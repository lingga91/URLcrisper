<?php

class crisper{
    private $urlRecords;
    private $no;
    private $dir;
    
    public function __construct(){
        
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
    
      foreach ($this->urlRecords as $value) {
           
            if($value['code'] == $code){
                 return $value['URL'];
            }
       }
       
       return false;
    }
    
    private function CheckURLExist($url){
        foreach ($this->urlRecords as $value) {
           
            if($value['URL'] == $url){
                 return $value['code'];
            }
       }
       return false;
    }
    
    public function AddUrl($url){
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
            return $this->code ;   
        }
    }
}   

?>