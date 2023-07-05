<?php 
include("hr_header.php");

           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
		   $table="tbl_school_admin";
           $smartcookie=new smartcookie();
		   $results=$smartcookie->retrive_individual($table,$fields);
           $result=mysql_fetch_array($results);
           $school_id=$result['school_id'];


if(isset($_POST['submit']))
{
         $permision=@implode(',',$_POST['permission']);
         $currentdate = date('Y-m-d H:i:s');
         $stf_id=$_POST['staff'];
//------------------------------Fetch Data form tbl_school_adminstaff table----------
	 
	$sql1=mysql_query("select id,stf_name,school_id from tbl_school_adminstaff where id='$stf_id'");
	$result=mysql_fetch_array($sql1);
	  $staf_id=$result['id'];
	$school_id=$result['school_id'];
	$staf_name=$result['stf_name'];
	
	
//------------------------------End--------------------------------------------------

       

//------------------------------Insert in permision in tbl_permission table----------
     $sql="INSERT INTO `tbl_permission` (`permission_id`,`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL,'$school_id','$staf_id',NULL,'$staf_name',NULL, '$permision', '$currentdate')";
	 $rs=mysql_query($sql) or die(mysql_error());
	 
	 ?>
     <script>
             alert('Permission granted successfully to :<?php echo $staf_name; ?>');
     </script>
     <?php
//------------------------------End--------------------------------------------------
}
?>

<html>
<head>
<style>
  body {
   background-color:#F8F8F8;
   }
  .indent-small {
  margin-left: 5px;
}
.form-group.internal {
  margin-bottom: 0;
}

.dialog-panel {
  margin: 10px;
}


.panel-body {  
  


  font: 600 15px "Open Sans",Arial,sans-serif;
}

label.control-label {
  font-weight: 600;
  color: #777;  
}
</style>
</head>
<body>
 <script language="JavaScript">
  function toggle(source) {
  checkboxes = document.getElementsByName('permission[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>
<form action="" method="post" name="access">  
 <div class='panel-heading'>
        
            <h3 align="center">Acess to Staff</h3>
        
          </div>
          <div class="row">
               <div class="col-md-12">
         <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Select Staff Member Name</label>         </div>    
               <div class='col-md-12'>
            
              <select id="staff" name="staff">
              <option value=''>---Select---</option>
              <?php 
			 
			  
			 $fetch_staff_name=mysql_query("SELECT * FROM `tbl_school_adminstaff` where school_id='$school_id'");
			                    
								while($row=mysql_fetch_array($fetch_staff_name))
								{
		     	          ?>         
                           <option value='<?=$row['id']?>'><?=$row['stf_name']?></option>
                
						<?php
						   }
	                      ?>
                         
                              </select>
            </div>
          
          </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#master").click(function () {
            $('.name').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".name").click(function () {
 
           if($(".name:checked").length!=0) {
                  $("#master").attr("checked", "checked");
            }
			else
			{
			 $("#master").removeAttr("checked");
			}

        });
    });
</SCRIPT>

<!-----------------------------POINT----------------------------------------->
<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#point").click(function () {
            $('.subpoint').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpoint").click(function () {
 
           if($(".subpoint:checked").length!=0) {
                  $("#point").attr("checked", "checked");
            }
			else
			{
			 $("#point").removeAttr("checked");
			}

        });
    });
</SCRIPT>
<!--------------------------------LOG-------------------------------------------->

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#log").click(function () {
            $('.sublog').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".sublog").click(function () {
 
           if($(".sublog:checked").length!=0) {
                  $("#log").attr("checked", "checked");
            }
			else
			{
			 $("#log").removeAttr("checked");
			}

        });
    });
</SCRIPT>

<!-------------------------------------purches coupone------------>

