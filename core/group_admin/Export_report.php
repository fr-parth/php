<?php session_start(); ob_start();
//Added by Sayali for SMC-4920 on 22/10/2020


	//code to download the data of report in the excel format

	$fn=$_GET['fn'].".xls";

	include_once("class.export_excel.php");

	//create the instance of the exportexcel format

	$excel_obj=new ExportExcel("$fn");

	//setting the values of the headers and data of the excel file 

	//and these values comes from the other file which file shows the data

	@$excel_obj->setHeadersAndValues($_SESSION['report_header'],$_SESSION['report_values']); 

	//now generate the excel file with the data and headers set

	$excel_obj->GenerateExcelFile();

	//print_r($_SESSION['report_values']);

	

	

?>

