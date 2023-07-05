<?php
/*
Author : Pranali Dalvi
Date Created : 05-01-2019
This file was created for registration of Spectator / Volunteer
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <style>
        .bgwhite {
            background-color: #fff;
        }
        .padtop10 {
            padding-top: 10px;
        }
        .red {
            color: #f00;
        }
        tr {
            padding-top: 10px;
        }
        .green {
            color: #0f0;
        }
        .panel-info
        {
            width:1000px;
        }
    </style>
</head>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>:: Smart Cookie -  Student/Teacher Rewards Program ::</title>
    <link href="css/bootstrap.css"rel="stylesheet">
<!--    <script src="js/jquery-1.11.1.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <link href="css/sc_style2.css"rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
</head>
<body>


<div id="background">
    <p id="bg-text">Background</p>
</div>

<div class="row1 header  bg-wht">
    <div class='container'>
        <div class="row " style="padding-top:20px;" >
            <div class="col-md-7 visible-lg visible-md">
                <a href="index.php"> <img src="images/300_103.png" /> </a>
            </div>
            <div class="col-md-7 visible-sm">
                <img src="Images/250_86.png" />
            </div>
            <div class="col-md-7 visible-xs">
                <img src="Images/220_76.png" />
            </div>
        </div>
    </div>
</div>

    <div style="width:800px; margin:0 auto; background-color: white;">
        <div class='col-md-10 col-md-offset-2' >
            <div class='panel panel-info' style="width: 550px;height: 700px;">
                <div class='panel-heading'>
                    <div class='panel-title'>
                        Smartcookie - Students/Teachers/Employees/Managers/Social Workers / Player rewards program
                    </div>
                </div>
                <div class='panel-body' style="text-align: center;">
                    <form method="post" id="myform" action="">
                        <table class='table'>
                                
                                <tr>
                                    <td style="padding: 27px">I am<span class='red'>*</span></td>
                                    <td style="padding: 27px">
                                        <select id="user_type" name="user_type" style="width:200px">
                                            <option value="" selected="selected">Select</option>
                                            <option value="spectator">Spectator</option>
                                            <option value="volunteer">Volunteer</option>
                                            
                                        </select>
										<?php echo form_error('user_type', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
										</td>
                                </tr>
								 <tr>
                                    <td style="padding: 27px"><span id="user"></span> Name<span class='red'>*</span></td>
                                    <td style="padding: 27px"><input type='text' class=" " id='user_name' name='user_name' style='width:200px'/>
									<?php echo form_error('user_name', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
									</td>
                                    
                                </tr>
                               <tr>
                                    <td style="padding: 27px">Mobile No<span class='red'>*</span></td>
                                    <td style="padding: 27px"><input type='Contact' class="mobile-num " id='Contact' name='Contact' style='width:200px'/>
									<?php echo form_error('Contact', '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
									</td>
                                    <span id="folio-invalid" class="hidden mob-helpers">
                                        <i class="fa fa-times mobile-invalid"></i><font color="red">Please enter valid Mobile No</font></span>
                                </tr>
								<tr>
                                    <td style="padding: 27px"></td>
                                    <td class="center">
                                        <input class="btn btn-primary" type='submit' id='submit' name='submit'  value="Submit" style='width:200px'  />
                                    </td>
                                </tr>
								<tr>
								<?php 
								if($this->session->flashdata('success')){
									?>
									<h3 style="color:green;">
											<?php echo $this->session->flashdata('success'); ?>
										</h3>
										<?php
								}
								?>
								</tr>
								</table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'core/index_footer.php'; ?>