<?php $this->load->view('sp/header');

?>

<!--END THEME SETTING-->
<div id="page-wrapper"><!--BEGIN SIDEBAR MENU-->

    <!--END SIDEBAR MENU--><!--BEGIN CHAT FORM-->

    <div class="row mbl" style="display:none;">
        <div class="col-lg-8">
            <div class="panel">
                <div class="panel-body">
                    <div class="row">
                        <div id="area-chart-spline" style="width: 100%; height:300px"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div id="form-layouts" class="row">

            <div class="col-lg-12">

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6" style="border:dashed; background-color:#FFF; margin-top:60px;  padding-bottom:20px; margin-right:200px;margin-left:50px;">

                        <div clas="row" align="center">
                            <img src="<?php echo base_url().'\images\220_76.png'?>" style="width:281px;margin:0; auto;">
                        </div>

                        <div clas="row" align="center">
                            <h2><b>SmartCookie Accepted Here</b></h2>
                        </div>

                        <div class="row" align="center" style="margin-top:5%;">
                        <div class="thumb">
                            <img src="<?php echo imageurl($user[0]->sp_img_path,'avatar','sp_profile');?>" style="max-width:100%;max-height:100%; " alt="" class="img-circle"/>
                        </div>
                        <div class="info">
                            <p><font size="4"><b><?=$user[0]->sp_company;?></b></font></p>
                            <p>Sponsor</p>
                            <div class='row text-center' style='background-color:#CF4346;width:100px; margin:0 auto;'>
                                <p><font color="black" size="4"><?='V'.$user[0]->id;?></font></p>
                            </div>
                        </div>
                    </div>
<!--                        <div class="row" align="center" style="margin-top:5%;">-->
<!--                            <label for="usr">Merchant Name</label>-->
<!---->
<!--                            <input type="text" class="form-control" id="usr" value="--><?php //echo $user[0]->sp_name;;?><!--" style="width:280px;" readonly>-->
<!--                        </div>-->
<!--                        <div class="row" align="center" style="margin-top:5%;">-->
<!--                            <label for="pwd">ID</label>-->
<!--                            <input type="text" class="form-control" id="" value="--><?php //echo "V".$user[0]->id;;?><!--" style="width:280px;" readonly>-->
<!--                        </div>-->


                        <div class="row" align="center" style="margin-top:5%;" id="result">
                            <?php
                            $output1="V";
                            $output=$output1.$user[0]->id;
                            echo "<img src='".base_url()."/application/views/qr_img0.50j/php/qr_img.php?d=$output' style=\"width:200px; margin:0 auto;\" >";
                            ?>
                        </div>
<!--                        <div style="background-color:#257cc1; width:640px; height: 30px; margin-left: -15px; margin-top: 100px; class="row">-->
<!---->
<!--                            <span style="color: black;">www.smartcookie.com</span>-->
<!--                        </div>-->

                    </div>
                </div>
            </div>

        </div>

    </div>

    <!--END CONTENT--><!--BEGIN FOOTER-->
    
</div>

<?php
    $this->load->view('sp/footer');
    ?>

</body>
</html>