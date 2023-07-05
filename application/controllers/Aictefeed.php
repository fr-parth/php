<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 

class Aictefeed extends CI_Controller {
 
    function __construct() 
    { 
        parent::__construct(); 
        $this->load->model('Aictefeed_model');
        $this->load->model('student'); 
    }

  
   public function aicte_feedback()
    {   

        $std_PRN = $this->session->userdata('std_PRN');  //86004 
 
        $school_id=$this->session->userdata('school_id');  //119   
  
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['parentinfo']=$this->student->parentlog($std_PRN,$school_id);
  
        $row['stud_rating']=$this->student->studentRating();
        $this->load->model('Teacher'); 
        $row['all_acadmic_year']= $this->Teacher->select_all_acadmic_year('Academic_Year','tbl_academic_Year',array('school_id'=>$school_id));
         $row['Academic_Year']= $this->Teacher->Academic_Year($school_id);
         // print_r($row['Academic_Year'][0]->Academic_Year);exit;

        //$row['stud_subList']=$this->student->studentSubList($std_PRN,$school_id);
        
        //api implemente here for student subject
           $teacher_id1=$this->input->post('country_id');
            $url = base_url()."/core/Version4/student_subjectlistTeacher.php";
            
            //input Parameter of this web service
            $data=array(
            'std_PRN'=>$std_PRN,
            'school_id'=>$school_id,
            'student_dashboard'=>''
            
            );
            $row['stud_subList1'] = $this->get_curl_result($url,$data);
            //print_r($row['stud_subList1']);
           $url = base_url()."/core/Version4/get_entity_by_input_id.php";
            
            //input Parameter of this web service
            $data=array(
            'school_id'=>$school_id,
            'input_id'=>0,
            'entity_key'=>'Teachers',
            'limit'=>'All'
            
            );
           // print_r($data);
            //$resultBASE_URL = $this->get_curl_result($url,$data);
           $row['stud_subList'] = $this->get_curl_result($url,$data);
           $url = base_url()."/core/Version4/get_entity_by_input_id.php";
            
            //input Parameter of this web service
            $data=array(
            'school_id'=>$school_id,
            'input_id'=>0,
            'entity_key'=>'Academic_Year',
            'limit'=>'80'
            
            );
           // print_r($data);
           $row['stud_subList1'] = $this->get_curl_result($url,$data);
           //print_r($row['stud_subList']);
           //print_r($row['teacher_stud_subList']);exit;
           
           $row['Allow_student_add_subject_360'] = $this->student->get_Allow_student_add_subject_360($school_id);

        $this->load->view('aicte_feedback', $row);    
    }

