<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<script>
	
        $(document).ready(function() {
            $('#example').dataTable( {
		
				
         });
			
  
        } );
		
		
        </script>
</head>

<title><?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> List</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Points Request to Other <?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?></div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Requests</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?></li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
			<?php echo form_open("main/show_studlistfor_request","class=form-horizontal");?>
			<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-2" width="100%" style="margin-top: 10%;">
					   <input type="text" id="name" name="name"  placeholder= "<?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> Complete Name">
					</div>
					<div class="col-md-2" width="100%" style="margin-top: 10%;">
					<input type="text" id="prn" name="prn"  placeholder= "<?php echo ($this->session->userdata('usertype')=='employee')?'Employee ID':'Student PRN'; ?>">
					</div>
					 <div class="col-md-2" width="100%" style="margin-top: 10%;">
					<input type="text" id="phone" name="phone"  placeholder= "<?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> Phone No">
					</div>
					
					<div class="col-md-2" width="100%" style="margin-top: 10%;">
					<input type="text" id="email" name="email"  placeholder= "<?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> Email">
				</div>
					 
					 
				
						<?php /*  


						<!---<div class="col-md-4" width="100%" style="margin-top: 10%;">
						<input type="text" id="name" name="name"  placeholder= "Student Name">
						</div>
						<div class="col-md-4" width="100%" style="margin-top: 10%;">
						
						<input type="text" id="prn" name="prn"  placeholder= "Student PRN">----->*/?>
    <?php
	if(isset($_POST['submit']))
	{
		$stdname = trim($_POST['name']);
		$studentPRN = trim($_POST['prn']);
		$studemail= trim($_POST['email']);
		$studphone= trim($_POST['phone']);
		//$studaddress= trim($_POST['addr']);
	
	}
	
	/* <option value="1" <?php 
	 
	 if(isset($_POST['select_opt']))
	 {
		 if($_POST['select_opt']=="1")
		 {  ?> selected 
	<?php } 
		 
	 }
	 ?>


	 ><?php echo "Current" ?></option>
	 <option value="2"   <?php 
	 
	 if(isset($_POST['select_opt']))
	 {
		 if($_POST['select_opt']=="2")
		 { ?> selected 
	<?php } 
		 
	 }
	  ?>


	  > <?php echo "All" ?></option>
	  
	 
	  
	  */?>
      <?php echo form_error('submit', '<div class="error">', '</div>'); ?>
						
						<!--</div>-->
						
							
								
						<div class="col-md-3" width="100%" style="margin-top: 10%;" >
						  <?php 
						 
							 echo form_submit('submit', 'Go','class="btn btn-green"'); 
						     //echo form_submit('submit', 'Add Subject','class="btn btn-green"');
								//echo form_submit('button', 'Add Subject','class="btn btn-green"');
						  
							?>
						</div>
					
					 </div>
					</div>
					</div>
						<?php



echo form_close();

	?>
						
						
						
				   
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="generalTabContent" class="tab-content responsive" style="margin-top:4%;">
                            <div id="teacher" class="tab-pane fade in active">
                        
                                <div class="row">
                                
                                  <div id="no-more-tables">
                                    <table class="table table-bordered table-hover " id="example" style="margin-left: 0px !important;">
                                        <thead class="cf">
                                        <tr>
                                          <th>Sr.No.</th>
											<th>Image</th>
                <th><?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> ID</th>
                <th><?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> Name </th>
                <th>Assign</th>
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
											<?php 
											$PRN = $this->session->userdata('std_PRN');
                                            $i=1;
											if($studentsearchlist!="")
											{
                                            foreach($studentsearchlist as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No."><?php echo $i;?></td>
                                            <td data-title=""><?php if ($t->std_img_path==""){ ?> <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:50px;width:50px;"/><?php  } else {?><img src="<?php echo base_url()?>/core/<?php echo $t->std_img_path?>"  alt="" class="img-circle" style="height:50px;width:50px;"/> <?php };?></td>
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> ID" > <?php echo $t->std_PRN;?></td>
                                            <td data-title="Name" ><?php  if($t->std_complete_name!=''){echo ucwords(strtolower( $t->std_complete_name));}else { echo ucwords(strtolower( $t->std_name." ".$t->std_Father_name." ".$t->std_lastname	));}?></td>
                                            <td><?php if ($t->std_PRN == $PRN){ ?>
													Can't send request to this user.
												<?php }else{?> 
													<a href="send_reuest_to_student/<?php echo $t->std_PRN?>"><button type="button" class="btn btn-success">Request</button></a>
												<?php } ?>
											</td>   
                                        </tr>
											<?php $i++;}}?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                
                                </div>
                                </div>
                                    
                                </div>
                            </div>
                    
                          
                            
                         
                        
                          
                          
                                       
                                    </div>
                                </div>
                            
              
              
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
            
           
        <!--END PAGE WRAPPER-->
           
           
           
                   
                  <?php 


$this->load->view('footer');

?>

               
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            
            
         
</body>
</html>