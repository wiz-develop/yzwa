<?php
/**
Plugin Name:WPDoctor Malware Scanner & Security Pro 
Plugin URI: https://website-malware-removal.com/
description: WP doctor Malware scan and Security plugin
Version: 2.9
Author: WP-Doctor
Author URI: https://wp-doctor.jp/
Text Domain: wpinfecscan
Domain Path: /languages/
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpinfecscanversion;
$wpinfecscanversion = "2.9";


require_once('scannerdata/wpinfectsecurity.php');

/////add plugin wp header for proof this is wordpress site since 1.4.5

function theme_wpinfectscan_header_metadata() {
  if ( is_home() || is_front_page() ):
        require_once('scannerdata/wpinfectscanner.php');
        $mysiteurl = get_home_url();
        $scanner=new MalwareScanner();
        $metavalue=$scanner->makekey($mysiteurl);
        ?>
        <meta name="wpms_prove" content="<?php echo $metavalue; ?>" />
        <?php
  endif;
}
add_action( 'wp_head', 'theme_wpinfectscan_header_metadata' );


//////////Textdomain
add_action('init', 'my_wpinfecscanplugin_textdomaininit');
function my_wpinfecscanplugin_textdomaininit() {
  $lang = dirname( plugin_basename( __FILE__ ) ) . "/languages";
  load_plugin_textdomain( 'wpinfecscan', false, $lang );
}

//////////Auto update
add_action( 'init', 'infecscanner_activate_au' );
function infecscanner_activate_au()
{
    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    
	require_once ( 'wp_autoupdate.php' );
    global $wpinfecscanversion;
	$plugin_current_version = $wpinfecscanversion;
	$plugin_remote_path = $scanner->phpurl.'update.php'; //DLOK
	$plugin_slug = plugin_basename( __FILE__ );
	$license_user = '';
	$license_key = '';
	new infecscanner_WP_AutoUpdate ( $plugin_current_version, $plugin_remote_path, $plugin_slug, $license_user, $license_key );
}

//////////cron_schedules

function infecscanner_my_cron_schedules($schedules){
    if(!isset($schedules["10min"])){
        $schedules["10min"] = array(
            'interval' => 10*60,
            'display' => __('All files are continuously scanned every 10 minutes after designated time.','wpinfecscan'));
    }
    return $schedules;
}
add_filter('cron_schedules','infecscanner_my_cron_schedules');


function infecscanner_my_repeat_function() {
    
	require_once('scannerdata/wpinfectscanner.php');
    
    $scanner=new MalwareScanner();
    $lastpatternget = strtotime(get_option( 'wpinfectscanner_lastpatternget',-1));
    $datebefore_6hours = strtotime(date("Y-m-d H:i:s", strtotime('-6 hours', time())));
    if($lastpatternget<$datebefore_6hours){
        $scanner->loaddatacloud();
    }
    
    $scanner=new MalwareScanner();
    $scanner->timezone=get_option('timezone_string');
    $scanner->run(ABSPATH,true,450); 
}

add_action ('wpinfectscannercronjob', 'infecscanner_my_repeat_function'); 


function wpinfectscannercron_activation() {
	if( !wp_next_scheduled( 'wpinfectscannercronjob' ) ) {  
	   wp_schedule_event( time(), '10min', 'wpinfectscannercronjob' );  
	}
    if (!wp_next_scheduled ( 'wpinfectscanneripupdatecronjob' )) {
        wp_schedule_event(time(), 'hourly', 'wpinfectscanneripupdatecronjob');
    }
}
add_action('wp', 'wpinfectscannercron_activation');

//Auto update auto IP block
add_action('wpinfectscanneripupdatecronjob', 'wpinfectscanneripupdatecronjob_hourly');
function wpinfectscanneripupdatecronjob_hourly() {
    
    $n = rand(0, 12);
    $autoblockdata = get_option("wpinfectscanner_autoblockip");
    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
        
    if($n==1 && !empty($autoblockdata)){
        
        $ipblockdata = $scanner->getipdata();
        
        if(!empty($ipblockdata)){
            $ipautook = true;
            $iplisttxt = array();
            if($scanner->getpro() != 1){
                $ipautook = false;
                if(get_option('wpinfectscanner_realtimeblock')==1){
                    require_once('scannerdata/wpinfectsecurity.php');
                    $secfunc=new WPInfectSecurity();
                    $secfunc->security_realtimeblock(0);
                    update_option( 'wpinfectscanner_realtimeblock', '0' );
                }
            }else{
                foreach ($ipblockdata as $key => $value){
                    $iplisttxt[]=$value->ip;
                }
            }
            if($ipautook){
                update_option("wpinfectscanner_autoblockip",implode("\n",$iplisttxt));
                
                
                require_once('scannerdata/wpinfectsecurity.php');
                $secfunc=new WPInfectSecurity();
                $secfunc->security_blockip2($iplisttxt);
                
            }else{
                update_option("wpinfectscanner_autoblockip","");
            }
        }
    }
    
    $setting_vulautoscan = get_option( 'wpinfectscanner_cron_vulautoscan_info',-1);
    if($setting_vulautoscan==1){
        if($scanner->getpro() != 1){
            update_option( 'wpinfectscanner_cron_vulautoscan_info', '0' );
        }
    }
    
    //X $advanceipblock = get_option("wpinfectscanner_advanceblockip");
    //X if($advanceipblock==1){
        //X if($n<6){
            
            //X require_once('scannerdata/wpinfectscanner.php');
            //X $scanner=new MalwareScanner();
            
            //X if($scanner->getpro()==1){
                //X $secfunc=new WPInfectSecurity();
                //X $secfunc->security_advanceipblock(1);
            //X }else{
                //X update_option("wpinfectscanner_advanceblockip","");
                //X $secfunc=new WPInfectSecurity();
                //X $secfunc->security_advanceipblock(0);
            //X }
        //X }
    //X }
    
    
    if($scanner->getpro()!=1){
        update_option( 'wpinfectscanner_autoblock_valunarability_attack', '0' );
        update_option( 'wpinfectscanner_autoblock_wpscan_attack', '0' );
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack', '0' );
		update_option( 'wpinfectscanner_autoblock_cookie_attack', '0' );
        update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', '1hour' );
        update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', '1hour' );
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', '1hour' );
		update_option( 'wpinfectscanner_autoblock_cookie_attack_length', '1hour' );
    }
    
    require_once('scannerdata/wpinfectsecurity.php');
    $security=new WPInfectSecurity();
    $res = $security->security_ipblock();
}

function wpinfectscanner_plugin_activate() {
    register_mysettings();
    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    $scanner->loaddatacloud();
}
register_activation_hook( __FILE__, 'wpinfectscanner_plugin_activate' );

function wpinfectscannercron_deactivate() {
	$timestamp = wp_next_scheduled ('wpinfectscannercronjob');
	wp_unschedule_event ($timestamp, 'wpinfectscannercronjob');
    
    $timestamp = wp_next_scheduled ('wpinfectscanneripupdatecronjob');
	wp_unschedule_event ($timestamp, 'wpinfectscanneripupdatecronjob');
    
    require_once('scannerdata/wpinfectsecurity.php');
    $secfunc=new WPInfectSecurity();
    
    $res=$secfunc->security_filehogo(0);
    $res=$secfunc->security_badqueryblock(0);
    $res=$secfunc->security_serverhogo(0);
    $res=$secfunc->security_blockwlwmanifest(0);
    $res=$secfunc->security_authorhogo(0);
    $res=$secfunc->security_noindex(0);
    $res=$secfunc->security_noproxycomment(0);
    $res=$secfunc->security_spambot(0);
    $res=$secfunc->security_nowpscan(0);
    $res=$secfunc->security_tracktrace(0);
    $res=$secfunc->security_nodirectaccessincludes(0);
    $res=$secfunc->security_nouploadfolderphp(0);
    $res=$secfunc->security_nobadquery(0);
    $res=$secfunc->security_searchnoindex(0);
    $res=$secfunc->security_blockip2(0);
    //X $res=$secfunc->security_advanceipblock(0);
    
    $securytysetting=array();
    $securytysetting['security_kantansettei']=0;
    $securytysetting['security_wphideversion']=0;
    $securytysetting['security_loginlockdown']=0;
    $securytysetting['security_logincaptcha']=0;
    $securytysetting['security_pwresetcaptcha']=0;
    $securytysetting['security_noedit']=0;
    $securytysetting['security_filehogo']=0;
    $securytysetting['security_badqueryblock']=0;
    $securytysetting['security_serverhogo']=0;
    $securytysetting['security_blockwlwmanifest']=0;
    $securytysetting['security_authorhogo']=0;
    $securytysetting['security_nopingback']=0;
    $securytysetting['security_norestapi']=0;
    $securytysetting['security_noindex']=0;
    $securytysetting['security_noproxycomment']=0;
    $securytysetting['security_loginchange']=0;
    $securytysetting['security_commentcaptcha']=0;
    $securytysetting['security_spambot']=0;
    $securytysetting['security_nowpscan']=0;
    $securytysetting['security_tracktrace']=0;
    $securytysetting['security_bruteforthlockdown']=0;
    $securytysetting['security_nodirectaccessincludes']=0;
    $securytysetting['security_nouploadfolderphp']=0;
    $securytysetting['security_nobadquery']=0;
    $securytysetting['security_searchnoindex']=0;
    
    $securytysettingTXT = json_encode($securytysetting);
    
    update_option( 'wpinfectscanner_security', $securytysettingTXT);
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'infectscannerdata';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);
    
    $table_name = $wpdb->prefix . 'infectscannerdata_db';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);
    
    $table_name = $wpdb->prefix . 'infectscannernfblock';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);
    
    $table_name = $wpdb->prefix . 'infectscannerrealtimeblock';
    $sql = "DROP TABLE IF EXISTS ".$table_name;
    $wpdb->query($sql);
    
    delete_option( 'wpinfectscanner_autoblockip');
    delete_option( 'wpinfectscanner_advanceblockip');
    delete_option( 'wpinfectscan_db_version' );
    delete_option( 'wpinfectscan_db_version_db' );
    delete_option( 'wpinfectscanner_newdbstructure1.9.2' );
    delete_option( 'wpinfectscanner_newdbstructure1.9.5' );
    delete_option( 'wpinfectscan_localwhitelist' );
    delete_option( 'wpinfectscanner_attackpattern' );
    
    delete_option( 'wpinfectscanner_cron_autoscan_info' );
    delete_option( 'wpinfectscanner_cron_starttime_info' );
    
    delete_option( 'wpinfectscanner_cron_vulautoscan_info' );
    
    delete_option( 'wpinfectscanner_cron_mailsend_info' );
    delete_option( 'wpinfectscanner_cron_mailaddr_info' );
    delete_option( 'wpinfectscanner_hidealert_info' );
    delete_option( 'wpinfectscanner_lastpatternget' );
    delete_option( 'wpinfectscanner_malwarepattern' );
    delete_option( 'wpinfectscanner_newpatternnum' );
    delete_option( 'wpinfectscanner_detectionpower' );
    delete_option( 'wpinfectscanner_newpatterndetail' );
    delete_option( 'wpinfectscanner_whitelist' );
    
    delete_option( 'wpinfectscanner_security' );
    delete_option( 'wpinfectscanner_loginurl' );
    delete_option( 'wpinfectscanner_alert' );
    delete_option( 'wpinfectscanner_contractto' );
    delete_option( 'wpinfectscanner_blockip' );
    delete_option( 'wpinfectscanner_realtimeblock' );
    delete_option( 'wpinfectscanner_cron_lastemailsend_info' );
    delete_option( 'wpinfectscan_nfblock_version' );
    delete_option( 'wpinfectscan_dbrtb_version' );
    delete_option( 'wpinfectscanner_realtimeblockkey' );
    
    delete_option( 'wpinfectscanner_protecthtaccessindexphp' );
    delete_option( 'wpinfectscanner_rhtaccesscode' );
    delete_option( 'wpinfectscanner_rindexcode' );
    
    delete_option( 'wpinfectscanner_noindexsearchresult');
    
    delete_option( 'wpinfectscanner_hackmonitor' );
    delete_option( 'wpinfectscanner_hackmonitor_logcount' );
    delete_option( 'wpinfectscanner_autoblock_valunarability_attack');
    delete_option( 'wpinfectscanner_autoblock_valunarability_attack_length');
    delete_option( 'wpinfectscanner_autoblock_wpscan_attack');
    delete_option( 'wpinfectscanner_autoblock_wpscan_attack_length');
    delete_option( 'wpinfectscanner_autoblock_bruteforth_attack');
    delete_option( 'wpinfectscanner_autoblock_bruteforth_attack_length');
    delete_option( 'wpinfectscanner_autoblock_cookie_attack');
    delete_option( 'wpinfectscanner_autoblock_cookie_attack_length');
	
    $res = $secfunc->security_ipblock();
    $res = $secfunc->wpinfecscan_deactivated();
	
	delete_option( 'wpinfectscanner_csp');
	
	$res = $secfunc->security_csp(0);
    
} 
register_deactivation_hook (__FILE__, 'wpinfectscannercron_deactivate');

////////////////

/////AJAX///////

function realtimerun(){

    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    $scanner->timezone=get_option('timezone_string');
    $res=explode(":",$scanner->run(ABSPATH,false,120));
    
    if($res[0]=="doneok"){
        $data['status'] = "doneok";
        echo json_encode($data);
    }else{
        $data['status']="error";
        $data['d1'] = $res[1];
        echo json_encode($data);
    }

    die();
}
add_action( 'wp_ajax_realtimerun', 'realtimerun' );

include_once('scannerdata/getscanprocess_inc.php');

function infeccodegetter(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
            
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }


    global $wpdb;
    $table_name = $wpdb->prefix . 'infectscannerdata';
            
    $query = $wpdb->prepare( "SELECT * FROM ".$table_name." where filepath = %s and filename = %s and infectedflag=1 LIMIT 1;",$fpath,$ffile);
    

    $rows = $wpdb->get_results($query);
    if($wpdb->num_rows>0){
        
        if (! file_exists(ABSPATH.$fpath.$ffile)) {
            echo "nofile";
            die();
        }
                      
        $fileContent = htmlspecialchars (file_get_contents(ABSPATH.$fpath.$ffile));
        $fileContent = base64_encode ($fileContent);
        
        echo $fileContent;
                                                
    }
    
    die();
}
add_action( 'wp_ajax_infeccodegetter', 'infeccodegetter' );

function infeccodegetter_db(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
            
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }
  
    global $wpdb;
    $table_name_db = $wpdb->prefix . 'infectscannerdata_db';
    
    //wp_options-option_value-956-option_id
    $dbdata = explode("-",$fpath.$ffile);
    if(count($dbdata)==4){
        $dbname = esc_sql($dbdata[0]);
        $rowname = esc_sql($dbdata[1]);
        $dbidname = esc_sql($dbdata[3]);
        $dbid = esc_sql($dbdata[2]);
        $datasql = "SELECT * FROM `".$table_name_db."` WHERE dbname='".$dbname."' and dbrowname='".$rowname."' and dbidname='".$dbidname."' and dbid='".$dbid."' and infectedflag>0";
        $data = $wpdb->get_results($datasql);
        if(count($data)>0){
            $exists = $wpdb->get_results("SELECT * from ".$dbname." where ".$dbidname."= ".$dbid."");
            if(count($exists)>0){
                $strdata = $exists[0]->$rowname;
                $unserializedata = unserialize( $strdata );
                if(! empty($unserializedata)){
                    echo "1".base64_encode (htmlspecialchars ($strdata));
                }else{
                    echo "0".base64_encode (htmlspecialchars ($strdata));
                }
            }else{
                echo "nofile";
            }
        }else{
            echo "nofile";
        }
    }else{
        echo "nofile";
    }
    
    die();
}
add_action( 'wp_ajax_infeccodegetter_db', 'infeccodegetter_db' );

function infeccodedelete(){

    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }

    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();

    global $wpdb;
    $table_name = $wpdb->prefix . 'infectscannerdata';
            
    $query = $wpdb->prepare( "SELECT * FROM ".$table_name." where filepath = %s and filename = %s and infectedflag=1 LIMIT 1;",$fpath,$ffile);
    

    $rows = $wpdb->get_results($query);
    if($wpdb->num_rows>0){
        
        if (file_exists(ABSPATH.$fpath.$ffile)) {
            $ebefore = file_get_contents(ABSPATH.$fpath.$ffile);
            $eafter = "delete";
            $scanner->test_phperrorcheck($fpath,$ffile,$ebefore,$eafter);
        }
        
        //// --Set writable permission-- ////
        $oldpermission = false;
        $setpermissionfilepath = ABSPATH.$fpath;
        if (! is_writable($setpermissionfilepath)) {
            $filepermget = @fileperms($setpermissionfilepath);
            if(! empty($filepermget)){
                $oldpermission = substr(sprintf("%o",$filepermget), -4);
                @chmod($setpermissionfilepath, 0777);
                @chmod(ABSPATH.$fpath.$ffile, 0777);
            }
        }
        //// --Set writable permission-- ////
            
        $res = unlink ( ABSPATH.$fpath.$ffile );
        
        //// --Set writable permission-- ////
        if (! empty($oldpermission) && strlen($oldpermission)==4) {
            @chmod($setpermissionfilepath, octdec($oldpermission));
        }
        //// --Set writable permission-- ////
        
        if($res){
            $wpdb->get_results("DELETE from ".$table_name." where id= ".$rows[0]->id." limit 1");
            echo "ok";
        }else{
            echo "fail";
        }
                                                
    } else {
        echo "fail";
    }
    
    die();
}
add_action( 'wp_ajax_infeccodedelete', 'infeccodedelete' );


function infeccodedelete_db(){

   
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }
    
    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    

    global $wpdb;
    $table_name_db = $wpdb->prefix . 'infectscannerdata_db';
    
    //wp_options-option_value-956-option_id
    $dbdata = explode("-",$fpath.$ffile);
    if(count($dbdata)==4){
        $dbname = esc_sql($dbdata[0]);
        $rowname = esc_sql($dbdata[1]);
        $dbidname = esc_sql($dbdata[3]);
        $dbid = esc_sql($dbdata[2]);
        $datasql = "SELECT * FROM `".$table_name_db."` WHERE dbname='".$dbname."' and dbrowname='".$rowname."' and dbidname='".$dbidname."' and dbid='".$dbid."' and infectedflag>0";
        $data = $wpdb->get_results($datasql);
        if(count($data)>0){
            
            $exists = $wpdb->get_results("SELECT * from ".$dbname." where ".$dbidname."= ".$dbid." limit 1");
            if(count($exists)>0){
                $result = $wpdb->query("DELETE from ".$dbname." where ".$dbidname."= ".$dbid." limit 1");
                
                $fpath = $dbname;
                $ffile = $rowname;
                $ebefore = $exists[0]->$rowname;
                $eafter = "delete";
                $scanner->test_phperrorcheck("DB:".$dbid.":".$fpath,$ffile,$ebefore,$eafter);
                
            }else{
                $result=true;
            }
            if($result){
                $sqldddel = "DELETE FROM `".$table_name_db."` WHERE dbname='".$dbname."' and dbrowname='".$rowname."' and dbidname='".$dbidname."' and dbid='".$dbid."'";
                $wpdb->query($sqldddel);
                
                echo "ok";
            }else{
                echo "fail";
            }
        }else{
            echo "fail";
        }
    }else{
        echo "fail";
    }
    
    die();
}
add_action( 'wp_ajax_infeccodedelete_db', 'infeccodedelete_db' );

function infeccodechange_db(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
	
	global $wp_version;
    
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];
    if ( version_compare( $wp_version, '5.0', '<' ) ) {
        $ccode=rawurldecode(wp_unslash($_POST['code']));
    }else{
        $ccode=rawurldecode($_POST['code']);
    }

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }

    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    
    global $wpdb;
    $table_name_db = $wpdb->prefix . 'infectscannerdata_db';
    
    //wp_options-option_value-956-option_id
    $dbdata = explode("-",$fpath.$ffile);
    if(count($dbdata)==4){
        $dbname = esc_sql($dbdata[0]);
        $rowname = esc_sql($dbdata[1]);
        $dbidname = esc_sql($dbdata[3]);
        $dbid = esc_sql($dbdata[2]);
        $datasql = "SELECT * FROM `".$table_name_db."` WHERE dbname='".$dbname."' and dbrowname='".$rowname."' and dbidname='".$dbidname."' and dbid='".$dbid."' and infectedflag>0";
        $data = $wpdb->get_results($datasql);
        if(count($data)>0){
            
            if($_POST['serializedata']==1){
                $atai=unserialize($ccode);
                if(empty($atai)){ 
                    echo "fail_structure";
                    die();
                }
                
            }
            
            $exists = $wpdb->get_results("SELECT * from ".$dbname." where ".$dbidname."= ".$dbid." limit 1");
            if(count($exists)>0){
                $fpath = $dbname;
                $ffile = $rowname;
                $ebefore = $exists[0]->$rowname;
                $eafter = $ccode;
                $scanner->test_phperrorcheck("DB:".$dbid.":".$fpath,$ffile,$ebefore,$eafter);
            }
            
            $wpdb->query("UPDATE ".$dbname." SET ".$rowname." = '".esc_sql($ccode)."' where ".$dbidname."=".$dbid.";");
            
            $fhash=md5($ccode);
            $infec = $scanner->onedbscan($dbname,$rowname,$dbidname,$dbid,$fhash);
            if($infec==false){
                
                $sqldddel = "DELETE FROM `".$table_name_db."` WHERE dbname='".$dbname."' and dbrowname='".$rowname."' and dbidname='".$dbidname."' and dbid='".$dbid."'";
                $wpdb->query($sqldddel);
                
                echo "ok2";
            }else{
                echo "ok1";
            }
            
        }else{
            echo "fail";
        }
    }else{
        echo "fail";
    }
    
    die();
}
add_action( 'wp_ajax_infeccodechange_db', 'infeccodechange_db' );


function infeccodechange(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
	global $wp_version;
	
    $fpath=$_POST['pfile'];
    $ffile=$_POST['gfile'];
    if ( version_compare( $wp_version, '5.0', '<' ) ) {
        $ccode=rawurldecode(wp_unslash($_POST['code']));
    }else{
        $ccode=rawurldecode($_POST['code']);
    }

    if(!isset($fpath)){
        die();
    }

    if(!isset($ffile)){
        die();
    }

    require_once('scannerdata/wpinfectscanner.php');
    $scanner=new MalwareScanner();
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'infectscannerdata';
            
    $query = $wpdb->prepare( "SELECT * FROM ".$table_name." where filepath = %s and filename = %s and infectedflag=1 LIMIT 1;",$fpath,$ffile);
    
    $rows = $wpdb->get_results($query);
    if($wpdb->num_rows>0){
        
        //// --Set writable permission-- ////
        $oldpermission = false;
        $setpermissionfilepath = ABSPATH.$fpath.$ffile;
        if (! is_writable($setpermissionfilepath)) {
            $filepermget = @fileperms($setpermissionfilepath);
            if(! empty($filepermget)){
                $oldpermission = substr(sprintf("%o",$filepermget), -4);
                @chmod($setpermissionfilepath, 0777);
            }
        }
        //// --Set writable permission-- ////
           
        $ebefore = @file_get_contents(ABSPATH.$fpath.$ffile);
        $res = file_put_contents(ABSPATH.$fpath.$ffile, $ccode);
        
        //// --Set writable permission-- ////
        if (! empty($oldpermission) && strlen($oldpermission)==4) {
            @chmod($setpermissionfilepath, octdec($oldpermission));
        }
        //// --Set writable permission-- ////
        
        if($res!==false){
            $fhash=md5($ccode);
            $infec = $scanner->onefilescan($ccode,$fhash);
            if($infec==false){
                
                $eafter = $ccode;
                $scanner->test_phperrorcheck($fpath,$ffile,$ebefore,$eafter);
                
                $wpdb->get_results("UPDATE ".$table_name." SET `filehash` = '".$fhash."', `size` = '".strlen($ccode)."', `infectedflag` = '0', `maindbflaged` = '0', `matchline` = '' WHERE id= ".$rows[0]->id." limit 1");
                
                echo "ok2";
            }else{
                echo "ok1";
            }
        }else{
            echo "fail";
        }
                                                
    } else {
        echo "fail";
    }
    
    die();
}
add_action( 'wp_ajax_infeccodechange', 'infeccodechange' );

function wpinfectscanner_valncheck(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $chackdata=$_POST['chackdata'];

    if(!isset($chackdata)){
        die();
    }
    
    require_once('scannerdata/wpinfectexploit.php');
    $scanner=new WPInfectExploit();
    $res = $scanner->scanexploit($chackdata);
    
    if($res!="blocked"){
        $checkdata = json_decode($res,false);
        if(is_array($checkdata)){
            update_option( 'wpinfectscanner_valncheck',$res);
            update_option( 'wpinfectscanner_valnchecktime',date_i18n ("Y/m/d H:i:s"));
        }
    }
    
    echo $res;
    
    die();
}
add_action( 'wp_ajax_wpinfectscanner_valncheck', 'wpinfectscanner_valncheck' );

function wpinfectscanner_userpasscheck(){
    
    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $usernum=$_POST['usernum'];

    if(!isset($usernum)){
        die();
    }
    
    require_once('scannerdata/wpinfectexploit.php');
    $scanner=new WPInfectExploit();
    $res = $scanner->scanuserpass($usernum);
    
    
    echo $res;
    
    die();
}
add_action( 'wp_ajax_wpinfectscanner_userpasscheck', 'wpinfectscanner_userpasscheck' );


function wpinfectscanner_changepage(){

    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $page=trim(sanitize_text_field($_POST['page']));
    $pcount=trim(sanitize_text_field($_POST['pcount']));
    
    if($page>0){
        $page = $page-1;
    }else{
        $page = 0;
    }
    
    global $wpdb;
    
    $tablename = $wpdb->prefix."infectscannernfblock";
    $query = $wpdb->prepare( "SELECT * FROM `%1s` ORDER BY lastdetect DESC limit %d,%d",$tablename,$page*$pcount,$pcount);
    
    $nfblockres = $wpdb->get_results($query);
    
    $output = "";
    
    $blockips = get_option( 'wpinfectscanner_blockip',-1);
    if($blockips===-1){
        $blockips = "";
    }else{
        $blockips = unserialize($blockips);
    }        
    
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
            $showquery=str_replace('"','',$showquery);
            $showquery=str_replace('{','',$showquery);
            $showquery=str_replace('}','',$showquery);
            $showquery=str_replace(':','=',$showquery);
            $showquery = htmlspecialchars (mb_strimwidth($showquery, 0, 255, '...'));
            
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
            
            if(! empty($row->autoblocklimit)){
                $ipblockbutton .= "<small style='font-color:red'><br>".__("This Ip was auto blocked <br>till","wpinfecscan")." ".$row->autoblocklimit."</small>";
            }
        
            $output .= "<tr><td>".esc_html($detecttime)."</td><td>".__($hacktype,"wpinfecscan")."</td><td><a href='https://www.abuseipdb.com/check/".esc_html($ip)."' target='_blank'>".esc_html($ip)."</a></td><td>".esc_html($accessedfile)."</td><td class='showq'>".esc_html($showquery)."</td><td nowrap>".esc_html($detectcount)."</td><td nowrap>".$ipblockbutton."</td></tr>";
        }
    }
    
    echo esc_html(base64_encode($output));

    die();
}
add_action( 'wp_ajax_wpinfectscanner_changepage', 'wpinfectscanner_changepage' );

function wpinfecscan_convert_tz($time, $from_tz, $to_tz)
{
    $date = new DateTime($time, new DateTimeZone($from_tz));
    $date->setTimezone(new DateTimeZone($to_tz));
    return $date->format('Y-m-d H:i:s');
}
    
function wpinfectscanner_blockip(){

    if ( ! current_user_can( 'manage_options' ) ) {
        die();
    }
    
    $ip=trim(base64_decode(sanitize_text_field($_POST['ip'])));
    
    if(! filter_var($ip, FILTER_VALIDATE_IP)){
        echo "-1";
        die();
    }
    
    $mode=trim(sanitize_text_field($_POST['mode']));
    $limit=trim(sanitize_text_field($_POST['limit']));
    
    $settingarray = array("1hour","24hour","Forever");
    if(! in_array($limit,$settingarray)){
        $limit="Forever";
    }
    
    if($mode != 1){
        $mode = 0;
    }
    
    $blockips = get_option( 'wpinfectscanner_blockip',-1);
    if($blockips===-1){
        update_option( 'wpinfectscanner_blockip', "" );
        $blockips_set = "";
        if($mode == 1){
            $blockips_set = array();
            $blockips_set []= array(date_i18n("Y-m-d H:i:s"),$ip,$limit);
        }
        $blockips_set = serialize($blockips_set);
    }else{
        $blockips = unserialize($blockips);
        if($mode == 1){
            $blockips_set = array();
            if(empty($blockips) || ! is_array($blockips)){
                $blockips =  array();
            }
            foreach ($blockips as $blockip){
                if($blockip[1]!=$ip){
                    $blockips_set []= $blockip;
                }
            }
            $blockips_set []= array(date_i18n("Y-m-d H:i:s"),$ip,$limit);
            $blockips_set = serialize($blockips_set);
        }else{
            $blockips_set = array();
            foreach($blockips as $b){
                if($b[1] != $ip ){
                    $blockips_set []= $b;
                }
            }
            if(count($blockips_set)==0){
                $blockips_set = "";
            }else{
                $blockips_set = serialize($blockips_set);
            }
        }
    }
    
    update_option( 'wpinfectscanner_blockip', $blockips_set );
    require_once('scannerdata/wpinfectsecurity.php');
    $security=new WPInfectSecurity();
    $res = $security->security_ipblock();
    //$res = true;
    
    if(! $res){
        echo "-1";
        die();
    }
    
    if($mode != 1){
        global $wpdb;
        $table_name = $wpdb->prefix . 'infectscannernfblock';
        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $query =  $wpdb->prepare("SELECT * FROM `%1s` where ipv6 = %s",$table_name,$ip);
        }else{
            $query =  $wpdb->prepare("SELECT * FROM `%1s` where ipv4 = %s",$table_name,$ip);
        }
        $nfblockres = $wpdb->get_results($query);
        $timezonest = wp_timezone_string();
        foreach( $nfblockres as $key => $row) {
             $rowid = $row->id;
             $autoblocklimit = trim($row->autoblocklimit);
             if(! empty($autoblocklimit)){
                 $gmtime = wpinfecscan_convert_tz($autoblocklimit, $timezonest, "UTC");
                 if(strtotime($gmtime) > time()){
                    $sqlupdate = $wpdb->prepare("UPDATE `%1s` SET `autoblocklimit` = '' WHERE `id` = %d;",$table_name,$rowid);
                    $wpdb->get_results($sqlupdate);
                 }
             }
        }
    }
    
    if($mode == 1){
        echo "1";
    }else{
        echo "0";
    }

    die();
}
add_action( 'wp_ajax_wpinfectscanner_blockip', 'wpinfectscanner_blockip' );
///AJAX END

function wpinfectscanner_base64_encode_removeeq($txt){
    $txt = base64_encode($txt);
    $txt = str_replace("=","",$txt);
    return $txt;
}


function wpinfecscan_admin_notice__error() {
    
    if ( !current_user_can( 'manage_options' ) )  {
		return;
	}
    
    $ar = get_option( 'wpinfectscanner_hidealert_info' ,-1 );
    
    if($ar!=1){
        
        $ptext = "";
        $koudokutext = "";
        $exptext = "";
        $ptcount = get_option( 'wpinfectscanner_newpatternnum');

        $ptar = explode(",",$ptcount);
        if(count($ptar)>=2){
            $ptcount=0;
            $koudokutext = $ptar[1];
        }
        
        if($ptcount>0){
            $class = 'notice notice-warning';
            $message = __("The definition file of WordPress malware scanner is not the latest version. Please update from [Malware Scan] in the administration display.",'wpinfecscan') ;

            printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'infectscannerdata';
        if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            $query = "SELECT COUNT(id) FROM ".$table_name." where infectedflag=1 or (infectedflag=2 and maindbflaged=1);";
            $rows = $wpdb->get_var($query);
            if ($rows>0){
                $class = 'notice notice-error';
                $message = __("Detected malware infection. Please check from [Malware Scan] in the administration display.",'wpinfecscan') ;

                printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
            }
        }
    }
    
    if(function_exists("wpinfectlitescanner_isactive")){
        $class = 'notice notice-error';
        $message = __("Wp-Doctor Malware scan plugin Lite has been detected; if you are using the Pro version, please stop and remove the Lite version",'wpinfecscan') ;

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }
}
add_action( 'load-index.php', 
    function(){
        add_action( 'admin_notices', 'wpinfecscan_admin_notice__error' );
    }
);

add_action( 'admin_menu', 'wpinfectscan_plugin_menu' );

function register_mysettings() { 

    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_autoscan_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_starttime_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_vulautoscan_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_mailsend_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_mailaddr_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_cron_lastemailsend_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_hidealert_info' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_lastpatternget' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_malwarepattern' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_newpatternnum' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_detectionpower' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_newpatterndetail' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_whitelist' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_security' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_loginurl' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_alert' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_contractto' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_blockip' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblockip' );
    //X register_setting( 'wpinfecscanner-group', 'wpinfectscanner_advanceblockip' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_realtimeblock' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_realtimeblockkey' );
    
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_hackmonitor' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_hackmonitor_logcount' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_valunarability_attack' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_valunarability_attack_length' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_wpscan_attack' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_wpscan_attack_length' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_bruteforth_attack' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_bruteforth_attack_length' );
	register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_cookie_attack' );
    register_setting( 'wpinfecscanner-group', 'wpinfectscanner_autoblock_cookie_attack_length' );
    
    
    $setting_autoscan = get_option( 'wpinfectscanner_cron_autoscan_info',-1);
    if($setting_autoscan===-1){
        update_option( 'wpinfectscanner_cron_autoscan_info', '1' );
    }
    
    $setting_autoscantime = get_option( 'wpinfectscanner_cron_starttime_info' ,-1);
    if($setting_autoscantime===-1){
        update_option( 'wpinfectscanner_cron_starttime_info', '3' );
    }
    
    $setting_vulautoscan = get_option( 'wpinfectscanner_cron_vulautoscan_info',-1);
    if($setting_vulautoscan===-1){
        update_option( 'wpinfectscanner_cron_vulautoscan_info', '0' );
    }
    
    
    $setting_email = get_option( 'wpinfectscanner_cron_mailsend_info' ,-1);
    if($setting_email===-1){
        update_option( 'wpinfectscanner_cron_mailsend_info', '0' );
    }
    
    $setting_emailaddr = get_option( 'wpinfectscanner_cron_mailaddr_info',-1);
    if($setting_emailaddr===-1){
        update_option( 'wpinfectscanner_cron_mailaddr_info', get_option( 'admin_email' ) );
    }
    
    $hidealert = get_option( 'wpinfectscanner_hidealert_info',-1);
    if($hidealert===-1){
        update_option( 'wpinfectscanner_hidealert_info', 0 );
    }
    
    $lastpatternget = get_option( 'wpinfectscanner_lastpatternget',-1);
    if($lastpatternget===-1){
        $datebeforeonemonth = date("Y-m-d H:i:s", strtotime('-1 month', time()));
        update_option( 'wpinfectscanner_lastpatternget', $datebeforeonemonth);
    }
    
    $malwarepattern = get_option( 'wpinfectscanner_malwarepattern',-1);
    if($malwarepattern===-1){
        update_option( 'wpinfectscanner_malwarepattern', "" );
    }
    
    $newpatternnum = get_option( 'wpinfectscanner_newpatternnum',-1);
    if($newpatternnum===-1){
        update_option( 'wpinfectscanner_newpatternnum', 0 );
    }
    
    $newpatternnum = get_option( 'wpinfectscanner_detectionpower',-1);
    if($newpatternnum===-1){
        update_option( 'wpinfectscanner_detectionpower', 100 );
    }
    
    $newpatterndetail = get_option( 'wpinfectscanner_newpatterndetail',-1);
    if($newpatterndetail===-1){
        update_option( 'wpinfectscanner_newpatterndetail', "" );
    }
    
    $whitelist = get_option( 'wpinfectscanner_whitelist',-1);
    if($whitelist===-1){
        update_option( 'wpinfectscanner_whitelist', "" );
    }
    
    $security = get_option( 'wpinfectscanner_security',-1);
    if($security===-1){
        update_option( 'wpinfectscanner_security', "" );
    }
    
    $loginurl = get_option( 'wpinfectscanner_loginurl',-1);
    if($loginurl===-1){
        update_option( 'wpinfectscanner_loginurl', "" );
    }
    
    $wpialert = get_option( 'wpinfectscanner_alert',-1);
    if($wpialert===-1){
        update_option( 'wpinfectscanner_alert', "" );
    }
    
    $contractto = get_option( 'wpinfectscanner_contractto',-1);
    if($contractto===-1){
        update_option( 'wpinfectscanner_contractto', '' );
    }
    
    $setting_blockip = get_option( 'wpinfectscanner_blockip',-1);
    if($setting_blockip===-1){
        update_option( 'wpinfectscanner_blockip', '' );
    }
    
    $setting_autoblockip = get_option( 'wpinfectscanner_autoblockip',-1);
    if($setting_autoblockip===-1){
        update_option( 'wpinfectscanner_autoblockip', '' );
    }
    
    //X $setting_advanceblockip = get_option( 'wpinfectscanner_advanceblockip',-1);
    //X if($setting_advanceblockip===-1){
        //X update_option( 'wpinfectscanner_advanceblockip', '' );
    //X }
    
    $setting_realtimeblock = get_option( 'wpinfectscanner_realtimeblock',-1);
    if($setting_realtimeblock===-1){
        update_option( 'wpinfectscanner_realtimeblock', '0' );
    }
    
    $setting_realtimeblockkey = get_option( 'wpinfectscanner_realtimeblockkey',-1);
    if($setting_realtimeblock===-1){
        update_option( 'wpinfectscanner_realtimeblockkey', "" );
    }
    
    $setting_hackmonitor = get_option( 'wpinfectscanner_hackmonitor',-1);
    if($setting_hackmonitor===-1){
        update_option( 'wpinfectscanner_hackmonitor', '0' );
    }
    
    $setting_hackmonitor_logcount = get_option( 'wpinfectscanner_hackmonitor_logcount' ,-1);
    if($setting_hackmonitor_logcount===-1){
        update_option( 'wpinfectscanner_hackmonitor_logcount', 'infinity' );
    }
    
    
    $setting_autoblock_valunarability_attack = get_option( 'wpinfectscanner_autoblock_valunarability_attack',-1);
    if($setting_autoblock_valunarability_attack===-1){
        update_option( 'wpinfectscanner_autoblock_valunarability_attack', '0' );
    }
    $setting_autoblock_wpscan_attack = get_option( 'wpinfectscanner_autoblock_wpscan_attack',-1);
    if($setting_autoblock_wpscan_attack===-1){
        update_option( 'wpinfectscanner_autoblock_wpscan_attack', '0' );
    }
    $setting_autoblock_bruteforth_attack = get_option( 'wpinfectscanner_autoblock_bruteforth_attack',-1);
    if($setting_autoblock_bruteforth_attack===-1){
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack', '0' );
    }
	$setting_autoblock_cookie_attack = get_option( 'wpinfectscanner_autoblock_cookie_attack',-1);
    if($setting_autoblock_cookie_attack===-1){
        update_option( 'wpinfectscanner_autoblock_cookie_attack', '0' );
    }
    
    $setting_autoblock_valunarability_attack_length = get_option( 'wpinfectscanner_autoblock_valunarability_attack_length' ,-1);
    if($setting_autoblock_valunarability_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', '1hour' );
    }
    $setting_autoblock_wpscan_attack_length = get_option( 'wpinfectscanner_autoblock_wpscan_attack_length' ,-1);
    if($setting_autoblock_wpscan_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', '1hour' );
    }
    $setting_autoblock_bruteforth_attack_length = get_option( 'wpinfectscanner_autoblock_bruteforth_attack_length' ,-1);
    if($setting_autoblock_bruteforth_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', '1hour' );
    }
	
	$setting_autoblock_cookie_attack_length = get_option( 'wpinfectscanner_autoblock_cookie_attack_length' ,-1);
    if($setting_autoblock_cookie_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_cookie_attack_length', '1hour' );
    }
    
}

function wpinfectscan_plugin_menu() {
    
    if ( current_user_can( 'manage_options' ) )  {
        $batch =  '';
         global $wpdb;
         $table_name = $wpdb->prefix . 'infectscannerdata';
         if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
            $query = "SELECT COUNT(id) FROM ".$table_name." where infectedflag=1 or (infectedflag=2 and maindbflaged=1);";
            $rows = $wpdb->get_var($query);
            $totalcount = 0;
            if ($rows>0){
                $totalcount = $rows;
            }
            
            $table_name2 = $wpdb->prefix . 'infectscannerdata_db';
            if($wpdb->get_var("SHOW TABLES LIKE '$table_name2'") == $table_name2) {
                $query2 = "SELECT COUNT(DISTINCT patternid,dbname,dbrowname) FROM ".$table_name2." where infectedflag=1 or (infectedflag=2 and maindbflaged=1);";
                $rows2 = $wpdb->get_var($query2);
                if ($rows2>0){
                    $totalcount = $totalcount+$rows2;
                }
            }
            
            if ($totalcount>0){
                $batch =  '<span class="update-plugins count-'.$totalcount.'"><span class="plugin-count">'.$totalcount.'</span></span>';
            }
         }
         

        add_menu_page( "WP malware scanner", __("Malware scan",'wpinfecscan').$batch, 'manage_options', "wpdoctorinfecscanner","wpinfec_my_plugin_options",plugin_dir_url( __FILE__ )."/images/menuicon.png");
        add_action( 'admin_init', 'register_mysettings' );
        
        $lastpatternget = strtotime(get_option( 'wpinfectscanner_lastpatternget',-1));
        $datebefore_6hours = strtotime(date("Y-m-d H:i:s", strtotime('-6 hours', time())));
        if($lastpatternget<$datebefore_6hours){
            $scanner=new MalwareScanner();
            $scanner->loaddatacloud();
        }else{
            if(get_option( 'wpinfectscanner_newpatternnum',-1)>0){
                $scanner=new MalwareScanner();
                if($scanner->getpatternnum()==0){
                    $scanner->loaddatacloud();
                }
            }
        }
    }
    
}

function wpinfecscanget_home_path() {
    $home    = set_url_scheme( get_option( 'home' ), 'http' );
    $siteurl = set_url_scheme( get_option( 'siteurl' ), 'http' );
    if ( ! empty( $home ) && 0 !== strcasecmp( $home, $siteurl ) ) {
        $wp_path_rel_to_home = str_ireplace( $home, '', $siteurl ); /* $siteurl - $home */
        $pos = strripos( str_replace( '\\', '/', $_SERVER['SCRIPT_FILENAME'] ), trailingslashit( $wp_path_rel_to_home ) );
        $home_path = substr( $_SERVER['SCRIPT_FILENAME'], 0, $pos );
        $home_path = trailingslashit( $home_path );
    } else {
        $home_path = ABSPATH;
    }

    return str_replace( '\\', '/', $home_path );
}

