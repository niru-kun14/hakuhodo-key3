<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Main Framework Controller
     * @version 2.0
     */

    //Error Display Control (comment out on production)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

    //Set TimeZone
    date_default_timezone_set("Asia/Manila");
    
    //Set WEB Variables
    $referer = "";
    if(isset($_SERVER["HTTP_REFERER"])) $referer = $_SERVER["HTTP_REFERER"]; //referer URL if exist
    
    $ip = $_SERVER["REMOTE_ADDR"]; //ip address of the client
    $ua = $_SERVER["HTTP_USER_AGENT"]; //user agent of the device
    $server = $_SERVER['SERVER_NAME']; //server name of the system
    
    // Header that is used by the trusted proxy to refer to the original IP
    $xfor = "";
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $xfor = $_SERVER['HTTP_X_FORWARDED_FOR'];
        

    //Check Mobile Using User Agent Function
    $mobile = 0;
    $ua = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match("/DoCoMo/", $ua) || preg_match("/J-PHONE/", $ua) || preg_match("/Vodafone/", $ua) || preg_match("/SoftBank/", $ua) ||
        preg_match("/UP.Browser/", $ua) || preg_match("/KDDI/", $ua)) $mobile = 1;
    else if(preg_match("/Android/", $ua) || preg_match("/iPhone/", $ua) || preg_match("/iPad/", $ua)) $mobile = 1;
    
    if(!preg_match("/Mobile/", $ua) && !preg_match("/Touch/", $ua) && !preg_match("/Android/", $ua) &&
        (preg_match("/Windows/", $ua) || preg_match("/Mac/", $ua) || preg_match("/Linux/", $ua) || preg_match("/Ubuntu/", $ua))) $mobile = 0;
    
    //Included Libraries
    include_once $common_path."func.php";
    include_once $common_path."user_func.php";
    include_once $common_path."tag_func.php";
    include_once $common_path."db_manage.php";
    include_once $common_path."pages.php";
    include_once $common_path."mailtext.php";
    include_once $common_path."validate.php";
    
    //Set Language
    if(isset($req["lang"])) $_SESSION["lang"] = $req["lang"];
    if(!isset($_SESSION["lang"])) $_SESSION["lang"] = "en_US";
    
    include_once $common_path."langcontroller.php"; //include language controller
    
    //Change WEB Variable for protection against CrossSiteScripting
    foreach ( $_REQUEST as $key => $value)
    {
    	if(is_array($value))
    	{
    		$a_tmp = array();
    		
    		foreach($value as $val) array_push($a_tmp,htmlspecialchars($val, ENT_QUOTES));
    		
    		$req[$key] = $a_tmp;
    	}
    	else $req[$key] = htmlspecialchars($value, ENT_QUOTES);
    }
    
    //Change Character Setting Mobile 
    if($mobile) foreach($req as $key => $val) $req[$key] = mb_convert_encoding($val, "UTF-8", "SJIS");
    
    //Get WEB Mode
    if(isset($req['pageid']))
    {
    	$page_param = explode("/", $req['pageid']);
    	if(count($page_param) == 0) $pageid = "base__top";
    	if(count($page_param) >= 1) $pageid = $page_param[0];
    	if(count($page_param) >= 2) $mode = $page_param[1];
    	if(count($page_param) >= 3) $param = $page_param[2];
    	if(count($page_param) >= 4) $param2 = $page_param[3];
    	if(count($page_param) >= 5) $param3 = $page_param[4];
    }
    else $pageid = "base__top"; //default page
    
    //Get Page Setting Information
    $page = new pages($conf_path."pages.cfg");
    $aPage = $page->get($pageid);
    
    //Change to HTTPS if needed
    if($aPage[2] == "HTTPS" && !is_https()) force_https();
    
    //Check if User is Logged In
    if($aPage[3] != "OFF")
    {
    	if($aPage[3] == "A") //
    	{
    		if(!chklogin("9"))
    		{
    		    logout();
    		    page_move("/"); //return to top page if the user is not logged in
    		}
    		else $aLogin = getLogin(); //Set Login Session Variable
    	}
    	elseif($aPage[3] == "U")
    	{
    	    if(!chklogin("1"))
    	    {
    	        logout();
    	        page_move("/"); //return to top page if the user is not logged in
    	    }
    		else $aLogin = getLogin(); //Set Login Session Variable
    	}
    }
    
    if(strpos($pageid, "login") !== false)
    {
    	if(chklogin("")) page_move("/admin__top/");
    	else if(chklogin("1")) page_move("/user__top/");
    	else page_move("/base__top/");
    }
    
    // //DB Open (Transaction)
    // $db = new db_manage();
    // if($db == null) echo $db->error;
    
    $base_dir = "";
    $page_file = $pageid;
    
    //folder and filename acquisition of current page
    if(($pos = strpos($pageid,"__")) != FALSE )
    {
    	$tmp = explode( "__" ,$pageid );
    	$base_dir = $tmp[0]; //directory
    	$page_file = $tmp[1]; //filename (without extension)
    }
    
    $extraJS = ""; //additional javascript for the current page
    
    //Call Action
    $act_file = "$act_path/$base_dir/$page_file.php";
    
    if(!file_exists($act_file)) page_move("/error__dialogue/");
    else include_once $act_file;
    
    //Including the HTML File
    if(strncmp($aPage[1],"HTML",4) == 0)
    {
        //Include Header File
        if(file_exists("$ht_path/$base_dir/header.html") && strncmp($aPage[5], "yes", 3) == 0) include_once "$ht_path/$base_dir/header.html";
	    if(file_exists("$ht_path/$base_dir/header_no.html") && strncmp($aPage[5], "no", 2) == 0) include_once "$ht_path/$base_dir/header_no.html";
		
		//Include Main HTML File
		if(file_exists("$ht_path/$base_dir/$page_file.html")) include_once "$ht_path/$base_dir/$page_file.html";
		
		//Include Footer File
		if(file_exists("$ht_path/$base_dir/footer.html") && strncmp($aPage[5], "yes", 3) == 0) include_once "$ht_path/$base_dir/footer.html";
		if(file_exists("$ht_path/$base_dir/footer_no.html") && strncmp($aPage[5], "no", 2) == 0) include_once "$ht_path/$base_dir/footer_no.html";
    }
    elseif(strncmp($aPage[1],"VIEW",4)==0 )
    {
        //Include VIEW File
        if(file_exists("$view_path/$base_dir/$page_file.view")) include_once "$view_path/$base_dir/$page_file.view";
    }
?>
