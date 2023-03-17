<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Common Processing Function Group (Business Unit)
     * @version 2.0
     */

    /**
     * Function that acquires the date and returns it to the reference destination while generating the target Date
     * @param string $y [optional] The specifed year. Default to the current Year.
     * @param string $m [optional] The specifed month. Default to the current Month.
     * @param string $d [optional] The specifed day. Default to the current Day.
     * @param string $str [optional] The specifed character separator. Default to -.
     * @return string Date
     */
    function getTargetDateAndSet($y = null, $m = null, $d = null, $str = '-')
    {
        $ret = null;
        
        if(empty($y))
        {
            $ret = date('Y');
            $y = date('Y');
        }
        else $ret = $y;
        
        if(empty($m))
        {
            $ret .= (isset($ret)) ? $str.date('m') : date('m');
            $m = date('m');
        }
        else $ret .= (isset($ret)) ? $str.$m : $m;
        
        if(empty($d))
        {
            $ret .= (isset($ret)) ? $str.date('d') : date('d');
            $d = date('d');
        }
        else $ret .= (isset($ret)) ? $str.$d : $d;
        
        return $ret;
    };
    
    /**
     * Fiscal Year acquisition
     * @param string $indate The specifed date.
     * @return string The fiscal year.
     */
    function get_nendo($indate){
        
    	//Get the month of the specified date
    	$month = date("m",strtotime($indate));
    
    	//Get the year of the specified date
    	$year = date("Y",strtotime($indate));
    
    	//Year Decision
    	if($month == 1 || $month == 2 || $month == 3) $year = $year - 1;
    
    	return $year;
    }
    
    /**
     * Fiscal Year Start Date acquisition
     * @param string Year The specifed date.
     * @return string The Start Date of the Fiscal Year.
     */
    function get_nendo_start($inYear){
        //Get the year of the specified date
    	$year = $inYear;
    
    	return $year."/04/01";
    }
    
    /**
     * Fiscal Year End Date acquisition
     * @param string Year The specifed date.
     * @return string The End Date of the Fiscal Year.
     */
    function get_nendo_end($inYear){
        //Get the year of the specified date
    	$year = $inYear;
    
    	return ($year + 1) ."/03/31";
    }
?>
