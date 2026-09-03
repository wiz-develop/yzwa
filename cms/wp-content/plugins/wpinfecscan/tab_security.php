<?php if ( ! defined( 'ABSPATH' ) ) {exit;}?>
<div class="tab-pane" id="ContentE">       
    <div class="col-lg-12">
    
        <?php
        
        $showhtaccesserror = false;
        $home_path = wpinfecscanget_home_path();
        $htaccess_file = $home_path.'.htaccess';
        if (! file_exists($htaccess_file)) {
            @file_put_contents($htaccess_file, "" , FILE_APPEND);
            if(! is_writable($htaccess_file)){
                @chmod($htaccess_file, 0644);
            }
        }
        
        //2023 01 18 deleted
        //if(! is_writable($htaccess_file)){
            //@chmod($htaccess_file, 0644);
        //}
        
        //2023 08 03 deleted
        //if(! is_writable($htaccess_file)){
            //$showhtaccesserror = true;
            //echo "<p style='color:red'><b><span class='dashicons dashicons-warning'></span> ".$htaccess_file.__("Unable to activate most of the security functions because of no permission to write the file. Please access again after conferred write permission on the file with using FTP.","wpinfecscan")."</b><br></p>";
        //}

        ?>
        
        <?php
        
        $showhtaccessdoubleerror = false;
        $thiswpinfechomepath = wpinfecscanget_home_path();
        $home_path = str_replace('\\', '/',$thiswpinfechomepath);
        $home_path2 = str_replace('\\', '/',ABSPATH);
        $htaccess_file = $home_path.'.htaccess';
        $htaccess_file2 = $home_path2.'.htaccess';
        if ($home_path != $home_path2 && file_exists($htaccess_file) && file_exists($htaccess_file2)) {
            $showhtaccessdoubleerror = true;
            echo "<p style='color:red'><b><span class='dashicons dashicons-warning'></span> ".__("There are 2 htaccess files in wordpress root folder and wordpress home folder. We recommend to delete root folder htaccess file to work security functions properly. <br>Delete this file:","wpinfecscan").$htaccess_file2."</b><br></p>";
        }

        ?>
        
        <?php if($totalscore>=0 && $totalscore<40){ ?>
        <h3><?php _e("Security score","wpinfecscan");?> <?php echo $totalscore; ?> <?php _e("Points (Risk level High)","wpinfecscan");?></h3>
        <p><?php _e("Security measures are required","wpinfecscan");?></p>
        <div class="progress" id="scanprogress">
          <div class="progress-bar progress-bar-danger" role="progressbar"
          aria-valuenow="<?php echo $totalscore; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $totalscore; ?>%">
            &nbsp;&nbsp;<?php echo $totalscore; ?>/100
          </div>
        </div> 
        <?php } ?>
        <?php if($totalscore>=40 && $totalscore<80){ ?>
        <h3><?php _e("Security score","wpinfecscan");?> <?php echo $totalscore; ?> <?php _e("Points","wpinfecscan");?></h3>
        <div class="progress" id="scanprogress">
          <div class="progress-bar progress-bar-warning" role="progressbar"
          aria-valuenow="<?php echo $totalscore; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $totalscore; ?>%">
            &nbsp;&nbsp;<?php echo $totalscore; ?>/100
          </div>
        </div> 
        <?php } ?>
        <?php if($totalscore>=80 && $totalscore<101){ ?>
        <h3><?php _e("Security score","wpinfecscan");?> <?php echo $totalscore; ?> <?php _e("Points","wpinfecscan");?></h3>
        <div class="progress" id="scanprogress">
          <div class="progress-bar progress-bar-info" role="progressbar"
          aria-valuenow="<?php echo $totalscore; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $totalscore; ?>%">
            &nbsp;&nbsp;<?php echo $totalscore; ?>/100
          </div>
        </div> 
        <?php } ?>
        
        <form method="post" action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
            <style>
            .securityexp{
                width:100%;
                box-sizing: border-box;
                padding:20px;
                border:1px solid #ccc;
                border-radius: 3px;
                box-shadow: 0 1px 5px rgba(0, 0, 0, 0.10);
            }
            </style>
            <div id="lightsetting">
                <h3 style="font-size:22px"><span class="dashicons dashicons-admin-generic" style="font-size: 28px;color:#0ed39d;"></span>&nbsp;&nbsp;<?php _e("Security measures","wpinfecscan");?></h3>
                <p style="font-size:14px"><?php _e("Settings of security functions to protect login and files, to prevent brute-force attack and spam, etc. Move to<b>detailed</b>settings to activate each function individually.","wpinfecscan");?></p>
                <hr>
                <small style="color:#888"><?php _e("*Higher security settings may interfere with site operations when the website is equipped with several plugins or is customized.","wpinfecscan");?>
                <br>
                <?php _e("*Security function may not work appropriately on multi-site.","wpinfecscan");?></small><br>
                <p><?php echo $secerror; ?></p><br>
                <h4 style="line-height:25px;font-size:16px;">
                <input type="radio" name="kantansettei" value="0" <?php if($security_kantansettei==0){echo 'checked="checked"';} ?>><?php _e("Disable security functions","wpinfecscan");?></h4>
                <h4 style="line-height:25px;font-size:16px;">
                <input type="radio" name="kantansettei" value="1" <?php if($security_kantansettei==1){echo 'checked="checked"';} ?>><?php _e("Security level: Moderate","wpinfecscan");?></h4>
                
                <div class="securityexp" id="kantansetteiexp1" style="display:none;"><br>
                <?php _e("<b>Activated functions</b>: Login LockDown, Prevent information leak about WordPress version, Protect important files (htaccess, wp-config.php), Protect server information, Prohibit display of Index list, Prohibit WPSCAN, Prohibit Pingback,  Include file protection, Upload folder protection, Prevent brute-force attack, Prohibit comment posting via proxy, Prohibit comment posting by spambots","wpinfecscan");?><br><br>
                </div>
                
                <h4 style="line-height:25px;font-size:16px;">
                <input type="radio" name="kantansettei" value="2" <?php if($security_kantansettei==2){echo 'checked="checked"';} ?>><?php _e("Security level: High (Recommended)","wpinfecscan");?></h4>
                
                <div class="securityexp" id="kantansetteiexp2" style="display:none"><br><?php _e("<b>Activated functions</b>: Login LockDown, Login captcha, Password reset captcha, Prevent information leak about WordPress version, Protect important files (htaccess, wp-config.php), Protect server information, Block access to wlwmanifest.xml, Block malicious query, Protect author information, Prohibit display of Index list, Prohibit WPSCAN, Prohibit Pingback, Prevent brute-force attack, Prohibit Trace & Track, Include file protection, Upload folder protection, Block danger SQL query,  Prohibit comment posting via proxy, Comment form captcha, Prohibit comment posting by spambots, noindex & 404 if not found searchresult page","wpinfecscan");?><br><br>
                
                <script>
                var permissionchanging = false;
                var permissionchangesuccess = false;
                function collectdisplaypermissionalerttable(){
                    jQuery(".displaypermissionalert tbody tr").css("background-color", "#87CEFA");
                    jQuery(".displaypermissionalert2 tbody tr").css("background-color", "#87CEFA");
                    jQuery(".displaypermissionalert3 tbody tr").css("background-color", "#87CEFA");
                    jQuery('.displaypermissionalert tbody tr').each(function(i){
                        jQuery('td',this).eq(1).text("✓");
                    });
                    jQuery('.displaypermissionalert2 tbody tr').each(function(i){
                        jQuery('td',this).eq(1).text("✓");
                    });
                    jQuery('.displaypermissionalert3 tbody tr').each(function(i){
                        jQuery('td',this).eq(1).text("✓");
                    });
                }
                function setpermission(){
                    if(permissionchanging==false){
                        permissionchanging=true;
                        jQuery('.changepmt').val("<?php _e('Working...', "wpinfecscan") ?>");
                        
                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: {
                                "action": "ajaxcollectpermission",
                           },
                           success: function(msg){
                               //alert(msg);
                               if ( msg.indexOf('error:') == 0) {
                                   var errormessage = msg.replace("error:", "");
                                   alert(errormessage);
                                   jQuery('.changepmt').val("<?php _e("Correct permissions","wpinfecscan");?>");
                                   permissionchanging = false;
                                   jQuery(".displaypermissionalert").show();
                                   jQuery(".displaypermissionalert2").show();
                               }else{
                                   alert('<?php _e("Changed to optimal permissions!","wpinfecscan");?>');
                                   jQuery('.changepmt').val("<?php _e("Correct permissions","wpinfecscan");?>");
                                   permissionchanging = false;
                                   //jQuery(".displaypermissionalert").hide();
                                   //jQuery(".displaypermissionalert2").hide();
                                   collectdisplaypermissionalerttable();
                                   permissionchangesuccess = true;
                               }
                           }
                        });
                    }
                }
                </script>
                
                <p class="displaypermissionalert" style="display:none;color:#717171"><b><span class="dashicons dashicons-warning"></span><?php _e("To enhance the security level further, it is recommended to set properly the permissions in the rows displayed in red or yellow.","wpinfecscan");?></b></p>
                <table class="table displaypermissionalert" style="width:60%;display:none">
                    <thead>
                        <tr>
                            <th><?php _e('Files', "wpinfecscan") ?></th>
                            <th><?php _e('Current permission', "wpinfecscan") ?></th>
                            <th><?php _e('Recommended permission', "wpinfecscan") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $wp_config_file = ABSPATH . 'wp-config.php';
                        if(file_exists($wp_config_file)){
                            $wp_config_file = $wp_config_file;
                        }
                        else if (file_exists(dirname( ABSPATH ) . '/wp-config.php')){       
                            $wp_config_file = dirname( ABSPATH ) . '/wp-config.php';
                        }
                        
                        $files_and_dirs_to_check = array(
                            array('name'=>'/','path'=>ABSPATH,'permissions'=>'0755'),
                            array('name'=>'index.php','path'=>ABSPATH."index.php",'permissions'=>'0544'),
                            array('name'=>'wp-includes/','path'=>ABSPATH."wp-includes",'permissions'=>'0755'),
                            array('name'=>'.htaccess','path'=>ABSPATH.".htaccess",'permissions'=>'0644'),
                            array('name'=>'wp-admin/index.php','path'=>ABSPATH."wp-admin/index.php",'permissions'=>'0644'),
                            array('name'=>'wp-admin/js/','path'=>ABSPATH."wp-admin/js/",'permissions'=>'0755'),
                            array('name'=>'wp-content/themes/','path'=>ABSPATH."wp-content/themes",'permissions'=>'0755'),
                            array('name'=>'wp-content/plugins/','path'=>ABSPATH."wp-content/plugins",'permissions'=>'0755'),
                            array('name'=>'wp-admin/','path'=>ABSPATH."wp-admin",'permissions'=>'0755'),
                            array('name'=>'wp-content/','path'=>ABSPATH."wp-content",'permissions'=>'0755'),
                            array('name'=>'wp-content/index.php','path'=>ABSPATH."wp-content/index.php",'permissions'=>'0544'),
                            array('name'=>'wp-config.php','path'=>$wp_config_file,'permissions'=>'0644')
                        ); 
                        
                        $permissionneedfix=false;
                        foreach ($files_and_dirs_to_check as $file_or_dir)
                        {
                            $res=wpinfectsecurity_show_wp_filesystem_status($file_or_dir['name'],$file_or_dir['path'],$file_or_dir['permissions']);
                            if($res){
                                $permissionneedfix=true;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <input class="displaypermissionalert changepmt" type="button" onClick="setpermission()" value="<?php _e("Correct permissions","wpinfecscan");?>">
                </div>
                
                <h4 style="line-height:25px;font-size:16px;">
                <input type="radio" name="kantansettei" value="3" <?php if($security_kantansettei==3){echo 'checked="checked"';} ?>><?php _e("Security level: Highest","wpinfecscan");?></h4>
                
                <div class="securityexp" id="kantansetteiexp3" style="display:none"><br><?php _e("<b>Activated functions</b>: Login LockDown, Login captcha, Password reset captcha, Change login page URL, Prevent information leak about WordPress version, Protect important files (htaccess, wp-config.php), Protect server information, Block access to wlwmanifest.xml, Block malicious query, Protect author information, Prohibit display of Index list, Prohibit WPSCAN, Prohibit editing themes and plugins,Include file protection, Upload folder protection, Block danger SQL query, Prohibit Pingback, Prevent brute-force attack, Prohibit REST API, Prohibit Trace & Track, Prohibit comment posting via proxy, Comment form captcha, Prohibit comment posting by spambots, noindex & 404 if not found searchresult page","wpinfecscan");?><br><br>
                <p style="display:none;color:red" class="displaylogin"><b><?php _e("*The login URL will be changed as follows. Make sure to take a note so as not to forget.","wpinfecscan");?></b></p>
                <h4 class="displaylogin" style="display:none;"><?php
                    if ( get_option( 'permalink_structure' ) ) {
                        echo site_url( '/' ) ;
                    } else {
                        echo home_url( '/' ) . '?' ;
                    }
                    $changed = get_option( 'wpinfectscanner_loginurl');
                    echo "<span id='loginurlchanged'>";
                    if(!empty($changed)){
                        echo get_option( 'wpinfectscanner_loginurl');
                    }
                    echo "</span>";
                ?></h4>
                <p class="displaypermissionalert2" style="display:none;color:#717171"><br><b><span class="dashicons dashicons-warning"></span><?php _e("To enhance the security level further, it is recommended to set properly the permissions in the rows displayed in red or yellow.","wpinfecscan");?></b></p>
                <table class="table displaypermissionalert2" style="width:60%;display:none">
                    <thead>
                        <tr>
                            <th><?php _e('Files', "wpinfecscan") ?></th>
                            <th><?php _e('Current permission', "wpinfecscan") ?></th>
                            <th><?php _e('Recommended permission', "wpinfecscan") ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        $wp_config_file = ABSPATH . 'wp-config.php';
                        if(file_exists($wp_config_file)){
                            $wp_config_file = $wp_config_file;
                        }
                        else if (file_exists(dirname( ABSPATH ) . '/wp-config.php')){       
                            $wp_config_file = dirname( ABSPATH ) . '/wp-config.php';
                        }
                        
                        $files_and_dirs_to_check = array(
                            array('name'=>'/','path'=>ABSPATH,'permissions'=>'0755'),
                            array('name'=>'index.php','path'=>ABSPATH."index.php",'permissions'=>'0544'),
                            array('name'=>'wp-includes/','path'=>ABSPATH."wp-includes",'permissions'=>'0755'),
                            array('name'=>'.htaccess','path'=>ABSPATH.".htaccess",'permissions'=>'0644'),
                            array('name'=>'wp-admin/index.php','path'=>ABSPATH."wp-admin/index.php",'permissions'=>'0644'),
                            array('name'=>'wp-admin/js/','path'=>ABSPATH."wp-admin/js/",'permissions'=>'0755'),
                            array('name'=>'wp-content/themes/','path'=>ABSPATH."wp-content/themes",'permissions'=>'0755'),
                            array('name'=>'wp-content/plugins/','path'=>ABSPATH."wp-content/plugins",'permissions'=>'0755'),
                            array('name'=>'wp-admin/','path'=>ABSPATH."wp-admin",'permissions'=>'0755'),
                            array('name'=>'wp-content/','path'=>ABSPATH."wp-content",'permissions'=>'0755'),
                            array('name'=>'wp-content/index.php','path'=>ABSPATH."wp-content/index.php",'permissions'=>'0544'),
                            array('name'=>'wp-config.php','path'=>$wp_config_file,'permissions'=>'0644')
                        );
                        
                        $permissionneedfix=false;
                        foreach ($files_and_dirs_to_check as $file_or_dir)
                        {
                            $res=wpinfectsecurity_show_wp_filesystem_status($file_or_dir['name'],$file_or_dir['path'],$file_or_dir['permissions']);
                            if($res){
                                $permissionneedfix=true;
                            }
                        }
                        ?>
                    </tbody>
                </table>
                
                <input class="displaypermissionalert2 changepmt" type="button" onClick="setpermission()" value="<?php _e("Correct permissions","wpinfecscan");?>">
                
                </div>
                
                <h4 style="line-height:25px;font-size:16px;">
                <input type="radio" name="kantansettei" value="4" <?php if($security_kantansettei==4){echo 'checked="checked"';} ?>><?php _e("Security level: Detailed","wpinfecscan");?><br>
                </h4>
            </div>
            
            <div id="detainsetting" style="display:none">
              
                <table class="form-table table">
                
                  <tr valign="top">
                    <td scope="row" colspan="2" style="border-top:0px;"><h3><span class="dashicons dashicons-lock" style="font-size: 28px;color:#8cb1cf;"></span>&nbsp;&nbsp;<?php _e("Login protection","wpinfecscan");?></h3>
                    </td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_loginlockdown" value="1" <?php if($security_loginlockdown==1){echo 'checked="checked"';} ?> /> <?php _e("Login LockDown","wpinfecscan");?></th>
                    <td><small><?php _e("Blocks login for 10 minutes after 3 repeated login failures. This function can reduce the risk of hacker incursion by a brute-force attack on the login display.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_logincaptcha" value="1" <?php if($security_logincaptcha==1){echo 'checked="checked"';} ?> /> <?php _e("Login captcha","wpinfecscan");?>
                    </th>
                    <td><small><?php _e("Displays captcha on the login display. Adding questionnaire on the login display can reduce the risk of hacker incursion and prevent administrative rights from being deprived.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_pwresetcaptcha" value="1" <?php if($security_pwresetcaptcha==1){echo 'checked="checked"';} ?> /> <?php _e("Password reset captcha","wpinfecscan");?></th>
                    <td><small><?php _e("Displays captcha on the password reset display to prevent hacking that utilizes fragility of mail transmission program on the display.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_loginchange" value="1" <?php if($security_loginchange==1){echo 'checked="checked"';} ?> /> <?php _e("Change login page URL","wpinfecscan");?><br>
                    <?php _e("Changed URL","wpinfecscan");?> <?php
                    if ( get_option( 'permalink_structure' ) ) {
                        echo site_url( '/' ) ;
                    } else {
                        echo home_url( '/' ) . '?' ;
                    }
                    ?>
                    <input type="text" name="wpinfectscanner_security_loginchangeurl" value="<?php echo get_option( 'wpinfectscanner_loginurl');?>" /><br>
                    <small style="font-weight:normal;"><?php _e("<span style='color:red'>Please make sure to take a note of the login URL</span> so as not to forget when changing it.","wpinfecscan");?></small>
                    </th>
                    <td><small><?php _e("Prevents hackers from accessing the login page by changing the login page URL.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <td scope="row" colspan="2"><br><h3><span class="dashicons dashicons-shield" style="font-size: 28px;color:#69b981;"></span>&nbsp;&nbsp;<?php _e("Protect WordPress information and files","wpinfecscan");?></h3></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_wphideversion" value="1" <?php if($security_wphideversion==1){echo 'checked="checked"';} ?>  /> <?php _e("Prevent information leak about WordPress version","wpinfecscan");?></th>
                    <td><small><?php _e("Hackers try to find out WordPress version to utilize the fragility. Hides the information by disabling meta generator output and query (numeric variable of the version which is given to CSS or JS read into HTML).","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_filehogo" value="1" <?php if($security_filehogo==1){echo 'checked="checked"';} ?> /> <?php _e("Protect important files","wpinfecscan");?></th>
                    <td><small> <?php _e("Prevents any access to htaccess and wp-config.php","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_serverhogo" value="1" <?php if($security_serverhogo==1){echo 'checked="checked"';} ?> /> <?php _e("Protect server information","wpinfecscan");?></th>
                    <td><small> <?php _e("Prevents any access to readme.html, license.txt and wp-config-sample.php which consist WordPress or plugins and may contain version or server information. Also restricts server signature which outputs server information.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_blockwlwmanifest" value="1" <?php if($security_blockwlwmanifest==1){echo 'checked="checked"';} ?> /> <?php _e("Block access to wlwmanifest.xml.","wpinfecscan");?></th>
                    <td><small> <?php _e("Prevents any access to wlwmanifest.xml. This file is used by Windows Live Writer to update your WordPress site, but is subject to unauthorized data acquisition and attack by hackers. Enabling this feature will disable WordPress updates by Windows Live Writer.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_badqueryblock" value="1" <?php if($security_badqueryblock==1){echo 'checked="checked"';} ?> /> <?php _e("Block malicious query","wpinfecscan");?></th>
                    <td><small> <?php _e("Block hackers from sending queries for tampering files (40 different types) that are written very common ly in malicious files.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_authorhogo" value="1" <?php if($security_authorhogo==1){echo 'checked="checked"';} ?> /> <?php _e("Protect author information","wpinfecscan");?></th>
                    <td><small> <?php _e("Prevents WordPress from outputting user information based on accesses from a particular query, such as /?author=1,/wp-json/wp/v2/users.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_noindex" value="1" <?php if($security_noindex==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit display of Index list","wpinfecscan");?></th>
                    <td><small><?php _e("Disables display of file list when accessing a directory which does not contain any index file, such as Index.html.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_nowpscan" value="1" <?php if($security_nowpscan==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit WPSCAN","wpinfecscan");?></th>
                    <td><small><?php _e("WPSCAN is a fragility checker for WordPress which is used by many hackers for a pre-survey. Hides version information to disable WPSCAN.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <td scope="row" style="width:60%"><b><?php _e("Permission (write permission of files)","wpinfecscan");?></b>
                    
                        <table class="table displaypermissionalert3">
                            <thead>
                                <tr>
                                    <th><?php _e('Files', "wpinfecscan") ?></th>
                                    <th><?php _e('Current permission', "wpinfecscan") ?></th>
                                    <th><?php _e('Recommended permission', "wpinfecscan") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                
                                $wp_config_file = ABSPATH . 'wp-config.php';
                                if(file_exists($wp_config_file)){
                                    $wp_config_file = $wp_config_file;
                                }
                                else if (file_exists(dirname( ABSPATH ) . '/wp-config.php')){       
                                    $wp_config_file = dirname( ABSPATH ) . '/wp-config.php';
                                }
                                
                                $files_and_dirs_to_check = array(
                                    array('name'=>'/','path'=>ABSPATH,'permissions'=>'0755'),
                                    array('name'=>'index.php','path'=>ABSPATH."index.php",'permissions'=>'0544'),
                                    array('name'=>'wp-includes/','path'=>ABSPATH."wp-includes",'permissions'=>'0755'),
                                    array('name'=>'.htaccess','path'=>ABSPATH.".htaccess",'permissions'=>'0644'),
                                    array('name'=>'wp-admin/index.php','path'=>ABSPATH."wp-admin/index.php",'permissions'=>'0644'),
                                    array('name'=>'wp-admin/js/','path'=>ABSPATH."wp-admin/js/",'permissions'=>'0755'),
                                    array('name'=>'wp-content/themes/','path'=>ABSPATH."wp-content/themes",'permissions'=>'0755'),
                                    array('name'=>'wp-content/plugins/','path'=>ABSPATH."wp-content/plugins",'permissions'=>'0755'),
                                    array('name'=>'wp-admin/','path'=>ABSPATH."wp-admin",'permissions'=>'0755'),
                                    array('name'=>'wp-content/','path'=>ABSPATH."wp-content",'permissions'=>'0755'),
                                    array('name'=>'wp-content/index.php','path'=>ABSPATH."wp-content/index.php",'permissions'=>'0544'),
                                    array('name'=>'wp-config.php','path'=>$wp_config_file,'permissions'=>'0644')
                                );
                                
                                $needfix=false;
                                foreach ($files_and_dirs_to_check as $file_or_dir)
                                {
                                    $res=wpinfectsecurity_show_wp_filesystem_status($file_or_dir['name'],$file_or_dir['path'],$file_or_dir['permissions']);
                                    if($res){
                                        $needfix=true;
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    
                    </td>
                    <td>
                    <?php
                    
                    if($needfix){
                        _e("<small>Write permission of files is fragile. Please replace the particulars indicated in red or yellow in the left table with recommended permission.</small>","wpinfecscan");
                    }else{
                        _e("<small>Permission (write permission of files) are properly set.</small>","wpinfecscan");
                    }
                    
                    ?></td>
                  </tr>
                  
                  <tr valign="top">
                    <td scope="row" colspan="2"><br><h3><span class="dashicons dashicons-admin-tools" style="font-size: 28px;color:#da906d;"></span>&nbsp;&nbsp;<?php _e("Protect WordPress functions","wpinfecscan");?></h3></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_noedit" value="1" <?php if($security_noedit==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit editing of themes and plugins","wpinfecscan");?></th>
                    <td><small><?php _e("Disables editing of themes and plugins from the administration display.","wpinfecscan");?></small></td>
                  </tr>
                  

                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_nopingback" value="1" <?php if($security_nopingback==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit Pingback","wpinfecscan");?></th>
                    <td><small><?php _e("Disables Pingback; notification function of WordPress, which has a risk of being utilized for high-intensity attack with multiple accesses or of information leak about username, etc.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_bruteforthlockdown" value="1" <?php if($security_bruteforthlockdown==1){echo 'checked="checked"';} ?> /> <?php _e("Ban brute-force attack IP to XMLRPC and wp-login","wpinfecscan");?>
                    
                    </th>
                    <td><small><?php _e("Disables accessing for 3 hours of the IP which tried to access XMLRPC or wp-login for more than 50 times in 10 minutes. Since this function detects only excessive access, it can be used with Jetpack and also reduces the load of the website by preventing brute-force attack.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_norestapi" value="1" <?php if($security_norestapi==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit REST API","wpinfecscan");?></th>
                    <td><small><?php _e("REST API is loaded into WordPress 4.7 or later which enables outside posting, information aquisition, modification and addition of posts, etc. However, it has great fragility in some versions and may be subjected to other misuse in future.<br>Its function is utilized in some famous plugins such as Jetpack and ContactForm7, therefore disables all Jetpack and ContactForm7 functions except REST API.<br>If enables its function while using REST API in other plugins, some kind of malfunction may occur.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_tracktrace" value="1" <?php if($security_tracktrace==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit Trace & Track","wpinfecscan");?></th>
                    <td><small><?php _e("Prevents attacks utilizing Trace & Track function of the server (unique processing method of requests sent to the server) such as HTTP trace attack (XST) and cross site scripting (XSS).","wpinfecscan");?></small></td>
                  </tr>
                  
                  <!--Since 1.7-->
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_nodirectaccessincludes" value="1" <?php if($security_nodirectaccessincludes==1){echo 'checked="checked"';} ?> /> <?php _e("Include file protection","wpinfecscan");?></th>
                    <td><small><?php _e("Protect direct access to include php files in wp-include folder and other.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_nouploadfolderphp" value="1" <?php if($security_nouploadfolderphp==1){echo 'checked="checked"';} ?> /> <?php _e("Upload folder protection","wpinfecscan");?></th>
                    <td><small><?php _e("BLock access to malcious file in wordpress upload directory.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_nobadquery" value="1" <?php if($security_nobadquery==1){echo 'checked="checked"';} ?> /> <?php _e("Block danger SQL query","wpinfecscan");?></th>
                    <td><small><?php _e("Block danger SQL queries that used for SQL injection.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_searchnoindex" value="1" <?php if($security_searchnoindex==1){echo 'checked="checked"';} ?> /> <?php _e("Noindexing search results page on wordpress if result not exist.","wpinfecscan");?></th>
                    <td><small><?php _e("If a WordPress search result does not exist, it will be noindexed and a status 404 will be returned. This prevents the search results in WordPress from being created and registered in search engines illegally.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <!--Since 1.7end-->
                  
                  <tr valign="top">
                    <td scope="row" colspan="2"><br><h3><span class="dashicons dashicons-format-status" style="font-size: 28px;color:#dac738;"></span>&nbsp;&nbsp;<?php _e("Protect comments from spam","wpinfecscan");?></h3></td>
                  </tr>
                  
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_noproxycomment" value="1" <?php if($security_noproxycomment==1){echo 'checked="checked"';} ?> /> <?php _e("Prohibit comment posting via proxy","wpinfecscan");?></th>
                    <td><small><?php _e("Prohibits comment posting via proxy by judging from header information unique for the proxy users.","wpinfecscan");?></small></td>
                  </tr>
                  
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_commentcaptcha" value="1" <?php if($security_commentcaptcha==1){echo 'checked="checked"';} ?> /> <?php _e("Comment form captcha","wpinfecscan");?></th>
                    <td><small><?php _e("Prevents automatic comment posting by adding captcha to the comment form. It may not be displayed in particular themes which display customized comment form.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <th scope="row" style="width:60%"><input type="checkbox" name="wpinfectscanner_security_spambot" value="1" <?php if($security_spambot==1){echo 'checked="checked"';} ?>  /> <?php _e("Prohibit comment posting by spambots","wpinfecscan");?></th>
                    <td><small><?php _e("Spambot is a program which posts comments automatically and does not have any referrer. Prevents comment posting by spambots by disabling posting from viewers who have no referrers.","wpinfecscan");?></small></td>
                  </tr>
                  
                  <tr valign="top">
                    <td scope="row" colspan="2"><br><h3><span class="dashicons dashicons-welcome-view-site" style="font-size: 28px;color:#0ec6c6;"></span>&nbsp;&nbsp;<?php _e("Definition of malware patterns","wpinfecscan");?></h3></td>
                  </tr>
                  
                  <?php
                  $ptcount = get_option('wpinfectscanner_newpatternnum',0);
                  if($ptcount<=0){
                  ?>
                  <tr valign="top">
                    <th scope="row" style="width:60%">
                    <?php _e("Detectable the latest malware patterns","wpinfecscan");?>
                    </th>
                    <td><small><?php _e("No action required.","wpinfecscan");?></small></td>
                  </tr>
                  <?php } else { ?>
                  <tr valign="top">
                    <th scope="row" style="width:60%">
                    <?php _e("Malware patterns are not the latest version","wpinfecscan");?>(-<?php echo (int)$mcount; ?><?php _e("Points","wpinfecscan");?>)
                    </th>
                    <td><small><?php _e("Subscription of malware pattern definition files is recommended to detect malware codes which are increasing day by day.","wpinfecscan");?></small></td>
                  </tr>
                  <?php } ?>
                  
                </table>
                <input type="hidden" name="settingname" value="security"/>

            </div>
            
            <?php submit_button(); ?>
            </form>
            
            <hr>
            
            <h3 style="font-size:22px"><span class="dashicons dashicons-image-rotate" style="font-size: 28px;color:#e96f6f;"></span>&nbsp;&nbsp;<?php _e("Repair and protect .htaccess and index.php","wpinfecscan");?></h3>
            
            <?php $nowlockdown = get_option( 'wpinfectscanner_emergencystopworking', false );
            
            $nowprotecthtaccessindexphp = get_option( 'wpinfectscanner_protecthtaccessindexphp', false );
            
            if($nowlockdown==1){
                
                echo "<p>";
                _e("This function is not available if 'Emergency suspension of all access to the site' is enabled.","wpinfecscan");
                echo "</p>";
                
            }else{
            
            ?>
            
            <p>
            <?php _e("If you have symptoms of a malware infection that causes the htaccess file or index.php to be rewritten on its own, add monitoring and auto-repair code to your WordPress configuration file to prevent these two files from being rewritten again after restoring them. If you enable this function, the contents of the htaccess file and index.php cannot be changed.","wpinfecscan");?>
            </p>
            
            <?php
            
            function removeurlstr($url){
                $url = str_replace("http://","",$url);
                $url = str_replace("https://","",$url);
                $url = str_replace("/","",$url);
                $url = str_replace("\\","",$url);
                return $url;
            }
            
            $home_path = wpinfecscanget_home_path();
            $indextxt = file_get_contents($home_path.'index.php');
            $htacctxt = file_get_contents($home_path.'.htaccess');
            
            
            
            $subdirecrtry = "";
            $mysiteurl = removeurlstr(get_option( 'siteurl' ));
            $myhomeurl = removeurlstr(get_option( 'home' ));
            
            if ( $mysiteurl !== $myhomeurl ) {
                $subdirecrtry = str_replace($mysiteurl,"",$myhomeurl)."/";
            }
            
            $sindextxt ="<?php
define( 'WP_USE_THEMES', true );
/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/".$subdirecrtry."wp-blog-header.php' );
?>";
    
            $subfolder = "";
            $docroot = removeurlstr($_SERVER['DOCUMENT_ROOT']);
            $absroot = removeurlstr(ABSPATH);
            if(strlen($docroot)>0 && strlen($absroot) - strlen($docroot) > 1){
                $subfolder = str_replace($docroot,"",$absroot)."/";
            }
            
            $shtacctxt = "# BEGIN WordPress
RewriteEngine On
RewriteBase /".$subfolder."
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /".$subfolder."index.php [L]
# END WordPress";

            ?>
            
            <script>
            
            var protecthtaccessindexphp = 0;
            var protecthtaccessindexphp_repair = 0;
            
            var firsthtaccess = "<?php echo base64_encode($htacctxt);?>";
            var firsthindex = "<?php echo base64_encode($indextxt);?>";
            
            var syufukuhtaccess = "<?php echo base64_encode($shtacctxt);?>";
            var syufukuindex = "<?php echo base64_encode($sindextxt);?>";
            
            function repaircheckfunc1(){
                var c = jQuery("#protecthtaccessindexphp").is(':checked');
                if(c){
                    protecthtaccessindexphp = 1;
                    jQuery("#indexhtaccesstxt").show();
                }else{
                    protecthtaccessindexphp = 0;
                    if(protecthtaccessindexphp_repair!=1){
                        jQuery("#indexhtaccesstxt").hide();
                    }
                }
            }
            function repaircheckfunc2(){
                var c = jQuery("#protecthtaccessindexphp_repair").is(':checked');
                if(c){
                    protecthtaccessindexphp_repair = 1;
                    jQuery("#repairexp").show();
                    jQuery("#indexhtaccesstxt").show();
                    jQuery("#indextxt").prop('readonly', false);
                    jQuery("#htaccesstxt").prop('readonly', false);
                    jQuery(".resettercl").show();
                }else{
                    protecthtaccessindexphp_repair = 0;
                    if(protecthtaccessindexphp!=1){
                        jQuery("#indexhtaccesstxt").hide();
                    }
                    jQuery("#repairexp").hide();
                    
                    jQuery("#indextxt").prop('readonly', true);
                    jQuery("#htaccesstxt").prop('readonly', true);
                    
                    jQuery(".resettercl").hide();
                    
                    jQuery("#indextxt").val(decodeURIComponent(escape(atob(firsthindex))));
                    jQuery("#htaccesstxt").val(decodeURIComponent(escape(atob(firsthtaccess))));
                }
            }
            
            function shokikaindex(){
                var c = jQuery("#protecthtaccessindexphp_repair").is(':checked');
                if(c){
                    jQuery("#indextxt").val(atob(syufukuindex));
                }
            }
            function shokikahtaccess(){
                var c = jQuery("#protecthtaccessindexphp_repair").is(':checked');
                if(c){
                    jQuery("#htaccesstxt").val(atob(syufukuhtaccess));
                }
            }
            function stopprotecthtacccessindexfunc(){
                    jQuery('#protecthtaccessindexphpbt').hide();
                    jQuery('#protecthtacccessindexreturnbt').hide();
                    jQuery('#protecthtaccessindexphpdoing').show();
                    
                    jQuery.ajax({
                       type: "POST",
                       url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                       data: {
                            "action": "siteprotecthtacccessindex",
                            "stop": 1,
                       },
                       success: function(msg){
                           if ( msg.indexOf('error:') == 0) {
                               var errormessage = msg.replace("error:", "");
                               alert(errormessage);
                               jQuery('#protecthtaccessindexphpbt').show();
                               jQuery('#protecthtaccessindexphpdoing').hide();
                               jQuery('#protecthtacccessindexreturnbt').show();
                               jQuery("#protecthtaccessindexphp").parent().hide();
                               jQuery("#protecthtaccessindexphp_repair").parent().hide();
                           }else{
                               //alert(msg);
                               //ToDo 
                               jQuery('#protecthtaccessindexphpbt').show();
                               jQuery('#protecthtaccessindexphpdoing').hide();
                               jQuery("#protecthtaccessindexphp").prop( "checked", false );
                               jQuery("#protecthtaccessindexphp_repair").prop( "checked", false );
                               
                               jQuery("#protecthtaccessindexphp").parent().show();
                               jQuery("#protecthtaccessindexphp_repair").parent().show();
                               jQuery('#protecthtacccessindexreturnbt').hide();
                               jQuery("#protecthtaccessindexphp").prop('readonly', false);
                               jQuery("#nowprotectingindexhtaccess").hide();
                               
                               repaircheckfunc1();repaircheckfunc2();
                               
                               if (jQuery("#emergencyshutdownbt").length ) {
                                    jQuery("#emergencyshutdownbt").show();
                               }
                               
                               if (! jQuery("#emergencyshutdownbttxt").length ) {
                                    jQuery("#emergencyshutdownbttxt").hide();
                               }
                               
                           }
                       }
                     });
                }
                
                var repairdone = false;
                var sikoucount = 0;
                function repairhtacccessindexfunc(rhtaccesscode,rindexcode,isprotection) {
                    
                    sikoucount = sikoucount+1;
                    
                    //alert(sikoucount);
                    
                    if(sikoucount>10){
                        alert("<?php _e("Failed repaire.htaccess and index.php","wpinfecscan");?>");
                        jQuery('#protecthtaccessindexphpbt').show();
                        jQuery('#protecthtaccessindexphpdoing').hide();
                        jQuery('#protecthtacccessindexreturnbt').hide();
                        jQuery('#protecthtacccessindexreturnbt').hide();
                        jQuery("#protecthtaccessindexphp").parent().show();
                        jQuery("#protecthtaccessindexphp_repair").parent().show();
                    }else{

                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: {
                                "action": "repairsiteprotecthtacccessindex",
                                "stop": 0,
                                "isprotection" : isprotection,
                                "rhtaccesscode" : rhtaccesscode,
                                "rindexcode" : rindexcode,
                                "callcount" : sikoucount,
                           },
                           success: function(msg){
                       
                               if ( msg.indexOf('error:') == 0) {
                                   var errormessage = msg.replace("error:", "");
                                   alert(errormessage);
                                   jQuery('#protecthtaccessindexphpbt').show();
                                   jQuery('#protecthtaccessindexphpdoing').hide();
                                   jQuery('#protecthtacccessindexreturnbt').hide();
                                   jQuery('#protecthtacccessindexreturnbt').hide();
                                   jQuery("#protecthtaccessindexphp").parent().show();
                                   jQuery("#protecthtaccessindexphp_repair").parent().show();
                               }else{
                                   ////Todo
                                   //alert(msg);
                                   
                                   firsthtaccess = rhtaccesscode;
                                   firsthindex = rindexcode;
                                   
                                   if(msg=="ok2"){
                                       if(isprotection !=1){
                                            alert('<?php _e("Successfully repaired .htaccess and index.php","wpinfecscan");?>');
                                            sikoucount = 0;
                                            jQuery('#protecthtaccessindexphpbt').show();
                                            jQuery('#protecthtaccessindexphpdoing').hide();
                                            jQuery("#protecthtaccessindexphp_repair").prop( "checked", false );
                                           repaircheckfunc1();repaircheckfunc2();
                                       }
                                       if(isprotection ==1){
                                           repairdone = true;
                                           protecthtacccessindexfunc();
                                       }
                                   }else{
                                       repairhtacccessindexfunc(rhtaccesscode,rindexcode,isprotection);
                                   }
                               }
                            }
                         }).fail(function (jqXHR, textStatus, error) {
                            repairhtacccessindexfunc(rhtaccesscode,rindexcode,isprotection);
                         });
                    }
                }
                
                function protecthtacccessindexfunc() {
                    
                    var isprotection = jQuery("#protecthtaccessindexphp").is(':checked');
                    var isrepair = jQuery("#protecthtaccessindexphp_repair").is(':checked');
                    
                    if(isprotection==true){
                        isprotection=1;
                    }
                    if(isrepair==true){
                        isrepair=1;
                    }
                    
                    if(isprotection ==1 || isrepair==1){
                        
                        jQuery('#protecthtaccessindexphpbt').hide();
                        jQuery('#protecthtaccessindexphpdoing').show();
                        
                        var rhtaccesscode = jQuery('#htaccesstxt').val();
                        rhtaccesscode = btoa( unescape(encodeURIComponent(rhtaccesscode)) );
                        var rindexcode = jQuery('#indextxt').val();
                        rindexcode = btoa( unescape(encodeURIComponent(rindexcode)) );
                        
                        if(isrepair==1 && repairdone == false){
                            sikoucount = 0;
                            repairhtacccessindexfunc(rhtaccesscode,rindexcode,isprotection);
                        }else{
                            
                            sikoucount = 0;
                            repairdone = false;
                    
                            jQuery.ajax({
                               type: "POST",
                               url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                               data: {
                                    "action": "siteprotecthtacccessindex",
                                    "stop": 0,
                                    "isprotection" : isprotection,
                                    "isrepair" : isrepair,
                                    "rhtaccesscode" : rhtaccesscode,
                                    "rindexcode" : rindexcode,
                               },
                               success: function(msg){
                                   
                                   if ( msg.indexOf('error:') == 0) {
                                       var errormessage = msg.replace("error:", "");
                                       alert(errormessage);
                                       jQuery('#protecthtaccessindexphpbt').show();
                                       jQuery('#protecthtaccessindexphpdoing').hide();
                                       jQuery('#protecthtacccessindexreturnbt').hide();
                                       jQuery('#protecthtacccessindexreturnbt').hide();
                                       jQuery("#protecthtaccessindexphp").parent().show();
                                       jQuery("#protecthtaccessindexphp_repair").parent().show();
                                   }else{
                                       //alert(msg);
                                       
                                       firsthtaccess = rhtaccesscode;
                                       firsthindex = rindexcode;
                                       
                                       if(msg=="ok1"){
                                           jQuery('#indexhtaccesstxt').hide();
                                           jQuery('#protecthtacccessindexreturnbt').show();
                                           jQuery("#protecthtaccessindexphp").prop( "checked", false );
                                           jQuery("#protecthtaccessindexphp_repair").prop( "checked", false );
                                           jQuery('#protecthtaccessindexphpdoing').hide();
                                           jQuery("#protecthtaccessindexphp").parent().hide();
                                           jQuery("#protecthtaccessindexphp_repair").parent().hide();
                                           jQuery("#nowprotectingindexhtaccess").show();
                                           repaircheckfunc1();repaircheckfunc2();
                                           
                                           if (jQuery("#emergencyshutdownbt").length ) {
                                                jQuery("#emergencyshutdownbt").hide();
                                           }
                                           
                                           if (! jQuery("#emergencyshutdownbttxt").length ) {
                                                jQuery("#emergencyshutdownbt").before("<p id='emergencyshutdownbttxt'><?php echo _e("*This function is not available if index.php or htaccess protection is enabled.","wpinfecscan");?></p>" );
                                           }else{
                                               jQuery("#emergencyshutdownbttxt").show();
                                           }
                                       }
                                   }
                               }
                            });
                        }
                    }
                }
            </script>
            
    
            <p style="color:red;<?php if($nowprotecthtaccessindexphp !=1){echo "display:none";}?>" id="nowprotectingindexhtaccess"><?php _e("The contents of index.php and htaccess are currently protected.","wpinfecscan");?></p>
            
            
            <p><input type="checkbox" autocomplete="off" name="protecthtaccessindexphp" id="protecthtaccessindexphp" value="1" onclick="repaircheckfunc1()" <?php $protecthtaccessindexphp = get_option("wpinfectscanner_protecthtaccessindexphp");if($protecthtaccessindexphp==1){ echo " checked='checked' readonly";} ?>><?php _e("Protect htaccess and index.php","wpinfecscan");?></p>
            
            <div id="indexhtaccesstxt" style="display:none">
            <h5><?php _e("Contents of index.php to be protected","wpinfecscan");?> <a href="javascript:void(0);" onClick="shokikaindex()" class="resettercl"><?php _e("initialisation","wpinfecscan");?></a></h5>
            <textarea readonly=readonly id="indextxt" autocomplete="off" style="width:100%;height:180px"><?php echo htmlspecialchars($indextxt);?></textarea>
            <h5><?php _e("Contents of htaccess to be protected","wpinfecscan");?> <a href="javascript:void(0);" onClick="shokikahtaccess()" class="resettercl"><?php _e("initialisation","wpinfecscan");?></a></h5>
            <textarea readonly=readonly id="htaccesstxt" autocomplete="off" style="width:100%;height:180px;margin-bottom:15px;"><?php echo htmlspecialchars($htacctxt);?></textarea>
            </div>
            
            <p <?php if($nowprotecthtaccessindexphp ==1){echo " style='display:none'";} ?>><input type="checkbox" autocomplete="off" name="protecthtaccessindexphp_repair" id="protecthtaccessindexphp_repair" value="1" onclick="repaircheckfunc2()"><?php _e("Repair htaccess and index.php","wpinfecscan");?></p>
            
            <p id="repairexp" style="display:none"><?php _e("If .htaccess and index.php are rewritten on their own, we will forcibly rewrite and restore the contents of the .htaccess and index.php displayed above. In this case, a special process is executed to stop the PHP process, so PHP may temporarily stop working and the site may not be able to be displayed. In this case, it may be necessary to restart PHP on the server or the server itself.","wpinfecscan");?></p>
            
            <script>repaircheckfunc1();repaircheckfunc2();</script>
            
            
            <button class="btn btn-warning" onclick="protecthtacccessindexfunc()" id="protecthtaccessindexphpbt" style="<?php if($nowprotecthtaccessindexphp==1){ echo "display:none;"; } ?>"><span class="dashicons dashicons-warning"></span> <?php _e("Implement htaccess and index.php protection","wpinfecscan");?></button>
            <div id="protecthtaccessindexphpdoing" style="display:none;"><i class="fa fa-circle-o-notch fa-spin"></i> <?php _e("processing...","wpinfecscan");?>
            </div>
            
            <button style="<?php if($nowprotecthtaccessindexphp!=1){ echo "display:none;"; } ?>" class="btn btn-success" onclick="stopprotecthtacccessindexfunc()" id="protecthtacccessindexreturnbt"><span class="dashicons dashicons-undo"></span> <?php _e("Unprotect index.php,htaccess","wpinfecscan");?></button>
            
            <?php } ?>
            
            <hr>
            
            <?php if(isset($_SERVER['REMOTE_ADDR'])){
            $myip = $_SERVER['REMOTE_ADDR'];
            if(filter_var($myip, FILTER_VALIDATE_IP)){ ?>
            <h3 style="font-size:22px"><span class="dashicons dashicons-vault" style="font-size: 28px;color:#e96f6f;"></span>&nbsp;&nbsp;<?php _e("Emergency site shutdown","wpinfecscan");?></h3>
            
            <p>
            <?php _e("Blocks all external access except for your current login IP","wpinfecscan");?>(<?php echo $myip;?>)<?php _e(". It prohibits all external access and deters the activities of the kind of malware that automatically repeats tampering. You can then remove the malware.","wpinfecscan");?>
            </p>
            
            <?php 
            
            if($nowprotecthtaccessindexphp==1){
                
                echo "<p>";
                _e("*This function is not available if index.php or htaccess protection is enabled.","wpinfecscan");
                echo "</p>";
                
            }else{
            
            ?>
            
            <?php
            
            require_once('scannerdata/wpinfectsecurity.php');
            $csecfunc=new WPInfectSecurity();
            $csecfunc->security_check_emergencyblock();
            
            $nowlockdown = get_option( 'wpinfectscanner_emergencystopworking', false );
            //var_dump($nowlockdown);
            $htaccesscode = "";
            if($nowlockdown==1){ 
                $htaccesscode = get_option( 'wpinfectscanner_oldhtaccessdata', '' );
                $htaccesscode = base64_decode(str_rot13($htaccesscode));
                $htaccesscode = htmlspecialchars($htaccesscode);
            }
            
            ?>
            <button class="btn btn-danger" onclick="emergencystop('<?php echo $myip;?>')" id="emergencyshutdownbt" style="<?php if($nowlockdown){ echo "display:none;"; } ?>"><span class="dashicons dashicons-warning"></span> <?php _e("Emergency site shutdown","wpinfecscan");?></button>
            <div id="emergencyshutdownbtdoing" style="display:none;"><i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;&nbsp;<?php _e("processing...","wpinfecscan");?></div>
            
            <button style="<?php if(! $nowlockdown){ echo "display:none;"; } ?>" class="btn btn-success" onclick="emergencyreturn()" id="emergencyreturnbt"><span class="dashicons dashicons-undo"></span> <?php _e("Make the site accessible again.","wpinfecscan");?></button>
            
            <p id="eoldhtaccesstxt" style='color:red;<?php if(! $nowlockdown){ echo "display:none;"; } ?>'><br><?php _e("When the site is made accessible again, the contents of the old htaccess file below will be restored. If there is any malware in this file, please delete it before restoring the site.","wpinfecscan");?></p>
            
            <textarea id="eoldhtaccess" style="width:100%;height:120px;<?php if(! $nowlockdown){ echo "display:none;"; } ?>"><?php echo $htaccesscode; ?></textarea>
            
            <p>
            <small style="color:#888"><br><?php _e("*When this feature is enabled, all accesses except your current IP will be ignored. If you are unable to access the site due to a change of your IP address, please delete #EMERGENCY_BLOCK_START to #EMERGENCY_BLOCK_END in the HTACCESS file on the server and you will be able to access the site again.","wpinfecscan");?></small>
            </p>
            
            <hr>
            
            <script>
                function emergencyreturn(){
                    jQuery('#emergencyreturnbt').hide();
                    jQuery('#emergencyshutdownbtdoing').show();
                    var htaccesscode = jQuery('#eoldhtaccess').val();
                    htaccesscode = htaccesscode.replace( "%", "@#@#$@#@##@#@#$#@$#@" );
                    jQuery.ajax({
                       type: "POST",
                       url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                       data: {
                            "returnmode":1,
                            "action": "siteemergencystop",
                            "htaccesscode": encodeURIComponent(htaccesscode),
                       },
                       success: function(msg){
                           //alert(msg);
                           if ( msg.indexOf('error:') == 0) {
                               var errormessage = msg.replace("error:", "");
                               alert(errormessage);
                               jQuery('#emergencyreturnbt').show();
                               jQuery('#emergencyshutdownbtdoing').hide();
                           }else{
                               //ToDo
                               alert('<?php _e("Restored access to the site.","wpinfecscan");?>');
                               jQuery('#emergencyshutdownbt').show();
                               jQuery('#emergencyshutdownbtdoing').hide();
                               jQuery('#emergencyreturnbt').hide();
                               jQuery('#eoldhtaccesstxt').hide();
                               jQuery('#eoldhtaccess').hide();
                           }
                           
                       }
                     });
                }
                function emergencystop(myipaddr) {
                    jQuery('#emergencyshutdownbt').hide();
                    jQuery('#emergencyshutdownbtdoing').show();
                    jQuery.ajax({
                       type: "POST",
                       url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                       data: "myip="+myipaddr+"&action=siteemergencystop",
                       success: function(msg){
                           //alert(msg);
                           if ( msg.indexOf('error:') == 0) {
                               var errormessage = msg.replace("error:", "");
                               alert(errormessage);
                               jQuery('#emergencyshutdownbt').show();
                               jQuery('#emergencyshutdownbtdoing').hide();
                           }else{
                               //ToDo
                               alert('<?php _e("It worked! Only the currently logged-in IP can access the site now!","wpinfecscan");?>');
                               jQuery('#emergencyshutdownbt').hide();
                               jQuery('#emergencyshutdownbtdoing').hide();
                               jQuery('#emergencyreturnbt').show();
                               jQuery('#eoldhtaccesstxt').show();
                               jQuery('#eoldhtaccess').show();
                               jQuery('#eoldhtaccess').val(msg);
                           }
                           
                       }
                     });
                }
            </script>
            
            <?php }}} ?>
            
            <h3 style="font-size:22px"><span class="dashicons dashicons-excerpt-view" style="font-size: 28px;color:#e91e63;"></span>&nbsp;&nbsp;<?php _e("Process manager","wpinfecscan");?></h3>
            <br>
            <p><?php _e("The Process Manager detects and displays potentially malware processes running in memory. If a process keeps executing a file that you do not recognize, and the PHP file does not exist (or is executing a file that does not exist in the WordPress core files), and the execution time is long (more than 1 hour), malware may have embedded some malware in the process. If the htaccess file or index.php is rewritten without your permission and malicious code is continuously embedded, malware may be deployed in the process.","wpinfecscan");?></p>
            
            <p><small style="color:#888"><?php _e("*Processes may not be retrieved or stopped on some servers.","wpinfecscan");?></small></p>
            
            <p><a href="javascript:void(0);" onClick="document.getElementById('processmonitor').contentWindow.location.href='<?php echo plugin_dir_url( __FILE__ ); ?>tools/index.php';"><?php _e("Refresh","wpinfecscan");?></a></p>
            <iframe  id="processmonitor" src="<?php echo plugin_dir_url( __FILE__ ); ?>tools/index.php" style="width:100%;height:250px; overflow: scroll;border: 1px solid #bbb;"></iframe>
            
            <hr>

            <h3 style="font-size:22px"><span class="dashicons dashicons-text" style="font-size: 28px;color:#b4b9c6;"></span>&nbsp;&nbsp;<?php _e("Login log","wpinfecscan");?></h3>
            <br>
            <p><b><?php _e("List of IPs succeeded to login with administrator permission in the last 1 month","wpinfecscan");?> <?php _e("Your current IP","wpinfecscan");?> = <?php echo isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;?></b></p>
            
            <textarea readonly style="width:100%;height:120px"><?php
            global $wpdb;
            $query = "SELECT * FROM ".$wpdb->options." WHERE option_name LIKE '%_transient_archive_iplogin%'  order by option_id desc limit 25";

            $rowsfiles = $wpdb->get_results($query);
            $ipandcountry = array();

            foreach ($rowsfiles as $row) 
            {
                if((bool) get_transient(str_replace("_transient_","",$row->option_name))){
                    $eip= explode("archive_iplogin",$row->option_name);
                    $eips= explode("_",$eip[1]);
                    
                    $ipc="";
                    if(isset($ipandcountry[$eips[0]])){
                        $ipc = $ipandcountry[$eips[0]];
                    }
                    
                    if(empty($ipc)){
                        $options['ssl']['verify_peer']=false;
                        $options['ssl']['verify_peer_name']=false;
                        $res = @file_get_contents('https://www.iplocate.io/api/lookup/'.$eips[0], false, stream_context_create($options));
                        if($res){
                            $res = json_decode($res);
                            if(empty($res->country)){
                                $res->country = "";
                            }
                            if(strlen($res->country)>1){
                                 $eips[0]= $eips[0]." - ".$res->country ." ". $res->city;
                                 $ipandcountry[$eips[0]] = " - ".$res->country ." ". $res->city;
                            }else{
                                $ipandcountry[$eips[0]] =" ";
                            }
                        }else{
                            $ipandcountry[$eips[0]] =" ";
                        }
                    }else{
                        $eips[0]= $eips[0].$ipc;
                    }
                    
                    echo $eips[0]." ".$eips[1]." ".$eips[2].__("O'Clock","wpinfecscan")."\n";
                }
            }
            ?></textarea> 
            
                    
              
          <script>
          
          function setseclevel(mysetting){
              
                if(mysetting==4){
                    jQuery("#detainsetting").show();
                }else{
                    jQuery("#detainsetting").hide();
                }
                
                jQuery("#kantansetteiexp1").hide();
                jQuery("#kantansetteiexp2").hide();
                jQuery("#kantansetteiexp3").hide();
                jQuery(".displaypermissionalert").hide();
                jQuery(".displaypermissionalert2").hide();
                jQuery(".displaylogin").hide();
                
                jQuery("#kantansetteiexp"+mysetting).show();
                
                jQuery('input[name="wpinfectscanner_security_loginlockdown"]').prop("checked",false);
                
                jQuery('input[name="wpinfectscanner_security_logincaptcha"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_pwresetcaptcha"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_loginchange"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_wphideversion"]').prop("checked",false);
                
                jQuery('input[name="wpinfectscanner_security_serverhogo"]').prop("checked",false);
                
                jQuery('input[name="wpinfectscanner_security_blockwlwmanifest"]').prop("checked",false);
                    
                jQuery('input[name="wpinfectscanner_security_filehogo"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_badqueryblock"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_authorhogo"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_noindex"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_nowpscan"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_noedit"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_nopingback"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_bruteforthlockdown"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_norestapi"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_tracktrace"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_noproxycomment"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_commentcaptcha"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_spambot"]').prop("checked",false);
                
                jQuery('input[name="wpinfectscanner_security_nodirectaccessincludes"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_nouploadfolderphp"]').prop("checked",false);
                jQuery('input[name="wpinfectscanner_security_nobadquery"]').prop("checked",false);
                
                jQuery('input[name="wpinfectscanner_security_searchnoindex"]').prop("checked",false);
                
                if(mysetting==1){
                    jQuery('input[name="wpinfectscanner_security_loginlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_wphideversion"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_filehogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_serverhogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noindex"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nowpscan"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nopingback"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_bruteforthlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noproxycomment"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_spambot"]').prop("checked",true);
                    
                    jQuery('input[name="wpinfectscanner_security_nodirectaccessincludes"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nouploadfolderphp"]').prop("checked",true);
                }
                
                if(mysetting==2){
                    jQuery('input[name="wpinfectscanner_security_loginlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_logincaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_pwresetcaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_wphideversion"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_filehogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_serverhogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_blockwlwmanifest"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_badqueryblock"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_authorhogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noindex"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nowpscan"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nopingback"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_bruteforthlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_tracktrace"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noproxycomment"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_commentcaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_spambot"]').prop("checked",true);
                    
                    jQuery('input[name="wpinfectscanner_security_nodirectaccessincludes"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nouploadfolderphp"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nobadquery"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_searchnoindex"]').prop("checked",true);
                    
                    <?php if($permissionneedfix){ ?>
                    if(permissionchangesuccess == false){
                        jQuery(".displaypermissionalert").show();
                    }
                    <?php } ?>
                }
                
                if(mysetting==3){
                    jQuery('input[name="wpinfectscanner_security_loginlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_logincaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_pwresetcaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_loginchange"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_wphideversion"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_filehogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_serverhogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_blockwlwmanifest"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_badqueryblock"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_authorhogo"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noindex"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nowpscan"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noedit"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nopingback"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_bruteforthlockdown"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_norestapi"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_tracktrace"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_noproxycomment"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_commentcaptcha"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_spambot"]').prop("checked",true);
                    
                    jQuery('input[name="wpinfectscanner_security_nodirectaccessincludes"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nouploadfolderphp"]').prop("checked",true);
                    jQuery('input[name="wpinfectscanner_security_nobadquery"]').prop("checked",true);
                    
                    jQuery('input[name="wpinfectscanner_security_searchnoindex"]').prop("checked",true);
                    
                    var loginval = jQuery('input[name="wpinfectscanner_security_loginchangeurl"]').val();
                    if(loginval==""){
                        <?php $loginid = uniqid();?>
                        jQuery('input[name="wpinfectscanner_security_loginchangeurl"]').val('<?php echo $loginid;?>');
                    }
                    
                    jQuery('#loginurlchanged').html(jQuery('input[name="wpinfectscanner_security_loginchangeurl"]').val());
                    
                    <?php if($permissionneedfix){ ?>
                    if(permissionchangesuccess == false){
                        jQuery(".displaypermissionalert2").show();
                    }
                    <?php } ?>
                    jQuery(".displaylogin").show();
                }
                
                if(mysetting==4){
                    <?php
                    
                    if($security_wphideversion>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_wphideversion\"]').prop(\"checked\",true);";
                    }
                    if($security_loginlockdown>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_loginlockdown\"]').prop(\"checked\",true);";
                    }
                    if($security_logincaptcha>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_logincaptcha\"]').prop(\"checked\",true);";
                    }
                    if($security_pwresetcaptcha>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_pwresetcaptcha\"]').prop(\"checked\",true);";
                    }
                    if($security_noedit>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_noedit\"]').prop(\"checked\",true);";
                    }
                    if($security_filehogo>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_filehogo\"]').prop(\"checked\",true);";
                    }
                    if($security_serverhogo>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_serverhogo\"]').prop(\"checked\",true);";
                    }
                    if($security_blockwlwmanifest>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_blockwlwmanifest\"]').prop(\"checked\",true);";
                    }
                    if($security_badqueryblock>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_badqueryblock\"]').prop(\"checked\",true);";
                    }
                    if($security_authorhogo>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_authorhogo\"]').prop(\"checked\",true);";
                    }
                    if($security_nopingback>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_nopingback\"]').prop(\"checked\",true);";
                    }
                    if($security_norestapi>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_norestapi\"]').prop(\"checked\",true);";
                    }
                    if($security_noindex>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_noindex\"]').prop(\"checked\",true);";
                    }
                    if($security_noproxycomment>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_noproxycomment\"]').prop(\"checked\",true);";
                    }
                    if($security_loginchange>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_loginchange\"]').prop(\"checked\",true);";
                    }
                    if($security_commentcaptcha>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_commentcaptcha\"]').prop(\"checked\",true);";
                    }
                    if($security_spambot>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_spambot\"]').prop(\"checked\",true);";
                    }
                    if($security_nowpscan>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_nowpscan\"]').prop(\"checked\",true);";
                    }
                    if($security_tracktrace>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_tracktrace\"]').prop(\"checked\",true);";
                    }
                    if($security_bruteforthlockdown>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_bruteforthlockdown\"]').prop(\"checked\",true);";
                    }
                    
                    if($security_nodirectaccessincludes>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_nodirectaccessincludes\"]').prop(\"checked\",true);";
                    }
                    if($security_nouploadfolderphp>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_nouploadfolderphp\"]').prop(\"checked\",true);";
                    }
                    if($security_nobadquery>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_nobadquery\"]').prop(\"checked\",true);";
                    }
                    if($security_searchnoindex>0){
                        echo "jQuery('input[name=\"wpinfectscanner_security_searchnoindex\"]').prop(\"checked\",true);";
                    }


                    ?>
                }

          }
          
          jQuery( 'input[name="kantansettei"]:radio' ).change( function() {  
                var mysetting=jQuery( this ).val();
                setseclevel(mysetting);
          }); 
          
          jQuery(document).ready(function() {
                <?php if($security_kantansettei>0){ ?>
                var mysetting=<?php echo $security_kantansettei;?>;
                setseclevel(mysetting);
                <?php } ?>
          });
          
          </script>
    </div>
</div>
