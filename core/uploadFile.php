<div id="mydiv" style="background-image:url(Koala.jpg) ;background-size: 100%;
background-size :200px 200px;
background-repeat: no-repeat;">
<p>text!</p>
<img src="mug.png" height="100" width="100"/></div>
<div id="canvas">
<p>Canvas:</p>
</div>

 <div style="width:200px; float:left" id="image">
 <p style="float:left">Image: </p>
 </div>
 <div style="float:left;margin-top: 120px;" class="return-data">
 </div>
 <script src="js/html2canvas.js"></script>
 <script src="js/jquery.min.js"></script>
<style>
#mydiv {
background-color: lightblue;
width: 200px;
height: 200px
}
</style>

 <script language="javascript">
    html2canvas([document.getElementById('mydiv')], {
    onrendered: function (canvas) {
    document.getElementById('canvas').appendChild(canvas);
    var data = canvas.toDataURL('image/png');
     //display 64bit imag
     var image = new Image();
    image.src = data;
    document.getElementById('image').appendChild(image);
    // AJAX call to send `data` to a PHP file that creates an PNG image from the dataURI string and saves it to a directory on the server

    var file= dataURLtoBlob(data);

// Create new form data
var fd = new FormData();
fd.append("imageNameHere", file);

$.ajax({
   url: "uploadFile.php",
   type: "POST",
   data: fd,
   processData: false,
   contentType: false,
}).done(function(respond){

    $(".return-data").html("Uploaded Canvas image link: <a href="+respond+">"+respond+"</a>").hide().fadeIn("fast");
    });

  }
});

function dataURLtoBlob(dataURL) {
// Decode the dataURL    
var binary = atob(dataURL.split(',')[1]);
// Create 8-bit unsigned array
var array = [];
for(var i = 0; i < binary.length; i++) {
    array.push(binary.charCodeAt(i));
 }
// Return our Blob object
return new Blob([new Uint8Array(array)], {type: 'image/png'});
 }

</script>