<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Tag Output Function
     * @version 2.0
     */

    /**
     * Common List Creator Function
     * @param array $dbArry The array to be output as list.
     * @param array $in_id The default selected value of the list.
     * @param string $list_name Name and ID of the list.
     * @param array $mode [optional] Set to 1 to enable multiple selection on the list;
     * otherwise set 0.
     * @param array $label_mode [optional] <p>
     * The default label of the list.
     * </p>
     * <p>
     * Label Modes:
     * <p>
     * <br>
     * 0 - (default) No Label<br>
     * 1 - Value='', Label='Unspecified'<br>
     * 2 - Value='-1', Label='Don't Use'<br>
     * 3 - Value='-2', Label='---'<br>
     * 4 - Value='-1', Label='---'<br>
     * </p>
     * </p>
     * @return mixed HTML string for Select Tag
     */
    function make_list($dbArry, $in_id, $list_name, $mode = 0, $label_mode = 0)
    {
    	$multi = "";
    	
    	if($mode == 1) $multi = "multiple";
    	
    	echo "<select name='$list_name' id='$list_name' $multi>";
    	if($label_mode == 1) if($mode != 1) echo "<option value=\"\">Unspecified</option>\n";
    	else if ($label_mode == 2) echo "<option value=-1>Don't Use</option>\n";
    	else if ($label_mode == 3) echo "<option value=-2> --- </option>\n";
    	else if ($label_mode == 4) ;
    	else if ($mode != 1)
    	{
    		if($label_mode == 4) ;
    		else echo "<option value=-1> --- </option>\n";
    		
    	}
    	
    	for($lp=0; $lp < count($dbArry); $lp++)
    	{
    		$sel_flg = "";
    		if($dbArry[$lp]["code"] == $in_id) $sel_flg = " selected";
    		echo "<option value='".$dbArry[$lp]["code"]."' $sel_flg>".$dbArry[$lp]["value"]."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * String List of Category
     * @param array $in_id The default selected value of the list.
     * @param string $list_name Name and ID of the list.
     * @param mixed $code_cate Code of Category from the database.
     * @param array $mode [optional] Set to 1 to enable multiple selection on the list;
     * otherwise set 0.
     * @param array $label_mode [optional] <p>
     * The default label of the list.
     * </p>
     * <p>
     * Label Modes:
     * <p>
     * <br>
     * 0 - (default) No Label<br>
     * 1 - Value='', Label='Unspecified'<br>
     * 2 - Value='-1', Label='Don't Use'<br>
     * 3 - Value='-2', Label='---'<br>
     * 4 - Value='-1', Label='---'<br>
     * </p>
     * </p>
     * @return mixed HTML string for Select Tag
     */
    function string_list($in_id, $list_name, $code_cate, $mode = 0, $label_mode = 0)
    {
    	global $db;
    	
    	$sql = "SELECT code, value
                FROM m_code
                WHERE cate = $code_cate
                ;";
    	$res = $db->exec_query($sql);
    	make_list($res, $in_id, $list_name, $mode, $label_mode);
    }
    
    /**
     * Gender List
     * @param array $in_id The default selected value of the list.
     * @param string $list_name Name and ID of the list.
     * @return mixed HTML string for Select Tag
     */
    function sex_list($in_id, $list_name){
    	$res=array();
    	//Male
    	$res[0]["code"] = "男";
    	$res[0]['value'] = "男";
    	
    	//Female
    	$res[1]["code"] = "女";
    	$res[1]['value'] = "女";
    
    	make_list($res, $in_id, $list_name, 0, 4);
    }
    
    /**
     * List creator function for DB list
     * @param array $in_id The default selected value of the list.
     * @param string $list_name Name and ID of the list.
     * @param array $dbArry The array to be output as list.
     * @param mixed $code_cate Code of Category from the database.
     * @param array $mode [optional] Set to 1 to enable multiple selection on the list;
     * otherwise set 0.
     * @param array $label_mode [optional] <p>
     * The default label of the list.
     * </p>
     * <p>
     * Label Modes:
     * <p>
     * <br>
     * 0 - (default) No Label<br>
     * 1 - Value='', Label='Unspecified'<br>
     * 2 - Value='-1', Label='Don't Use'<br>
     * 3 - Value='-2', Label='---'<br>
     * 4 - Value='-1', Label='---'<br>
     * </p>
     * </p>
     * @return mixed HTML string for Select Tag
     */
    function string_dblist($in_id, $list_name, $dblist, $mode=0, $label_mode=0)
    {
    	make_list($dblist ,$in_id ,$list_name,$mode,$label_mode);
    }
    
    /**
     * Daily list for the past 2 months of the specified date
     * @param array $in_id The default selected value of the list.
     * @param string $list_name Name and ID of the list.
     * @param array $indate The date to start the list from.
     * @return mixed HTML string for Select Tag
     */
    function get_daycopy_list($in_id,$list_name,$indate){
        
    	//Get the previous date
    	$lastday = get_ch_day_str($indate,"-1 day");
    
    	//Create the daily list
    	$a_day = array();
    	for($i = 0; $i < 62; $i++)
    	{
    		$a_week[$i]["code"] = get_ch_day_str($lastday,"-".$i." day");
    		$a_week[$i]['value'] = get_ch_day_str($lastday,"-".$i." day");
    	}
    
    	make_list($a_week,$in_id,$list_name);
    }
    
    /**
     * Yearly List display
     * @param string $list_name Name and ID of the list.
     * @return mixed HTML string for Select Tag
     */
    function get_year_list($list_name){
    
    	//Get Current date and time
    	$now = getdate();
    
    	//Get Current Year
    	$year = $now['year'];
    
    	//List Creation
    	echo "<select name='".$list_name."' id='".$list_name.">";
    	for($i = 10; $i >= 0; $i = $i - 1 )
    	{
    		$cur_year = $year - $i;
    		
    		if($i==0) $selected = " selected";
    		else $selected = "";
    		
    		echo "<option value='".$cur_year."' ".$selected.">".$cur_year."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Yearly List display before the specified year
     * @param string $list_name Name and ID of the list.
     * @param string $inyear The specified year.
     * @return mixed HTML string for Select Tag
     */
    function get_year_list_set($list_name, $inyear){
    
        //Get Current date and time
    	$now = getdate();
    
    	//Start Year
    	$year = $now['year']+1;
    
    	//List Creation
    	echo "<select name='".$list_name."' id='".$list_name.">";
    	for($i = 5; $i >= 0; $i = $i - 1)
    	{
    		$cur_year = $year - $i;
    		if( $cur_year == $inyear ) $selected = " selected";
    		else $selected = "";
    		
    		echo "<option value='".$cur_year."' ".$selected.">".$cur_year."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Yearly List display after the specified year
     * @param string $list_name Name and ID of the list.
     * @param string $inyear The specified year.
     * @return mixed HTML string for Select Tag
     */
    function get_year_list_set_after($list_name,$inyear){
    
        //Get Current date and time
    	$now = getdate();
    
    	//Start Year
    	$year = $now['year'];
    
    	//List Creation
    	echo "<select name='".$list_name."' id='".$list_name."'>";
    	for($i = 0; $i < 7; $i++)
    	{
    		$cur_year = $year + $i;
    		if($cur_year == $inyear) $selected = " selected";
    		else $selected = "";
    		
    		echo "<option value='".$cur_year."' ".$selected.">".$cur_year."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * List of Month
     * @param string $list_name Name and ID of the list.
     * @return mixed HTML string for Select Tag
     */
    function get_month_list($list_name){
    
    	//Get current date
    	$now = getdate();
    
    	//Start Month
    	$month = $now['mon'];
    
    	//List Creation
    	echo "<select name='".$list_name."' id='".$list_name."'>";
    	for($i = 0; $i <= 12; $i = $i + 1)
    	{
    		if($i == $month) $selected = " selected";
    		else $selected = "";
    		
    		echo "<option value='".$i."' ".$selected.">".$i."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * List of Month with specific selected month.
     * @param string $list_name Name and ID of the list.
     * @param string $inmonth The specified Month.
     * @return mixed HTML string for Select Tag
     */
    function get_month_list_set($list_name, $inmonth){
    
    	//Get Current Date
    	$now = getdate();
    
    	//Specified month
    	$month = $inmonth;
    
    	//List Creation
    	echo "<select name='".$list_name."' id='".$list_name."'>";
    	
    	for($i = 1; $i <= 12; $i = $i + 1)
    	{
    		if($i == $month) $selected = " selected";
    		else $selected = "";
    		
    		if($i < 10) $i = "0".$i;
    		echo "<option value='".$i."' ".$selected.">".$i."</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Checkbox generation
     * @param string $name Name and ID of the list.
     * @param string $inId Set to 1 for the checkbox to be checked; otherwise 0.
     * @return mixed HTML string for Checkbox Tag
     */
    function make_chkbox($name, $inId)
    {
    	$checked = "";
    	if($inId == 1) $checked = "checked";
    	
    	echo "<input type=checkbox name=".$name." id=".$name." value=1 ".$checked.">";
    }
    
    
    /**
     * Time list generation with a 30-minute interval
     * @param string $name Name and ID of the list.
     * @param string $inId The specified selected time.
     * @return mixed HTML string for Select Tag
     */
    function make_timelist($name, $inId)
    {
    	echo "<select name='".$name."'>";
    	for($lp = 0; $lp < 24 ; $lp++)
    	{
    		$sel = "";
    		if($lp == $inId) $sel="selected";
    		
    		echo "<option value='".$lp.":00' ".$sel.">".$lp.":00</option>\n";
    		echo "<option value='".$lp.":30'>".$lp.":30</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Time list generation with a 30-minute interval with additional settings
     * @param string $name Name of the list.
     * @param string $inId ID of the list.
     * @param string $timeval The Default selected time. ex: 8:30, 15:00, 17:30, etc.  Default value is 7:00.
     * @param string $append_attr The Additional attribute/s for the tag.
     * @param bool $hasEmpty [optional] Set to true if you want a padding option in the list;
     * otherwise this is default to false
     * @return mixed HTML string for Select Tag
     */
    function make_timelist2($name, $inId, $timeval, $append_attr, $hasEmpty=false)
    {
    	if(isset($timeval) || $timeval != 0)
    	{
    		$hour = date('H', strtotime($timeval));
    		$min = date('i', strtotime($timeval));
    	}
    	else
    	{
    	    //default selected time if there is no padding option
    		if(!$hasEmpty)
    		{
    		    $hour=7;
    		    $min="00";
    		}
    	}
    	
    	$attr="";
    	if(isset($append_attr) && $append_attr!=null) $attr = $append_attr;
    
    	echo "<select name='".$name."' id='".$inId."' ".$attr.">";
    	if($hasEmpty) echo "<option value=''>--</option>\n";
    	
    	$seltext="selected = \"selected\"";
    	for( $lp = 0; $lp < 24; $lp++)
    	{
    		if($lp == $hour && $min == "00") echo "<option value='".$lp.":00' ".$seltext.">".$lp.":00</option>\n";
    		else echo "<option value='".$lp.":00' ".">".$lp.":00</option>\n";
    		
    		if($lp == $hour && $min == "30") echo "<option value='".$lp.":30' ".$seltext.">".$lp.":30</option>\n";
    		else echo "<option value='".$lp.":30'>".$lp.":30</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Time list generation with a 30-minute interval with additional settings
     * @param string $name Name of the list.
     * @param string $inId ID of the list.
     * @param string $timeval The Default selected time. ex: 8:30, 15:00, 17:30, etc. Default value is 7:00.
     * @param string $append_attr The Additional attribute/s for the tag.
     * @return mixed HTML string for Select Tag
     */
    function make_timelist3($name, $inId, $timeval, $append_attr)
    {
    	if(isset($timeval) || $timeval != 0)
    	{
    		$hour = date('H', strtotime($timeval));
    		$min = date('i', strtotime($timeval));
    	}
    	else
    	{
    		$hour = 7;
    		$min = "00";
    	}
    	
    	$attr = "";
    	if(isset($append_attr)) $attr = $append_attr;
    
    	echo "<select name = '".$name."' id = '".$inId."' ".$attr.">";
    	$seltext = "selected = \"selected\"";
    	
    	for($lp = 0; $lp < 24; $lp++)
    	{
    		if($lp == $hour && $min == "00") echo "<option value='".$lp.":00' ".$seltext.">".$lp.":00</option>\n";
    		else echo "<option value='".$lp.":00' ".">".$lp.":00</option>\n";
    		
    		if($lp == $hour && $min == "10") echo "<option value='".$lp.":10' ".$seltext.">".$lp.":10</option>\n";
    		else echo "<option value='".$lp.":10' ".">".$lp.":10</option>\n";
    		
    		if($lp == $hour && $min == "20") echo "<option value='".$lp.":20' ".$seltext.">".$lp.":20</option>\n";
    		else echo "<option value='".$lp.":20' ".">".$lp.":20</option>\n";
    		
    		if($lp == $hour && $min == "30") echo "<option value='".$lp.":30' ".$seltext.">".$lp.":30</option>\n";
    		else echo "<option value='".$lp.":30'>".$lp.":30</option>\n";
    		
    		if($lp == $hour && $min == "40") echo "<option value='".$lp.":40' ".$seltext.">".$lp.":40</option>\n";
    		else echo "<option value='".$lp.":40'>".$lp.":40</option>\n";
    		
    		if($lp == $hour && $min == "50") echo "<option value='".$lp.":50' ".$seltext.">".$lp.":50</option>\n";
    		else echo "<option value='".$lp.":50'>".$lp.":50</option>\n";
    	}
    	echo "</select>";
    }
    
    /**
     * Create option tag from master table.
     * @param object $db The DB Class.
     * @param string $selectedval The default selected value.
     * @param string $tablename The specified table to get data from.
     * @param string $value_column Column name of the table.
     * @param string $text_column The Text output of the Option Tag.
     * @param string $key_column [optional] Primary Key Column of the table.
     * @param string $keyval [optional] Key Value to filter.
     * @param string $readonly [optional] Setting if the option tag is readonly.
     * @return mixed HTML string for Option Tag
     */
    function make_opt($db, $selectedval, $tablename, $value_column, $text_column, $key_column = null, $keyval = null, $readonly = false)
    {
    	$txt = "";
    
    	//Initial value when there is no value in readonly
    	$firstval= false;
    	if($readonly && $selectedval == null) $firstval = true;
    	
    	$sql = "SELECT * FROM ".$tablename;
    	if($key_column != null) $sql = $sql." WHERE ".$key_column." = '".$keyval."' ";
    	
    	$sql = $sql." ORDER BY ".$value_column;
    	$rows = $db->exec_query($sql);
    	
    	foreach ($rows as $row)
    	{
    		if($row[$value_column] == $selectedval) $txt = $txt."<option value = '".$row[$value_column]."' selected>".$row[$text_column]."</option>\n";
    		else
    		{
    			if(!$readonly || $firstval)
    			{
    				$txt = $txt."<option value = '".$row[$value_column]."'>".$row[$text_column]."</option>\n";
    				$firstval = false;
    			}
    		}
    	}
    	
    	return $txt;
    }
    
    /**
     * Database data acquisition function
     * @param object $db The DB Class.
     * @param string $tablename The specified table to get data from.
     * @param string $value_column Column name to sort the data from.
     * @param string $key_column [optional] Primary Key Column of the table.
     * @param string $keyval [optional] Key Value to filter.
     * @return array data from the specified table 
     */
    function get_dbrows($db, $tablename, $value_column, $key_column = null, $keyval = null)
    {
    	$sql = "SELECT *
                FROM $tablename";
    	if($key_column != null) $sql = "$sql
    	                               WHERE $key_column = '$keyval' ";
    	
    	$sql = "$sql
    	       ORDER BY $value_column";
    	
    	return $db->exec_query($sql);
    }

    /**
     * Year Period List
     * @param string $inval The default selected value from the list.
     * @param string $listname The name and ID of the Select tag.
     * @return mixed HTML string for Select Tag
     */
    function nendo_list($inval, $listname)
    {
    	$this_year = get_nendo(date('Y-m-d'));
    
    	echo "<select name='".$listname."' id='".$listname."' >";
    
    	for( $lp=0; $lp<12; $lp++)
    	{
    		$tar_year=$this_year - $lp;
    		$select="";
    		
    		if($tar_year == $inval) $select = " selected ";
    		
    		echo "<option value=".$tar_year.$select.">".$tar_year."</option>\n";
    	}
    
    	echo "</select>";
    }
?>