<SCRIPT language="javascript">
    $(function () {
        // add multiple select / deselect functionality
        $("#purchesC").click(function () {
            $('.subpurches').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".subpurches").click(function () {
 
           if($(".subpurches:checked").length!=0) {
                  $("#purchesC").attr("checked", "checked");
            }
			else
			{
			 $("#purchesC").removeAttr("checked");
			}

        });
    });
</SCRIPT>


<div class='form-group'>
                                 
         
             <div class='form-group'>
       
        <div class='col-md-12'>
             <div class="form-group internal" align="center" style="padding:10px;"> <td style="background-color:#B2B2B2;"><input type="checkbox" onClick="toggle(this)">Select All</td></div>
            <fieldset style="border:thick;">
    <legend></legend>
    <table class="table-striped" style="width:100%;">
 <tr>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" hidden="" name="permission[]" value="Leader Board"></td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="master" value="Master"> Master&nbsp;</td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="point" value="Points"> Points&nbsp;</td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="log" value="Logs"> Logs&nbsp;</td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" value="Sponsor Map"> Sponsor Map&nbsp;</td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" id="purchesC" value="Purches Coupon"> Purches Coupon&nbsp;</td>
  <td style=" background-color:#B2B2B2;"><input type="checkbox" hidden="" name="permission[]" value="Profile"> &nbsp;</td>
 <!-- <td style=" background-color:#B2B2B2;"><input type="checkbox" name="permission[]" value="Star Board"> Star Board&nbsp;</td> --->
                      
      </tr>
          <tr>
              <td><ul style="list-style-type:none; border-left:dotted; margin-left: -41px;"></ul>
           </td>
           
               <td>
                 <ul style="list-style-type:none; margin-left: -20px;">
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Teacher"> Manager&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Student"> Employee&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="School Master"> Company Master&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Activity"> Activity&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Subject"> Project&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Degrees"> Degignation&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Departments"> Departments&nbsp;</li>
 
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Division"> Project Domain&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="ThanQ"> ThanQ&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Who Assign Blue Point?"> Who Assign Blue Point?&nbsp;</li>
  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Get Teachers Password File"> Get Manager Password File&nbsp;</li>

  <li><input type="checkbox" class="name" name="permission[]" id="td" value="Upload Panel"> Upload Panel&nbsp;</li>
                   </ul>
    
    </td>
                   
              <td style="vertical-align:top; ">
                  <ul style="list-style-type:none; vertical-align:top; margin-left:-20px;">
       <li><input type="checkbox" class="subpoint" name="permission[]" value="Geen Points">Green Points to MAnager for distribution&nbsp;</li>
       <li><input type="checkbox" class="subpoint" name="permission[]" value="Blue Points To Teacher">Blue Point rewards to manager&nbsp;</li>
       <li><input type="checkbox" class="subpoint" name="permission[]" value="Blue Points To Student">Blue Points to Employee for distribution&nbsp;</li>
                   </ul>
                </td>
                   
                   <td style="vertical-align:top; ">
                      <ul style="list-style-type:none; margin-left: -20px;">
     <li><input type="checkbox" class="sublog" name="permission[]" value="Teacher Geen Points">Manager log of Green Points distributed&nbsp;</li>
     <li><input type="checkbox" class="sublog" name="permission[]" value="Student Geen Points"> Employee log of Green Points received&nbsp;</li>
     <li><input type="checkbox" class="sublog" name="permission[]" value="Sponsor"> Sponsers log of points and products&nbsp;</li>
     <li><input type="checkbox" class="sublog" name="permission[]" value="Teacher Blue Point">Manager log of Blue Points Received&nbsp;</li>
                      </ul>
                    </td>
                    
                    <td>  
                       <ul style="list-style-type:none;   margin-left: -41px;"> </ul>
                    </td>
                    
              <td style="vertical-align:top;">
                     <ul style="list-style-type:none; margin-left: -20px;">
         <li><input type="checkbox" class="subpurches" name="permission[]" value="Geen Points coupones">Geen Points coupones&nbsp;</li>
         <li><input type="checkbox" class="subpurches" name="permission[]" value="Blue Points coupones">Blue Points coupones&nbsp;</li>
                     </ul>
                   </td>
             </tr>
         </table>              
  </fieldset>
</div>
  </div>
           <div class='form-group row'>
           <div class='col-md-2 col-md-offset-4' >
          <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div>
      <div class='col-md-1'>
           <input type="reset" class='btn-lg btn-danger' value="Cancel" style="padding:5px;" />
                 </div>
</div>
</form>
</body>

</html>