    public function show_perticular_subject_teacher()
    {
        $std_PRN = $this->session->userdata('std_PRN');  //86004 
 
        $school_id=$this->session->userdata('school_id');  //119   
         //student info
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

            $school_id=$row['studentinfo'][0]->school_id;
           $this->session->set_userdata('sem_mutual',$row['studentinfo'][0]->std_semester);
            $this->session->set_userdata('branch_mutual',$row['studentinfo'][0]->std_branch);
            $this->session->set_userdata('dept_mutual',$row['studentinfo'][0]->std_dept);
            $stu_class=$row['studentinfo'][0]->std_class;
            $stu_div=$row['studentinfo'][0]->std_div;
            //print_r($row['studentinfo']);die;

        $teacher_id1=$this->input->post('teach_id');
        $acadmic_year1=$this->input->post('acadmic_year1');

        if($this->input->post('teach_id'))
      {
        
        $data = array('school_id'=>$school_id,'t_id'=>$teacher_id1,'acadmic_year'=>$acadmic_year1,'limit'=>'All','offset'=>0);          
         //print_r($data);exit;
           $url = base_url()."core/Version5/teacher_ws.php?f=teacherMySubjects";
          
           $teacher_stud_subList = $this->get_curl_result($url,$data);
              //print_r(count($teacher_stud_subList['posts']));
              if(count($teacher_stud_subList['posts'])>0){    
           $i=1;
           echo '<option value="0" >'.'Choose subject'.'</option>';
           foreach($teacher_stud_subList['posts'] as $row)
                {
                    
                     //echo '<option value="'.$row['subjectName'].'~'.$row['teacher_id'].'~'.$row['subjcet_code'].'~'.$row['Division_id'].'~'.$row['Semester_id'].'~'.$row['Branches_id'].'~'.$row['Department_id'].'~'.$row['CourseLevel'].'~'.$row['AcademicYear'].'">'.$row['subjectName'].','.$row['Department_id'].','.$row['Branches_id'].','.$row['Semester_id'].','.$row['Division_id'].'</option>';
                      echo '<option value="'.$row['subjectName'].'~'.$teacher_id1.'~'.$row['subjcet_code'].'~'.$row['Division_id'].'~'.$row['Semester_id'].'~'.$row['Branches_id'].'~'.$row['Department_id'].'~'.$row['CourseLevel'].'~'.$row['AcademicYear'].'~'.$stu_class.'">'.''.$row['subjectName'].' '.'('.$row['subjcet_code'].') Type: '.$row['Subject_type'].', Dept: '.$row['Department_id'].', '.'Branch: '.$row['Branches_id'].', '.'Semester: '.$row['Semester_id'].', '.'Division: '.$row['Division_id'].'</option>';
                      $i++;
                }
               // print_r($teacher_stud_subList['posts']);
           }
           
           if(count($teacher_stud_subList['posts'])==0)
           {
            //$this->session->set_userdata('school_sub','1')
            $url = base_url()."core/Version4/teacher_subject_details.php";
            
        //input Parameter of this web service
          $data=array("school_id"=>$school_id);


          $teacher_stud_subList = $this->get_curl_result($url,$data);
          if(count($teacher_stud_subList)>0){
            $std_PRN = $this->session->userdata('std_PRN');

            $school_id=$this->session->userdata('school_id');

            $Branches_id=$this->session->userdata('branch_mutual');
            $Semester_id=$this->session->userdata('sem_mutual');
            $Dept_id=$this->session->userdata('dept_mutual');
            //$this->session->unset_userdata('a');
           echo '<option value="0" >'.'Choose School subject'.'</option>';
           foreach($teacher_stud_subList['subjects'] as $row)
                {
                   

                     echo '<option value="'.$row['subject'].'~'.$teacher_id1.'~'.$row['Subject_Code'].'~'.$stu_div.'~'.$Semester_id.'~'.$Branches_id.'~'.$Dept_id.'~'.$row['Course_Level_PID'].'~'.''.'~'.$stu_class.'">'.''.$row['subject'].' '.'('.$row['Subject_Code'].') Type: '.$row['Subject_type'].', '.' Dept: '.$Dept_id.', Branch: '.$Branches_id.', '.'Semester: '.$Semester_id.', '.'Division: '.$stu_div.'</option>';

                      // echo '<option value="'.$row['subject'].'~'.$teacher_id1.'~'.$row['Subject_Code'].'~'..'~'.$Semester_id.'~'.$Branches_id.'~'.$Dept_id.'">'.'Sub:- '.$row['subject'].',Sub Code:-'.$row['Subject_Code'].',Sub Type:-'.$row['Subject_type'].','.'Branch:- '.$Branches_id.',Sem:- '.$Semester_id.',Div:- '.$Division_id.'</option>';
                      $i++;
                }
             }
             else
             {
                //echo '<option>'.'No School Subject Found'.'</option>';
                echo '<option value="'.'manual_val'.'~'.$teacher_id1.'">'.'No School Subject Found'.'</option>';
             }
            //print_r($teacher_stud_subList['subjects']);
           }
       }
    }
    
   public function getTeacherID()
    { 
         $school_id=$this->session->userdata('school_id');  //119     
       
         $tID = $_POST['teacID'];
        
         $res = $this->Aictefeed_model->teacherNameTeaID($tID,$school_id);
         
         echo $resesutl =  "Teacher Name - " .$res[0]->t_complete_name;  
    }

