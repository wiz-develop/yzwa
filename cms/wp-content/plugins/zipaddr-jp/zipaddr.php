<?php
if( !defined('ABSPATH') ) exit;
function zipaddr_jp_change($output, $opt=""){
	$flds= zipaddr_jp_fld(); foreach($flds as $i => $key){$keys=ZIPADDR_JP_SYS.$key; $$keys="";}
	$param= @unserialize( get_option(ZIPADDR_JP_DEFINE) ); // get定義情報
	if( $param === false ) $param= array();
	foreach((array)$param as $key => $data){
		$da= ($data=="&nbsp;") ?  $data : htmlspecialchars($data,ENT_QUOTES,'UTF-8');
		$$key= $da;
	}
	$sysid= array();
	$sysid[1]= "ContactForm7,contactform7";
	$sysid[2]= "MWWPForm,    mwwpform";
	$sysid[3]= "TrustForm,   trustform";
	$sysid[4]= "NinjaForms,  ninjaforms";
	$sysid[5]= "WP-Members,  wpmembers";
	$sysid[6]= "WPForms,     wpforms";
	$sysid[7]= "VisualFB,    visualformb";
	$sysid[8]= "WooCommerce, woocommerce";
	$sysid[9]= "Welcart2,    welcart2";
	$sysid[10]="MailformPro, mailformpro";
	$sysid[11]="SnowMonkeyForm,snowmonkeyform";
	$sysid[12]="TieredWorks, tieredworks";
	$sysid[13]="Forminator,  forminator";
	$sysid[14]="booking-package,bookingpackage";
	$sysid[15]="YubinBango,";
	$sysid[16]="jetformbuilder,jetformbuilder";
	$sysid[99]="###other###, tricks";
//
	$contf7= strpos($output, 'wpcf7-form');       //Contact Form 7
	$mwform= strpos($output, 'mw_wp_form_');      //MW WP Form
	$trustf= strpos($output, '#trust-form');      //Trust Form
	$ninjaf= strpos($output, 'ninja-forms-');     //Ninja Forms
	$wpmem=  strpos($output, 'id="wpmem_reg"');   //WP-Members
	$wpfms=  strpos($output, 'id="wpforms-form-');//WPForms
	$visufb= strpos($output, 'vfb-form-');        //Visual Forms Builder
	$woocmb= strpos($output, 'woocommerce-billing'); //Woo Commerce
	$woocms= strpos($output, 'woocommerce-shipping');//Woo Commerce
	$woocma= strpos($output, 'woocommerce-address'); //Woo Commerce
	$woocmk= strstr($output, 'wp-block-woocommerce-checkout-'); //Woo Commerce block
	$welcart=strpos($output, '[zipcode]');        //Welcart
	$mailpro=strpos($output, 'id="mailformpro"'); //Mailform Pro
	$mailfor=strpos($output, "mfpc('mailform'");  //Mailform
	$snowmon=strpos($output, 'snow-monkey-form'); //SnowMonkeyForm
	$tieredw=strpos($output, 'SF-contact');       //TieredWorks
	$formina=strpos($output, 'forminator-label'); //Forminator
	$bookpak=strpos($output, 'id="booking-package"'); //booking-package
	$yubingo=strpos($output, 'h-adr');            //YubinBango
	$jetform=strpos($output, 'class="jet-form-builder'); //jet-form-builder
	$yubin=  strpos($output, '郵便番号');
	$idzip=  strpos($output, 'id="zip');
//フォームの自動判定
	$sid= "";
		 if( $yubingo!==false ) $sid= 15;
	else if( $contf7 !==false ) $sid= 1;
	else if( $mwform !==false ) $sid= 2;
	else if( $trustf !==false ) $sid= 3;
	else if( $ninjaf !==false ){$sid= 4; $sys_dyna="1";}
	else if( $wpmem  !==false ){$sid= 5; $sys_dyna="1";}
	else if( $wpfms  !==false ) $sid= 6;
	else if( $visufb !==false ) $sid= 7;
	else if( $woocmb !==false || $woocms!==false || $woocma!==false ) $sid= 8;
	else if( !empty($woocmk)  ) $sid= 8;
	else if( $welcart!==false ) $sid= 9;
	else if( $mailpro!==false || $mailfor!==false) $sid= 10;
	else if( $snowmon!==false ) $sid= 11;
	else if( $tieredw!==false ) $sid= 12;
	else if( $formina!==false ) $sid= 13;
	else if( $bookpak!==false ){$sid= 14; $sys_dyna="1";}
	else if( $jetform!==false && $idzip!==false ) $sid= 16;
	else if( empty($sys_syid))  $sid= 99;
//
	if( $sid < 99 ){;}                            //自動判定
	else
	if( strpos($output,'zip')!==false || strpos($output,'postc')!==false || $sys_drct!="" ){;} //kword
	else
	if( ($wpfms!==false || $visufb!==false) && $yubin!==false ){;}
	else
	if( !empty($woocmk) ){;}
	else  return $output;
	$apid= "";
	if( !empty($sid) ) {list($sys_syid,$apid)=explode(",", $sysid[$sid]); $apid=trim($apid);}

	$jsfile= '<script type="text/javascript" charset="UTF-8"';
	$http="http"; $lcpath="";                     // http,  // local_path
	if(isset($_SERVER['HTTPS'])) {$http=(empty($_SERVER['HTTPS'])||$_SERVER['HTTPS']=='off')? 'http':'https';}
	$pth= isset($_SERVER['SERVER_NAME']) ?  $http.'://'.sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME'])) : ""; // host用
	if( empty($sys_site) ) $sys_site= "4";        // パラメータの初期変換
	if( empty($sys_keta) ) $sys_keta= "7";
	if( $sys_keta < 5 ||  7 < $sys_keta ) $sys_keta= "7";
	if( $sys_pfon < 9 || 25 < $sys_pfon ) $sys_pfon= "";
	if( $sys_sfon < 9 || 25 < $sys_sfon ) $sys_sfon= "";
	if( $sys_site == "2" || $sys_site == "3" ){
		$lcpath= $pth.'/css/zipaddr.css';
		$wk= @file_get_contents($lcpath);
		$wk2= strpos($wk,"autozip");
		if( empty($wk) || $wk2===false ) wp_enqueue_style('zipaddr-jp',ZIPADDR_JP_PLUGIN_URL."/zipaddr.css",array(),1.1); // 定義がなければ補う
	 }                                   // 変換の判定開始
                           $uls=ZIPADDR_JP_COM.'js/zipaddr7.js';
	 if( $sys_site == "2" ) $uls= ZIPADDR_JP_GIT. 'zipaddr3.js';
else if( $sys_site == "3" ) $uls= ZIPADDR_JP_GIT. 'zipaddr30.js';
else if( $sys_site == "4" ) $uls= ZIPADDR_JP_GIT. 'zipaddrx.js';
else if( $sys_site == "5" ) $uls= ZIPADDR_JP_GIT. 'zipaddra.js';
	$pre= "ZP.";                                  // prefix
//モジュール・ファイル生成
	$js = $jsfile.' src="'.$uls.'?v='.ZIPADDR_JP_VERS.'"></script>';
//オプション・パラメータ生成
	$jx= "function zipaddr_ownb(){" .$pre."dli='".$sys_deli."';";
	$jx.= $pre."wp='1';";
	$jx.= $pre."uver='".zipaddr_jp_suji(get_bloginfo('version'))."';";
	if( $sys_tate!="" ) $jx.= $pre."top=".    $sys_tate. ";";
	if( $sys_yoko!="" ) $jx.= $pre."left=".   $sys_yoko. ";";
	if( $sys_pfon!="" ) $jx.= $pre."pfon=".   $sys_pfon. ";";
	if( $sys_sfon!="" ) $jx.= $pre."sfon=".   $sys_sfon. ";";
	if( $sys_focs!="" ) $jx.= $pre."focus='". $sys_focs."';";
	if( $sys_syid!="" ) $jx.= $pre."sysid='". $sys_syid."';";
	if( $sys_plce!="" ) $jx.= $pre."holder='".$sys_plce."';";
	if( $sys_dyna!="" ) $jx.= $pre."dyna='".  $sys_dyna."';";
	if( $sys_site=="3") $jx.= $pre."min='7';";
	if( defined('ZIPADDR_JP_IDENT') && ZIPADDR_JP_IDENT == "3" ) $jx.= $pre."usces='1';";
	$jx.= '}';
	$js.= '<script defer src="data:text/javascript;base64,'.base64_encode($jx).'"></script>';
//pmファイル生成
	if( !empty($apid) ){
		$js.= $jsfile.' src="'.ZIPADDR_JP_GIT.$apid.'.js"></script>';
	}
//stylesheetファイル生成
//	if( $sys_site=="2" || $sys_site=="3" ) wp_enqueue_style('zipaddr-jp',$lcpath,array(),1.1); // style
//オウンコード設定パラメータ生成
//	if( $sys_parm != "" ){
		$skip1= "skip=1";
		$syskip= strpos($sys_parm, $skip1);
		if( $syskip === false && $sys_gide == "1" ){
			if( !empty($sys_parm) ) $sys_parm.= "|";
			$sys_parm.= $skip1;
		}
		$sys_parm= str_replace("|", ",", $sys_parm);
		if( !empty($sys_parm) ) $js.= '<input type="hidden" name="zipaddr_param" id="zipaddr_param" value="'.$sys_parm.'">';
//	}
	if( !empty($opt) || $ninjaf!==false || $visufb!==false ) {$ans= $output.$js;} //Ninja Forms、Visual Forms Builder
	else
	if( !empty($sys_drct) ){                      // 無条件挿入
		$ans= $output;
		$urlh= isset($_SERVER['REQUEST_URI']) ?  sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : "";
		$wk= explode(";", $sys_drct);
		foreach($wk as $ka => $da){
			if( strpos($urlh,$da)!==false ) {$ans=$output.$js; break;}
		}
	}
	else
	if( !empty($woocmk) ){
		$ans= $output;
		define('ZIPADDR_JP_URL', $uls);           // 参照用
		add_action('wp_enqueue_scripts', 'zipaddr_jp_scripts');
	}
	else
		$ans= str_ireplace("<form", $js."<form", $output);
	return $ans;
}
function zipaddr_jp_scripts(){
	wp_enqueue_script('zipaddr-jp-blk', ZIPADDR_JP_URL, array(),get_bloginfo('version'),array('in_footer' => true) );
	wp_enqueue_script('zipaddr-jp-st2', ZIPADDR_JP_GIT.'browsjp_zipaddr.js',array(),'1.4',  array('in_footer' => true) );
	wp_enqueue_script('zipaddr-jp-st3', ZIPADDR_JP_GIT.'woocommerce.js',array(),'1.6',  array('in_footer' => true) );
}
?>
