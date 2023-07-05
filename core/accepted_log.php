<?php
/**
 * Created by PhpStorm.
 * User: Bpsi-Rohit
 * Date: 9/16/2017
 * Time: 4:19 PM
 */
include("cookieadminheader.php");
?>
<html>
<head>
    <style>
    h2:hover{
      color:#9F5F9F;
      font-size:40px;
      font-weight: bold;
      animation: fadein 5s;
      -moz-animation: fadein 2s; /* Firefox */
      -webkit-animation: fadein 2s; /* Safari and Chrome */
      -o-animation: fadein 2s; /* Opera */
    }
    @keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-moz-keyframes fadein { /* Firefox */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-webkit-keyframes fadein { /* Safari and Chrome */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-o-keyframes fadein { /* Opera */
    from {
        opacity:0;
    }
    to {
        opacity: 1;
    }
}
    </style>
</head>
  <body>
    <div class='container' align='center' style='font-style: oblique;margin-top:10%'>
      <div class="row">
        <div class='col-md-12'>
          <a href="used_coupon_log_student.php" style="text-decoration:none" ;>
                      <?php $row = mysql_query("select * from tbl_coupons where status='p' or status='no'");
                      $result = mysql_num_rows($row);
                      ?>
          <h2 style='color:#694489'><?php
		  //Camel casing for Used Coupon(SmartCookie) Students done by Pranali
		  echo "Used Coupon(SmartCookie) Students------------". $result; ?></h2><hr style='color: #f00;background-color: #694489;height: 3px;width:400px;margin-top:-8px'></a>
        </div>
        <div class='col-md-12'>
            <a href="coupon_log.php" style="text-decoration:none" ;>
              <?php
              $row1 = mysql_query("SELECT tc.status,tc.coupon_id,tc.user_id,tc.amount,tc.issue_date,t.t_complete_name,t.t_name,t.t_middlename,tc.issue_date,tc.validity_date,t.t_lastname FROM tbl_teacher_coupon tc join tbl_teacher t on t.id=tc.user_id where status='p' or status='no' order by tc.id DESC");
              $result1 = mysql_num_rows($row1);

              ?>

          <h2 style='color:#694489'><?php 
		  //Camel casing for Used Coupon(SmartCookie) Teacher done by Pranali
		  echo "Used Coupon(SmartCookie) Teacher------------". $result1; ?></h2><hr style='color: #f00;background-color: #694489;height: 3px;width:400px;margin-top:-10px'></a>
        </div>
        <div class='col-md-12'>
          <a href="use_vervder_coupon_for_student.php" style="text-decoration:none" ;>
            <?php $row = mysql_query("select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,s.id,s.std_complete_name from tbl_selected_vendor_coupons svc join tbl_student s join tbl_sponsorer sp on s.id=svc.user_id and svc.sponsor_id=sp.id where svc.used_flag='used' order by id DESC");
            $result = mysql_num_rows($row);
            ?>
            <h2 style='color:#694489'><?php   echo "Used Coupon(Vendor) Students------------". $result; ?></h2><hr style='color: #f00;background-color: #694489;height: 3px;width:400px;margin-top:-10px'></a>
        </div>
        <div class='col-md-12'>
          <a href="use_vervder_coupon_for_teacher.php" style="text-decoration:none" ;>
            <?php $row = mysql_query("select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,t.id,t.t_complete_name from tbl_selected_vendor_coupons svc join tbl_teacher t join tbl_sponsorer sp on t.id=svc.user_id and svc.sponsor_id=sp.id where svc.used_flag='used' order by id DESC");
            $result = mysql_num_rows($row);
            ?>
            <h2 style='color:#694489'><?php   echo "Used Coupon(Vendor) Teacher------------". $result; ?></h2><hr style='color: #f00;background-color: #694489;height: 3px;width:400px;margin-top:-10px'></a>
        </div>
      </div>
    </div>
  </body>

</html>


<!--<div class="row" style="padding-top:10px; width:100%;">

    <div style="padding-top:20px;">
        <div class="col-sm-1" style="padding-top:20px;"></div>

        <div class="container" style="color: #1a4a72;">

            <a href="used_coupon_log_student.php" style="text-decoration:none" ;>
                <div class="col-md-3 shadow radius"
                     style="background-color:#FFFFFF; border:1px solid #CCCCCC;margin-left:200px; margin-bottom:100px;margin-top: 100px;">
                    <h4 class="" align="center">Used Coupon(Smartcookie) Students </h4>
                    <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                        <?php $row = mysql_query("select * from tbl_coupons where status='p' or status='no'");
                        $result = mysql_num_rows($row);
                        echo $result;
                        ?>
                    </div>

                </div>
            </a>

            <a href="coupon_log.php" style="text-decoration:none" ;>
                <div class="col-md-3 shadow radius"
                     style="background-color:#FFFFFF; border:1px solid #CCCCCC;margin-left:300px; margin-bottom:100px;margin-top: 100px;">
                    <h4 class="" align="center">Used Coupon(Smartcookie) Teacher </h4>
                    <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                        <?php $row = mysql_query("SELECT tc.status,tc.coupon_id,tc.user_id,tc.amount,tc.original_point,tc.issue_date,t.t_complete_name,t.t_name,t.t_middlename,tc.issue_date,tc.validity_date,t.t_lastname FROM tbl_teacher_coupon tc join tbl_teacher t on t.id=tc.user_id where status='p' or status='no' order by tc.id DESC");
                        $result = mysql_num_rows($row);
                        echo $result;
                        ?>
                    </div>

                </div>
            </a>
        </div>
        <div class="container">
            <a href="use_vervder_coupon_for_student.php" style="text-decoration:none" ;>
                <div class="col-md-3 shadow radius"
                     style="background-color:#FFFFFF; border:1px solid #CCCCCC;margin-left:200px; margin-bottom:100px">
                    <h4 class="" align="center">Used Coupon( Vendor ) Students </h4>
                    <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                        <?php $row = mysql_query("select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,s.id,s.std_complete_name from tbl_selected_vendor_coupons svc join tbl_student s join tbl_sponsorer sp on s.id=svc.user_id and svc.sponsor_id=sp.id where svc.used_flag='used' order by id DESC");
                        $result = mysql_num_rows($row);
                        echo $result;
                        ?>
                    </div>

                </div>
            </a>

            <a href="use_vervder_coupon_for_teacher.php" style="text-decoration:none" ;>
                <div class="col-md-3 shadow radius"
                     style="background-color:#FFFFFF; border:1px solid #CCCCCC; margin-left:300px; margin-bottom:100px">
                    <h4 class="" align="center">Used Coupon( Vendor ) Teacher </h4>
                    <div align="center" style="font-size:54px;padding-left:5px;color:#308C00;font-weight:bold;">
                        <?php $row = mysql_query("select svc.code,svc.entity_id,svc.used_flag,svc.coupon_id,sp.sp_company,svc.school_id,svc.sponsor_id,svc.for_points,svc.valid_until,t.id,t.t_complete_name from tbl_selected_vendor_coupons svc join tbl_teacher t join tbl_sponsorer sp on t.id=svc.user_id and svc.sponsor_id=sp.id where svc.used_flag='used' order by id DESC");
                        $result = mysql_num_rows($row);
                        echo $result;
                        ?>
                    </div>

                </div>
            </a>
        </div>
    </div>
</div>-->
