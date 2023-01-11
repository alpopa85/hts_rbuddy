<?php

namespace App\Model;

use App\Model\Entity\UcdAverages;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

class AveragingEngine
{
    const INPUT_AVERAGING = 1;
    const SOIL_WATER_AVERAGING = 2;
    const SNOW_AVERAGING = 3;           

    const AVERAGE_YEAR = 1;
    const AVERAGE_MONTH = 2;
    const AVERAGE_SPRING = 3;
    const AVERAGE_SUMMER = 4;
    const AVERAGE_FALL = 5;
    const AVERAGE_WINTER = 6;
    const AVERAGE_GROWTH_SEASON_IN = 7;
    const AVERAGE_GROWTH_SEASON_OUT_AFTER = 8;
    const AVERAGE_GROWTH_SEASON_OUT_BEFORE = 9;
    
    const AVERAGE_TYPICAL_DAILY = 10; // averages across all years for each day in year
    const AVERAGE_TYPICAL_WINTER = 11; // averages for the winter months of the typical year

    private $dataset, $type;
    private $params;

    private $ucd1AvgMethod, $ucd2AvgMethod, $ucd3AvgMethod, $ucd4AvgMethod, $ucd5AvgMethod;
        
    // regular tables
    private $sourceDataTable, $monthlyDataTable, $yearlyDataTable;
    private $springDataTable, $summerDataTable, $fallDataTable, $winterDataTable, $seasonsDataTable;
    private $inGsDataTable, $outGsDataTable, $growingDataTable;

    // typical year tables
    private $typicalDailyDataTable, $typicalMonthlyDataTable, $typicalYearlyDataTable;    
    private $typicalSpringDataTable, $typicalSummerDataTable, $typicalFallDataTable, $typicalWinterDataTable, $typicalSeasonsDataTable;
    private $typicalInGsDataTable, $typicalOutGsDataTable, $typicalGrowingDataTable;

