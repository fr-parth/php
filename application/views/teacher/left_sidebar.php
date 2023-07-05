 
<?php
 
 
$webHost = $_SESSION['webHost'];
$isSmartCookie=$_SESSION['isSmartCookie'];
 
if($teacher_info[0]->t_complete_name != '')
{
    $teacher_name = $teacher_info[0]->t_complete_name;
}
else
{
    $teacher_name = $teacher_info[0]->t_name.' '.$teacher_info[0]->t_middlename.' '.$teacher_info[0]->t_lastname;
}

$filepath = $_SERVER['DOCUMENT_ROOT'].'/teacher_images/'.$teacher_info[0]->t_pc;
?>


<?php  
//emp type of teacher
$empType = $teacher_info[0]->t_emp_type_pid; 
$school_type = $teacher_info[0]->sctype;
$is_dept_admin = $teacher_info[0]->is_dept_admin;
//switch case added by Pranali to get teacher type based on empType for SMC-3825 on 7-5-19
//condition added for Manager in case 134 by Pranali for SMC-4210 on 28-11-19
switch ($empType) {
    case 133:
    if($school_type=='organization')
    {
            $teacherType='Manager';
    }else{
         $teacherType='Teacher';
    }           
        break;
    case 134:
           if($school_type=='organization')
    {
            $teacherType='Manager';
    }else{
         $teacherType='Teacher';
    }
        break;
    case 135:
           if($school_type=='organization')
    {
            $teacherType='Reviewing Officer';
    }else{
         $teacherType='HOD';
    }           
        break;
    case 137:
           if($school_type=='organization')
    {
            $teacherType='Appointing Authority';
    }else{
         $teacherType='Principal';
    }           
        break;
    case 139:
           if($school_type=='organization')
    {
            $teacherType='Member Secretary';
    }else{
         $teacherType='';
    }           
        break; 
    case 141:
           if($school_type=='organization')
    {
            $teacherType='Vice Chairman';
    }else{
         $teacherType='';
    }           
        break;
    case 143:
           if($school_type=='organization')
    {
            $teacherType='Chairman';
    }else{
         $teacherType='';
    }           
        break;     
    default:
           if($school_type=='organization')
    {
            $teacherType='Manager';
    }else{
         $teacherType='Teacher';
    }           
        break;
}

