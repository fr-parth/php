<html>
<head>
  
  </head>
  <body> 
<section class="content">

  <div class="container-fluid">

    <div class="row clearfix">
                    
      <div class="block-header" align="center" style="height: 40px;">
          <h2 style="font-size: 18px;">Student Feedback Summary </h2>
      </div>  
<div class="col-md-3" style="color:#700000;">
                        <a href="<?php echo base_url().'Teachers/my_feedback'; ?>"><button class="btn btn-primary" style="margin-top: -15px; margin-left:89px;">Back To My Feedback Report</button></a>
                    </div>
                                        
      <div class="panel panel-default" style="width: 75%;margin-left: 100px;margin-top: 50px;">
        <div class="panel-body">

          <form method="POST" action="">
            <table style="text-align: center;" width="100%" cellspacing="0" border="1">
            <thead style="height: 40px;background-color:#d8cf63;">
            <tr>
                
                <th style="text-align: left;padding: 0px 0px 0px 10px;width:10%;">Question ID </th>
                <th style="text-align: left;padding: 0px 0px 0px 10px;width:80%;">Questions</th>
                <th style="text-align: left;padding: 0px 0px 0px 10px;width:10%;"> points </th>
                
            </tr>
            </thead>
            <tbody>
              <?php
              $avgId=$this->input->post('avgId');
             foreach($feecbacksummary as $feedback){ 
               if(($feedback['stu_feed_que_id']=='3') || ($feedback['stu_feed_que_id']=='6'))
               {
             ?>
              <tr>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                <?php
                echo $feedback['stu_feed_que_id'];
                ?>

              </td>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                <?php
                echo $feedback['stu_feed_que'];
                ?>
              </td>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                 
              </td>
              
            </tr>
            <?php 
          }
          else{
          ?>
          <tr>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                <?php
                echo $feedback['stu_feed_que_id'];
                ?>

              </td>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                <?php
                echo $feedback['stu_feed_que'];
                ?>
              </td>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                 <?php
                echo $feedback['avgpoints'];
                ?>
              </td>
              
            </tr>
            <?php
          }
          } ?>
          <tr>
              <th colspan="2">Average</th>
              <td style="text-align: left; padding: 0px 0px 0px 10px;">
                <?php
                 
                        
                echo $avgId;
            
                ?>
              </td>
              </tr>
            </tbody>
            </table>

          </form>
         </div>   
     </div>
 </div>
</div>
</section>
</body>
</html>