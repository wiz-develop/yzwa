<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<div class="tab-pane" id="ContentG">
    <div class="col-lg-12">
        <?php
        
        if($showhtaccesserror){
            echo "<p style='color:red'><b><span class='dashicons dashicons-warning'></span> ".$htaccess_file.__("Unable to activate most of the security functions because of no permission to write the file. Please access again after conferred write permission on the file with using FTP.","wpinfecscan")."</b><br></p>";
        }

        ?>
        <?php
        
        if ($showhtaccessdoubleerror) {
            echo "<p style='color:red'><b><span class='dashicons dashicons-warning'></span> ".__("There are 2 htaccess files in wordpress root folder and wordpress home folder. We recommend to delete root folder htaccess file to work security functions properly. <br>Delete this file:","wpinfecscan").$htaccess_file2."</b><br></p>";
        }

        ?>

        <h3><span class="dashicons dashicons-lock" style="font-size: 30px;color:#f52157;"></span>   <?php _e("Real-time block of website tampering","wpinfecscan");?></h3>
        <p><?php _e("This feature greatly reduces the possibility of tampering or malware infection with two algorithms that protect against hacker attacks before they occur<br>1 Blocks the patterns of the most commonly hacked files on the Internet for the past month.<br>2 Detects unauthorized access to programs directly in files other than those listed above, performs malware scanning, and blocks access if malware code patterns are included.<br>*This feature blocks the operation of vulnerable plug-ins and themes, and may interfere with some of their functions.<br>","wpinfecscan");?></p>
        
        <?php 
        $attackpattern = $scanner->getattackpattern(true);
        if(! empty($attackpattern)){
        $attackpattern = array_reverse($attackpattern);
        ?>
        <div style="height:180px;overflow:auto;margin-bottom:25px;border:solid 0px #eee">
            <div style="padding-top:5px;">
            
                <h5><span class="dashicons dashicons-pressthis"></span><b> <?php 
                _e("Top 10 most attacked files now","wpinfecscan");
                $attackpatternnumdate=$scanner->getattackpatternnumdate();
                $updatedate = explode(" ",$attackpatternnumdate[1]);
                echo " (".__("Last update ",'wpinfecscan')." ".$updatedate[0].")";
                ?></b></h5>
                <p style="color:blue"><?php echo sprintf(__("When this feature is enabled, %s other attack patterns will be blocked.",'wpinfecscan'), $attackpatternnumdate[0]); ?></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php _e("Attacked vulnerability type","wpinfecscan");?></th>
                            <th><?php _e("File name","wpinfecscan");?></th>
                            <th><?php _e("Ajax action","wpinfecscan");?></th>
                            <th><?php _e("Attack Frequency","wpinfecscan");?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($attackpattern as $key => $value) {
                    $filename = basename($key);
                    $action = "";
                    $arr = explode("?action=",$filename);
                    $atype = "Other";
                    if(count($arr)==2){
                        $filename = $arr[0];
                        $action = $arr[1];
                        $atype = "Theme or Plugin";
                    }else{
                        if(strpos($key,'plugins') !== false){
                            $atype = "Plugin";
                        }
                        if(strpos($key,'themes') !== false){
                            $atype = "Theme";
                        }
                    }
                    ?>
                    <tr>
                        <td><b><?php _e($atype,"wpinfecscan");?></b></td>
                        <td>/*****/<b><?php echo $filename;?></b></td>
                        <td><?php echo $action;?></td>
                        <td><b style='color:red'><?php _e("<b style='color:red'>High</b>","wpinfecscan");?></b></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>                                
            </div>
        </div>
        <?php } ?>
        <br>
        <form method="post" action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
        <?php echo $setting_realtimeblock_error; ?>
        <input type="checkbox" name="setting_realtimeblock" value="1" id="realtimeblockcheckbox" onchange="selectrealtimeblock()" <?php if(get_option('wpinfectscanner_realtimeblock')==1){echo " checked='checked'";} ?>> <?php _e("Enable function (Paid)","wpinfecscan");?>
        <input type="hidden" name="setting_realtimeblock_ht" value="1">
        <?php submit_button(); ?>
        </form>
        <script>
        function selectrealtimeblock(){
            <?php if($autoipblockok==false){ ?>
            if(document.getElementById("realtimeblockcheckbox").checked){
                alert("<?php _e("This function is exclusive for subscription (paid) members of malware.","wpinfecscan");?>");
                document.getElementById("realtimeblockcheckbox").checked = false;
            }
            <?php } ?>
        }
        </script>
        <hr>
        <h4><b><?php _e("Real-time block history","wpinfecscan");?></b></h4>
        <p><?php _e("It displays a record of up to 255 hacks blocked by the real-time blocking function of the plugin.","wpinfecscan");?></p>
        <br>
        <table id="scanresult" class="table">
        <thead><tr><th><?php _e("Blocked date and time","wpinfecscan");?></th><th><?php _e("Hacker's IP","wpinfecscan");?></th><th><?php _e("Files accessed by hacker","wpinfecscan");?></th><th nowrap=""><?php _e("Details of sent information","wpinfecscan");?></th></tr></thead>
        <tbody>
        <?php
        $kirokfound = false;
        $table_name = $wpdb->prefix . 'infectscannerrealtimeblock';
        if($wpdb->get_var("SHOW TABLES LIKE '".$table_name."'") == $table_name) {
            $table_name = $wpdb->prefix . 'infectscannerrealtimeblock';
            $query = "SELECT * FROM ".$table_name." ORDER BY `adddate` DESC limit 255";
            $rowsfiles = $wpdb->get_results($query);

            foreach ($rowsfiles as $row) {
                $kirokfound = true;
                echo "<tr>";
                echo "<td>".get_date_from_gmt($row->adddate,"Y-m-d H:i:s")."</td>";
                echo "<td>".$row->ipv4.$row->ipv6."</b></td>";
                echo "<td>".$row->filepath."<b>".$row->filename."</b></td>";
                $data="";
                if(!empty($row->postquery)){
                    $data .= htmlentities(print_r(json_decode($row->postquery),true));
                }
                if(!empty($row->getquery)){
                    $data .= htmlentities(print_r(json_decode($row->getquery),true));
                }
                echo "<td><div style='height:130px;width:450px;overflow:auto;'><pre>".$data."</pre></div></td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
        </table>
        <?php if($kirokfound==false){ ?>
        <h5 style="margin-top:25px;margin-bottom:25px;color:#888"><?php _e("*No record of real-time block found","wpinfecscan");?></h5>
        <?php }else{ ?>
        <button onClick="location.href='<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&delrealtime=1'"><?php _e("Delete all records","wpinfecscan");?></button>
        <?php }  ?>
    </div>
</div>