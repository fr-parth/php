<?php

$json = file_get_contents('php://input');
$obj = json_decode($json);

	$school_id = $obj->{'school_id'};
	$entity_name = $obj->{'entity_key'};
    $limit=20;
    $input= $obj->{'input_id'};
    include 'conn.php';

       $schoolid = mysql_query("select id from tbl_school_admin where school_id='$school_id'");
       $res = mysql_fetch_array($schoolid);
       $School_running_id=$res['id'];
		if(!empty($school_id) && !empty($entity_name) && $input!='')
		{

		             if($entity_name=='REWARD_BLUE_POINT_TO_TEACHER')
					 {


                        	$arrs = mysql_query("select t.id,tp.sc_point,t_list,point_date,sc_teacher_id,t.t_complete_name from tbl_teacher_point tp
                             join tbl_teacher t on tp.sc_teacher_id = t.t_id join tbl_thanqyoupointslist on tbl_thanqyoupointslist.id=sc_thanqupointlist_id                                 where t.school_id='$school_id' ORDER BY tp.id DESC limit $limit offset $input");

                            	if(mysql_num_rows($arrs)>=1)
						        {
                    				while($teacher = mysql_fetch_array($arrs))
                    				{

                                        $posts[] = $teacher;

                          		    }
                          			$postvalue['responseStatus']=200;
                          			$postvalue['responseMessage']="OK";
                          			$postvalue['posts']=$posts;
                                    header('Content-type: application/json');
        							echo json_encode($postvalue);
                                }
                                else
                                {
                                     $postvalue['responseStatus']=204;
        							$postvalue['responseMessage']="Not Found";
        							$postvalue['posts']=null;
        							header('Content-type: application/json');
        							echo json_encode($postvalue);
                                 }

                      }

					 else if($entity_name=='REWARD_GREEN_POINT_TO_STUDENT')
					 {

                           	$query1=mysql_query("select s.id,sp.sc_list,s.std_PRN,s.std_complete_name,re.`sc_point`,re.`sc_entites_id`,re.`sc_studentpointlist_id`,re.`point_date`,re.`activity_type` from  tbl_student_point re inner join tbl_student s on re.sc_stud_id = s.std_PRN  and re.`school_id`=s.school_id inner JOIN tbl_studentpointslist sp on sp.sc_id=re.`sc_studentpointlist_id` where
 s.school_id='$school_id' AND  (`sc_entites_id` =  '$School_running_id' or `sc_entites_id` =  '$school_id') limit $limit offset $input");
						   while($value1 = mysql_fetch_array($query1))
						   {
						     $posts[] = $value1;

                  		    }
                  			$postvalue['responseStatus']=200;
                  			$postvalue['responseMessage']="OK";
                  			$postvalue['posts']=$posts;
                            header('Content-type: application/json');
        					echo json_encode($postvalue);

					 }

                     else if($entity_name=='DISTRIBUTE_GREEN_POINT_TO_TEACHER')
                      {




                                    $arrs = mysql_query("SELECT t.id,tp.t_list,t.t_id,t_complete_name, tc_balance_point, sc_point,st.point_date,st.assigner_id,
                                    st.sc_entities_id,st.reason FROM tbl_teacher t inner JOIN tbl_teacher_point st ON t.t_id = st.sc_teacher_id inner Join tbl_thanqyoupointslist tp on tp.id=st.`sc_thanqupointlist_id` WHERE t.school_id = '$school_id'  and (st.`assigner_id`='$school_id' or st.`assigner_id`='$School_running_id') and t.tc_balance_point!=0
                                        ORDER BY t.id limit $limit offset $input");



                            				while($teacher = mysql_fetch_array($arrs))
                            				{

                                              	 $posts[] = $teacher;
                                            }
                                                $postvalue['responseStatus']=200;
                                    			$postvalue['responseMessage']="OK";
                                    			$postvalue['posts']=$posts;
                                                header('Content-type: application/json');
        							            echo json_encode($postvalue);

				      }
                      else if($entity_name=='DISTRIBUTE_BLUE_POINT_TO_STUDENT')
                      {

                         $sql=mysql_query("Select id,std_PRN,std_name,std_Father_name,std_lastname,std_complete_name,used_blue_points,balance_bluestud_points from tbl_student where school_id='$school_id' order by std_complete_name,std_name ASC limit $limit offset $input");

						   while($value2 = mysql_fetch_array($sql))

						   {
						     $posts[] = $value2;

                  		    }
                  			$postvalue['responseStatus']=200;
                  			$postvalue['responseMessage']="OK";
                  			$postvalue['posts']=$posts;
                            header('Content-type: application/json');
        					echo json_encode($postvalue);
				      }
                      else if($entity_name=='SPONSOR')
                      {
                              	$arrs = mysql_query("select s.id ,s.sp_company,sp.Sponser_type,sp.Sponser_product,sp.points_per_product from tbl_sponsored sp join tbl_sponsorer s on s.id = sp.sponsor_id  ORDER BY sp.id limit $limit offset $input");

                				while($sponser = mysql_fetch_array($arrs))
                				{

                                     $posts[] = $sponser;

                  		        }
                                    $postvalue['responseStatus']=200;
                      			    $postvalue['responseMessage']="OK";
                      			    $postvalue['posts']=$posts;
                                    header('Content-type: application/json');
        							echo json_encode($postvalue);

                      }


                    else
						{

							$postvalue['responseStatus']=204;
							$postvalue['responseMessage']="Not Found";
							$postvalue['posts']=null;
							header('Content-type: application/json');
							echo json_encode($postvalue);
						}









		}else
			{

						$postvalue['responseStatus']=1000;
						$postvalue['responseMessage']="Invalid Input";
						$postvalue['posts']=null;

						header('Content-type: application/json');
						echo  json_encode($postvalue);


			}




  @mysql_close($con);

?>