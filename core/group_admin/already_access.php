<?php

include("../conn.php");


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
//print_r($all_permission);exit;
?>

<?php 
 $sql_menu_access = "SELECT * FROM tbl_menu WHERE entity_name='Group Admin'  AND menu_active='Y' AND parent_menu_id='0'";

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
            <input type="checkbox" name="permission[]" id="parent_menu_val" <?php echo $select; ?> value="<?php echo $menu['menu_key']; ?>" /><?php echo $menu['menu_name']; ?>
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
          $child_menu = mysql_query("SELECT * FROM tbl_menu WHERE entity_name='Group Admin' /*AND org_type_id='$school_type'*/ AND menu_active='Y' AND parent_menu_id='$menu_id'"); 
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
                      <input type="checkbox" name="permission[]" id="child_menu_val" <?php echo $select;?> value="<?php echo $child_menu1['menu_key']; ?>" /><?php echo $child_menu1['menu_name']; ?>
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
        <input type="submit" class="btn btn-primary" name="submit" value="Submit " style="width:80px;font-weight:bold;font-size:14px;margin-left:275px;margin-top:-18px;" onclick="return valid()"/>
    </div>
    </div>
