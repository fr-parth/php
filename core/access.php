<?php 
include("scadmin_header.php");

$entity_type = $_SESSION['usertype'];
           $id=$_SESSION['id'];
           $fields=array("id"=>$id);
       $table="tbl_school_admin";
           $smartcookie=new smartcookie();
       $results=$smartcookie->retrive_individual($table,$fields);
           $result=mysql_fetch_array($results);

// Taken school id from session, taken school type from query and added $entity variable for menu access by Pranali for SMC-5010
           $school_id=$_SESSION['school_id'];
$sch_sql = mysql_query("SELECT school_type FROM tbl_school_admin WHERE school_id='".$school_id."'");
$sch_res = mysql_fetch_array($sch_sql);
$school_type =strtolower($sch_res['school_type']);

$entity = (strtolower($sch_res['school_type'])=='school') ? 'School Admin' : 'HR Admin';

if(isset($_POST['submit'])) {
    $permision = @implode(',', $_POST['permission']);
    $currentdate = date('Y-m-d H:i:s');
    $stf_id = $_POST['staff'];

    if ($permision) {
//------------------------------Fetch Data form tbl_school_adminstaff table----------

        $sql1 = mysql_query("select id,stf_name,school_id from tbl_school_adminstaff where id='$stf_id'");
        $result = mysql_fetch_array($sql1);
        $staf_id = $result['id'];
        $school_id = $result['school_id'];
        $staf_name = $result['stf_name'];

//------------------------------End--------------------------------------------------

//------------------------------Insert in permision in tbl_permission table----------
        $exists = mysql_query("SELECT s_a_st_id FROM tbl_permission WHERE s_a_st_id='$staf_id'");
        $cnt = mysql_num_rows($exists);

        if($cnt==0){
          $sql = "INSERT INTO `tbl_permission` (`permission_id`,`school_id`, `s_a_st_id`, `cookie_admin_staff_id`,`school_staff_name`, `cookie_staff_name`, `permission`, `current_date`) VALUES (NULL,'$school_id','$staf_id',NULL,'$staf_name',NULL, '$permision', '$currentdate')";
          $rs = mysql_query($sql) or die(mysql_error());
          ?>
          <script>
              alert('Permission granted successfully to :<?php echo $staf_name; ?>');
          </script>
          <?php
        }
        else{
          echo "<script>
            alert('Permission already granted!!');
           </script>";
        }
        
//------------------------------End--------------------------------------------------
    }
  else
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
<form action="" method="post" name="access">  
 <div class='panel-heading'>
        
            <h3 align="center">Access to Staff</h3>
        
          </div>
          <div class="row">
               <div class="col-md-12">
         <label class='control-label col-md-2 col-md-offset-2' for='id_service' style="text-align:left;">Select Staff Member Name <span style="color: red;">*</span></label>         </div>   &emsp; 
               <div class='col-md-4'>
            
              <select id="staff" name="staff" class="form-control" style="margin-top: -6px;">
              <option value=''>---Select---</option>
              <?php 

       
        //and delete_flag=0 added in query by Pranali for SMC-5010
       $fetch_staff_name=mysql_query("SELECT * FROM `tbl_school_adminstaff` where school_id='$school_id' and delete_flag=0");
                          
                while($row=mysql_fetch_array($fetch_staff_name))
                {
                    ?>   

                           <option value='<?=$row['id']?>'><?=ucwords($row['stf_name'])?></option>
                
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


<div class='form-group' id="edit_access">
                                 
<?php 
   $sql_menu_access = "SELECT * FROM tbl_menu WHERE entity_name='$entity' AND org_type_id='$school_type' AND menu_active='Y' AND parent_menu_id='0'";

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
            
                ?>
          <td style="background-color:#B2B2B2;">
            <input type="checkbox" name="permission[]" value="<?php echo $menu['menu_key']; ?>" /><?php echo $menu['menu_name']; ?>
          </td>
        <?php
        }
        ?>
      </tr>

      <tr>
        <?php
        $menu_access=mysql_query($sql_menu_access);

        // $getpermision=mysql_query("select * from tbl_permission where s_a_st_id='".$staff_id."' AND school_id='".$school_id."'");
        // $fetchpermision=mysql_fetch_array($getpermision);
        // $child_perm=$fetchpermision['permission'];

        while ($menu = mysql_fetch_assoc($menu_access)) { ?>
          <td>
          <table>
          <?php
          $child_menu = mysql_query("SELECT * FROM tbl_menu WHERE entity_name='$entity' AND org_type_id='$school_type' AND menu_active='Y' AND parent_menu_id='".$menu['id']."'");
            
          if(mysql_num_rows($child_menu)==0){ ?>
            </table>
            </td>
            <?php
          } else {
            //display child menu if it exists
            while($child_menu1 = mysql_fetch_assoc($child_menu)){ 
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
                      <input type="checkbox" name="permission[]" value="<?php echo $child_menu1['menu_key']; ?>" /><?php echo $child_menu1['menu_name']; ?>
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
        <input type="submit" class="btn btn-primary" name="submit" value="Add " style="width:80px;font-weight:bold;font-size:14px;margin-left:275px;margin-top:-18px;" onclick="return valid()"/>
    </div>
    </div>
</div>
</form>
</body>

</html>
