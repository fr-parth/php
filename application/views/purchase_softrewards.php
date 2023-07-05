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
	<script>

function form_reset()
{
	var r = confirm("Do you want to purchase rewards?");
	if (r == true) {
			window.location.href ="<?php echo base_url('view/purchase_softrewards')?>";
		}
}
</script>

</head>

<title>Accepted Request Points Log</title>
    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Purchase Soft Rewards</div>
                </div>
				
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Points</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Soft Rewards</li>
                </ol>
                <div class="clearfix"></div>
            </div>
			<?php if ($this->session->flashdata('successpurchasereward')) { ?>
				<h3 style="color:green;">
					<?php echo $this->session->flashdata('successpurchasereward'); ?>
				</h3>
			<?php } ?>
			<?php if ($this->session->flashdata('errorpurchasereward')) { ?>
				<h3 style="color:red;">
					<?php echo $this->session->flashdata('errorpurchasereward'); ?>
				</h3>
			<?php } ?>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
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
                                        <th>Sr. No.</th>
                                        <th>Reward Image</th>
                                        <th>Reward Name</th>
                                        <th>Reward Points</th>
                                        <th>Purchase Points</th> 
                                    </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($purchase_softrewards as $t) {?>
                                        <tr>
                                            <td data-title="Sr.No"><?php echo $i;?></td>
                                             <td data-title="Image" >
											        <img src="<?php echo site_url()."core/".$t->imagepath ?>" name="image" height="75" width="75" class="img-responsive" >
											 </td>
                                            <td data-title="reward" ><?php  echo ucwords(strtolower($t->rewardType));?></td>
											    <td data-title="Points" ><?php echo $t->fromRange;?></td>
												<td data-title="Button"><a onClick="javascript: return confirm('Do you want to purchase rewards?');" href="<?php echo base_url().'/main/purchase_reward1/'. $t->fromRange.'/'.$t->softrewardId?>"><input type="button"
												 value="Purchase"  class="btn btn-success"></a></td>
                                         
                                          
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
                            </div>
                 </div>
                
            <!--END CONTENT--><!--BEGIN FOOTER-->
                       
        <!--END PAGE WRAPPER-->
                   
                  <?php 
$this->load->view('footer');

?>          
            <!--END CONTENT--><!--BEGIN FOOTER-->
         
            </div>  
</body>
</html>