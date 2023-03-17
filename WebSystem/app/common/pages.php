<?php
    //**************************************************************
    //**    Auto Innovate DAO - The future of decentralize management
    //**************************************************************
    /**
     * @author Sysplex IT Solutions Team
     * @name Page Processing Model
     * @version 2.0
     */
    
    /**
     * Pages Class
     */
    class pages
    {
        private    $pages = Array();	//Array for Storing Page Information
        private    $sFile;				//File for Page Control
    
    	/**
    	 * Constructor Function
    	 * @param string $inpath The path of the configuration file
    	 */
    	function __construct($inpath = null)
    	{
    		if( $inpath == null) $inpath = "../conf/pages.cfg";
    		$this->sFile = $inpath;
    
    		$ret = $this->read();
    	}
    
    	/**
    	 * Read Function
    	 */
    	private function read()
    	{
    		if(($fp = fopen($this->sFile ,"r")) == false) return false;
    
    		while(($sLine = fgets($fp)))
    		{
    			if(strlen($sLine) > 2)
    			{
    				if(strncmp($sLine ,"//" ,2) == 0) continue;
    				
    				$aLine = explode(",", $sLine);
    				
    				array_push($this->pages, $aLine);
    			}
    		}
    	}
    
    	/**
    	 * Get the configuration of the target page.
    	 * @param string $inStr The target page.
    	 * @return mixed The congfiguration of the target page; null if the page configuration does not exist.
    	 */
    	public function get($inStr)
    	{
    		for($lp=0; $lp < count($this->pages); $lp++)
    		{
    			$tmpPage = $this->pages[$lp];
    			
    			if(strcmp($tmpPage[0], $inStr) == 0)
    			{
    				return $tmpPage;
    			}
    		}
    		
    		return null;
    	}
    }