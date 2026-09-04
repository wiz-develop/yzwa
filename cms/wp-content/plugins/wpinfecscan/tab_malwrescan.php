<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<div class="tab-pane active" id="ContentA">
    <div class="col-lg-12">
            <style>
            .ceditbt,.cdelbt {
                display: block;
                position: relative;
                width: 100%;
                padding: 0.3em;
                text-align: center;
                text-decoration: none;
                color: #fff;
                border-radius:5px;
                font-size: 13px;
                white-space:nowrap;
            }
            .ceditbt{
                background: #02b762;
                margin-bottom:5px;
            }
            .cdelbt{
                background: #ec2a33;
            }
            .autorestorebt {
                display: block;
                position: relative;
                width: 100%;
                padding: 0.3em;
                text-align: center;
                text-decoration: none;
                color: #fff;
                border-radius:5px;
                font-size: 13px;
                min-width:110px;
                height:58px;
                background: #adb7b9;
                border:1px solid #888;
                line-height: 100%;
            }
            .ikkatukujyo{
                display:none;
            }
            </style>
            <script>
            function showikkatukujyo(){
                jQuery('#myModal3').modal({backdrop: 'static', keyboard: false});
                jQuery('#myModal3').modal('show');
            }
            </script>
            <?php 
                
                if($scanok){
                    
                    $wpinfectscan_db_version = get_option( 'wpinfectscan_db_version',1.0);
                    if($wpinfectscan_db_version < 1.1){
                        $scanner->wpinfectscan_dbinstall();
                    }
                    
                    ?>
                     <div class="progress" id="scanprogress">
                      <div class="progress-bar progress-bar-striped active" role="progressbar"
                      aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        <?php echo __("Scanning in progress","wpinfecscan");?>
                      </div>
                    </div> 
                    <div style="width:100%">
                        <h4 id="scanprocessdb"><span class='dashicons dashicons-album' style='font-size: 20px;color:#aaa;'></span> <?php echo __("The number of database table scanned:","wpinfecscan");?> <?php echo __("The number of malwares detected on database:","wpinfecscan");?></h4>
                        <h4 id="scanprocess"><span class='dashicons dashicons-portfolio' style='font-size: 20px;color:#ffbb51;'></span> <?php echo __("The number of files scanned:","wpinfecscan");?> <?php echo __("The number of malwares detected:","wpinfecscan");?></h4>
                    </div>
                    <small><?php echo __("Inspecting files/database that have changed contents or have passed for a certain period since the last inspection.",'wpinfecscan'); ?><br><?php echo __("Make sure to read <a href='javascript:void(0);' onClick='showexptalert()'>this notifications </a>upon removal or deletion of malware files.",'wpinfecscan'); ?></small><br><br>
                    <script>
                    var scanend = false;
                    var infecfilecount = 0;
                    var startTime;
                    var oldscanendfilecount=0;
                    var samefilecount=0;
                    var scanlloptimeout;
                    function scanloop(){
                        startTime = new Date();
                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: "action=realtimerun",
                           success: function(msg){
                               var res = jQuery.parseJSON(msg);
                               
                               if(res.status.match(/doneok/) && scanend==false){
                                    var currentTime = new Date();
                                    var status = (currentTime - startTime);
                                    if(status>20000){
                                        scanloop();
                                    }else{
                                        scanlloptimeout=setTimeout("scanloop()",20000-status);
                                    }
                                }
                               
                               if(res.status=="error"){
                                   alert(res.d1);
                                   scanend = true;
                                   jQuery("#scanprogress").hide();
                                   document.getElementById("scank").innerHTML = "<?php echo __("Scanning completed!","wpinfecscan");?> ";
                               }
                           }
                         });     
                    }
                    
                    function getprocess(){  
                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: "starttime=<?php echo date("Y-m-d H:i:s", strtotime('-10 seconds', time())); ?>&action=getscanprocess",
                           success: function(msg){
                               
                               var res = jQuery.parseJSON(msg);
                               if(res==null){
                                   setTimeout(getprocess,20000);
                               }else{
                                   jQuery("#scanprocess").html(" <span class='dashicons dashicons-portfolio' style='font-size: 20px;color:#ffbb51;'></span> <?php echo __("The number of files scanned:","wpinfecscan");?>"+res.d1+" <?php echo __("The number of malwares detected:","wpinfecscan");?>"+res.d2);
                                   ///todo
                                   jQuery("#scanprocessdb").html(" <span class='dashicons dashicons-album' style='font-size: 20px;color:#aaa;'></span> <?php echo __("The number of database table scanned:","wpinfecscan");?>"+res.d4+" <?php echo __("The number of malwares detected on database:","wpinfecscan");?>"+res.d5);
                                   
                                   infecfilecount=res.d2+res.d5;
                                   if(res.d2>0 || res.d5>0){
                                       jQuery("#showinfectfiles").html(res.d6+res.d3);
                                   }
                                   if(oldscanendfilecount==res.d1+res.d4){
                                       samefilecount=samefilecount+1;
                                       if(samefilecount>2){
                                            scanend = true;
                                            document.getElementById("scank").innerHTML = "<?php echo __("Scanning completed!","wpinfecscan");?> ";
                                            
                                            if(parseInt(infecfilecount)==0){
                                                jQuery("#showinfectfiles").html("<?php 
                                                $hmatchurl = plugin_dir_url( __FILE__ )."images/noinfect.png";
                                                echo "<h4 style='margin-top:25px;margin-bottom:25px;'><img src='".$hmatchurl."' style='width:30px'> ".__("Not detected any malware in this website.","wpinfecscan")."</h4>";?>");
                                            }else{
                                                jQuery(".ikkatukujyo").show();
                                            }
                                            
                                            jQuery("#scanprogress").hide();
                                            
                                            clearTimeout(scanlloptimeout);
                                       }
                                   }else{
                                       oldscanendfilecount=res.d1+res.d4;
                                   }
                                   if(scanend==false){
                                        setTimeout(getprocess,15000);
                                   } 
                               }
                           }
                         });     
                    }
                    
                    jQuery(function(){
                            scanloop();   
                            getprocess();                                       
                    });
                    
                    </script>
                    <?php
                    
                    $modaltitleautodel = __("Automatic Restore",'wpinfecscan');
                    $modalbodyautodel = __("Replace the infected file with the same version of the file distributed from the official WordPress website. Files that do not exist in the official directory will be deleted. Database data and configuration files cannot be disinfected automatically. Please note that if you have customized the target files, the customized parts will be lost.","wpinfecscan");


                    echo '<table id="scanresult" class="table"><thead><tr><th nowrap>'.__("Type",'wpinfecscan').'</th><th>'.__("Detected",'wpinfecscan')."</th><th>".__("Pattern matching",'wpinfecscan')."</th><th>".__("Definitive diagnosis",'wpinfecscan').'</th><th nowrap>'.__("Manual Extermination",'wpinfecscan').'</th><th style="width:165px">'.__("Automatic Restore",'wpinfecscan').' <a href="javascript:void(0);" onclick="showinfomodal(\''.$modaltitleautodel.'\',\''.$modalbodyautodel.'\')"><span class="dashicons dashicons-editor-help"> </span></a></th></tr><tr class="ikkatukujyo"><td colspan="5"></td><td><button type="button" onclick="showikkatukujyo()" style="width:100%" class="btn btn-danger">'.__("Auto-restore all",'wpinfecscan').'</button></td></tr></thead>';
                    ?><tbody id="showinfectfiles"></tbody></table>
                    <?php
                } else {
                    
                    include_once('scannerdata/getscanprocess_inc2.php');

                }
            ?>
            <br><br>
        <small><?php _e("*Pattern matched signifies the file matches to malware in its characteristics, and definitive diagnosis signifies the file is judged as containing harmful code by detailed inspection.","wpinfecscan");?></small>
    </div>
</div>