<?php 
  $this->load->view('stud_header',$studentinfo); 
 ?>

<!DOCTYPE html>
<html lang="en"> 
  <head>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
* {
  box-sizing: border-box;
}

/* Add a gray background color with some padding */
body {
  font-family: Arial; 
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
  padding: 30px;
  font-size: 40px;
  text-align: center;
  background: white;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
 /* float: left;*/
  width: 100%;
  padding-left: 40px;       
}

/* Right column */
.rightcolumn {
    /*float: left;*/
    width: 25%;
    padding-left: 20px;
    position: relative;
    right: 10px;
}

/* Fake image */
.fakeimg {
/*  background-color: #aaa;*/
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
.card {
   background-color: white;
   padding: 15px 15px 42px 15px;
   margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Footer */
.footer {
  padding: 20px;
  text-align: center;
  background: #ddd;
  margin-top: 20px;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 800px) {
  .leftcolumn, .rightcolumn {   
    width: 100%;
    padding: 0;
  }
}
        
        .blogAdd{
            
            padding: 20px;
        }
        
        .blogDesc{
            
            background-color: antiquewhite;
            padding: 15px;
            border-radius: 10px;
            font-size: 16px;
        } 
        
        .checked {
          color: orange;
          font-size: 22px;
          margin-left: 5px;    
        }
        
          #que_is_sub{ 
/*           // width: 300px !imporatant;*/
            margin-left: -46px !important; 
        }
        
        .que_width{ 
            
            margin-left: 20px;
        }
        
        
        @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

            fieldset, label { margin: 0; padding: 0; }
 
            .rating { 
              border: none;
              float: left;
            /*  width: 188px;*/
            }

            .rating > input { display: none; } 
            .rating > label:before { 
              margin: 5px;

              font-size: 1.25em;
              font-family: FontAwesome;
              display: inline-block;
              content: "\f005";
            }

            .rating > .half:before { 
              content: "\f089";
              position: absolute;
            }

            .rating > label { 
              color: #ddd; 
             float: right; 
            }

            /***** CSS Magic to Highlight Stars on Hover *****/

 
            .rating > input:checked ~ label,  
            .rating:not(:checked) > label:hover,  
            .rating:not(:checked) > label:hover ~ label { color: #FFD700;  }  

            .rating > input:checked + label:hover,  
            .rating > input:checked ~ label:hover,
            .rating > label:hover ~ input:checked ~ label,  
            .rating > input:checked ~ label:hover ~ label { color: #FFED85;  } 
   
 
        
        .rating input:checked~label,
        .rating input:not(:checked):not(:disabled) + label:hover,
        .rating input:not(:checked):not(:disabled) + label:hover~label {
 
        color: #FFD700;}
 
       .rating label {
            display: block;
            float: right;
            height: 17px;
            margin-top: 5px;
            padding: 0 0px !important;
            font-size: 17px;
            line-height: 17px;
            cursor: pointer;
            color: #ccc;
            -ms-transition: color 0.3s;
            -moz-transition: color 0.3s;
            -webkit-transition: color 0.3s;
        } 
        
        
        .rating_width{
            width: 170px;
        }
        
        #myTable{
                margin-left: -46px !important; 
        }
        
        .que_dis_num{
            
            margin-left: 50px;
        }
        
        #subFeddback{
            
            margin-right: 24px;
        }
        
        .modal-footer {
            margin-top: 15px;
            padding: 19px 20px 20px;
            text-align: right;
            border-top: none !important;  
        }
        
        .highlight{
            color: #fcb800 !important;
             
        }
        

        /*.fa-star{
             color: #fcb800;
             font-size: 25px;
        }*/
        
        .chSubj{
            position: relative;
            right: 45px;
        }
 
        .textComment{
            position: relative;
            right: 0px;
        }
        
        .tesDis {
                position: relative;
                right: 45px;
            }
        .postrate{
            color: #3c763d;
            font-size: 15px;
        }
        
        .strRate{
            position: relative;
            top: 60px; 
            border-radius: 0px;         
            font-size:24px;
            color: #fcb800;
            margin-left: 85px;
        }
        
        .shareit{
            font-size: 25px;
            float: right; 
        }
        
   .stars i {
  font-size: 26px;
  padding: 3px;
}

.stars i:hover {
  color: red;
}    
    
    .str {
  color: orange;
}
</style>
 
</head> 
    <title>Student Rating</title>  
<body>    
     <div id="area-chart-spline" style="width: 100%; height:300px; display:none;"></div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->            
        <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <div class="page-header pull-left">
                    <div class="page-title">Blog</div>
                </div>
                <ol class="breadcrumb page-breadcrumb pull-right">
                    <li><i class="fa fa-home"></i>&nbsp;<a href="/main/members">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                   
                    <li class="active">Blog</li>
                </ol>
                <div class="clearfix"></div>
            </div>
 
                 <?php if($this->session->flashdata('error')){
    
                    echo '<div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' . $this->session->flashdata('error') . '</div>';
                } ?>


                <?php if($this->session->flashdata('success')){
                    echo
                     '<div class="alert alert-success alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'. $this->session->flashdata('success') . '</div>'; } ?>        
            
            <a href="" user_id="" class="btn btn-primary btn_add" id="btn_add" data-toggle="modal" data-target="#addBlog"><strong>Add Blog</strong></a>         
<div id="addBlog" class="modal fade">
    <div class="modal-dialog">  
        <form id="addStudBlogPost"> 
            <div class="modal-content">
                <div class="modal-header">
                   <h4 class="modal-title">Blog Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                </div>  
                <div id="error"></div> 
                <div class="modal-body"> 
                    <label>Blog Title</label>
                    <input type="text" class="form-control" id="Blog_title" name="Blog_title" value="" >
                    <br/>
                     <label>Description</label>
                     <textarea type="text" class="form-control" id="Description" name="Description" value=""></textarea>
                    <br/>             
                <div class="form-group">   
                    <label class="control-label" for="dept">Activity Type</label> 
                                 <select class="form-control" id="act_type" name="act_type">
                                    <option value="">Select Activity Type</option>
                                     
                                     <?php 
                                  
                                     foreach($act_type as $row) { ?>

                                          <option value="<?php echo $row->id;?>"><?php echo $row->activity_type; ?></option>
                                     
                                     <?php }  ?>

                                  </select> 
                </div>  
                 <br/>
                  
                <div class="form-group">   
                    <label class="control-label" for="dept">Activity</label> 
                                 <select class="form-control" id="activityID" name="activityID"> 
                                  </select>
                                  <p id="act_error" style="color:red;">
                                    
                                  </p>
                      
                </div>  
                    <br/>  
                    <br/> 
                    <label>Choose image</label>
                    <input type="file" name="add_img"  id="add_img" value="" class="form-control"/> 
                   
                </div>
                <div class="modal-footer"> 
 
                    <input type="submit" name="submit" id="submit" value="Add" class="btn btn-success" />
 
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>  
        </form> 
    </div>
</div>   
            <div id="disStudentBlog"></div>
            
             
                 <br/><br/><br/><br/>
  
                  <?php  
                         $this->load->view('footer'); 
                   ?>
  
 </div> 
 
    <script type="text/javascript">
                            $(document).ready(function(){
                                 $(document).on('click','.str', function(){                        
                                     var Stu_blog_PRN       = $(this).attr("stu_PRN");
                                     var Stu_blog_school_id = $(this).attr("school_id");
                                     var Stu_blog_rate      = $(this).attr("u_data");
                                     var Stu_blog_member_id = $(this).attr("member_id");
                                     var Stu_blog_id        = $(this).attr("blog_id"); 
                                     $.ajax({
                                         type: "POST",
                                         url: "<?php echo base_url();?>Aictefeed/insertStarRating", 
                                         data:{Stu_blog_PRN:Stu_blog_PRN,Stu_blog_school_id:Stu_blog_school_id,Stu_blog_rate:Stu_blog_rate,Stu_blog_member_id:Stu_blog_member_id,Stu_blog_id:Stu_blog_id}, //this is  
                                         success: function(data){
                                              alert(data); 
                                              console.log(data);
                                              showStuBlog();
                                           } 
                                      }); 

                                 return false;
             
                                });       
                           showStuBlog();
                          
                           function showStuBlog()
                           {    
                              $.ajax({ 
                               url   :"<?php echo base_url();?>Aictefeed/studentDisBlog",
                               method:"POST", 
                               success:function(data)
                               {  
                                  $("#disStudentBlog").html(data);
                                   
                                }
                              });
                           }
                           showStuBlog();         
                        //             $('input').keypress(function( e ) {
                        //                                if(e.which === 32) 
                        //                                    return false;
                        // //                           });
           
            
                      $("#act_type").on("change",function(){
                           var actTypeID = $("#act_type").val();                   
                                $.ajax({ 
                                url:"<?php echo base_url();?>/Aictefeed/fetchActTypeID",
                                method:"POST", 
                                data:{actType:actTypeID}, 
                                   success:function(data)
                                   {  
                                      if(data){
                                        $("#activityID").html(data);   
                                      }
                                      else {
                                        document.getElementById("act_error").innerHTML = "No activity found for selected activity type!!";
                                        //$("#act_error").html("No activity found for selected activity type!!");   
                                        
                                        //alert("No activity found for selected activity type!!");
                                      }
                                   }
                               });
                             return false;
                  
                            });           
           
       $("#addStudBlogPost").submit(function(e){

         e.preventDefault();
               var error = "";
               
                              if($("#Blog_title").val() == "")
                                {
                                    error += "<p>Blog title field is required</p>";
                                } 
                               if($("#Description").val() == "")
                                {
                                    error += "<p>Description field is required</p>";
                                }
                               if($("#act_type").val() == "")
                                {
                                    error += "<p>Activity type field is required</p>";
                                }
                               if($("#activityID").val() == "")
                                {
                                    error += "<p>Activity field is required</p>";
                                } 
                     
                                  
                     if(error != "")
                            {

                               $("#error").html("<div class='alert alert-danger'><strong>"+error+"</strong></div>"); 
                                
                                return false;

                            }else{ 

                                 $.ajax({
                                         type: "POST",
                                         url: "<?php echo base_url();?>Aictefeed/addStuBlogPost", 
                                         data:new FormData(this), //this is formData
                                         processData:false,
                                         contentType:false,
                                         cache:false, 
                                         success: function(data){
                                              alert(data);
                                              $("#error").hide();
                                              $('#addStudBlogPost')[0].reset();
                                              $("#addBlog").modal('hide');
                                              showStuBlog()
                                           } 
                                      }); 

                                 return false;
                                 
                                }
                           
                      }); 

            
        });
           

    </script>
  
</body>
</html>

