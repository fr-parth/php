<?php 
//Created by Rutuja Jori for fetching menu levels for SMC-5132 on 02-02-2021
include('conn.php');
  $menu_entity=$_POST['menu_entity'];
  $sqllevel = "SELECT distinct menu_level FROM tbl_menu where entity_type='".$menu_entity."'";
  $querylevel = mysql_query($sqllevel);
?> 
 <option value="">Select Menu Level</option>
<?PHP 
 while( $rows = mysql_fetch_assoc($querylevel))
  {  
?>		<option value="<?php echo $rows["menu_level"]; ?>"><?php echo $rows["menu_level"]; ?></option>  
<?php	
  }
   
?>