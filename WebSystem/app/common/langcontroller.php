<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Language Controller
     * @version 2.0
     */

	include_once $lib_path."gettext.php";
	include_once $lib_path."streams.php";
	
	if(isset($_SESSION["lang"])) $lang = $_SESSION["lang"];

	$lang_file = new FileReader("$lang_path$lang.mo");
	$fetch_lang = new gettext_reader($lang_file);
	
	/**
	 * Translate Function
	 * @param string $text The target string to be translate.
	 * @return string The Translated Text based on the current language setting.
	 */
	function translate($text)
	{
		global $fetch_lang;
		return $fetch_lang->translate($text);
	}
?>