<?php
ob_start();
ob_end_clean();
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Webservices extends CI_Controller {
 
   public function __construct()
   {  
       parent::__construct();
 
      $this->load->model('Webservices_model');  
        //date_default_timezone_set("Asia/Kolkata");
        //define('CURRENT_TIMESTAMP',date('Y-m-d H:i:s'));
       
            //URL call if http or https
            global $url_name;

            function url(){
            return sprintf(
            "%s://%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME']
            );
            }

            //$url_name = url();
            $GLOBALS['URLNAME']= url();
    }
     
 //
  //login webservices for android
    /*public function sendRequestToJoinSmartcookie_V5() 
    {  
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true); 
       
       $send_Mem_ID_Obj       =  $obj['sender_member_id']; 
       $send_Ent_ID_Obj       =  $obj['sender_entity_id'];  
       $rec_Ent_ID_Obj        =  $obj['receiver_entity_id'];
       $rec_Cont_Code_Obj     =  $obj['receiver_country_code']; 
       $rec_Mob_number_Obj    =  $obj['receiver_mobile_number'];
       $rec_email_ID_Obj      =  $obj['receiver_email_id'];
       $firstName_Obj         =  $obj['firstname']; 
       $middleName_Obj        =  $obj['middlename'];
       $lastName_Obj          =  $obj['lastname'];  
       $platform_Sor_Obj      =  $obj['platform_source'];
       $req_status_Obj        =  $obj['request_status'];   
       $inv_send_name_Obj     =  $obj['invitation_sender_name']; 
       
        
$send_Mem_ID = isset($_POST["sender_member_id"]) ? $_POST['sender_member_id']: $send_Mem_ID_Obj;
$send_Ent_ID = isset($_POST["sender_entity_id"]) ? $_POST['sender_entity_id']: $send_Ent_ID_Obj;
$rec_Ent_ID  = isset($_POST["receiver_entity_id"]) ? $_POST['receiver_entity_id']: $rec_Ent_ID_Obj;
$rec_Cont_Code = isset($_POST["receiver_country_code"]) ? $_POST['receiver_country_code']: $rec_Cont_Code_Obj;
$rec_Mob_number = isset($_POST["receiver_mobile_number"])? $_POST['receiver_mobile_number']: $rec_Mob_number_Obj;
$rec_email_ID = isset($_POST["receiver_email_id"]) ? $_POST['receiver_email_id']: $rec_email_ID_Obj;
$firstName = isset($_POST["firstname"]) ? $_POST['firstname']: $firstName_Obj;
$middleName = isset($_POST["middlename"]) ? $_POST['middlename']: $middleName_Obj;
$lastName = isset($_POST["lastname"]) ? $_POST['lastname']: $lastName_Obj;
$platform_Sor = isset($_POST["platform_source"]) ? $_POST['platform_source']: $platform_Sor_Obj;
$req_status = isset($_POST["request_status"]) ? $_POST['request_status']: $req_status_Obj;
$inv_send_name  = isset($_POST["invitation_sender_name"]) ? $_POST['invitation_sender_name']: $inv_send_name_Obj;
         
        
        if($rec_Ent_ID ==103) 
        { 
            $table_name = 'tbl_teacher';
            $condition = "(CountryCode = '$rec_Cont_Code' AND t_phone = '$rec_Mob_number') or t_email = '$rec_email_ID'";  
        } 
        
        else if($rec_Ent_ID ==105)
        {
            $table_name = 'tbl_student';
            $condition = "(country_code = '$rec_Cont_Code' AND std_phone = '$rec_Mob_number') or std_email = '$rec_email_ID'"; 

        }
        else 
        {
            $table_name = 'tbl_sponsorer';
            $condition = "(CountryCode = '$rec_Cont_Code' AND sp_phone = '$rec_Mob_number') or sp_email = '$rec_email_ID'"; 
 
        } 
    { 
      $table_name = 'tbl_teacher';
      $condition = "(CountryCode = '$rec_Cont_Code' AND t_phone = '$rec_Mob_number') or t_email = '$rec_email_ID'";  
    } 
        
    else if($rec_Ent_ID ==105)
    {
      $table_name = 'tbl_student';
      $condition = "(country_code = '$rec_Cont_Code' AND std_phone = '$rec_Mob_number') or std_email = '$rec_email_ID'"; 

    }
    else 
    {
      $table_name = 'tbl_sponsorer';
      $condition = "(CountryCode = '$rec_Cont_Code' AND sp_phone = '$rec_Mob_number') or sp_email = '$rec_email_ID'"; 
 
    }
 
         //$GLOBALS['URLNAME'] = ''; 
         $server_name = $GLOBALS['URLNAME'];
         
        
if((($rec_Cont_Code!='' && $rec_Mob_number!='') || $rec_email_ID!='') && $send_Mem_ID!='' && $send_Ent_ID !='' && $rec_Ent_ID!='' && $firstName!='' && $middleName!='' && $lastName!='' && $platform_Sor!='' && $req_status!='')
{
 
  $referral_id = rand(1, 9999999);
      
  $sender_type   = $send_Ent_ID == 103 ?  'teacher' : ( $send_Ent_ID == 105 ? 'student' : 'sponsor'); 
 
    $receiver_type = $rec_Ent_ID == 103 ?  'teacher' : ( $rec_Ent_ID == 105 ? 'student' : 'sponsor');
    
    $check_request_query  =  $this->Webservices_model->ch_req_query($receiver_type,$rec_Cont_Code,$rec_Mob_number,$rec_email_ID); 
            //print_r($check_request_query);exit;  
    
     $check_request_query_two  = $this->Webservices_model->ch_req_query_two($table_name,$condition); 
           //print_r($check_request_query_two);exit; 
           
  $acceptance_flag = 'N'; 
  //$invitation_sent_datestamp = date("Ymd h:i:s");//SMC-3450
  $invitation_sent_datestamp = CURRENT_TIMESTAMP;//SMC-3450
  //End SMC-3450
    $password = $firstName.'123';  
  //changes done by Pranali for SMC-3477 and SAND-1661 to display full name in message
  if($send_Ent_ID == 103)
  { 
    $sender_table = "tbl_teacher";
    $select = "t_complete_name,t_name,t_middlename,t_lastname,t_id,school_id";
    $tbl_point = "tbl_teacher_point";
    $point_insert_column = "sc_teacher_id,sc_entities_id,assigner_id,reason,sc_point,point_date,school_id,referral_id";
    $tbl_reward = "tbl_teacher";
    $user_id = "t_id";
 
        $invitation_sender_name_sql = $this->Webservices_model->inv_send_name_teacher($select,$sender_table,$send_Mem_ID);
           // print_r($invitation_sender_na me_sql);exit;
   
       $complete_name1          = $invitation_sender_name_sql[0]->t_complete_name;
       $invitation_sender_name  = $invitation_sender_name_sql[0]->t_name;
       $fn                      = $invitation_sender_name_sql[0]->t_name;
       $mn                      = $invitation_sender_name_sql[0]->t_middlename;
       $ln                      = $invitation_sender_name_sql[0]->t_lastname;
       $school_id               = $invitation_sender_name_sql[0]->school_id;
       $id_prn                  = $invitation_sender_name_sql[0]->t_id; 
       
        if(empty($invitation_sender_name))
                {
                     $invitation_sender_name =  $fn." ".$mn." ".$ln;
                }
 
  }
  else if($send_Ent_ID == 105)
  {
    $sender_table = "tbl_student";
    $select ="std_complete_name,std_name,std_Father_name,std_lastname,std_PRN,school_id";
    $tbl_reward = "tbl_student_reward";
    $tbl_point = "tbl_student_point";
    $point_insert_column = "sc_stud_id, sc_entites_id, sc_teacher_id, reason,sc_point, point_date,school_id,referral_id";
    $user_id = "sc_stud_id"; 
        
        $invitation_sender_name_sql = $this->Webservices_model->inv_send_name_student($select,$sender_table,$send_Mem_ID);
             //print_r($invitation_sender_name_sql);exit;
           
           $complete_name1          = $invitation_sender_name_sql[0]->std_complete_name;
           $invitation_sender_name  = $complete_name1;
           $fn                      = $invitation_sender_name_sql[0]->std_name;
           $mn                      = $invitation_sender_name_sql[0]->std_Father_name;
           $ln                      = $invitation_sender_name_sql[0]->std_lastname;
           $school_id               = $invitation_sender_name_sql[0]->school_id;
           $id_prn                  = $invitation_sender_name_sql[0]->std_PRN; 

            if(empty($invitation_sender_name))
                    {
                         $invitation_sender_name =  $fn." ".$mn." ".$ln;
                    }
         
  }
  else
  { 
        
    $sender_table = "tbl_sponsorer";
    $select = "sp_name"; 
 
        $invitation_sender_name_sql = $this->Webservices_model->inv_send_name_spo($select,$sender_table,$send_Mem_ID);
             //print_r($invitation_sender_name_sql);exit;
        
        $invitation_sender_name = $invitation_sender_name_sql[0]->sp_name;  
          
    }  
     
    $points_query = $this->Webservices_model->points_que($sender_type,$receiver_type,$req_status);
        //print_r($points_query);exit;
 
    $points = $points_query[0]->points;  
     
    $viral_link1 = $server_name."/core/Version3/accept_request_to_join_smartcookie.php?id=".base64_encode($send_Mem_ID)."&senderentity=".base64_encode($send_Ent_ID)."&receiverentity=".base64_encode($rec_Ent_ID)."&referral_id=".base64_encode($referral_id); 
             //print_r($viral_link1);exit;
 
  if(!($check_request_query || $check_request_query_two)) 
  {   
       // echo "testing12"; exit;
        
        $data = array(
            'sender_member_id'          => $send_Mem_ID,
            'sender_user_type'          => $sender_type,
            'receiver_country_code'     => $rec_Cont_Code,
            'receiver_mobile_number'    => $rec_Mob_number,
            'receiver_email_id'         => $rec_email_ID,
            'invitation_sent_datestamp' => $invitation_sent_datestamp,
            'acceptance_flag'           => $acceptance_flag,
            'method'                    => $platform_Sor,
            'receiver_user_type'        => $receiver_type,
            'firstname'                 => $firstName,
            'middlename'                => $middleName,
            'lastname'                  => $lastName,
            'referral_id'               => $referral_id
        );
        
 
    $referral_activity_log_query = $this->Webservices_model->chq_requst_int($data);
                    //print_r($referral_activity_log_query);exit;  
  
      if($referral_activity_log_query > 0)
      {    
        $Text=urlencode("You are requested by ".$inv_send_name." to join Smartcookie. Click on following link to join smartcookie ".$viral_link1." sent by ".$platform_Sor);  
        //changes end for SMC-3477 & SAND-1661 
                //print_r($Text);exit;
                
        $url="http://www.smswave.in/panel/sendsms.php?user=blueplanet&password=123123&sender=PHUSER&PhoneNumber=$rec_Mob_number&Text=$Text";
        file_get_contents($url); 
                //print_r($url);exit;

        $msgid='promoting_smartcookie';
 
                $res =  $GLOBALS['URLNAME']."/core/clickmail/sendmail.php?email=$rec_email_ID&msgid=$msgid&invitation_sender_name=$inv_send_name&viral_link=$viral_link1&platform_source=$platform_Sor&site=$server_name";
                    //print_r($res);exit;
     
                if($res)
 
        {
            $result_mail = 'mail sent successfully';
        } 
                
//                if($rec_Cont_Code != '91')
//        {  
//          $ApiVersion = "20100401";
//          // set our AccountSid and AuthToken
//          $AccountSid = "ACf8730e89208f1dfc6f741bd6546dc055";
//          $AuthToken = "45e624a756b26f8fbccb52a6a0a44ac9";
//          // instantiate a new Twilio Rest Client
//          $client = new TwilioRestClient($AccountSid, $AuthToken);
////          $number="+1".$phone;
//                    $number= "8668286925";
//          echo $message="You are requested by ".$inv_send_name." to join Smartcookie,student Teacher Reward program.click following link to join ".$viral_link1."sent through ".$platform_Sor.".";
//          $response = $client>request("/$ApiVersion/Accounts/$AccountSid/SMS/Messages",
//          "POST", array(
//          "To" => $number,
//          "From" => "7327987878",
//          "Body" => $message
//          )); 
//        } 
 
                
                $data = array( 
                   'sc_teacher_id'    => $id_prn,
                   'sc_entites_id'    => $rec_Ent_ID,
                   'reason'           => $req_status,
                   'sc_point'         => $points,
                   'point_date'       => CURRENT_TIMESTAMP,    
                   'school_id'        => $school_id,
                   'referral_id'      => $referral_id    
                ); 
                 
                foreach($data as $key=>$value)
                {
                    if(trim($value==''))
                    {
                        unset($data[$key]);
                    }
                } 
                 
                $point_insert_query = $this->Webservices_model->pot_inst_qury($tbl_point,$data); 
                        //print_r($point_insert_query);exit; 
                         
                $update_brown_points = $this->Webservices_model->update_brown_poits($points,$school_id,$user_id,$id_prn,$tbl_reward);  
                        //print_r($update_brown_points); exit; 
                         
                //if($update_brown_points == 0 && $send_Ent_ID ==105)
 
        if($update_brown_points > 0 && $send_Ent_ID ==105)
        {  
                    $data = array(
                        
                         'sc_stud_id'   => $id_prn,
                         'sc_date'      => CURRENT_TIMESTAMP,
                         'brown_point'  => $points,
                         'school_id'    => $school_id
                    );
                     
 
          $stu_rew = $this->Webservices_model->stu_reward_insert($data);
                    //print_r($stu_rew);exit;
                 
        }

        $postvalue['responseStatus']  = 200;
        $postvalue['responseMessage'] = "ok";
        $postvalue['posts'] = "Request submitted successfully"; 
                echo json_encode($postvalue);
        }
 
            }else if($check_request_query_two > 0)
            { 
                    $postvalue['responseStatus'] = 409;
                    $postvalue['responseMessage'] = "User Already Exists";
                    $postvalue['posts'] = null; 
                    echo json_encode($postvalue);
            }
            else if($check_request_query > 0)
            {
                    $postvalue['responseStatus'] = 208;
                    $postvalue['responseMessage'] = "User is Already Requested";
 
                    $postvalue['posts'] = null;  
 
                    echo json_encode($postvalue);
            }
            else
            {
                    $postvalue['responseStatus']=204;
                    $postvalue['responseMessage']="No Response";
                    $postvalue['posts']=null; 
                    echo json_encode($postvalue); 
            }

            }
            else
            {
                $postvalue['responseStatus'] = 1000;
                $postvalue['responseMessage'] = "Invalid Input";
                $postvalue['posts'] = null; 
                echo json_encode($postvalue); 
            }

 
 
     }*/
 
    public function feedBackRatingStudnetOnSubject_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $stu_id                = $obj['stu_feed_student_ID']; 
       $school_id             = $obj['stu_feed_school_id'];
       $teacher_id            = $obj['stu_feed_teacher_id']; 
       $stu_feed_subj_code    = $obj['stud_subjcet_code'];
       $subName               = $obj['stu_feed_subj']; 
       $acdmic_year           = $obj['stu_feed_academic_year'];
       $semester_id           = $obj['stu_feed_semester_ID'];
       $branch_id             = $obj['stu_feed_branch_ID'];  
       $dept_id               = $obj['stu_feed_dept_ID'];  
       $course_level          = $obj['stu_feed_course_level']; 
       $stufeedComment        = $obj['stu_feed_comment'];
       $is_manual             = $obj['is_manual'];  
       $stu_feed_div          = $obj['stu_feed_div']; 
       $stu_feed_class        = $obj['stu_feed_class']; 
 
       if($stu_id != '' and $school_id != '' and $subName != '' and $teacher_id != '')
       {
         
       $stuSubExt = $this->Webservices_model->checkStudentSubjectExt($stu_id,$school_id,$subName,$teacher_id);
            
       $stuSubExt =FALSE;
       if($stuSubExt === FALSE)
       {
            
           foreach($obj['stu_feedback'] as $v4)
               {  
                  $data = array( 
                   'stu_feed_student_ID'            => $stu_id,
                   'stud_subjcet_code'              => $stu_feed_subj_code, 
                   'stu_feed_subj'                  => $subName,  
                   'stu_feed_school_id'             => $school_id,
                   'stu_feed_teacher_id'            => $teacher_id, 
                   'stu_feed_academic_year'         => $acdmic_year,
                   'stu_feed_semester_ID'           => $semester_id,
                   'stu_feed_branch_ID'             => $branch_id, 
                   'stu_feed_dept_ID'               => $dept_id,
                   'stu_feed_course_level'          => $course_level,
                   'stu_feed_comment'               => $stufeedComment,
                   'stu_feed_que_ID'                => $v4['stu_feed_que_ID'],
                   'stu_feed_que'                   => $v4['stu_feed_que'],  
                   'stu_feed_points'                => $v4['stu_feed_points'],
                   'is_manual'                      => $is_manual,
                   'stu_feed_div'                   => $stu_feed_div,  
                   'stu_feed_class'                 => $stu_feed_class,


                 ); 


                                $queID = $v4['stu_feed_que_ID'];  //$school_id,$stu_id,$queID,$data 

                                $res = $this->Webservices_model->insertFeeedBackRatingOnSujectQue($data);
                                
                                //Assign_Reward_Points360_API called for inserting reward(brown) points for giving 360 feedback for SMC-4476 on 30-1-20
                                $url = base_url().'core/Version5/Assign_Reward_Points360_API.php';
                                $data = array('PRN_EmpID'=>$stu_id,'SchoolID'=>$school_id,'Entity_TypeID'=>'105','Key'=>'Students Feedback');
                                $result = $this->get_curl_result($url,$data);
                                

                    } 
  
                                if($res != 1)
                                        {
                                                      $response['status']  =  'success'; 
                                                      $response['message'] =  'feedback send successfully';

                                                      echo json_encode($response);    

                                        }else{
                                                      $response['status']  =  'failed'; 
                                                      $response['message'] =  'student feedback already given';

                                                      echo json_encode($response);   
                                             } 

           
        }else{ 
                  $response['status']  =  'failed'; 
                  $response['message'] =  'Subject already taken for feedback';

                  echo json_encode($response); 
             }
              
          
       }else{
           
                  $response['status']  =  'failed'; 
                  $response['message'] =  'Something is wrong';

                  echo json_encode($response); 
       }
        
    }
    
    
    public function getDataStudentFeedbackRating()
    { 
          
         $response = array();
         $result = $this->Webservices_model->getDataQueQuestion();   
         
         $response['status']  =  $result;  
 
         echo json_encode($response); 
         
    }
    
    public function teacherTeachingProcess_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true); 
 
        $school_id                     = $obj['feed360_school_id']; 
        $tea_id                        = $obj['feed360_teacher_id'];
        $sub_id                        = $obj['feed360_subject_name']; 
        $sub_code                      = $obj['feed360_subject_code'];  
        $acadmicYear                   = $obj['feed360_academic_year_ID']; 
        $semesterID                    = $obj['feed360_semester_ID'];
        $branchID                      = $obj['feed360_branch_ID']; 
        $deptID                        = $obj['feed360_dept_ID']; 
        $courseID                      = $obj['feed360_course_ID'];
        $classSchedule                 = $obj['feed360_classes_scheduled']; 
        $actualSchedule                = $obj['feed360_actual_classes'];  
        
                    $data = array( 
                        
                       'feed360_school_id'               => $school_id,
                       'feed360_teacher_id'              => $tea_id,
                       'feed360_academic_year_ID'        => $acadmicYear,
                       'feed360_semester_ID'             => $semesterID, 
                       'feed360_branch_ID'               => $branchID,
                       'feed360_dept_ID'                 => $deptID, 
                       'feed360_course_ID'               => $courseID,
                       'feed360_classes_scheduled'       => $classSchedule, 
                       'feed360_actual_classes'          => $actualSchedule, 
                       'feed360_subject_name'            => $sub_id,
                       'feed360_subject_code'            => $sub_code    
                   );
         
       $teaProExt = $this->Webservices_model->checkTeacherTeachingProcessExt($school_id,$tea_id,$acadmicYear,$semesterID,$branchID,$deptID,$courseID,$sub_id,$sub_code); 
 
       if($teaProExt === FALSE)
       { 
            $insTeaPro = $this->Webservices_model->insertTeacherTeachingProcessExt($data);

            //Assign_Reward_Points360_API called for inserting reward(brown) points for giving 360 feedback for SMC-4476 on 31-1-20
            $url = base_url().'core/Version5/Assign_Reward_Points360_API.php';
            $data1 = array('PRN_EmpID'=>$tea_id,'SchoolID'=>$school_id,'Entity_TypeID'=>'103','Key'=>'Teaching Process');
            $result = $this->get_curl_result($url,$data1);
          
                        if($insTeaPro)
                             {
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'teaching process insertion successfully';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'teaching process insertion failed';

                                      echo json_encode($response);   
                                  }  
 
        }else{  
           
         
                   //409 commented and 200 response added for successful edit by Pranali for SMC-3808 on 26-4-19
                  $response['status']  =  '409'; 
                  $response['message'] =  'Teacher already have a teaching process'; 
           
                  echo json_encode($response);
           
//                  $update = $this->Webservices_model->updateTeachingProcess($classSchedule,$actualSchedule,$data);
//                  if($update){ 
//                  $response['status']  =  '200'; 
//                  $response['message'] =  'Teacher teaching process updated successfully';
//                  echo json_encode($response); 
//                }
 
        }
 
    }
    
    //teachingProcessLog() created for logs by Pranali for SMC-3808 on 26-4-19
    public function teachingProcessLog() 
    { 
 
          $json = file_get_contents('php://input'); 
          $obj  = json_decode($json,true); 

          $teacherID = $obj['teacherID'];
          $schoolID  = $obj['schoolID'];

          $log = $this->Webservices_model->getTeachingProcessLog($teacherID,$schoolID);

          if($log){
                      $response['status']  =  $log; 
                      $response['message'] =  'Teacher teaching process log';
                      echo json_encode($response);
          }
 
          else{ 
          //if there is no data  
                      //$response['status']  =  '204'; 
 
                      $response['message'] =  'Teacher teaching process not available';
                      echo json_encode($response);
          }

    }

    //get values against schoolID
    public function schoolSemesterActivitySchoolID_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
         
       $semesterAct = $this->Webservices_model->fetchSchoolSemesterActivitiesData($schoolID);
        
                 if($semesterAct)
                    {
                                  $response['status']  =  $semesterAct;
                                  $response['message'] =  'semester activity list';

                                  echo json_encode($response);    

                    }else{
                                  $response['message']  =  'failed'; 

                                  echo json_encode($response);   
                         } 
 
       
    }
    
    
    //get values against schoolID
    public function schoolDeptList_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
         
       $schoolDeptList = $this->Webservices_model->schoolDeptList($schoolID);
        
                 if($schoolDeptList)
                    {
                                  $response['status']  =  $schoolDeptList;
                                  $response['message'] =  'school dept list';

                                  echo json_encode($response);    

                    }else{
                                  $response['message']  =  'failed'; 

                                  echo json_encode($response);   
                         } 
 
       
    }
    
    //get values against schoolID
    public function teachersListAgainstSchoolIDDept() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
       $deptCode = $obj['t_dept'];      
         
       $schoolTeacherList = $this->Webservices_model->teachersList($schoolID,$deptCode);
        
                 if($schoolTeacherList)
                    {
                                  $response['status']  =  $schoolTeacherList;
                                  $response['message'] =  'school teachers list';

                                  echo json_encode($response);    

                    }else{
                                  $response['message']  =  'failed'; 

                                  echo json_encode($response);   
                         } 
 
       
    }
    
    
    
    //get values for principle against schoolID 
    public function schoolPrincipleActivitySchoolID_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
         
       $prinAct = $this->Webservices_model->fetchSchoolPrincipleActivitiesData($schoolID);
        
                 if($prinAct)
                    {
                                  $response['status']  =  $prinAct;
                                  $response['message'] =  'principle activity list'; 
                                  echo json_encode($response);    

                    }else{
                                  $response['message']  =  'failed';   
                                  echo json_encode($response);   
                         } 
 
       
    }
    
    //get academic year and course leverl against schoolID 
    public function academicYearCourseLevelFeedback_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
         
       $acadYear = $this->Webservices_model->academicYearCourseLevelFeed($schoolID);
        
                 if($acadYear)
                    {
                                  $response['status']  =  $acadYear;
                                  $response['message'] =  'school academic year list'; 
                                  echo json_encode($response);    

                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         } 
 
       
    }
    
    
    //get values against schoolIDI
    public function getActivityAndSemesterList_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);
         
       $schoolID = $obj['school_id'];   
         
       $sem = $this->Webservices_model->getActivitiesAndSemester($schoolID);
 
                 if($sem)
                    {
                                  $response['status']  =   $sem;
                                  $response['message'] =   'semester activity list';

                                  echo json_encode($response);     

                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         }  
  
       
    }
    
    
    //get values against schoolIDI
    public function getActivityListSchoolID_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);
         
       $schoolID = $obj['school_id'];
        
       $actLevelID = $obj['act360_activity_level_ID'];      
         
       $activity = $this->Webservices_model->activitiesList($schoolID,$actLevelID);
        
                 if($activity)
                    {
                                  $response['status']  =   $activity;
                                  $response['message'] =   'activities list';

                                  echo json_encode($response);     

                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         }  
  
       
    }
     
    
    
     //get values against schoolID for HOD
    public function fetchAllDataHodAgainstSchoolID_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
         
       $schoolID = $obj['school_id'];  
         
       $ActData = $this->Webservices_model->fetchAllData_tbl_360_activities_data($schoolID);
        
                 if($ActData)
                    {
                                  $response['status']  =   $ActData;
                                  $response['message'] =   'semester activity list';

                                  echo json_encode($response);     

                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         } 
 
       
    }
    
     //get values against schoolID for principle
    public function fetchAllDataPrinAgainstSchoolID_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID = $obj['school_id'];  
         
       $PrinActData = $this->Webservices_model->fetchAllPrinData_tbl_360_activities_data($schoolID);
        
                 if($PrinActData)
                    {
                                  $response['status']  =   $PrinActData;
                                  $response['message'] =   'semester activity list';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         } 
 
       
    }
    
    //get values against schoolID for ACR
    public function fetchActivity_LevelAllDataAgainstSchoolIDLeverlID_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true); 
         
       $schoolID     = $obj['school_id']; 
       $sctLevID     = $obj['activity_level_id'];
       $empID        = $obj['t_id'];
       $empTypeID    = $obj['empID_type'];       
         
       $allLevelDataSID = $this->Webservices_model->fetchAllLevelData_tbl_360_activities_data($schoolID,$sctLevID,$empID,$empTypeID);
        
                 if($allLevelDataSID)
                    {
                                  $response['status']  =   $allLevelDataSID;
                                  $response['message'] =   'activity list';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         }  
    }   
 
    //hod insertion activity 
    public function hodGet360ActivitiesSchoolIDtID_V5() 
    {   
 
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);   // "CourseLevel": "UG",
 
        $semID                          = $obj['Semester_Id']; 
        $semName                        = $obj['Semester_Name']; 
        $tID                            = $obj['tID'];
        $recievedTid                    = $obj['recievertID'];
        $deptID                         = $obj['Dept_Id']; 
        $deptName                       = $obj['Department_Name']; 
        $schoolID                       = $obj['schoolID'];  
        $courseLevel                    = $obj['CourseLevel'];
        $actID                          = $obj['act360_ID']; 
        $actName                        = $obj['act360_activity']; 
        $activityLID                    = $obj['activity_level_id'];
        $actImage                       = $obj['act_img'];
        
       $items = array();
       foreach($actImage as $key=>$value)
       { 
           // define('UPLOAD_DIR', 'image/');
            $UPLOAD_DIR =  'image/';
            $img = $value;
            //$img = str_replace('data:image/jpeg;base64,', '', $img);
            //$img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = $UPLOAD_DIR . uniqid() . '.jpeg';
            $success = file_put_contents($file, $data);
            $success ? $file : 'Unable to save the file.'; 
           
            $str = str_replace("image/" , "" , "$file"); 
           
            $items[] = ltrim(base_url().'image/'.$str,','); 
       }
        
         $r = implode(",",$items); 
 
         $getCourID = $this->Webservices_model->getIdFromCourseLevel($schoolID,$courseLevel);
         
        foreach($getCourID as $key=>$value){ 
             if($value =='') 
                 unset($getCourID[$key]);
             else  
              $corLevelID = $value->id;
             
        }
        
        $branchIdName = $this->Webservices_model->getBranchIdBranchName($schoolID,$courseLevel,$deptName);
        
        foreach($branchIdName as $key=>$value){ 
             if($value =='') 
                 unset($branchIdName[$key]);
             else  
              $branchID   = $value->id;
              $branchName = $value->branch_Name; 
        } 
        
        $acdmcYear  = $this->Webservices_model->getAcademicYear($schoolID);
        
        
        
        foreach($acdmcYear as $key=>$value){ 
             if($value =='') 
                 unset($acdmcYear[$key]);
             else  
                 $acdYear   = $value->Academic_Year;
                 $acdYearId = $value->Year;
        }   
        
        
        $teaSenEmpType  = $this->Webservices_model->getTeacherEmpType($schoolID,$tID);
        
        foreach($teaSenEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teaSenEmpType[$key]);
             else  
                $senderEmpTeacher = $value->t_emp_type_pid; 
        }  
        
        
        $teaRecEmpType  = $this->Webservices_model->getRecTeacherEmpType($schoolID,$recievedTid);
        foreach($teaRecEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teaRecEmpType[$key]);
             else  
                $recEmpTeacher = $value->t_emp_type_pid; 
            
         //$t_complete_name reteived and inserted into tbl_360_activities_data by Pranali for SMC-4039 on 6-11-19
                if($value->t_complete_name!='' || $value->t_complete_name!=null)
                      $t_complete_name = $value->t_complete_name;
                else
                      $t_complete_name = $value->t_name." ".$value->t_middlename." ".$value->t_lastname;
              } 
        //activitiesList() called for credit points for particular activity level id by Pranali for SMC-4476 on 31-1-20      
        $activity_details  = $this->Webservices_model->activitiesList($schoolID,$activityLID); 

        foreach($activity_details as $key=>$value){ 
             if($value =='') 
                 unset($activity_details[$key]);
             else  
                $credit_points = $value->act360_credit_points; 
        }  

        $cTimestamp = $now = date('Y-m-d H:i:s'); 
 
                    $data = array( 
                        
                       'semesterID'                 => $semID,
                       'semester_name'              => $semName, 
                       'tID'                        => $tID,
                       'Receiver_tID'               => $recievedTid,  
                       'deptID'                     => $deptID,
                       'deptName'                   => $deptName, 
                       'schoolID'                   => $schoolID, 
                       'courselevel_name'           => $courseLevel, 
                       'activityID'                 => $actID,
                       'activity_name'              => $actName,
                       'activity_level_id'          => $activityLID,
                       'courselevel_ID'             => $corLevelID,
                       'branch_id'                  => $branchID,
                       'branch_name'                => $branchName,
                       'Academic_YearID'            => $acdYearId, 
                       'Academic_Year'              => $acdYear,
                       'Emp_type_id'                => $senderEmpTeacher,   
                       'Emp_type_id_receiver'       => $recEmpTeacher,
                       'created_date'               => $cTimestamp,
                       'updated_date'               => $cTimestamp,
                       'act_img'                    => $actImage,
                       'receiver_teacher_name'      => $t_complete_name,
                       'credit_point'               => $credit_points 
                   ); 
        
      foreach($data as $key=>$value)
        {
              if(trim($value) =='')
                unset($data[$key]); 
        } 
      $hodActExt = $this->Webservices_model->checkHodActExt($semID,$semName,$tID,$recievedTid,$deptID,$deptName,$schoolID,$corLevelID,$actID,$actName,$activityLID);
 
       if($hodActExt)
       { 
                  $response['status']  =  '409'; 
                  $response['message'] =  'Activity already exists';

                  echo json_encode($response); 
            
       }else{
       
                $insAct = $this->Webservices_model->insertHODactivities($data);
                
                //Assign_Reward_Points360_API called for inserting reward(brown) points for giving 360 feedback for SMC-4476 on 31-1-20
                if($activityLID=='1'){
                    $key = 'Departmental Activities';
                }else if($activityLID=='2')
                {
                  $key = 'Institute Activities';
                }
                else if($activityLID=='3')
                {
                  $key = 'Contribution to Society';
                }
                
                $url = base_url().'core/Version5/Assign_Reward_Points360_API.php';
                $data1 = array('PRN_EmpID'=>$tID,'SchoolID'=>$schoolID,'Entity_TypeID'=>'103','Key'=>$key);
                $result = $this->get_curl_result($url,$data1);  
                        if($insAct)
                             {
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'Insertion Success';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'Insertion failed';

                                      echo json_encode($response);   
                                  }  
              
               }
      
    }
    
    
    
    //insert ACR activities
    public function insertACRactvities_V5() 
    { 
       $json = file_get_contents('php://input');  
       $obj  = json_decode($json,true);
        
        $semID                              = $obj['Semester_Id']; 
        $semName                            = $obj['Semester_Name']; 
        $acadYear                           = $obj['academic_year']; 
        $tID                                = $obj['tID']; 
        $recievedTid                        = $obj['recievertID']; 
        $deptID                             = $obj['Dept_Id'];
        $deptName                           = $obj['Department_Name']; 
        $schoolID                           = $obj['schoolID']; 
        $courseLevel                        = $obj['CourseLevel']; 
        $actID                              = $obj['act360_ID']; 
        $actName                            = $obj['act360_activity'];  
        $activityLID                        = $obj['activity_level_id'];
        $rating                             = $obj['rating'];
         
        
        $getCourID = $this->Webservices_model->getIdFromCourseLevel($schoolID,$courseLevel);
         
        foreach($getCourID as $key=>$value){ 
             if($value =='') 
                 unset($getCourID[$key]);
             else  
                 $courseLevelID = $value->id;
             
        }
      
     
        $branchIdName = $this->Webservices_model->getBranchIdBranchName($schoolID,$courseLevel,$deptName);
        
       foreach($branchIdName as $key=>$value){ 
             if($value =='') 
                 unset($branchIdName[$key]);
             else  
                  $branchID = $value->id;
                  $branchName = $value->branch_Name;
             
        } 
        
        $teacherEmpType  = $this->Webservices_model->getTeacherEmpType($schoolID,$tID);
        
        foreach($teacherEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teacherEmpType[$key]);
             else  
                 $senderEmpTeacher = $value->t_emp_type_pid; 
        }  
        
         
        
        $teaRecEmpType  = $this->Webservices_model->getRecTeacherEmpType($schoolID,$recievedTid);
        foreach($teaRecEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teaRecEmpType[$key]);
             else  
                $recEmpTeacher = $value->t_emp_type_pid; 
        }  
        
        
        $cTimestamp = $now = date('Y-m-d H:i:s');
            
                    $data = array(  
                        
                       'semesterID'                 => $semID,
                       'semester_name'              => $semName, 
                       'tID'                        => $tID,
                       'Receiver_tID'               => $recievedTid,  
                       'deptID'                     => $deptID,
                       'deptName'                   => $deptName,
                       'schoolID'                   => $schoolID, 
                       'courselevel_name'           => $courseLevel, 
                       'activityID'                 => $actID,
                       'activity_name'              => $actName,
                       'activity_level_id'          => $activityLID,
                       'courselevel_ID'             => $courseLevelID,
                       'branch_id'                  => $branchID, 
                       'branch_name'                => $branchName, 
                       //'academic_year'              => $acadYear,
                       'Academic_Year'              => $acadYear, 
                       'Emp_type_id'                => $senderEmpTeacher,   
                       'Emp_type_id_receiver'       => $recEmpTeacher, 
                       'credit_point'               => $rating, 
                       'created_date'               => $cTimestamp,
                       'updated_date'               => $cTimestamp    
                     
                   );
        
        
        foreach($data as $key=>$value)
        {
              if(trim($value) =='')
                unset($data[$key]);
        }
 
       $extARCact = $this->Webservices_model->checkARCActExt($semName,$tID,$recievedTid,$deptName,$schoolID,$courseLevel,$branchName,$senderEmpTeacher,$recEmpTeacher,$actID,$actName,$activityLID);
 
       if($extARCact > 0) 
       { 
                  $response['status']  =  '409'; 
                  $response['message'] =  'ACR Activity already exists';

                  echo json_encode($response); 
            
       }else{
       
                $insARCact = $this->Webservices_model->insertARCactivities($data);
                //Assign_Reward_Points360_API called for inserting reward(brown) points for giving 360 feedback for SMC-4476 on 31-1-20
                                $url = base_url().'core/Version5/Assign_Reward_Points360_API.php';
                                $data1 = array('PRN_EmpID'=>$tID,'SchoolID'=>$schoolID,'Entity_TypeID'=>'103','Key'=>'ACR');
                                $result = $this->get_curl_result($url,$data1);

                        if($insARCact)
                             {
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'Insertion Success';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'Insertion failed';

                                      echo json_encode($response);   
                                  }  
               } 
    } 
    
    //principle insertion activity
    public function principleGet360ActivitiesSchoolIDtID_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
                
        $semID                          = $obj['Semester_Id']; 
        $semName                        = $obj['Semester_Name'];
        $actID                          = $obj['act360_ID']; 
        $actName                        = $obj['act360_activity'];  
        $tID                            = $obj['tID'];
        $recievedTid                    = $obj['Receiver_tID']; 
        $schoolID                       = $obj['schoolID']; 
        $deptID                         = $obj['Dept_Id']; 
        $deptName                       = $obj['Department_Name'];
        $branchID                       = $obj['Branch_ID']; 
        $branchName                     = $obj['Branch_name'];  
        $courseLevelID                  = $obj['CourseLevel'];
        $academicYearID                 = $obj['Academic_Year']; 
        $divID                          = $obj['div_id'];  
        $class                          = $obj['class'];  
        $actLevelID                     = $obj['activity_level_id'];  
 
        $teacherEmpType  = $this->Webservices_model->getTeacherEmpType($schoolID,$tID);
        
        foreach($teacherEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teacherEmpType[$key]);
             else  
                 $senderEmpTeacher = $value->t_emp_type_pid; 
        }  
        
        
        $teaRecEmpType  = $this->Webservices_model->getRecTeacherEmpType($schoolID,$recievedTid);
        foreach($teaRecEmpType as $key=>$value){ 
             if($value =='') 
                 unset($teaRecEmpType[$key]);
             else  
                $recEmpTeacher = $value->t_emp_type_pid; 
        }  
        
 
        $cTimestamp = $now = date('Y-m-d H:i:s');
 
                    $data = array( 
                        
                       'semesterID'                 => $semID,
                       'semester_name'              => $semName,
                       'activityID'                 => $actID,
                       'activity_name'              => $actName,  
                       'tID'                        => $tID, 
                       'Receiver_tID'               => $recievedTid,  
                       'schoolID'                   => $schoolID, 
                       'deptID'                     => $deptID,
                       'deptName'                   => $deptName, 
                       'branch_id'                  => $branchID,
                       'branch_name'                => $branchName,
                       'courselevel_ID'             => $courseLevelID,
                       'Academic_YearID'            => $academicYearID,
                       'Division_id'                => $divID, 
                       'Class'                      => $class, 
                       'activity_level_id'          => $actLevelID,
                       'Emp_type_id'                => $senderEmpTeacher,   
                       'Emp_type_id_receiver'       => $recEmpTeacher,
                       'created_date'               => $cTimestamp,
                       'updated_date'               => $cTimestamp           
 
                   );
         
       $prinActExt = $this->Webservices_model->checkPrinActExt($semID,$semName,$actID,$actName,$tID,$schoolID,$deptID,$deptName,$branchID,$branchName,$courseLevelID,$academicYearID,$divID,$class,$actLevelID);
        
        
       if($prinActExt)
       { 
                  $response['status']  =  '409'; 
                  $response['message'] =  'Activity already exists';

                  echo json_encode($response); 
            
       }else{
       
                $insPrinAct = $this->Webservices_model->insertPrinActivities($data);
          
                        if($insPrinAct)
                             {
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'Insertion Success';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'Insertion failed';

                                      echo json_encode($response);   
                                  }  
              
               }
      
    }
 
    //get fetch online course subjectlist
    public function fetchOnline_Course_SubjectList_V5() 
    {     
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $schoolID     = $obj['school_id']; 
       $scID         = $obj['sc_id'];
       $actType      = $obj['activity_type']; 
        
       $SubActivityList = $this->Webservices_model->fetchOnlineSclistForSubActivity($schoolID,$actType);     
       $sc_list = $SubActivityList[0]->id;       
       
       $OnlineCourSubList = $this->Webservices_model->fetchOnlineCoursesSubjectLIST($sc_list,$schoolID,$scID);
         
                 if($OnlineCourSubList)
                    {
                                  $response['status']  =   $OnlineCourSubList;
                                  $response['message'] =   'online subject list';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  'failed';  
                                  echo json_encode($response);   
                         } 
 
       
    } 
    
    
    public function fetchOnline_SubjectActivity_Achivement_V5() 
    {  
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
       $scID     = $obj['sc_id'];  
      
       $OnlineAchivement = $this->Webservices_model->fetchOnlineAchivementSubjectLIST($scID);
         
                 if($OnlineAchivement)
                    {
                                  $response['status']  =   $OnlineAchivement;
                                  $response['message'] =   '200';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  '404';  
                                  echo json_encode($response);   
                         } 
 
       
    }
    
    
    public function insertStudentOnlineCoursACTachivement_V5() 
    {   
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
 
        $sc_id                         = $obj['sc_id'];   ///sub activity
        $sc_list                       = $obj['sc_list'];
        $sc_type                       = $obj['sc_type'];  
        $schoolID                      = $obj['school_id'];  
        $sc_stu_ID                     = $obj['sc_stud_id']; 
        $branchID                      = $obj['Branch_ID'];
        $subject                       = $obj['subject']; 
        $subCode                       = $obj['Subject_Code']; 
        $semID                         = $obj['Semester_id'];
        $yearID                        = $obj['Year_ID']; 
        $courLevelID                   = $obj['Course_Level_PID'];  
        $deptID                        = $obj['Dept_id']; 
        $upBy                          = $obj['Uploaded_by'];
        $actType                       = $obj['activity_type'];   //online course
        $aDesc                         = $obj['a_desc']; 
        $a_alloPoint                   = $obj['a_alloc_points'];
    
        
                    $data = array(  
                        
                       'sc_id'                 => $sc_id, 
                       'sc_list'               => $sc_list,
                       'sc_type'               => $sc_type,
                       'school_id'             => $schoolID, 
                       'sc_stud_id'            => $sc_stu_ID,
                       'Branch_ID'             => $branchID, 
                       'subject'               => $subject,
                       'Subject_Code'          => $subCode, 
                       'Semester_id'           => $semID,
                       'Year_ID'               => $yearID,
                       'Course_Level_PID'      => $courLevelID,
                       'Dept_id'               => $deptID,
                       'Uploaded_by'           => $upBy,
                       'activity_type'         => $actType,
                       'a_desc'                => $aDesc, 
                       'a_alloc_points'        => $a_alloPoint,
                       'point_date'            => CURRENT_TIMESTAMP      
                        
                   );
        
        foreach($data as $key=>$value)
        {
              if(trim($value) =='')
                unset($data[$key]);
        }
        
     
       $teaProExt = $this->Webservices_model->checkStuOnlineCourSubLISTexist($sc_id,$sc_list,$sc_type,$schoolID,$sc_stu_ID,$subject,$actType,$aDesc); 
        
       if($teaProExt === FALSE)
       { 
           
           $fetchReward = $this->Webservices_model->fetchDataFromRewardPoint($schoolID,$sc_stu_ID);
           
           foreach($fetchReward as $row)
           {
                $rePext = $row->sc_total_point + $a_alloPoint;
              
                $upd = $this->Webservices_model->updateGreenRewardPoints($rePext,$schoolID,$sc_stu_ID);
                            
           }
                       
           
           
            $ins = $this->Webservices_model->insertStuPointsOnlineCourse($data);
          
                        if($ins)
                             { 
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'Points Insertion successfully';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'Points Insertion failed';

                                      echo json_encode($response);   
                                  }  
 
        }else{  
           
         
                   //409 commented and 200 response added for successful edit by Pranali for SMC-3808 on 26-4-19
                  $response['status']  =  '409'; 
                  $response['message'] =  'Student Already Taken The Points'; 
           
                  echo json_encode($response);
           
//                  $update = $this->Webservices_model->updateTeachingProcess($classSchedule,$actualSchedule,$data);
//                  if($update){ 
//                  $response['status']  =  '200'; 
//                  $response['message'] =  'Teacher teaching process updated successfully';
//                  echo json_encode($response); 
//                }

 
           
        }

    }
    
    
    public function fetchDataFromtbl_student_point_V5() 
    { 
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
      
       $scType        = $obj['sc_type'];
       $schoolID      = $obj['school_id'];
       $sc_studID     = $obj['sc_stud_id'];    
      
       $fetchData = $this->Webservices_model->fetchAllDataFROMstudentPoint($scType,$schoolID,$sc_studID);
         
                 if($fetchData)
                    {
                                  $response['status']  =   $fetchData;
                                  $response['message'] =   '200';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  '404';  
                                  echo json_encode($response);   
                         } 
 
       
    }
  
    public function sponsor_payment_V5()
    { 
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true); 
      
                    $custName                      = $obj['cust_name'];    
                    $custAdd                       = $obj['cust_address'];
                    $custCity                      = $obj['cust_city'];  
                    $custZipCode                   = $obj['cust_zip_code'];  
                    $custState                     = $obj['cust_state']; 
                    $custCountry                   = $obj['cust_country'];
                    $custCountryCode               = $obj['cust_country_Code']; 
                    $custEmail                     = $obj['cust_email']; 
                    $custSchoolID                  = $obj['cust_school_id'];
                    $custID                        = $obj['cust_id'];    
                    $custCouponID                  = $obj['cust_coupon_id'];  
                    $custProCode                   = $obj['cust_product_code'];
                    $custEntID                     = $obj['cust_entity_id'];  
                    $custSponsorID                 = $obj['cust_sponsor_id'];  
                    $custSponsorName               = $obj['cust_sponsor_name'];
                    $custSponsorAdd                = $obj['cust_sponsor_address'];   
                    $custSonsorCity                = $obj['cust_sponsor_city']; 
                    $custSponsorCountry            = $obj['cust_sponsor_country'];
                    $custSponsorCountryCode        = $obj['cust_sponsor_country_code']; 
                    $custSponsorState              = $obj['cust_sponsor_state'];
                    $custSponsorEmail              = $obj['cust_sponsor_email'];
                    $custSponsorPhone              = $obj['cust_sponsor_phone']; 
                    $custActualAmt                 = $obj['cust_actual_amount'];
                    $custPaidAmt                   = $obj['cust_paid_amount'];
                    $custDisPer                    = $obj['cust_discount_per']; 
                    $custPayMode                   = $obj['cust_pay_mode'];
                    $custPayStatus                 = $obj['cust_pay_status'];
                    $custPayTransID                = $obj['cust_pay_trans_id'];
                    $cust_date_time                = date("Y-m-d h:i:s");
        
       
                    $data = array(   
                       
                        'cust_name'                      => $custName,
                        'cust_address'                   => $custAdd,
                        'cust_city'                      => $custCity,
                        'cust_zip_code'                  => $custZipCode,
                        'cust_state'                     => $custState,
                        'cust_country'                   => $custCountry,
                        'cust_country_Code'              => $custCountryCode,
                        'cust_email'                     => $custEmail,
                        'cust_school_id'                 => $custSchoolID,
                        'cust_id'                        => $custID,               
                        'cust_coupon_id'                 => $custCouponID,
                        'cust_product_code'              => $custProCode,
                        'cust_entity_id'                 => $custEntID,
                        'cust_sponsor_id'                => $custSponsorID,
                        'cust_sponsor_name'              => $custSponsorName,         
                        'cust_sponsor_address'           => $custSponsorAdd,
                        'cust_sponsor_city'              => $custSonsorCity,
                        'cust_sponsor_country'           => $custSponsorCountry,
                        'cust_sponsor_country_code'      => $custSponsorCountryCode,
                        'cust_sponsor_state'             => $custSponsorState,
                        'cust_sponsor_email'             => $custSponsorEmail,
                        'cust_sponsor_phone'             => $custSponsorPhone,
                        'cust_actual_amount'             => $custActualAmt,
                        'cust_paid_amount'               => $custPaidAmt,
                        'cust_discount_per'              => $custDisPer,
                        'cust_pay_mode'                  => $custPayMode,
                        'cust_pay_status'                => $custPayStatus,
                        'cust_pay_trans_id'              => $custPayTransID,
                        'cust_date_time'                 => $cust_date_time 
                        
                   );
        
         
        
        
        foreach($data as $key=>$value)
        {
              if(trim($value) =='')
                unset($data[$key]);
        }
        
        
        
