<?php	 	

include('conn.php');

include("frm_header.php");

$arr=mysql_query("select * from tbl_option where DR_ID ='".$_SESSION['dr_id']."'");

$row=mysql_fetch_array($arr);

 $ph_num=$row['ph_number'];

$arr2=mysql_query("Select * from tbl_practice where PRT_ID ='".$_SESSION['dr_id']."'");

 $row2=mysql_fetch_array($arr2);



if(isset($_POST['submit']))

 {

 $todate=date('Y-m-d 00:00:00',strtotime($_POST['todate']));

  $fromdate=date('Y-m-d 12:59:59',strtotime($_POST['fromdate']));

  

  $todates=date('Y-m-d',strtotime($_POST['todate']));

  $fromdates=date('Y-m-d',strtotime($_POST['fromdate']));

  $_SESSION['todate']=$todates;

 $_SESSION['fromdate']=$fromdates;

 

 $arr11=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 

 $count1=mysql_num_rows($arr11);

  $arr12=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count2=mysql_num_rows($arr12);

  $arr13=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count3=mysql_num_rows($arr13);

  $arr14=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count4=mysql_num_rows($arr14);

 $arr15=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count5=mysql_num_rows($arr15);

  $arr16=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=6 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count6=mysql_num_rows($arr16);

 $arr17=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count7=mysql_num_rows($arr17);

 $arr18=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count8=mysql_num_rows($arr18);

 $arr19=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count9=mysql_num_rows($arr19);

 $arr20=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Call Transfer' and date1 between '$todate' and '$fromdate'");

 $count0=mysql_num_rows($arr20);

 

 

  $arr21=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count21=mysql_num_rows($arr21);

  $arr22=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count22=mysql_num_rows($arr22);

  $arr23=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count23=mysql_num_rows($arr23);

  $arr24=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count24=mysql_num_rows($arr24);

  $arr25=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count25=mysql_num_rows($arr25);

  $arr26=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=6 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count26=mysql_num_rows($arr26);

  $arr27=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count27=mysql_num_rows($arr27);

  $arr28=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count28=mysql_num_rows($arr28);

  $arr29=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count29=mysql_num_rows($arr29);

  $arr30=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Voice Mail' and date1 between '$todate' and '$fromdate'");

 $count30=mysql_num_rows($arr30);

 

  $arr31=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count31=mysql_num_rows($arr31);

  $arr32=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count32=mysql_num_rows($arr32);

  $arr33=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count33=mysql_num_rows($arr33);

  $arr34=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count34=mysql_num_rows($arr34);

  $arr35=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count35=mysql_num_rows($arr35);

  $arr36=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count36=mysql_num_rows($arr36);

  $arr37=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count37=mysql_num_rows($arr37);

  $arr38=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count38=mysql_num_rows($arr38);

  $arr39=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count39=mysql_num_rows($arr39);

  $arr40=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Play Message' and date1 between '$todate' and '$fromdate'");

 $count40=mysql_num_rows($arr40);

 }else{



$sql_last = mysql_query("SELECT * FROM tbl_url where ph_number='$ph_num' order by id desc LIMIT 0, 1");



	$sql_last1=mysql_fetch_array($sql_last);

	$last_1=$sql_last1['date1'];

	$last=date('Y-m-d 12:59:59',strtotime($last_1));

	 $last1=date('d',strtotime($last));

$d=$last1-4;



$dc=strlen($d);

if($dc==1)

{

$d1="0".$d;

}else{

$d1=$d;

}

 $last2=date('Y-m',strtotime($last));

 $lastdate = $last2."-".$d1." 00:00:00";







 $arr11=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count1=mysql_num_rows($arr11);

  $arr12=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count2=mysql_num_rows($arr12);

  $arr13=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count3=mysql_num_rows($arr13);

  $arr14=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count4=mysql_num_rows($arr14);

  $arr15=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count5=mysql_num_rows($arr15);

  $arr16=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=6 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count6=mysql_num_rows($arr16);

  $arr17=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count7=mysql_num_rows($arr17);

  $arr18=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count8=mysql_num_rows($arr18);

  $arr19=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count9=mysql_num_rows($arr19);

  $arr20=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count0=mysql_num_rows($arr20);

 

  $arr21=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Voice Mail' and date1 between '$lastdate' and '$last'");

 $count21=mysql_num_rows($arr21);

  $arr22=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Voice Mail' and date1 between '$lastdate' and '$last'");

 $count22=mysql_num_rows($arr22);

  $arr23=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Voice Mail' and date1 between '$lastdate' and '$last'");

 $count23=mysql_num_rows($arr23);

  $arr24=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Voice Mail' and date1 between '$lastdate' and '$last'");

 $count24=mysql_num_rows($arr24);

  $arr25=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Voice Mail' and date1 between '$lastdate' and '$last'");

 $count25=mysql_num_rows($arr25);

  $arr26=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=6 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count26=mysql_num_rows($arr26);

  $arr27=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count27=mysql_num_rows($arr27);

  $arr28=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count28=mysql_num_rows($arr28);

  $arr29=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count29=mysql_num_rows($arr29);

  $arr30=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Call Transfer' and date1 between '$lastdate' and '$last'");

 $count30=mysql_num_rows($arr30);

 

  $arr31=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=1 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count31=mysql_num_rows($arr31);

  $arr32=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=2 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count32=mysql_num_rows($arr32);

  $arr33=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=3 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count33=mysql_num_rows($arr33);

  $arr34=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=4 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count34=mysql_num_rows($arr34);

  $arr35=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=5 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count35=mysql_num_rows($arr35);

  $arr36=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=6 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count36=mysql_num_rows($arr36);

  $arr37=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=7 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count37=mysql_num_rows($arr37);

  $arr38=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=8 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count38=mysql_num_rows($arr38);

  $arr39=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=9 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count39=mysql_num_rows($arr39);

  $arr40=mysql_query("select * from tbl_url where ph_number='$ph_num' and digit=0 and action='Play Message' and date1 between '$lastdate' and '$last'");

 $count40=mysql_num_rows($arr40);

 }