    public function __construct($type)
    {
        $this->dataset = Utils::getCurrentDataset();
        $this->type = $type;      
        $this->params = Utils::getParams();
                
        switch ($this->type){
            case self::INPUT_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('InputData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('InputDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('InputDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('InputDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('InputDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('InputDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('InputDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('InputDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('InputDataGrowthSeasonOut');                
                $this->growingDataTable = TableRegistry::getTableLocator()->get('InputDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('InputDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('InputDataTypicalGrowingSeasons');
                break;            

            case self::SNOW_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('SnowData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('SnowDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('SnowDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('SnowDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('SnowDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowthSeasonOut');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SnowDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SnowDataTypicalGrowingSeasons');
                break;

            case self::SOIL_WATER_AVERAGING:
                // default averaging
                $this->sourceDataTable = TableRegistry::getTableLocator()->get('SoilWaterData');
                $this->monthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataMonthly');
                $this->yearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataYearly');

                $this->springDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSpring');
                $this->summerDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSummer');
                $this->fallDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataFall');
                $this->winterDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataWinter');
                $this->seasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataSeasons');

                $this->inGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonIn');
                $this->outGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowthSeasonOut');
                $this->growingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataGrowingSeasons');

                // typical year averaging
                $this->typicalDailyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypical');
                $this->typicalMonthlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalMonthly');
                $this->typicalYearlyDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalYearly');

                $this->typicalSpringDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSpring');
                $this->typicalSummerDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSummer');
                $this->typicalFallDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalFall');
                $this->typicalWinterDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalWinter');
                $this->typicalSeasonsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalSeasons');

                $this->typicalInGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowthSeasonIn');
                $this->typicalOutGsDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowthSeasonOut');                
                $this->typicalGrowingDataTable = TableRegistry::getTableLocator()->get('SoilWaterDataTypicalGrowingSeasons');
        }        
    }    

    private function adjustWorkingTablesForTypicalYear()
    {
        $this->sourceDataTable = $this->typicalDailyDataTable;

        $this->monthlyDataTable = $this->typicalMonthlyDataTable;
        $this->yearlyDataTable = $this->typicalYearlyDataTable;

        $this->springDataTable = $this->typicalSpringDataTable;
        $this->summerDataTable = $this->typicalSummerDataTable;
        $this->fallDataTable = $this->typicalFallDataTable;
        $this->winterDataTable = $this->typicalWinterDataTable;
        $this->seasonsDataTable = $this->typicalSeasonsDataTable;

        $this->inGsDataTable = $this->typicalInGsDataTable;
        $this->outGsDataTable = $this->typicalOutGsDataTable;
        $this->growingDataTable = $this->typicalGrowingDataTable;
    }

    //
    public function run()
    {
        // get averaging methods for UCD
        $this->ucd1AvgMethod = Utils::getUcdAvgMethod('ucd1');
        $this->ucd2AvgMethod = Utils::getUcdAvgMethod('ucd2');
        $this->ucd3AvgMethod = Utils::getUcdAvgMethod('ucd3');
        $this->ucd4AvgMethod = Utils::getUcdAvgMethod('ucd4');
        $this->ucd5AvgMethod = Utils::getUcdAvgMethod('ucd5');

        // default averaging
        $this->runMonthly();
        $this->runSpecialElevationChange(self::AVERAGE_MONTH);
        $this->runYearly();
        $this->runSpecialElevationChange(self::AVERAGE_YEAR);
        $this->runSpring();
        $this->runSpecialElevationChange(self::AVERAGE_SPRING);
        $this->runSummer();
        $this->runSpecialElevationChange(self::AVERAGE_SUMMER);
        $this->runFall();
        $this->runSpecialElevationChange(self::AVERAGE_FALL);
        $this->runWinter();
        $this->runSpecialElevationChange(self::AVERAGE_WINTER);
        $this->aggregateSeasons();        
        // if (Utils::isSetGrowthSeason()){
        //     $this->runGrowthSeasonIn();
        //     $this->runGrowthSeasonOut();
        //     $this->aggregateGrowingSeasons();
        // }

        // typical day averaging
        $this->runTypicalDaily();

        // interval averaging based on typical day
        $this->adjustWorkingTablesForTypicalYear();
        $this->runTypicalMonthly();
        $this->runSpecialElevationChange(self::AVERAGE_MONTH);                
        $this->runTypicalYearly();
        $this->runSpecialElevationChange(self::AVERAGE_YEAR);
        $this->runTypicalSpring();
        $this->runSpecialElevationChange(self::AVERAGE_SPRING);
        $this->runTypicalSummer();
        $this->runSpecialElevationChange(self::AVERAGE_SUMMER);
        $this->runTypicalFall();
        $this->runSpecialElevationChange(self::AVERAGE_FALL);
        $this->runTypicalWinter();
        $this->runSpecialElevationChange(self::AVERAGE_WINTER);
        $this->aggregateSeasons();
        // if (Utils::isSetGrowthSeason()){
        //     $this->runTypicalGrowthSeasonIn();
        //     $this->runTypicalGrowthSeasonOut();
        //     $this->aggregateGrowingSeasons();
        // }    
    }    

    public function runMonthly()
    {
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_MONTH);        
        // Log::write('debug', "MONTHLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){
            $monthAbbrev = Utils::convertMonthToString($item['time_month']);                

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];                    
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                          
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;                    
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev . '/' . $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                   
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;                                       
            }                    

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->monthlyDataTable);        
        }
    }

    public function runSpecialElevationChange($type)
    {
        $select = null;
        $query = null;
        $conditions = null;

        // Log::debug('getCurrentDataset: ' . Utils::getCurrentDataset());
        // Log::debug('dataset: ' . $this->dataset);
        $query = $this->sourceDataTable->find();        
        $queryWhereDataset = [
            'dataset' => $this->dataset
        ];

        switch ($type){
            case self::AVERAGE_MONTH:
                $select = ['time_month', 'time_year'];
                $group = ['time_year', 'time_month'];
                $queryWhere = $queryWhereDataset;
                break;
            case self::AVERAGE_YEAR:
                $select = ['time_year'];
                $group = ['time_year'];
                $queryWhere = $queryWhereDataset;
                break;
            case self::AVERAGE_SPRING:
                $select = ['time_year'];
                $group = ['time_year'];
                $queryWhere = array_merge($queryWhereDataset,[
                    'time_month >=' => 3,
                    'time_month <' => 6
                ]);
                break;
            case self::AVERAGE_SUMMER:
                $select = ['time_year'];
                $group = ['time_year'];
                $queryWhere = array_merge($queryWhereDataset,[
                    'time_month >=' => 6,
                    'time_month <' => 9
                ]);
                break;
            case self::AVERAGE_FALL:
                $select = ['time_year'];
                $group = ['time_year'];
                $queryWhere = array_merge($queryWhereDataset,[
                    'time_month >=' => 9,
                    'time_month <' => 12    
                ]);
                break;
            case self::AVERAGE_WINTER:
                $select = ['time_year'];
                $group = ['time_year'];
                $queryWhere = array_merge($queryWhereDataset,[
                    'time_month >=' => 1,
                    'time_month <' => 3    
                ]);
                break;
        }
                
        $query->select($select);       
        if (!empty($group)){
            $query->group($group);
        }                    
        if (!empty($queryWhere)){
            $query->where($queryWhere);
        }               
        $data = $query->toArray();    

        foreach($data as $row) {
            $newQuery = $this->sourceDataTable->find();
            $newQuery->select('elevation');        

            switch($type){
                case self::AVERAGE_MONTH:
                    $elevQueryConditions = [
                        'time_month' => $row['time_month'],
                        'time_year' => $row['time_year']
                    ];  
                    break;              
                case self::AVERAGE_YEAR:
                    $elevQueryConditions = [
                        'time_year' => $row['time_year']
                    ];         
                    break;
                case self::AVERAGE_SPRING:
                    $elevQueryConditions = [
                        'time_year' => $row['time_year'],
                        'time_month >=' => 3,
                        'time_month <' => 6
                    ];                             
                    break;
                case self::AVERAGE_SUMMER:
                    $elevQueryConditions = [
                        'time_year' => $row['time_year'],
                        'time_month >=' => 6,
                        'time_month <' => 9
                    ];                             
                    break;
                case self::AVERAGE_FALL:
                    $elevQueryConditions = [
                        'time_year' => $row['time_year'],
                        'time_month >=' => 9,
                        'time_month <' => 12    
                    ];                             
                    break;
                case self::AVERAGE_WINTER:
                    $elevQueryConditions = [
                        'time_year' => $row['time_year'],
                        'time_month >=' => 1,
                        'time_month <' => 3    
                    ];                             
                    break;
            }                   
            
            $newQuery->where(array_merge($queryWhereDataset, $elevQueryConditions));
            $newQuery->orderAsc('time_day');  
            $elevationData = $newQuery->toArray();    

            Log::debug('interval: ' . $row);
            $firstValue = $elevationData[0]['elevation'];
            // workaround for winter (take month 12 of previous year)
            if ($type == self::AVERAGE_WINTER) {
                $firstValueLastDecember = $this->getFirstElevationLastDecember($row['time_year']);
                if ($firstValueLastDecember) {
                    // Log::debug('firstValueLastDecember: ' . $firstValueLastDecember);
                    $firstValue = $firstValueLastDecember;                    
                }
            }
            // Log::debug('firstValue: ' . $firstValue);
            $lastValue = $elevationData[count($elevationData)-1]['elevation'];
            // Log::debug('lastValue: ' . $lastValue);
            // Log::debug('elevationChange: ' . ($lastValue - $firstValue) * 1000);            

            // update output
            $targetKey = [
                'elev_change' => ($lastValue - $firstValue) * 1000
            ];       
            
            switch($type){
                case self::AVERAGE_MONTH:
                    $targetDataTable = $this->monthlyDataTable;
                    $updateConditions = [
                        'time_month' => $row['time_month'],
                        'time_year' => $row['time_year']
                    ];  
                    break;              
                case self::AVERAGE_YEAR:
                    $targetDataTable = $this->yearlyDataTable;      
                    $updateConditions = [
                        'time_year' => $row['time_year']
                    ];  
                    break;
                case self::AVERAGE_SPRING:
                    $targetDataTable = $this->springDataTable;      
                    $updateConditions = [
                        'time_year' => $row['time_year']
                    ];  
                    break;
                case self::AVERAGE_SUMMER:
                    $targetDataTable = $this->summerDataTable;      
                    $updateConditions = [
                        'time_year' => $row['time_year']
                    ];  
                    break;
                case self::AVERAGE_FALL:
                    $targetDataTable = $this->fallDataTable;      
                    $updateConditions = [
                        'time_year' => $row['time_year']
                    ];  
                    break;
                case self::AVERAGE_WINTER:
                    $targetDataTable = $this->winterDataTable;      
                    $updateConditions = [
                        'time_year' => $row['time_year']
                    ];  
                    break;
            }
            $this->updateOutputRow($targetKey, $updateConditions, $targetDataTable);
        }                                
    }

    private function getFirstElevationLastDecember($currentYear)
    {
        $query = $this->sourceDataTable->find();

        $querySelect = ['elevation'];
        $query->select($querySelect);                           
        $query->where([
            'dataset =' => $this->dataset,
            'time_month =' => 12,
            'time_year =' => $currentYear-1    
        ]);   
        $query->orderAsc('time_day');          
        $data = $query->first(); 

        return $data ? $data['elevation'] : null;
    }

    public function runYearly()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_YEAR);
        // Log::write('debug', "YEARLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];                    
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                        
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $item['time_year'];            
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];              
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->yearlyDataTable);
        }        
    }   
    
    public function runSpring()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SPRING);
        // Log::write('debug', "SPRING:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                            
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                   
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];             
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->springDataTable);
        }        
    }

    public function runSummer()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SUMMER);
        // Log::write('debug', "SUMMER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = $item['elevation'];                   
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                           
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->summerDataTable);
        }        
    }

    public function runFall()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_FALL);
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                         
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->fallDataTable);
        }        
    }

    public function runWinter()
    {                
        // if ($this->type != self::SOIL_WATER_AVERAGING){

        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_WINTER);
        // Log::write('debug', "WINTER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];
                    // Log::write('debug', $item['time_year'] . " DECEMBER: " . json_encode($decemberAverages)); 

                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = ($item['elevation'] + $decemberAverages['elevation']) / 2;                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
                    break;                                        

                case self::SNOW_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];
                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                                        
                    $outputDataRow['elevation'] = ($item['elevation'] + $decemberAverages['elevation']) / 2;    
                    $outputDataRow['elev_change'] = ($item['elev_change'] + $decemberAverages['elev_change']) / 2;                                          
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'] + $decemberAverages['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'] + $decemberAverages['gw_recharge'];                        
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'] + $decemberAverages['gw_discharge'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
                    break;   
                    
                case self::SOIL_WATER_AVERAGING:
                    $decemberAverages = $this->getAveragedDataLastDecember($item['time_year'])[0];

                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter/' . $item['time_year'];           
                    $outputDataRow['time_year'] = $item['time_year'];                    
                    $outputDataRow['elevation'] = ($item['elevation'] + $decemberAverages['elevation']) / 2;
                    $outputDataRow['elev_change'] = $item['elev_change'] + $decemberAverages['elev_change'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($item['ucd1'], $decemberAverages['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($item['ucd2'], $decemberAverages['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($item['ucd3'], $decemberAverages['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($item['ucd4'], $decemberAverages['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($item['ucd5'], $decemberAverages['ucd5'], $this->ucd5AvgMethod);
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->winterDataTable);
        }       
    }    

    public function aggregateSeasons()
    {
        $yearList = $this->getYearList();
        
        $timeIndex = 0;
        foreach($yearList as $yearItem){            
            $seasonsData = $this->getSeasonsData($yearItem[0]);
            // Log::debug('seasons '. json_encode($seasonsData));

            // add to _seasons table       
            $counter = 0;     
            foreach($seasonsData as $item){
                $counter++;
                if (!empty($item[0])){
                    // Log::debug('year ' . $yearItem[0] . ' season ' . json_encode($item[0]));
                    $outputDataRow = $item[0]->toArray();                 
                    unset($outputDataRow['id']);
                    $outputDataRow['time_index'] = ++$timeIndex;

                    // Log::debug('outputDataRow ' . json_encode($outputDataRow));
                    $this->writeOutputToDb($outputDataRow, $this->seasonsDataTable);
                } else {
                    Log::debug('skipping_aggregate_seasons for counter = ' . $counter . ' in seasonsData ' . json_encode($seasonsData));
                }
            }                        
        }
    }

    public function runGrowthSeasonIn()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRows = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_IN, $yearItem[0])[0];
            // Log::write('debug', "runGrowthSeasonIn:" . json_encode($calculatedDataRows)); 

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];           
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];
                    $outputDataRow['elev_change'] = $calculatedDataRows['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $calculatedDataRows['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $calculatedDataRows['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $calculatedDataRows['gw_discharge'];                              
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing/' . $calculatedDataRows['time_year'];           
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];
                    $outputDataRow['elev_change'] = $calculatedDataRows['elev_change'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];      
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->inGsDataTable);
        }        
    }

    public function runGrowthSeasonOut()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRowsBefore = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_BEFORE, $yearItem[0])[0];
            // Log::write('debug', "GS_OUT_BEFORE:" . json_encode($calculatedDataRowsBefore));    
            $calculatedDataRowsAfter = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_AFTER, $yearItem[0])[0];             
            // Log::write('debug', "GS_OUT_AFTER:" . json_encode($calculatedDataRowsAfter));

            if (!empty($calculatedDataRowsBefore['time_year'])){
                $timeYear = $calculatedDataRowsBefore['time_year'];
            } else {
                $timeYear = $calculatedDataRowsAfter['time_year'];
            }

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;
                    $outputDataRow['time_year'] = $timeYear;
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;           
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;
                    $outputDataRow['elev_change'] = ($calculatedDataRowsBefore['elev_change'] + $calculatedDataRowsAfter['elev_change']) / 2;
                    $outputDataRow['aquif_storage_change'] = $calculatedDataRowsBefore['aquif_storage_change'] + $calculatedDataRowsAfter['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $calculatedDataRowsBefore['gw_recharge'] + $calculatedDataRowsAfter['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $calculatedDataRowsBefore['gw_discharge'] + $calculatedDataRowsAfter['gw_discharge'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing/' . $timeYear;           
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;
                    $outputDataRow['elev_change'] = $calculatedDataRowsBefore['elev_change'] + $calculatedDataRowsAfter['elev_change'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;
            }        

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outGsDataTable);
        }        
    }

    public function aggregateGrowingSeasons()
    {        
        $yearList = $this->getYearList();
        
        $timeIndex = 0;
        foreach($yearList as $yearItem){            
            $seasonsData = $this->getGrowingSeasonsData($yearItem[0]);
            // Log::debug('seasons '. json_encode($seasonsData));

            // add to _growing table
            $counter = 0;
            foreach($seasonsData as $item){
                $counter++;
                if (!empty($item[0])){
                    $outputDataRow = $item[0]->toArray(); 
                    unset($outputDataRow['id']);
                    $outputDataRow['time_index'] = ++$timeIndex;

                    // Log::debug('outputDataRow ' . json_encode($outputDataRow));
                    $this->writeOutputToDb($outputDataRow, $this->growingDataTable);
                } else {
                    Log::debug('skipping_aggregate_growing_seasons for counter = ' . $counter . ' in seasonsData ' . json_encode($seasonsData));
                }
                // Log::debug('year ' . $yearItem[0] . ' growing season ' . json_encode($item[0]));                
            }                        
        }
    }

    public function runTypicalDaily()
    {                
        $calculatedDataRows = $this->getTypicalDayAveragedData();
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day']; 
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day']; 
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                     
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];                 
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = Utils::singleToDoubleDigitDatePart($item['time_day']) . '-' . Utils::convertMonthToString($item['time_month']);
                    $outputDataRow['time_year'] = 2000; 
                    $outputDataRow['time_month'] = $item['time_month'];                    
                    $outputDataRow['time_day'] = $item['time_day'];                                        
                    $outputDataRow['time_date'] = 2000 . '-' . $item['time_month'] . '-' . $item['time_day'];    
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;                       
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->typicalDailyDataTable);
        }        
    }

    public function runTypicalMonthly()
    {
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_MONTH);
        // Log::write('debug', "MONTHLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            $monthAbbrev = Utils::convertMonthToString($item['time_month']);    

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = $monthAbbrev;
                    $outputDataRow['time_month'] = $item['time_month'];
                    $outputDataRow['time_year'] = $item['time_year'];          
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break; 
            }                    

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->monthlyDataTable);        
        }
    }

    public function runTypicalYearly()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_YEAR);
        // Log::write('debug', "YEARLY:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                         
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Typical Year';
                    $outputDataRow['time_year'] = $item['time_year'];                   
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break; 
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->yearlyDataTable);
        }        
    }   

    public function runTypicalSpring()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SPRING);
        // Log::write('debug', "SPRING:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];                   
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                       
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Spring';
                    $outputDataRow['time_year'] = $item['time_year'];         
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->springDataTable);
        }        
    }

    public function runTypicalSummer()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_SUMMER);
        // Log::write('debug', "SUMMER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                      
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];               
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                          
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Summer';
                    $outputDataRow['time_year'] = $item['time_year'];     
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->summerDataTable);
        }        
    }

    public function runTypicalFall()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_FALL);
        // Log::write('debug', "FALL:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                         
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];         
                    $outputDataRow['elevation'] = $item['elevation'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];      
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Fall';
                    $outputDataRow['time_year'] = $item['time_year'];   
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->fallDataTable);
        }        
    }

    public function runTypicalWinter()
    {                
        $calculatedDataRows = $this->getAveragedData(self::AVERAGE_TYPICAL_WINTER);
        // Log::write('debug', "WINTER:" . json_encode($calculatedDataRows)); 
        
        $index = 0;
        foreach ($calculatedDataRows as $item){    
            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                                
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];               
                    $outputDataRow['elevation'] = $item['elevation'];                   
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $item['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $item['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $item['gw_discharge'];                                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'Winter';
                    $outputDataRow['time_year'] = $item['time_year'];           
                    $outputDataRow['elevation'] = $item['elevation'];
                    $outputDataRow['elev_change'] = $item['elev_change'];                    
                    $outputDataRow['ucd1'] = $item['ucd1'];
                    $outputDataRow['ucd2'] = $item['ucd2'];
                    $outputDataRow['ucd3'] = $item['ucd3'];
                    $outputDataRow['ucd4'] = $item['ucd4'];
                    $outputDataRow['ucd5'] = $item['ucd5'];   
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->winterDataTable);
        }        
    }

    public function runTypicalGrowthSeasonIn()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRows = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_IN, $yearItem[0])[0];
            // Log::write('debug', "runGrowthSeasonIn:" . json_encode($calculatedDataRows)); 

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                    
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];
                    $outputDataRow['elev_change'] = $calculatedDataRows['elev_change'];
                    $outputDataRow['aquif_storage_change'] = $calculatedDataRows['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $calculatedDataRows['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $calculatedDataRows['gw_discharge'];                             
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'inGrowing';
                    $outputDataRow['time_year'] = $calculatedDataRows['time_year'];  
                    $outputDataRow['elevation'] = $calculatedDataRows['elevation'];
                    $outputDataRow['elev_change'] = $calculatedDataRows['elev_change'];                    
                    $outputDataRow['ucd1'] = $calculatedDataRows['ucd1'];
                    $outputDataRow['ucd2'] = $calculatedDataRows['ucd2'];
                    $outputDataRow['ucd3'] = $calculatedDataRows['ucd3'];
                    $outputDataRow['ucd4'] = $calculatedDataRows['ucd4'];
                    $outputDataRow['ucd5'] = $calculatedDataRows['ucd5'];
                    break;
            }

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->inGsDataTable);
        }        
    }

    public function runTypicalGrowthSeasonOut()
    {                
        $yearList = $this->getYearList();
        // Log::write('debug', "YEAR LIST:" . json_encode($yearList)); 

        $index = 0;
        foreach($yearList as $yearItem){
            // Log::write('debug', "calculating for YEAR:" . json_encode($yearItem[0])); 
            $calculatedDataRowsBefore = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_BEFORE, $yearItem[0])[0];
            // Log::write('debug', "GS_OUT_BEFORE:" . json_encode($calculatedDataRowsBefore));    
            $calculatedDataRowsAfter = $this->getAveragedData(self::AVERAGE_GROWTH_SEASON_OUT_AFTER, $yearItem[0])[0];             
            // Log::write('debug', "GS_OUT_AFTER:" . json_encode($calculatedDataRowsAfter));

            if (!empty($calculatedDataRowsBefore['time_year'])){
                $timeYear = $calculatedDataRowsBefore['time_year'];
            } else {
                $timeYear = $calculatedDataRowsAfter['time_year'];
            }

            switch($this->type){
                case self::INPUT_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;                    
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);                    
                    break;                                        

                case self::SNOW_AVERAGING:                    
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;                    
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;
                    $outputDataRow['elev_change'] = ($calculatedDataRowsBefore['elev_change'] + $calculatedDataRowsAfter['elev_change']) / 2;
                    $outputDataRow['aquif_storage_change'] = $calculatedDataRowsBefore['aquif_storage_change'] + $calculatedDataRowsAfter['aquif_storage_change'];
                    $outputDataRow['gw_recharge'] = $calculatedDataRowsBefore['gw_recharge'] + $calculatedDataRowsAfter['gw_recharge'];
                    $outputDataRow['gw_discharge'] = $calculatedDataRowsBefore['gw_discharge'] + $calculatedDataRowsAfter['gw_discharge'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;

                case self::SOIL_WATER_AVERAGING:
                    $outputDataRow['dataset'] = $this->dataset;
                    $outputDataRow['time_index'] = ++$index;
                    $outputDataRow['time_name'] = 'outGrowing';
                    $outputDataRow['time_year'] = $timeYear;                                                        
                    $outputDataRow['elevation'] = ($calculatedDataRowsBefore['elevation'] + $calculatedDataRowsAfter['elevation']) / 2;
                    $outputDataRow['elev_change'] = $calculatedDataRowsBefore['elev_change'] + $calculatedDataRowsAfter['elev_change'];                    
                    $outputDataRow['ucd1'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd1'], $calculatedDataRowsAfter['ucd1'], $this->ucd1AvgMethod);
                    $outputDataRow['ucd2'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd2'], $calculatedDataRowsAfter['ucd2'], $this->ucd2AvgMethod);
                    $outputDataRow['ucd3'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd3'], $calculatedDataRowsAfter['ucd3'], $this->ucd3AvgMethod);
                    $outputDataRow['ucd4'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd4'], $calculatedDataRowsAfter['ucd4'], $this->ucd4AvgMethod);
                    $outputDataRow['ucd5'] = self::getAverageOfTwo($calculatedDataRowsBefore['ucd5'], $calculatedDataRowsAfter['ucd5'], $this->ucd5AvgMethod);
                    break;
            }        

            // write to output               
            $this->writeOutputToDb($outputDataRow, $this->outGsDataTable);
        }        
    }

    private function getYearList()
    {                
        // Log::write('debug', 'sourceDataTable: ' . json_encode($this->sourceDataTable->getTable()));

        $connection = ConnectionManager::get('default');
        $yearList = $connection
            ->newQuery()
            ->select('year(time_date) as theYear')
            ->from($this->sourceDataTable->getTable())
            ->where([
                'dataset =' => $this->dataset
            ])
            ->group('theYear')
            ->execute()
            ->fetchAll();

        return $yearList;
    }

    private function getSeasonsData($theYear)
    {
        $data = [];

        $query = $this->springDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['spring'] = $query->toArray();               

        $query = $this->summerDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['summer'] = $query->toArray();               

        $query = $this->fallDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['fall'] = $query->toArray();               

        $query = $this->winterDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['winter'] = $query->toArray();               

        return $data;
    }

    private function getGrowingSeasonsData($theYear)
    {
        $data = [];

        $query = $this->inGsDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['gs_in'] = $query->toArray();               

        $query = $this->outGsDataTable->find();
        $query->where([
            'dataset =' => $this->dataset,                    
            'time_year =' => $theYear
        ]);           
        $data['gs_out'] = $query->toArray();                       

        return $data;
    }

    private function getAveragedData($sortBy, $theYear = null)
    {
        $query = $this->sourceDataTable->find();

        // define ucd averaging
        $ucd1Avg = ($this->ucd1AvgMethod == 1) ? $query->func()->avg('ucd1') : $query->func()->sum('ucd1');
        $ucd2Avg = ($this->ucd2AvgMethod == 1) ? $query->func()->avg('ucd2') : $query->func()->sum('ucd2');
        $ucd3Avg = ($this->ucd3AvgMethod == 1) ? $query->func()->avg('ucd3') : $query->func()->sum('ucd3');
        $ucd4Avg = ($this->ucd4AvgMethod == 1) ? $query->func()->avg('ucd4') : $query->func()->sum('ucd4');
        $ucd5Avg = ($this->ucd5AvgMethod == 1) ? $query->func()->avg('ucd5') : $query->func()->sum('ucd5');        

        switch($this->type){
            case self::INPUT_AVERAGING:
                $select = [                                     
                    'elevation' => $query->func()->avg('elevation'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $select = [      
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->avg('elev_change'),
                    'aquif_storage_change' => $query->func()->sum('aquif_storage_change'),                    
                    'gw_recharge' => $query->func()->sum('gw_recharge'),
                    'gw_discharge' => $query->func()->sum('gw_discharge'),                                       
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg  
                ];
                break;             

            case self::SOIL_WATER_AVERAGING:    
                $select = [  
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->sum('elev_change'),                    
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg                                                    
                ];
                break;
        }        

        switch($sortBy){
            case self::AVERAGE_YEAR:
            default:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset
                ];
                break;
            case self::AVERAGE_MONTH:
                $querySelect = array_merge($select, ['time_year', 'time_month']);
                $queryGroup = 'time_year, time_month';
                $queryWhere = [
                    'dataset =' => $this->dataset
                ];
                break;
            case self::AVERAGE_SPRING:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 3,
                    'time_month <' => 6
                ];
                break;
            case self::AVERAGE_SUMMER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 6,
                    'time_month <' => 9
                ];
                break;
            case self::AVERAGE_FALL:
                    $querySelect = array_merge($select, ['time_year']);
                    $queryGroup = 'time_year';
                    $queryWhere = [
                        'dataset =' => $this->dataset,
                        'time_month >=' => 9,
                        'time_month <' => 12    
                    ];
                    break;
            case self::AVERAGE_WINTER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_month >=' => 1,
                    'time_month <' => 3    
                ];
                break;
            case self::AVERAGE_TYPICAL_WINTER:
                $querySelect = array_merge($select, ['time_year']);
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_month IN' => [1,2,12]    
                ];                
                break;
            case self::AVERAGE_GROWTH_SEASON_IN:
                $querySelect = array_merge($select, ['time_year']);                      
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,
                    'time_date >=' => $theYear . '-' . $this->params['gs_start_month'] . '-' . $this->params['gs_start_day'],
                    'time_date <=' => $theYear . '-' . $this->params['gs_end_month'] . '-' . $this->params['gs_end_day']                   
                ];
                break;
            case self::AVERAGE_GROWTH_SEASON_OUT_BEFORE:
                $querySelect = array_merge($select, ['time_year']);   
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_date >' => ($theYear-1) . '-12-31',
                    'time_date <' => $theYear . '-' . $this->params['gs_start_month'] . '-' . $this->params['gs_start_day']                    
                ];
                break;
            case self::AVERAGE_GROWTH_SEASON_OUT_AFTER:
                $querySelect = array_merge($select, ['time_year']);   
                $queryGroup = 'time_year';
                $queryWhere = [
                    'dataset =' => $this->dataset,                    
                    'time_date >' => $theYear . '-' . $this->params['gs_end_month'] . '-' . $this->params['gs_end_day'],
                    'time_date <' => ($theYear+1) . '-01-01'
                ];
                break;                      
        }
        
        $query->select($querySelect);       
        if (!empty($queryGroup)){
            $query->group($queryGroup);
        }                    
        if (!empty($queryWhere)){
            $query->where($queryWhere);
        }               
        $data = $query->toArray();               

        return $data;
    }    

    private function getAveragedDataLastDecember($currentYear)
    {
        $query = $this->sourceDataTable->find();

        // define ucd averaging
        $ucd1Avg = ($this->ucd1AvgMethod == 1) ? $query->func()->avg('ucd1') : $query->func()->sum('ucd1');
        $ucd2Avg = ($this->ucd2AvgMethod == 1) ? $query->func()->avg('ucd2') : $query->func()->sum('ucd2');
        $ucd3Avg = ($this->ucd3AvgMethod == 1) ? $query->func()->avg('ucd3') : $query->func()->sum('ucd3');
        $ucd4Avg = ($this->ucd4AvgMethod == 1) ? $query->func()->avg('ucd4') : $query->func()->sum('ucd4');
        $ucd5Avg = ($this->ucd5AvgMethod == 1) ? $query->func()->avg('ucd5') : $query->func()->sum('ucd5');

        switch($this->type){
            case self::INPUT_AVERAGING:
                $querySelect = [                                     
                    'elevation' => $query->func()->avg('elevation'),
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $querySelect = [      
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->avg('elev_change'),
                    'aquif_storage_change' => $query->func()->sum('aquif_storage_change'),                    
                    'gw_recharge' => $query->func()->sum('gw_recharge'),
                    'gw_discharge' => $query->func()->sum('gw_discharge'),                                       
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg  
                ];
                break;             

            case self::SOIL_WATER_AVERAGING:    
                $querySelect = [  
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->sum('elev_change'),                    
                    'ucd1' => $ucd1Avg,
                    'ucd2' => $ucd2Avg,
                    'ucd3' => $ucd3Avg,
                    'ucd4' => $ucd4Avg,
                    'ucd5' => $ucd5Avg                                                    
                ];
                break;
        }        
        
        $query->select($querySelect);                           
        $query->where([
            'dataset =' => $this->dataset,
            'time_month =' => 12,
            'time_year =' => $currentYear-1    
        ]);     
        
        $data = $query->toArray();               

        return $data;
    }    

    private function getTypicalDayAveragedData()
    {
        $query = $this->sourceDataTable->find();

        switch($this->type){
            case self::INPUT_AVERAGING:
                $select = [                                 
                    'elevation' => $query->func()->avg('elevation'),                   
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')                   
                ];
                break;                                

            case self::SNOW_AVERAGING:    
                $select = [     
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->avg('elev_change'),
                    'aquif_storage_change' => $query->func()->avg('aquif_storage_change'),
                    'gw_recharge' => $query->func()->avg('gw_recharge'),
                    'gw_discharge' => $query->func()->avg('gw_discharge'),
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')                 
                ];
                break;

            case self::SOIL_WATER_AVERAGING:    
                $select = [                                     
                    'elevation' => $query->func()->avg('elevation'),
                    'elev_change' => $query->func()->avg('elev_change'),                    
                    'ucd1' => $query->func()->avg('ucd1'),
                    'ucd2' => $query->func()->avg('ucd2'),
                    'ucd3' => $query->func()->avg('ucd3'),
                    'ucd4' => $query->func()->avg('ucd4'),
                    'ucd5' => $query->func()->avg('ucd5')                           
                ];
                break;
        }                
        
        $querySelect = array_merge($select, ['time_month', 'time_day']);
        $queryGroup = ['time_month', 'time_day'];
        $queryWhere = [
            'dataset =' => $this->dataset
        ]; 
        
        $query->select($querySelect);       
        if (!empty($queryGroup)){
            $query->group($queryGroup);
        }                    
        if (!empty($queryWhere)){
            $query->where($queryWhere);
        }        
        $data = $query->toArray();               

        return $data;
    }

    private function writeOutputToDb($outputDataRow, $table)
    {        
        $outputEntity = $table->newEntity($outputDataRow);        
        $table->save($outputEntity);
    }

    private function updateOutputRow($keyValue, $conditions, $table)
    {
        Log::debug('keyValue ' . json_encode($keyValue));
        Log::debug('conditions ' . json_encode($conditions));
        // Log::debug('table ' . json_encode($table));

        $outputEntity = $table->find()
            ->where(array_merge(['dataset' => $this->dataset], $conditions))
            ->first();   

        // Log::debug('Updating ' . json_encode($outputEntity));
        $keys = array_keys($keyValue);
        foreach ($keys as $key){            
            $outputEntity->$key = $keyValue[$key];
        }
        // Log::debug('Updated ' . json_encode($outputEntity));
        $table->save($outputEntity);
    }

    private function getAverageOfTwo($one, $two, $method)
    {            
        switch ($method) {
            case 1:
                $output = ($one + $two) / 2;
                break;
            case 2:
            default:
                $output = $one + $two;
        }

        return $output;        
    }
    
}