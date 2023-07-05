<?php
//print_r($emaildetails); 
 
        $email1=$emaildetails[0]['Email_id'];
        $email2=$emaildetails[1]['Email_id'];
        $email3=$emaildetails[2]['Email_id'];
      
?>
<html>
<head>
<script type="text/javascript">
    function EnableDisableTextBox(chkPassport) {
        var txtPassportNumber = document.getElementById("txtPassportNumber");
        txtPassportNumber.disabled = chkPassport.checked ? false : true;
        if (!txtPassportNumber.disabled) {
            txtPassportNumber.focus();
        }
    }
    function EnableDisableTextBox1(chkPassport1) {
        var txtPassportNumber1 = document.getElementById("txtPassportNumber1");
        txtPassportNumber1.disabled = chkPassport1.checked ? false : true;
        if (!txtPassportNumber1.disabled) {
            txtPassportNumber1.focus();
        }
    }
    function EnableDisableTextBox2(chkPassport2) {
        var txtPassportNumber2 = document.getElementById("txtPassportNumber2");
        txtPassportNumber2.disabled = chkPassport2.checked ? false : true;
        if (!txtPassportNumber2.disabled) {
            txtPassportNumber2.focus();
        }
    }
    function validateEmail(emailField){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        
         if (emailField.value == '') 
        {
            alert('Please enter Email Address');
            return false;
        }
        else if (reg.test(emailField.value) == false) 
        {
            alert('Principal Email Address is incorrect');
            return false;
        }


        return true;

}
      function validateEmail1(emailField1){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        
       if (emailField1.value == '') 
        {
            alert('Please enter Email Address');
            return false;
        }
        else if (reg.test(emailField1.value) == false) 
        {
            alert('Coordinator Email Address is incorrect');
            return false;
        }
        
        

        return true;
      }
      function validateEmail2(emailField2){
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if (emailField2.value == '') 
        {
            alert('Please enter Email Address');
            return false;
        }
        else if (reg.test(emailField2.value) == false) 
        {
            alert('Head of Department Email Address is incorrect');
            return false;
        }
       

        return true;
      }
      
</script>

</head>


 
<body>
  <div class="container">

<h1 style="margin-left: 400px;">Select Whom To Send Email</h1>

<form method="post" action="" name="myForm" style="margin-left: 400px;">
  <!-- <div class="checkbox-group-required"> -->
 <div class="row">
  <div class="col-md-7">
     
 
  <input type="checkbox" id="chkPassport" name="check[]" value="1" onclick="EnableDisableTextBox(this)">
  <label><h4> Principal</h4></label><br>
  
 
  <input type="text" id="txtPassportNumber" disabled="disabled" class="form-control input-lg" name="email1" value="<?php echo $email2;?>" onblur="validateEmail(this);"  /><br><br>
  </div>
</div>
  <div class="row">
  <div class="col-md-7">
  <input type="checkbox" id="chkPassport1" name="check[]" value="2" onclick="EnableDisableTextBox1(this)">

  <label><h4>Coordinator</h4></label><br>
  
  <input type="text" id="txtPassportNumber1" disabled="disabled" class="form-control input-lg" name="email2" value="<?php echo $email3; ?>" onblur="validateEmail1(this);" /><br><br>
</div>
</div>
<div class="row">
  <div class="col-md-7">
  <input type="checkbox" id="chkPassport2" name="check[]" value="3" onclick="EnableDisableTextBox2(this)">
  
  <label> <h4>Head of Department</h4></label><br>
 
  <input type="text" id="txtPassportNumber2" disabled="disabled" class="form-control input-lg" name="email3" value="<?php echo $email1; ?>" onblur="validateEmail2(this);" /><br><br>
</div>
</div>
  <button type="submit" class="btn btn-primary" name="save">SEND EMAIL</button>
   <button type="submit1" name="submit1" class="btn btn-danger">CANCEL</button>
</form>
</div>
</div>


</body>
</html>


