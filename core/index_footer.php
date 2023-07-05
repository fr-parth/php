<?php //include('securityfunctions.php'); 

?>

                         <div class="row" style="background-color:#FFFFFF;padding-top:10px;"  ></div>
						 <div class="row4 ">
                		   <div class=" col-md-12 text-center footer2txt" >
                        	<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/about-us.php"; ?>">About Us</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/contact-us.php"; ?>">Contact Us</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/SmartCookie.pdf"; ?>"target='_blank'>Info</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/student.php"; ?>">Students</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/college.php"; ?>">School/College</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/teacher.php"; ?>">Teachers</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/parent.php"; ?>">Parents</a> |

								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/core/sponsor.php"; ?>">Vendors/Sponsors</a> |
								
								<a href="<?php $site=$_SERVER['HTTP_HOST'];
								echo base_url()."/help"; ?>">Help</a>

                                   <!-- <a href="contact-us.php">Contact Us</a> |
                                    <a href="SmartCookie.pdf" target='_blank'>Info</a>
                                    <a href="student.php">Students</a> |
                                    <a href="college.php">School/College </a> |
                                    <a href="teacher.php">Teachers</a> |
                                     <a href="parent.php">Parents</a> |
                                     <a href="sponsor.php">Vendors/Sponsors </a>
                           </div>
                  </div>

                  <div class=" row5">
                		<div class=" col-md-12 text-center footer3txt" >
                        <div class="container ">
                                  <div class="row">
                                       Blue Planet Info Solutions © <?php echo date('Y',time());?> :
                                        <a href="#">User Agreement </a> |
                                        <a href="privacypolicy.php">Privacy Policy</a> |
                                        <a href="#">Cookie Policy</a> |
                                        <a href="#"> Copyright Policy </a>
                                    </div>
                        </div>
                  </div>
                </div>


<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Open+Sans::latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
  </body>
</html>
