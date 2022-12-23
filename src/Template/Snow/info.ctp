<div class="container">
    
    <div class="intro-content swib-maintext my-5">      
        <div class="swib-title text-center mb-5">
            <h2>Analysis Module</h2>
        </div>

        <div class="table-responsive text-left">

            <h5>On the Analysis Tab the user must first provide the coefficients required by the tool in the "Vertical distribution of specific yield" and "Calibration mapping" sections of this page. The values of the coefficients can be entered manually using the collapsible menus available under the Analysis Tab or can be uploaded as a set using the "Import configuration file" button available in the same tab. The configuration file can be downloaded using the "Export Configuration File" button under the Analysis Tab (including either default values of the coefficients if the first tool run has not been completed or values of the coefficient as set for the last available run of the tool if the analysis has been completed at least once) or by using "Export Configuration" in the "Export Results" menu (available after one successful run of the module). If needed, the users can also reset all the values of the coefficients to default values by using the "Reset to Default" button available at the bottom at the bottom of the page in the Analysis tab.</h5>          
                
            <h5>In the "Vertical distribution of specific yield" section of the page the user have to enter the lower and upper bound elevations as well as the specific yield for each layer of the domain. The number of layers can be expanded or reduced using the "+" or "-" buttons at the left of coefficient fields. Lower and upper bound elevations values between -1000 and 8000 m.a.s.l. (meters above sea level) are allowed. Of note, use of depths instead of elevations will result in erroneous results. When entering values in the elevation fields, the user have to check that the depth intervals do not overlap and the lower bound elevation is smaller than the upper bound elevation for each layer. For specific yield, the values have to be between 0 and 1 and the units currently used are m3/m3. For reference, the specific yield values can be converted to percentages if they are multiplied by 100 (e.g., 0.1 m3/m3 is equal to 10%). </h5>

            <h5>In the "Calibration mapping" section of the page the users have to select the pairs of tool output and user calibration data that will be used during the calibration of the tool. The "Calibration Mapping" fields can be ignored if the UCD data is not available in the Input Data file.</h5>

            <h5>RECHARGE BUDDY starts groundwater recharge calculations once the values of the required coefficients are set and the user clicks on the Run Analysis button at the bottom of the page.</h5>

            <h5>All values entered on this page can be subsequently adjusted during the calibration procedure, with calibration being considered final once no further improvement in the output fitness is observed. See section <a href="<?= $this->Url->build('/main/index#chapter_3.6');?>">3.6</a> for instructions regarding the calibration of the tool and section <a href="<?= $this->Url->build('/main/index#chapter_3.7');?>">3.7.</a> for instructions regarding the inspection of datasets using tables and graphs as well as for the various options available for exporting the data.</h5>            
        </div> 
    </div>    
   
</div>