                                                                                    <?php
 	include("scadmin_header.php");
    include("error_function.php");
    $reports="";
    $report="";


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">


   var _validFileExtensions = [".xlsx", ".xls", ".xlsm", ".xlw", ".xlsb",".xml",".xlt"];
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }

            if (!blnValid) {
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//js/jquery-1.10.2.js"></script>
  <script src="//js/jquery-ui.js"></script>
  <link rel="stylesheet" href="/js/style.css">
<style>
H3{
     text-align: center;
color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;

background-color:grey;
width: 25%;
line-height:30px;
}
H5{
 text-align: center;
 color: white;
font-family: arial, sans-serif;
font-size: 20px;
font-weight: bold;
margin-top: 0px;
background-color:grey;
width:35%;
line-height:30px;
}
</style>

<script>
  $(function() {
    $("#dialog").dialog();
  });
  </script>
</head>

<body >
<div class='container' style="padding-top:30px;padding-left:30px;">
    <div class='panel panel-primary dialog-panel'>
   <div style="color:red;font-size:15px;font-weight:bold;margin-top:10px;"> <?php if(isset($_GET['report'])){ echo $_GET['report']; };?></div>
          <div class='panel-heading'>

                <h3>Create Student Subject Master Excel Sheet</h3>



              </div>


                    <div class='panel-body' style="background:lightgrey; box-shadow: 0 0 10px 10px black;">
                    <form name='frm' method='post' enctype='multipart/form-data' id='frm'>
                   <!-- <div class="row" style="margin-left: 500px;">
                    <p><b>Scan Excel file</b></p>

                    <input type="radio" name="flag" value="1" >YES
                    <input type="radio" name="flag" value="0" checked>NO

                    </div>-->
                    <br>

                  <div class='form-group'>
                  <div class="assignlimit">
                                  <div class="assign-limit">
                                        <form method="post" action="#">
                                        	<!--<select name="limit" class="limitofuploadingrecords" id="limit" style="width:20%; height:30px; border-radius:2px;margin-left:426px;">
                                              <option value="" disabled selected>Set upload Records Limit</option>
                                              <option value="1">1</option>
                                              <option value="4">4</option>
                                              <option value="100">100</option>
                                              <option value="500">500</option>
                                              <option value="1000">1000</option>
                                              <option value="1500">1500</option>
                                               <option value="2000">2000</option>
                                             <option value="2500">2500</option>
                                              <option value="5000">5000</option>
                                              <option value="15000">15000</option>
                                              <option value="20000">20000</option>
                                              <option value="25000">25000</option>
                                              <option value="30000">30000</option>
                                              </select>-->

                                            </div>
                                            </div>

                                    <!--<label class='control-label col-md-2 col-md-offset-2' for='id_title'></label>-->
                                <div class='row col-md-12'>
                                     <div class='col-md-5'></div>
                                    <div class='col-md-4 '>
                                        <!--<center>-->
                                        <label>Student Excel</label>
                                        <input type='file' name='file1'  id='file1' size='30' onChange="ValidateSingleInput(this);" style=""/> <br />                 <label>Class Subject Excel</label>
                                         <input type='file' name='file2'  id='file2' size='30' onChange="ValidateSingleInput(this);" style=""/>
    </div>                                <!--</center>-->
                                </div>
                                <br><br>
                              </div>
                              <div style="height:50px;"></div>
                              <div class='row form-group'>
                                <div class='col-md-offset-3 col-md-3' style="padding-left:155px;margin-top:-35px">
                                  <input class='btn-lg btn-primary' type='submit' value="Submit" name="submit" />
                                </div>
                                <div class='col-md-3' style="margin-top:-35px">

                                  <button class='btn-lg btn-danger'  type='submit'>Cancel</button>
                                </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-6 col-md-offset-2' align="center" style="color:black;margin-top:15px;padding-left:201px;">

                                    <?php
                                            echo $reports1."<br>";
                                            echo $reports."<br>";
                                            echo $report."<br>";
                                            echo $no_rows;

                                    ?>


                                     </div>
                                    </div>
                                </div>

                                </form>

                                </div>

                                       <!-- <div class='col-md-12 col-md-offset-2' align="right" style="padding-right:190px;">
                                     <?php $query2="select batch_id from `tbl_raw_student` WHERE s_school_id='$school_id' ORDER BY id DESC LIMIT 1 ";
                                            $row2=mysql_query($query2);
                                            $value2=mysql_fetch_array($row2);
                                            $batch_id1=$value2['batch_id'];
                                            $b_id=explode("-",$batch_id1);
                                            $b=$b_id[1];
                                            $b1=$b_id[0];
                                            $bat_id=$b;
                                            $batch_id=$b1."-".$bat_id;?>
                                    <h5><?php echo "Batch"." ". $batch_id." "."Uploaded Successfully by"." ".$uploaded_by."<br>"?></h5>
                                    </div>-->
                                    </div>
                                    <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-12 ">
                                   <!-- <table cellpadding="12" cellspacing="6" align="center">
                                    <tr bgcolor="#9900CC">
                                    <center><a href="download_stud_upload_format.php?name=<?php echo "S";?>">Download Student Upload Excel Sheet Format</a></center><tr>
                                    <center><?php for($space=1;$space<=25;$space++){?>&nbsp;<?php }?>
                                    <a href="download_stud_upload_format.php?name=<?php echo "EE";?>">Download Student Error Excel Sheet</a></center><tr>
                                    </table>-->
                                    </div>
                                    </div>
                                    </form>
                                    </body>
                                    </html>