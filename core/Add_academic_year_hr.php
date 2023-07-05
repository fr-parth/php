<?php
include('hr_header.php');
$report="";
/*$id=$_SESSION['id'];
$fields=array("id"=>$id);
$table="tbl_school_admin";*/
$smartcookie=new smartcookie();
$results=$smartcookie->retrive_individual($table,$fields);
$result=mysql_fetch_array($results);
$sc_id=$result['school_id'];




if(isset($_POST['submit']))
{
    $a_year = $_POST['a_year'];
    $year = $_POST['year'];
	$enabled = $_POST['enabled'];
//echo"hello1";



//echo "SELECT * FROM  `tbl_academic_Year` WHERE `school_id`='$sc_id' and Academic_Year='$a_year' or Year = '$year' ";
   /* echo  $d_name." ".$d_post." ". $course; */
    $results=mysql_query("SELECT * FROM  `tbl_academic_Year` WHERE `school_id`='$sc_id' and (Academic_Year='$a_year' ) ");
	 //$rs = mysql_num_rows($results);
	
	
  if(mysql_num_rows($results)==0)
	  
    {
		
					if(Academic_Year > 0)
					{
					$query= "select * from tbl_academic_Year WHERE Academi
					c_Year='$a_year'";
					$query_run = mysql_query($query);
					
					if(mysql_num_rows($query_run)>0)
					{
						//if academic year is alredy present
						echo '<script type="text/javascript"> alert("Academic_Year already exists try another Academic_Year") </script>';
					}
					}
		//echo"hello 2";
       //echo"insert into `tbl_academic_Year`(Academic_Year,Year,school_id) values('$a_year','$year','$sc_id'";
	   
	   //$enabled added in insert query by Pranali for bug SMC-3554
	    $query="insert into `tbl_academic_Year` (Academic_Year,Year,school_id,Enable) values('".$a_year."','".$year."','".$sc_id."','".$enabled."') ";
        $rs = mysql_query($query);
        //$successreport = "Record inserted Successfully";
		if($rs){
		echo "<script type='text/javaScript'>
				alert('Record inserted Successfully');
               window.location.href='list_school_academic_year.php';
					</script>";
		}
		}
	
    else
    {
        $errorreport = 'Academic_Year already exists try another Academic_Year';
    }


}
?>
<script  src="http://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
			<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
			<script type="text/javascript">
function valid() {
	
		var a_year = document.getElementById("a_year").value;
        var pattern = /^[0-9- ]+$/;
        if (pattern.test(a_year)) {
            //alert("Your your Academic Year is : " + a_year);
           // return true;
        }
		else{
        alert("It is not valid Academic Year!");
		return false;
		}
		var year = document.getElementById("year").value;
        var pattern = /^[0-9]+$/;
        if (pattern.test(year)) {
            //alert("Your your Academic Year is : " + year);
           // return true;
        }
		else{
        alert("It is not valid  Year!");
		return false;
		}
		//validations for enabled year added by Pranali for bug SMC-3554
		var enabled = document.getElementById("enabled");
		if(enabled.value == '-1'){
			alert("Please Select if year is Enabled or not!");
			return false;	
		}
}
	</script>
<html>
    <head>

    </head>
    <body>
        <div class="container" style="padding:25px;" >

            	<div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;background-color:#F8F8F8;">

                   <form method="post">

                   <div class="row">

                    <div class="col-md-3 col-md-offset-1"  style="color:#700000 ;padding:5px;" ></div>

              			 <div class="col-md-3 " align="center" style="color:#663399;" >

                   				<h2>Add Academic Year</h2>

                               <!-- <h5 align="center"><a href="Add_SubjectSheet_updated_20160109PT.php" >Add Excel Sheet</a></h5>  -->
                                 <br><br>
               			 </div>

                     </div>


          <!--     <div class="row formgroup" style="padding:5px;" >

                   <div class="col-md-3 col-md-offset-4">
-->						
						<div class="row">
					<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;">Academic Year:<span style="color:red;font-size: 2px;">*</span></div>
					<div class="col-md-3">
                        <input type="text" name="a_year" class="form-control " id="a_year" placeholder="Academic Year" maxlength="4" required>

                   </div>

                   

              <!--      <div class="col-md-3 col-md-offset-4">  -->
						<div class="row">
					<div class="col-md-4"><input type="hidden" name="id" value="<?php echo $_GET['id']?>" /></div>
					<div class="col-md-2" style="color:#808080; font-size:18px;"> Current Year:<span style="color:red;font-size: 25px;">*</span></div>
					<div class="col-md-3">
                        <input type="text" name="year" class="form-control " id="year" placeholder="Current Year" maxlength="4" required>

                   </div></div>
				   <!--Enabled Year added by Pranali for bug SMC-3554 -->
				   <div class="row">
				   <div class="col-md-2" style="color:#808080; font-size:18px;margin-left:390px;"> Enabled :<span style="color:red;font-size: 25px;">*</span></div>
						<div class="col-md-3">
						
							<select name="enabled" id="enabled" class="form-control" style="width:150px;">			  
							<option value="-1">Choose</option>
							<option value="1" >Yes </option>
							<option value="0" >No </option>
							</select>
						</div>
                    <br/><br/>
             <!--changes end for bug SMC-3554  -->
                   <div class="col-md-3 col-md-offset-4">

                   </div>

                    <!--<br/><br/>
-->


                 </div>


                  <div id="error" style="color:#F00;text-align: center;" align="center"></div>

                   <div class="row" style="padding-top:15px;">

                  <div class="col-md-2 col-md-offset-4 " >

                    <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>

                    </div>

                     <div class="col-md-3 "  align="left">

                   <a href="list_company_academic_year.php" style="text-decoration:none;"> <input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>

                    </div>

                   </div>

                     <div class="row" style="padding-top:15px;">

                     <div class="col-md-4">

                     <input type="hidden" name="count" id="count" value="1">

                     </div>

                      <div class="col-md-11" style="color:#FF0000;" align="center" id="error">



                      <?php echo $errorreport;?>

               			</div>
                         <div class="col-md-11" style="color:#063;" align="center" id="error">



                      <?php echo $successreport;?>

               			</div>



                    </div>




                  </form>

          </div>
          </div>

    </body>
</html>