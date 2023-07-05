<?php


            if(isset($_GET['id']))

			{

					include_once("school_staff_header.php");

					$report="";

					$results=mysql_query("select * from tbl_school_adminstaff where id=".$staff_id."");

					$result=mysql_fetch_array($results);

					$sc_id=$result['school_id'];



				if(isset($_POST['submit']))

                {

	

		          	$divisions=$_POST['division'];

		            $division=explode(",",$divisions);

					

			        $count=count($division);

					$class_id=$_POST['class_id'];	

					$result=mysql_query("select * from tbl_school_class where Id=$class_id");

					$values=mysql_fetch_array($result);

					$class=$values['class'];

				

					$counts=0;			

					$j=0;

				

						for($i=0;$i<count($division);$i++)

						{

							$results=mysql_query("select id,division from tbl_school_division where class_id='$class_id'  and division like '%$division[$i]%'");

									if(mysql_num_rows($results)<=0 && $division[$i]!="")

									{

									    $division[$i]=strtoupper($division[$i]);



										$query="insert into tbl_school_division(class_id,division,school_id,school_staff_id) values('$class_id','$division[$i]','$sc_id','$staff_id')";

										$rs = mysql_query($query); 

										$div2[$counts]=$division[$i];

                                        $counts++; 

									}

									else

									{

									    $div1[$j]=$division[$i];

										$j++;

									

									}

						}

						

						$divs="";

						
						if($counts==0)

						{

								for($i=0;$i<count($div1);$i++)

								{

									if($j==$i+1)

									{

										$divs=$divs." ".$div1[$i];

									}

									else

									{

										$divs=$divs." ".$div1[$i].",";

									}

								}

									  

								if(count($div1)>1)

								{

									$report=$divs." divisions are already present in  class".$class;

								}

								else

								{

									$report=$division[0] ." division is already present in  class ".$class;

										

								}

									

						}	

									

									else if($counts==1)

								    {

							            $report="You are successfully added ".$division[0]." division in class ".$class." ";

									}

									else

									{

										for($i=0;$i<count($div2);$i++)

										{

									   

											if($counts==$i+1)

											{

												$divs=$divs." ".$div2[$i];

										

											}

											else

											{

											

												$divs=$divs." ".$div2[$i].",";

											 

											

											}

										}

									   $report="You are successfully added ".$divs." divisions in class ".$class."";

									

									}

				}


			
			
?>







<html >

<head>



<title>Untitled Document</title>



<script>



function valid()

{ 

   

	var division=document.getElementById("division").value;



			

		if(division==null||division=="")

			{

			

				document.getElementById('error').innerHTML='Please Enter Division';

				

				return false;

			}

			

           var divisions = division.split(',');

		  

		   for(var j=0;j<divisions.length;j++)

		   {

		 

		   	regx=/^[0-9]*$/;

				//validation of division

				

			if(regx.test(divisions[j]))

				{

			

					document.getElementById('error').innerHTML='Please Enter valid Division';

					return false;

				}

		   }



	



}

</script>

</head>





<body bgcolor="#CCCCCC">

<div style="bgcolor:#CCCCCC">

<div>



</div>

<div class="container" style="padding:25px;">

        	

            

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">

                   

                    

                <div style="background-color:#F8F8F8 ;">

                    <div class="row">

                    <div class="col-md-4"  style="color:#700000 ;">

                         

               		</div>

					
					<div class="col-md-3 " align="center" style="color:#666 ;" >

                         	

                   		<h2>Add Division</h2>

               		</div>

                         

                    </div>

                  

                  

                   

                  

			<div class="row">

					<form method="post">

						<div class="col-md-3">

						</div>

				<div class="col-md-6 col-md-offest-2">

					<?php $i=0;?>

					<table class="table-bordered" >

                     

                    	

                 

               

					<?php

					$value=mysql_query("select id,class from tbl_school_class where school_id='$sc_id' ORDER BY class ");?>

                 

					<tr>

					

					<td align="center" >
					<select name="class_id" style="width:100px;" class="form-control"><?php while($result=mysql_fetch_array($value)){ ?><option value="<?php echo $result['id'];?>"><?php echo $result['class'];?></option><?php }?></select></td>
					
					
					
					
					
					<td align="left" style="padding:5px;width:200px;">
					<input type="text" class="form-control" id="division" name="division" placeholder=" Divisions separated by comma"/></td>
					
					
					</br></br>
					
					
					
					
					<td align="left" style="padding:5px;width:200px;"><input type="text" class="form-control" id="division" name="division" placeholder=" Batch ID"/></td>
					
					</br></br>
					
					
					
					<td align="left" style="padding:5px;width:200px;"><input type="text" class="form-control" id="division" name="division" placeholder=" Division ID"/></td>
					
					
					</tr>

                 

                   

                  

					</table>

				</div>

            </div>

                  

                  

					<div class="row" style="padding:15px;">

              

					<div class="col-md-3 col-md-offset-3 "  align="center">

                    <input type="submit" class="btn btn-primary" name="submit" value="Add" style="width:70px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                   

					</div>

					<script>

					         function backpage()

							 {

                                window.history.go(-1);

							 }

                    </script>

					
					<div class="col-md-3 "  align="left">

                            <?php $names="division"; ?>

					<a href="list_school_division.php?name=<?=$names?>" style="text-decoration:none;">
					<input type="button" class="btn btn-primary" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                </form>

                </div>

						
						
						<div class="row" style="padding:15px;" >

						<div class="col-md-4">

						</div>

						<div class="col-md-6" style="color:#FF0000;"  id="error">

                      

							<?php echo $report;?>

               			</div>

                 

						</div>

                      

                

                  

                 

                    

                    

                  

               </div>

               </div>

</body>

</html>

<?php

				 
					}					
					else

					{
		include('scadmin_header.php');
$report = "";
$smartcookie = new smartcookie();
$results = $smartcookie->retrive_individual($table, $fields);
$result = mysql_fetch_array($results);
$sc_id = $result['school_id'];

//Changes made by Rutuja Jori for making Add & Edit on same page & added validations for the same on 14/11/2109 for SMC-4191
if(($_GET["aut_id"])=='')
{
if (isset($_POST['submit'])) {
    $division = $_POST['division'];
	
    $division_id = $_POST['division_id'];
    $results = mysql_query("SELECT * FROM `Division` WHERE `school_id`='$sc_id' and ExtDivisionID='$division_id' ");
    if (mysql_num_rows($results) == 0) {
        $query = "insert into `Division` (DivisionName,school_id,ExtDivisionID) values('$division','$sc_id','$division_id') ";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		echo "<script LANGUAGE='JavaScript'>
					window.alert('Record inserted Successfully');
					window.location.href='list_school_division.php';
					</script>";
    } else {
        echo "<script LANGUAGE='JavaScript'>
					window.alert('".$designation." already present');
					window.location.href='add_school_division.php';
					</script>";
    }
}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">

function valid() {
	//alert('hi');
var division_id = document.getElementById("division_id").value;
        
		if(division_id.trim()=="" || division_id.trim()==null)
		{
			alert("Please enter <?php echo $designation;?> ID !");
		return false;
		}
       
		
		var division = document.getElementById("division").value;
        
		if(division.trim()=="" || division.trim()==null)
		{
			alert("Please enter <?php echo $designation;?> !");
		   return false;
		}
       
}
</script>
<html>
<head>

</head>
<body>
<div class="container" style="padding:25px;"
" >

<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

    <form method="post">

        <div class="row">

            <div class="col-md-3 col-md-offset-1" style="color:#700000 ;padding:5px;"></div>

            <div class="col-md-3 " align="center" style="color:#663399;">

                <h2>Add <?php  echo $designation; ?></h2>
                <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                <br><br>
            </div>


        </div>     

       <div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:50px"> <?php  echo $designation ;?> ID:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">

                <input type="text" name="division_id" class="form-control " id="division_id" placeholder="Enter <?php  echo $designation; ?> ID " style="margin-left:-35px">

            </div>
         </div>
            
				<div class="row" style="padding-top:30px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2" style="color:#808080;font-size:18px;margin-left:50px"> <?php  echo $designation; ?>:<span style="color:red;font-size: 25px;">*</span></div>
                                    <div class="col-md-3">
				
                <input type="text" name="division" class="form-control " id="division" placeholder="Enter <?php  echo $designation; ?>" style="margin-left: -35px;">

            </div>

            <br/><br/>

            <!--<div class="col-md-3 col-md-offset-4">

                <input type="text" name="Batch ID" class="form-control " id="0" placeholder="Batch ID">

            </div>-->

        </div>


        <div id="error" style="color:#F00;text-align: center;" align="center"></div>


        <div class="row" style="padding-top:15px;">


            <div class="col-md-2 col-md-offset-4 ">

                <input type="submit" class="btn btn-primary" name="submit" value="Add "
                       style="width:80px;font-weight:bold;font-size:14px;" id = "btnValid" onClick ="return valid()"/>

            </div>


            <div class="col-md-3 " align="left">

                <a href="list_school_division.php" style="text-decoration:none;"> <input type="button"
                                                                                             class="btn btn-primary"
                                                                                             name="Back" value="Back"
                                                                                             style="width:80px;font-weight:bold;font-size:14px;"/></a>

            </div>


        </div>


        <div class="row" style="padding-top:15px;">

            <div class="col-md-4">

                <input type="hidden" name="count" id="count" value="1">

            </div>

            <div class="col-md-11" style="color:#FF0000;" align="center" id="error">


                <?php echo $errorreport; ?>
            </div>

            <div class="col-md-11" style="color:#063;" align="center" id="error">

                <?php echo $successreport; ?>

            </div>

        </div>

    </form>

</div>


</body>
</html>

					
					
	
<?php
				   }else{
				$school_id=$_SESSION['school_id'];	 
			if(isset($_GET["aut_id"]) && isset($_GET["division"]))
	{
		$division_id= $_GET["aut_id"];
		$ExtDivisionID= $_GET["ExtDivisionID"];
		 $sql1="select * from Division where id=".$division_id;
		$row=mysql_query($sql1);
	    $arr=mysql_fetch_array($row);
		$division=$arr['division'];
	    $class_id=$arr['class_id'];
		$ExtDivisionID= $arr["ExtDivisionID"];
		$rows=mysql_query("select * from tbl_school_class where id='$class_id'");
	    $value=mysql_fetch_array($rows);
		$class=$value['class'];
	

 if(isset($_POST['submit']))
 {
   $division_new=$_POST['division'];
    $ExtDivisionID_new=$_POST['divisionid'];

	if($ExtDivisionID == $ExtDivisionID_new)
{
	

	$r = "update Division set DivisionName='$division_new',  ExtDivisionID='$ExtDivisionID_new' where id='$division_id' and school_id='$school_id'";
	

}
else
{
$sql1 = mysql_query("select * from Division where ExtDivisionID='$ExtDivisionID_new' and school_id='$school_id'");
echo $count=mysql_num_rows($sql1);


if ($count > 0) 
{
	
	
    echo "<script>alert('Record already present') </script>";
}

else
{
    $r = "update Division set DivisionName='$division_new',  ExtDivisionID='$ExtDivisionID_new' where id='$division_id' and school_id='$school_id'"; 
}
}
    
	if($r!='')
	{
        $a = mysql_query($r);
        if (mysql_affected_rows() > 0) {
            
            echo ("<script LANGUAGE='JavaScript'>
                        alert('Record Updated Successfully..!!');
                        window.location.href='list_school_division.php';
                        </script>");
        } else {
            echo "<script>alert('There is no change while updating record') </script>";
        }
	}
	

		
      
		}
	
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
<script>
	function valid()
	{
	  var division=document.getElementById("division").value;
	
	  if(division=="")
	  {
	   document.getElementById('error').innerHTML='Please Enter <?php  echo $designation ;?>';
	    return false;
	  }
	  	regx=/^[0-9]*$/;
				//validation of division
				
			if(regx.test(division))
				{
			
					document.getElementById('error').innerHTML='Please Enter valid <?php  echo $designation; ?>';
					return false;
				}
	
	}
</script>
</head>
<body  align="center">
<div class="container" style="padding:10px;" align="center">
<div class="row"  >
<div class="col-md-3">
</div>
<div class="col-md-6">
<div class="container" style="padding:25px;" >
        	
            
            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8 ;">
                   
                    
               
	
         <form method="post"  >
          <div class="row" style="color: #666;height:80px;font-family: 'Open Sans',sans-serif;font-size: 12px;">

                <h2>Edit <?php  echo $designation; ?></h2>

          </div>
           <div class="row " >
                 <!-- <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b>Class</b>
                  </div>-->
                  <div class="col-md-5 form-group" align="left">
                  <?php 
		$rows=mysql_query("select * from tbl_school_class where id='$class_id'");
	    $arrs=mysql_fetch_array($rows); echo $arrs['class'];?>
                            
                            
                  </div>
          </div>
		  
		   <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">
                 <b> <?php echo $designation;?> ID</b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" name="divisionid" id="divisionid" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter Division Id" value='<?php echo $ExtDivisionID; ?>'/>
                  </div>
          </div>
		  
          <div class="row " >
                  <div class="col-md-3 col-md-offset-2" align="left" style="color:#003399;font-size:16px">

                 <b> <?php  echo $designation ;?></b>
                  </div>
                  <div class="col-md-5 form-group">
                            
                                <input type="text" value="<?php echo $_GET["division"];?>" name="division" id="division" class="form-control" style="width:100%; padding:5px;" placeholder=":Enter <?php  echo $designation ;?>" value='<?php echo $division; ?>'/>

                  </div>
          </div>
          <div class="row " >
                  
                  <div class="col-md-8 form-group col-md-offset-2" id="error" style="color:red;">
                            
                               <?php echo $report;?>
                  </div>
          </div>
          
          <div class="row" >
          	<div class="col-md-3 col-md-offset-2" style="padding:10px;">
          			   <input type="submit" name="submit" class="form-control" style="width:100%;background-color:#0080C0; color:#FFFFFF;" value="Submit" onClick="return valid()"/>
             </div>
             <div class="col-md-3 col-md-offset-1" style="padding:10px;">
                <a href="list_school_division.php" style="text-decoration:none;"><input type="button" class="form-control" name="cancel" value="Cancel" style="width:100%;background-color:#0080C0; color:#FFFFFF;" ></a>
              </div>
          
          </div>
         </form>
          </div>
      </div>
    </div>
</div>

</div>
</div>

	
      
</body>
</html>

<?php }?>		   
				   
				   
				   
				   
				   


<?php
					}}

?>