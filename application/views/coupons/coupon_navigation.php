			<?php if($this->session->entity!='sponsor'){ ?>	
				<li <?php if(uri_string()=='Ccoupon/select_coupon' or 
								uri_string()=='Ccoupon/cart' or
								uri_string()=='Ccoupon/unused_coupons' or
								uri_string()=='Ccoupon/used_coupons'){ 
								echo 'class="active"'; 
						} ?> >
					<a href="#"><i class="fa fa-desktop fa-fw"></i><span class="menu-title">Sponsor Coupons</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li <?php if(uri_string()=='Ccoupon/select_coupon'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Ccoupon/select_coupon'); ?>"><i class="fa fa-briefcase"></i><span class="submenu-title">Select Coupon</span></a></li>
							<li <?php if(uri_string()=='Ccoupon/cart'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Ccoupon/cart'); ?>"><i class="fa fa-briefcase"></i><span class="submenu-title">Cart</span></a></li>
							
							<li <?php if(uri_string()=='Ccoupon/unused_coupons'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Ccoupon/unused_coupons'); ?>"><i class="fa fa-briefcase"></i><span class="submenu-title">My Coupons</span></a></li>	
							
							<li <?php if(uri_string()=='Ccoupon/used_coupons'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Ccoupon/used_coupons'); ?>"><i class="fa fa-briefcase"></i><span class="submenu-title">Used Coupons</span></a></li>	
                            
                        </ul>
                    </li>
					<li <?php if(uri_string()=='Ccoupon/suggested_sponsors' or 
								uri_string()=='Ccoupon/suggest_sponsor'){ 
											echo 'class="active"'; } ?> >
								<a href="<?php echo site_url('Ccoupon/suggested_sponsors'); ?>"><i class="fa fa-bookmark"></i><span class="menu-title">Suggest Sponsor</span></a></li>
			<?php } ?>	