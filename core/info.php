<?php 
//Updated by Sayali Balkawade for Display Logo and Entity,header ,footer and back button  name on 30/12/2020 for SMC-5058
 include 'index_header.php'; ?>
<?php 
include_once('conn.php');
//include("conn.php");
error_reporting(0);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

<style>
    @media only screen and (max-width: 800px) {

        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #no-more-tables tr {
            border: 1px solid #ccc;
        }

        #no-more-tables td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
            white-space: normal;
            text-align: left;
            font: Arial, Helvetica, sans-serif;
        }

        #no-more-tables td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;

            padding-right: 10px;
            white-space: nowrap;

        }

        /*
        Label the data
        */
        #no-more-tables td:before {
            content: attr(data-title);
        }
		
    }
	.bgwhite {
            background-color: #dcdfe3;
        }

  
</style>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Your Smartcookie Details</title>
	<meta charset="UTF-8">
</head>	
<script>
    $(document).ready(function () {
        $('#example').dataTable({
			"scrollX": true,	
		});
    });

</script>
<style>
.btnRegister {
    padding: 7px;
    background-color: #694489;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 4px;
    width: 8%;
	height:2%;
    border: #5791da 1px solid;
    font-size: 1.1em;
}
</style>
<?php 
$entity=$_GET['entity'];
$phone=$_GET['phn'];
$email=$_GET['email'];
$url_cat=$GLOBALS['URLNAME']."/core/Version4/display_student_teacher_info.php";
$myvars_cat=array(
			
			'mobile_number'=>$phone,
			'emil_id'=>$email,	
			'entity_type'=>$entity
			
			);
			$res_cat = get_curl_result($url_cat,$myvars_cat);
			$response=($res_cat['posts']);
			//print_r($res_cat);
			//$responce = $res_cat["posts"];
			//echo $response;exit;
?>
<body>
<div class='row bgwhite padtop10'>
<div style="bgcolor:#CCCCCC">

    <div class="container" style="padding:30px;">

<div class="col-md-12 " align="center" style="color:black;padding:5px;" >
                         	
                   				<h2>Your Smartcookie Details</h2>
               			 </div>

        <div style="border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 2px 3px 6px 2px #C3C3C4;">


            <div style="background-color:#F8F8F8 ;">
                <div class="row">
                    
                    <div class="col-md-10 " align="center">

                    </div>

                </div>


                <div class="row" style="padding:10px;">

                    <div class="col-md-12  " id="no-more-tables">
                        <?php $i = 0; ?>
                        <table class="table-bordered  table-condensed cf" id="example" width="100%;">
                            <thead>
                            <tr style="background-color:#694489;color:white">
                                <th style="width:10%;"><b>Sr.No</b></th>
								<th style="width:10%;"> Member ID</th>
                                <!--<th style="width:20%;">App Name</th>-->
								<b><th style="width:10%;"><?php if($entity=='103'){echo " Teacher ID";}else if($entity=='105'){echo "PRN Number";}else if($entity=='203'){echo "Manager ID";}else if($entity=='205'){echo "Employee ID";}?></th></b>
                               <b><th style="width:10%;"><?php if($entity=='103' || $entity=='105'){echo " School ID";}else{echo "Organisation ID";}?></th></b>
                                <th style="width:45%;"> <?php if($entity=='103' || $entity=='105'){echo " School Name";}else{echo "Organisation Name";}?></th>
                                <th style="width:15%;">Email ID</th>
                                  <th style="width:10%;">Phone Number</th>
                                 
                                  
                                    
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
							$i=1;
							?>
							
                 			 <?php foreach ($response as $value){
							?>
						
                                <tr style="color:#808080;" class="active" align="center">
                                    <td data-title="Sr.No" style="width:10%;"><b><?php echo "$i"; ?></b></td>
									<td data-title="Member ID" style="width:10%;"><?php echo $value['member_id'] ;?></td>
									<td data-title=" ID" style="width:10%;"><?php  if($entity=='103' || $entity=='203'){echo $value['t_id'];}else{echo $value['std_PRN'];}?> </td>
									<td data-title=" School ID" style="width:10%;"><?php echo $value['school_id'];?> </td>
									<td data-title=" School Name" style="width:10%;"><?php echo $value['school_name'] ;?> </td>
									<td data-title=" Email ID" style="width:10%;"><?php if($entity=='103' || $entity=='203'){echo $value['t_email'];}else {echo $value['std_email'];}?> </td>
									<td data-title=" Phone Number" style="width:10%;"><?php if($entity=='103' || $entity=='203'){ echo $value['t_phone'];}else{echo  $value['std_phone'];}?> </td>
									
                                  
								  
								 </tr>

                                <?php $i++; ?>
								<?php } ?>

                            </tbody>
							
                        </table>
						

                   
					<br>
							 <?php 
													 
						  $id=$value['member_id'];
						 if($entity=='103')
						 {
							 $email=$value['t_email'];
							 $phone=$value['t_phone'];
						 }else{
						 	$email=$value['std_email'];
							$phone=$value['std_phone'];
						 }
								?>
								<div align="center">
                    <input type="submit"
                        name="submit" value="Register"
                        class="btnRegister" onClick= "window.open('../index.php')" />
						
						
                </div>
					
			 </div>
                </div>
                <div class="row" style="padding:5px;">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3 " align="center">

                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-3" style="color:#FF0000;" align="center">
                       
                    </div>
                </div>
            </div>
        </div>
		</div>
		</div>
		</div>
</body>
</html>


<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>


