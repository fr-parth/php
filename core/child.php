<?php
  error_reporting(0);
  include("Parent_header.php");
 $id=$_SESSION['id'];

?>
<style>
.fnt{
  font-size: 130px;

}
</style>
<script>
function confirmation(xxx) {
    var answer = confirm("Are you sure you want to delete?")
	
    if (answer){
        
        window.location = "deletechild.php?id="+xxx;
    }
    else{
       
    }
}
</script>
<?php

?>
  <div class="col-md-12" style="padding-top:10px;">
  <div class="row">
<?php
      //$result=mysql_query("select * from tbl_parent where Id='$parent_id'");
      //$rows1=mysql_fetch_array($result);
      //$student_prn=$rows1['std_PRN']; 
      //$id= $rows1['stud_id']; 
      //$school_id= $rows1['school_id']; 

      
        $stud=mysql_query("select * from tbl_student where parent_id='$id'"); //std_PRN='$student_prn' 
        //$result1=mysql_fetch_array($stud);
	    while($rows=mysql_fetch_array( $stud))
       {
		   
    ?>
    <!--onClick="confirmation(<?php // echo $rows['std_PRN'] ?> )"-->
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
      <h1 class="panel-title">
          <a  href="child_header.php?stud_id=<?php echo $rows['std_PRN']; ?>&sch_id=<?php echo $rows['school_id']; ?>" style="text-decoration:none;"><?php  echo $rows['std_complete_name']; ?></a>
          &nbsp;&nbsp;&nbsp;
          <a  href="deletechild.php?id=<?php echo $rows['std_PRN']; ?>&sch_id=<?php echo $rows['school_id']; ?>" ><span class="glyphicon glyphicon-trash"></span></a></h1>
      </div>
      <a  href="child_header.php?stud_id=<?php echo $rows['std_PRN']; ?>&sch_id=<?php echo $rows['school_id']; ?>" style="text-decoration:none;">
      <div class="panel-body">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-sm-4">
                <?php if($rows['std_img_path']!="" && file_exists($rows['std_img_path'])) {?> 
                              <img src="<?php  echo $rows['std_img_path'];?>"  class="img-responsive" alt=""/> 
                              <?php } else { ?>
                              <img src="image/avatar_2x.png"  class="img-responsive"  style="width:100%;"/> 
                              <?php } ?>
            </div>
            <div class="col-sm-8">
              <div class="row">PRN No : <?php  echo $rows['std_PRN']; ?></div>
              <div class="row">Institute : <?php echo $rows['std_school_name'];?></div>
              
            </div>
          </div>
        </div>
      </div>
    </a>
    </div>
  </div>
<?php } ?>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-sm-12" >  
        <a href="addchild.php" >        
          <div class="row" align="center"><span class="glyphicon glyphicon-plus fnt"></span></div>
        </a>  
        </div>
      </div>
    </div>
  </div>

  </div>
</div>      



<!-- ----------------------------------------------             ADD Multiple CHILD ------------------------                     -->		


