<?php
    //**************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************
    /** 
     * @author Sysplex IT Solutions Team
     * @version 2.0
     */

	$app_path = realpath("../app/"); //backend files folder
	$ht_path = realpath("../htdocs/"); //front end files folder
	$upload_path = realpath("../upload/"); //upload destination
	$act_path = $app_path."/action/"; //action (php file of each pages) file folder
	$view_path = $app_path."/view/"; //view file folder (usually used for ajax called pages)
	$conf_path =  $app_path."/conf/"; //configuration file folder
	$common_path =  $app_path."/common/"; //common functions file folder
	$lib_path = $app_path."/lib/"; //additional modules folder
	$lang_path = $lib_path."/lang/"; //language module folder
	$img_path = $ht_path."/imgs/"; //image path
	
	//include the main framework controller
	include_once $app_path . "/controller/controller.php";
?>