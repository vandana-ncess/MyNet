<?php

 session_start();   
//Import the PhpJasperLibrary
include_once('databaseconnection.php');

include_once('PhpJasperLibrary/tcpdf/tcpdf.php');

include_once('PhpJasperLibrary/PHPJasperXML.inc.php');

//include_once ('PhpJasperLibrary/PHPJasperXMLSubReport.inc.php');

//database connection details

$server='localhost';

$db='ncess_intranet';

$user='root';

$pass='';






//display errors should be off in the php.ini file

ini_set('display_errors', 0);

//setting the path to the created jrxml file

$xml =  simplexml_load_file('reports/rptTest.jrxml');

$PHPJasperXML = new PHPJasperXML();

//$PHPJasperXML->debugsql=true;
$start = $_SESSION['start'];
$end = $_SESSION['end'];

$PHPJasperXML->arrayParameter=array("employeeCode"=>1305);

$PHPJasperXML->xml_dismantle($xml);

//Mysql

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);// Mysql Default

//Oracle

$odbc_name='screen';

// For using Oracle , DSN create  First

//$PHPJasperXML->transferDBtoArray($server,$user,$pass,$odbc_name,'ODBC');//

$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

?>