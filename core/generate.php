<?php
include("cookieadminheader.php");

$report="";
if(isset($_POST['submit']))

{
$points=$_POST['points'];
$cards=$_POST['cards'];
$i=1;
while($i<=$cards)
{

//new date format for ticket SMC-3473 On 25Sept18
//$issue_date=date('d/m/Y');
$issue_date = CURRENT_TIMESTAMP;
$d=strtotime("+6 Months -1 day");
//$validity=date("d/m/Y",$d);
$validity=date("Y-m-d H:i:s",$d);

$chars = "0123456789";
$coupon_id = substr( str_shuffle( $chars ), 0, 10 );
$status="Unused";
$sql=mysql_query("insert into tbl_giftcards (card_no,amount,issue_date,valid_to,status)values('$coupon_id','$points','$issue_date','$validity','$status')");
$i++;


}
if($cards==1)
{
  $report1="$cards Card is generated successfully";
}
else {
  $report1="$cards Cards are generated successfully";
}


}




?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Generate Coupon</title>


<script>
function valid()
{

var points=document.getElementById('points').value;
var cards=document.getElementById('cards').value;

 var numbers = /^[0-9]+$/;
      if(points == 0)
      {
      document.getElementById('errorpoints').innerHTML='Invalid Amount';

      return false;
      }
    if(!(points.match(numbers)))
      {
      document.getElementById('errorpoints').innerHTML='Please Enter Valid Amount';

      return false;
      }
    else
    {
      
    }
    if(cards == 0)
      {
      document.getElementById('errorcards').innerHTML='Invalid Amount';

      return false;
      }
      if(!(cards.match(numbers)))
      {
      document.getElementById('errorcards').innerHTML='Please Enter Valid Cards Number';

      return false;
      }

}
</script>
</head>
<body>
</br>
<div class="row" style="padding-top:5px; color:#FF0000" align="center"><?php echo $report;?></div>
<div class="row" style="padding-top:5px; color:green" align="center"><?php echo $report1;?></div>
<div class="container" style="padding-top:50px;">

<div class="row">

<div class="col-md-1"></div>
<div class="col-md-10" style="border:1px solid #694489; transition: box-shadow 0.3s, border 0.3s; box-shadow: 0 0 5px 1px #969696;">
<h2 align="center">Generate Gift Cards</h2>

<form method="post">
<div class="row" style="padding-top:30px;">
<div class="col-md-3"></div>
<div class="col-md-3">Amount of Gift Card:</div>
<div class="col-md-3">
  <!--Below code updated by Rutuja Jori for changing maxlength of Amount of Gift Card on 28/11/2019 for SMC-4221-->
 <input type="text" name="points" id="points" placeholder="Enter Amount of Gift Card:" maxlength="7" class="form-control"/>
</div>


</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorpoints" style="color:#FF0000"></div></div>
<div class="row"  style="padding-top:20px;">
<div class="col-md-3"></div>
<div class="col-md-3">No.of Cards to Generate</div>
<div class="col-md-3" >
<input type="text" name="cards" id="cards" placeholder="Enter No.of Cards" maxlength="4" class="form-control"/></div>
</div>
<div class="row" style="padding-top:4px;"><div class="col-md-6"></div><div id="errorcards" style="color:#FF0000"></div></div>
<div class="row"  style="padding-top:40px;">
<div class="col-md-3"></div>
<div class="col-md-2"></div>
<div class="col-md-3" >
<input type="submit" name="submit" value="Generate" class="btn btn-primary" onclick="return valid();"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="generatecoupon.php" style="text-decoration:none"><input type="button" name="back" value="Back" class="btn btn-danger" ></div>
</div>


</form>






</div>



</div>


</div>

</body>
</html>
