<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<div class="tab-pane" id="ContentB">
    <div class="col-lg-12">
          <form method="post" action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
            <table class="form-table">
              <tr valign="top">
              <th scope="row"><?php _e("Scan malware automatically","wpinfecscan"); ?></th>
              <td><input type="checkbox" name="wpinfectscanner_cron_autoscan_info" value="1" <?php if($setting_autoscan==1){echo 'checked="checked"';} ?>/></td>
              <th scope="row"><?php _e("Beginning time of auto scanning","wpinfecscan"); ?></th>
              <td><select name="wpinfectscanner_cron_starttime_info" autocomplete="off"/>
              <?php
              for($i=0;$i<22;$i++){
                  $select="";
                  if($setting_autoscantime==$i){
                      $select=" selected='selected'";
                  }
                  echo "<option value='".$i."' ".$select.">".$i." ".__("O'Clock","wpinfecscan")."</option>";
              }
              ?>
              </select>
              
              </td>
              </tr>
              
              <tr valign="top">
              <th scope="row"><?php _e("Scan vulnerability automatically(Paid)","wpinfecscan"); ?></th>
              <script>
              function selectautovulncheck(){
                    <?php if($scanner->getpro() != 1){ ?>
                    if(document.getElementById("vulautoscaninfocheckbox").checked){
                        alert("<?php _e("This function is exclusive for subscription (paid) members of malware.","wpinfecscan");?>");
                        document.getElementById("vulautoscaninfocheckbox").checked = false;
                    }
                    <?php } ?>
              }
              </script>
              <td><input type="checkbox" onchange="selectautovulncheck()" name="wpinfectscanner_cron_vulautoscan_info" id="vulautoscaninfocheckbox" value="1" <?php if($setting_vulautoscan==1){echo 'checked="checked"';} ?>/></td>
              </td>
              <td>
              </td>
              </tr>
              
              <tr valign="top">
              <th scope="row"><?php _e("Notify by e-mail upon detection","wpinfecscan");?></th>
              <td><input type="checkbox" name="wpinfectscanner_cron_mailsend_info" value="1" <?php if($setting_email==1){echo 'checked="checked"';} ?> /></td>
              <th scope="row"><?php _e("E-mail address","wpinfecscan");?></th>
              <td><input type="text" name="wpinfectscanner_cron_mailaddr_info" value="<?php echo $setting_emailaddr; ?>" /></td>
              </tr>
              
              <tr valign="top">
              <th scope="row"><?php _e("Hide detection alert on the administration display","wpinfecscan");?></th>
              <td><input type="checkbox" name="wpinfectscanner_hidealert_info" value="1" <?php if($setting_hidealert==1){echo 'checked="checked"';} ?> /></td>
              <th scope="row"></th>
              <td></td>
              </tr>
            </table>
           <input type="hidden" name="settingname" value="setting"/>
            <?php submit_button(); ?>
            <small><?php _e("*E-mail notification is only once in 24 hours even if detected multiple times.","wpinfecscan");?></small><br>
            <small><?php _e("*The beginning time of auto scanning may be different when using WordPress cron.","wpinfecscan");?></small>
          </form>
    </div>
</div>