    public function save() 
    {   
        if( isset($_POST['subName']) ) { 
            $stuID         = $this->session->userdata('std_PRN');    
            $schoolID      = $this->session->userdata('school_id');
            $que_points    = $this->input->post('que_points'); 
            $que_question  = $this->input->post('question');
            $queNumber     = $this->input->post('que_number'); 
            $stuSub        = $this->input->post('subName');
            $teaID         = $this->input->post('teaID');
            $subCode       = $this->input->post('subCode');   
            $semID         = $this->input->post('semID');
            $branchID      = $this->input->post('braID');
            $deptID        = $this->input->post('deptID');
            $courLev       = $this->input->post('courLevel'); 
            $acdYear       = $this->input->post('acdYear');

            $textArea      = $this->input->post('textArea');  
            $is_manual     = $this->input->post('is_manual');  
            $stu_class      = $this->input->post('stu_class');  
            $stu_div     = $this->input->post('divID');  
      
            $data = array(
 
                'stu_feed_student_ID'     => $stuID,
                'stu_feed_school_id'      => $schoolID, 
                'stu_feed_points'         => $que_points,
                'stu_feed_que'            => $que_question,
                'stu_feed_que_ID'         => $queNumber,
                'stu_feed_subj'           => $stuSub,
                'stu_feed_teacher_id'     => $teaID,
                'stud_subjcet_code '      => $subCode,
                'stu_feed_semester_ID'    => $semID,
                'stu_feed_branch_ID'      => $branchID,
                'stu_feed_dept_ID'        => $deptID,
                'stu_feed_course_level'   => $courLev, 
                'stu_feed_academic_year'  => $acdYear,
                'stu_feed_comment'        => $textArea,
                'is_manual'               => $is_manual, 
                'stu_feed_div'            => $stu_div,
                'stu_feed_class'          => $stu_class

            );
          // print_r($data);die;
           $stuQueExt = $this->Aictefeed_model->checkQueIDandStudIDexist($stuID,$schoolID,$stuSub,$teaID,$queNumber);
            
           // if($stuQueExt != '1') {
//api's Version3/check_referral_act_points.php and Version5/Assign_Reward_Points360_API.php called for checking if student feedback doesn't exists for that particular subject and question then only give reward points (brown) to student by Pranali for SMC-4445 on 21-1-20
            $key='Students Feedback';
            $Reward = $this->Aictefeed_model->getRewardPoints($key);
            
            $reward_points = $Reward[0]->reward_points;
            $studentinfo = $this->student->studentinfo($stuID, $schoolID);
            $school_type = $studentinfo[0]->school_type;
            $group_member_id = $studentinfo[0]->group_member_id;

            $url = base_url().'core/Version3/check_referral_act_points.php';
            $data_api = array('reason_id'=>'1005','from_entity_id'=>'105','school_type'=>$school_type,'group_id'=>$group_member_id,'point_feedback'=>$reward_points);
            
            $result = $this->get_curl_result($url,$data_api);
            if($result['responseStatus']==200)
            {                      
                 $data1=$result['posts'];
                 $brown_points=$data1['points'];
                 $point_type=$data1['point_type'];
            }

            $res = $this->Aictefeed_model->insertFeedbackPointOnQue($data);

                if($res)
                {
                    $url = base_url().'core/Version5/Assign_Reward_Points360_API.php';
                    $data = array('PRN_EmpID'=>$stuID,'SchoolID'=>$schoolID,'Entity_TypeID'=>'105','Key'=>'Students Feedback');
            
                    $result = $this->get_curl_result($url,$data);

                    //echo "<div class='alert alert-success'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Question Feedback Points Inserted Successfully</div>"; 
                  
                }

                                    
//             } else {

//                echo "<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Question Feedback Points Already Given</div>"; 

// //                "<div class='alert alert-success' style='display:none;'> <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Question Feedback Points Insert Successfully</div>";
//             }
                
        } else {
            echo "<script> console.log('Failed'); </script>";
            echo "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Failed</div>"; 
        }
       
      }
    