?>







    <style type="text/css">

    .ButtonClass

    {

      cursor: pointer;     

    }

    .ButtonClass:hover

    {

      color:White !important;

    }

    .box

    {  

      

      background-color:white;

	  

      -moz-border-radius-topleft: 10px;

                -webkit-border-top-left-radius: 10px;

                border-top-left-radius: 10px;

                -moz-border-radius-topright: 10px;

                -webkit-border-top-right-radius: 10px;

                border-top-right-radius: 10px;

                

    }

    .bottombox

    {

      background-color:white;

      

      -moz-border-radius-bottomleft: 10px;

                -webkit-border-bottom-left-radius: 10px;

                border-bottom-left-radius: 10px;

                -moz-border-radius-bottomright: 10px;

                -webkit-border-bottom-right-radius: 10px;

                border-bottom-right-radius: 10px;

    }

    </style>

</head>

<body style="BACKGROUND-COLOR: #999966">

<center>







<script type="text/javascript">

//<![CDATA[

var theForm = document.forms['aspnetForm'];

if (!theForm) {

    theForm = document.aspnetForm;

}

function __doPostBack(eventTarget, eventArgument) {

    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {

        theForm.__EVENTTARGET.value = eventTarget;

        theForm.__EVENTARGUMENT.value = eventArgument;

        theForm.submit();

    }

}

//]]>

</script>



<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>

  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <link rel="stylesheet" href="/resources/demos/style.css" />

  <script>

  $(function() {

    $( "#datepicker" ).datepicker();	

  });

   $(function() {

    $( "#datepicker1" ).datepicker();	

  });

  </script>



<script src="/WebResource.axd?d=EgNO0r2ypmOT_RzsQo36XEICBDgbDVQz--n_D01L1-ovZlEgEEE3-sE5YNDotOGSBtOhj70P0t8YtLoRpN2KXUvIR2k1&amp;t=635006203607397289" type="text/javascript"></script>





<script src="/ScriptResource.axd?d=d7tOwt5RvqFYSUNr96CjQE79ZGexssJ9CTrfvDB8P-j-8cEm6N7_GpZGramhvYrWnF0piD6d9sSbuS4um3X3O3PzSFGJLWpqeWYt7bXppd0TgrvVnyVGNxS19482gh4FD43pZdxTLpmpXbYvhQDlujUxyIb1VcAQU32K2ERIe2LkF5up0&amp;t=634801827506406250" type="text/javascript"></script>

<script src="/ScriptResource.axd?d=n_wkwJjUPyv3IO1xg-0ikcm46hkDaJ8W2Y3Gl5SqkctMK8yDPOo7dG77Sjk1_gssqDc-BW7JOfmkMzlL7pLa3LIOVcmvbgq2qp4RfImVURtJT4aG4-V0Ygyav8Ubnx1yU31HVpiTI3elmr7u8wLjPGLbXdUOGvWkBMsO83yrw_ovCq_70&amp;t=634801827506406250" type="text/javascript"></script>

