<div class="my-5 row">
    <div class="col-12 col-lg-6 offset-lg-3">   
        <form method="post" id="uploadParamsForm" action="upload-param-file" enctype="multipart/form-data">                            
            <div id="upload_param_input_group" class="input-group mb-3 form-red-border">           
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="filename" name="inputDataFile" aria-describedby="fileHelp">
                    <label class="custom-file-label" for="fileHelp">Choose configuration file</label>
                </div>
            </div>                                      

            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name ="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />                
            <!-- END OF CAKE FORM FIELDS !-->
            
            <div class="row text-center">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary" style="min-width:66%">Import Configuration File</button>                    
                </div>

                <div class="col-6">
                    <?= $this->Html->link('Export Configuration File', [
                    'controller' => 'snow',
                    'action' => 'export-config'], [
                        'class' => 'btn btn-secondary',
                        'style' => 'min-width:66%']); ?>
                </div>                
            </div>        
        </form>  
    </div>
</div>

<div class="my-5 row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <form id="analysisForm" method="post" action="perform-analysis">

            <div id="accordion">
                <div class="card active">
                    <div class="card-header myAccordionHeader" id="headingOne">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="d-flex justify-content-between" type="button">
                                <span>Vertical distribution of specific yield (m<sup>3</sup>/m<sup>3</sup>)</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            <div class="form-group" id="param-group">
                                <div class="row">                                    
                                    <div class="col col-3 offset-2">
                                        <span data-toggle="tooltip" title="<?= $tooltips['yield'] ?>">Layer lower bound (masl)</span>
                                    </div>

                                    <div class="col col-3">
                                        <span data-toggle="tooltip" title="<?= $tooltips['yield'] ?>">Layer upper bound (masl)</span>
                                    </div>

                                    <div class="col col-4">
                                        <span data-toggle="tooltip" title="<?= $tooltips['yield'] ?>">Specific yield</span>                                        
                                    </div>
                                </div>

                                <?php for($i=0; $i<$paramData['layer_count']; $i++) { ?>
                                <div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <?php if ($i==0) { ?>
                                        <button type="button" class="btn btn-success add-param-row" data-toggle="tooltip" title="Add interval"><i class="fas fa-plus"></i></button>
                                        <?php } else { ?>
                                        <button type="button" class="btn btn-danger rm-param-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                        <?php } ?>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. -25" name="layer_l[]" value="<?= $paramData['layer_l_' . $i] ?>">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 5" name="layer_h[]" value="<?= $paramData['layer_h_' . $i] ?>">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="layer_yield[]" value="<?= $paramData['layer_yield_' . $i] ?>">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['yield_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>  
                                <?php } ?>                                                      
                            </div>            
                            
                            <div class="row mt-4">
                                <div class="col col-11 offset-1 alert-warning text-center">
                                    <span>* Data points not covered by any interval will have a conversion factor of 0. *</span>
                                </div>                                    
                            </div>   
                            
                            <div class="row mt-4" id="overlapError" style="display:none">
                                <div class="col col-11 offset-1 alert-danger text-left">
                                    <div class="text-center">
                                        <h4>Invalid parameters! Requirements:</h4>
                                    </div>                                    
                                    <h5>- all values must be numeric<br/>
                                    - depths of the layers are entered as elevations (masl - meters above sea level)<br/>
                                    - the elevation intervals should not overlap<br/>                                    
                                    - the lower bound elevation should be smaller than the upper bound elevation for each layer<br/>
                                    - the specific yield values should be between 0 and 1</h5>
                                </div>                                    
                            </div>    
                        </div>
                    </div>
                </div>                

                <?php if ($nValidationColumns) { ?>
                <div class="card">
                    <div class="card-header myAccordionHeader" id="headingUcd">
                        <h5 class="mb-0">
                            <button data-toggle="collapse" data-target="#collapseUcd" aria-expanded="false" aria-controls="collapseUcd" class="d-flex justify-content-between collapsed" type="button">
                                <span>Calibration mapping</span>
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </h5>
                    </div>
                    
                    <div id="collapseUcd" class="collapse" aria-labelledby="headingUcd" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table table-borderless table-sm px-5 graph-params">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Model Output</th>
                                        <th scope="col" class="text-center">Calibration Data</th>
                                    </tr>
                                <tbody>                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output1_select" name="output1_select" placeholder="Model Output...">
                                                <option value="elev_change" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'elev_change') == 0) ? 'selected' : ''?>>Elevation Change</option>
                                                <option value="aquif_storage_change" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'aquif_storage_change') == 0) ? 'selected' : ''?>>Aquifier Storage Change</option>
                                                <option value="gw_recharge" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'gw_recharge') == 0) ? 'selected' : ''?>>Ground Water Recharge</option>
                                                <option value="gw_discharge" <?= (isset($calibration['output1_field']) && strcmp($calibration['output1_field'],'gw_discharge') == 0) ? 'selected' : ''?>>Ground Water Discharge</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd1_select" name="ucd1_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd1_field']) && strcmp($calibration['ucd1_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>   
                                    
                                    <tr>
                                        <td>
                                            <select class="custom-select" id="output2_select" name="output2_select" placeholder="Model Output...">
                                                <option value="elev_change" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'elev_change') == 0) ? 'selected' : ''?>>Elevation Change</option>
                                                <option value="aquif_storage_change" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'aquif_storage_change') == 0) ? 'selected' : ''?>>Aquifier Storage Change</option>
                                                <option value="gw_recharge" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'gw_recharge') == 0) ? 'selected' : ''?>>Ground Water Recharge</option>
                                                <option value="gw_discharge" <?= (isset($calibration['output2_field']) && strcmp($calibration['output2_field'],'gw_discharge') == 0) ? 'selected' : ''?>>Ground Water Discharge</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="custom-select" id="ucd2_select" name="ucd2_select" placeholder="UCD field...">
                                                <?php for ($i = 0; $i < $nValidationColumns; $i++) {
                                                    $ucdVal = 'ucd'.($i+1);
                                                ?>
                                                    <option value=<?=$ucdVal?> <?= (isset($calibration['ucd2_field']) && strcmp($calibration['ucd2_field'],$ucdVal) == 0) ? 'selected' : ''?>><?=strtoupper($ucdVal)?></option>;
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div>                
                <?php } ?>
            </div>                         
                       
            <!-- CAKE FORM FIELDS !-->
            <input type="hidden" name="_method" value="POST" />
            <input type="hidden" name="_csrfToken" autocomplete="off" value="<?= $this->request->getParam('_csrfToken') ?>" />
            <!-- END OF CAKE FORM FIELDS !-->
            <div class="mt-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col text-right">
                            <button type="button" id="validateButton" style="min-width:50%" class="btn btn-primary">Validate</button>
                        </div>

                        <div class="col text-left">
                            <button type="button" class="btn btn-danger" id="reset-to-default" style="min-width:50%">Reset to Default</button>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6 offset-3 text-center">
                            <button type="submit" class="btn btn-success" style="min-width:50%">Run Analysis</button>            
                        </div>
                    </div>
                </div>                                
            </div>            
        </form>
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js?render=6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e"></script>
<script type="module">
    //import {getCookie} from "../js/project.js";     
    
    var paramRowTemplate = `<div class="row mt-2">
                                    <div class="col col-2 add-param-col">
                                        <button type="button" class="btn btn-danger rm-param-row" data-toggle="tooltip" title="Remove interval"><i class="fas fa-minus"></i></button>
                                    </div>
                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 25" name="layer_l[]">
                                    </div>

                                    <div class="col col-3">
                                        <input type="text" class="form-control" placeholder="e.g. 35" name="layer_h[]">
                                    </div>

                                    <div class="col col-4">
                                        <input type="text" class="form-control" placeholder="&ge; 0" name="layer_yield[]">
                                        <div class="accepted-units-tooltip">
                                            <i class="fas fa-exclamation-circle" data-toggle="tooltip" title="<?= $tooltips['yield_val'] ?>"></i>
                                        </div>
                                    </div>
                                </div>`;     
    
    function validateConfigFileForm() {
        if (!$('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', true);
            $('#uploadParamsForm').find(':input[type=submit]').addClass('disabled');
        } else {
            $('#uploadParamsForm').find(':input[type=submit]').prop('disabled', false);
            $('#uploadParamsForm').find(':input[type=submit]').removeClass('disabled');
        }
    }    

    function validateParams() {
        var valid = true;

        var lowBoundary = [];        
        $('#analysisForm').find(':input[name="layer_l[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                valid = false;
            }
            if (elem.value < -1000 ) {
                elem.value = -1000;
            }
            if (elem.value > 8000 ) {
                elem.value = 8000;
            }
            lowBoundary.push(parseFloat(elem.value));
        }); 
        lowBoundary.sort(function(a,b) {
            return(a - b);
        });
        // console.log('lowBoundary', lowBoundary);  

        var highBoundary = [];
        $('#analysisForm').find(':input[name="layer_h[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                valid = false;
            }
            if (elem.value < -1000 ) {
                elem.value = -1000;
            }
            if (elem.value > 8000 ) {
                elem.value = 8000;
            }
            highBoundary.push(parseFloat(elem.value));
        });
        highBoundary.sort(function(a,b) {
            return(a - b);
        });         
        // console.log('highBoundary', highBoundary); 

        $('#analysisForm').find(':input[name="layer_yield[]"]').each((index,elem) => {
            if (isNaN(parseFloat(elem.value))) {
                // console.log('non numeric element', elem);
                valid = false;
            } else {
                if (elem.value < 0) {
                    elem.value = 0;
                }
            }            
        });

        for (var i=0; i<lowBoundary.length; i++) {
            if (lowBoundary[i] >= highBoundary[i]) {
                // console.log('incorrect boundary condition', lowBoundary[i] + ' vs ' + highBoundary[i]);
                valid = false;
            }
            
            if (i>0 && lowBoundary[i] < highBoundary[i-1]) {
                // console.log('overlapped interval');
                valid = false;
            }
        }

        if (valid) {
            $("#overlapError").hide();

            $('#validateButton').prop('disabled', true);
            $('#validateButton').addClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', false);
            $('#analysisForm').find(':input[type=submit]').removeClass('disabled');
        } else {
            $("#overlapError").show();

            $('#validateButton').prop('disabled', false);
            $('#validateButton').removeClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
            $('#analysisForm').find(':input[type=submit]').addClass('disabled');
        }
    }

    $(document).ready(function() {
        var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
        validateConfigFileForm();
        validateParams();    

        $('.add-param-row').click(function(e) {
            // console.log(e.currentTarget.parentElement.parentElement);  
            $('#param-group').append(paramRowTemplate);
            validateParams();
        });

        $('#param-group').on('click', '.rm-param-row', function(e) {
            // console.log(e.currentTarget.parentElement);  
            e.currentTarget.parentElement.parentElement.remove();

            // also remove tooltips
                let tooltips = $('body > .tooltip');
                if (tooltips.length === 0) {
                    // no tooltips
                    return;
                }
                
                // Loop through tooltips
                tooltips.each((i,tooltip) => {
                    // Do tooltip has its initiator?
                    if ($(`[aria-describedby="${tooltip.id}"]`).length === 0) {
                        // No. It is dead tooltip, remove it.
                        tooltip.remove();
                    }
                });

            validateParams();
        });       
        
        $('#validateButton').click(() => {
            validateParams();
        })
       
        $('#analysisForm').on('change', ':input', function(e) {
            $('#validateButton').prop('disabled', false);
            $('#validateButton').removeClass('disabled');

            $('#analysisForm').find(':input[type=submit]').prop('disabled', true);
            $('#analysisForm').find(':input[type=submit]').addClass('disabled');

            validateParams();
        });    
             
        $('#uploadParamsForm').find(':input[name=inputDataFile]').change(function(){     
            // alert($('#uploadParamsForm').find(':input[name=inputDataFile]').val());
            if ($('#uploadParamsForm').find(':input[name=inputDataFile]').val()){
                $("#upload_param_input_group").removeClass("form-red-border");        
                $("#upload_param_input_group").addClass("form-green-border");        
            } else {
                $("#upload_param_input_group").removeClass("form-green-border");        
                $("#upload_param_input_group").addClass("form-red-border");  
            }
            
            validateConfigFileForm();
        });

        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });        

        $('#reset-to-default').click(() => {
            async function resetToDefault() {
                return $.ajax({
                    url: 'reset-params-to-default',
                    type: 'post',                    
                    headers: {
                        'X-CSRF-Token': csrfToken 
                    },
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };

            var redirectUrl = "<?= $this->Url->build([
                    'controller' => 'snow',
                    'action' => 'analysis'
                ], true); ?>"; 

            resetToDefault().finally(function(){                
                window.location.href = redirectUrl;
            });       
        });

        $("#uploadParamsForm").submit(async function(e){
            $("#mySpinnerContainer").show();

            e.preventDefault();   
            var actionUrl = e.target.action;                      
                   
            var redirectUrl = "<?= $this->Url->build([
                'controller' => 'snow',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to function that tells me how many UCD fields
            async function uploadFile(recaptchaToken) {
                let formData = new FormData($("#uploadParamsForm")[0]);
                formData.append('token', recaptchaToken);
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };

            // console.log('pre recaptcha');
            let recaptchaToken = null;
            async function recaptchaRequest() {
                return new Promise((resolve, reject) => {
                        grecaptcha.ready(function() {
                        grecaptcha.execute('6Lf-FlYgAAAAACb4jxIZTEifVXANttZUt1245r5e', {action: 'submit'}).then(function(token) {
                            // console.log('received token ' + token);
                            recaptchaToken = token;
                            resolve();
                        });
                    });
                });
            };

            await recaptchaRequest();
            // console.log('post recaptcha');
            
            let result = await uploadFile(recaptchaToken).then(function(data){                
                window.location.href = redirectUrl;
            }).catch(function(){                
                window.location.href = redirectUrl;
            });       
        }); 

        $("#analysisForm").submit(async function(e){
            e.preventDefault();   

            $(this).find(':input[type=submit]').prop('disabled', true);
            $(this).find(':input[type=submit]').addClass('disabled');

            if ($("#output1_select").val() == undefined) { // no validation data
                $(".modal-body").hide();
            }

            $("#snowAnalysisModal").modal({
                backdrop: 'static'
            });
            
            var actionUrl = e.target.action;                      
                    
            var redirectUrlError = "<?= $this->Url->build([
                'controller' => 'snow',
                'action' => 'analysis'
            ], true); ?>";            

            // ajax call to run analysis
            async function runAnalysis() {
                return $.ajax({
                    url: actionUrl,
                    type: 'post',
                    // dataType: 'application/json',
                    data: new FormData($("#analysisForm")[0]),
                    cache: false,
                    contentType: false,
                    processData: false               
                });
            };
            
            let result = await runAnalysis().then(function(response){                
                if (response.success) {
                    // console.log('SUCCESS');
                    $("#cancel-sn-analysis").hide(); // this is found in the analysis modal
                    $("#return-sn-analysis").show(); // this is found in the analysis modal
                    $("#complete-sn-analysis").show(); // this is found in the analysis modal
                    $("#calibTypeMenu").show();
                    $("#analysisCompletionRate").html('COMPLETED');
                } else {
                    // alert('Error ' + JSON.stringify(data));
                    if (response.has_error) {
                        window.location.href = redirectUrlError;
                    }
                    
                    if (response.user_stopped) {
                        console.log('USER STOPPED');
                        $("#cancel-sn-analysis").hide(); // this is found in the analysis modal
                        $("#return-sn-analysis").show(); // this is found in the analysis modal
                    }
                }                
            }).catch(function(){
                // alert('Error');
                window.location.href = redirectUrlError;
            });       
        }); 
    });
</script>