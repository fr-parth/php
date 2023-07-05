<?php
include("groupadminheader.php");
//include('../conn.php');


$uploaded_by = $_SESSION['group_admin_id'];
$group_admin_id = $_SESSION['group_admin_id'];


if($_SESSION['entity'] !=12){

	echo "You are not authorize to view this page.";
	exit;
}
?>
<div class='container'>



<div class='panel panel-default'>

	<div class='panel-heading' align ='center'>

<h2>Subject/Game Types Upload Panel </h2></div>
<form method="post" action="" enctype="multipart/form-data">
<table align='left'>

<!-- <tr><br><td><b>Select upload data type: </td><td><select name="file_type" id= 'file_type'/><option value=''>Select data type</option>
<option value='basic_data'>Student's basic data</option>
 <option value='all_data'>Student's all data</option> </td></tr> -->
<tr><br><td><b>Select file: </td><td><input type="file" name="file"/></td></tr>
		   
		<tr><td><br><input class="btn btn-success" type="submit" name="submit_file" value="Submit"/></td></tr>
		</table>
 </form>

 <form method='post' enctype='multipart/form-data'>
<table align='right'>
		<div class='row'>
			<select name='data_format' id='data_format'>

				<option value=''>Select format</option>
				<option value='basic_data_format'>Subject/Game types data format</option>
				<!-- <option value='all_data_format'>Student's all data format</option> -->
				

			</select>

			<button type='submit' name='dformat' class='btn btn-success btn-xs' >Download Format</button>
		</div>	
</table>
		</form>
	<div class='panel-body'>

	<div class='row'>

	<div class='col-md-8'>

	</div>
	</div>
	</div>
	</div>
	</div>


<?php 

 if(isset($_POST["submit_file"]))
 { 
	 $filetype = $_POST["file_type"];
	 $filename = basename($_FILES['file']['name']); //exit; 
	 $file = $_FILES['file']['tmp_name'];
	 $handle = fopen($file, "r");


		if ($file == NULL)
		{
		 echo "Please select a file to import";
		  
		}
		$m =0;
		$row =0;
			while ( ($data = fgetcsv($handle) ) !== FALSE ) {
				if($row==0){$row++; continue;}
			$fields = array();
			for($i=0;$i<count($data); $i++) {
				$fields[] = '\''.addslashes($data[$i]).'\'';
			}
			//query
				if($fields[0] != '')
				{
					$sql = "Insert into tbl_games values(''," . implode(', ', $fields) . ",'$uploaded_by',NOW(),'$group_admin_id ');"; //exit;
					 
					$res = mysql_query($sql);
					if($res)
						{
						   $m++;
						}
				}
			}
			echo "<div align='center'><font color='green'><b>Total uploaded records: ".$m."</b></font></div>";

}

if(isset($_POST['dformat']))
{

	$data_format=$_POST['data_format'];	
	$path = url()."/core/Importdata/";

	if($data_format =='basic_data_format')
	{
		$filename="Subjectgame_type_format.csv";
		$filepath = $path.$filename;

		echo "<script>window.open('$filepath');</script>";

	}
	
}
?>