?>

        <!-- Left Sidebar -->
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
           <div class="user-info">
                <span id="mydiv">
                    <div class="image" style="cursor:pointer;" data-toggle="modal" data-target="#uploadModal" id="mydiv1">
                        <img src="<?php if(!file_exists($filepath) || empty($teacher_info[0]->t_pc)){echo DEFAULT_IMG_PATH;}else{echo TEACHER_IMG_PATH.$teacher_info[0]->t_pc;} ?>" width="48" height="48" alt="User" id="myimg" />
                    </div>
                </span>
                <div class="info-container" >
            <!--$teacherType added by Pranali to display teacher type for SMC-3825 on 7-5-19 -->
                    <div class="name" style="max-width: 400px;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><?php echo $teacher_name ."  "."(". $teacherType .")";?></div>
                    <!--<div class="email"><?php //echo $teacher_info[0]->t_email;?></div>-->
                    <div class="name">Member ID :<?php
                        echo $_SESSION['id']?><br> 
                        Year:<?php if(count($current_acadmic_year>0)){echo $current_acadmic_year[0]['Academic_Year'];}else{echo "";}?>
                    </div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo base_url(); ?>teachers/teacher_profile"><i class="material-icons">person</i>My Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>Clogin/logout"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            
            <div class="menu" id="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION </li>
                    <li class="">
                        <a href="<?php echo base_url(); ?>teachers">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <?php if($this->session->userdata('usertype')=='teacher') {?>
                    <li id="aicte">


                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>AICTE Feedback Details</span>
                        </a>

                        <ul class="ml-menu">  
    
                            <?php 
                             if($empType=='133' || $empType=='134') //Employee type is Teacher
                             {
                            ?>
 
                            <li id="genCoupon">
                                <a href="<?php echo base_url(); ?>teachers/fill_teaching_process_form">Teaching Process</a>
                            </li>
 
                            <li id="society">
                                     <?php $list='society'; ?>
                                <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Contribution to Society</a>
                            </li> 
                             <li id="society">
                                   
                                <a href="<?php echo base_url(); ?>Teachers/my_feedback">My Feedback Report</a>
                            </li> 
 
                        <?php } else if($empType=='135') { ?>  
 
                            <li id="genCoupon">
                                <a href="<?php echo base_url(); ?>teachers/fill_teaching_process_form">Teaching Process</a>
                            </li>  
                            
                            <li id="dept_activity">
                                <?php $list='dept_activity'; ?>
                                <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Departmental Activites</a>
                            </li>
                            
                            <li id="society">
                                     <?php $list='society'; ?>
                                 <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Contribution to Society</a>
                            </li> 
                             <li id="society">
                                  
                                <a href="<?php echo base_url(); ?>Teachers/my_feedback">My Feedback Report</a>
                            </li>
                            
                            <?php } else if($empType=='137') { ?>
                            
                                  <li id="genCoupon">
                                      <a href="<?php echo base_url(); ?>teachers/fill_teaching_process_form">Teaching Process</a>
                                  </li>
                                  
                                  <li id="dept_activity">
                                        <?php $list='dept_activity'; ?>
                                        <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Departmental Activities</a>
                                  </li>
                                  
                                  <li id="institute">
                                     <?php $list='institute'; ?>
                                     <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Institute Activities</a>
                                  </li>

                                  <li id="acr">
                                     <?php $list='acr'; ?>
                                    <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">ACR</a>
                                  </li>

                                  <li id="society">
                                     <?php $list='society'; ?>
                                    <a href="<?php echo base_url(); ?>teachers/aicte_principal_activity/<?php echo $list; ?>">Contribution to Society</a>
                                  </li>
                                   <li id="society">
                                    
                                <a href="<?php echo base_url(); ?>Teachers/my_feedback">My Feedback Report</a>
                            </li>
                            
                            <?php }?>
                            
                        </ul>
                    </li> 
                    <?php }?>
                    <li id="sponCoupon">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">layers</i>
                            <span>Sponsor Coupons</span>
                        </a>
                        <ul class="ml-menu">
                                    <li id="selCoupon">
                                        <a href="<?php echo base_url(); ?>teachers/select_coupons">Select Coupon</a>
                                    </li>
                            
                                    <li id="cartCoupon">
                                        <a href="<?php echo base_url(); ?>teachers/cart">My Cart</a>
                                    </li>
                                    
                                    <li id="allCoupon">
                                        <a href="<?php echo base_url(); ?>teachers/bought_coupons">Used / Unused Coupons</a>
                                    </li>
                        
                                    <!--<li>
                                        <a>Used Coupon</a>
                                    </li>-->
                                    </ul>
                    </li>
                    <li id="smartCoupon">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>SmartCookie Coupon</span>
                        </a>
                        <ul class="ml-menu">
                            
                            <li id="genCoupon">
                                <a href="<?php echo base_url(); ?>teachers/generate_coupon">Generate / View Coupon</a>
                            </li>
                        </ul>
                    </li>
                    <li id="otheract">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">swap_calls</i>
                            <span>Other Activities</span>
                        </a>
                        <ul class="ml-menu">
                            <?php 
//Department Hierarchy option added by Rutuja Jori on 21/12/2019 for SMC-4278
                            if($school_type=='organization' && $is_dept_admin=='1'){ ?>
                            <li id="dept_hierarchy">
                                <a href="<?php echo base_url(); ?>teachers/dept_hierarchy">Department Hierarchy</a>
                            </li>
                            <?php } ?>
                            <?php
