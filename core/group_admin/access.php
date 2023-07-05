<?php 
include("groupadminheader.php");
//print_r($_SESSION);exit;
$entity_type = $_SESSION['usertype'];
           $id=$_SESSION['id'];


   
if(isset($_POST['submit'])) {
$permision = @implode(',', $_POST['permission']);       
    $currentdate = date('Y-m-d H:i:s');
    $stf_id = $_POST['staff'];
     if ($permision) 
     {
//------------------------------Fetch Data form tbl_school_adminstaff table----------
      //print_r($permision);exit;
        $sql1 = mysql_query("select id,stf_name from tbl_cookie_adminstaff where id='$stf_id'");
        $result = mysql_fetch_array($sql1);
        $staf_id = $result['id'];
        $staf_name = $result['stf_name'];

//------------------------------End--------------------------------------------------

//------------------------------Insert in permision in tbl_permission table----------
        $exists = mysql_query("SELECT s_a_st_id FROM tbl_permission WHERE s_a_st_id='$staf_id' AND (school_id='' OR isnull(school_id))");
        $cnt = mysql_num_rows($exists);
        if($cnt==0)
        {
         $sql = "INSERT INTO `tbl_permission` (`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL,'$staf_id','$staf_id',NULL,'$staf_name', '$permision', '$currentdate')";
          $rs = mysql_query($sql) or die(mysql_error());
          ?>
          <script>
              alert('Permission granted successfully to :<?php echo $staf_name; ?>');
          </script>
          <?php
        }
        else
        {
          $sql = "UPDATE `tbl_permission` SET permission='$permision',`current_date`='$currentdate' WHERE s_a_st_id='$staf_id' AND (school_id='' OR isnull(school_id))";

          $rs = mysql_query($sql) or die(mysql_error());
          ?>
          <script>
              alert('Permission grant updated successfully to :<?php echo $staf_name; ?>');
          </script>
       <?php }
            
  }else
    {
    ?>
            <script>
                alert('Permission not granted');
            </script>
            <?php
    }

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
  /*color: #777;  */
}

#edit_access{
  overflow-x: scroll;
}
</style>
</head>
<body>
 
<form action="" method="post" name="access">  
 <div class='panel-heading'>
        
            <h2 align="center"><b>Access to Staff</b></h2>  
        
          </div>
          <div class="container">
              <div class="row">
                <div class="col-lg-4" style="text-align:right;">
                    <label class='control-label col-md-offset-2' for='id_service' style="text-align:left;">Select Staff Member Name <span style="color: red;">*</span></label> 
                </div>
                <div class="col-lg-4" style="text-align:left;">
                    <select id="staff" name="staff"  class="form-control" onChange="already_access(this.value)" style="margin-top: -6px;">
                      <option value=''>---Select---</option>
                      <?php 
               
                       //and delete_flag=0 added in query by Pranali for SMC-5010
                       $fetch_staff_name=mysql_query("SELECT * FROM `tbl_cookie_adminstaff` where group_member_id='$id'");
                        while($row=mysql_fetch_array($fetch_staff_name))
                        {
                            ?>   
                                   <option value='<?=$row['id']?>'><?=ucwords($row['stf_name'])?></option>
                        
                    <?php
                       }
                                ?>
                    </select>
                </div>
                <div class="col-lg-4">
                  <button type="button" name="btn_staff" id="btn_staff" style="margin-top: -7px;margin-bottom: 13px;" value='Select Staff' onclick="return valid()" class="btn btn-success">Select Staff</button>
                </div>
              </div>
          </div>
          <!--<div class="row">
               <div class="col-lg-12">
                  <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Select Staff Member Name <span style="color: red;">*</span></label>         
               </div>   &emsp; 
               <div class='col-lg-4'>
            
              <select id="staff" name="staff"  class="form-control" style="margin-top: -6px;">
              <option value=''>---Select---</option>
              <?php 
			 
			         //and delete_flag=0 added in query by Pranali for SMC-5010
			         $fetch_staff_name=mysql_query("SELECT * FROM `tbl_cookie_adminstaff` where group_member_id='$id'");
								while($row=mysql_fetch_array($fetch_staff_name))
								{
		     	          ?>   
                           <option value='<?=$row['id']?>'><?=ucwords($row['stf_name'])?></option>
                
            <?php
               }
                        ?>
              </select>
              
            </div>
            <div class="col-lg-4">
              <button type="submit" name="btn_staff" id="btn_staff" value='Select Staff' class="btn btn-success">Select Staff</button>
            </div>
          </div>-->
        <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->


<div class='form-group' id="edit_access" style="display: none;">
          <input type="hidden" id="staff_id_sql" name="staff_id_sql" value="">                       
<?php 
$id=$_POST['get_option'];
$query=mysql_query("select permission from tbl_permission where s_a_st_id='$id' AND (school_id='' OR isnull(school_id))");
$result=mysql_fetch_array($query);
//print_r(count($result['permission']));exit;
if(count($result['permission'])>0)
{
  $all_permission=explode(',',$result['permission']);
}
else
{
  $all_permission=$result['permission'];
}


 $sql_menu_access = "SELECT * FROM tbl_menu WHERE entity_name='$entity_type'  AND menu_active='Y' AND parent_menu_id='0'";

    $menu_access=mysql_query($sql_menu_access); 
