<?php
/* lat/lng data will be added to this array */
include("cookieadminheader.php");
if(!isset($_SESSION['id']))
{
    header('location:login.php');
}
$salesperson_id=$_GET['salesperson_id'];
$locations=array();
$timediff=array();
$query =mysql_query("SELECT sp_company,sp_name,sp_date,sp_address,sp_country,sp_city,sales_p_lat,sales_p_lon FROM tbl_sponsorer where sales_person_id=$salesperson_id AND sales_p_lon!='' AND sales_p_lat!=''");
$num_rows = mysql_num_rows($query);
if(isset($_POST['submit'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    switch(true)
    {
        case ($from_date !='' && $to_date!=''):
            if($from_date == $to_date){
                $query =mysql_query("SELECT sp_company,sp_name,sp_date,sp_address,sp_country,sp_city,sales_p_lat,sales_p_lon FROM tbl_sponsorer where sales_person_id=$salesperson_id AND sales_p_lon!='' AND sales_p_lat!='' AND `sp_date` like '%$from_date%'");
                $num_rows = mysql_num_rows($query);
            }else {
                $query = mysql_query("SELECT sp_company,sp_name,sp_date,sp_address,sp_country,sp_city,sales_p_lat,sales_p_lon FROM tbl_sponsorer where sales_person_id=$salesperson_id AND sales_p_lon!='' AND sales_p_lat!='' AND `sp_date` BETWEEN '$from_date' AND '$to_date%'");
                $num_rows = mysql_num_rows($query);
            }
            break;
        default:
            $query =mysql_query("SELECT sp_company,sp_name,sp_date,sp_address,sp_country,sp_city,sales_p_lat,sales_p_lon FROM tbl_sponsorer where sales_person_id=$salesperson_id AND sales_p_lon!='' AND sales_p_lat!=''");
            $num_rows = mysql_num_rows($query);
            break;
    }
}
$data_array = array();
   while( $row=mysql_fetch_assoc($query)) {
    /* Each row is added as a new array */
       $data_array[] = $row;
       $res[] =$row;
      $time1=strtotime(str_replace('/', '-',$timediff['$index']));
      $time2=$timediff['$index'+1];
       $hourdiff = round((strtotime($time1) - strtotime($time2))/3600, 1);
      $locations[] = array(
            "title"=>$row['sp_company'],
            "lat"=>$row['sales_p_lat'],
            "lng"=>$row['sales_p_lon'],
            "description"=>"Sponsor Name : <b>".$row['sp_name']."</b><br>Shop Name : <b>".$row['sp_company']."</b><br>Address : <b>".$row['sp_address'].",".$row['sp_city'].",".$row['sp_country']."</b><br> Reg.Date : <b>".$row['sp_date']
          );
}
//print_r($locations);
$markers = json_encode( $locations ,true);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        th { font-size: 12px; }
        td { font-size: 11px; }
        .dataTables_wrapper {
            font-family: tahoma;
            font-size: 10px;
            *zoom: 1;
            zoom: 1;
        }
        .labels {
            color: red;
            background-color: white;
            font-family: "Lucida Grande", "Arial", sans-serif;
            font-size: 10px;
            font-weight: bold;
            text-align: center;
            width: 60px;
            border: 2px solid black;
            white-space: nowrap;
        }
    </style>
    <script>
        $(function () {
            $("#from_date").datepicker({
                // changeMonth: true,
                //changeYear: true
                dateFormat: 'yy-mm-dd',
            });
        });
        $(function () {
            $("#to_date").datepicker({
                //changeMonth: true,
                //changeYear: true,
                dateFormat: 'yy-mm-dd',
            });
        });
        $(document).ready(function() {
            $('#example').DataTable( {
                "lengthMenu": [[5, 25, 50, -1], [5,10, 25, 50, "All"]]
            } );
        });
        $(document).ready(function() {
            $('#button').click(function(e){
                alert("coming"); return false;
                $('#myDiv').toggleClass('fullscreen');
            });
        });
    </script>

    <title>Document</title>
</head>
<body>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    var markers = <?php echo $markers;?>;
    window.onload = function () {
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();
        var marker_length=markers.length;
        var end_marker_length=markers.length-1;
        for (i = 0; i < markers.length; i++) {
            var data = markers[i];
            var myLatlng = new google.maps.LatLng(data.lat, data.lng);
            lat_lng.push(myLatlng);
            switch(i) {
                case 0:
                    var iconBase = 'https://chart.apis.google.com/chart?chst=d_map_spin&chld=1|0|6FA804|18|_|'+(i+1)+'';
                    break;
                case end_marker_length:
                    var iconBase = 'https://chart.apis.google.com/chart?chst=d_map_spin&chld=1|0|FF0000|18|_|'+(i+1)+'';
                    break;
                default:
                    var iconBase = 'https://chart.apis.google.com/chart?chst=d_map_spin&chld=1|0|CC7ED8|18|_|'+(i+1)+'';
            }
            var markerLabel = 'GO!';
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: iconBase,
                title: data.title,
               /* label: {
                    text: data.title,
                    color: "red",
                    fontSize: "16px",
                    fontWeight: "bold",
                    labelClass: "labels",
                }*/
            });
            latlngbounds.extend(marker.position);
            (function (marker, data) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent(data.description);
                    infoWindow.open(map, marker);
                });
            })(marker, data);
        }
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);
        //***********ROUTING****************//
        //Intialize the Path Array
        var path = new google.maps.MVCArray();
        //Intialize the Direction Service
        var service = new google.maps.DirectionsService();
        //Set the Path Stroke Color
        var poly = new google.maps.Polyline({ map: map, strokeColor: '#4986E7' });
        //Loop and Draw Path Route between the Points on MAP
        for (var i = 0; i < lat_lng.length; i++) {
            if ((i) < lat_lng.length) {
                var src = lat_lng[i];
                var des = lat_lng[i + 1];
                path.push(src);
                poly.setPath(path);
                service.route({
                    origin: src,
                    destination: des,
                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                }, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                            path.push(result.routes[0].overview_path[i]);
                        }
                    }
                });
            }
        }
    }