<div>



	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEWBQKEuueBBQKA3rXHDQKm7+bMCALijtWiCgK5r/RsnOK1ZT2TXVEgKWCfl/ukF4RSQC8=" />

</div>

    

     <div style="height:auto">

        

        <table style="width: 100%; height:auto" border="0" cellpadding="0" cellspacing="0" valign="top">

            <tr>

                <td align="center" style="background-color: #999966; height: 474px;" valign="top">

               

                    <table style="width: 100%; height:auto; background-color: white">

                       

                       

                        <tr>

                            <td align="left" valign="top">

                           

                                

                                        

                                            

    <center>

<div style="height:100%; width:100%">





    

    <table style="width: 100%;">

        <tr>

            <td align="center" style="height: 25px;">

                <span id="ctl00_ContentPlaceHolder1_Label13" style="color:Black;font-family:Verdana;font-size:16px;font-weight:bold;">Dashboard</span></td>

        </tr>

        <tr>

             <?php	 	



	$sql = mysql_query("SELECT * FROM tbl_url where ph_number='$ph_num' order by id desc LIMIT 0, 1");



	$row_end=mysql_fetch_array($sql);



	$lasts=$row_end['date1'];

	 $lasts1=date('d',strtotime($lasts));

$ds=$lasts1-4;

$dsc=strlen($ds);

if($dsc==1)

{

$dsc1="0".$ds;

}else{

$dsc1=$ds;

}

 $lasts2=date('Y-m',strtotime($lasts));