?>
    <div class='form-group'>
        
    <fieldset style="border:thick;"> 
    
    <div class='col-md-12' style="margin-left:-15px;">
             <div class="form-group internal" align="center" style="padding:10px;"> <td style="background-color:#B2B2B2;  border-radius:5px;"><input type="checkbox" onClick="toggle(this)">Select All</td></div>  
<!--Added below code for table driven menu access by Pranali for SMC-4485 on 5-3-20  --> 
    <table id="perm" class="table-striped table-bordered table" style="width:100%;border:1px solid #ddd;">
      <tr>
        <?php 
        while ($menu = mysql_fetch_assoc($menu_access)) { 
          $select="";
          foreach($all_permission as $key=>$val){
              if($val==$menu['menu_name'])
              {
                $select="checked";
                break;
              }
              continue;
          }
                ?>
          <td style="background-color:#B2B2B2;">
            <input type="checkbox" name="permission[]" id="parent_menu_val" value="<?php echo $menu['menu_key']; ?>" /><?php echo $menu['menu_name']; ?>
          </td>
        <?php
        } 
        ?>
      </tr>

      <tr>
        <?php
        $menu_access=mysql_query($sql_menu_access);
        //print_r(mysql_fetch_assoc($menu_access));exit;
        // $getpermision=mysql_query("select * from tbl_permission where s_a_st_id='".$staff_id."' AND school_id='".$school_id."'");
        // $fetchpermision=mysql_fetch_array($getpermision);
        // $child_perm=$fetchpermision['permission']; 
        while ($menu = mysql_fetch_assoc($menu_access)) { 
          $select="";
          foreach($all_permission as $key=>$val){
              if($val==$menu['menu_name'])
              {
                $select="checked";
                break;
              }
              continue;
          }


         ?>
          <td>
          <table>
          <?php $menu_id=$menu['id']; //print_r($menu_id);exit;
          $child_menu = mysql_query("SELECT * FROM tbl_menu WHERE entity_name='$entity_type' /*AND org_type_id='$school_type'*/ AND menu_active='Y' AND parent_menu_id='$menu_id'"); 
          if(mysql_num_rows($child_menu)==0){ ?>
            </table>
            </td>
            <?php
          } else { 
            //display child menu if it exists
            while($child_menu1 = mysql_fetch_assoc($child_menu)){ 
              $select="";
          foreach($all_permission as $key=>$val){
              if($val==$menu['menu_name'])
              {
                $select="checked";
                break;
              }
              continue;
          }
              ?>
              <tr>
                <?php
                // $child_key=$child_menu1['menu_key'];
                // $child_Mst=strpos($child_perm,$child_key);
                //     if($child_Mst !== false)
                //     {  $child_checked='checked';

                //   }else{
                //     $child_checked='';
                //   }
                  
                  ?>
                <td>
                  <ul style="list-style-type:none; margin-left: -35px;">
                    <li>
                      <input type="checkbox" name="permission[]" id="child_menu_val" value="<?php echo $child_menu1['menu_key']; ?>" /><?php echo $child_menu1['menu_name']; ?>
                    </li>
                  </ul>
                </td>
              </tr>
              <?php 
            }
            ?>
            </table>
            </td>
          <?php 
          } 
        }
        ?>
      </tr>
    </table>
    </div>
    </fieldset>
    <div class="col-md-2 col-md-offset-2">
        <input type="submit" class="btn btn-primary" name="submit" value="Submit" style="width:80px;font-weight:bold;font-size:14px;margin-left:275px;margin-top:-18px;" onclick="return valid()"/>
    </div>
    </div>
</div>
</form>
</body>

</html>
<SCRIPT language="javascript">

$(document).ready(function(){
  $("#btn_staff").click(function(){

  var staff = document.getElementById("staff").value;
  var parent_menu_val = document.getElementById("parent_menu_val").value;
  var child_menu_val = document.getElementById("child_menu_val").value;
 /* if(child_menu_val!="")
  {

    if(parent_menu_val == "")
    {
      alert("Please select parent menu !!");  
      return false;
    }
    else   { 
      return true;
    }
  }*/
  if(staff == "")
  {
    alert("Please select staff member name !!");
    return false;
  }
  else   { 
    $("#edit_access").toggle();
    document.getElementById("staff_id_sql").innerHTML = staff;
    return true;
  }
    
  });
});


    function already_access(val)
    {
     // onChange="already_access(this.value)"
     $.ajax({
     type: 'post',
     url: 'already_access.php',
     data: {
      get_option:val
     },
     success: function (response) {
      if(response != ""){
      $("#edit_access").html(response);
      $("#edit_access").toggle();
      //console.log(response);
    }else{
      $("#edit_access").toggle();
    }
     }
     });
    }



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
<script type="text/javascript">
  function toggle(source) {
  checkboxes = document.getElementsByName('permission[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

//valid() added by Pranali for validation message of staff name for SMC-5010
function valid() {
  var staff = document.getElementById("staff").value;
  var parent_menu_val = document.getElementById("parent_menu_val").value;
  var child_menu_val = document.getElementById("child_menu_val").value;
 /* if(child_menu_val!="")
  {

    if(parent_menu_val == "")
    {
      alert("Please select parent menu !!");  
      return false;
    }
    else   { 
      return true;
    }
  }*/
  if(staff == "")
  {
    alert("Please select staff member name !!");
    return false;
  }
  else   { 
    return true;
  }
}
</script>