//Mudra Request option for organization added by Pranali for SMC-4269 on 14-12-19                           
                            if($school_type=='organization'){ ?>
                            <li id="mudra">
                                <a href="<?php echo base_url(); ?>teachers/manager_list">Mudra Request/ThanQ To Manager</a>
                            </li>
                           <?php } ?>
                            <li id="mysub">
                                <a href="<?php echo base_url(); ?>teachers/teacherSubject_list">My <?php echo ($school_type=='organization')?'Project':'Subject'; ?></a>
                            </li>
                            <li id="addsub1" class="sweet-5" onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-5']);">
                                <a href="<?php echo base_url(); ?>teachers/addsubject">Add <?php echo ($school_type=='organization')?'Manager':'Teacher'; ?> <?php echo ($school_type=='organization')?'Project':'Subject'; ?></a>
                            </li>
                            <li id="sharepts">
                                <a href="<?php echo base_url(); ?>teachers/get_teachers">Share Points</a>
                            </li>
                            <li id="buysoftR">
                                <a href="<?php echo base_url(); ?>teachers/get_softreward">Purchase Soft Rewards</a>
                            </li>
                            <li id="purchaseWPts">
                                <a href="<?php echo base_url(); ?>teachers/purchase_water_point">Purchase Water Points</a>
                            </li>
                            
                            <?php //Below if condition added by Rutuja for SMC-4455 on 22/01/2020 for hiding Coordinator List option for Manager
                             if($school_type=='school')
                            {?>
                            <li id="coordList">
                                <a href="<?php echo base_url(); ?>teachers/coordinator_list">Coordinator List</a>
                            </li>
                        <?php }?>
                            <li id="smartRequest">
                                <a href="<?php echo base_url(); ?>teachers/requestToJoinSmartcookie">Request to Join SmartCookie</a>
                            </li>
                            <li id="pointRequest">
                                <a href="<?php echo base_url(); ?>teachers/pointRequest_from_student">Point Request from <?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee/Manager'; ?></a>
                            </li>
                            <!--<li>
                                <a href="#">Request from other Student</a>
                            </li>-->
                            <?php //Below if condition added by Rutuja for SMC-4455 on 22/01/2020 for hiding Request for Coordinator option for Manager
                             if($school_type=='school')
                            {?>
                            <li id="coordRequest1">
                                <a href="<?php echo base_url(); ?>teachers/request_for_coordinator">Request for Coordinator</a>
                            </li>
                        <?php } ?>
                            
                        </ul>
                    </li>
                    <li id="sponsors">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Sponsors</span>
                        </a>
                        <ul class="ml-menu">
                            <li id="sponsmap">
                                <a href="<?php echo base_url(); ?>teachers/sponsor_map">Sponsor Map</a>
                            </li>
                            <li id="suggestSpons">
                                <a href="<?php echo base_url(); ?>teachers/suggest_sponsor">Suggest New Sponsor</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li id="searchstuds">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">search</i>
                            <span>Search <?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?></span>
                        </a>
                        <ul class="ml-menu">
                            <li id="searchstud">
                                <a href="<?php echo base_url(); ?>teachers/search_students">My <?php echo ($this->session->userdata('usertype')=='teacher')?'School':'Oraganization'; ?> <?php echo ($this->session->userdata('usertype')=='teacher')?'Student':'Employee'; ?></a>
                            </li>
                            <!--<li> search is working but have to change conditions for point assign 
                                <a href="<?php //echo base_url(); ?>teachers/search_students/all">All School Student</a>
                            </li>-->
                        </ul>
                    </li>
                    
                    <li id="mylogs">
                    
                       <a  class="menu-toggle">
                            <i class="material-icons" style="color: #7c7c7c;">text_fields</i>
                            <span style="color: #3a3a3a;">Logs</span>
                        </a>
                        <ul class="ml-menu">
                            
                            <li id="stdRlog">
                                <a href="<?php echo base_url(); ?>teachers/assigned_points_log"><?php echo ($school_type=='organization')?'Employee':'Student'; ?> Rewards Log</a>
                            </li>
                            <li id="softlog">
                                <a href="<?php echo base_url(); ?>teachers/purchased_softreward">Soft Rewards Log</a>
                            </li>
                            <li id="sharedpt">
                                <a href="<?php echo base_url(); ?>teachers/shared_points_log">My Shared Points</a>
                            </li>
                            <li id="thanqpt">
                                <a href="<?php echo base_url(); ?>teachers/thanqpoints_log">ThanQ Points from <?php echo ($school_type=='organization')?'Employee':'Student';?>s</a>
                            </li>
                            <li id="buyclog">
                                <a href="<?php echo base_url(); ?>teachers/bought_coupons">My Buy Coupon Log</a>
                            </li>
                            <li id="myblue">
                                <a  class="menu-toggle">
                                <i class="material-icons"></i>
                                My Blue Points
                                </a>
                                <ul class="ml-menu">
                                <li id="usedblue">

                                <a href="<?php echo base_url(); ?>teachers/allUsed_bluePoints">Used ThanQ Points</a>

                                </li>
                                <li id="allblue">

                                <a href="<?php echo base_url(); ?>teachers/allReceived_bluePoints">Points provided by <?php echo ($school_type=='organization')?'Organization':'School'; ?> Admin and <?php echo ($school_type=='organization')?'Manager':'Teacher'; ?></a>

                                </li>
                                </ul>
                            </li>
                            <li id="mygreen">
                                <a  class="menu-toggle">
                                <i class="material-icons"></i>
                                My Green Points
                                </a>
                                <ul class="ml-menu">
                                <li>
                                <a href="<?php echo base_url(); ?>teachers/assigned_points_log">Used Green Points</a>
                                </li>
                                <li id="allgreen">

                                <a href="<?php echo base_url(); ?>teachers/greenPointsFrom_scadmin">Reward Points Distributed by <?php echo ($this->session->userdata('usertype')=='teacher')?'School':'Organization'; ?> Admin</a>

                                </li>
                                </ul>
                            </li>
                            <li id="mybrown">
                                <a  class="menu-toggle">
                                <i class="material-icons"></i>
                                My Brown Points
                                </a>
                                <ul class="ml-menu">
                                <li id="allbrown">
                                <a href="<?php echo base_url(); ?>teachers/earned_brown_points">Earned Points Log</a>
                                </li>
                                
                                </ul>
                            </li>
                            
                             <li id="mywater">
                                <a  class="menu-toggle">
                                <i class="material-icons"></i>
                                My Water Points
                                </a>
                                <ul class="ml-menu">
                                <li id="used_water">
                                    <a href="<?php echo base_url(); ?>teachers/used_water_point_log">Used Water Points</a>
                                </li>
                                <li id="allwater">
                                    <!--Purchased Water Point Log option given by Pranali for SMC-4088 on 25-10-19 -->
                                <a href="<?php echo base_url(); ?>teachers/purchase_water_point_log">Assigned/Purchased Water Point Log</a>
                                </li>
                                
                                </ul>
                            </li>

                             <li id="actLog">
                                <a href="<?php echo base_url(); ?>teachers/activity_log">Activity Logs</a>
                            </li>

                        </ul>
                    </li>
                    <?php 
                    //Employee Activity Summary Report is Added by Sayali Balkawade for SMC-4277 on 25/12/2019 
                    ?>
                    
                    <?php if ($this->session->userdata('usertype')=='manager')
                    {?>
                    <li class="">
                        <a href="<?php echo base_url(); ?>teachers/empActivitySummary_report">
                            <i class="material-icons">report</i>
                            <span>Employee Activity Summary Report</span>
                        </a>
                    </li>
                    <?php } ?>
                    <!--<li>
                         <a href="javascript:void(0);">
                            <i class="material-icons">view_list</i>
                          <span>Leaderboard</span>
                        </a> 
                    </li> -->
 
 
 
 
 <br/><br/><br/><br/><br/><br/><br/><br/><br/>
