<?php
##########################################################
## Author: Hannes Rothe
## Description: Collect and aggregate data of an author using different databases
## Integrated databases via API: Readermeter
## Future Integration: CiteULike |& Bibsonomy
## Date: 2012-09-21
##########################################################
	class author_analytics{
		private  $author_data = array(
			"fname", //first name
			"lname", //last name
		);
		
		private $readermeter;
		public $debug;
		
		public function __construct(){
		}//__construct
		
		##Fetch data from data sources##
		private function fetch_data(){
			$this->readermeter = $this->set_data_rm();

		}//fetch_data
	
		##open readermeter and decode as json filetype##
		private function set_data_rm(){
			//open URL and merge to string
			$file_uri = "http://readermeter.org/".$this->author_data["lname"].".".$this->author_data["fname"]."/json";
			
			try{
				@$handle = fopen($file_uri, "r");
			}catch(Exception $e){
				$this->debug[] = $e->getMessage();
			}//catch
			
			
			//Does File with respective author exist? If so, open and read File
			if(!is_bool($handle)){
				
				while(!feof($handle)){
					@$readermeter_file .= fgets($handle);
				}//while
				
				//decode as json and return or debug
				try{
					return json_decode($readermeter_file);
				}catch(Exception $e){
					$this->debug[] = $e->getMessage();
				}//catch
					
				fclose($handle);
			
			}else {
				$this->debug[] = array("set_data_rm","Author could not be found.");
				return false;
			}//else
			

		} 
		
		public function get_data_rm(){
			
			try{
				return $this->readermeter;
			}catch(Exception $e){
				$this->debug[] = $e->getMessage();
			}//catch
		}
		
		##Set name of the author
		public function set_author_data($author_data_raw){
			if(!empty($author_data_raw)){
				$this->author_data["fname"] = $author_data_raw["fname"];
				$this->author_data["lname"] = $author_data_raw["lname"];
				
				$this->fetch_data();
				return true;
			}else{
				$this->debug[] = array("set_author_data","No data given.");
				return false;
			}
		}//set_author_data
		
		public function get_author_data(){
			if(!empty($this->author_data)){
				return $this->author_data;
			}else{
				$this->debug[] = array("get_author_data","No data set.");
				return false;
			}//else
		}//get_author_data
		
		
	}//class author_analytics
?>