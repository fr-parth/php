<?php
//Below variables added for Protsahan-Bharati by Rutuja Jori on 19/07/2018/2019
 $webHost = $_SESSION['webHost'];
 $isSmartCookie=$_SESSION['isSmartCookie']; 
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link href="<?php echo base_url();?>Assets/vendors/bootstrap/css/bootstrap.css" rel="stylesheet">
  <script src="<?php echo base_url();?>Assets/js/jquery-1.11.1.min.js"></script>
  <script src="<?php echo base_url();?>Assets/vendors/bootstrap/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>
</head>
<body>
<style>
body{
  background-color:#cdcdcd;
}
.padtop100{
  padding-top:100px;
}
.padtop10{
  padding-top:10px; 
}
.bg-red{
  background-color:#F0483E;
}
.red{
  color:#f00;
}
.color-white{
  color:white;
}
.panel{
  border-radius:10px; 
  box-shadow: 10px 10px 5px #888888;
}
.title-text{
  padding-top:10px;
  padding-bottom:10px;  
}
.form-content{
  padding-top:10px;
}
.no-top-padding{
  padding-top:0px;
}
</style>
<script>
$(document).ready(function(){
    
    $('.schoolID').select2({
    
     });
 
    
     function validateEmail(email) 
        {
        var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
        return re.test(email);
        }
     
                    $('input').keypress(function( e ) {
                                if(e.which === 32) 
                                    return false;
                            });
    
    
                        $("#newUserForm").submit(function(e){ 
                             e.preventDefault();

                        var error = "";
                        var valerror = "";   
                           

                           if($("#schoolList").val() == "Select School")
                            {
                                error += "<p>School name field is required</p>";
                            }
                            
                              if($("#CountryCode").val() == "")
                               {
                                    error += "<p>CountryCode field is required</p>";
                               }
                            if($("#phone").val() == "")
                               {
                                    error += "<p>Phone field is required</p>";
                               }
                            
                            if($("#prn").val() == "")
                            {
                                error += "<p>std_PRN field is required</p>";
                            }
                                                 
                           if($("#pass").val() == "")
                               {
                                    error += "<p>Password field is required</p>";
                               }
                           if($("#conpass").val() == "")
                               {
                                    error += "<p>Confirm password field is required</p>";
                               } 

                          
                            
                        if($("#email").val() && validateEmail($("#email").val()) == false)
                        {
                            valerror += "<p>Your email address is not valid!</p>";
                        } 
                            
                        if($("#phone").val() && $.isNumeric($("#phone").val()) &&  $("#phone").val().length==10 == false )
                        {

                        valerror += "<p>Your phone number is not valid!</p>";

                        }
                        
                        if($("#pass").val() != $("#conpass").val())
                        {

                        valerror += "<p>Your password does not match!</p>";

                        } 

                            if(valerror != "")
                            {
                                error += "There are some error(s)"+valerror;
                            }
                                  
                          if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }else{ 
                                
                                   $.ajax({ 
                                         type: "POST", 
                                         url: "<?php echo base_url();?>ChangePasswordBFLogin/addNewUserPass", 
                                         data:new FormData(this), //this is formData
                                         processData:false,
                                         contentType:false,
                                         cache:false, 
                                         success: function(data){
                                              alert(data);
                                              $("#error").hide();
                                              $('#newUserForm')[0].reset(); 
                                              window.location = "<?php echo base_url();?>Clogin/login/student";
                                           } 
                                      }); 
                                
                                  return false;
 
                            }
                        });
 
 
});
</script>
     
  <div class='container-fluid bgcolor'>
    <div class='row'>
      <div class='col-md-4 col-md-offset-4 padtop100'>
        <div class='panel panel-primary'>           
          <div class='panel-body'>                    
            <div class='row text-center'>             
              <?php if($isSmartCookie) {  ?>            
              <div class="visible-sm visible-lg visible-md">
                <img src="<?php echo base_url();?>Assets/images/logo/250_86.png" />
              </div>
<?php  }else{   ?>
              
              <div class="visible-sm visible-lg visible-md">
                <img src="<?php echo base_url();?>Assets/images/logo/pblogoname.jpg" />
              </div>
<?php } ?>
              <div class="visible-xs">
                <img src="<?php echo base_url();?>Assets/images/logo/220_76.png" />
              </div>
            </div>
                        
                        <div id="error"></div>
                        
            <div class='row bg-red text-center title-text'>
              <span class='panel-title color-white'><?php echo ucfirst(@$entity); ?> Change Password</span>
            </div>
            <div class='row form-content'>            
             <form id="newUserForm">
              <div class='col-md-12'>
              <div class='form-group'>
                <label for='LoginOption' >Change Password</label>
                                
                                
                    <select name='schoolList' id='schoolList' class='form-control schoolID' onfocus="resetReport()">
                                            <option>Select School</option>
                                            <?php foreach($schoolList as $row){?>
                                               
                                               <option value="<?php echo $row->school_id;?>"><?php echo $row->school_name;?></option>
                                            
                                            <?php }?>
                                            
                    </select>
                
              </div>
                                <br/>
                                 
                                <div class='form-group'>                
                <div class='col-md-3'>                  
                    <select name='CountryCode' id='CountryCode' class='form-control' style="position:relative; right:15px; width:130%" onfocus="resetReport()">
                        
                                                <option value='91'>+91</option>
                        <option value='1'>+1</option>
                    </select>                 
                </div>
                                    
                            
                                    
                <div class='col-md-9' style="width:75%">
                     
                                        <input type="number" name='phone'  id="phone" value="<?php echo $this->session->userdata('std_phone');?>" class='form-control' />
                </div>                  
                 </div> 
                                
                                <br/><br/>
                                <label>stu_PRN</label>
                                <div class='form-group'>                
                    <input type='text' name='prn'  id='prn' class='form-control' value="<?php echo $this->session->userdata('std_PRN');?>"/> 
                  </div>
                                 
                                
                                 <br/>
                                
              <div class='form-group'>                
                    <input type='text' name='oldpass'  id='pass' class='form-control' placeholder='Eenter password' />                
              </div>
                                 <br/> 
                            <div class='form-group'>                
                    <input type='text' name='newpass'  id='conpass' class='form-control' placeholder='Confirm password' />                
              </div> 
                                
                                <input type="hidden" name='email'  id='email' value="<?php echo $this->session->userdata('email');?>">
                                
               <br/>
                          
                                <div class='form-group'>                
                    <input type='text' class='form-control' value="<?php echo $this->session->userdata('email');?>"  placeholder='Eenter email id' disabled/> 
                  </div>
                                
                            <br/>    
                            
              </div>
             
              <div  class='col-md-12' style="margin-top:20px;">
               
              <div class='form-group' id='SubmitInput'>
                 
              
        <input type='submit' name='submit' id='submit' class='btn btn-primary' value='Login'/>         
        
              </div>

 
              </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>

