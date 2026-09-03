<?php
if( !defined('ABSPATH') ) exit;

//first処理
	$zipaddr_jp_prm= get_option(ZIPADDR_JP_DEFINE); // システム固有情報の取得
	if( !$zipaddr_jp_prm ){                       // first初期化（最初の1回のみの処理）
		if( file_exists(ZIPADDR_JP_FILE1) ){      // 旧定義情報
			$zipaddr_jp_array= zipaddr_jp_file1();// 初期済項目
			$zipaddr_jp_param= serialize($zipaddr_jp_array);
			update_option(ZIPADDR_JP_DEFINE,$zipaddr_jp_param); // 新規に追加する
		}
		else
		if( file_exists(ZIPADDR_JP_FILE2) ){      // 新定義情報
			$zipaddr_jp_array= zipaddr_jp_first();// 初期済項目
			$zipaddr_jp_param= serialize($zipaddr_jp_array);
			update_option(ZIPADDR_JP_DEFINE,$zipaddr_jp_param); // 新規に追加する
		}
	}

function zipaddr_jp_fld(){
	return array("site", "keta", "tate", "yoko", "pfon", "sfon", "focs", "syid", "deli",
		"parm", "plce", "drct", "dyna", "gide");
}
function zipaddr_jp_str($leng=16){
	$ans= null;
	$str= array_merge( range('a','z'),range('0','9'),range('A','Z') );
	for( $i=0;$i<$leng;$i++ ) {$ans.= $str[wp_rand(0,count($str)-1)];}
	return $ans;
}
//function zipaddrjp_e($da){echo esc_html($da);}
function zipaddr_jp_suji($in, $sp=".",$kwd="2.1.3.4"){
	$ans= "";
	$dt= explode($sp, $in);
	$kd= explode($sp, $kwd);
	for( $i=count($dt)-1;$i>=0;$i-- ){
		$ss= substr("111111",$i,$i+1);
		$ee= substr("999999",$i,$i+1);
		$gen = wp_rand($ss,$ee);
		$gen.= $kd[$i];
		$gen.= $dt[$i];
		for( $j=0;strlen($gen)<5;$j++ ){$gen.=wp_rand(0,9);}
		if( $ans!="" ) $ans.= ".";
		$ans.= $gen;
	}
	return $ans;
}
function zipaddr_jp_file1(){
	$array= array();
	$flds= zipaddr_jp_fld();                      // 項目一覧
	$data= @file_get_contents(ZIPADDR_JP_FILE1);
	$data= trim($data);
	$prms= explode(",", $data);
	foreach($prms as $i => $dd){
		$key= $flds[$i];
		     if( empty($dd) && $key=='site' ) $dd= "4";
		else if( empty($dd) && $key=='keta' ) $dd= "7";
		if( !empty($dd) ) $dd= htmlspecialchars($dd,ENT_QUOTES,'UTF-8');
		$keys= ZIPADDR_JP_SYS.$key;               // sys_
		$array[$keys]= $dd;
	}
	return $array;
}
function zipaddr_jp_first(){
	$array= array();
	$flds= zipaddr_jp_fld();                      // 項目一覧
	foreach($flds as $i => $key){
		     if( $key=="site" ) $dd= "4";
		else if( $key=="keta" ) $dd= "7";
		else if( $key=="deli" ) $dd= "-";
		else                    $dd= "";
		$keys= ZIPADDR_JP_SYS.$key;               // sys_
		$array[$keys]= $dd;
	}
	return $array;
}
?>
