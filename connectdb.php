<?php
$db_host='localhost';
$db_name='aproject';
$username='root';
$password='hard';

try{
    $db =new PDO("mysql:dbname=$db_name;host=$db_host",$username,$password);
   
}
catch(PDOException $ex){
    echo(" failed to connect to the database.<br>");
    echo($ex->getMessage());
    exit;
}


?>