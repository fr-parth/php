	<div class='col-sm-6 col-md-2'>
        <div class='panel db mbm panel-green'>
            <div class='panel-body' ><h4 class='value'><?php if($userinfo[0]->green==''){ echo '0';}else{ echo $userinfo[0]->green;}?></h4>
			<!--Reward Points camel casing done by Pranali for bug SMC-3370-->
                <p class='description'>Reward Points</p>
            </div>
        </div>
    </div>
    <div class='col-sm-6 col-md-2'>
        <div class='panel db mbm panel-yellow'>
            <div class='panel-body'><h4 class='value'><?php if($userinfo[0]->yellow==''){ echo '0';}else{ echo $userinfo[0]->yellow;}?></h4>
				<p class='description'>Friendship Points</p>
            </div>
        </div>
    </div>
		<?php
						 if($this->session->userdata('usertype')=='student'){   ?> 
    <div class='col-sm-6 col-md-2'>
        <div class='panel db mbm panel-violet'>
            <div class='panel-body' ><h4 class='value'><?php if($userinfo[0]->purple==''){ echo '0';}else{ echo $userinfo[0]->purple;}?></h4>
                <p class='description'>Family Points</p>
            </div>
        </div>
    </div>
						 <?php }?>
	
	<div class='col-sm-6 col-md-2'>
        <div class='panel db mbm'>
            <div class='panel-body' ><h4 class='value'><?php if($userinfo[0]->water==''){ echo '0';}else{ echo $userinfo[0]->water;}?></h4>
                <p class='description'>Water Points</p>             
            </div>
        </div>
    </div>
	
	<div class='col-sm-6 col-md-2'>
        <div class='panel db mbm '>
            <div class='panel-body'><h4 class='value'><?php echo $rem_pts=$userinfo[0]->green + $userinfo[0]->yellow +   $userinfo[0]->purple + $userinfo[0]->water  ;?></h4>

                <p class='description'>Available Points</p>

            </div>
        </div>
    </div>
	
	<div class='col-sm-6 col-md-2'>
	<a href="<?php echo site_url('Ccoupon/cart'); ?>">
        <div class='panel db mbm '>
            <div class='panel-body'><p class='icon'><i class='icon fa fa-shopping-cart'></i></p><h4 class='value'><?=$cart_items['rows']; ?></h4>
				<p class='description'>My Cart</p>
            </div>
        </div>
	</a>	
    </div>