$lastdates = $lasts2."-".$dsc1;

 $lasts3=date('Y-m-d',strtotime($lasts));

	//$row_end1=date('Y-m-d 00:00:00',strtotime($_POST['row_end']));



 // $row_start1=date('Y-m-d 12:59:59',strtotime($_POST['row_start']));



	?>

        <tr>

            <td align="center">

             <div style="margin-top:10px;"> <form method="post" action=""> From Date&nbsp;: &nbsp;<input type="text" name="todate" id="datepicker" value="<?php	 	 if(isset($_POST['submit'])){echo $_SESSION['fromdate'];}else{ echo $lasts3;} ?>"> &nbsp; &nbsp;<input type="submit" name="submit" value="Submit"></form></div>

                &nbsp;<div>

	<table width="100%" border="1" cellspacing="0" rules="rows" id="ctl00_ContentPlaceHolder1_gvStaffList" style="width:100%;border-collapse:collapse; height:300px;;">

		<tr style="font-size:16px; color:#FFFFFF; background-color:#339999; height:40px;">

			<th width="5%" scope="col">Sr. No.</th>

            <th width="10%" scope="col">Telephone Key pad digits </th>

            <th width="35%" scope="col">Options</th>

            

            <th width="10%" scope="col">Number of phone transfers</th>

            <th width="10%" scope="col">Number of Voice Mails</th>

             <th width="10%" scope="col">Outgoing Messages played</th>

           <!-- <th width="25%" scope="col">First Message template</th>

        <th width="25%" scope="col">Second Message template</th>



          <th width="15%" scope="col"> Thank you Msg Template</th>-->



            <th width="15%" scope="col">Total</th>

            

		</tr><tr align="center" style="font-family:Verdana;font-size:13px;">

			<td align="center"><strong>1.</strong></td>

            <td align="center"><strong>1</strong></td>

            <?php	 	 $total6=$count6+$count26+$count36;?>

            <td align="left"><strong>Office Hours and Fax Number</strong></td>

            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count6;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $count26;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count36;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label14"><?php	 	 echo $total6;?></span>

                                

                            </td>

                            

		</tr>

        

        

       <tr align="center" style="font-family:Verdana;font-size:13px;">

       <td align="center"><strong>2.</strong></td>

       <td align="center"><strong>2</strong></td>

      <?php	 	 $total3=$count3+$count23+$count33;?>

			<td  align="left"><strong>Make, Reschedule or Cancel Appointment</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count3;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count23;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count33;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total3;?></span>

                            </td>

                           

		</tr>

        

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>3.</strong></td>

         <td align="center"><strong>3</strong></td>

          <?php	 	 $total4=$count4+$count24+$count34;?>

			<td  align="left"><strong>Referral or Refill Request</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count4;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count24;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count34;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total4;?></span>

                            </td>

                           

		</tr>

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>4.</strong></td>

         <td align="center"><strong>4</strong></td>

            <?php	 	 $total1=$count1+$count21+$count31;?>

			<td align="left"><strong>Doctor, Hospital, Pharmacy or Nursing Home</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count1;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count21;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count31;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total1;?></span>

                            </td>

                           

		</tr>

        </tr>

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>5.</strong></td>

         <td align="center"><strong>5</strong></td>

            <?php	 	 $total7=$count7+$count27+$count37;?>

			<td align="left"><strong>Diagnostic Lab with abnormal results</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count7;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count27;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count37;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total7;?></span>

                            </td>

                           

		</tr>

        

         </tr>

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>6.</strong></td>

         <td align="center"><strong>6</strong></td>

            <?php	 	 $total5=$count5+$count25+$count35;?>

			<td align="left"><strong>General Mail Box</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count5;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count25;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count35;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total5;?></span>

                            </td>

                           

		</tr>

        

        

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>7.</strong></td>

         <td align="center"><strong>7</strong></td>

            <?php	 	 $total2=$count2+$count22+$count32;?>

			<td align="left"><strong>Patient with medical emergency :Talk to Doctor</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count2;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count22;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count32;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total2;?></span>

                            </td>

                           

		</tr>

        

         </tr>

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>8.</strong></td>

         <td align="center"><strong>8</strong></td>

            <?php	 	 $total8=$count8+$count28+$count38;?>

			<td align="left"><strong>Invalid</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count8;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count28;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count38;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total8;?></span>

                            </td>

                           

		</tr>

        

         </tr>

         <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>9.</strong></td>

         <td align="center"><strong>9</strong></td>

            <?php	 	 $total9=$count9+$count29+$count39;?>

			<td align="left"><strong>Replay Message</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count9;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count29;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count39;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total9;?></span>

                            </td>

                           

		</tr>

        

          <tr align="center" style="font-family:Verdana;font-size:13px;">

         <td align="center"><strong>10.</strong></td>

         <td align="center"><strong>0</strong></td>

            <?php	 	 $total0=$count0+$count30+$count40;?>

			<td align="left"><strong>Human Being</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $count0;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count30;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count40;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total0;?></span>

                            </td>

                           

		</tr>

        

         <tr align="center" style="font-family:Verdana;font-size:13px; background-color:#F0FFFF;">

         <td align="center"><strong></strong></td>

            <?php	 	

			$count_total=$count31+$count32+$count33+$count34+$count35+$count36+$count37+$count38+$count39+$count40;

			 $counts=$count1+$count2+$count3+$count4+$count5+$count6+$count7+$count8+$count9+$count0;

			 $count=$count21+$count22+$count23+$count24+$count25+$count26+$count27+$count28+$count29+$count30;

			 $total=$counts+$count+$count_total;

			 ?>

			<td align="left" colspan="2"><strong>Total</strong></td>

			

			<td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label2"><?php	 	 echo $counts;?></span>

                            </td><td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label4"><?php	 	 echo $count_total;?></span>

                            </td>

                            <td>

                                <span id="ctl00_ContentPlaceHolder1_gvStaffList_ctl02_Label16"><?php	 	 echo $total;?></span>

                            </td>

                           

		</tr>

        

	</table>

    <br />

    

  

   

   <br/>

   <br/>

    

    

</div>

            </td>

        </tr>

    </table>





    

</div>

</center>



                                        

                                        

                                        

                            </td>

                        </tr>

                    </table>

                    </div>

                    <div class="bottombox" style="width:100%; height:20px; background-color: #999966;">

                        <img id="ctl00_Image3" src="images/bottombar.png" style="border-width:0px; width:100%; " /></div>

                </td>

            </tr>

            <tr>

                <td align="center" style="background-color: #999966" valign="top">

                    <script type="text/javascript">

//<![CDATA[

Sys.WebForms.PageRequestManager._initialize('ctl00$ScriptManager1', document.getElementById('aspnetForm'));

Sys.WebForms.PageRequestManager.getInstance()._updateControls([], [], [], 90);

//]]>

</script>



                </td>

            </tr>

        </table>

        </div>

    



<script type="text/javascript">

//<![CDATA[

Sys.Application.initialize();

//]]>

</script>



    </center>

</body>

</html>

