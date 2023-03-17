<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Common Processing Function Group
     * @version 2.0
     */

    session_start();

    // Set Torus API endpoint
    $torus_endpoint = "https://cors-proxy.toruswallet.io/";

    // Set your Torus API key and secret
    $torus_api_key = "YOUR_API_KEY";
    $torus_api_secret = "YOUR_API_SECRET";

    // Set your desired network (e.g. "rinkeby", "mainnet")
    $network = "rinkeby";

    // Set your application's callback URL after successful login
    $callback_url = "https://yourapp.com/callback";
    
    /**
     * Global Variables
     */
    $sex_arr = array(0 => "男性"/*Male*/, 1 => "女性"/*Female*/);

    /**
     * Sets the Login Details
     */
    function setLogin($inLogin)
    {
        $_SESSION["login"] = $inLogin;
    }
    
    /**
     * Get the Login Details
     * @return array login_details 
     */
    function getLogin()
    {
        return $_SESSION["login"];
    }
    
    /**
     * Clear Login Information
     * @return array login_details
     */
    function clearLogin()
    {
        $_SESSION["login"] = null;
    }
    
    /**
     * Check Login mode of the logged in User
     * @return bool true if the logged in User Type is correct; otherwise false;
     */
    function chklogin($mode)
    {
        if(isset($_SESSION["login"]))
        {
            $aLogin = $_SESSION["login"];
            if($aLogin["mode"] == $mode) return true;
        }
        
        return false;
    }
    
    /**
     * Move to the Specified Page using the current protocol
     * @param string $inUrl The target URL to open
     */
    function page_move($inUrl)
    {
        if(isset($_SERVER["HTTP_X_FORWARDED_PROTO"])) $protocol = $_SERVER["HTTP_X_FORWARDED_PROTO"]."://";
        else
        {
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") $protocol = "https://";
            else $protocol = "http://";
        }
        
        header("Location: $protocol".$_SERVER['SERVER_NAME'].$inUrl );
    }
    
    /**
     * Move to the Specified Page without using the current protocol
     * @param string $inUrl The target URL to open
     */
    function page_move_noproto($inUrl)
    {
        header("Location: $inUrl");
    }
    
    /**
     * Force to use HTTPS protocol
     */
    function force_https()
    {
        header("Location:https://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
    }
    
    /**
     * Force to use HTTP protocol
     */
    function force_http()
    {
        header("Location:http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]);
    }
    
    /**
     * Check if the current protocol is HTTPS
     * @return bool true if the current protocol is HTTPS; otherwise false.
     */
    function is_https()
    {
        if(isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] == "on") return true;
        
        return false;
    }
    
    /**
     * Logout Current User
     */
    function logout()
    {
        $_SESSION["login"] = null;
        
        page_move("/login/");
    }
    
    /**
     * Change XML object data to Array
     * @param object $object The Object to be converted to array.
     * @return Array $res The Converted Object.
     */
    function obj2hash($object)
    {
    	$res = array();
    	
        if(is_object($object))
        {
            $list = get_object_vars($object);
            
            while(list($k, $v) = each($list)) $res[$k] = obj2hash($v);
        }
        else if(is_array($object)) while(list($k, $v) = each($object)) $res[$k] = obj2hash($v);
        else return $object;
        
        return $res;
    }
    
    /**
     * Get today's date as a string(YYYY-MM-DD)
     * @return string The Current Date in [YYYY-MM-DD] format
     */
    function get_today_str()
    {
        return date("Y-m-d");
    }
    
    /**
     * Acquires the date shifted by the specified date as a character string as a character string (YYYY-MM-DD)
     * @param string $org_date The Original Date to be processed.
     * @param string $move_day The is specified move date. eg; "+1 day", "-1 day", etc.
     * @return string The processed Date in [YYYY-MM-DD] format
     */
    function get_ch_day_str($org_date, $move_day)
    {
        $timestamp = strtotime("$org_date $move_day");
        return date("Y-m-d", $timestamp);
    }
    
    /**
     * Acquires last day of target Year and Month
     * @param string $year The target year.
     * @param string $month The target month.
     * @return string The last day in [DD] format.
     */
    function get_last_day($year, $month)
    {
    	$tmpdate = strtotime(get_ch_day_str("$year-$month-1", "+1 month"));
    	$tmpdate2 = strtotime(get_ch_day_str(date("Y-m", $tmpdate)."-1", "-1 day"));
    	return date("d", $tmpdate2);
    }
    
    /**
     * Get Day from date
     * @param string $target_date The target date to be processed.
     * @return string The last day in [DD] format.
     */
    function get_day($target_date)
    {
    	$tmpdate = strtotime($target_date);
    	return date("d", $tmpdate);
    }
    
    /**
     * Get Month from date
     * @param string $target_date The target date to be processed.
     * @return string The month in [MM] format.
     */
    function get_month($target_date)
    {
        return date("m", strtotime($target_date));
    }
    
    /**
     * Get Year from date
     * @param string $target_date The target date to be processed.
     * @return string The Year in [YYYY] format.
     */
    function get_year($target_date)
    {
    	return date("Y", strtotime($target_date));
    }
    
    /**
     * Get Week from date
     * @param string $target_date The target date to be processed.
     * @return string The Week from date.
     */
    function get_week($target_date)
    {
        return date("w", strtotime($target_date));
    }
    
    /**
     * Get the first day of the Month of the target date
     * @param string $target_date The target date to be processed.
     * @return string The processed date in [YYYY-MM-DD] format.
     */
    function get_month_first($target_date)
    {
        $year = date("Y", strtotime($target_date));
        $month = date("m", strtotime($target_date));
    	return "$year-$month-01";
    }
    
    /**
     * Get the last day of the Month of the target date
     * @param string $target_date The target date to be processed.
     * @return string The processed date in [YYYY-MM-DD] format.
     */
    function get_month_end($date)
    {
    	$year = date("Y", strtotime($date));
    	$month = date("m", strtotime($date));
    	$day = get_last_day($year, $month);
    	return "$year-$month-$day";
    }
    
    
    /**
     * Check if the string is null
     * @param string $inStr The string to be checked.
     * @return string The inputted string if it not null; otherwise blank.
     */
    function chk_str($inStr)
    {
        if(isset($inStr)) return $inStr;
        else return "";
    }
    
    /**
     * Generate Hash Code
     * @return string The generated Hash Code.
     */
    function get_hashcode()
    {
        $CHARLIST = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $CHARLEN = 36;
        
        $number = base_convert(uniqid(), 16, 10);
        
        $dst = "";
        while($number)
        {
            $dst = @$CHARLIST[@fmod($number, $CHARLEN)] . $dst;
            $number = floor($number / $CHARLEN);
        }
        
        return strval($dst);
    }
    
    /**
     * Output Arbitrary Log (Variable)
     */
    function log_val($inLogFl, $inVal)
    {
        ob_start();
        print_r($inVal);
        $buffer = ob_get_contents();
        ob_end_clean();
        
        $fp = fopen($inLogFl, "a");
        fputs($fp, date("Y/m/d H:i:s").":$buffer\n");
        fclose($fp);
    }
    
    /**
     * Output Arbitrary log (Character String)
     */
    function log_str($inLogFl, $inStr)
    {
        $fp = fopen($inLogFl ,"a");
        fputs($fp,date('Y/m/d H:i:s').":$inStr\n");
        fclose($fp);
    }
    
    /**
     * Cut a string to the specified number of characters and add "..." as replacement to the removed character/s
     * @param string $inStr The target string to be processed.
     * @param int $inLen The specified length of output string.
     * @return string $output The processed string.
     */
    function sep_string($inStr, $inLen)
    {
        if(mb_strlen($inStr) <= $inLen) return $inStr;
        
        return mb_substr($inStr, 0, $inLen)."...";
    }
    
    /**
     * Check if the date string is invalid or null
     * @param string $val The target date string to be processed.
     * @return bool true if the value is invalid; otherwise false.
     */
    function isNULLDate($val)
    {
        if($val == null || $val == "" || $val == "0000-00-00" || $val == "0000-00-00 00:00:00") return true;
        
    	return false;
    }
    
    /**
     * Change the date to the specified format
     * @param string $str The the target format.
     * @param string $target_date The target date string to be processed.
     * @return string the formatted date if the date is valid; otherwise " - ".
     */
    function setDate($str, $target_date)
    {
        if($target_date === "0000-00-00 00:00:00" ||
            $target_date === "00:00:00" ||
            $target_date === "0000-00-00" ||
            trim($target_date) === "" ||
            !isset($target_date)) return " - ";
        
      	$tmpdate = strtotime($target_date);
      	return date($str, $tmpdate);
    }
    
    /**
     * UniqCode to Text
     * @param string $c The the target character.
     * @return mixed the position of where the character exists relative to the beginning of
     * the character list string (independent of offset).
     * Also note that string positions start at 0, and not 1.
     * <p>
     * Returns false if the character was not found.
     * </p> 
     */
    function rev_uc($c)
    {
    	$CHARLIST = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      	$CHARLEN = 36;
    
    	$pos = strpos($CHARLIST, $c);
    	return $pos;
    }
    
    /**
     * Reverse Text
     * @param string $in The target string to be reversed.
     * @return string $ret The reverse output of the string.
     */
    function str_rev($in)
    {
    	$ret = "";
    	
    	for($i = strlen($in); $i > 0 ;$i = $i - 1) $ret .= $in[$i-1];
    	return $ret;
    }
    
    /**
     * Create Check Digit
     * @param string $in The target string to be processed.
     * @return string $dst The string with the check digit.
     */
    function make_cd($in)
    {
    	$CHARLIST = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      	$CHARLEN = 36;
    
    	$cd_num = 0;
    	
    	for($i = 0; $i < strlen($in); $i++) $cd_num += rev_uc($in[$i]);
    	
    	$dst = @$CHARLIST[@fmod($cd_num, $CHARLEN)];
    	
    	return $dst;
    }
    
    /**
     * Check for Check Digit
     * @param string $in The target string to be processed.
     * @return bool true if a check digit exist; otherwise false.
     */
    function chk_cd($in)
    {
    	$CHARLIST = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      	$CHARLEN = 36;
    
    	$cd_num=0;
    	for($i = 0; $i < strlen($in) - 1; $i++) $cd_num += rev_uc($in[$i]);
    	$dst = @$CHARLIST[@fmod($cd_num, $CHARLEN)];
    	
    	if($in[strlen($in) - 1] == $dst) return TRUE;
    
    	return FALSE;
    }
    
    /**
     * 2 Way Integer Hash Function
     * @param int $inNum The target integer to be processed.
     * @return int processed number (hashed or unhashed).
     */
    function numhash($inNum)
    {
        return (((0x0000FFFF & $inNum) << 16) + ((0xFFFF0000 & $inNum) >> 16));
    }
?>
