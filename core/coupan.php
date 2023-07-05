<?php 

	 include("conn.php");
	 if(!isset($_SESSION['id']))
	 {
	 	header('Location:index.php');
	 }
 $query_points = mysql_query("select r.sc_total_point, r.sc_stud_id, r.sc_reward, s.std_name from tbl_student_reward r, tbl_student s where s.id = r.sc_stud_id and  sc_stud_id = ".$_SESSION['id']);
 $row_points = mysql_fetch_array($query_points);
 $amount = $row_points['sc_reward'];
 $std_name = $row_points['std_name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
 <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;
			window.location = "reward_process.php";
          
        }
    </script>
</head>

<body>
<div align="center">
 <form id="form1" runat="server">
<div id="div1" style="width:500px; height:250px; border:1px solid #CCCCCC; padding:10px 10px 10px 10px;">
<h1>REWARD COUPANS</h1>
<div><p style="font-size:21px; font-family:Arial, Helvetica, sans-serif;"> Presented to <i style="font-size:18px;"><?php echo $std_name;?></i></p></div>
<p style="font-size:21px;font-family:Arial, Helvetica, sans-serif;">Amount <i style="font-size:18px;"><?php echo $amount;?> $</i></p>
<p style="font-size:21px;font-family:Arial, Helvetica, sans-serif;">Specific Information <i style="font-size:18px;"></i></p>

</div>
<div style="padding-top:30px;"><input type="button" value="Print" onclick="javascript:printDiv('div1')"/></div>
</form>
</div>
</body>
</html>