//    $payMet = $this->Webservices_model->checkPaymentUserExists($custID,$custCouponID,$custSchoolID,$custCity,$custState,$custCountry,$custSponsorID,$custSonsorCity,$custSponsorState,$custSponsorCountry); 
//       
//       if($payMet === FALSE)
//       { 
          
           
            $ins = $this->Webservices_model->insertPaymentTeacherStudentToSponsor($data);
          
                        if($ins > 0)
                             { 
                                      $response['status']  =  '200'; 
                                      $response['message'] =  'Payment Successful';

                                      echo json_encode($response);    

                              }else{
                                      $response['status']  =  '204'; 
                                      $response['message'] =  'Payment Failed';

                                      echo json_encode($response);   
                                  }  
 
//        }else{  
//           
//         
//                   //409 commented and 200 response added for successful edit by Pranali for SMC-3808 on 26-4-19
//                  $response['status']  =  '409'; 
//                  $response['message'] =  'Transaction already done'; 
//           
//                  echo json_encode($response);
// 
// 
//           
//        }
        
        $update = $this->Webservices_model->updatePaymentTeacherStudentToSponsorCoupon($custCouponID,$custSponsorID);
         
        
    }
    
    public function fetch_sponsor_payment_V5() 
    { 
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
  
       $schoolID      = $obj['school_id'];
       $custID        = $obj['cust_id'];    
      
       $fetchData = $this->Webservices_model->fetchAllTeaStuPaymentData($schoolID,$custID);
         
                 if($fetchData)
                    {
                                  $response['status']  =   $fetchData;
                                  $response['message'] =   '200';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  '404';  
                                  echo json_encode($response);   
                         } 
 
       
    }
    
    public function payment_getway_setting_fetchData_V5() 
    { 
       $json = file_get_contents('php://input'); 
       $obj  = json_decode($json,true);  
   
       $fetchData = $this->Webservices_model->fetchAllTeaStuPaymentGetwayData();
         
                 if($fetchData)
                    {
                                  $response['status']  =   $fetchData;
                                  $response['message'] =   '200';
 
                                  echo json_encode($response);    
 
                    }else{
                                  $response['message']  =  '404';  
                                  echo json_encode($response);   
                         } 
 
       
    }
