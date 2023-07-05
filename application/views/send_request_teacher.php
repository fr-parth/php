<?php 
//print_r($schoolinfo);

$this->load->view('stud_header',$studentinfo);
$school_id=$teacherinfo[0]->school_id;

?>

<!DOCTYPE html>
<html lang="en">
<head>


<script type="text/javascript">
  var school_id = <?php echo json_encode($school_id); ?>;  
function studentactivityalert()  
    {  
     
     var activity = document.getElementById("activity").value;
  if(activity=='')
  {
document.getElementById('catList').innerHTML='';
  document.getElementById('ciudad').innerHTML='';
   document.getElementById('errorreport').innerHTML='Select one Activity or Subject type';
  
 
  }


        if(activity=='activity')
  {
document.getElementById('catList').innerHTML='<div class="row"> <div class="col-md-6"><div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Activity Type<span class="mandatory" style="color:red;">*</span>:</label><div class="col-md-7"><select name="activity_type" id="activity_type" class="form-control"  onChange="getactivity(this.value)" ><option value="">Select</option><?php $i=0; foreach($activity_type as $t){?>  <option value="<?php echo $t->id;?>"><?php echo $t->activity_type;?></option><?php $i++;}?></div></div></div></div>';
 document.getElementById('errorreport').innerHTML='';
  }
 
  if(activity=='subject')
  {
    /* Author VaibhavG
    * Assigned subject id instead of subject code to the select option value for the ticket number SMC-3248 24Aug18 06:37Pm
    */
       document.getElementById('ciudad').innerHTML='';
  document.getElementById('catList').innerHTML='<div class="row"> <div class="col-md-6"><div class="form-group"><label for="inputPhone" class="col-md-3 control-label">MyProjects<span class="mandatory" style="color:red;">*</span>:</label><div class="col-md-7"><select name="subject" id="subject" class="form-control" ><option value="">Select</option><?php $i=0; foreach($subject_list as $t1){ ?> <option value="<?php echo $t1->id;?>"><?php echo $t1->subjectName; ?></option><?php $i++;}?></div></div></div></div>';

 document.getElementById('errorreport').innerHTML='';
 
 
  }


    
    
    }    
  
  function my_validation()
  {
    var activity = document.getElementById("activity").value;
    var points = document.getElementById("points").value;

    if(activity == '')
    {
      document.getElementById('catList').innerHTML='';
      document.getElementById('ciudad').innerHTML='';
      document.getElementById('errorreport').innerHTML='Select one Activity or Subject type';
      document.getElementById("activity").focus();
      return false;
    }
    else if(activity != '' )
    {
      var activity_type=document.getElementById("activity_type").value;

      if(activity_type == '')
      {
        document.getElementById('ciudad').innerHTML='';
        document.getElementById('errorreport').innerHTML='Please Select Activity type';
        document.getElementById("activity_type").focus();
        return false;
      }
      else if(activity_type != '')
      {
        var activitydisplay=document.getElementById("activitydisplay").value;
        if(activitydisplay == '')
        {
          //document.getElementById('ciudad').innerHTML='';
          document.getElementById('errorreport').innerHTML='Please Select Activity sub type';
          document.getElementById("activitydisplay").focus();
          return false;
        }

      }


    }
    
  }
  function getactivity(value)
  {
    if(value != '')
    {
       document.getElementById('errorreport').innerHTML='';
    }
     $.ajax({
         type: "POST",
     url: '<?php echo base_url(); ?>main/getactivity',
        
         data: {
       activity_type : value, 
     school_id : school_id
     },
       
         cache:false,
        success: function(data) {
                        $('#ciudad').html(data);
                    }
          });// you have missed this bracket
     


  }

  function activity_display(val)
  {
    if(val != '')
    {
       document.getElementById('errorreport').innerHTML='';
    }
  }
</script>
</head>


<title>Send Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></title>


    

<body>

    <!--END THEME SETTING-->

   
        <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->
   
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
          
          
           
             <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Send Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="<?php echo base_url();?>/main/members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li><a href="#">Request</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                    <li class="active">Send Request to <?php echo ($this->session->userdata('usertype')=='employee')?'Manager':'Teacher'; ?></li>
                </ol>
                <div class="clearfix"></div>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
        <div class="page-content">
        <div id="form-layouts" class="row">
                    <div class="col-lg-12">
         <div id="tab-two-columns-readonly" >
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-yellow">
                                            <div class="panel-heading"><?php echo ucwords( strtolower($teacherinfo[0]->t_complete_name))?></div>
                                            <div class="panel-body pan">
                                           
                                              <?php 
