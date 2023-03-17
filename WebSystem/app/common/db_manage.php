<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name DB Management Class MySQL
     * @version 2.0
     */
    
    /**
     * Database Class
     */
    class db_manage
    {
        public  	$db;		//DB Instance
        public  	$error;		//Error Message
        private     $errno;
        private     $errstr;
        
        private $db_serv = "127.0.0.1";		//DB Server
        private $db_user = "TestUser";		//DB User
        private $db_pass = "TestPass";		//DB Password
        private $db_schema = "test";		//DB Schema
        
        /**
         * Constructor Function
         * @param string $inServ
         */
        function __construct($inServ = null)
        {
            //no $inServer
            // if($inServ == null) $this->db = mysqli_connect($this->db_serv ,$this->db_user ,$this->db_pass, $this->db_schema);
            // else $this->db = mysqli_connect($inServ ,$this->db_user ,$this->db_pass);
                    
            if($this->db == false)
            {
                // $this->error = "DB Connection Error: ".mysqli_error($this->db);
                $this->db = null;
                return;
            }
            
            mb_language("uni");
            mb_internal_encoding("utf-8"); //Change Default Character Code
            mb_http_input("auto");
            mb_http_output("utf-8");
            $sql = "SET NAMES utf8mb4";
            mysqli_query($this->db, $sql);
        }
        
        /**
         * Table Data Collector Function
         * @param string $intable The target Table from the database 
         * @param string $infields [optional] (Default null) The target column/s to fetch from the specified table. This fetch all columns if null.
         * @param string $inwhere [optional] The target condition/s. eg: id = 3 AND create_date > 2020/08/03
         * @param string $inorder [optional] The order of values. eg: id DESC
         * @param string $indesc [optional] Additional options for the query. eg: LIMIT 30
         * @return array of selected column values
         */
        function select($intable, $infields = null, $inwhere = "", $inorder = "", $indesc = "")
        {
            if( $infields == null )$infields = "*";
            if( $inwhere != "" ) $inwhere = " WHERE ".$inwhere;
            if( $inorder != "" ) $inorder = " ORDER BY ".$inorder;
            
            $sql = "SELECT $infields
                    FROM $intable
                    $inwhere
                    $inorder
                    $indesc
                    ;";
            
            $res = mysqli_query($this->db,$sql);
            if(mysqli_errno($this->db) != 0)
            {
                $error = mysqli_error($this->db);
                return $error;
            }
            
            $ret = array();
            
            while($row = mysqli_fetch_array($res)) array_push($ret ,$row);
            
            return $ret;
        }
        
        /**
         * All Table Data Collector Function
         * @param string $intable The target Table from the database
         * @return array of all column values
         */
        function get_table($intable)
        {
            $sql = "SELECT *
                    FROM $intable
                    ORDER BY id;";
            
            $res = mysqli_query($this->db, $sql);
            
            if(mysqli_errno($this->db) != 0)
            {
                $error = mysqli_error($this->db);
                return $error;
            }
            
            $ret = array();
            while($row = mysqli_fetch_array($res)) array_push($ret ,$row);
            
            return $ret;
        }
        
        /**
         * Run SQL String Query 
         * @param string $insql The SQL Query String
         * @return array of selected column values
         */
        function exec_query($insql)
        {
            $res = mysqli_query($this->db, $insql);
            
            if( mysqli_errno($this->db) != 0)
            {
                $error = mysqli_error($this->db);
                return $error;
            }
                
            $ret = array();
            
            while($row = mysqli_fetch_array($res)) array_push($ret, $row);
            
            return $ret;
        }
        
        /**
         * Run SQL String Query for Execution(UPDATE, DELETE, INSERT, etc. commands)
         * @param string $insql The SQL Query String
         * @return int 0 if true; otherwise returns string MySQL error 
         */
        function exec_cmd($insql)
        {
            $res = mysqli_query($this->db, $insql);
            
            if( mysqli_errno($this->db) != 0)
            {
                $error = mysqli_error($this->db);
                return $error;
            }
            
            return 0;
        }
        
        /**
         * Get Fields of target Table
         * @param string $intable The target table
         * @return array values of fields
         */
        function get_fields($intable)
        {
            $sql = "SHOW FIELDS
                    FROM $intable
                    ;";
            $res = mysqli_query($this->db, $sql);
            $ret = array();
            
            while($row = mysqli_fetch_assoc($res)) array_push($ret ,$row);
            
            return $ret;
        }
        
        /**
         * Check if field exisit in an array.
         * @param array $fld_array Array that contains the group of fields and types.
         * @param string $infield The target field that needs to be check.
         * @return bool true if Field exist; otherwise returns false.
         */
        function chk_field($fld_array, $infield)
        {
            for($lp = 0; $lp < count($fld_array); $lp++)
                if(strcmp($fld_array[$lp]["Field"], $infield) == 0) return true;
            return false;
        }
        
        /**
         * Get the Type of Field
         * @param array $fld_array Array that contains the group of fields and types.
         * @param string $infield The target field that needs to be check for type. 
         * @return string The type of field; otherwise null if the field does not exist.
         */
        function get_field_type($fld_array, $infield)
        {
            for($lp = 0; $lp < count($fld_array); $lp++)
                if(strcmp($fld_array[$lp]["Field"], $infield) == 0 ) return $fld_array[$lp]["Type"];
                
            return null;
        }
        
        /**
         * Escape the input value to prevent SQL Injections
         * @param string $value Unprocessed string.
         * @return string $value Processed string.
         */
        function escape($value)
        {
            //Check duplicate escape character
            if (get_magic_quotes_gpc()) $value = stripslashes($value);
            
            //Quote
            $value = "'" . mysqli_real_escape_string($value) . "'";
            
            return $value;
        }
        
        /**
         * Get the last ID INSERT Command ID.
         * @return int Last ID
         */
        function get_last_id()
        {
            return mysqli_insert_id($this->db);
        }
        
        /**
         * Get the Error Number
         * @return int Error Number
         */
        function get_error_no()
        {
            return mysqli_errno($this->db);
        }
        
        /**
         * Get the Error Message
         * @return string Error
         */
        function get_error_msg()
        {
            return mysqli_error($this->db);
        }
        
        /**
         * Data Insert/Update Function Function.
         * @param string $in_table The Target table.
         * @param array $in_arr The target columns and values for the command. format: array(colum1=value1,column2=value2).
         * @param string $in_id ID of the data to be updated, input 0 if new.
         * @return string "OK:[last_id]" if INSERT command is successful; "OK:[data_id]" if UPDATE command is successful; otherwise "$error  $sql".
         */
        function data_update($in_table, $in_arr, $in_id)
        {
            $rec_mode = "new";
            $sql = "SELECT COUNT(id)
                    FROM $in_table
                    WHERE id = $in_id
                    ;";
            $res = $this->exec_query($sql);
            if($res[0][0] == 1 && $in_id != -1) $rec_mode = "update";
            
            //Get Field Data From Table
            $fields = $this->get_fields($in_table);
            
            //Make Update String
            $ins_fld="";
            $ins_val="";
            $upd_val="";
            foreach ($in_arr as $key => $val)
            {
                //Check Field Name
                for($lp=0; $lp<count($fields); $lp++)
                {
                    if( $key == $fields[$lp]["Field"])
                    {
                        if($rec_mode == "new")
                        {
                            if($ins_fld != "") $ins_fld .= ",";
                            
                            $ins_fld .= $key;
                            
                            if($ins_val != "") $ins_val .= ",";
                            
                            if(strstr($fields[$lp]["Type"], "int") != false ||
                                strstr($fields[$lp]["Type"], "datetime") != false ||
                                strstr($fields[$lp]["Type"], "timestamp") != false ||
                                strstr($fields[$lp]["Type"], "decimal") != false) $ins_val .= $val;
                            else $ins_val .= "'$val'";
                        }
                        else
                        {
                            if($upd_val != "") $upd_val .= ",";
                            
                            $upd_val .= "$key = ";
                            
                            if(strstr($fields[$lp]["Type"],"int") != false ||
                                strstr($fields[$lp]["Type"], "datetime") != false ||
                                strstr($fields[$lp]["Type"], "timestamp") != false ||
                                strstr($fields[$lp]["Type"], "decimal") != false) $upd_val .= $val;
                            else $upd_val .= "'$val'";
                        }
                        
                        break;
                    }
                }
            }
            
            //create the SQL String
            $sql="";
            
            if($rec_mode == "new")
            {
                $sql = "INSERT INTO $in_table ($ins_fld)
                        VALUES ($ins_val)
                        ;";
            }
            else
            {
                $sql = "UPDATE $in_table
                        SET $upd_val
                        WHERE id = $in_id
                        ;";
            }
            
            //Start Transaction
            mysqli_query($this->db, "begin");
            $res = mysqli_query($this->db,$sql);
            
            if(mysqli_errno($this->db) != 0)
            {
                $error = mysqli_error($this->db);
                mysqli_query($this->db, "rollback");
                return "$error  $sql";
            }
            
            $ret_str = "";
            if($rec_mode == ("new")) $ret_str = "OK:".mysqli_insert_id($this->db);
            else $ret_str = "OK:$in_id";
                
            mysqli_query($this->db, "commit");
            return $ret_str;
        }
    }
?>