</script>
<div class="container">
    <div class="page-header">
        <b><h2 style="text-align: center;"> <font face="verdana" color="#3d004d">Salesperson Tracking System</font></h2></b>
    </div>
    <div class="panel panel-default" style="background-color:#694489;">
        <form method="POST">
            <div class="panel-body" style="background-color:#694489;">
                <div class="col-xs-4">  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="row">
                            <div class="col-lg-12">
                                    <a href="#" class="btn btn-large btn-success" >
                                        <i><font face="verdana" color="#3d004d">Sponsor [<?php echo $num_rows;?>]</font></i>
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2  input-group input-group-sm">
                    <input type="text" id="from_date" name="from_date" value="<?php if($_POST['from_date']){echo $_POST['from_date']; }?>" class="form-control" placeholder="FORM">
                </div>
                <div class="col-xs-2 input-group input-group-sm">
                    <input type="text" id="to_date" name="to_date" value="<?php if($_POST['to_date']){echo $_POST['to_date']; }?>" class="form-control" placeholder="TO">
                </div>
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit" name="submit"><i class="glyphicon glyphicon-search"></i></button>
                    <a class="btn btn-large btn-danger" href="salesperson_list_cookie.php" style="margin-left:10px;" ><i class="glyphicon glyphicon-arrow-left"></i></a>
                </div>
        </form>
    </div>
</div>
</div>
<div class="container">
    <div class="row" >
        <div class="col-sm-6 " style="width: 540px; height: 700px; ">
            <div class='row'>
                <div class="col-sm-8">
                    <div class="d-inline-block bg-primary" >
                        <font face="verdana" color="#3d004d"><h4>Salesperson Name ::
                        <?php
                        $sql =mysql_query("SELECT * FROM tbl_salesperson WHERE person_id='$salesperson_id'");
                        $Result=mysql_fetch_assoc($sql);
                        echo $Result['p_name'];
                        ?></h4>
						<br>
						<?php
							if($num_rows<=0){
								echo"<h4 style=color:green;>".$Result['p_name']." don't have sponsor list.</h4>";
								echo"<h4 style=color:Red;>Map doesn't load without sponsor list.</h4>";
							}
						?>
                        </font>
                    </div>
                </div>
            </div>
            <div id="dvMap" style="width: 580px; height: 645px; margin-top: 20px;">
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-6 jumbotron" style="width: 520px; height: 700px;overflow-y: scroll;" >
            <button class="btn btn-default pull-right" onclick="myFunction()" ><i class="glyphicon glyphicon-fullscreen"></i></i></button>
            <hr>
            <hr>
            <div class="page-header">
                <b><h2 style="text-align: center;"> <font face="verdana" color="#3d004d">Sponsor Tracking List </font></h2></b>
            </div>
            <hr style="display: block;height: 1px;border: 0;border-top: 1px solid #3d004d;margin: 1em 0;padding: 0;">
            <table id="example" class="display" width="20%"  style="font-size:10px;" cellspacing="0">
                <thead>
                <tr>
                    <th>sr no</th>
                    <th>Sponsor Name</th>
                    <th>Shop Name</th>
                    <th>Address</th>
                    <th>Reg.Date</th>
                </tr>
                </thead>
                <?php
                $i=1;
                mysql_data_seek($row,0);
                foreach ($data_array as $data) {
                    ?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $data['sp_name']; ?></td>
                        <td><?php echo $data['sp_company']; ?></td>
                        <td><?php echo $data['sp_address']; ?></td>
                        <td><?php echo $data['sp_date']; ?></td>
                    </tr>
                    <?php  $i++; }?>
            </table>
            <hr>
            <hr>
            </button>
        </div>
    </div>
</div>
</body>
</html>