    //stud_blog 
    public function stud_blog()
    {  
        $std_PRN = $this->session->userdata('std_PRN');  //86004  
        $school_id=$this->session->userdata('school_id');  //119   
  
        $row['studentinfo']=$this->student->studentinfo($std_PRN,$school_id);

        $school_id=$row['studentinfo'][0]->school_id;

        $row['parentinfo']=$this->student->parentlog($std_PRN,$school_id);
  
        $row['stud_rating']=$this->student->studentRating();

        $row['stud_subList']=$this->student->studentSubList($std_PRN,$school_id);
        
        $row['act_type']=$this->Aictefeed_model->actType($school_id);
        
        $this->load->view('stud_blog', $row);    
    }  
    
    
    public function studentDisBlog()
    {
        $baseurl=base_url();
         //$res = $this->student->fetchallBlogRecords();
            $Btitle = $_POST['Blog_title'];
            $Des    = $_POST['Description'];
            $actID  = $_POST['activityID']; 
            $cnt_likes = $_POST['cnt_likes'];
            $avg_star_cnt= $_POST['avg_star_cnt'];
            $rating  = $_POST['rating'];
            $activity  = $_POST['activity'];

            $actID = explode("," , $activity_id);        
            $actvID  = $actID[0];
            $actName = $actID[1]; 
             $extension=array("jpeg","jpg","png","gif");
            $file = array(); 
               $file_name = $_FILES["add_img"]["name"];
               $file_tmp  = $_FILES["add_img"]["tmp_name"];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention                
                if(in_array($ext,$extension)) 
                {                  
                     //Image upload logic changed by Pranali for SMC-4715 ON 15-5-20
                     $destination = './images/Blog_Images/'.$CurrentYear.'/'.$Currentmonth.'/';
                     //if path ($destination) does not exist then create path
                        if(!file_exists($destination))
                        {
                             mkdir($destination, 0777, true);
                        }
                        //rand() used for generating random number for image name
                        $randno=rand();
                        //$blog = $this->student->lastBlogID();
                        $blogid = $blog[0]->BlogID;
                        $insertpath="images/Blog_Images/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$blogid."."."jpg";
                        $filenm=$destination.$randno."_".$blogid."."."jpg";                        
                        move_uploaded_file($file_tmp=$_FILES["add_img"]["tmp_name"],$filenm);    
                }
               
         $data = array(
                        'BlogID'        => $blogid,
                        'BlogTitle'     => $Btitle,
                        'Description'   => $Des,
                        'featureimage'  => $insertpath,
                        'MemberID'      => $memID,
                        'EntityType'    => 105,
                        'cnt_likes'     => $cnt_likes,
                        'avg_star_cnt'  => $avg_star_cnt,                     
                        'SchoolID'      => $school_id,
                        'name'          => $stuName,
                        'activity_id'   => $actvID,
                        'activity' => $activity,
                        'rating'        => $rating,
                        'PRN_TID'       => $std_PRN,
                        'date'          => date("Y-m-d h:i:sa") 
                    );

        $url=$baseurl."core/Version5/DisplayBlog_API.php";
         //  echo $url;
         $result = $this->get_curl_result($url,$data);
          $result=$result['posts'];
          $row['result'] =$result;
          // print_r($result);    
        foreach($result as $data){  
         $output = '';  ?> 
         
                    <div class="row">
                      <div class="leftcolumn">
                        <div class="card">           
                          <h2><?php echo $data['BlogTitle']; ?></h2> -   <span> <?php echo $data['activity']; ?></span>
                          <p><div class="blogDesc"><?php echo $data['Description']; ?></div></p>                        
                          <div class="fakeimg">                              
                            <!-- <span><?php //echo $data->date; ?></span>-->                            
                              <img src="<?php 
                        //new path BASE_URL.'/'. added before $data->featureimage; by Pranali for SMC-4715 on 15-5-20
                                               echo BASE_URL.'/'.$data['featureimage'];                                       
                                       ?>" class="img-thumbnail" width="50%" height="50px;" />
                             <!-- <div> -->
                            <p> <span class="postrate">Post - Rate</span></p>
                            <p> <span>MY Rating</span></p>                            
                                 <div>    
                                   <?php 
                                   
                                           if($data['rating'] == 10)
                                           { ?> 
                                            <div class="strRate">                                                     
                                                          <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                          <i class="fa fa-star"  aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>  
                                                          <i class="fa fa-star" aria-hidden="true" id = "st3" style="color:#dbd9d9;font-size:24px;"></i> 
                                                          <i class="fa fa-star" aria-hidden="true" id = "st4" style="color:#dbd9d9;font-size:24px;"></i> 
                                                          <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>
                                     
                                       <?php }else if($data['rating'] == 15) { ?>                                                     
                                                    <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>                                     
                                        <?php   }else if($data['rating'] == 20){ ?> 
                                               
                                                   <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true"  style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>                          
                                                    </div>
                                     
                                       <?php   }else if($data['rating'] == 25){ ?> 
                                               
                                                   <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>
                                               
                                        <?php   }else if($data['rating'] == 30){ ?>
                                     
                                                   <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>
                                     
                                       <?php   }else if($data['rating'] == 35){ ?>
                                     
                                                   <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>   
                                     
                                        <?php   }else if($data['rating'] == 40){ ?>
                                     
                                                 <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#dbd9d9;font-size:24px;"></i>
                                                    </div>
                                     
                                         <?php   }else if($data['rating'] == 45){ ?>
                                     
                                                   <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                    </div> 
                                        
                                        <?php   }else if($data['rating'] == 50){ ?> 
                                     
                                                     <div class="strRate">
                                                          <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                    </div>                                     
                                        <?php   }else if($data['rating'] >= 50){ ?> 
                                     
                                                     <div class="strRate">
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i> 
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                         <i class="fa fa-star" aria-hidden="true" style="color:#fcb800;font-size:24px;"></i>
                                                    </div>                                   
                                <?php    }  ?>
                                </div>
                                <div>
                                <p> <span>Rating Till Now</span></p>
                                <fieldset class="rating" id="row" style="margin-top:-70px;margin-left: 80px;">  
                                            <!-- <p> Rating Till Know</p> -->
                                        <input type="hidden" id="que_ID"  name="que_ID" value="" /> 

                                        <input type="text" id="star" name="que_ID1" value="1"/ required>
                                        <label class="str fa-star" stu_PRN="<?php echo $data['PRN_TID'];?>" school_id="<?php echo $data['SchoolID'];?>" blog_id="<?php echo $data['BlogID'];?>" member_id="<?php echo $data['MemberID']; ?>" id = "i5" u_data="50" onclick="star5()" for="star1" title="Excellent"></label>

                                        <input type="hidden" id="star" name="rating" value="2" / required>
                                        <label class="str fa-star" stu_PRN="<?php echo $data['PRN_TID'];?>" school_id="<?php echo $data['SchoolID'];?>" blog_id="<?php echo $data['BlogID'];?>" member_id="<?php echo $data['MemberID']; ?>" id = "i4" u_data="40" onclick="star4()" for="star2" title="Very Good" data-id=""></label> 
         
                                        <input type="hidden" id="star" name="rating" value="3" / required>
                                        <label class="str fa-star" stu_PRN="<?php echo $data['PRN_TID'];?>" school_id="<?php echo $data['SchoolID'];?>" blog_id="<?php echo $data['BlogID'];?>" member_id="<?php echo $data['MemberID']; ?>" id = "i3" u_data="30" onclick="star3()" for="star3" title="Good" data-id=""></label>  
                                      
                                        <input type="hidden" id="star" name="rating" value="4" / required>
                                        <label class="str fa-star" stu_PRN="<?php echo $data['PRN_TID'];?>" school_id="<?php echo $data['SchoolID'];?>" blog_id="<?php echo $data['BlogID'];?>" member_id="<?php echo $data['MemberID']; ?>" id = "i2" u_data="20" onclick="star2()" for="star4" title="Poor" data-id=""></label>   
                                      
                                        <input type="hidden" id="star" name="rating" value="5" / required>
                                        <label class="str fa-star" stu_PRN="<?php echo $data['PRN_TID'];?>" school_id="<?php echo $data['SchoolID'];?>" blog_id="<?php echo $data['BlogID'];?>" member_id="<?php echo $data->MemberID; ?>" id = "i1" u_data="10" onclick="star1()" for="star5" title="Very Poor" data-id=""></label>  
         
                                 </fieldset>                      
                                </div> 
                                 
           <!-- <div class="shareit"><a href="" data-toggle="modal" data-target="#getShareIt"><strong class="share"> Share </strong> <i class="fa fa-share-alt" aria-hidden="true"></i></a></div>-->
                          </div>
                          </div>
                        </div> 
                      </div>
                      
                      <!-- <div class="rightcolumn">
                        <div class="card">
                          <h2>About Me</h2>
                           new path BASE_URL.'/'. added before $data->featureimage; by Pranali for SMC-4715 on 15-5-20
                          <div class="fakeimg"><img src="<?php echo BASE_URL.'/'.$data->featureimage; ?>" class="img-thumbnail" width="100%" height="100px"></div>
                          <p><?php echo $data->Description;?></p>
                        </div> 
                        <div class="card">
                          <h3>Follow Me</h3>
                          <p></p>
                        </div>
                         <div class="card">
                          <h3><p style="color:red">Get the star ratings</p></h3> 
                          
                          <fieldset class="rating" id="row">  

                                <input type="hidden" id="que_ID"  name="que_ID" value="" /> 

                                <input type="text"  id="star1" name="que_ID1" value="1"/ required>
                                <label class="str" stu_PRN="<?php echo $data->PRN_TID;?>" school_id="<?php echo $data->SchoolID;?>" blog_id="<?php echo $data->BlogID;?>" member_id="<?php echo $data->MemberID; ?>" id = "i5" u_data="50" data-id="" for="star1" title="Excellent"></label>

                                <input type="hidden" id="star2" name="rating" value="2" / required>
                                <label class="str" stu_PRN="<?php echo $data->PRN_TID;?>" school_id="<?php echo $data->SchoolID;?>" blog_id="<?php echo $data->BlogID;?>" member_id="<?php echo $data->MemberID; ?>" id = "i4" u_data="40" for="star2" title="Very Good" data-id=""></label> 
 
                                <input type="hidden" id="star3" name="rating" value="3" / required>
                                <label class="str" stu_PRN="<?php echo $data->PRN_TID;?>" school_id="<?php echo $data->SchoolID;?>" blog_id="<?php echo $data->BlogID;?>" member_id="<?php echo $data->MemberID; ?>" id = "i3" u_data="30" for="star3" title="Good" data-id=""></label>  
                              
                                <input type="hidden" id="star4" name="rating" value="4" / required>
                                <label class="str" stu_PRN="<?php echo $data->PRN_TID;?>" school_id="<?php echo $data->SchoolID;?>" blog_id="<?php echo $data->BlogID;?>" member_id="<?php echo $data->MemberID; ?>" id = "i2" u_data="20" for="star4" title="Poor" data-id=""></label>   
                              
                                <input type="hidden" id="star5" name="rating" value="5" / required>
                                <label class="str" stu_PRN="<?php echo $data->PRN_TID;?>" school_id="<?php echo $data->SchoolID;?>" blog_id="<?php echo $data->BlogID;?>" member_id="<?php echo $data->MemberID; ?>" id = "i1" u_data="10" for="star5" title="Very Poor" data-id=""></label>  
 
                            </fieldset> 
                           
                        </div>
                      
                      </div>
                     
                   </div> -->
        <?php  
                   
         }
        
       echo $output;
    }      
   
