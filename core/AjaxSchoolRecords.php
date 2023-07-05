<?php
require('conn.php');
                                    define('MAX_REC_PER_PAGE', 100); 
                                    $School_id = $_POST['school'];
                    
                                    if(isset($_POST['t_dept'])){
                                        $dept = $_POST['t_dept'];
                    $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name
                                                        FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE  sa.school_id='$School_id' AND t.t_dept='$dept' AND t.t_emp_type_pid IN ('133','134') AND t.error_records 
                                                        LIKE 'Correct' ORDER BY t.id";
                   }else{
                    $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, t.t_dept, sa.school_name
                                                        FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE  sa.school_id='$School_id' AND t.t_emp_type_pid IN ('133','134') AND t.error_records 
                                                        LIKE 'Correct' ORDER BY t.id";
                   }
                    // echo $sqln1."<br>";
                                    //getting count of total number of rows
                                    // $sqln1 = "SELECT t.id,t.t_id,t.t_complete_name,t.t_phone,t.t_email,t.t_internal_email,t.batch_id,t.send_unsend_status,t.email_status,t.school_id,t.t_country,t.sms_time_log,t.email_time_log, sa.school_name FROM tbl_teacher t LEFT JOIN tbl_school_admin sa ON t.school_id=sa.school_id WHERE sa.group_member_id='$group_member_id' AND t.t_emp_type_pid IN ('133','134') AND t.error_records LIKE 'Correct'";
                                                        // echo $sqln1; exit;
                                    $rs = mysql_query($sqln1);
               //mysql_num_rows added by Pranali for bug SMC-3096
                                    $total = mysql_num_rows($rs);
                                    // echo $total;
                                    $total_pages = ceil($total / MAX_REC_PER_PAGE);//diving total rows by 100
                                    $page = intval(@$_GET["page"]);
            
                                     if(0 == $page){
                                         $page = 1;
                                        }  
                                    $start = MAX_REC_PER_PAGE * ($page - 1);
                                    $max = MAX_REC_PER_PAGE;
                             
                                    $i=$start + 1;// for serial number
                                    $arr = mysql_query($sqln1." LIMIT $start, $max"); ?>
                                    
                                    <?php while ($row = mysql_fetch_array($arr)) {

                                                    $teacher_id = $row['t_id'];
                                    ?>
    <!--id for tr added by Pranali -->
                                    <tr id ='data<?php echo $teacher_id ?>' style="color:#808080;" class="active">
                                        <td data-title="Sr.No" style="width:4%;"><b><?php echo $i; ?></b></td>
                                        <td data-title="<?php echo $dynamic_teacher;?> ID" style="width:6%;"><b><?php echo $teacher_id; ?></b></td>
                                        <td data-title="First Name" style="width:12%;"><?php echo $row['t_complete_name']."(".$row['t_phone'].")" ?></td>
                                        <td data-title="Email" style="width:10%;">
                                        <?php  if($row['t_email']=="")
                                        {
                                            echo $row['t_internal_email'];
                                        }
                                        else
                                        {
                                            echo $row['t_email'];
                                            
                                        }?> </td>
                                        
                                        
                                        <td data-title="School Name" style="width:6%;"><?php echo $row['school_name']; ?> </td>
                                        
                                        <td data-title="Department" style="width:6%;"><?php echo $row['t_dept']; ?> </td>

                                        <td data-title="Send/Unsen Status" style="width:5%;"><?php
                                            if ($row['send_unsend_status'] == 'Send_SMS') {
                                                echo 'SMS sent';
                                            } elseif ($row['send_unsend_status'] == 'Unsend') {
                                                echo 'Unsent';
                                            }
                                            ?> </td>
                                        <td data-title="Send/Unsen Status" style="width:5%;"><?php
                                            if ($row['email_status'] == 'Send_Email') {
                                                echo 'Email sent';
                                            }   
                                            elseif ($row['email_status'] == 'Email sent') {
                                                echo 'Email sent';  
                                            } elseif ($row['email_status'] == 'Unsend') {
                                                echo 'Unsent';
                                            }
                                            ?> </td>
                                        <td ><?php echo "SMS :".$row['sms_time_log']."<br>Email :".$row['email_time_log'];?>
                                            
                                        </td>
                                        
                                        <td  data-title="Phone" style="width:10%;">


                                        <img src="../Images/S.png" onclick="confirmSMS('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['send_unsend_status'];?>','<?php echo $row['t_country']; ?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" >

                                        <img src="../Images/E.png" onclick="confirmEmail('<?php echo $row['school_id']; ?>','<?php if($row['t_email']=="")
                                            {
                                            echo $row['t_internal_email'];
                                            }
                                            else
                                            {
                                            echo $row['t_email'];
                                            } ?>','<?php echo $row['t_phone']; ?>','<?php echo $row['email_status'];?>','<?php echo $teacher_id; ?>','<?php echo $i;?>');" >
                                        </td>

                                    </tr>
                <?php $i++;
                                     } 
                                     ?>