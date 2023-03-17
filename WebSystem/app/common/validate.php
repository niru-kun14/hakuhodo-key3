<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Control functions for Validation
     * @version 2.0
     */

    /**
     * String validation.
     * @param string $str The string to be checked.
     * @return mixed null if the string is set; otherwise $err_msg.
     */
    function V_EMPTY($str)
    {
    	$err_msg = "This variable is required.";
    	
    	if($str != null) return null;
    	return $err_msg;
    }
    
    /**
     * Number Validation.
     * @param int $int The number to be checked.
     * @return mixed null if the number is valid; otherwise $err_msg.
     */
    function V_NUMBER($int)
    {
    	$err_msg = "Please enter a single-byte number";
    	
    	if(preg_match("/^[0-9]+$/", $int) || $int == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string only contains Half-width Letters.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_ALPHA($str)
    {
    	$err_msg = "Please enter half-width letters only.";
    	
    	if(preg_match("/^[a-zA-Z]+$/", $str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string only contains alphanumeric characters.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_ALPHA_NUMBER($str)
    {
    	$err_msg = "Please enter single-byte alphanumeric characters only";
    	
    	if(preg_match("/^[a-zA-Z0-9]+$/", $str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string is a valid URL.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_URL($str){
    	$err_msg = "The URL is invalid.";
    	
    	if(preg_match('/^(http|HTTP|ftp)(s|S)?:\/\/+[A-Za-z0-9]+\.[A-Za-z0-9]/', $str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string is a valid Email Address.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_MAIL($str){
    	$err_msg = "The email address is Invalid.";
    	$match = '/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i';
    	
    	if(preg_match($match, $str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string only contains Full-width Katakana characters.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_ZEN_KATA($str)
    {
    	$err_msg = "Please enter in the Full-width Katakana.";
    	
    	if(preg_match("/^[ァ-ヶ]+$/u",$str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the string only contains Full-width Hiragana characters.
     * @param string $str The string to be checked.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_ZEN_HIRA($str){
    	$err_msg = "Please enter in Full-width Hiragana.";
    	
    	if(preg_match("/^[ぁ-ん]+$/u",$str) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the number of [UTF-8] characters in a string $str
     * falls between the specified $min and $max values.
     * @param string $str The string to be checked.
     * @param int $min [optional] The minimum number of characters. Default is 0.
     * @param int $max [optional] The maximum number of characters. Default is 500.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_ZEN_LENGH($str, $min = 0, $max = 500)
    {
        $utf = "utf-8"; //Character Code
//         $err_msg = $min ."文字以上". $max."文字以内で入力してください。";
    	$err_msg = "Please enter between $min to $max number of characters.";
    	
    	if((mb_strlen($str, $utf) >= $min && mb_strlen($str,$utf) <= $max) || $str == "") return null;
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the number of characters in a string $str
     * falls between the specified $min and $max values.
     * @param string $str The string to be checked.
     * @param int $min [optional] The minimum number of characters. Default is 0.
     * @param int $max [optional] The maximum number of characters. Default is 500.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_HAN_LENGH($str, $min = 0, $max = 500){
//     	$err_msg = $min ."文字以上". $max."文字以内で入力してください。";
    	$err_msg = "Please enter between $min to $max number of characters.";
    	if((strlen($str) >= $min && strlen($str) <= $max) || $str == ""){
    		return null;
    	}
    	return $err_msg;
    }
    
    /**
     * String Validation to check if the value of string $str
     * falls between the specified $min and $max values.
     * @param string $str The string to be checked.
     * @param int $min [optional] The minimum number of characters. Default is 0.
     * @param int $max [optional] The maximum number of characters. Default is 500.
     * @return mixed null if the string is valid; otherwise $err_msg.
     */
    function V_RANGE($str, $min = 0, $max = 500){
//     	$err_msg = $min ."〜". $max."の範囲で入力してください。";
        $err_msg = "Please enter between the range of $min-$max";
    	if(((int)$str >= (int)$min && (int)$str <= (int)$max) || $str == ""){
    		return null;
    	}
    	return $err_msg;
    }
?>