     public function insertStarRating()
     {  
         $Stu_blog_PRN        = $_POST['Stu_blog_PRN'];
        $Stu_blog_school_id  = $_POST['Stu_blog_school_id'];
        $Stu_blog_rat        = $_POST['Stu_blog_rate'];
        $Stu_blog_member_id  = $_POST['Stu_blog_member_id'];
        $Stu_blog_id         = $_POST['Stu_blog_id'];
        $g_std_PRN    = $this->session->userdata('std_PRN');    
        $g_school_id  = $this->session->userdata('school_id');      
         if($g_std_PRN != $Stu_blog_PRN && ($g_school_id !='' || $g_school_id !='$Stu_blog_school_id' || $Stu_blog_school_id!=''))
            {
                    $result = $this->student->checkStudentALgivenRatingInPost($g_std_PRN,$Stu_blog_school_id,$Stu_blog_id);
                   //print_r($result);exit;
                   if(count($result) == 0)
                   { 
                         $c=1;
                         for($i=1;$i<6;$i++)
                        $result2= $this->student->star_count($Stu_blog_id);
                     
                        foreach($result2 as $row)
                        {   
                            $rate= $row->rating;
                        }                           
                                   $data = array(
                                         'rating'           => $Stu_blog_rat, 
                                         'g_stu_PRN'        => $g_std_PRN,
                                         'g_stu_school_id'  => $g_school_id,
                                         'avg_star_cnt'     => $i,
                                         'cnt_likes'        => $c
                                     );  
                                   
                                     $result = $this->student->updateRatingInPost($data,$Stu_blog_id,$rate); 
                              
                                     if($result==1)
                                     {
                                         echo "You have given the rating successfully";                                    
                                     }                                   
                                    elseif($result!='')
                                     {
                                     echo "You have given the rating successfully";
                                     }
                                     else{

                                         echo "Failed";
                                     }
                             
                   }else{
 
                          echo "You have already given the rating";                             
                    }
                     }else{

                         echo "You can't get the rating on your own post";
                     } 
    }

  
    public function fetchActTypeID()
    {
         ob_end_clean();
         $actType    = $_POST['actType'];
         $school_id  = $this->session->userdata('school_id');        
         $data       = $this->student->fetchActId($actType,$school_id);
        foreach($data as $row)
        {     
          $scID    = $row->sc_id;
          $scList  = $row->sc_list;              
          echo '<option value="'.$scID.','.$scList.'">'.$scList.'</option>';           
        } 
         
    }
    
