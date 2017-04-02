<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('dumping'))
{
    function dumping($var = array())
    {
        echo"<pre>";
        print_r($var);
        echo "</pre>";
    }   
}
if ( ! function_exists('todate'))
{
    function todate($var = "",$noref=TRUE)
    {	
       if($noref){ 
       	$new=explode("/",$var);
        if(sizeof($new)==3){
        	return $new[2]."-".$new[1]."-".$new[0];
        }else{
        	return "";
        }
       }else{
       	$new=explode("-",$var);
       		if(sizeof($new)==3){
        	return $new[2]."/".$new[1]."/".$new[0];
	        }else{
	        	return "";
	        }
       } 
    }   
}