function wpinfec_my_plugin_options() {
    
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    
    include_once('scannerdata/headscript_inc.php');
    
    if($securitysettingchanged==false){
        $securytysettingTXT = get_option( 'wpinfectscanner_security');
        if(strlen($securytysettingTXT)>3){
            $securytysetting=json_decode($securytysettingTXT);
            
            $security_kantansettei=$securytysetting->security_kantansettei;
            $security_wphideversion=$securytysetting->security_wphideversion;
            $security_loginlockdown=$securytysetting->security_loginlockdown;
            $security_logincaptcha=$securytysetting->security_logincaptcha;
            $security_pwresetcaptcha=$securytysetting->security_pwresetcaptcha;
            $security_noedit=$securytysetting->security_noedit;
            $security_filehogo=$securytysetting->security_filehogo;
            $security_badqueryblock=$securytysetting->security_badqueryblock;
            $security_serverhogo=$securytysetting->security_serverhogo;
            
            if(! isset($securytysetting->security_blockwlwmanifest)){
                $security_blockwlwmanifest=0;
            }else{
                $security_blockwlwmanifest=$securytysetting->security_blockwlwmanifest;
            }
            if(! isset($security_kantansettei) && isset($security_loginlockdown)){
                $security_kantansettei=4;
            }
            
            
            $security_authorhogo=$securytysetting->security_authorhogo;
            $security_nopingback=$securytysetting->security_nopingback;
            $security_norestapi=$securytysetting->security_norestapi;
            $security_noindex=$securytysetting->security_noindex;
            $security_noproxycomment=$securytysetting->security_noproxycomment;
            $security_loginchange=$securytysetting->security_loginchange;
            $security_commentcaptcha=$securytysetting->security_commentcaptcha;
            $security_spambot=$securytysetting->security_spambot;
            $security_nowpscan=$securytysetting->security_nowpscan;
            $security_tracktrace=$securytysetting->security_tracktrace;
            $security_bruteforthlockdown=$securytysetting->security_bruteforthlockdown;
            
            $security_nodirectaccessincludes=$securytysetting->security_nodirectaccessincludes;
            $security_nouploadfolderphp=$securytysetting->security_nouploadfolderphp;
            $security_nobadquery=$securytysetting->security_nobadquery;
            $security_searchnoindex=$securytysetting->security_searchnoindex;
            
            
            if($security_kantansettei==1){
                if($security_nodirectaccessincludes!=1 || $security_nouploadfolderphp!=1){

                    require_once('scannerdata/wpinfectsecurity.php');
                    $secfunc1=new WPInfectSecurity();
                    $res=$secfunc1->security_nodirectaccessincludes(1);
                    if($res){
                        $security_nodirectaccessincludes=1;
                    }
                    $res=$secfunc1->security_nouploadfolderphp(1);
                    if($res){
                        $security_nouploadfolderphp=1;
                    }
                }
            }
            
            if($security_kantansettei==2 || $security_kantansettei==3){
                if($security_nodirectaccessincludes!=1 || $security_nouploadfolderphp!=1 || $security_nobadquery!=1 || $security_searchnoindex!=1 || $security_badqueryblock!=1 ){
                    require_once('scannerdata/wpinfectsecurity.php');
                    $secfunc2=new WPInfectSecurity();
                    $res=$secfunc2->security_nodirectaccessincludes(1);
                    if($res){
                        $security_nodirectaccessincludes=1;
                    }
                    $res=$secfunc2->security_nouploadfolderphp(1);
                    if($res){
                        $security_nouploadfolderphp=1;
                    }
                    $res=$secfunc2->security_nobadquery(1);
                    if($res){
                        $security_nobadquery=1;
                    }
                    $res=$secfunc2->security_searchnoindex(1);
                    if($res){
                        $security_searchnoindex=1;
                    }
                    $res=$secfunc2->security_badqueryblock(1);
                    if($res){
                        $security_badqueryblock=1;
                    }
                }
            }

        }else{
            $security_kantansettei=0;
        }
    }
    
    
    $setting_autoscan = get_option( 'wpinfectscanner_cron_autoscan_info',-1 );
    if($setting_autoscan===-1){
        update_option( 'wpinfectscanner_cron_autoscan_info', '1' );
        $setting_autoscan = 1;
    }
    
    $setting_autoscantime = get_option( 'wpinfectscanner_cron_starttime_info' ,-1 );
    if($setting_autoscantime===-1){
        update_option( 'wpinfectscanner_cron_starttime_info', '3' );
        $setting_autoscantime = 3;
    }
    
    $setting_vulautoscan = get_option( 'wpinfectscanner_cron_vulautoscan_info',-1 );
    if($setting_vulautoscan===-1){
        update_option( 'wpinfectscanner_cron_vulautoscan_info', '0' );
        $setting_vulautoscan = 0;
    }
    
    
    $setting_email = get_option( 'wpinfectscanner_cron_mailsend_info' ,-1 );
    if($setting_email===-1){
        update_option( 'wpinfectscanner_cron_mailsend_info', '0' );
        $setting_email = 0;
    }
    
    $setting_emailaddr = get_option( 'wpinfectscanner_cron_mailaddr_info',-1  );
    if($setting_emailaddr===-1){
        update_option( 'wpinfectscanner_cron_mailaddr_info', get_option( 'admin_email' ) );
        $setting_emailaddr = get_option( 'admin_email' );
    }
    
    $setting_hidealert = get_option( 'wpinfectscanner_hidealert_info',-1  );
    if( $setting_hidealert===-1){
        update_option( 'wpinfectscanner_hidealert_info', 0 );
        $setting_hidealert = get_option( 'wpinfectscanner_hidealert_info' );
    }
    
    
	if ( function_exists( 'set_time_limit' ) ) {
        @set_time_limit(60*10);
    }
    //error_reporting(E_ERROR | E_PARSE);

    $scanok = false;
    if(isset($_POST["dir"])){ 
        if (md5(ABSPATH)==($_POST["dir"])) {
            $scanok = true;
        }
    }
    
    $totalscore=0;
    
    if(! isset($security_wphideversion)){$security_wphideversion=0;}
    if(! isset($security_loginlockdown)){$security_loginlockdown=0;}
    if(! isset($security_logincaptcha)){$security_logincaptcha=0;}
    if(! isset($security_pwresetcaptcha)){$security_pwresetcaptcha=0;}
    if(! isset($security_noedit)){$security_noedit=0;}
    if(! isset($security_filehogo)){$security_filehogo=0;}
    if(! isset($security_badqueryblock)){$security_badqueryblock=0;}
    if(! isset($security_serverhogo)){$security_serverhogo=0;}
    if(! isset($security_blockwlwmanifest)){$security_blockwlwmanifest=0;}
    if(! isset($security_authorhogo)){$security_authorhogo=0;}
    if(! isset($security_nopingback)){$security_nopingback=0;}
    if(! isset($security_norestapi)){$security_norestapi=0;}
    if(! isset($security_noindex)){$security_noindex=0;}
    if(! isset($security_noproxycomment)){$security_noproxycomment=0;}
    if(! isset($security_loginchange)){$security_loginchange=0;}
    if(! isset($security_commentcaptcha)){$security_commentcaptcha=0;}
    if(! isset($security_spambot)){$security_spambot=0;}
    if(! isset($security_nowpscan)){$security_nowpscan=0;}
    if(! isset($security_tracktrace)){$security_tracktrace=0;}
    if(! isset($security_bruteforthlockdown)){$security_bruteforthlockdown=0;}
    if(! isset($security_nodirectaccessincludes)){$security_nodirectaccessincludes=0;}
    if(! isset($security_nouploadfolderphp)){$security_nouploadfolderphp=0;}
    if(! isset($security_nobadquery)){$security_nobadquery=0;}
    if(! isset($security_searchnoindex)){$security_searchnoindex=0;}

    $totalscore=$totalscore+($security_wphideversion*5);
    $totalscore=$totalscore+($security_loginlockdown*8);
    $totalscore=$totalscore+($security_logincaptcha*5);
    $totalscore=$totalscore+($security_pwresetcaptcha*4);
    $totalscore=$totalscore+($security_noedit*3);
    $totalscore=$totalscore+($security_filehogo*4);
    $totalscore=$totalscore+($security_badqueryblock*3);
    $totalscore=$totalscore+($security_serverhogo*3);
    $totalscore=$totalscore+($security_blockwlwmanifest*2);
    $totalscore=$totalscore+($security_authorhogo*2);
    $totalscore=$totalscore+($security_nopingback*2);
    $totalscore=$totalscore+($security_norestapi*2);
    $totalscore=$totalscore+($security_noindex*3);
    $totalscore=$totalscore+($security_noproxycomment*2);
    $totalscore=$totalscore+($security_loginchange*11);
    $totalscore=$totalscore+($security_commentcaptcha*4);
    $totalscore=$totalscore+($security_spambot*3);
    $totalscore=$totalscore+($security_nowpscan*3);
    $totalscore=$totalscore+($security_tracktrace*3);
    $totalscore=$totalscore+($security_bruteforthlockdown*5);
    $totalscore=$totalscore+($security_nodirectaccessincludes*2);
    $totalscore=$totalscore+($security_nouploadfolderphp*2);
    $totalscore=$totalscore+($security_nobadquery*2);
    $totalscore=$totalscore+($security_searchnoindex*2);
    
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
        $res=needfix_filesystem_permission_status($file_or_dir['name'],$file_or_dir['path'],$file_or_dir['permissions']);
        if($res){
            $needfix=true;
            break;
        }
    }
    
    if(!$needfix){
        $totalscore=$totalscore+12;
    }
    
    $totalscore=(int)($totalscore*0.8)+20;
    
    $ptcount = get_option('wpinfectscanner_newpatternnum',0);
    if($ptcount<0){
        $ptcount=0;
    }
    $mcount = ($ptcount/3);
    if($mcount>30){
        $mcount = 30;
    }
    $totalscore = $totalscore - $mcount + 3;
    
    $totalscore = (int)$totalscore;
    if($totalscore<0){
        $totalscore=0;
    }
    if($totalscore>100){
        $totalscore=100;
    }
    
    //IP block options
    $ipblocksettingchanged = false;
    $ipblockdata = $scanner->getipdata();
    
    $hackmonitorchanged_error = "";
    
    if(isset($_POST["ipblocksetting"])){
        
         require_once('scannerdata/wpinfectsecurity.php');
         $secfunc=new WPInfectSecurity();
         
         $wpinfectscanner_hackmonitor = isset($_POST["wpinfectscanner_hackmonitor"]) ? $_POST["wpinfectscanner_hackmonitor"] : 0;
         if($wpinfectscanner_hackmonitor !=0){$wpinfectscanner_hackmonitor=1;}
         update_option( 'wpinfectscanner_hackmonitor', $wpinfectscanner_hackmonitor);
         
         $wpinfectscanner_hackmonitor_logcount = $_POST["wpinfectscanner_hackmonitor_logcount"];
         $logcountsettingarray = array("infinity",10000,5000,1000,500,255);
         if(! in_array($wpinfectscanner_hackmonitor_logcount,$logcountsettingarray)){
            $wpinfectscanner_hackmonitor_logcount="infinity";
         }
         update_option( 'wpinfectscanner_hackmonitor_logcount', $wpinfectscanner_hackmonitor_logcount );
         
         if($scanner->getpro()==1){
             
             $removeallipblocks = false;
             $autoblockip = 0;
             
             if(isset( $_POST["autoblockip"] )){
                $autoblockip = $_POST["autoblockip"];
             }
             if($autoblockip !=0){$autoblockip=1;}
             if($autoblockip == 1){
                
                if(!empty($ipblockdata)){
                    foreach ($ipblockdata as $key => $value){
                        $iplisttxt[]=$value->ip;
                    }
                    update_option("wpinfectscanner_autoblockip",implode("\n",$iplisttxt));
                    $secfunc->security_blockip2($iplisttxt);
                    
                }else{
                    update_option("wpinfectscanner_autoblockip","");
                    $removeallipblocks = true;
                }
             }else{
                update_option("wpinfectscanner_autoblockip","");
                $removeallipblocks = true;
             }
             
             if($removeallipblocks){
                 $secfunc->security_blockip2(0);
             }
             
             $blocklengthsettingarray = array("1hour","24hour","Forever");
             
             $wpinfectscanner_autoblock_valunarability_attack = isset($_POST["wpinfectscanner_autoblock_valunarability_attack"]) ? $_POST["wpinfectscanner_autoblock_valunarability_attack"] : 0;
             if($wpinfectscanner_autoblock_valunarability_attack !=0){$wpinfectscanner_autoblock_valunarability_attack=1;update_option( 'wpinfectscanner_hackmonitor', 1);$wpinfectscanner_hackmonitor=1;}
             update_option( 'wpinfectscanner_autoblock_valunarability_attack', $wpinfectscanner_autoblock_valunarability_attack );
             
             $wpinfectscanner_autoblock_valunarability_attack_length = $_POST["wpinfectscanner_autoblock_valunarability_attack_length"];
             if(! in_array($wpinfectscanner_autoblock_valunarability_attack_length,$blocklengthsettingarray)){
                $wpinfectscanner_autoblock_valunarability_attack_length="1hour";
             }
             update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', $wpinfectscanner_autoblock_valunarability_attack_length );
             
             $wpinfectscanner_autoblock_wpscan_attack = isset($_POST["wpinfectscanner_autoblock_wpscan_attack"]) ? $_POST["wpinfectscanner_autoblock_wpscan_attack"] : 0;
             if($wpinfectscanner_autoblock_wpscan_attack !=0){$wpinfectscanner_autoblock_wpscan_attack=1;update_option( 'wpinfectscanner_hackmonitor', 1);$wpinfectscanner_hackmonitor=1;}
             update_option( 'wpinfectscanner_autoblock_wpscan_attack', $wpinfectscanner_autoblock_wpscan_attack );
             
             $wpinfectscanner_autoblock_wpscan_attack_length = $_POST["wpinfectscanner_autoblock_wpscan_attack_length"];
             if(! in_array($wpinfectscanner_autoblock_wpscan_attack_length,$blocklengthsettingarray)){
                $wpinfectscanner_autoblock_wpscan_attack_length="1hour";
             }
             update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', $wpinfectscanner_autoblock_wpscan_attack_length );
             
             $wpinfectscanner_autoblock_bruteforth_attack = isset($_POST["wpinfectscanner_autoblock_bruteforth_attack"]) ? $_POST["wpinfectscanner_autoblock_bruteforth_attack"] : 0;
             if($wpinfectscanner_autoblock_bruteforth_attack !=0){$wpinfectscanner_autoblock_bruteforth_attack=1;update_option( 'wpinfectscanner_hackmonitor',1);$wpinfectscanner_hackmonitor=1;}
             update_option( 'wpinfectscanner_autoblock_bruteforth_attack', $wpinfectscanner_autoblock_bruteforth_attack );
             
             $wpinfectscanner_autoblock_bruteforth_attack_length = $_POST["wpinfectscanner_autoblock_bruteforth_attack_length"];
             if(! in_array($wpinfectscanner_autoblock_bruteforth_attack_length,$blocklengthsettingarray)){
                $wpinfectscanner_autoblock_bruteforth_attack_length="1hour";
             }
             update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', $wpinfectscanner_autoblock_bruteforth_attack_length );
			 
			 $wpinfectscanner_autoblock_cookie_attack = isset($_POST["wpinfectscanner_autoblock_cookie_attack"]) ? $_POST["wpinfectscanner_autoblock_cookie_attack"] : 0;
             if($wpinfectscanner_autoblock_cookie_attack !=0){$wpinfectscanner_autoblock_cookie_attack=1;update_option( 'wpinfectscanner_hackmonitor',1);$wpinfectscanner_hackmonitor=1;}
             update_option( 'wpinfectscanner_autoblock_cookie_attack', $wpinfectscanner_autoblock_cookie_attack );
             
             $wpinfectscanner_autoblock_cookie_attack_length = $_POST["wpinfectscanner_autoblock_cookie_attack_length"];
             if(! in_array($wpinfectscanner_autoblock_cookie_attack_length,$blocklengthsettingarray)){
                $wpinfectscanner_autoblock_cookie_attack_length="1hour";
             }
             update_option( 'wpinfectscanner_autoblock_cookie_attack_length', $wpinfectscanner_autoblock_cookie_attack_length );
         
         }else{
             
            update_option( 'wpinfectscanner_autoblock_valunarability_attack', '0' );
            update_option( 'wpinfectscanner_autoblock_wpscan_attack', '0' );
            update_option( 'wpinfectscanner_autoblock_bruteforth_attack', '0' );
			update_option( 'wpinfectscanner_autoblock_cookie_attack', '0' );
            update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', '1hour' );
            update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', '1hour' );
            update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', '1hour' );
            update_option( 'wpinfectscanner_autoblock_cookie_attack_length', '1hour' );
         }
         
         $ipblocksettingchanged = true;
         
         if($wpinfectscanner_hackmonitor==1){
             $checkifhackmonitorcanactive = $secfunc->wpinfec_check_hackmonitor_canenable();
             if(! $checkifhackmonitorcanactive){
                update_option( 'wpinfectscanner_hackmonitor', '0' );
                $wpinfectscanner_hackmonitor=0;
                update_option( 'wpinfectscanner_autoblock_valunarability_attack', '0' );
                update_option( 'wpinfectscanner_autoblock_wpscan_attack', '0' );
                update_option( 'wpinfectscanner_autoblock_bruteforth_attack', '0' );
				update_option( 'wpinfectscanner_autoblock_cookie_attack', '0' );
                update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', '1hour' );
                update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', '1hour' );
                update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', '1hour' );
                update_option( 'wpinfectscanner_autoblock_cookie_attack_length', '1hour' );
                $hackmonitorchanged_error = __("The Hack Monitor also logs brute force attacks with weak passwords. Therefore, it cannot be enabled if there is an administrator user who is already using a weak password.",'wpinfecscan');
             }
             
         }
    }
    
    $setting_hackmonitor = get_option( 'wpinfectscanner_hackmonitor',-1 );
    if($setting_hackmonitor===-1){
        update_option( 'wpinfectscanner_hackmonitor', '0' );
        $setting_hackmonitor = 0;
    }
    
    $setting_hackmonitor_logcount = get_option( 'wpinfectscanner_hackmonitor_logcount' ,-1 );
    if($setting_hackmonitor_logcount===-1){
        update_option( 'wpinfectscanner_hackmonitor_logcount', "infinity" );
        $setting_hackmonitor_logcount = "infinity";
    }
    
    $wpinfectscanner_autoblock_valunarability_attack = get_option( 'wpinfectscanner_autoblock_valunarability_attack',-1 );
    if($wpinfectscanner_autoblock_valunarability_attack===-1 || $scanner->getpro()!=1){
        update_option( 'wpinfectscanner_autoblock_valunarability_attack', '0' );
        $wpinfectscanner_autoblock_valunarability_attack = 0;
    }
    
    $wpinfectscanner_autoblock_wpscan_attack = get_option( 'wpinfectscanner_autoblock_wpscan_attack',-1 );
    if($wpinfectscanner_autoblock_wpscan_attack===-1 || $scanner->getpro()!=1){
        update_option( 'wpinfectscanner_autoblock_wpscan_attack', '0' );
        $wpinfectscanner_autoblock_wpscan_attack = 0;
    }
    
    $wpinfectscanner_autoblock_bruteforth_attack = get_option( 'wpinfectscanner_autoblock_bruteforth_attack',-1 );
    if($wpinfectscanner_autoblock_bruteforth_attack===-1 || $scanner->getpro()!=1){
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack', '0' );
        $wpinfectscanner_autoblock_bruteforth_attack = 0;
    }
	
	$wpinfectscanner_autoblock_cookie_attack = get_option( 'wpinfectscanner_autoblock_cookie_attack',-1 );
    if($wpinfectscanner_autoblock_cookie_attack===-1 || $scanner->getpro()!=1){
        update_option( 'wpinfectscanner_autoblock_cookie_attack', '0' );
        $wpinfectscanner_autoblock_cookie_attack = 0;
    }
    
    $wpinfectscanner_autoblock_valunarability_attack_length = get_option( 'wpinfectscanner_autoblock_valunarability_attack_length',-1 );
    if($wpinfectscanner_autoblock_valunarability_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_valunarability_attack_length', '1hour' );
        $wpinfectscanner_autoblock_valunarability_attack_length = '1hour';
    }
    
    $wpinfectscanner_autoblock_wpscan_attack_length = get_option( 'wpinfectscanner_autoblock_wpscan_attack_length',-1 );
    if($wpinfectscanner_autoblock_wpscan_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_wpscan_attack_length', '1hour' );
        $wpinfectscanner_autoblock_wpscan_attack_length = '1hour';
    }
    
    $wpinfectscanner_autoblock_bruteforth_attack_length = get_option( 'wpinfectscanner_autoblock_bruteforth_attack_length',-1 );
    if($wpinfectscanner_autoblock_bruteforth_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_bruteforth_attack_length', '1hour' );
        $wpinfectscanner_autoblock_bruteforth_attack_length = '1hour';
    }
	
	$wpinfectscanner_autoblock_cookie_attack_length = get_option( 'wpinfectscanner_autoblock_cookie_attack_length',-1 );
    if($wpinfectscanner_autoblock_cookie_attack_length===-1){
        update_option( 'wpinfectscanner_autoblock_cookie_attack_length', '1hour' );
        $wpinfectscanner_autoblock_cookie_attack_length = '1hour';
    }
    
    
    $setting_realtimeblock_changed=false;
    $setting_realtimeblock_error="";
    //realtime block
     if(isset($_POST["setting_realtimeblock_ht"])){
         $setting_realtimeblock=0;
         if(isset($_POST["setting_realtimeblock"])){
             $setting_realtimeblock=$_POST["setting_realtimeblock"];
         }
         
         if($setting_realtimeblock==1){
            $rkey = md5(uniqid());
            update_option( 'wpinfectscanner_realtimeblockkey', $rkey );
         }else{
             $setting_realtimeblock=0;
         }
         
         require_once('scannerdata/wpinfectsecurity.php');
         $secfunc=new WPInfectSecurity();
         $res=$secfunc->security_realtimeblock($setting_realtimeblock);
         if($res){
             update_option("wpinfectscanner_realtimeblock",$setting_realtimeblock);
         }else{
             $setting_realtimeblock=get_option( 'wpinfectscanner_realtimeblock',false);
             $setting_realtimeblock_error="<p style='color:red'>". __("Couldn't activate the function.<br>1 Please confirm the htaccess file is writeable.<br>2 Database table is creatable.<br>3 file_get_contents is activated on PHP config.",'wpinfecscan')."</p>";
         }
         $setting_realtimeblock_changed=true;
     }
     
     if(isset($_GET["delrealtime"])){
         
         $setting_realtimeblock_changed=true;
         global $wpdb;
         $table_name = $wpdb->prefix . 'infectscannerrealtimeblock';
         $query = "DELETE FROM ".$table_name;
         $wpdb->get_results($query);
         
     }
     
    if(!empty($ipblockdata)){
        
        if($scanner->getpro() != 1){
            $datautoblockip = get_option("wpinfectscanner_autoblockip");
            if(!empty($datautoblockip)){
                update_option("wpinfectscanner_autoblockip","");
            }
            if(get_option('wpinfectscanner_realtimeblock')==1){
                require_once('scannerdata/wpinfectsecurity.php');
                $secfunc=new WPInfectSecurity();
                $secfunc->security_realtimeblock(0);
                update_option( 'wpinfectscanner_realtimeblock', '0' );
            }
        }
    }
    
    //X $advanceblockip = get_option("wpinfectscanner_advanceblockip");
    //X if($advanceblockip == 1 && $scanner->getpro() != 1){
        //X update_option("wpinfectscanner_advanceblockip","");
                
        //X require_once('scannerdata/wpinfectsecurity.php');
        //X $secfunc=new WPInfectSecurity();
        //X $secfunc->security_advanceipblock(0);
    //X }
    
    $durl = $scanner->phpurl;
    
