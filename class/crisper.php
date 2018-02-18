<?php

class crisper{
    private $urlRecords;
    private $no;
    private $dir;
    
    public function __construct(){
        
        //initialize the directory,get the existing records and make code for the next URL
        
        $this->dir = "./temp/data.txt";  
        if(filesize($this->dir)>0){
            $this->urlRecords = unserialize(file_get_contents($this->dir)); 
            $index = count($this->urlRecords) - 1; 
            $this->no = $this->urlRecords[$index]['id']+1;  
            $this->code = base_convert($this->no,10,36);
        }
        else{
            $this->urlRecords = array();
            $this->no = 10000;
            $this->code = base_convert($this->no,10,36);
        }
    }

    public function GetUrl($code){
    
      //find the matches for the user input code from the existing data, return the URL if exist
      foreach ($this->urlRecords as $value) {
           
            if($value['code'] == $code){
                 return $value['URL'];
            }
       }
       
       return false;
    }
    
    private function CheckURLExist($url){
        //find the matches for the user input URL from the existing data, return the code if exist
        foreach ($this->urlRecords as $value) {
           
            if($value['URL'] == $url){
                 return $value['code'];
            }
       }
       return false;
    }
    
    public function AddUrl($url){
    
        //validate the URL & save the URL if it valid
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return 'invalid';
        } 
        
        $URLexist = $this->CheckURLExist($url);
        if($URLexist){
            return $URLexist;
        }
        else{
            $link = array("id" =>$this->no, 
                      "code" =>$this->code,
                      "URL" => $url
                      );
            array_push($this->urlRecords,$link);               
            file_put_contents($this->dir,serialize($this->urlRecords));
            
            //to check the file exist / data exist
            if(file_exists($this->dir)){
                return $this->code ; 
            }
            else{
                return false;
            }   
        }
    }
}   

?>