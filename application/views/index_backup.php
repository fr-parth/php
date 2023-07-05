<?php
$url_old='core/login.php';
//$url_new='http://test.smartcookie.in/Welcome/login/';
$url_new=base_url('Clogin/login/');


///phpinfo();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Smart Cookie::</title>
    <link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css"rel="stylesheet">
    <script src="<?php echo base_url();?>Assets/js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>

    <link href="<?php echo base_url();?>Assets/css/sc_style2.css"rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <style>
        body{
            background-color:#fff;
        }
        .aln{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .add{
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .addli1{
            float: left;
        }
		option{
			background-color:white;
			color:black;
		}
		
    </style>
	<script>
		function changeMessage(){
			var entity = document.getElementById('entity').value;
			
			if(entity==2 || entity==10 || entity==5 || entity==1 || entity==11 || entity==7 || entity==6 || entity==12 || entity==8)
			{
				var url = "<?php echo $url_old; ?>";
				document.loginform.action = url;
				document.forms["loginform"].submit();
			}
			else if(entity=='student' || entity=='employee' || entity=='sponsor' || entity=='salesperson'){
				var url = "<?php echo $url_new; ?>";
				document.loginform.action = url+'/'+entity;
				document.forms["loginform"].submit();
			}

		}
	</script>
</head>
<body>
<div class="row1 header bg-wht">
    <div class='container'>
        <div class="row" style="padding-top:20px;" >
            <div class="col-md-7 visible-sm visible-lg visible-md">
                <img src="<?php echo base_url();?>images/250_86.png" />
            </div>
            <div class="col-md-7 visible-xs">
                <img src="<?php echo base_url();?>images/220_76.png" />
            </div>
            <div class='col-md-2'>
                <a class="btn btn-primary" href="core/express_registration_sp.php" >Registration</a>
            </div>
            <div class="col-md-3" >
                <div class="btn-group">
				<form method="POST" name='loginform' id='loginform'>
					<select onchange="changeMessage()" id='entity' name='entity' class="btn btn-primary" style='width:70%'>
					  <option value="">Login</option>
					  <option value="student">Student</option>
					  <option value="employee">Employee</option>
					  <option value="2">Teacher</option>
					  <option value="10">Manager</option>
					  <option value="sponsor">Sponsor</option>
					  <option value="5">Parent</option>
					  <option value="1">School Admin</option>
					  <option value="11">HR Admin</option>
					  <option value="7">School Staff</option>
					  <option value="6">Cookie Admin</option>
					  <option value="12">Group Admin</option>
					  <option value="8">Cookie Staff</option>
					  <option value="salesperson">Sales Person</option>
					  
					</select>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$server_name = $_SERVER['SERVER_NAME'];

Switch($server_name)
{

    case "tsmartcookies.bpsi.us":

        ?><h2 style='text-align: center;font: italic bold 30px/30px Georgia, serif;color:ForestGreen;text-decoration: underline;'>Test Environment</h2>
        <?php
        break;

    case "devsmart.bpsi.us":
        ?><h2 style='text-align: center;font: italic bold 30px/30px Georgia, serif;color:ForestGreen;text-decoration: underline;'>Dev Environment</h2>
        <?php

        break;


}

?>

<div class="row2 bg-wht">
    <div class="container ">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-10" style="padding-top:25px;" >


                <img src="<?php echo base_url();?>images/signin-imgbg.jpg" class="img-responsive"/>

            </div>
			
            <!--<div class="col-md-4  text-center aln" style="padding-top:25px;" >
            <ul class="add">
<li class="addli">
<a href="https://www.seedinfotech.com"><img src="<?php //echo base_url();?>images/seed.jpg" class="img-responsive"/></a>
</li>
<li class="addli">
<?php //echo "&nbsp &nbsp &nbsp";?>
</li>

<li class="addli">
<a href="http://www.advantosoftware.com/"><img src="<?php //echo base_url();?>images/advanto.jpg" class="img-responsive"/></a>
</li>
</ul>


            </div>-->
        </div>
		
    </div>
</div>
<div class="row" style="background-color:#FFFFFF;padding-top:10px;" >
</div>
<div class="row4">

    <div class="col-md-12 text-center footer2txt" >

        <a href="core/about-us.php"><b>About Us</b></a> |
        <a href="core/contact-us.php"><b>Contact Us</b></a> |
        <a href="core/SmartCookie.pdf" target='_blank'><b>Info</b></a> |
        <a href="core/student.php"><b>Students</b></a> |
        <a href="core/college.php"><b>School/College</b></a> |
        <a href="core/teacher.php"><b>Teachers</b></a> |
        <a href="core/parent.php"><b>Parents</b></a> |
        <a href="core/sponsor.php"><b>Vendors/Sponsors</b></a> |
        <a href="help/"><b>Help </b></a>
    </div>
</div>



<div>
    <div class=" col-md-12 text-center footer3txt" >
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="<?php echo base_url();?>images/playstore.png" class="img-responsive"/>
                </div>
                <div class="col-md-4">
                    <a href="https://goo.gl/G6jpu2"><img src="<?php echo base_url();?>images/play_smartstudent.png"  title="Smart Student" height="64" width="64"></a>
                    <!-- <a href="#"><img src="<?php echo base_url();?>images/play_smartstudentcoordinator.png"  title="Smart Student Coordinator" height="64" width="64"></a> -->
                    <a href="https://goo.gl/5buFwD"><img src="<?php echo base_url();?>images/play_smartteacher.png"  title="Smart Teacher" height="64" width="64"></a>
                    <a href="https://goo.gl/vP5ENe"><img src="<?php echo base_url();?>images/play_smartparent.png" title="Smart Parent" height="64" width="64"></a>
                    <a href="https://goo.gl/2LwVqs"><img src="<?php echo base_url();?>images/play_smartsponsor.png"  title="Smart Sponsor" height="64" width="64"></a>
                </div>

                <div class="col-md-2">
                    <img src="<?php echo base_url();?>images/appstore.png" class="img-responsive"/>
                </div>
                <div class="col-md-4">
                    <a href="https://goo.gl/HNqrPR"><img src="<?php echo base_url();?>images/app_smartstudent.png"  title="Smart Student" height="64" width="64"></a>
                    <!-- <a href="#"><img src="<?php echo base_url();?>images/app_smartstudentcoordinator.png"  title="Smart Student Coordinator" height="64" width="64"></a> -->
                    <a href="https://goo.gl/cdi711"><img src="<?php echo base_url();?>images/app_smartteacher.png"  title="Smart Teacher" height="64" width="64"></a>
                    <a href="https://goo.gl/Vs11Yb"><img src="<?php echo base_url();?>images/app_smartparent.png" title="Smart Parent" height="64" width="64"></a>
                    <a href="https://goo.gl/DyfJ9Z"><img src="<?php echo base_url();?>images/app_smartsponsor.png"  title="Smart Sponsor" height="64" width="64"></a>
                </div>


            </div>
        </div>
    </div>
</div>
</br></br>

<div style="padding-top:50px;margin-bottom: 50px;background-color:gray" >

</div>
<div class='row'>
    <div class='col-md-12'>
        <div style="padding-top:50px;margin-bottom: 50px;margin-left: 300px;">
            <ul class="add">

                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>


                <li class="addli1">
                    <a href="https://www.seedinfotech.com"><img src="<?php echo base_url();?>images/seed.png" class="img-responsive"/></a>
                </li>
                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>

                <li class="addli1">
                    <a href="http://www.starbucks.in/"><img src="<?php echo base_url();?>images/coffee.png" class="img-responsive"/></a>
                </li>
                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>

                <li class="addli1">
                    <a href="http://www.german-bakery.in/"><img src="<?php echo base_url();?>images/germanbakery.png" class="img-responsive"/></a>
                </li>
                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>

                <li class="addli1">
                    <a href="http://cafecreme.co.in/"><img src="<?php  echo base_url();?>images/cafe_creame.png" class="img-responsive" style="margin-top:50;"/></a>
                </li>

                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>

                <li class="addli1">
                    <a href="https://www.zomato.com/pune/kadak-misal-kothrud"><img src="<?php echo base_url();?>images/kadak-misal.png" class="img-responsive"/></a>
                </li>
                <li class="addli1">
                    <?php echo "&nbsp &nbsp &nbsp";?>
                </li>
            </ul>
        </div>
    </div>
</div>

</br></br>
<div class=" row5">
    <div class=" col-md-12 text-center footer3txt" >
        <div class="container ">
            <div class="row">
                Blue Planet Info Solutions © <?php echo date('Y',time());?> :
                <a href="#">User Agreement </a> |
                <a href="<?php echo base_url('core/privacypolicy.php');?>">Privacy Policy</a> |
                <a href="#">Cookie Policy</a> |
                <a href="#"> Copyright Policy </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    WebFontConfig = {
        google: { families: [ 'Open+Sans::latin' ] }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
            '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>
</body>
</html>