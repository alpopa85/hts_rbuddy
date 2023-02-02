<div class="container">  

    <div class="swib-title my-4">
        <div class="text-center">
            <h1>RECHARGE BUDDY</h1>    
            <h2>Groundwater Recharge Estimation Tool</h2>                    
            <h3>Online Tool</h3>
        </div>        
    </div>

    <div class="intro-content swib-maintext">
    
        <table class="table table-sm table-hover table-borderless text-center pb-5" id="contents">
            <thead class="thead-dark">
                <tr>
                    <th scope="row" colspan="3">Table of Contents</th>                        
                </tr>                    
            </thead>
            <tbody>  
                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_1">&rarr;  1.</a></td>
                    <td class="text-left" colspan="2"><a href="#chapter_1">About RECHARGE BUDDY</a></td>                        
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_2">&rarr; 2.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_2">Background</a></td>                        
                </tr>                                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_4">&rarr; 3.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_3">User Guide</a></td>    
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.1">&rarr; 3.1.</td>      
                    <td class="text-left"><a href="#chapter_3.1">Quick start</a></td>   
                </tr>  
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.2">&rarr; 3.2.</td>      
                    <td class="text-left"><a href="#chapter_3.2">Home Module</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.3">&rarr; 3.3.</td>      
                    <td class="text-left"><a href="#chapter_3.3">Input Data Module</a></td>   
                </tr>    
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.4">&rarr; 3.4.</td>      
                    <td class="text-left"><a href="#chapter_3.4">Analysis Module</a></td>   
                </tr>   
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.5">&rarr; 3.5.</td>      
                    <td class="text-left"><a href="#chapter_3.5">Output Timeseries</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.6">&rarr; 3.6.</td>      
                    <td class="text-left"><a href="#chapter_3.6">Calibration Procedure</a></td>   
                </tr> 
                <tr class="table-info no-wrap-table-row">  
                    <td width="30%" colspan="2" class="text-right"><a href="#chapter_3.7">&rarr; 3.7.</td>      
                    <td class="text-left"><a href="#chapter_3.7">Data inspection, visualisation and export</a></td>   
                </tr>                 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_4">&rarr; 4.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_4">Limitations</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_5">&rarr; 5.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_5">Terms of Use</a></td>    
                </tr> 

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_6">&rarr; 6.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_6">References</a></td>    
                </tr>

                <tr class="table-info no-wrap-table-row">                        
                    <td width="10%"><a href="#chapter_7">&rarr; 7.</a></td>
                    <td class="text-left"  colspan="2"><a href="#chapter_7">Contact</a></td>    
                </tr> 
            </tbody>
        </table>        

        <ul class="main-ul">
            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_1">1. About RECHARGE BUDDY</h3> 

                <h5>Groundwater Recharge Estimation Tool (RECHARGE BUDDY) is an online tool that allows for estimation of daily groundwater recharge using an adaptation of the Water Table Fluctuation (WTF) method for multi-layered systems. The tool requires user provided aquifer (or material) specific yield and daily water table elevations. The tool is free to use and does not require user registration.</h5>

                <h5>RECHARGE BUDDY has been developed through a collaborative research effort between Canadian Rivers Institute (CRI), University of New Brunswick (UNB), Agriculture and Agri-Food Canada (AAFC) and Environment and Climate Change Canada (ECCC). RECHARGE BUDDY is the result of a larger research effort aimed at evaluating the effects of agricultural production systems on groundwater and surface water quantity and quality. RECHARGE BUDDY is part of Hydrology Tool Set (HTS; <a href="https://portal.hydrotools.tech">https://portal.hydrotools.tech</a>). HTS includes additional applications, such as SepHydro (daily baseflow / hydrograph separation; 11 methods), ETCalc (daily potential, reference and actual evapotranspiration estimation; 8 methods), SWIB (daily estimation of soil water stress, crop water deficit, irrigation requirement and its impact on aquifer storage, water balance components), SNOSWAB (daily estimation of snow related processes and water balance budget) and SNOW BUDDY (daily estimation of snowfall and rainfall amounts).</h5>

                <br/>
                <h5>Citation:<br/>

                <h5><span style="font-style:italic">Danielescu S (2022) Groundwater Recharge Estimation Tool (RECHARGE BUDDY) - A web-based tool. Reference Manual.</span>
                <br/>Available at <a href="https://rbuddy.hydrotools.tech">https://rbuddy.hydrotools.tech</a>.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>            

            <li class="py-5 no-marker">
                <h3 class="top-section" id="chapter_2">2. Background</h3> 

                <h5>Groundwater recharge (also known as deep drainage or deep percolation) is a hydrological process through which aquifers receive water and thus allows for replenishing of groundwater resources. Most typically, groundwater recharge is related to the downward movement (via. infiltration and percolation) of water from the surface of the ground to the aquifer and is commonly a result of natural processes such as rain and snowmelt, but can also be artificially induced. Groundwater recharge is extremely important for appropriate management of groundwater systems and is a key component of many water resource studies aimed at understanding the dynamics of aquifer water storage. Thus, estimation of groundwater recharge is an important parameter for studies involving for example groundwater quantity and contaminant transport modelling, irrigation, climate change, saltwater intrusion in coastal areas, weathering of rock material, etc.</h5>

                <h5>The Water Table Fluctuation (WTF) method, widely used in hydrogeological studies (e.g., Healy and Cook, 2002; Scanlon and Healy, 2002; Coes et al., 2007; Labrecque et al., 2010) allows for estimation of groundwater recharge in unconfined aquifers based on the specific yield of the aquifer (or material) and the changes in water table elevation. Groundwater recharge is calculated using the following equation:</h5>                

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq1.png', [
                        'class' => ['img','set-h-40'],
                        'alt' => 'WTF Method'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 1. - WTF Method</h5>
                        <h6>GWR - Groundwater recharge (mm)<br/>
                        S<sub>v</sub> - Specific yield (m<sup>3</sup>/m<sup>3</sup>)</br/>
                        dt - change in time (day)<br/>
                        </h6>
                    </div>
                </div>                                               

                <br/>
                <h5>Specific yield (also known as drainable porosity) is defined as the ratio of the volume of water that a saturated rock or soil will yield by gravity to the total volume of the rock or soil. Specific yield can be estimated through various methods; however, if these estimates are not available, specific yield values for various soil and rock types are available via numerous literature sources.</h5>
                
                <h5>The change in water table elevation, defined as the difference in water table elevation between two consecutive days, is used for determining the presence of groundwater recharge and discharge processes. Thus, groundwater recharge is considered to occur if the change is positive and groundwater discharge is considered to occur if the change is negative.</h5>
                
                <h5>WTF method has the advantage of being a simple and easy to use method. The values of recharge estimated with this method are representative for areas ranging from several square meters to thousands of square meters, provided the water levels are representative for the aquifer as a whole, and thus, WTF method provides a distinct advantage over point measurement approaches (e.g. measurements within the unsaturated zone) (Healy and Cook, 2002).</h5>

                <h5>The WTF method has been adapted in the Groundwater Recharge Estimation Tool (RECHARGE BUDDY) to allow for estimation of groundwater recharge in multi-layered systems. Thus, the user can define the properties (e.g., thickness and specific yield) of up to 20 layers and, depending on the position of the user provided water table elevation timeseries, RECHARGE BUDDY will calculate the total groundwater recharge as the sum of the recharges associated with each layer.</h5>

                <h5>RECHARGE BUDDY can be used for any location for which input data is available. The tool includes routines for validating the output when user-provided calibration data is supplied. The web-based tool provides various data visualization, analysis and output (i.e., export) options through a streamlined process and a user-friendly interface. The Test Data set allows users to test the various routines and familiarize themselves with the tool.</h5>

                <h5>RECHARGE BUDDY has a broad range of applicability and can be used for standalone analyses of groundwater recharge, for generation of critical data for external models that allow for uploading of user-provided groundwater recharge; or for educational purposes to demonstrate the significance and the dynamics of groundwater recharge processes.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>        

            <li class="pt-5 pb-3 no-marker">
                <h3 class="top-section" id="chapter_3">3. User Guide</h3> 

                <h5>At the top, a contextual menu provides access to the various modules of the tool. The modules can be accessed progressively, in the following order: 1) Home (Information module); 2) Input Data (Data entry module); and 3) Analysis (Calculation module). Once the calculations of a module are completed, the user can advance to the next module and can also return to the respective module at any time during the session. Menu tabs are available for both the data entry (i.e., Info, Load Data, Graphical View, Table View and Export Input Data for the Input Data module) and calculation (i.e., Info, Analysis, Graphical View, Table View and Export) modules.  Additional buttons (i.e., UCD and Reset Data) appear in the contextual menu once the Input Data is loaded to the tool.</h5>

                <h5>RECHARGE BUDDY uses daily timestep for both input and output data and includes a series of averaging options for displaying and exporting data (i.e., monthly, seasonal [meteorological and growing season], yearly).  RECHARGE BUDDY also calculates and allows for displaying of input and output data using as a "typical year daily" timeseries (i.e., daily multi-year averages for each day of the year available in the input and output files) when the analysis is carried out for a period longer than one year. The daily values for the typical year can also be averaged by the tool over monthly, seasonal [meteorological and growing season], and yearly periods. Daily typical and monthly averaging intervals are recommended for inspecting and analyzing "average" conditions when the datasets cover longer periods of time (several years).</h5>

                <h5>In the following sections the options available under the various modules of the tool, together with details about the output data, calibration procedure and data inspection, visualization and export are presented in separate subsections.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.1">3.1. Quick start</h4><br/>

                <h5>In order to run Groundwater Recharge Estimation Tool (RECHARGE BUDDY) the user has to complete the following steps:</h5>

                <ol class="large-list">
                    <li>
                        <h5>Load Data: provide required data or use the provided test data [Input Data module];</h5>
                    </li>

                    <li>
                        <h5>Perform groundwater recharge calculations: enter required coefficients and select Run Analysis [ANALYSIS module – Analysis tab]. The calibration of the tool is conducted by adjusting the coefficients available on this page (i.e., specific yield; lower and upper elevations for each layer) in conjunction with the information displayed in the Calibration overlay window launched by using the Run Analysis button;</h5>
                    </li>                   

                    <li>
                        <h5>Investigate Results and Export Data: review RECHARGE BUDDY output from each module [Table View and/or Graphical View] and export results [Export Data button available under each data entry and calculation modules or the CSV button available under the Stats and Calibration Stats of the Graphical View or under the Table, Stats and Calibration Stats of the Table View].</h5>
                    </li>
                </ol>

                <h5>The steps required for using this tool are described in more detail below.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.2">3.2. Home Module</h4><br/>

                <h5>This module contains information related to the development, methodology and use of RECHARGE BUDDY. Under each of the input and calculation modules an Info tab is available, where general information relevant to the respective module is provided.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.3">3.3. Input Data Module</h4><br/>

                <!-- <h5>The Input Data menu entry has five tabs at the top of the page: Info, Load Data, Graphical View, Table View and Export Input Data.</h5> -->

                <h5>The first step in conducting an analysis is to upload the input data file to be used by RECHARGE BUDDY. The users can run RECHARGE BUDDY either by using the test dataset or by uploading a new dataset.</h5>
             
                <h5>For testing RECHARGE BUDDY and better understanding how the various components of the tool operate, the user can upload the test data set provided by clicking on "Try the tool using the test dataset" button. The test dataset contains three years of weather and user calibration data (UCD). Test dataset UCD data consists of groundwater recharge (mm; UCD1; corresponding to RECHARGE BUDDY Groundwater Recharge output parameter; UCD1 estimated from groundwater levels measured in research wells at AAFC Harrington Experimental Farm, Prince Edward Island, Canada), groundwater discharge (mm; UCD2; corresponding to RECHARGE BUDDY Groundwater Discharge output parameter; UCD2 estimated from groundwater levels measured in research wells at AAFC Harrington Experimental Farm, Prince Edward Island, Canada), and soil water content (m/m; UCD3; UCD3 measured at Agriculture and Agri-Food Canada [AAFC] Harrington Experimental Farm, Prince Edward Island, Canada).</h5>

                <h5>For using RECHARGE BUDDY, the users need to upload daily timeseries. The tool accepts source data sets in Comma Separated File (csv) format. The users can use the "Download Sample File" button located on the Upload User Data Page (Load Data) or the "Export Input Data - Daily" menu to obtain a correctly formatted input file that can be used as a model for populating the input data file with user data. The "Export Input Data - Daily" menu becomes available after the test or a user dataset is loaded. The user input file can be uploaded to RECHARGE BUDDY by using the "Upload user data" button. RECHARGE BUDDY allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods. It should be noted that the tool cannot accommodate missing data (i.e., blank rows in required data columns) or erroneous data entries, and hence it is recommended that the integrity of the source data is verified before uploading. An error message will be displayed, and the user will be redirected to the Load Data page if inconsistencies are detected in the user file.</h5>

                <h5>The input data file consists of a tabular file, with the first row dedicated to the parameter names, 1 column dedicated to calendar date, 1 column dedicated to required input data (WTELEV - Water Table Elevation; m.a.s.l. – meters above sea level) and 3 columns reserved for optional user calibration data (UCD1 to UCD3). The required input data columns have to contain values in all rows, while the optional data columns (i.e., UCD) can be left blank if data is not available. If UCD data is provided, then all the rows in the respective column(s), except for the column headings, must contain numeric values. UCD data sets are not restricted to certain parameters and can include time series for any parameter that the user intends to use for comparing with the output from RECHARGE BUDDY. Although UCD data is optional, it provides critical information for adjusting the various coefficients of the tool during the calibration procedure. Examples of calibration time series datasets include groundwater recharge and discharge obtained with other methods, soil water content, stream discharge, infiltration, evapotranspiration, etc.</h5>

                <div class="table-responsive text-left pt-2">

                    <h5>The number of columns, data format and the units of the various timeseries required for the input file are shown in the table below.</h5>
                    
                    <table class="table table-bordered text-center my-3">
                        <thead class="thead-dark">
                            <tr class="table-primary">
                                <td class="customlegend" colspan=7>
                                    <fieldset>
                                        <legend>RECHARGE BUDDY Input data file: format, columns, and units for input and user calibration data (UCD)</legend>
                                    </fieldset>
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <th scope="row">Columns</th>
                                <td>DATE</td>
                                <td><span data-toggle="tooltip" title="<?= $tooltips['ELEVATION'] ?>">WTELEV</span></td>   
                                <td class="validation-col"><span data-toggle="tooltip" title="<?= $tooltips['UCD'] ?>">UCD</span> (max. 3 columns)</td>
                            </tr>
                            <tr class="table-info no-wrap-table-row">
                                <th scope="row">Units</th>
                                <td>yyyy-mm-dd</td>                                
                                <td>m</td>               
                                <td>user choice</td>    
                            </tr> 
                            <tr class="table-info no-wrap-table-row">
                                <th scope="row">Values</th>
                                <td>eg. 2021-12-24</td>                                
                                <td>-1000 to 8000</td>                                           
                                <td>user choice</td>    
                            </tr>   
                        </thead>
                        <tbody>        
                        </tbody>
                    </table>
                </div>                

                <br/>
                <h5>Notations:</h5>

                <ul>
                    <li>
                        <h5><span class="underlined">Required data</span>:
                            <br/>DATE - use yyyy-mm-dd format;                             
                            <br/>WTELEV - daily water table elevation;                                                         
                    </li>

                    <li>
                        <h5><span class="underlined">Optional data</span>:
                            <br/>UCD - user calibration data (up to three columns; leave blank if no data is available)</h5>
                    </li>
                </ul>

                <br/>
                <h5>Notes:</h5>

                <ul>
                    <li>
                        <h5>The tool requires daily data</h5>
                    </li>

                    <li>
                        <h5>The user input data file has to be uploaded using a file with 1 column dedicated to calendar date, 1 column dedicated to required input data (WTELEV) and 3 columns reserved for optional user calibration data (UCD1 to UCD3)</h5>
                    </li>

                    <li>
                        <h5>Use the first row of the data set for column headings</h5>
                    </li>

                    <li>
                        <h5>RECHARGE BUDDY includes several input data integrity and quality check routines; however, the user is advised to thoroughly check the input dataset before uploading it to the tool to minimize the risk for erroneous output</h5>
                    </li>                    
                </ul>

                <br/>
                <!-- <h5>On this page the user can specify the beginning and the end of the growing season in the boxes provided. These dates are used for averaging the various parameters during the growing season (GS) and outside of the growing season (OGS). In RECHARGE BUDDY, it is assumed that these dates are not changing from year to year and hence, the start and end dates use the mm-dd format (the year is ignored as the same dates are applied to all years available in the input data file).</h5> -->

                <h5>Once the input dataset is loaded to RECHARGE BUDDY via either the "Try the tool using the test data set" or "Upload user data" button an overlay window appears (i.e., "Select the UCD averaging method") asking the user to specify the method used for calculation of monthly values for each UCD timeseries (i.e., averaging vs. summation). Once this step is completed a new button ("UCD") is added to the right of the Input Data tab at the top of the page and the view switches to Graphical View. The UCD menu available at the top of the page allows the user to change the method for the calculation of monthly values for each UCD at any time. See section <a href="#chapter_3.7">3.7.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>

                <br/>
                <h5>Once the loading and inspecting of the input data is completed the user can click on the ANALYSIS menu entry at the top of the page to advance to the calculation module.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.4">3.4. Analysis Module</h4><br/>

                <h5>On the Analysis Tab the user must first provide the coefficients required by the tool in the "Vertical distribution of specific yield" and "Calibration mapping" sections of the page. The values of the coefficients can be entered manually using the collapsible menus available under the Analysis Tab or can be uploaded as a set using the "Import configuration file" button. Once specified, the values of the coefficients can be checked using the "Validate" button at the bottom of the page. An error message is displayed if the coefficients include blank, out of range or incorrect format data. "Run Analysis" button replaces the "Validate" button if no errors in coefficient values are found during the validation. The configuration file can be downloaded using the "Export Configuration File" button under the Analysis Tab (including either default values of the coefficients if the first tool run has not been completed or values of the coefficient as set for the last available run of the tool if the analysis has been completed at least once) or by using "Export Configuration" in the "Export Results" menu (available after one successful run of the module). If needed, the users can also reset all the values of the coefficients to default values by using the "Reset to Default" button available at the bottom of the page in the Analysis tab.</h5>          
                
                <h5>In the "Vertical distribution of specific yield" section of the page the user have to enter the lower and upper bound elevations as well as the specific yield for each layer of the domain. The number of layers can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Lower and upper bound elevations values between -1000 and 8000 m.a.s.l. (meters above sea level) are allowed. Of note, use of depths instead of elevations will result in erroneous results. When entering values in the elevation fields, the user have to check that the depth intervals do not overlap and the lower bound elevation is smaller than the upper bound elevation for each layer. For specific yield, the values have to be between 0 and 1 and the units currently used are m3/m3. For reference, the specific yield values can be converted to percentages if they are multiplied by 100 (e.g., 0.1 m3/m3 is equal to 10%). </h5>

                <h5>In the "Calibration mapping" section of the page the users have to select the pairs of tool output and user calibration data that will be used during the calibration of the tool. The "Calibration Mapping" fields can be ignored if the UCD data is not available in the Input Data file.</h5>

                <h5>RECHARGE BUDDY starts groundwater recharge calculations once the values of the required coefficients are set and the user clicks on the Run Analysis button at the bottom of the page.</h5>

                <h5>All values entered on this page can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the output fitness is observed. See section <a href="#chapter_3.6">3.6</a> for instructions regarding the calibration of the tool and section <a href="#chapter_3.7">3.7.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.5">3.5. Output Timeseries</h4><br/>

                <h5>The output from RECHARGE BUDDY is shown in the table below.</h5>

                <table class="table table-bordered text-center my-3">
                    <thead class="thead-dark">                        
                        <tr class="table-primary" style="font-style:italic">
                            <td>NAME</td>
                            <td>DESCRIPTION</td>
                        </tr>          
                        <tr class="table-info">
                            <td>Index</td>
                            <td>Indicates the position of a specific record (line) in the timeseries.</td>                                                                      
                        </tr>                      
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['ELEV_CHANGE'] ?>">Change in WT Elev. (mm)</span></td>
                            <td>Change in Water Table (WT) Elevation. For daily timestep the values in this column are calculated as the difference between Water Table (WT) Elevations for two consecutive days (i.e.  &Delta;WT Elev. = WT Elev<sub>t+1</sub> - WT Elev<sub>t</sub>). For all other averaging intervals this is calculated as the difference between the last day and the first day in the interval (e.g., for monthly this is calculated as the difference between the water table elevation on the last day of the month and the water table elevation on the first day of the month). The units for &Delta;WT Elev. are mm.</td>                                                                      
                        </tr>                                
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['GW_RECHARGE'] ?>">Groundwater Recharge (mm)</span></td>
                            <td>This is the amount of groundwater recharge and is always calculated using the daily timestep. When the data is displayed using averaging intervals other than daily, this is calculated as the sum of daily recharges (i.e., recharge is calculated only for the days when &Delta;WT Elev. is positive). The units for Groundwater Recharge are mm. To obtain the volume of recharge for a given area the user has to multiply this value with the land area of interest.</td>                                                                      
                        </tr>  
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['GW_DISCHARGE'] ?>">Groundwater Discharge (mm)</span></td>
                            <td>This is the amount of groundwater discharge and is always calculated using the daily timestep. When the data is displayed using averaging intervals other than daily, this is calculated as the sum of daily discharges (i.e., discharge is calculated only for the days when &Delta;WT Elev. is negative). The units for Groundwater Discharge are mm. To obtain the volume of discharge for a given area the user has to multiply this value with the land area of interest. </td>                                                                      
                        </tr>   
                        <tr class="table-info">
                            <td><span data-toggle="tooltip" title="<?= $tooltips['AQUIF_STORAGE_CHANGE'] ?>">Change in aquifer storage (mm)</span></td>
                            <td>The change in aquifer storage is calculated on a daily basis as the product of &Delta;WT Elev. and specific yield. When positive, this indicates occurrence (i.e., dominance) of groundwater recharge, and when negative occurrence (i.e., dominance) of groundwater discharge. When the data is displayed using averaging intervals other than daily, this is calculated as the sum of daily changes, and thus, it shows the "net" change in storage over the respective averaging interval. The values calculated in this column are assigned to the Groundwater Recharge if positive and to Groundwater Discharge columns if negative. Consult sections <a href="#chapter_2">2</a> and <a href="#chapter_4">4</a> for additional details.</td>                                                                      
                        </tr>                             
                    </thead>
                    <tbody>        
                    </tbody>
                </table>                           
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>

                <br/>
                <br/><h4 class="l2-section" id="chapter_3.6">3.6. Calibration Procedure</h4><br/>

                <h5>Calibration of the tool is performed via the Analysis tab of ANALYSIS module and is available only when UCD data is included in the Input data file. Calibration is conducted by first pairing the datasets from the output of the tool with the user calibration data (UCD) using the "Calibration mapping" menu available under the "Analysis" tab. Once the pairing is completed, the user can proceed to running the ANALYSIS module (i.e., "Run Snow Analysis" button at the bottom of the Analysis tab page) and inspect the tool output in the subsequent Calibration overlay window. The fitness of the output for various timesteps and averaging intervals can be inspected in the Calibration overlay window via graphs as well as bivariate statistics. If the calibration is considered unsatisfactory the user can return to the Analysis menu (i.e., "Return" button), adjust the various coefficients of the tool and rerun the analysis. If the calibration is considered satisfactory the user can complete the calculations by proceeding to the next step (i.e., "Proceed to results" in the Calibration Overlay window). </h5>                

                <h5>To aid with data inspection and assessment of the fitness of the output data, RECHARGE BUDDY includes several univariate and bivariate statistics. Univariate statistics, including, average, minimum, maximum and standard deviation are calculated separately for the input (i.e., user provided calibration data) and tool output time series. The graphs and the univariate statistics can be used for example for comparing the general trends, the range of values and the amplitude of variations in both data sets. The bivariate statistics include the coefficient of determination (R2), root mean square error (RMSE) and the normalized root mean square error (NRMSE). NRMSE is calculated by using the average, the interquartile range or the differences between maximum and minimum (see definitions below). The bivariate statistics are used for evaluating the fitness of the output, by providing a measure of the differences between the values calculated by the tool and the user provided calibration data (i.e., UCD). The equations used for calculating each bivariate statistic are shown below.</h5>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_r_square.png', [
                        'class' => ['img','set-h-60'],
                        'alt' => 'Conceptual model for the Model Calibration'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 2. - Coefficient of determination</h5>
                        <h6>R<sup>2</sup> - coefficient of determination<br/>
                        x<sub>i</sub> - value for observed data on day i<br/>
                        y<sub>i</sub> - value for modelled data on day i<br/>
                        x<sub>mean</sub> - mean of observed data</h6>
                    </div>
                </div>                   
                
                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_rmse_2.png', [
                        'class' => ['img','set-h-60'],
                        'alt' => 'Conceptual model for the Model Calibration'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 3. - Root mean square error</h5>
                        <h6>RMSE - Root mean square error<br/>
                        <h6>N - number non-missing data points<br/>
                        x<sub>i</sub> - value for observed data on day i<br/>
                        y<sub>i</sub> - value for modelled data on day i</h6>
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_ave.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error average'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 4. - Normalized root mean square error average</h5>
                        <h6>NRMSE<sub>ave</sub> - normalized root mean square error calculated using the average value of measured data<br/>
                        RMSE - root mean square error<br/>
                        x<sub>a</sub> - average value of observed data</h6>
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_iqr.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error IQR'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 5. - Normalized root mean square error IQR</h5>
                        <h6>NRMSE<sub>IQR</sub> - normalized root mean square error calculated using minimum and maximum values of measured data<br/>
                        RMSE - root mean square error<br/>
                        IQR  - interquartile range of the observed data; IQR = Q3-Q1,<br/>with Q3 = CDF<sup>-1</sup>(0.25), Q1 = CDF<sup>-1</sup>(0.75),<br/>where CDF is the quantile function 
                    </div>
                </div>

                <div class="text-center mt-5 pb-2">
                    <?= $this->Html->image('eq_nrmse_minmax.png', [
                        'class' => ['img'],
                        'alt' => 'Normalized root mean square error min/max'
                ]); ?>
                </div>   
                <div class="row mt-2">
                    <div class="col-8 offset-2 text-center">
                        <h5 class="fig-title">Eq 6. - Normalized root mean square error min/max</h5>
                        <h6>NRMSE<sub>min/max</sub> - normalized root mean square error calculated using minimum and maximum values of measured data<br/>
                        RMSE - root mean square error<br/>
                        x<sub>max</sub> - maximum value for observed data<br/>
                        x<sub>min</sub> - minimum value for observed data</h6>
                    </div>
                </div>

                <br/>
                <h5>It is recommended that the calibration is conducted by changing one coefficient at a time over a selected range of values. When no further improvement is observed in the output the user can advance to adjusting the values of the next coefficient. The values of the various coefficients can be considered final once no further improvement in the fitness of the data is observed. Currently, only calibration by trial and error is available, however the integration of an autocalibration routine is in planning stages.</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>                               
                
                <br/>
                <br/><h4 class="l2-section" id="chapter_3.7">3.7. Data inspection, visualisation and export</h4><br/>
            
                <h5>Inspection of data via graphical and tabular views can be conducted via the Graphical View, Table View and Export Data menu entries that become available in the Input Data module once the input dataset is loaded to RECHARGE BUDDY. These menu entries are also available under each ANALYSIS module and allow the user to evaluate the output for each of these modules.</h5>

                <br/>
                <h5><strong>Graphical View</strong> allows for plotting of input or output data using various time steps and intervals available via a drop-down menu. The parameters that can be displayed are available in the selection pane located to the right of the plot. Each parameter can be displayed on the primary (left) Y axis or on the secondary (right) Y axis by clicking on the toggle placed at the right of the selection pane. Additional options for customizing the plot become visible in the top right corner when the mouse pointer is placed above the plot. These options include zoom, auto scale, reset axes, show data point labels, download plot, etc. Univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the tool output are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset ("Show Complete Dataset Stats" button) or for a selected subset ("Show stats by Interval" button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page.</h5>

                <br/>
                <h5><strong>Table View</strong> allows the user to display data in tabular format using various time steps and intervals. The user can also change the number of lines, filter data based on date or adjust the starting date of the data that is displayed. In the initial Table View, the columns displayed by default are limited to "key" parameters, however the user can change the selection of the parameters to be displayed by selecting the parameters listed above the table. In the respective list, the parameters that are displayed in the table are shown in filled boxes, while the ones that are omitted are included in clear boxes. The "key" parameters are shown in red font when not selected to be displayed. Similar to the Graphical View, univariate statistics (average, minimum, maximum, standard deviation) for selected timeseries and bivariate statistics (R<sup>2</sup>, RMSE, NRMSE<sub>ave</sub>, NRMSE<sub>IQR</sub>, NRMSE<sub>min/max</sub>) for inspecting the fitness of the output are available under the Stats and Calibration Stats tabs, respectively. These statistics are available either for the entire dataset ("Show Complete Dataset Stats" button) or for a selected subset ("Show stats by Interval" button). The tables shown on the statistics pages can be exported individually by using the corresponding CSV button located to the right of the page.</h5>

                <br/>
                <h5>The <strong>Export Data</strong> tab offers additional options for exporting the entire dataset using various time steps and intervals. The Export Data tab also provides options for exporting statistics and the tool configuration (i.e., values of parameters and coefficients used by the user in each of the tool modules). The data is currently exported in csv format. The CSV button located at the top right of each table in Table View or in Graphical View can be used if the intent is to export only the data shown in the current window.</h5>
                                
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_4">4. Limitations</h3>

                <br/><h4 class="l2-section">Limitations of the tool</h4><br/>
                
                <h5>RECHARGE BUDDY allows uploading of files with maximum 7500 rows (~20 years of daily data). It is recommended to split the input data set in blocks of 20 years daily timeseries when the intent is to analyze longer time periods.</h5>

                <br/>
                <h5>Although RECHARGE BUDDY includes several input data integrity and quality check routines, the user is advised to thoroughly check the input dataset before uploading it to the tool to minimize the risk for erroneous output.</h5>

                <br/><h4 class="l2-section">Limitations of the Water Table Fluctuation (WTF) method for groundwater recharge</h4><br/>
                
                <h5>The approach used by the WTF method (i.e., recharge calculated as the product of specific yield and change in water table elevation) is a simplification of the complex process of movement of water to and from the aquifer (Healy and Cook, 2002).</h5>

                <br/>
                <h5>WTF method assumes that specific yield is constant over time, however studies have shown that specific yield can vary (Sophocleous, 1985; Sloto, 1990).</h5>

                <br/>
                <h5>WTF method is most suitable for shallow unconfined aquifers that show sharp rises and declines in water table (Healey and Cook, 2002).</h5>

                <br/>
                <h5>A positive change in water table elevation shows that the amount of water moving into the aquifer is larger than the amount of water moving away from the aquifer, and hence a "net" groundwater recharge occurs. Hence, it is not possible to estimate the "true" or "total" groundwater recharge unless independent estimates of the groundwater discharge are available. Similarly, a negative change in water table shows that groundwater discharge process was dominant, and does not imply that groundwater recharge did not occur during the respective time interval.</h5>

                <br/>
                <h5>Care must be exercised when selecting the specific yield values for application of the WTF method in fractured rock (USGS, 2017).</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_5">5. Terms of Use</h3> 

                <h5>Groundwater Recharge Estimation Tool (RECHARGE BUDDY) can be used freely.</h5>

                <h5>The authors do not assume any responsibility for the tool's operation, output, interpretation, or use of results.</h5>               
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>         
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_6">6. References</h3> 

                <h5><span style="font-style:italic">Coes A, Spruill T, Thomasson M (2007) Multiple-method estimation of recharge rates at diverse locations in the North Carolina Coastal Plain, USA: Hydrogeology Journal 15: 773-788.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.1007/s10040-006-0123-3">https://doi.org/10.1007/s10040-006-0123-3</a></h5>

                <h5><span style="font-style:italic">Healey RW, Cook PG (2002) Using groundwater levels to estimate recharge. Hydrogeology Journal 10:91-109.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.1007/s10040-001-0178-0">https://doi.org/10.1007/s10040-001-0178-0</a></h5>

                <h5><span style="font-style:italic">Johnson AI (1967) Specific yield: compilation of specific yields for various materials. Geological Survey Water-Supply Paper 1662-D. USGS, Washington, DC, US.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.3133/wsp1662d">https://doi.org/10.3133/wsp1662d</a></h5>

                <h5><span style="font-style:italic">Labrecque G, Chesnaux R, Boucher M-A (2020) Water-table fluctuation method for assessing aquifer recharge: application to Canadian aquifers and comparison with other methods. Hydrogeology Journal 28: 521-533.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.1007/s10040-019-02073-1">https://doi.org/10.1007/s10040-019-02073-1</a></h5>

                <h5><span style="font-style:italic">Scanlon BR, Healy RW (2002) Choosing appropriate techniques for quantifying groundwater recharge. Hydrogeology Journal 10:18-39.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.1007/s10040-002-0200-1">https://doi.org/10.1007/s10040-002-0200-1</a></h5>

                <h5><span style="font-style:italic">Sloto R (1990) Geohydrology and simulation of ground-water flow in the carbonate rocks of the Valley Creek Basin, Eastern Chester County, Pennsylvania. U.S.Geological Survey Water-Resources Investigations Report 89-4169, 60 p.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.3133/wri894169">https://doi.org/10.3133/wri894169</a></h5>

                <h5><span style="font-style:italic">Sophocleous M. (1985) The role of specific yield in ground-water recharge estimations—A numerical study. Ground Water 23:  52-58.</span><br/>
                DOI: <a target="_blank" href="https://doi.org/10.1111/j.1745-6584.1985.tb02779.x">https://doi.org/10.1111/j.1745-6584.1985.tb02779.x</a></h5>

                <h5><span style="font-style:italic">United States Geological Survey (USGS) (2017) Water-Table Fluctuation (WTF) Method - Key Assumptions and Critical Issues.</span><br/>
                URL: <a target="_blank" href="http://water.usgs.gov/ogw/gwrp/methods/wtf/issues_limititations.html">http://water.usgs.gov/ogw/gwrp/methods/wtf/issues_limititations.html</a> [Accessed December 2022]</h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>

            <li class="py-3 no-marker">
                <h3 class="top-section" id="chapter_7">7. Contact</h3> 

                <h5>
                    Serban Danielescu, Ph.D.<br/>
                    Research Scientist | Chercheur scientifique<br/>
                    Environment and Climate Change Canada | Environnement et Changements Climatiques Canada<br/>
                    Agriculture and Agri-Food Canada | Agriculture et Agroalimentaire Canada<br/>
                    Fredericton Research and Development Centre | Centre de recherche et développement de Fredericton<br/>
                    95 Innovation Rd., Fredericton, NB, E3B 4Z7<br/>
                    Telephone/Téléphone: 506-460-4468<br/>
                    Facsimile/Télécopieur: 506-460-4377<br/>
                    <!-- <a href="mailto:serban.danielescu@ec.gc.ca">serban.danielescu@ec.gc.ca</a><br/>
                    <a href="mailto:serban.danielescu2@agr.gc.ca">serban.danielescu2@agr.gc.ca</a><br/>                -->
                    <?= $this->Html->image('email_addresses.png', ['class' => ['img','max-h-300']]); ?>
                </h5>
                <div class="text-right"><a href="#contents">&rarr; Table of Contents</a></div>
            </li>
               
        </ul>                
    </div>    
    
</div>