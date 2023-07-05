
<script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>

<!--UI design modified by Pranali for SMC-4689 on 4-5-20-->

    <?php if(isset($msg)){?>
    <tr>
      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
    </tr>
    <?php } ?>
    <tr width="400" border="0" align="center" cellpadding="2" cellspacing="1" class="table">      
      <td>
        <label for='message' style="margin-left: -90px;">Enter the code here :</label>
        <br>
        <input id="captcha_code" name="captcha_code" type="text" style="margin-left: -64px;" autocomplete="off">
        
    </td>
    <td>
        <img src="phpcaptcha/captcha.php?rand=<?php echo rand();?>" id='captchaimg' style="margin-left: -595px;margin-top:12px"><br>
        <br>
         </td>
         </tr>
         <tr>
            <td>
        Can't read the image? Click <a href='javascript: refreshCaptcha();'>here</a> to refresh.
    </td>
   </tr>
    

