<?php 
 include 'index_header.php'; ?>
<?php
/*Created by Rutuja Jori for email activation for SMC-5175 for School Activation functionality on 24-02-2021*/

error_reporting(0);
//include("conn.php");
session_start();
                   
?>
<!DOCTYPE html>
<html>
<head>

<title>Update Password</title>
<!--<link href="./css/style.css" rel="stylesheet" type="text/css" />-->
<style>

    .bgwhite {
            background-color: #dcdfe3;
        }
body {
    font-family: Arial;
    color: #333;
    font-size: 0.95em;


 background-color: #edebe6
 
 
}
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 1px 0 5px 0;
  border: #0887cc solid;
  border-width: thin;
  display: inline-block;
 
  background: none;
}


.form-head {
    color: white;
    font-weight: normal;
    font-weight: 400;
    margin: 0 190px 0 190px ;
    text-align: center;    
    font-size: 1.5em;
    width : 50%;
    height:100%;
    background-color:#f00;
    font-family: "Times New Roman", Times, serif;
    
    
}

.error-message {
    padding: 7px 10px;
    background: #fff1f2;
    border: #ffd5da 1px solid;
    color: #d6001c;
    border-radius: 4px;
    margin: 10px 0px 10px 0px;
}

.success-message {
    padding: 7px 10px;
    background: #cae0c4;
    border: #c3d0b5 1px solid;
    color: #027506;
    border-radius: 4px;
    margin: 30px 0px 10px 0px;
}

.demo-table {
    background: white;
    border-spacing: 100px;
    margin: 200px auto;
    word-break: break-word;
    table-layout: 100px;
    line-height: 1.8em;
    color: #333;
    border-radius: 10px;
    padding: 20px 40px;
    width: 700px;
     border: 2px solid;
    border-color: #e5e6e9 #dfe0e4 #d0d1d5;
    
}


.demo-table .label {
    color: #888888;
}

.demo-table .field-column {
    padding: 2px 0px;
}

.demo-input-box {
    padding: 13px;
    border: #CCC 1px solid;
    border-radius: 4px;
    width: 100%;
}

.btnRegister {
    padding: 13px;
    background-color: #006699;
    color: #f5f7fa;
    cursor: pointer;
    border-radius: 4px;
    width: 30%;
    border: #5791da 1px solid;
    font-size: 1.1em;
}

.response-text {
    max-width: 380px;
    font-size: 1.5em;
    text-align: center;
    background: #fff3de;
    padding: 42px;
    border-radius: 3px;
    border: #f5e9d4 1px solid;
    font-family: arial;
    line-height: 34px;
    margin: 15px auto;
}

.terms {
    margin-bottom: 5px;
}
 select {
        width: 150px;
        margin: 10px;
        height: 30px;
    }
    select:focus {
        min-width: 150px;
        width: auto;
    }

</style>


</head>
<body>
  <div class='row bgwhite padtop10'>
    <form name="frmRegistration" method="post" action="">
        <div class="demo-table">
        <?php
 
        if($isSmartCookie) { ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/250_86.png"/></a></div>
                            <?php  }else{  ?>
                           <div align='center'> <a href='<?php echo xecho($index_url); ?>'><img src="Images/pblogoname.jpg"/></a></div>
                            <?php } ?>
                             
        
            <br>
           
          
                
                 <div align="center">
                <h2>Email ID (<?php echo $_SESSION['email_activation'];?>) does not match for Activation, do you want to re-enter or use this Email-ID?</h2>

                <div><br><br>&nbsp;&nbsp;
                  <a href="activate_school.php" style="text-decoration:none;"> <input type="button"  class="btn btn-danger" name="Re-enter" value="Re-enter"/></a>

                          <?php $server_name = $GLOBALS['URLNAME']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="register_school_admin_staff.php" style="text-decoration:none;"> <input type="button"  class="btn btn-success" name="Back" value="Use this Email ID"/></a>
                        
                </div>
                </div>
            </div>

    </form>
    </div>
</body>
</html>



<div class="row4 ">
 <div class=" col-md-12 text-center footer2txt">
  </div></div>