//get_curl_result() added by Pranali for SMC-4476 on 30-1-20
  public function get_curl_result($url,$data)
  {
    $ch = curl_init($url);
    $data_string = json_encode($data);    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));
    $result = json_decode(curl_exec($ch),true);
    return $result;
  }
 
//    public function fetchTeacherStudentListSchoolID_V5() 
//    {     
//       $json = file_get_contents('php://input'); 
//       $obj  = json_decode($json,true);
//         
//        
//       $schoolID        = $obj['school_id'];
//       $key             = $obj['key']; 
//       $sub             = $obj['subject'];
//       $offset          = $obj['offset'];    
//       $courLevel       = $obj['courseLevel'];   
//       $deptID          = $obj['department'];   
//       $branch          = $obj['branch'];   
//       $sem             = $obj['semester'];   
//       $div             = $obj['division'];
//        
//        $fetchData = $this->Webservices_model->fetchAllDataFROMstudentTeacherList($schoolID,$key,$sub,$courLevel,$deptID,$branch,$sem,$div);
//        
//        print_r($fetchData);exit;
//        
//        
//        
//        if($key == 'Student')
//        {
//            if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '' )
//                {
//                     $fetchData = $this->Webservices_model->fetchAllDataFROMstudentTeacherList($schoolID,$key,$sub,$courLevel,$deptID,$branch,$sem,$div);
//
//                }else{  
//
//                     $fetchData = $this->Webservices_model->fetchAllDataFROMstudentTeaStuList($schoolID,$key,$sub);     
//                }
//        }
//        
////        else if($key == 'Teacher'){
////            
////               if($courLevel != '' || $deptID != '' || $branch != '' || $sem != '' || $div != '' )
////                {
////                     $fetchData = $this->Webservices_model->fetchAllDataFROMstudentTeacherList($schoolID,$key,$sub,$courLevel,$deptID,$branch,$sem,$div);
////
////                }else{
////
////                     $fetchData = $this->Webservices_model->fetchAllDataFROMstudentTeaStuList($schoolID,$key,$sub);     
////                }
////        }
//        
//        
//        
//        print_r($fetchData);exit;
//        
//           
//        
//       
//        
//        
//        
//        
//        
//        
////        // define how many result you want per page
////       $per_page_results = 50;  
////      
////                   $sql1 = "SELECT school_name,scadmin_state,school_id,COUNT(activity_level_id) AS activities,Academic_YearID from tbl_360_activities_data ad join tbl_school_admin on ad.schoolID=tbl_school_admin.school_id WHERE activity_level_id = 3 group by school_id"; 
////                   
////       $que = mysql_query($sql1); 
////                   
////       $a = 0;
////    
////      while($r = mysql_fetch_assoc($que))
////       {   
////           $a++; 
////       } 
////                   
////       $number_of_total_results = $a; 
////
////       // determine number of total pages are available
////       //whole number using php function ceil
////       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
////                   
////                   
////                               if(!isset($_GET['page']))
////                                {
////                                    $page = 1;
////                                    
////                                }else{
////                                    
////                                    $page = $_GET['page'];
////                                }           
////                   
////                   
////                                 $this_page_first_result = ($page-1)*$per_page_results; 
////    
////                    $sql = ("SELECT school_name,scadmin_state,school_id,COUNT(activity_level_id) AS activities,Academic_YearID from tbl_360_activities_data ad join tbl_school_admin on ad.schoolID=tbl_school_admin.school_id WHERE activity_level_id = 3 group by school_id LIMIT " . $this_page_first_result . ',' .$per_page_results); 
//        
//        
//        
//        
//        
//        
//        
//        
//         
//                 if($fetchData)
//                    {
//                                  $response['status']  =   $fetchData;
//                                  $response['message'] =   '200';
// 
//                                  echo json_encode($response);    
// 
//                    }else{
//                                  $response['message']  =  '404';  
//                                  echo json_encode($response);   
//                         } 
// 
//       
//    }
//    
    
     
}