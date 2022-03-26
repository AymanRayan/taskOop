<?php

class DB{ 
var  $server = "localhost"; //127.0.0.1
var  $dbName =  "task6";
var  $dbUser = "root";
var  $dbPassword =""; 
var  $con;

   function __construct(){
       $this->con = mysqli_connect($this->server,$this->dbUser,$this->dbPassword,$this->dbName);
       if(!$this->con){
           die('Error'.mysqli_connect_error());
       }
   }
   function doQuery($sql){
       $op =mysqli_query($this->con,$sql); 
       return $op;
   }
   
   function __destruct()
    {
        mysqli_close($this->con);
    }




}

?>