echo form_open("main/send_requestteacher/".$teacherinfo[0]->t_id,"class=form-horizontal onsubmit='return my_validation()'");?>
                                                 <div class="row" align="center" style="margin-top:2%;">
                                                 <?php if ($teacherinfo[0]->t_pc==""){ ?> <img src="<?php echo base_url()?>images/avtar.png"  alt="" class="img-circle" style="height:80px;width:80px;"/><?php  } else {?><img src="<?php echo base_url()?>core/<?php echo $teacherinfo[0]->t_pc?>"  alt="" class="img-circle" style="height:80px;width:80px;border: 5px solid #eee;"/> <?php }; ?>
                                                           
                                                           
                                                        </div>
                                                    <div class="form-body pal" style="margin-top:-2%;"><h3>Personal Details</h3>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputFirstName" class="col-md-3 control-label">Name:</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo ucwords(strtolower($teacherinfo[0]->t_complete_name))?></p></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group"><label for="inputLastName" class="col-md-3 control-label">Email:</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php if($teacherinfo[0]->t_email=="")
                                  {                                   
                                      echo $teacherinfo[0]->t_internal_email;
                                    }
      
                                  else
                                  {
                                    echo $teacherinfo[0]->t_email;
                                  }
                                  ?></p></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                     
                                                        <div class="row">
                                                        
                                                         <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Phone:</label>

                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $teacherinfo[0]->t_phone?></p></div>
                                                                </div>
                                                            </div>
                                                            
                                                             <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Balance Green Points:</label>
                                                                    
                                                                    <div class="col-md-9"><p class="form-control-static"><?php echo $teacherinfo[0]->tc_balance_point?></p></div>
                                                                </div>
                                                            </div>
                                                          
                                                        </div>
                                                        
                                                        
                                                              <div class="row">
                                                        
                                                         <div class="col-md-6">
                                                                <div class="form-group"><label for="thanq_reason" class="col-md-3 control-label">Activity or <?php echo ($this->session->userdata('usertype')=='employee')?'MyProjects':'Subject'; ?><span class="mandatory" style="color:red;">*</span>:</label>
                                                                
                                                            
                                                                    <div class="col-md-7">
                                                                <br/>
                                                                 <select name="activity" id="activity" class="form-control" onchange="studentactivityalert()"> 
                                                                 <option value="">Select</option>

                                                                 <option value="activity" >Activity</option>
                                                                    <option value="subject"><?php echo ($this->session->userdata('usertype')=='employee')?'MyProjects':'Subject'; ?></option>
                                                                 </select>
                                                                    
                                                                    
                                                                    </div>
                                                     
                                                        </div>
                            </div>
                            </div>
                            
                            
                            
                             <div id="catList"></div>
                                                      
                            
                             <div class="row">
                                                        
                                                         <div class="col-md-6">
                                                                <div class="form-group"><label for="thanq_reason" class="col-md-3 control-label"></label>
                                                                
                                                            
                                <div class="col-md-7" id="ciudad">
                                
                                <?php 
                                /* Author VaibhavG
                                  Add one extra validation error message for the ticket number SMC-3279 27Aug18 8:00PM
                                */
                                  echo form_error('activitydisplay', '<div class="error">', '</div>'); ?>
                                </div>
                                                     
                                                        </div>
                            </div>
                            </div>
                    
                                                     
                                                    <div class="row">
                                                     
                                                      <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Points<span class="mandatory" style="color:red;">*</span>:</label>

                                                                    <div class="col-md-7"><input id="points" name="points" type="text" placeholder="Points" class="form-control"><?php echo form_error('points', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>
                                                            
                                                    </div>


                                                    <div class="row">
                                                           <div class="col-md-6">
                                                                <div class="form-group"><label for="inputPhone" class="col-md-3 control-label">Request Comment:</label>

                                                                    <div class="col-md-7"><textarea id="request_comment" name="request_comment" type="text" placeholder="Request Comment" class="form-control"></textarea><?php echo form_error('request_comment', '<div class="error">', '</div>'); ?></div>
                                                                </div>
                                                            </div>  
                              
                                                    </div>
                          
                          
                                                    <div class="form-actions text-right pal" style="background-color:#FFF;">
                                                    <div class="error" align="center" id="errorreport">
                          
                          <?php 
                          if(isset($report))
                          {
                            ?><font color="red"><?php echo $report;?></font>
                        
                          <?php }
                          if(isset($report1))
                          {
                          ?><font color="green"><?php echo $report1;?></font>
                          <?php }
                          ?>
                          </div>
                        </div>
                          <center>
                                                      <?php 
                          echo form_submit('assign', 'Send Request','class="btn btn-green"');
                          ?>
                                                      
                                                        &nbsp;
                                                         <a href="<?php echo site_url();?>/main/teacherlist_request" ><button type="button" class="btn btn-danger">Cancel</button></a>
                                                    </center>
                                                    </div>
                                               <?php echo form_close(); ?>
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