
<?php
include_once('cookieadminheader.php');
 $id=$_SESSION['id'];


?>

<html>
<head>


<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
-->
<script>

function callajax(){
    $.ajax({

        url: "student_reason_list.php",
        type:'post',
        success: function(result){
        $("#student_reason_list").html(result);
  }});
};
$(document).ready(function(){
callajax();
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever');
    var array = recipient.split(','); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body #recipient-name').val(array[0])
    modal.find('.modal-body #nik-name').val(array[1])
  });
  $('#addreason').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('whatever');
    var array = recipient.split(','); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body #recipient-name').val(array[0])
    modal.find('.modal-body #nik-name').val(array[1])
  });
});


function addreason_task(){



  var reason = document.getElementById('add_reason_name').value;
  var reg1 = /^[A-Za-z A-Za-z]+$/;
  var res = reg1.test(reason);

  if(res==false)
  {
     document.getElementById('add_error').innerHTML = 'enter only a-z alphabates';
     return false;
  }
  else {
      var reason = $('#add_reason_name').val();
    $.ajax({
    url: "add_student_reason.php",
    type:'post',
    data:({reason:reason}),
    success: function(result){
      if(result == "already present")
      {
        //alert("eret");
       document.getElementById('add_error').innerHTML = 'Reason Is Already Present';
      }
      else if(result == true)
      {
        document.getElementById('add_error').innerHTML = '';
       document.getElementById('add_success').innerHTML = 'Successfully Added Reason';
       callajax();
      }
      else {
        document.getElementById('add_error').innerHTML = 'Error In Insertion';
      }
  }
})

}
}

function delete_reason(id)
{
  //alert('srsr');
  //alert(id);
  if(window.confirm("Do you want to delete reason"))
  {
    //alert('yes');
    $.ajax({
    url: "deletereason.php",
    type:'post',
    data:({id:id}),
    success: function(result){
      if(result == true)
      {
        alert('Record Deleted Successfully');
        callajax();
      }
      else {
        alert('Error In Deletion');
      }
  }
})
  }
  
}

function removedata()
{
  document.getElementById('edit_error').innerHTML = '';
  document.getElementById('edit_success').innerHTML = '';
  document.getElementById('add_reason_name').value = '';
}

  function editreason_task(){

    console.log('ureguie');

    var reason = document.getElementById('recipient-name').value;
    var reg1 = /^[A-Za-z A-Za-z]+$/;
    var res = reg1.test(reason);

    if(res==false)
    {
       document.getElementById('edit_error').innerHTML = 'enter only a-z alphabates';
       return false;
    }
    else {
        var reason = $('#recipient-name').val();
        var row_id = $('#nik-name').val();
      $.ajax({
      url: "editreason.php",
      type:'post',
     data:({reason:reason,row_id:row_id}),
      success: function(result){
        if(result == true)
        {
         document.getElementById('edit_success').innerHTML = 'successfully updated reason';
         callajax();
        }
        else {
          document.getElementById('edit_error').innerHTML = 'error in insert';
        }
    }
  })

  }
}

</script>


</head>
<body>

  <div class="container">
    <div class="radius " style="height:50px; width:100%; background-color:#694489;" align="center">
      <!--Heading changed from Student Recognization to Student Recognition Reason by Pranali -->
            	<h2 style="padding-left:20px;padding-top:15px; margin-top:20px;color:white">Student Recognition Reason</h2>
            </div>
    <div class="panel panel-default">
      <div class="panel-heading" align='center'>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reason" data-whatever="@mdo,nik">Add Reason</button>
          <div class="modal fade" id="reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <form>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group">
                      <div class="radius " style="height:30px; width:100%; background-color:#9F5F9F;" align="center">
                               	<h4 style="padding-left:20px;padding-top:5px; margin-bottom:20px;color:white">Add Reason</h4>
                               </div>
                      <input type="text" class="form-control" id="add_reason_name">
                    </div>
                    <h5 id='add_error' style='color:red'></h5>
                    <h5 id='add_success' style='color:green'></h5>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" onclick="removedata()"  data-dismiss="modal">Close</button>
                  <button type="button" onclick="addreason_task()" class="btn btn-primary" name='edit' id='edit'>Submit</button>
                </div>
              </form>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="panel-body" align='center'>
        <table id="example" class="display "  width="80%" cellspacing="0">
            <thead>
                <tr style='background-color:#9F5F9F;color:white;font-size:20px;padding:10px' align='center'>
                    <th style='padding:5px' align='center'>Sr. No.</th>
                    <th>Reason</th>

                    <th>Edit</th>
                    <th>Delete</th>


                </tr>
            </thead>



            <tbody id='student_reason_list'>



            </tbody>
        </table>

      </div>
    </div>
  </div>


  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <form>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
               <div class="radius " style="height:30px; width:100%; background-color:#9F5F9F;" align="center">
                        	<h4 style="padding-left:20px;padding-top:5px; margin-bottom:20px;color:white">Edit Reason</h4>
                        </div>
              <input type="text" class="form-control" id="recipient-name">
              <input type="hidden" class="form-control" id="nik-name">
            </div>
            <h5 id='edit_error' style='color:red'></h5>
            <h5 id='edit_success' style='color:green'></h5>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="removedata()"  data-dismiss="modal">Close</button>
          <button type="button" onclick="editreason_task()" class="btn btn-primary" name='edit' id='edit'>Submit</button>
        </div>
      </form>
      </div>
    </div>
  </div>



</body>
</html>
