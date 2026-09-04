<?php if ( ! defined( 'ABSPATH' ) ) {exit;} ?>

<style>.showq{word-break:break-all;max-width:200px !IMPORTANT;max-height:50px;overflow-x:auto;}
.activepage{font-weight:bold;text-decoration:none;color:#888}
td,th{padding-left:0px !important;}</style>

<div class="tab-pane" id="ContentF">
    
    <div class="col-lg-12">
    
        <?php 
         if(!empty($hackmonitorchanged_error)){
             echo "<p style='color:red'>".esc_html($hackmonitorchanged_error)."</p>";
         }
         ?>
    
        <h3><?php esc_html_e("Blocking IPs","wpinfecscan"); ?></h3>
        
        <p><?php esc_html_e("If you have inadvertently blocked your IP, please FTP to your server's HTACCESS file and delete #WPINFECBLOCKIP_START to #WPINFECBLOCKIP_END","wpinfecscan"); ?></p>
          
    
        <div style='width:100%;max-height:300px;overflow:auto;'>
          <div class="table-responsive">
          <table id="ipblocktable" style='width:100%' class='datashow table'>
                <tr>
                <th><?php esc_html_e("Blocked time","wpinfecscan"); ?></th>
                <th><?php esc_html_e("IP","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Block time limit","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Un block this IP","wpinfecscan"); ?></th>
                </tr>
                <?php
                
                $blockips = get_option( 'wpinfectscanner_blockip',"");
                if(! empty($blockips)){
                    $blockips = unserialize($blockips);
                    if(count($blockips)>0){
                        $blockips = array_reverse($blockips);
                        for( $i=0;$i<count($blockips);$i++) {
                            $blockip = $blockips[$i];
                            
                            $limit=$blockip[2];
                            if($limit!="Forever"){
                                $limit = date_i18n('Y-m-d H:i:s', strtotime($blockip[0].' +'.$limit));
                            }else{
                                $limit = "Unlimited";
                            }
                            
                            $ipblockbutton = "<button style='width:100%' class='ipb".esc_html(wpinfectscanner_base64_encode_removeeq($blockip[1]))." btn btn-success' onClick='blockthisip(\"".esc_html(base64_encode($blockip[1]))."\");'>".esc_html(__("Unblock","wpinfecscan"))."</button>";
                            
                            echo "<tr class='ipt".esc_html(wpinfectscanner_base64_encode_removeeq($blockip[1]))."'><td>".esc_html($blockip[0])."</td><td>".esc_html($blockip[1])."</td><td>".esc_html(__($limit,"wpinfecscan"))."</td><td>".$ipblockbutton."</td></tr>";
                        }
                    }
                }
                ?>
          </table>
          </div>
         </div>
         <?php
         if(empty($blockips)){
               echo "<h6 id='noipdata'><b style='color:#72e350'>".esc_html(__("No data found.","wpinfecscan"))."</b></h6>";
         }
         ?>
          
         <table class="form-table">
              <tbody><tr valign="top">
              
              <th scope="row"><?php _e("Block IPs manually","wpinfecscan");?></th>
              
              <td><input type="text" id="manualblockipblocksetting" name="manualblockipblocksetting" placeholder="111.222.333.444" style="width:100%"></td>
              
              <td> <button class='btn btn-danger' id="blockthisip_onebyonebt" onClick='blockthisip_onebyone();' style="width:100%"><?php echo esc_html(__("Block now","wpinfecscan"));?></button></td>
              
              </tr>
            </tbody>
        </table>
           
        <hr>
        
        <form method="post" action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
        
        <input type="hidden" id="ipblocksetting" name="ipblocksetting" value="1">
        
        <h3><?php _e("IP map of active hackers","wpinfecscan");?></h3>
        <p><?php _e("These IPs are of hackers around the world detected daily by WP doctor. This data is updated every 24 hours.","wpinfecscan");?></p>
        <p style="margin:20px 0px;"><input type="checkbox" class="proalert" name="autoblockip" id="ipblockcheckbox" value="1" <?php $autoblockipdata = get_option("wpinfectscanner_autoblockip");if(!empty($autoblockipdata )){ echo " checked='checked'";} ?>><?php _e("Block this IP automatically from access to the website (Paid)","wpinfecscan");?></p>
        
        <div style="width:100%;clear:both;">
        <style>
        @media only screen and (max-width: 650px) {
            .infecmapper{width:100% !important}
        }
        </style>
        <div id="container" class='infecmapper' style="position: relative;float:left; width: 650px; height: 300px;overflow:auto;margin-bottom:25px;">
        <table class="table">
        <tr><td><?php _e("Hacker's IP</td><td>country, region","wpinfecscan");?></td></tr>
        <?php
            $autoipblockok = true;
            if($scanner->getpro()!=1){
                $autoipblockok = false;
            }
            $flagurl = plugin_dir_url( __FILE__ ).'images/worldicon/';
            if(!empty($ipblockdata)){
                foreach ($ipblockdata as $key => $value){
                    echo "<tr><td>".$value->ip."</td><td><img src='".$flagurl.strtoupper ($value->country).".png'> ".$value->country_name." ,".$value->city."</td></tr>";
                }
            }
        ?>
        </table>
        </div>
        
        <div style="position: relative;float:left; width: 300px; height: 300px;margin-bottom:25px;overflow:hidden;">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <div id="piechart"></div>
        <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        <?php
        $carray = array();
        foreach ($ipblockdata as $key => $value){
            $num =  1;
            if(!empty($carray[$value->country_name])){
                $num =  $carray[$value->country_name]+1;
            }
            $carray[$value->country_name] = $num;
        }
        $clarray = array();
        $clarray["Other"] = 0;
        foreach ($carray as $key => $value){
            if($value>4){
                $clarray[$key]=$value;
            }else{
                $clarray["Other"]+=$value;
            }
        }
        ?>
        function drawChart() {
            var data = google.visualization.arrayToDataTable([ //グラフデータの指定
                ['Country', 'detect ip count'],
                <?php 
                foreach ($clarray as $key => $value){
                    echo "['".$key."',     ".$value."],";
                }
                ?>
            ]);
            data.sort([{column: 1}]);
            var options = {
                       'width': 400,
                       'height': 400,
                       'chartArea':{left:20,top:20,width:"400px",height:"400px"},
                       'pieSliceText': 'label',
                       'legend': {'position': 'none'}
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart')); //グラフを表示させる要素の指定
            chart.draw(data, options);
        }
        </script>
        </div>
        
        <div style="width:100%;clear:both;"> </div>
        </div>

        <hr>
        
        <div style="width:100%;clear:both;">

        <h3><?php _e("Hack monitor & Auto IP blocker","wpinfecscan");?></h3>
          
          <p><?php esc_html_e("Enabling this feature will detect and log hackers' attacks against your site. You can also block hacker IPs from this log. Keep in mind that hackers attack WordPress sites at random, so a logged attack does not necessarily mean that the hack was successful.","wpinfecscan"); ?></p>
          
            <table class="form-table">
              <tr valign="top">
              <td><input type="checkbox" name="wpinfectscanner_hackmonitor" value="1" <?php if($setting_hackmonitor==1){echo 'checked="checked"';} ?>/></td>
              <td scope="row"><?php esc_html_e("Enable Hack Monitor","wpinfecscan"); ?></td>
              <td scope="row"><?php esc_html_e("Number of logs to be stored","wpinfecscan"); ?></td>
              <td><select name="wpinfectscanner_hackmonitor_logcount" style="width:100%" autocomplete="off"/>
              <?php
              $settingarray = array("infinity",10000,5000,1000,500,255);
              for($i=0;$i<count($settingarray);$i++){
                  $select="";
                  if($setting_hackmonitor_logcount==$settingarray[$i]){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".esc_html($settingarray[$i])."' ".esc_html($select).">".__($settingarray[$i],"wpinfecscan")."</option>";
              }
              ?>
              </select>
              </td>
              </tr>
              
              <tr valign="top">
              <td colspan=4><?php esc_html_e("Notice:In many cases, a one-hour block is sufficient because hackers change their attack target to the next site as soon as they fail.","wpinfecscan"); ?></td>
              </tr>
              
              <tr valign="top">
              <td><input type="checkbox" class="proalert" name="wpinfectscanner_autoblock_valunarability_attack" value="1" <?php if($wpinfectscanner_autoblock_valunarability_attack==1){echo 'checked="checked"';} ?>/></td>
              <td scope="row"><?php esc_html_e("Automatic blocking of IPs of detected vulnerability attacks (paid)","wpinfecscan"); ?></td>
              <td scope="row"><?php esc_html_e("Block length","wpinfecscan"); ?></td>
              <td><select name="wpinfectscanner_autoblock_valunarability_attack_length" style="width:100%" autocomplete="off"/>
              <?php
              $settingarray = array("1hour","24hour","Forever");
              for($i=0;$i<count($settingarray);$i++){
                  $select="";
                  if($wpinfectscanner_autoblock_valunarability_attack_length==$settingarray[$i]){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".esc_html($settingarray[$i])."' ".esc_html($select).">".__($settingarray[$i],"wpinfecscan")."</option>";
              }
              ?>
              </select>
              </td>
              </tr>
              
              <tr valign="top">
              <td><input type="checkbox" class="proalert" name="wpinfectscanner_autoblock_wpscan_attack" value="1" <?php if($wpinfectscanner_autoblock_wpscan_attack==1){echo 'checked="checked"';} ?>/></td>
              <td scope="row"><?php esc_html_e("Automatic blocking of detected WPSCAN IPs (paid)","wpinfecscan"); ?></td>
              <td scope="row"><?php esc_html_e("Block length","wpinfecscan"); ?></td>
              <td><select name="wpinfectscanner_autoblock_wpscan_attack_length" style="width:100%" autocomplete="off"/>
              <?php
              $settingarray = array("1hour","24hour","Forever");
              for($i=0;$i<count($settingarray);$i++){
                  $select="";
                  if($wpinfectscanner_autoblock_wpscan_attack_length==$settingarray[$i]){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".esc_html($settingarray[$i])."' ".esc_html($select).">".__($settingarray[$i],"wpinfecscan")."</option>";
              }
              ?>
              </select>
              </td>
              </tr>
              
              <tr valign="top">
              <td><input type="checkbox" class="proalert" name="wpinfectscanner_autoblock_bruteforth_attack" value="1" <?php if($wpinfectscanner_autoblock_bruteforth_attack==1){echo 'checked="checked"';} ?>/></td>
              <td scope="row"><?php esc_html_e("Automatic blocking of detected brute force attack IPs (paid)","wpinfecscan"); ?></td>
              <td scope="row"><?php esc_html_e("Block length","wpinfecscan"); ?></td>
              <td><select name="wpinfectscanner_autoblock_bruteforth_attack_length" style="width:100%" autocomplete="off"/>
              <?php
              $settingarray = array("1hour","24hour","Forever");
              for($i=0;$i<count($settingarray);$i++){
                  $select="";
                  if($wpinfectscanner_autoblock_bruteforth_attack_length==$settingarray[$i]){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".esc_html($settingarray[$i])."' ".esc_html($select).">".__($settingarray[$i],"wpinfecscan")."</option>";
              }
              ?>
              </select>
              </td>
              </tr>
			  
			  <tr valign="top">
              <td><input type="checkbox" class="proalert" name="wpinfectscanner_autoblock_cookie_attack" value="1" <?php if($wpinfectscanner_autoblock_cookie_attack==1){echo 'checked="checked"';} ?>/></td>
              <td scope="row"><?php esc_html_e("Automatic blocking of detected malicious cookie attack IPs (paid)","wpinfecscan"); ?></td>
              <td scope="row"><?php esc_html_e("Block length","wpinfecscan"); ?></td>
              <td><select name="wpinfectscanner_autoblock_cookie_attack_length" style="width:100%" autocomplete="off"/>
              <?php
              $settingarray = array("1hour","24hour","Forever");
              for($i=0;$i<count($settingarray);$i++){
                  $select="";
                  if($wpinfectscanner_autoblock_cookie_attack_length==$settingarray[$i]){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".esc_html($settingarray[$i])."' ".esc_html($select).">".__($settingarray[$i],"wpinfecscan")."</option>";
              }
              ?>
              </select>
              </td>
              </tr>
              
            </table>
            <input type="hidden" name="settingname" value="hackmonitor"/>
            <div style="margin-top:25px;">
            <?php submit_button(); ?>
            </div>
          </form>
          
          </div>

          <hr>
          
          <div style="width:100%;clear:both;">
          <?php
          $limitcount = 30;
          ?>
          <h3><?php esc_html_e("Hack log","wpinfecscan"); ?></h3>
          <script>
          
          jQuery( ".proalert" ).on( "change", function() {
          <?php if($scanner->getpro()!=1){ ?>
            if(this.checked) {
                alert("<?php _e("This function is exclusive for subscription (paid) members of malware.","wpinfecscan");?>");
                jQuery(this).prop("checked", false);
            }
            <?php } ?>
          } );
          
          function b64DecodeUnicode(str) {
                // Going backwards: from bytestream, to percent-encoding, to original string.
                return decodeURIComponent(atob(str).split('').map(function(c) {
                    return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
                }).join(''));
            }
          function changepage(page){
              jQuery.ajax({
                   type: "POST",
                   url: "<?php echo esc_attr(admin_url( 'admin-ajax.php')); ?>",
                   data: "action=wpinfectscanner_changepage&nonce=<?php echo esc_attr(wp_create_nonce('wpinfecscan'));////edited2 ?>&pcount=<?php echo esc_attr($limitcount); ?>&page="+page,
                   success: function(msg){
                       //alert(msg);
                       if(msg!="error"){
                            jQuery("#hacktable tr:gt(0)").remove();
                            jQuery('#hacktable tr:last').after(b64DecodeUnicode(msg));
                            jQuery('.activepage').removeClass('activepage');
                            var pname = page-1;
                            jQuery('#hp'+pname).addClass('activepage');
                       }
                   }
              });
          }
          function blockthisip_onebyone(){
              var bip = jQuery.trim(jQuery("#manualblockipblocksetting").val());
              
              if(bip.length>7){
                  jQuery("#blockthisip_onebyonebt").prop("disabled",true);
                  var mode=1;
                  var ip = btoa(bip);
                  
                  var classnameip = ip.replaceAll("=", "");
                  jQuery.ajax({
                       type: "POST",
                       url: "<?php echo esc_url(admin_url( 'admin-ajax.php')); ?>",
                       data: "action=wpinfectscanner_blockip&ip="+ip+"&mode="+mode+"&limit=Forever",
                       success: function(msg){
                           jQuery(".ipb"+classnameip).prop("disabled",false);
                           if(msg==1){
                                var el = jQuery(".ipb"+classnameip);
                                el.addClass('btn-success');
                                el.removeClass('btn-danger');
                                el.html("<?php esc_html_e("Unblock","wpinfecscan"); ?>");
                                
                                var ipblockbutton = "<button style='width:100%' class='ipb"+classnameip+" btn btn-success' onClick='blockthisip(\""+ip+"\");'><?php echo esc_html(__("Unblock","wpinfecscan"));?></button>";
                                
                                jQuery('#ipblocktable tr:first').after('<tr class="ipt'+classnameip+'"><td>Now</td><td>'+ atob(ip)+'</td><td><?php echo esc_html(__("Unlimited","wpinfecscan"));?></td><td>'+ipblockbutton+'</td></tr>');
                                jQuery('#noipdata').remove();
                                
                                jQuery("#manualblockipblocksetting").val("");
                           }else{
                               if(msg==-1){
                                   alert("<?php esc_html_e("Block failed, does the HTACCESS file exist and is it writable permissions? Or did you enter the correct IP?","wpinfecscan"); ?>");
                               }else{
                                   
                                   var el = jQuery(".ipb"+classnameip);
                                   el.addClass('btn-danger');
                                   el.removeClass('btn-success');
                                   el.html("<?php esc_html_e("Block now","wpinfecscan"); ?>");
                                   
                                   jQuery('#ipblocktable .ipt'+classnameip).remove();
                               }
                           }
                           
                           jQuery("#blockthisip_onebyonebt").prop("disabled",false);
                       }
                  });
              }
          }
          function blockthisip(ip){
              
              var classnameip = ip.replaceAll("=", "");
              jQuery(".ipb"+classnameip).prop("disabled",true);
              var mode=1;
              if(jQuery(".ipb"+classnameip).hasClass( "btn-success" )){
                  mode=0;
              }
              //alert(mode);
              jQuery.ajax({
                   type: "POST",
                   url: "<?php echo esc_url(admin_url( 'admin-ajax.php')); ?>",
                   data: "action=wpinfectscanner_blockip&ip="+ip+"&mode="+mode+"&limit=Forever",
                   success: function(msg){
                       jQuery(".ipb"+classnameip).prop("disabled",false);
                       if(msg==1){
                            var el = jQuery(".ipb"+classnameip);
                            el.addClass('btn-success');
                            el.removeClass('btn-danger');
                            el.html("<?php esc_html_e("Unblock","wpinfecscan"); ?>");
                            
                            var ipblockbutton = "<button style='width:100%' class='ipb"+classnameip+" btn btn-success' onClick='blockthisip(\""+ip+"\");'><?php echo esc_html(__("Unblock","wpinfecscan"));?></button>";
                            
                            jQuery('#ipblocktable tr:first').after('<tr class="ipt'+classnameip+'"><td>Now</td><td>'+ atob(ip)+'</td><td><?php echo esc_html(__("Unlimited","wpinfecscan"));?></td><td>'+ipblockbutton+'</td></tr>');
                            jQuery('#noipdata').remove();
                       }else{
                           if(msg==-1){
                               alert("<?php esc_html_e("Block failed, does the HTACCESS file exist and is it writable permissions?","wpinfecscan"); ?>");
                           }else{
                               
                               var el = jQuery(".ipb"+classnameip);
                               el.addClass('btn-danger');
                               el.removeClass('btn-success');
                               el.html("<?php esc_html_e("Block now","wpinfecscan"); ?>");
                               
                               jQuery('#ipblocktable .ipt'+classnameip).remove();
                           }
                       }
                   }
              });
          }
          </script>
          <?php 
            global $wpdb;
                
            $table_name = $wpdb->prefix . 'infectscannernfblock';
            
            $query = $wpdb->prepare("SHOW TABLES LIKE %s",$table_name);
            if($wpdb->get_var($query) != $table_name) {
                $secfunc=new WPInfectSecurity();
                $secfunc->wpinfectscan_db404install();
            }else{
                if(get_option( 'wpinfectscan_nfblock_version')!="2.0"){
                    $secfunc=new WPInfectSecurity();
                    $secfunc->wpinfectscan_db404install();
                }
            }
            
            $nfblockres = false;
            $nfblockres_num_rows = 0;
            
            if($wpdb->get_var($query) == $table_name) {
                $query =  $wpdb->prepare("SELECT * FROM `%1s` ORDER BY lastdetect DESC limit %d",$table_name,$limitcount);
                
                $nfblockres = $wpdb->get_results($query);
                
                $query =  $wpdb->prepare("SELECT COUNT(*) FROM `%1s`",$table_name);
                $nfblockres_num_rows = $wpdb->get_var($query);
            }
            
            if($nfblockres_num_rows>$limitcount){
                echo "<div style='padding:20px 7px'>Page: ";
                for($i=0;$i<ceil($nfblockres_num_rows/$limitcount);$i++){
                    $active = "";
                    if($i==0){
                        $active = "activepage";
                    }
                    echo " <a id='hp".esc_html($i)."' class='".esc_html($active)."' href='javascript:void(0);' onCLick='changepage(".esc_html($i+1).")'>".esc_html($i+1)."</a> ";
                }
                echo "</div>";
            }
          ?>
          <div class="table-responsive">
          <style> #hacktable{word-break:break-all !important;}#hacktable td{min-width:90px;max-width:270px;}</style>
          <table style='width:100%' class='datashow table' id="hacktable">
                <tr>
                <th><?php esc_html_e("Detect time","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Hacking type","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Hacker's IP(Check Abuse IP)","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Accessed file","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Query","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Hack count","wpinfecscan"); ?></th>
                <th><?php esc_html_e("Block this IP","wpinfecscan"); ?></th>
                </tr>
                <?php
                
                if($nfblockres){
                    foreach( $nfblockres as $key => $row) {
                        $ip = $row->ipv4;
                        if(empty($ip)){
                            $ip = $row->ipv6;
                        }
                        $accessedfile= $row->filepath.$row->filename;
                        $accessedfile=str_replace('//','/',$accessedfile);
                        $detecttime = $row->lastdetect;
                        $hacktype = $row->hacktype;
                        
                        if(empty($hacktype)){
                            $hacktype = "NA";
                        }
                        
                        $getdata = $row->getquery;
                        $postdata = $row->postquery;
                        $showquery = $getdata;
                        if(strlen($postdata)>1){
                            $showquery = $postdata;
                        }
                        //$showquery=print_r(json_decode($showquery, true), TRUE);
                        $showquery=str_replace('"','',$showquery);
                        $showquery=str_replace('{','',$showquery);
                        $showquery=str_replace('}','',$showquery);
                        $showquery=str_replace(':','=',$showquery);
                        $showquery = htmlspecialchars (mb_strimwidth($showquery, 0, 200, '...'));
                        
                        $detectcount = $row->detectcount;
                        
                        $ipblockbutton = "<button class='ipb".esc_html(wpinfectscanner_base64_encode_removeeq($ip))." btn btn-danger' onClick='blockthisip(\"".esc_html(base64_encode($ip))."\");'>".esc_html(__("Block now","wpinfecscan"))."</button>";
                        if(! empty($blockips)){
                            for( $i=0;$i<count($blockips);$i++) {
                                $blockip = $blockips[$i];
                                if($blockip[1]==$ip){
                                    $ipblockbutton = "<button class='ipb".esc_html(wpinfectscanner_base64_encode_removeeq($ip))." btn btn-success' onClick='blockthisip(\"".esc_html(base64_encode($ip))."\");'>".esc_html(__("Unblock","wpinfecscan"))."</button>";
                                    break;
                                }
                            }
                        }
                        
                        //var_dump($row);
                        
                        if(! empty($row->autoblocklimit)){
                            $ipblockbutton .= "<small style='font-color:red'><br>".__("This Ip was auto blocked <br>till","wpinfecscan")."".$row->autoblocklimit."</small>";
                        }
                    
                        echo "<tr><td>".esc_html($detecttime)."</td><td>".__($hacktype,"wpinfecscan")."</td><td><a href='https://www.abuseipdb.com/check/".esc_html($ip)."' target='_blank'>".esc_html($ip)."</a></td><td>".esc_html($accessedfile)."</td><td class='showq'>".esc_html($showquery)."</td><td nowrap>".esc_html($detectcount)."</td><td nowrap>".$ipblockbutton."</td></tr>";
                    }
                }
                ?>
          </table>
          </div>
          <?php
           if($nfblockres){}else{
               echo "<h6><b style='color:#72e350'>".esc_html(__("No data found.","wpinfecscan"))."</b></h6>";
           }
          ?>
          </div>
    </div>
</div>