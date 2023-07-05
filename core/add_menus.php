<?php
//Created by Rutuja Jori for adding/updating menu for SMC-5132 on 02-02-2021
$report="";
  include_once('cookieadminheader.php');
  $id = $_GET['id'];
$sql1="select * from tbl_menu where id=".$id;
$query=mysql_query($sql1);
$res=mysql_fetch_array($query);
$isenabled = $res['menu_active'];
$entity_name = $res['entity_name'];
$entity_type = $res['entity_type'];
$menu_level = $res['menu_level'];
$menu_name = $res['menu_name'];
$menu_url = $res['menu_url'];

if(isset($_POST['submit']))
{ 
  $menu_level=trim($_POST['menu_level']);
  $new_menu_level=trim($_POST['new_menu_level']);
  $menu_entity=trim($_POST['menu_entity']);
  $menu_name=trim($_POST['menu_name']);
  $menu_url=trim($_POST['menu_url']);
  $isenabled=trim($_POST['isenabled']);
  $sql2 = mysql_query("select id from tbl_menu where entity_type='$menu_entity' and menu_name='$menu_name'");   
  $fetch2 = mysql_fetch_array($sql2);
  $count = mysql_num_rows($sql2);

  if($menu_level!='' || $new_menu_level!='')
  {
  if($menu_level!='' && $menu_url=='')
  {
  echo '<script type="text/javascript">'; 
  echo 'alert("Please enter URL for the Menu...");'; 
  echo 'window.location.href = "add_menus.php";';
  echo '</script>';exit;
  } 
  else if($menu_level!='' && $menu_url!=''){
  $menu_url = $menu_url;//echo "hi";exit; 
  }

  if($menu_level!=''){
  $sql = mysql_query("select id from tbl_menu where entity_type='$menu_entity' and menu_name='$menu_level'");   
  $fetch = mysql_fetch_array($sql); 
  $parent_menu_id = $fetch['id'];
  $level = $menu_level;
  }else{
  $level = $new_menu_level;
  $menu_url='';}//echo $menu_url;exit;
  if($menu_entity=='102'){$name_entity= "School Admin";$org_type_id= "school";}else if($menu_entity =='202'){$name_entity= "HR Admin";$org_type_id="organization";}else if($menu_entity =='118'){$name_entity= "Group Admin";}else if($menu_entity =='113'){$name_entity= "Cookie Admin";}    

    if($id!=''){
    if($count==1 && $menu_name==$res['menu_name'])
  { 
    $update = mysql_query("UPDATE tbl_menu SET org_type_id='$org_type_id', entity_type='$menu_entity', entity_name='$name_entity', menu_key='$menu_name',menu_level='$level', menu_name='$menu_name',menu_url='$menu_url', menu_active='$isenabled',parent_menu_id='$parent_menu_id'  WHERE id='$id'");
    if($update){
      $msg="Record updated successfully";
    }else{
      $msg="Record not updated";
    }
  }
  else{
  echo '<script type="text/javascript">'; 
  echo 'alert("This Menu already exists...");'; 
  echo 'window.location.href = "add_menus.php";';
  echo '</script>';exit;
}
    $href  = "list_menu.php"; 
  }
  else{
//echo "hi";exit;
    if($count<1)
  {
    $insert = mysql_query("INSERT INTO tbl_menu SET org_type_id='$org_type_id', entity_type='$menu_entity', entity_name='$name_entity', menu_key='$menu_name',menu_level='$level', menu_name='$menu_name',menu_url='$menu_url', menu_active='$isenabled',parent_menu_id='$parent_menu_id'");
    if($insert){
      $msg="Record inserted successfully";
    }else{
      $msg="Record not inserted! Please try again.";
    }   
    $href  = "list_menu.php";
  }
  else{
  echo '<script type="text/javascript">'; 
  echo 'alert("This Menu already exists...");'; 
  echo 'window.location.href = "add_menus.php";';
  echo '</script>';exit;
}
}

}
else{
  $msg = "Select Menu Level from drop down menu or enter new menu level!!!";
  $href  = "add_menus.php";
  }

  echo '<script type="text/javascript">'; 
  echo 'alert("'.$msg.'");'; 
  echo 'window.location.href = "'.$href.'";';
  echo '</script>';


}

?>


<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  <script>
 $(document).ready(function() 
 {  
   $("#menu_entity").on('change',function(){   
     var menu_entity = document.getElementById("menu_entity").value;

     $.ajax({
       type:"POST",
       data:{menu_entity:menu_entity}, 
       url:'fetchmenulevel.php',
       success:function(data)
       {
           //alert(data);
         
         $('#menu_level').html(data);
        
       }
       
       
     });
     
   });
     
 });

 function menu_level_change()
{
    document.getElementById("new_menu_level").value = '';
    //display_top10_students_subject_wise() ;
}

function new_menu()
{
    $('#menu_level').get(0).selectedIndex = 0;
    //display_top10_students_activity_wise();
}
</script>

<script>
 $(document).ready(function() {
  $('.smartsearch').select2();
});

</script>
</head>
<body bgcolor="#CCCCCC">
<div style="bgcolor:#CCCCCC">
<div>

