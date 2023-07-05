<?php

include("corporate_cookieadminheader.php");

$report = "";
$sponsor_id=$_GET['id'];
if (isset($_POST['submit'])) 
{
    
 $sp_name=$_POST['sp_name'];
 $shop_name=$_POST['shop_name'];
 $sp_email=$_POST['sp_email'];
 $sp_mobile=$_POST['sp_mobile'];
 $sp_web=$_POST['sp_web'];
 $sp_address=$_POST['sp_address'];
 $sp_img_path=$_POST['sp_img_path'];
 
 /* update image */
 if(isset($_FILES['profileimage']['name']))
        {
            $images= $_FILES['profileimage']['name'];
            $ex_img = explode(".",$images);
            $img_name = $ex_img[0]."_".$id."_".date('mdY').".".$ex_img[1];
            $full_name_path = "image_sponsor/".$img_name;
            move_uploaded_file($_FILES['profileimage']['tmp_name'],$full_name_path);
            $sqls= "UPDATE tbl_sponsorer set sp_name='$sp_name' ,sp_address='$sp_address',sp_phone='$sp_mobile', sp_company='$shop_name' , sp_website='$sp_web',sp_img_path='$full_name_path'  where id ='$sponsor_id'";
            $count = mysql_query($sqls) or die(mysql_error());
           // header("Location:sponsor_list.php");//retrive current inserted record id
        }
        else
        {
            $sqls= "UPDATE tbl_sponsorer SET sp_name='$sp_name' ,sp_address='$sp_address',sp_phone='$sp_mobile', sp_company='$shop_name' , sp_website='$sp_web'  where id ='$sponsor_id'";
            $count = mysql_query($sqls) or die(mysql_error());
        }
        if($count>=1){

             echo ("<script LANGUAGE='JavaScript'>
                alert('Successfully Updated');
                window.location.href='sponsor_list.php';
                </script>");
        
            //$report="Successfully Updated";
              //header( "refresh:0; url=edit_salesperson.php" );

        }
 /*
 echo $update=mysql_query("update tbl_sponsorer set sp_name='$sp_name' ,sp_address='$sp_address',sp_phone='$sp_mobile', sp_company='$shop_name' , sp_website='$sp_web',sp_img_path='$sp_img_path'  where id ='$sponsor_id'");
 
  $report = 'Successfully updated';
  echo "<script>alert('Successfully updated');</script>";
*/
  }

 $sql=mysql_query("select sp_name,sp_address,sp_phone,sp_company,sp_website,sp_email,sp_img_path from tbl_sponsorer where id='$sponsor_id'");


 $result=mysql_fetch_array($sql);

?>

<!DOCTYPE html>
<head>
<script src='js/bootstrap-datepicker.min.js' type='text/javascript'></script>
    <script src="js/city_state.js" type="text/javascript"></script>
    <link href='css/datepicker.min.css' rel='stylesheet' type='text/css'>

</head>
<script>
        $(document).ready(function () {
            $('.datepicker').datepicker();
        });
        function valid() {
            var sp_name = document.getElementById("sp_name").value;
            //changes done by Pranali intern start 
            if (sp_name.trim() == "" || sp_name.trim() == null) {
                document.getElementById('errorname').innerHTML = 'Please Enter Name';
                return false;
            }
            regx1 = /^[A-Za-z ]+$/;
            //validation for name
            if (!regx1.test(sp_name)) {
                document.getElementById('errorname').innerHTML = 'Please Enter valid Name';
                return false;
            }
            var regname=/^\S+(?: \S+)*$/;
            if(!regname.test(sp_name ))
                {
                    document.getElementById('errorname').innerHTML='Incorrect Name';
                    return false;
                }
            else 
            {
                document.getElementById('errorname').innerHTML = '';
            }
            var shop_name = document.getElementById("shop_name").value;
            if (shop_name.trim() == "" || shop_name.trim() == null  ) {
                document.getElementById('errorshopname').innerHTML = 'Please Enter Shop Name';
                return false;
            }
            regx1 = /^[A-Za-z. ]+$/;
            //validation for name
            if (!regx1.test(sp_name)) {
                document.getElementById('errorshopname').innerHTML = 'Please Enter valid Shop Name';
                return false;
            }
            else {
                document.getElementById('errorshopname').innerHTML = '';
            }
            
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

            var sp_email = document.getElementById("sp_email").value;

            if (!sp_email.match(mailformat)) {
                document.getElementById('erroreemailname').innerHTML = 'Please Enter valid email ID';

                return false;
            }
            else {
                document.getElementById('erroreemailname').innerHTML = '';
            }
            
/*Start regex for mobile no and add if condition to check it By Dhanashri Tak*/
             var phone=/^[6789]\d{9}$/;
            var sp_mobile = document.getElementById("sp_mobile").value;
            
            if (sp_mobile == "" || sp_mobile == null) 
                {
                    document.getElementById(errornobilename).innerHTML = 'Please Enter Mobile Number';
                   return false;
                 }
            if(phone.test(sp_mobile)==false)
            {
                document.getElementById('errornobilename').innerHTML='Please Enter Valid Phone No';
                return false;
            }
            /*else if (isNaN(sp_mobile)) {
                document.getElementById('errornobilename').innerHTML = 'Please Enter Valid Phone Number';
                return false;
            }*/
            
            else {
                document.getElementById('errornobilename').innerHTML = '';
            }
            
        /*END*/

            var sp_address = document.getElementById("sp_address").value;
            if (sp_address.trim() == "" || sp_address.trim() == null) {
    //changes done end
                document.getElementById('erroraddress').innerHTML = 'Please Enter address';

                return false;
            }
            else {
                document.getElementById('erroraddress').innerHTML = '';
            }
            
        }
    </script>
        <script>
function fileValidation(){
    var fileInput = document.getElementById('profileimage');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }
}
</script>
<body>
<div class='panel-heading'>
        <a href="sponsor_list.php"> <input type="button" class="btn btn-primary" name="submit" value="Back" style="width:150;font-weight:bold;font-size:14px;"/></a>
        <h3 align="center">Update Sponsor Information</h3>
    </div>

