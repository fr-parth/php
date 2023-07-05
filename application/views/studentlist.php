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
                    <div class="page-title">Share Points </div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Share Points</li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-15">
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
                <th>Share</th>
                                            
                                           
                                           
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($studentlist as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No."><?php echo $i;?></td>
                                            <td data-title=""><?php if ($t->std_img_path==""){ ?> <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:50px;width:50px;"/><?php  } else {?><img src="<?php echo base_url()?>/core/<?php echo $t->std_img_path?>"  alt="" class="img-circle" style="height:50px;width:50px;"/> <?php };?></td>
                                            <td data-title="<?php echo ($this->session->userdata('usertype')=='employee')?'Employee':'Student'; ?> ID" > <?php echo $t->std_PRN;?></td>
                                            <td data-title="Name" ><?php  if($t->std_complete_name!=''){echo ucwords(strtolower( $t->std_complete_name));}else { echo ucwords(strtolower( $t->std_name." ".$t->std_Father_name." ".$t->std_lastname	));}?></td>
                                           
                                            <td><a href="share_points/<?php echo $t->std_PRN?>"><button type="button" class="btn btn-success">Share</button></a></td>
                                         
                                           
                                        </tr>
                                      <?php $i++;}?>
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
 
                </div>
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            
            
         
</body>
</html> 