<!--
 
                             <li id="genCoupon">
                                 <a href="<?php //echo base_url(); ?>teachers/student_feedback_summary">Student Feedback Summary</a>
                            </li> 
 
-->
 
<!--
                    <li class=""></li> Do not remove li, it can create problem with scroll in menu 
 
 
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-red"></i>
                            <span>&nbsp;</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-amber"></i>
                            <span>&nbsp;</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">
                            <i class="material-icons col-light-blue"></i>
                            <span>&nbsp;</span>
                        </a>
                    </li>
                    
-->
                </ul>
            </div>
 

            <!-- #Menu -->
           <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2023 - 2024 <a href="javascript:void(0);">Smart Cookie</a>.
                </div>
               <!-- <div class="version">
                    <b>Version: </b> 1.0.5
                </div>-->
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <!--<ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>-->
        </aside>
        </div>
        <!-- #END# Right Sidebar -->
        <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/validation.js"></script>
                    <script type="text/javascript" src="<?php echo TEACHER_ASSETS_PATH;?>/js/ajax.js" /></script>
  <!-- Modal -->
        <div id="uploadModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Change Profile Image</h4>
                </div>
                <div class="modal-body">
                <div class="image" >
                    <img src="<?php echo TEACHER_IMG_PATH.$teacher_info[0]->t_pc;?>" id="logo" width="48" height="48" alt="User" />
                </div>
                    <!-- Form 
                    <form method="post" action="" id="upload_file" runat="server" enctype='multipart/form-data'>-->
                    <?php echo form_open_multipart('',"id='upload_file' runat='server'");?>
                        Select file : <input type="file" name="userfile" id="userfile" onchange="readURL(this);" /><br>
                        <span>Max file size is 100 KB</span>
                        <div id='preview'></div>
                        <button type="submit" name="submit" class="myButton form2" id="saveFile">Submit</button>
                    </form>
                </div>
            </div>
          </div>
        </div>
 
  <div id="uploadModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" align="center">Change Profile Image</h4>
                </div>
                <div class="modal-body">
                <div class="image" >
                    <img src="<?php echo TEACHER_IMG_PATH.$teacher_info[0]->t_pc;?>" id="logo" width="48" height="48" alt="User" />
                </div>
                    <!-- Form 
                    <form method="post" action="" id="upload_file" runat="server" enctype='multipart/form-data'>-->
                    <?php echo form_open_multipart('',"id='upload_file' runat='server'");?>
                        Select file : <input type="file" name="userfile" id="userfile" onchange="readURL(this);" /><br>
                        <span>Max file size is 100 KB</span>
                        <div id='preview'></div>
                        <button type="submit" name="submit" class="myButton form2" id="saveFile">Submit</button>
                    </form>
                </div>
            </div>
          </div>
        </div>

        <noscript>
  <p> <font color ="red" ><h3 style="position:fixed;
    top: 40%;
    left:35%;
    text-align:center;
    margin:0 auto;
    background-color:#FFFFFF;z-index:999;" class="alert alert-warning">This page needs JavaScript enabled to work.<br><a href="https://www.enable-javascript.com/" target="_blank">Click here to check settings</a></h3> </font></p>
 
 </noscript>
        <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#logo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script> 