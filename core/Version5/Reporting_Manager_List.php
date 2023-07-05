<?php  
/*
Author : Pranali Dalvi
Date : 16-1-20
This API was created for displaying Reporting Manager List to Employee / Manager according to reporting_manager_id
*/
$json = file_get_contents('php://input');
$obj = json_decode($json);

$format = 'json'; //xml is the default

include '../conn.php';

function msort($array, $key, $sort_flags = SORT_REGULAR) {
    if (is_array($array) && count($array) > 0) {
        if (!empty($key)) {
            $mapping = array();
            foreach ($array as $k => $v) {
                $sort_key = '';
                if (!is_array($key)) {
                    $sort_key = $v[$key];
                } else {
                    // @TODO This should be fixed, now it will be sorted as string
                    foreach ($key as $key_key) {
                        $sort_key .= $v[$key_key];
                    }
                    $sort_flags = SORT_STRING;
                }
                $mapping[$k] = $sort_key;
            }
            arsort($mapping, $sort_flags);
            $sorted = array();
            foreach ($mapping as $k => $v) {
                $sorted[] = $array[$k];
            }
            return $sorted;
        }
    }
    return $array;
}

$site=$GLOBALS['URLNAME'];
$ORG_ID =  xss_clean(mysql_real_escape_string($obj->{'ORG_ID'}));
$Employee_ID =  xss_clean(mysql_real_escape_string($obj->{'Employee_ID'}));
$Entity_Type =  xss_clean(mysql_real_escape_string($obj->{'Entity_Type'}));
$UpDown_key =  xss_clean(mysql_real_escape_string($obj->{'UpDown_key'}));


   if($ORG_ID!='' && $Employee_ID!='' && $Entity_Type!='' && $UpDown_key!='')
   {      
      if($Entity_Type=='103' || $Entity_Type=='105'){
            $postvalue['responseStatus']=1000;
            $postvalue['responseMessage']="Invalid Input";
            $postvalue['posts']=null;

            header('Content-type: application/json');
            echo  json_encode($postvalue); exit;
      }
      else{
         switch ($Entity_Type) {
            case '205':
                        $Reportingmanager = mysql_query("SELECT reporting_manager_id FROM tbl_student WHERE std_PRN='$Employee_ID' AND school_id='$ORG_ID'");
                        break;
            
            case '203':
                        $Reportingmanager = mysql_query("SELECT reporting_manager_id,t_emp_type_pid FROM tbl_teacher WHERE t_id='$Employee_ID' AND school_id='$ORG_ID'");
               break;
      }
      $reporting_manager = mysql_fetch_assoc($Reportingmanager);
      $reporting_manager_id = $reporting_manager['reporting_manager_id'];
      $emp_type_pid = $reporting_manager['t_emp_type_pid'];

      if($Entity_Type=='203' && $UpDown_key=='Up'){ //Manager up
         
         $sql=mysql_query("SELECT t.t_id as id,t.school_id,t.reporting_manager_id,(CASE
            WHEN t.t_complete_name='' THEN CONCAT_WS(' ',t.t_name,t.t_middlename,t.t_lastname) ELSE t.t_complete_name END) as name 
            FROM tbl_teacher t
            WHERE t.school_id='$ORG_ID' AND t.t_id='$reporting_manager_id' AND t.t_emp_type_pid>$emp_type_pid"); 

      }
      else if($Entity_Type=='203' && $UpDown_key=='Down'){ //Manager and Employee down
   
         //fetch all managers which have reporting manager id as logged in employee id of manager
         $sql=mysql_query("SELECT t.t_id as id,t.school_id,t.reporting_manager_id,(CASE
            WHEN t.t_complete_name='' THEN CONCAT_WS(' ',t.t_name,t.t_middlename,t.t_lastname) ELSE t.t_complete_name END) as name 
            FROM tbl_teacher t           
            WHERE t.school_id='$ORG_ID' AND reporting_manager_id='$Employee_ID' AND t.t_emp_type_pid<$emp_type_pid");
         
         //fetch all employees which have logged in employee id of manager as reporting manager id of the employee   
         $sql1=mysql_query("SELECT std_PRN as id,school_id,reporting_manager_id,(CASE
            WHEN std_complete_name='' THEN CONCAT_WS(' ',std_name,std_Father_name,std_lastname) ELSE std_complete_name END) as name 
            FROM tbl_student
            WHERE school_id='$ORG_ID' AND reporting_manager_id='$Employee_ID'");
      }
      else if($Entity_Type=='205' && $UpDown_key=='Up'){
//Manager up
         $sql=mysql_query("SELECT t.t_id as id,t.school_id,t.reporting_manager_id,(CASE
            WHEN t.t_complete_name='' THEN CONCAT_WS(' ',t.t_name,t.t_middlename,t.t_lastname) ELSE t.t_complete_name END) as name 
            FROM tbl_teacher t           
            WHERE t.school_id='$ORG_ID' AND t.t_id='$reporting_manager_id'");
      }
}

         $posts = array();
         $cnt = mysql_num_rows($sql);
         $cnt1 = mysql_num_rows($sql1);
// id and name taken as common o/p parameter for Employee and Manager for SMC-4432 on 6-3-20        
      if($cnt>0 || $cnt1>0) 
      {   
         if($cnt>0)
         {
            while($post = mysql_fetch_assoc($sql)) {
                     $posts[] = array('id'=>$post['id'],'school_id'=>$post['school_id'],'reporting_manager_id'=>$post['reporting_manager_id'],'name'=>$post['name'],'key'=>'Manager');
                  }
                  
         }
         if($cnt1>0)
         {
            while($post1 = mysql_fetch_assoc($sql1)) {
                     $posts[] = array('id'=>$post1['id'],'school_id'=>$post1['school_id'],'reporting_manager_id'=>$post1['reporting_manager_id'],'name'=>$post1['name'],'key'=>'Employee');
                  }
                  
         }
         $arrsort=msort($posts,array('reporting_manager_id'));
               $postvalue['responseStatus']=200;
               $postvalue['responseMessage']="OK";
               $postvalue['posts']=$arrsort;

      }
         else
         {
               $postvalue['responseStatus']=204;
               $postvalue['responseMessage']="No Record Found";
               $postvalue['posts']=null;
         }
}
   else
   {
      $postvalue['responseStatus']=1000;
      $postvalue['responseMessage']="Invalid Input";
      $postvalue['posts']=null;
           
   }
         header('Content-type: application/json');
         echo  json_encode($postvalue);  
         @mysql_close($link);
?>