</div>
<div class="container" style="padding:25px;" >
            <div style="padding:2px 2px 2px 2px;border:1px solid #CCCCCC; border:1px solid #CCCCCC;box-shadow: 0px 1px 3px 1px #C3C3C4;">
                   <form method="post">

                    <div style="background-color:#F8F8F8 ;">
                    <div class="row">
                   
                     <div class="col-md-12 " align="center" style="color:#663399;" >

                          <h2>Add New Menu</h2>
                     </div>

                     </div>
                     <br>
                   <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Entity</h4></b>
                    </div>
          
               <div class="col-md-3 ">
             <select name="menu_entity" id="menu_entity" style=" height:30px; border-radius:2px;width:250px" required >
             
    <option value="" disabled selected>Select Entity</option>
        
   <option value="102" <?php echo (isset($entity_type) && $entity_type == '102') ? 'selected="selected"' : ''; ?>>School Admin</option>
  
   <option value="202" <?php echo (isset($entity_type) && $entity_type == '202') ? 'selected="selected"' : ''; ?>>HR Admin</option>
   
    <option value="118" <?php echo (isset($entity_type) && $entity_type == '118') ? 'selected="selected"' : ''; ?>>Group Admin</option>

    <!--<option value="113" <?php echo (isset($entity_type) && $entity_type == '113') ? 'selected="selected"' : ''; ?>>Cookie Admin</option>-->
    
  

  </select>
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>

                  </div>

                  <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Menu Level</h4></b>
                    </div>
          
               <div class="col-md-3 ">
             <select  name="menu_level" id="menu_level" style=" height:30px; border-radius:2px;width:250px" onChange="menu_level_change()">
              <?php if($id!=''){?>
    <option value="<?php echo $menu_level;?>" selected><?php echo $menu_level;?></option>
   <?php $sqllevel = "SELECT distinct menu_level FROM tbl_menu where entity_type='".$entity_type."'";
    $querylevel = mysql_query($sqllevel);
  ?> 
  <?PHP 
  while($rows = mysql_fetch_assoc($querylevel))
  {  if($menu_level!=$rows['menu_level']){
?>    <option value="<?php echo $rows["menu_level"]; ?>"><?php echo $rows["menu_level"]; ?></option>  
<?php 
  }
 }
?>
              <?php }else{ ?>
    <option value="" disabled selected>First Select Entity</option>
<?php }?>
                    </select>
             </div>
             <?php if(!isset($id)){ ?>
             <div class="col-md-3">
                    <b><h4>Enter New Menu Level</h4></b>
                    </div>
          
               <div class="col-md-3 " style="margin-left: -100px">
             <input type="text" name="new_menu_level" id="new_menu_level" class="form-control " placeholder="Enter New Menu Level" onChange="new_menu()">
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>
           <?php } ?>
                  </div>

                  <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Menu Name</h4></b>
                    </div>
          
               <div class="col-md-3 ">
             <input type="text" name="menu_name" id="menu_name" class="form-control " placeholder="eg. Add Menu" required value="<?php echo $menu_name;?> ">
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>

                  </div>

                  <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Menu URL</h4></b>
                    </div>
          
               <div class="col-md-3 ">
             <input type="text" name="menu_url" id="menu_url" class="form-control " placeholder="eg. add_menus.php" value="<?php echo $menu_url;?> ">
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>

                  </div>

                  <div class="row " style="padding:5px;" >
                    <div class="col-md-2" >
                    </div>
                    <div class="col-md-2" align="left">
                    <b><h4>Is Enabled</h4></b>
                    </div>
          
               <div class="col-md-3 ">
             <select name="isenabled" id="isenabled" style=" height:30px; border-radius:2px;width:250px">
   
  <?php if(isset($_GET['id'])){ 
                    if($isenabled=='Y'){
                    ?>
                    <option value="<?php echo $isenabled;?>"><?php echo "Yes";?></option> 
                    <option value="N">No</option>
                  <?php }else{ ?>
                    <option value="<?php echo $isenabled;?>"><?php echo "No";?></option>
                    <option value="Y">Yes</option>
                <?php  } }else{ ?>

                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    <?php } ?>

  </select>
             </div>
               <div class="col-md-3" id="E-0" style="color:#FF0000;">

               </div>

                  </div>

                <div id="add">
                </div>

                   <div class="row" style="padding-top:15px;">
                   <div class="col-md-2">
               </div>
                  <div class="col-md-2 col-md-offset-2 "  >
                    <input type="submit" class="btn btn-success" name="submit" value="<?php if($id!=''){echo "Update";}else{echo "Add";}?> " style="width:80px;font-weight:bold;font-size:14px;" onClick="return valid()"/>
                    </div>
                     <div class="col-md-3 "  align="left">
                    <a href="list_menu.php" style="text-decoration:none;"><input type="button" class="btn btn-danger" name="Back" value="Back" style="width:80px;font-weight:bold;font-size:14px;" /></a>
                    </div>

                   </div>

                     <div class="row" style="padding:15px;">
                     <div class="col-md-4">
                     <input type="hidden" name="count" id="count" value="1">
                     </div>
                      <div class="col-md-3" style="color:#FF0000;" align="center" id="error">

                      <?php echo $report;?>
                    </div>
                    <div class="col-md-11" style="color:green;" align="center" id="success">

                    <?php echo $report_success;?>
                    </div>
                    </div>
                       </div>
                </form>
               </div>
               </div>
</body>
</html>
 