?>
    
	<link href="<?php echo plugin_dir_url( __FILE__ ); ?>Styles/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo plugin_dir_url( __FILE__ ); ?>Styles/fontawesome/font-awesome.min.css" rel="stylesheet">
    
	<script src="<?php echo plugin_dir_url( __FILE__ ); ?>Scripts/bootstrap.min.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>Scripts/d3.min.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>Scripts/topojson.min.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>Scripts/datamaps.world.min.js"></script>
    <script src="<?php echo plugin_dir_url( __FILE__ ); ?>Scripts/ace-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
    
    <style>
    input[type="checkbox"], input[type="radio"] {
        margin: 0px 4px 0px 0px;
    }
    #scanresult td img {
        float:left;
    }
    #scanresult td .mfound {
        display: flex;
        align-items: center;
        font-weight:bold;
        color:#f99a45;
    }
    #scanresult td .mfound2 {
        display: flex;
        align-items: center;
        font-weight:bold;
        color:#999999;
    }
    #scanresult td .mfound2 mt{
        color:#ee1100;
    }
    #showinfectfiles td small,#scanresult td small {
        display:block;
        clear:both;
    }
    @media screen and (max-width: 550px) {
        .nav {
            padding-left:2px;
            padding-right:2px;
        }
        .nav li {
            display:block !important;
            width:100%;
            margin:0px;
        }
        .nav li.active {
            border-bottom:1px solid #ddd!important;
            margin: 0px;
        }
    }
    #wpwrap{
        background-color:white;
    }
    .nav > li > a {
      padding: 12px 7px !important;
      font-weight: bold;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
        border: 1px solid #aaa !important;
        border-bottom-color: white !important;
    }
    .nav-tabs {
      border-bottom: 1px solid #aaa !important;
    }
    .nav-tabs *:focus {
        box-shadow: none !important;
    }
    </style>
    
	<div class="container" style="max-width:1000px">
		<div style="width:100%;height:261px;background-image: url('<?php echo plugin_dir_url( __FILE__ ); ?>images/<?php _e("title_en.png",'wpinfecscan'); ?>');background-repeat: no-repeat;">

			<form action="<?php echo '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" method='post'>
				<?php if($scanok) { ?>
                    <p><small style="font-size:12px"><?php echo __("*Scanning may take up to 10 minutes to complete. Please wait for a moment.",'wpinfecscan');?></small></p>
					<div class="lead" id="scank" style="clear:both;float:right;margin-top:84px"><i class="fa fa-circle-o-notch fa-spin"></i> <?php _e("Scanning in progress","wpinfecscan"); ?></div>
				<?php }else{ ?>
				<p class="lead"></p>
                    
					<p><small style="font-size:12px">
                    <?php if(strpos(get_locale(),'ja') !== false){ ?>
                    *このプラグインの利用方法、トラブルシューティングは<a href="https://wp-doctor.jp/blog/?p=4677" target="_blank">こちらの記事</a>からご覧ください
                    <?php }else{
                    global $wpinfecscanversion;
                    echo $wpinfecscanversion;
                    }?>
                    </small></p>
                    
					<p class="lead">
						<input type="hidden" name="dir" value="<?php echo md5(ABSPATH); ?>" class="form-control">
					</p>
					<div style="float:right;margin-top:66px">
						<input type="submit" class="btn btn-lg btn-success" value="<?php _e("Start scanning","wpinfecscan"); ?>">
					</div>
                    
				<?php } ?>
			</form>
		</div>
        
        <div style="width:100%;clear:both"><?php 
        $url = $durl ."/ad.php?lang=".get_locale()."&site=".urlencode(site_url());
        $options['ssl']['verify_peer']=false;
        $options['ssl']['verify_peer_name']=false;
        $response = @file_get_contents($url, false, stream_context_create($options));
        if(! empty($response)){
            echo $response;
        }
        ?></div>
        
        <?php if(strpos(get_locale(),'ja') !== false){  ?>
        <div style="height:150px;overflow:auto;margin-top:20px;margin-bottom:25px;border:solid 1px #eee">
            <div style="padding-top:5px;padding-left:15px;padding-right:15px;">
            
            <h5><span class="dashicons dashicons-pressthis"></span> WPドクターセキュリティー関連ニュース</h5>
            <?php
            libxml_use_internal_errors(true);
            $rss = simplexml_load_file(rawurlencode('http://wp-doctor.jp/blog/category/%e3%82%bb%e3%82%ad%e3%83%a5%e3%83%aa%e3%83%86%e3%82%a3%e3%83%bb%e8%84%86%e5%bc%b1%e6%80%a7/feed/'));
            if ($rss === false) {
                echo "Failed loading news\n";
                foreach(libxml_get_errors() as $error) {
                    //echo "\t", $error->message;
                }
            }
            

            echo '<ul>';
            foreach($rss->channel->item as $item){
                $title = $item->title;
                $date = date_i18n ("Y年 n月 j日", strtotime($item->pubDate));
                $link = $item->link;
            ?>
            <li style="margin-bottom:5px;"><a href="<?php echo $link; ?>" target="_blank">
            <span class="date"><?php echo $date; ?></span>
            <span class="title"><?php echo $title; ?></span>
            </a></li>
            <?php }  echo '</ul>'; ?>
            </div>
            
        </div>
        <?php } ?>
        
        <?php
        
        if($scanok) {
            $alerttxt = trim(get_option('wpinfectscanner_alert'));
            if(strlen($alerttxt)>0){
                $scanner=new MalwareScanner();
                $scanner->loaddatacloud();
            }
        }
        
        $mysiteurl = get_site_url();
        $mydomain = parse_url($mysiteurl);
        $mydomain = $mydomain['host'];
        
        $alerttxt = trim(get_option('wpinfectscanner_alert'));
        
        if($mydomain=="localhost" || filter_var($mydomain, FILTER_VALIDATE_IP)){
            echo "<p style='color:red'>".__("Attention!: Use of malware scanner through localhost or IP is restricted to inspection of 100 malware patterns.","wpinfecscan")."</p>
			<style>.malwaredetectionpower{display:none}</style>
			";
            if(! ($alerttxt && strlen($alerttxt)>0)){
                echo "<br>";
            }
        }
        
        if($alerttxt && strlen($alerttxt)>0){
            echo "<p style='color:red'>".__($alerttxt,"wpinfecscan")."</p><br>";
        }
        
        ?>

        <ul class="nav nav-tabs" style="margin-bottom:25px">
            <li class="active"><a href="#ContentA" data-toggle="tab"><?php _e('Malware scan','wpinfecscan'); ?></a></li>
            <li><a href="#ContentB" data-toggle="tab"><?php _e('Setting','wpinfecscan'); ?></a></li>
            <li><a href="#ContentC" data-toggle="tab"><?php _e('Purchase','wpinfecscan'); ?></a></li>
            <li><a href="#ContentE" data-toggle="tab"><?php _e('Security','wpinfecscan'); ?></a></li>
            <li><a href="#ContentH" data-toggle="tab"><?php _e('Vulnerability','wpinfecscan'); ?></a></li>
            <li><a href="#ContentF" data-toggle="tab"><?php _e('Hack monitor & IP blocker','wpinfecscan'); ?></a></li>
            <li><a href="#ContentG" data-toggle="tab"><?php _e('Real-time block','wpinfecscan'); ?></a></li>
			<li><a href="#ContentI" data-toggle="tab"><?php _e('CSP','wpinfecscan'); ?></a></li>
            <?php
                
                $ptcount = get_option( 'wpinfectscanner_newpatternnum');
                $ptar = explode(",",$ptcount);
                if(count($ptar)>=2){
                    $ptcount=0;
                }
                if($ptcount>0){
                    ?><style>#tabcontent_d{display:none !important;}</style>
                        <li id="tabcontent_d"><a href="#ContentD" data-toggle="tab"><?php _e('Pattern not purchased','wpinfecscan'); ?></a></li>
                    <?php
                }
            
            ?>
        </ul>

		<div style="margin-right: -15px;margin-left: -15px;">
            <div class="tab-content" style="display:block">
                <?php require_once('tab_malwrescan.php'); ?>
                <?php require_once('tab_setting.php'); ?>
                <?php require_once('tab_purchase.php'); ?>
                <?php require_once('tab_security.php'); ?>
                <?php require_once('tab_valn.php'); ?>
                <?php require_once('tab_ipblock.php'); ?>
                <?php require_once('tab_realtimeblock.php'); ?>
				<?php require_once('tab_csp.php'); ?>
                <?php require_once('tab_shownotinstalledpatterns.php'); ?>
            </div>  
            <script>
            function showcodenp(){
                alert('<?php echo __("This infection will be displayed after purchased the latest malware definition file.",'wpinfecscan'); ?>');
            }
            
            var editor;
            var nowfilepath;
            var nowfilename;
            var nowtid;
            var loadok = false;
            var codeshowing = true;
            function showcode(filepath,filename,highlight,tid){
                loadok = false;
                jQuery.ajax({
                   type: "POST",
                   url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                   data: "pfile="+filepath+"&gfile="+filename+"&action=infeccodegetter",
                   success: function(msg){
                       if(msg =="nofile"){
                           alert("<?php echo __("Couldn't open the file.",'wpinfecscan'); ?>");
                       }else{
                            jQuery('#myModalLabel').html(filepath+filename);
                            jQuery('.modal-body').html("<div style='width:100%;height:400px' id='infeccode'></div>");
                            jQuery('#myModal').modal('show');
                            jQuery('#infeccode').html(decodeURIComponent(escape(window.atob(msg))));
                            editor = ace.edit("infeccode");
                            editor.setTheme("ace/theme/github");
                            editor.session.setMode("ace/mode/php");
                            editor.session.setUseWrapMode(true);
                            var harray = highlight.split(',');
                            for( var i=0 ; i<harray.length ; i++ ) {
                               editor.session.addGutterDecoration(harray[i]-1,'HighlightBg');
                            }
                            nowfilepath = filepath;
                            nowfilename = filename;
                            nowtid = tid;
                            loadok = true;
                            codeshowing = true;
                            jQuery('#mydeletebutton').html('<?php _e("File deletion","wpinfecscan");?>');
                            
                            jQuery('#highlighttxt').show();
                            jQuery('#serializedtxt').hide();
                       }
                   }
                 });
            }
            
            var serializedata  = 0;
            function showcode_db(filepath,filename,highlight,tid,mytitle){
                loadok = false;
                jQuery.ajax({
                   type: "POST",
                   url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                   data: "pfile="+filepath+"&gfile="+filename+"&action=infeccodegetter_db",
                   success: function(msg){
                       if(msg =="nofile"){
                           alert("<?php echo __("Couldn't load the database data.",'wpinfecscan'); ?>");
                       }else{
                            //alert(msg);
                            if(msg.substr(0,1)=="1"){
                                msg = msg.substr(1);
                                serializedata  = 1;
                                jQuery('#myModalLabel').html(mytitle+" (<?php _e("Serialized data","wpinfecscan");?>)");
                               
                                jQuery('.modal-body').html("<div style='width:100%;height:350px;overflow:auto' id='infeccode'></div>");
                                jQuery('#myModal').modal('show');
                                jQuery('#infeccode').html("<textarea id='syrializedtxtdata' style='width:100%;height:100%'>"+decodeURIComponent(escape(window.atob(msg)))+"</textarea>");
                                
                                editor = ace.edit("infeccode");
                                editor.setTheme("ace/theme/github");
                                editor.session.setMode("ace/mode/php");
                                editor.session.setUseWrapMode(true);
                                
                                var harray = highlight.split(',');
                                for( var i=0 ; i<harray.length ; i++ ) {
                                   editor.session.addGutterDecoration(harray[i]-1,'HighlightBg');
                                }
                                
                                
                                nowfilepath = filepath;
                                nowfilename = filename;
                                nowtid = tid;
                                loadok = true;
                                codeshowing = false;
                                jQuery('#mydeletebutton').html('<?php _e("Databse data deletion","wpinfecscan");?>');
                                
                                jQuery('#highlighttxt').show();
                                jQuery('#serializedtxt').show();
                                
                            }else{
                                msg = msg.substr(1);
                                serializedata  = 0;
                                jQuery('#myModalLabel').html(mytitle);
                                jQuery('.modal-body').html("<div style='width:100%;height:400px' id='infeccode'></div>");
                                jQuery('#myModal').modal('show');
                                jQuery('#infeccode').html(decodeURIComponent(escape(window.atob(msg))));
                                
                                editor = ace.edit("infeccode");
                                editor.setTheme("ace/theme/github");
                                editor.session.setMode("ace/mode/php");
                                editor.session.setUseWrapMode(true);
                                var harray = highlight.split(',');
                                for( var i=0 ; i<harray.length ; i++ ) {
                                   editor.session.addGutterDecoration(harray[i]-1,'HighlightBg');
                                }
                                nowfilepath = filepath;
                                nowfilename = filename;
                                nowtid = tid;
                                loadok = true;
                                codeshowing = false;
                                jQuery('#mydeletebutton').html('<?php _e("Databse data deletion","wpinfecscan");?>');
                                
                                jQuery('#highlighttxt').show();
                                jQuery('#serializedtxt').hide();
                            }
                       }
                   }
                 });
            }
            
            function saveeditedfile(){
                if(loadok == true){
                    if(window.confirm(nowfilename + ' <?php echo __(" - Save changes of the file.",'wpinfecscan'); ?>\n<?php echo __("Note that file editing may cause errors of the website.",'wpinfecscan'); ?>')){
                        var edcode = editor.getValue();
                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: {
                                "pfile": nowfilepath,
                                "gfile": nowfilename,
                                "action": "infeccodechange",
                                "code": encodeURIComponent(edcode),
                           },
                           async: false,
                           success: function(msg){
                               if(msg=="fail"){
                                   alert("<?php echo __("Failed to change the file.",'wpinfecscan'); ?>");
                               }else{
                                   if(msg=="ok2"){
                                        alert("<?php echo __("Changed the file.",'wpinfecscan'); ?>");
                                        jQuery('#myModal').modal('hide');
                                        jQuery("#"+nowtid).remove();
                                   }else{
                                        alert("<?php echo __("Changed the file.",'wpinfecscan'); ?>");
                                        jQuery('#myModal').modal('hide');
                                        jQuery("#"+nowtid+" td:first-child").append("<p style='color:red'><small><?php echo __("*Edited",'wpinfecscan'); ?></small></p>");
                                   }
                               }
                            
                           }
                         });
                    }
                }
            }
            
            function saveeditedfile_db(){
                if(loadok == true){
                    if(window.confirm('<?php echo __("Save changes of the database data?",'wpinfecscan'); ?>\n<?php echo __("Note that data editing may cause errors of the website.",'wpinfecscan'); ?>')){
                        var edcode = "";
                        
                        edcode =  editor.getValue();
                        jQuery.ajax({
                           type: "POST",
                           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                           data: {
                                "pfile": nowfilepath,
                                "gfile": nowfilename,
                                "action": "infeccodechange_db",
                                "serializedata":serializedata,
                                "code": encodeURIComponent(edcode),
                           },
                           async: false,
                           success: function(msg){
                               if(msg=="fail"){
                                   alert("<?php echo __("Failed to change the data.",'wpinfecscan'); ?>");
                               }else{
                                   if(msg=="fail_structure"){
                                       alert("<?php echo __("A data stricture broken. Save failed.",'wpinfecscan'); ?>");
                                   }else{
                                       if(msg=="ok2"){
                                            alert("<?php echo __("Changed the data.",'wpinfecscan'); ?>");
                                            jQuery('#myModal').modal('hide');
                                            jQuery("#"+nowtid).remove();
                                       }else{
                                            alert("<?php echo __("Changed the data.",'wpinfecscan'); ?>");
                                            jQuery('#myModal').modal('hide');
                                            jQuery("#"+nowtid+" td:first-child").append("<p style='color:red'><small><?php echo __("*Edited",'wpinfecscan'); ?></small></p>");
                                       }
                                   }
                               }
                           }
                        });
                    }
                }
            }
            
            function deletecode_db(filepath,filename,tid){

                if(window.confirm(' <?php echo __("Delete the database row data?",'wpinfecscan'); ?>\n<?php echo __("Note that database row data deletion may cause errors of the website.",'wpinfecscan'); ?>')){
                   jQuery.ajax({
                   type: "POST",
                   url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                   data: "pfile="+filepath+"&gfile="+filename+"&action=infeccodedelete_db",
                   async: false,
                   success: function(msg){
                       //alert(msg);
                       if(msg=="fail"){
                           alert("<?php echo __("Failed to delete database row data.",'wpinfecscan'); ?>");
                       }else{
                           alert("<?php echo __("Deleted database row data.",'wpinfecscan'); ?>");
                           jQuery("#"+tid).remove();
                       }
                    
                   }
                 });
                }

            }
            
            function deletecode(filepath,filename,tid){

                if(window.confirm(filename + ' <?php echo __(" - Delete the file.",'wpinfecscan'); ?>\n<?php echo __("Note that file deletion may cause errors of the website.",'wpinfecscan'); ?>')){
                   jQuery.ajax({
                   type: "POST",
                   url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                   data: "pfile="+filepath+"&gfile="+filename+"&action=infeccodedelete",
                   async: false,
                   success: function(msg){
                       if(msg=="fail"){
                           alert("<?php echo __("Failed to delete the file.",'wpinfecscan'); ?>");
                       }else{
                           alert("<?php echo __("Deleted the file.",'wpinfecscan'); ?>");
                           jQuery("#"+tid).remove();
                       }
                    
                   }
                 });
                }

            }
            
            function autorestore(filepath,filename,tid){
                var delelem = tid.replace('detect_','autorestorebte');
                jQuery("#"+delelem).hide();
                jQuery("<p id='"+delelem+"fp'><?php echo __("Processing...",'wpinfecscan'); ?></p>").insertAfter("#"+delelem);
                jQuery.ajax({
                   type: "POST",
                   url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                   data: "pfile="+filepath+"&gfile="+filename+"&action=infeccoderestore",
                   async: false,
                   success: function(msg){
                       //alert(msg);
                       var rfail=false;
                       var delelem = tid.replace('detect_','autorestorebte');
                       jQuery("#"+delelem).show();
                       jQuery("#"+delelem+"fp").remove();
                       if(msg=="fail"){
                           alert("<?php echo __("Database data not exists.",'wpinfecscan'); ?>");
                           jQuery("#"+delelem).remove();
                           rfail=true;
                       }
                       if(msg=="fail1"){
                           alert("<?php echo __("Automatic disinfection failed. It did not exist in the official directory. Possibly an original theme or plugin.",'wpinfecscan'); ?>");
                           jQuery("#"+delelem).remove();
                           rfail=true;
                       }
                       if(msg=="fail2"){
                           alert("<?php echo __("Automatic extermination failed. There is a possibility that the file could not be rewritten due to a write permission problem.",'wpinfecscan'); ?>");
                           rfail=true;
                       }
                       if(msg=="fail3"){
                           alert("<?php echo __("The official directory is down or shomething went wrong for restoring file.",'wpinfecscan'); ?>");
                           rfail=true;
                       }
                       if(rfail == false){
                           if(msg=="ok2"){
                                jQuery("#"+tid).remove();
                           }else{
                               jQuery("#"+tid+" td:first-child").append("<p style='color:red'><small><?php echo __("*Edited",'wpinfecscan'); ?></small></p>");
                               jQuery("#"+delelem).remove();
                           }
                       }
                   }
                });
            }
            
            function deletefile(){
                if(loadok == true){
                    if(window.confirm(nowfilename + ' <?php echo __(" - Delete the file.",'wpinfecscan'); ?>\n<?php echo __("Note that file deletion may cause errors of the website.",'wpinfecscan'); ?>')){
                       jQuery.ajax({
                       type: "POST",
                       url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                       data: "pfile="+nowfilepath+"&gfile="+nowfilename+"&action=infeccodedelete",
                       async: false,
                       success: function(msg){
                           if(msg=="fail"){
                               alert("<?php echo __("Failed to delete the file.",'wpinfecscan'); ?>");
                           }else{
                               alert("<?php echo __("Deleted the file.",'wpinfecscan'); ?>");
                               jQuery('#myModal').modal('hide');
                               jQuery("#"+nowtid).remove();
                           }
                        
                       }
                     });
                    }
                }
            }
            
            function deletefile_db(){
                if(loadok == true){
                    if(window.confirm(' <?php echo __("Delete the database row data?",'wpinfecscan'); ?>\n<?php echo __("Note that database row data deletion may cause errors of the website.",'wpinfecscan'); ?>')){
                       jQuery.ajax({
                       type: "POST",
                       url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
                       data: "pfile="+nowfilepath+"&gfile="+nowfilename+"&action=infeccodedelete_db",
                       async: false,
                       success: function(msg){
                           //alert(msg);
                           if(msg=="fail"){
                               alert("<?php echo __("Failed to delete database row data.",'wpinfecscan'); ?>");
                           }else{
                               alert("<?php echo __("Deleted database row data.",'wpinfecscan'); ?>");
                               jQuery('#myModal').modal('hide');
                               jQuery("#"+nowtid).remove();
                           }
                       }
                     });
                    }
                }
            }
            
            function showsubscribetab(){
                jQuery('[href=\"#ContentC\"]').tab('show');
            }
            
            function showmisyutokutab(){
                jQuery('[href=\"#ContentD\"]').tab('show');
            }
            
            function showipblocktab(){
                jQuery('[href=\"#ContentF\"]').tab('show');
            }
            jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                 var activated_tab = jQuery(e.target).attr("href") ;
            })
            <?php 
                if($settingchanged){
                    echo "jQuery('[href=\"#ContentB\"]').tab('show');";
                }
                if($securitysettingchanged){
                    echo "jQuery('[href=\"#ContentE\"]').tab('show');";
                }
                if($ipblocksettingchanged){
                    echo "jQuery('[href=\"#ContentF\"]').tab('show');";
                }
                if($setting_realtimeblock_changed){
                    echo "jQuery('[href=\"#ContentG\"]').tab('show');";
                }
				if($setting_csp_changed){
                    echo "jQuery('[href=\"#ContentI\"]').tab('show');";
                }
            ?>
            function showexptalert(){
                jQuery('#myModal2').modal('show');
            }
            </script>
            <div class="col-lg-12">
                <footer class="footer">
                    <hr style="margin-top:30px">
                    <p><a href="javascript:void(0);" onClick="displaykyodaku()"><?php _e("Show agreement","wpinfecscan");?></a> &copy; BLUE GARAGE Inc. <?php _e("WP doctor","wpinfecscan");?> <a href="https://wp-doctor.jp/" target="_blank">https://wp-doctor.jp/</a></p>

                    <p style="margin-top:25px;display:none" id="riyokyodaku"><small><?php _e("<b style='color:#337ab7'>Disclaimer</b>: We do not guarantee the accuracy of the result of WP doctor: Malware Scan Plugin. In addition, we are not responsible for any damage to users, other indirect servers, any items, or data by using this tool. In the free version, you can only detect malware using data that is up to one month old from the time of installation. Please use WP doctor: Malware Scan Plugin with kind understanding and acknowledgement that it acquires a part of inspection data for the purpose of accuracy improvement.<br><b style='color:#337ab7'>Prohibited matters (licensing)</b>: Many of the functions of this plug-in can be used free of charge. But using this plug-in to get compensation from customers (Providing other companies with paid malware scanning and removal services) is prohibited. If you violate this clause, you agree to charge 400 $ per site. If you are interested in doing business like this, please contact us and conclude a licensing agreement.","wpinfecscan");?></small></p>
                    
                    <script>
                    var kyodakushowing = false;
                    function displaykyodaku(){
                        if(kyodakushowing){
                            jQuery("#riyokyodaku").hide();
                            kyodakushowing = false;
                        }else{
                            jQuery("#riyokyodaku").show();
                            kyodakushowing = true;
                        }
                    }
                    </script>
                </footer>
            </div>
        </div>
	</div>


    <!-- Modal -->
    <style>
    .HighlightBg{background-color:#ff7d7d !important;color:white !important;}
    </style>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel" style="font-size:18px">Modal title</h4>
            <p id='highlighttxt'><small><?php _e("Highlighted pattern matched rows.","wpinfecscan");?></small></p>
            <p id='serializedtxt'><small><?php _e("This data is serialized (array) data. In most cases, you will need to correct the text and enter the correct value for the 's:character count'.","wpinfecscan");?></small></p>
          </div>
          <div class="modal-body" style="padding: 15px;">
            <pre class='syntaxhighlight brush: php; ruler: true; highlight: [0]' style='width:100%;height:500px' id="infeccode">
                code here
            </pre>
          </div>
          <div class="modal-footer">
            <script>
            function deletedata(){
                if(codeshowing==true){
                    deletefile();
                }else{
                    deletefile_db();
                }
            }
            function saveediteddata(){
                if(codeshowing==true){
                    saveeditedfile();
                }else{
                    saveeditedfile_db();
                }
            }
            </script>
            <button type="button" class="btn btn-danger" style="float:left" onClick="deletedata()" id='mydeletebutton'></button>
            <button type="button" class="btn btn-success" style="float:left" onClick="saveediteddata()"><?php _e("Save edit","wpinfecscan");?></button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Close","wpinfecscan");?></button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal2 -->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel2" style="font-size:18px"><?php _e("Notifications upon removal or deletion of malware files","wpinfecscan");?></h4>
          </div>
          <div class="modal-body2" style="padding: 15px;">
            <?php _e("<h4>Infected files</h4><p>Removal of malwares requires technical knowledge. It is recommended to ask an expert, but pay attention especially to the following points when you manage it by yourself.<br></p><ul style='list-style:disc !important;margin:20px;'><li>If the malware is infesting the file originally consists WordPress, please delete only <b>the tampered parts </b>carefully.</li><li> If the file is not a regular file of WordPress, the entire file can be deleted without any problem.</li></ul><p>However, if the tampered file is read by <b>another tampered file </b>, deletion of the tampered file may cause errors to the caller and may lead to malfunction such as undisplayable website. In that case, investigation of the caller and deletion of its tampering are required.</p>","wpinfecscan");?>
            <?php _e("<h4>Infected database</h4><p>Database infections often result in Javascript code embedded in posts and widgets. It is often possible to make it harmless by removing only the part of the malware contained in the content without removing it line by line.</p>","wpinfecscan");?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e("Close","wpinfecscan");?></button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    var ikkatuallcount=0;
    var nowikkatu = false;
    function cancelikkatu(){
        if(nowikkatu==false){
            jQuery('#myModal3').modal('hide');
        }else{
            var result = window.confirm('<?php _e("Cancel batch automatic extermination?","wpinfecscan");?>');
            if(result==true){
                location.reload();
            }
        }
    }
            
    function doikkatukujyo(ikkatukujyostart){
        nowikkatu = true;
        startTime = new Date();
        if(ikkatukujyostart==0){
            jQuery('#ikkatukujyoexp').html('<p><?php _e("Bulk extermination is running...","wpinfecscan");?></p>');
        }
        jQuery.ajax({
           type: "POST",
           url: "<?php echo admin_url( 'admin-ajax.php'); ?>",
           data: "action=infeccodeallrestore&allcount="+ikkatuallcount+"&autoallremovalstartid="+ikkatukujyostart,
           success: function(msg){
               if(msg=="fail1"){
                    jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Bulk Delete failed. You do not have permission.","wpinfecscan");?></p>');
                    nowikkatu = false;
                    return 0;
               }
               if(msg=="fail"){
                    jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Batch deletion failed.","wpinfecscan");?></p>');
                    nowikkatu = false;
                    return 0;
               }
               if(msg=="fail2"){
                    jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Batch deletion failed. There were no files that can be deleted automatically.","wpinfecscan");?></p>'); 
                    nowikkatu = false;
                    return 0;
               }
               if(msg=="fail4"){
                    jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Batch deletion failed. There were no files that can be deleted automatically.","wpinfecscan");?></p>'); 
                    nowikkatu = false;
                    return 0;
               }
               if(msg=="fail3"){
                    jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Unknown malware was detected and could not be executed. You can confirm the diagnosis of unknown malware by subscribing to the paid service and rescanning.","wpinfecscan");?></p>'); 
                    nowikkatu = false;
                    return 0;
               }
               if(msg=="end"){
                   alert("<?php _e("Batch disinfection of files that can be automatically removed has been completed.","wpinfecscan");?>");
                   location.reload();
                   return 0;
               }
               //alert(msg);
               var res =  JSON.parse(msg);
               var nextid = res.nextid;
               if(nextid>0){
                   var allcount = res.allcount;
                   var nokoricount = allcount-res.nokoricount;
                   var nokoriprogress = (nokoricount/allcount)*100;
                   jQuery('#ikkatukujyoexp').html('<p><?php _e("Bulk extermination is running...","wpinfecscan");?></p><div style="text-align:center"><div class="progress"><div class="progress-bar" role="progressbar" style="width: '+nokoriprogress+'%" aria-valuenow="'+nokoriprogress+'" aria-valuemin="0" aria-valuemax="100"></div></div><h3>'+nokoricount+'/'+allcount+'</div></h3>');
                   
                   ikkatuallcount = allcount;
                   doikkatukujyo(nextid);
               }else{
                   jQuery('#ikkatukujyoexp').html('<p style="color:red"><?php _e("Bulk extermination is running...","wpinfecscan");?></p>'); 
                   nowikkatu = false;
                   return 0;
               }
           }
         });     
    }
    </script>
    <!-- Modal3 -->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel2" style="font-size:18px"><?php _e("Auto-restore all","wpinfecscan");?></h4>
          </div>
          <div class="modal-body2" style="padding: 15px;" id='ikkatukujyoexp'>
            <br><?php _e("This function will replace all files detected as malware with legitimate files that are publicly available in the official WordPress directory. Please note that some files that are not in the official directory may not be replaced. <br><br>Please note that if a malware-detected file contains any customizations, the customizations in that file will be overwritten and deleted. We recommend that you back up your site prior to implementation.","wpinfecscan");?>
            <button type="button" class="btn btn-success" onClick="doikkatukujyo(0)"; style='width:100%;margin-top:20px;'><?php _e("Start batch extermination","wpinfecscan");?></button>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="cancelikkatu()" id='ikkatukujyoexpbt'><?php _e("Cancel","wpinfecscan");?></button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    function showinfomodal(titletxt,bodytxt){
        jQuery('#myModalLabelInfoTitle').html(titletxt);
        jQuery('#myModalLabelInfobody').html(bodytxt);
        jQuery('#myModalInfo').modal('show');
    }
    </script>
    <!-- Info Modal -->
    <div class="modal fade" id="myModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabelInfo">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabelInfoTitle" style="font-size:18px">####</h4>
          </div>
          <div class="modal-body2" style="padding: 15px;" id='myModalLabelInfobody'>####</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" onClick="jQuery('#myModalInfo').modal('hide');"><?php _e("Close","wpinfecscan");?></button>
          </div>
        </div>
      </div>
    </div>

<?php } 

