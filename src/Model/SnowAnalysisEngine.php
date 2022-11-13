<?php

namespace App\Model;

use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class SnowAnalysisEngine
{    
    private $dataset;
    private $params;
    private $requiredInputFields;
    private $requiredInputData;

    private $outputDataTable;

    public function __construct()
    {
        $this->dataset = Utils::getCurrentDataset();            
        $this->params = $this->getRequiredParams();
        
        $this->outputDataTable = TableRegistry::getTableLocator()->get('SnowData');        
    }

    private function setRequiredInputFieldNames()
    {
        $requiredFields = [ // need these fields from input ALWAYS
            'time_index',
            'time_name',
            'time_date',
            'time_day',
            'time_month',
            'time_year',
            'elevation',            
            'ucd1',
            'ucd2',
            'ucd3'            
        ];                 

        return $requiredFields;
    }

    private function getRequiredInputData()
    {
        // get inputs
        $inputDataTable = TableRegistry::getTableLocator()->get('InputData');

        $query = $inputDataTable->find('all',[
            'fields' => $this->requiredInputFields
        ]);
        $query->where(['dataset' => $this->dataset]);        
        $query->order('time_index ASC');             
        $inputData = $query->all();

        return $inputData;
    }

    private function getRequiredParams()
    {        
        $params = Utils::getParams();

        return $params;
    }

    public function run()
    {
        $this->requiredInputFields = $this->setRequiredInputFieldNames();
        $this->requiredInputData = $this->getRequiredInputData();
        
        // delete previous output
        Utils::removeSnowDataset();    
        // Utils::removeSoilWaterDataset(); 
        
        // get calibration mappings
        // $calibration = Utils::getSnowCalibrationFields();

        // foreach inputData row
        $firstRow = true;
        $lastOutputDataRow = null;
        foreach ($this->requiredInputData as $inputDataRow){            
            $outputDataRow = [
                'dataset' => $this->dataset,
                'time_index' => $inputDataRow['time_index'],
                'time_name' => $inputDataRow['time_name'],
                'time_date' => $inputDataRow['time_date'],
                'time_day' => $inputDataRow['time_day'],
                'time_month' => $inputDataRow['time_month'],
                'time_year' => $inputDataRow['time_year']
            ];      
            
            $outputDataRow = array_merge($outputDataRow,
                $this->calculateSnow($inputDataRow, $lastOutputDataRow, $firstRow)
            );
            
            $firstRow = false;
            $lastOutputDataRow = $outputDataRow;

            // transform output data row for DB writing
            $outputDataRow = $this->formatOutputDataRow($outputDataRow);
            
            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outputDataTable);  
            
            // check for analysis stop every 50 data points
            if ($outputDataRow['time_index'] % 50 == 0) {  
                if (Utils::getStopAnalysisFlag()) {
                    // Log::debug('stopping snow analysis...');
                    return -1;
                }
            }

            // clone data for overlay each 188 points 
            if ($outputDataRow['time_index'] % 188 == 0) {              

                // also store data for Overlay scripts
                Utils::cloneTable('snow_data', 'snow_data_overlay');

                usleep(500 * 1000);
            }
        }    
        
        // clone data for overlay at script end
        Utils::cloneTable('snow_data', 'snow_data_overlay');
    }             

    private function writeOutputToDb($outputDataRow, $table)
    {        
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function updateOutputRow($keyValue, $table, $time_index)
    {
        $outputEntity = $table->find()
            ->where([
                'time_index' => $time_index,
                'dataset' => $this->dataset
            ])
            ->first();   

        $keys = array_keys($keyValue);
        foreach ($keys as $key){
            $outputEntity->$key = $keyValue[$key];
        }
        $table->save($outputEntity);
    }
      
    private function calculateSnow($inputData, $lastOutputDataRow, $isFirstRow)
    {        
        $outputArray = [];

        // get cols from input
        $outputArray['elevation'] = $inputData['elevation'];        
        $outputArray['ucd1'] = $inputData['ucd1'];
        $outputArray['ucd2'] = $inputData['ucd2'];
        $outputArray['ucd3'] = $inputData['ucd3'];        
                
        if ($isFirstRow) {
            $outputArray['elev_change'] = 0;
        } else {
            $outputArray['elev_change'] = ($outputArray['elevation'] - $lastOutputDataRow['elevation']) * 1000;  
        }        
        $outputArray['aquif_storage_change'] = $this->getLayerSpecificYield($inputData['elevation'])*$outputArray['elev_change'];    
        $outputArray['gw_recharge'] = $outputArray['aquif_storage_change'] > 0 ? $outputArray['aquif_storage_change'] : 0;
        $outputArray['gw_discharge'] = $outputArray['aquif_storage_change'] < 0 ? $outputArray['aquif_storage_change'] : 0;
        return $outputArray;
    }

    private function getLayerSpecificYield($elevation) {
        $factor = 0;

        $paramsCount = $this->params['layer_count'];
        for ($i = 0; $i < $paramsCount; $i++) {
            if (($elevation <= $this->params['layer_h_'.$i]) && ($elevation > $this->params['layer_l_'.$i])) {
                $factor = $this->params['layer_yield_'.$i];
            }
        }        

        return $factor;
    }

    private function formatOutputDataRow($outputDataRow)
    {        
        // rename desired keys
        $dbReadyDataRow = array(
            'dataset' => $outputDataRow['dataset'],
            'time_index' => $outputDataRow['time_index'],
            'time_name' => $outputDataRow['time_name'],
            'time_date' => $outputDataRow['time_date'],
            'time_day' => $outputDataRow['time_day'],
            'time_month' => $outputDataRow['time_month'],
            'time_year' => $outputDataRow['time_year']
        );

        $dbReadyDataRow['elevation'] = $outputDataRow['elevation'];
        $dbReadyDataRow['elev_change'] = $outputDataRow['elev_change'];
        $dbReadyDataRow['aquif_storage_change'] = $outputDataRow['aquif_storage_change'];
        $dbReadyDataRow['gw_recharge'] = $outputDataRow['gw_recharge'];
        $dbReadyDataRow['gw_discharge'] = $outputDataRow['gw_discharge'];

        $dbReadyDataRow['ucd1'] = $outputDataRow['ucd1'];
        $dbReadyDataRow['ucd2'] = $outputDataRow['ucd2'];
        $dbReadyDataRow['ucd3'] = $outputDataRow['ucd3'];        

        return $dbReadyDataRow;
    }
    
}