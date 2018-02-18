<?php
require_once('./class/crisper.php');
error_reporting(0);
$crisper = new crisper;
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $url = $crisper->GetUrl($code);
    if($url){
        header("Location:{$url}");
        exit();
    }
    else{ 
        header('Location:./pg404.html');
    }
     
}
else if(isset($_POST['url'])){
    
     $url  = trim($_POST['url']);
     $result = $crisper->AddUrl($url);  
     if($result){
        if($result=='invalid'){
            echo json_encode(array('status'=>'invalid','url'=>''));
        }else{
            $level = dirname($_SERVER['PHP_SELF']) == '/'?'':dirname($_SERVER['PHP_SELF']); // to include the parent directory
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".$level."/{$result}";
            echo json_encode(array('status'=>'success','url'=>$actual_link));
        }
     }
     else{
            echo json_encode(array('status'=>'failed','url'=>''));
     }
     return;   
}
else {
    header('Location:./index.html');
} 
 
?>