/*WP 5.3 fix*/
if (! function_exists('wp_timezone_string')) {
function wp_timezone_string() {
	$timezone_string = get_option( 'timezone_string' );

	if ( $timezone_string ) {
		return $timezone_string;
	}

	$offset  = (float) get_option( 'gmt_offset' );
	$hours   = (int) $offset;
	$minutes = ( $offset - $hours );

	$sign      = ( $offset < 0 ) ? '-' : '+';
	$abs_hour  = abs( $hours );
	$abs_mins  = abs( $minutes * 60 );
	$tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );

	return $tz_offset;
}
}

function wpinfecscan_str_replace_last($search,$replace,$str){
	$pos = strrpos($str, $search);
	if ($pos !== false) {
		$str = substr_replace($str, $replace, $pos, strlen($search));
	}

	return $str;
}
add_action('send_headers', function () {
	
	if (is_admin()) {
        return;
    }
	
	$csp_options = get_option( 'wpinfectscanner_csp', "" );
	
	if(! empty($csp_options)){
		$wpinfectscanner_csp = $csp_options['csp'] ?? '';
		$wpinfectscanner_csp_mode = $csp_options['csp_mode'] ?? '';
		
		if($wpinfectscanner_csp==1 && $wpinfectscanner_csp_mode == 1){
			// ======================
			// default-src
			// ======================
			$output = "Content-Security-Policy: ";
			$set_default_src   = $csp_options['default-src']['enable'] ?? '';
			if(! empty($set_default_src)){
				if($set_default_src == "*"){
					$output .= "default-src *; ";
				}
				if($set_default_src == "self"){
					$output .= " default-src 'self'; ";
				}
				if($set_default_src == "selfplus"){
					$output_s = "default-src 'self'; ";
					$set_default_src_o = $csp_options['default-src']['other']  ?? '';
					if(! empty($set_default_src_o)){
						$set_default_src_o = implode(" ",explode("\n",$set_default_src_o));
						$output_s = "default-src 'self' ".$set_default_src_o."; ";
					}
					$output .= $output_s;
				}
			}
			
			$set_default_src_i = $csp_options['default-src']['inline'] ?? '';
			if($set_default_src_i == "unsafe-inline"){
				if(strpos($output,'default-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," 'unsafe-inline';",$output);
				}else{
					$output .= "default-src 'unsafe-inline'; ";
				}
			}
			

			// ======================
			// script-src
			// ======================
			$set_script_src   = $csp_options['script-src']['enable'] ?? '';
			
			if(! empty($set_script_src)){
				if($set_script_src == "*"){
					$output .= " script-src *; ";
				}
				if($set_script_src == "self"){
					$output .= " script-src 'self'; ";
				}
				if($set_script_src == "selfplus"){
					$output_s = " script-src 'self'; ";
					
					$set_script_src_d = $csp_options['script-src']['domain'] ?? array();
					if(count($set_script_src_d) > 0){
						$set_script_src_d = " ".implode(" ",$set_script_src_d)." ";
					}else{
						$set_script_src_d = "";
					}
					$set_script_src_o = $csp_options['script-src']['other']  ?? '';
					if(! empty($set_script_src_o)){
						$set_script_src_o = " ".implode(" ",explode("\n",$set_script_src_o))." ";
					}
					
					$output_s = " script-src 'self' ".$set_script_src_d.$set_script_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			$set_script_src_i = $csp_options['script-src']['inline'] ?? '';
			if($set_script_src_i == "unsafe-inline"){
				if(strpos($output,'script-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," 'unsafe-inline';",$output);
				}else{
					$output .= " script-src 'unsafe-inline'; ";
				}
			}
			if($set_script_src_i == "unsafe-eval"){
				if(strpos($output,'script-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," 'unsafe-eval';",$output);
				}else{
					$output .= " script-src 'unsafe-eval'; ";
				}
			}

			// ======================
			// connect-src
			// ======================
			$set_connect_src   = $csp_options['connect-src']['enable'] ?? '';
			
			if(! empty($set_connect_src)){
				if($set_connect_src == "*"){
					$output .= " connect-src *; ";
				}
				if($set_connect_src == "self"){
					$output .= " connect-src 'self'; ";
				}
				if($set_connect_src == "selfplus"){
					$output_s = " connect-src 'self'; ";
					
					$set_connect_src_d = $csp_options['connect-src']['domain'] ?? array();
					if(count($set_connect_src_d) > 0){
						$set_connect_src_d = " ".implode(" ",$set_connect_src_d)." ";
					}else{
						$set_connect_src_d = "";
					}
					$set_connect_src_o = $csp_options['connect-src']['other']  ?? '';
					if(! empty($set_connect_src_o)){
						$set_connect_src_o = " ".implode(" ",explode("\n",$set_connect_src_o))." ";
					}
					
					$output_s = " connect-src 'self' ".$set_connect_src_d.$set_connect_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			// ======================
			// frame-src
			// ======================
			$set_frame_src   = $csp_options['frame-src']['enable'] ?? '';
			if(! empty($set_frame_src)){
				if($set_frame_src == "*"){
					$output .= " frame-src *; ";
				}
				if($set_frame_src == "self"){
					$output .= " frame-src 'self'; ";
				}
				if($set_frame_src == "selfplus"){
					$output_s = " frame-src 'self'; ";
					
					$set_frame_src_d = $csp_options['frame-src']['domain'] ?? array();
					if(count($set_frame_src_d) > 0){
						$set_frame_src_d = " ".implode(" ",$set_frame_src_d)." ";
					}else{
						$set_frame_src_d = "";
					}
					$set_frame_src_o = $csp_options['frame-src']['other']  ?? '';
					if(! empty($set_frame_src_o)){
						$set_frame_src_o = " ".implode(" ",explode("\n",$set_frame_src_o))." ";
					}
					
					$output_s = " frame-src 'self' ".$set_frame_src_d.$set_frame_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			// ======================
			// style-src
			// ======================
			$set_style_src   = $csp_options['style-src']['enable'] ?? '';
			
			if(! empty($set_style_src)){
				if($set_style_src == "*"){
					$output .= " style-src *; ";
				}
				if($set_style_src == "self"){
					$output .= " style-src 'self'; ";
				}
				if($set_style_src == "selfplus"){
					$output_s = " style-src 'self'; ";
					
					$set_style_src_d = $csp_options['style-src']['domain'] ?? array();
					if(count($set_style_src_d) > 0){
						$set_style_src_d = " ".implode(" ",$set_style_src_d)." ";
					}else{
						$set_style_src_d = "";
					}
					$set_style_src_o = $csp_options['style-src']['other']  ?? '';
					if(! empty($set_style_src_o)){
						$set_style_src_o = " ".implode(" ",explode("\n",$set_style_src_o))." ";
					}
					
					$output_s = " style-src 'self' ".$set_style_src_d.$set_style_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			$set_style_src_i = $csp_options['style-src']['inline'] ?? '';
			if($set_style_src_i == "unsafe-inline"){
				if(strpos($output,'style-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," 'unsafe-inline';",$output);
				}else{
					$output .= " style-src 'unsafe-inline'; ";
				}
			}
			
			// ======================
			// base-uri
			// ======================
			$set_base_uri = $csp_options['base-uri'] ?? '';
			if($set_base_uri == "self"){
				$output .= " base-uri 'self'; ";
			}
			if($set_base_uri == "none"){
				$output .= " base-uri 'none'; ";
			}

			// ======================
			// form-action
			// ======================
			$set_form_action   = $csp_options['form-action']['enable'] ?? '';
			
			if(! empty($set_form_action)){
				if($set_form_action == "*"){
					$output .= " form-action *; ";
				}
				if($set_form_action == "self"){
					$output .= " form-action 'self'; ";
				}
				if($set_form_action == "selfplus"){
					$output_s = " form-action 'self'; ";
					
					$set_form_action_d = $csp_options['form-action']['domain'] ?? array();
					if(count($set_form_action_d) > 0){
						$set_form_action_d = " ".implode(" ",$set_form_action_d)." ";
					}else{
						$set_form_action_d = "";
					}
					$set_form_action_o = $csp_options['form-action']['other']  ?? '';
					if(! empty($set_form_action_o)){
						$set_form_action_o = " ".implode(" ",explode("\n",$set_form_action_o))." ";
					}
					
					$output_s = " form-action 'self' ".$set_form_action_d.$set_form_action_o."; ";
					
					$output .= $output_s;
				}
			}

			// ======================
			// img-src
			// ======================
			$set_img_src   = $csp_options['img-src']['enable'] ?? '';
			if(! empty($set_img_src)){
				if($set_img_src == "*"){
					$output .= " img-src *; ";
				}
				if($set_img_src == "self"){
					$output .= " img-src 'self'; ";
				}
				if($set_img_src == "selfplus"){
					$output_s = " img-src 'self'; ";
					
					$set_img_src_d = $csp_options['img-src']['domain'] ?? array();
					if(count($set_img_src_d) > 0){
						$set_img_src_d = " ".implode(" ",$set_img_src_d)." ";
					}else{
						$set_img_src_d = "";
					}
					$set_img_src_o = $csp_options['img-src']['other']  ?? '';
					if(! empty($set_img_src_o)){
						$set_img_src_o = " ".implode(" ",explode("\n",$set_img_src_o))." ";
					}
					
					$output_s = " img-src 'self' ".$set_img_src_d.$set_img_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			$set_img_src_i = $csp_options['img-src']['inline'] ?? '';
			if($set_img_src_i == "data:"){
				if(strpos($output,'img-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," data:;",$output);
				}else{
					$output .= " img-src data:; ";
				}
			}
			
			// ======================
			// font-src
			// ======================
			$set_font_src   = $csp_options['font-src']['enable'] ?? '';
			
			if(! empty($set_font_src)){
				if($set_font_src == "*"){
					$output .= " font-src *; ";
				}
				if($set_font_src == "self"){
					$output .= " font-src 'self'; ";
				}
				if($set_font_src == "selfplus"){
					$output_s = " font-src 'self'; ";
					
					$set_font_src_d = $csp_options['font-src']['domain'] ?? array();
					if(count($set_font_src_d) > 0){
						$set_font_src_d = " ".implode(" ",$set_font_src_d)." ";
					}else{
						$set_font_src_d = "";
					}
					$set_font_src_o = $csp_options['font-src']['other']  ?? '';
					if(! empty($set_font_src_o)){
						$set_font_src_o = " ".implode(" ",explode("\n",$set_font_src_o))." ";
					}
					
					$output_s = " font-src 'self' ".$set_font_src_d.$set_font_src_o."; ";
					
					$output .= $output_s;
				}
			}
			
			$set_font_src_i = $csp_options['font-src']['inline'] ?? '';
			if($set_font_src_i == "data:"){
				if(strpos($output,'font-src') !== false){
					$output = wpinfecscan_str_replace_last(";" ," data:;",$output);
				}else{
					$output .= " font-src data:; ";
				}
			}
			
			
			$output = preg_replace('/\s{2,}/u', ' ', $output);
			$output = str_replace('Security-Policy:  ','Security-Policy: ',$output);
			
			header(
				trim($output)
			);
	
		}
	}
});
?>