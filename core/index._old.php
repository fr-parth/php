<?php 
include 'index_header.php'; 

function imageurl($value,$type='',$img=''){
			//$logoUrl=@get_headers(base_url('/Assets/images/sp/profile/'.$value));
			if($img=='sp_profile'){
				$path='sp/profile/';
			}elseif($img=='product'){
				$path='sp/productimage/';
			}elseif($img=='spqr'){
				$path='sp/coupon_qr/';
			}else{
				$path='';
			}
			$base_url='http://test.smartcookie.in/';
			$logoUrl=@get_headers($base_url.'/Assets/images/'.$path.$value);
			$tlogoUrl=@get_headers('http://tsmartcookies.bpsi.us/'.$value);
			$slogoUrl=@get_headers('http://www.smartcookie.in/'.$value);
			if($logoUrl[0] == 'HTTP/1.1 200 OK' && $value!='new-product.jpg' && $value!='' ){
				$logoexist=$base_url.'/Assets/images/'.$path.$value;
			}elseif($tlogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://tsmartcookies.bpsi.us/'.$value;
			}elseif($slogoUrl[0] == 'HTTP/1.1 200 OK' && $value!=''){
				$logoexist='http://www.smartcookie.in/'.$value;
			}else{
				if($type=='sclogo'){
					$logoexist=$base_url.'/Assets/images/sp/profile/newlogo.png';
				}elseif($type=='avatar'){
					$logoexist=$base_url.'/Assets/images/avatar/avatar_2x.png';
				}else{
					//$logoexist=$base_url.'/Assets/images/sp/profile/imgnotavl.png';
					//dont give default image here
					$logoexist='';
				}				
			}
			return $logoexist;
}
?> 
<!-- 
<style> 
#gallery{  

    img{
        max-height: 100px;
        max-width: 100px;
    }
}
       
#gallery img {
    -o-object-fit: cover;
    object-fit: cover;
    overflow: hidden;
}

</style>   -->  


                          <div class="row2  bg-wht">         
                                 		<div class="container "> 
                                        <div class="row">                                              
                                                 <div class=" col-md-12  text-center" style="padding-top:25px;" >
                        							     	<img src="images/signin-imgbg.jpg" class="img-responsive">
                                               </div>
                                     </div>
                               </div>
							   
							   
							   
							    <div class="container">
				<?php $sci=mysql_query("SELECT distinct img_path, school_name FROM tbl_school_admin WHERE img_path IS NOT NULL "); 
					$scrows=mysql_num_rows($sci);
					if($scrows>0){
						?>				
								<!--our educational sponsor start here-->
                            <div class="row bg-mar">
								<h2 class='text-center'>Our Educational Partners</h2>
							<div class=" clearfix">
						
							<marquee>						

			<?php
			while($scres=mysql_fetch_array($sci)){
				$scimg=imageurl($scres['img_path'],'','');
				if($scimg!=''){
					?>
				
							<img src="<?=$scimg;?>" alt="" height='100px' title="<?=$scres['school_name']?>">
			
					<?php
				}
			}			
			?>	
							
							</marquee>
							</div>
							</div>
					<?php } ?>
								<!--our educational sponsor end here-->
								
								
									<!--our  sponsor start here-->
							
			<?php 
/* 			$maxid1=mysql_query("SELECT max(id) from tbl_sponsorer");
			$maxid=mysql_fetch_array($maxid1);
			$ids=array();
			for($i=0;$i<50;$i++){
				$ids[]=rand(1,$maxid);
			}
			
			$qu */
						
			$spi=mysql_query("SELECT sp_img_path, sp_company FROM tbl_sponsorer WHERE sp_img_path IS NOT NULL ORDER BY RAND() LIMIT 10"); 
			
			
					$sprows=mysql_num_rows($spi);
					
					if($sprows>0){
						
						?>
				
									    <div class="row bg-mar">
								<h2 class='text-center'>Our sponsors</h2>
							<div class=" clearfix">
						
						<marquee>
						
			<?php
			while($spres=mysql_fetch_array($spi)){
				$img=imageurl($spres['sp_img_path'],'sp_profile','');
				
				if($img!=''){
					
					?>
					
					<img src="<?=$img;?>" alt=""  height='100px' title="<?=$spres['sp_company']?>">
					
					<?php
				}
			}			
			?>		
					</marquee>
							</div>
							</div>
					<?php } ?>					<!--our  sponsor end here-->
							</div>
							
							
							
                        </div>
                       
<?php include 'index_footer.php'; ?>