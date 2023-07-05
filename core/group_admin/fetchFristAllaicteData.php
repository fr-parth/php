<?php 

include("../conn.php"); 
 
  $query = $_POST['query']; 
 
       $per_page_results = 50;  

       $sqlInd2 = ("SELECT * FROM aicte_ind_feedback_summary_report");

       $qu2Total = mysql_query($sqlInd2);  
                   
       $a = 0;
    
          while($row = mysql_fetch_assoc($qu2Total))
          {
              $a++;
          }


       $number_of_total_results = $a;  
       
       $number_of_pages =  ceil($number_of_total_results/$per_page_results);
                    
                   
                               if(!isset($_GET['page']))
                                {
                                    $page = 1;
                                    
                                }else{
                                    
                                    $page = $_GET['page'];
                                }           
                   
                   
                                 $this_page_first_result = ($page-1)*$per_page_results; 
           
           
                   $query = ("SELECT * FROM aicte_ind_feedback_summary_report  LIMIT " . $this_page_first_result . ',' .$per_page_results); 
                
                   $que = mysql_query($query); 
 
                   $output .= '
                   
                            <table class="table table-bordered text-center">
                            
                               <tr class="rowHeading">
                                  <th>Id</th>
                                  <th>Institute Id</th>
                                  <th>Institute Name</th>
                                  <th>Department Name</th>
                                  <th>Teacher Id</th>
                                  <th>Teacher Name</th> 
                                  <th>School State</th> 
                                  <th>Student Feedback</th>
                                  <th>Teaching Process</th>
                                  <th>Departmental Activities</th>
                                  <th>Institute Activities</th>
                                  <th>ACR</th>
                                  <th>Contribution To Society</th>
                                  <th>Total on 100</th>
                                  <th>Total on Scale 10</th>
                               </tr> ';
                   $i = 0;
                   while($row = mysql_fetch_assoc($que))
                    {  
                       $i++; 
                       
                       $total =$row['student_feedback']+$row['teaching_process']+$row['dept_activity'] +$row['inst_activity']+$row['acr']+$row['cont_society']; 
                       
                       $scaleTen = $total/10;
                       
                       $output .= '
                               
                               <tr>
                                   <td>'.$i.'</td>
                                   <td>'.$row['school_id'].'</td> 
                                   <td>'.$row['school_name'].'</td>
                                   <td>'.$row['dept_name'].'</td> 
                                   <td>'.$row['teacher_id'].'</td> 
                                   <td>'.$row['teacher_name'].'</td>
                                   <td>'.$row['scadmin_state'].'</td> 
                                   <td>'.$row['student_feedback'].'</td> 
                                   <td>'.$row['teaching_process'].'</td>
                                   <td>'.$row['dept_activity'].'</td>
                                   <td>'.$row['inst_activity'].'</td>
                                   <td>'.$row['acr'].'</td>
                                   <td>'.$row['cont_society'].'</td> 
                                   <td>'.$total.'</td>
                                   <td>'.round(($scaleTen),2).'</td>
                               </tr>
                       
                       '; 
                    }
                  
                           
             $output .= '</table>';
//             header("Content-Type:application/xls");
//             header("Content-Disposition: attachment; filename=download.xls");
             echo $output; 
       ?>   
                    
 
                            <?php 
      
                               echo '<ul class="pagination justify-content-end">';
                                
                                for($page=1; $page<=$number_of_pages; $page++)
                                   {
                                        
                                       echo "<li><a  href= 'ind_college_summary.php?page=". $page ." '>" . $page . "</a></li>";
                                   } 
      
                               echo '</ul>';
                                
                                ?>  
          
                   
         