    public function addStuBlogPost()
    {
        $std_PRN    = $this->session->userdata('std_PRN');  
        $school_id  = $this->session->userdata('school_id');    
        $res       = $this->student->fetchStuNameAndMemID($std_PRN,$school_id);  
        $memID     = $res[0]->id;
        $stuName   = $res[0]->std_complete_name;    
        if(isset($_POST['Description']))
        {     
            $Btitle = $_POST['Blog_title'];
            $Des    = $_POST['Description'];
            $actID  = $_POST['activityID'];            
            $actID = explode("," , $actID);             
            $actvID  = $actID[0];
            $actName = $actID[1]; 
            $CurrentYear=date("Y");
            $Currentmonth=date("m");
            $extension=array("jpeg","jpg","png","gif");
            $file = array(); 
               $file_name = $_FILES["add_img"]["name"];
               $file_tmp  = $_FILES["add_img"]["tmp_name"];
               $ext       = pathinfo($file_name,PATHINFO_EXTENSION);   //file extention                
                if(in_array($ext,$extension)) 
                {                  
                     //Image upload logic changed by Pranali for SMC-4715 ON 15-5-20
                     $destination = './images/Blog_Images/'.$CurrentYear.'/'.$Currentmonth.'/';
                     //if path ($destination) does not exist then create path
                        if(!file_exists($destination))
                        {
                             mkdir($destination, 0777, true);
                        }
                        //rand() used for generating random number for image name
                        $randno=rand();
                        $blog = $this->student->lastBlogID();
                        $blogid = $blog[0]->BlogID;
                        $insertpath="images/Blog_Images/".$CurrentYear.'/'.$Currentmonth.'/'.$randno."_".$blogid."."."jpg";
                        $filenm=$destination.$randno."_".$blogid."."."jpg";                        
                        move_uploaded_file($file_tmp=$_FILES["add_img"]["tmp_name"],$filenm);    
                }
               
                    //$str = str_replace("image/" , "" , "$file_name");  
                    //$items = ltrim(base_url().'image/'.$str); 
                    $date  = date('Y-m-d');            
                    $data = array(                 
                        'BlogTitle'     => $Btitle,
                        'Description'   => $Des,
                        'featureimage'  => $insertpath,
                        'MemberID'      => $memID,
                        'EntityType'    => 105,
                        'cnt_likes'     => 0,
                        'avg_star_cnt'  => 0,
                        'SchoolID'      => $school_id,
                        'name'          => $stuName,
                        'activity_id'   => $actvID,
                        'activity'      => $actName,
                        'PRN_TID'       => $std_PRN,
                        'date'          => date("Y-m-d h:i:sa") 
                    );
                    // print_r($data);//exit;           
                      foreach($data as $key=>$value)
                      {
                          if(trim($value) == '')
                           unset($data[$key]);      
                      }             
                 $blgExt  = $this->student->checkBlogExt($Btitle,$Des,$insertpath,$memID,$school_id,$stuName,$actvID,$std_PRN);
                if($blgExt == 'TRUE')
                {
                    echo "Blog already exists";  
                }else{
                
                    $result  = $this->student->insertBlogAcvities($data);
                   // print_r($result);
                    if($result)
                    {
                        echo "Blog Created";

                    }else{

                        echo "Blog Failed"; 
                    }
                 }
             
            }
        
    }


    public function get_curl_result($url,$data)
    {
        $ch = curl_init($url);          
        $data_string = json_encode($data);    
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));$result = json_decode(curl_exec($ch),true);
        return $result;
    }
}