<div class='panel-body'>
        <form class='form-horizontal' role='form' method="POST" enctype="multipart/form-data">
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Sponsor Name<span style="color:red;font-size: 25px;"> *</span></label>
                <div class='col-md-8'>
                    <div class='col-md-4'>
                        <div class='form-group internal'>
                            <input class='form-control' id='sp_name' name="sp_name" placeholder="Enter Sponsor Name" maxlength="55" type='text' size="50" value="<?php echo $result['sp_name']; ?>">
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="errorname" style="color:#FF0000">
                    </div>
                </div>
            </div>
    
        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Shop Name<span style="color:red;font-size: 25px;"> *</span></label>
                <div class='col-md-8'>
                    <div class='col-md-4'>
                        <div class='form-group internal'>
                            <input class='form-control' id='shop_name' name="shop_name" placeholder="Enter Shop Name" type='text' size="50" value="<?php echo $result['sp_company']; ?>">
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="errorshopname" style="color:#FF0000">
                    </div>
                </div>
            </div>
        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Email ID<span style="color:red;font-size: 25px;"> *</span></label>
                <div class='col-md-8'>
                    <div class='col-md-4'>
                        <div class='form-group internal'>
                            <input class='form-control' id='sp_email' name="sp_email" placeholder="Enter Email ID" type='text' size="50" value="<?php echo $result['sp_email']; ?>">
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="erroreemailname" style="color:#FF0000">
                    </div>
                </div>
            </div>
        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Mobile No.<span style="color:red;font-size: 25px;"> *</span></label>
                <div class='col-md-8'>
                    <div class='col-md-4'>
                        <div class='form-group internal'>
                            <input class='form-control' id='sp_mobile' name="sp_mobile" placeholder="Enter Mobile Number" type='text' size="50" value="<?php echo $result['sp_phone']; ?>">
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="errornobilename" style="color:#FF0000">
                    </div>
                </div>
            </div>
        
            <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_title' style="text-align:left;">Web Site </label>
                <div class='col-md-8'>
                    <div class='col-md-4'>
                        <div class='form-group internal'>
                            <input class='form-control' id='sp_web' name="sp_web" placeholder="Enter Web Site" type='text' size="50" value="<?php echo $result['sp_website']; ?>">
                        </div>
                    </div>
                    <div class='col-md-4 indent-small' id="errorwebname" style="color:#FF0000">
                    </div>
                </div>
            </div>
                

        <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Address<span style="color:red;font-size: 25px;"> *</span></label>
                <div class='col-md-4'>
                    <textarea class='form-control' id='sp_address' name="sp_address" placeholder="Enter Address" rows='3'><?php echo $result['sp_address']; ?></textarea>
                </div>
                <div class='col-md-2 indent-small' id="erroraddress" style="color:#FF0000"></div>
            </div>

            
              <div class="row form-group">
                            
                            <label class='control-label col-md-2 col-md-offset-2' for='id_comments' style="text-align:left;">Profile image<span style="color:red;font-size: 25px;">  </span></label>
                            <div class='col-md-4 form-group internal'>
                                <input type="file" id="profileimage" name="profileimage"   onChange="return fileValidation()" style="margin-left: 17px; margin-top: 18px;"><span><?php echo $result['sp_img_path'];?></span>
                            <!--<?php if(isset($result['sp_img_path']))
                            {
                            ?>
                                    <label><span><?php echo $result['sp_img_path'];?></span></label>
                            <?php 
                            }
                            else{ 
                            ?>
                            <label id="profileimage1"><span><?php echo "please enter"?></span></label>
                                
                                <?php }?>-->
                            </div>
                        </div>
            
            
            
            <div class='form-group row' style="margin-top:3%">
                <div class='col-md-2 col-md-offset-4'>
                    <input class='btn-lg btn-primary' type='submit' value="Update" name="submit" onClick="return valid()" style="padding:5px;"/>
                </div>

                <div class='col-md-1'>
                    <a href="sponsor_list.php".php"><input type="button" class='btn-lg btn-danger' value="Cancel" name="cancel" style="padding:5px;"/></a>
                </div>
                
                
                 
        </form>
    </div>
        
        

</body>

