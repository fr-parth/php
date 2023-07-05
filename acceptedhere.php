<?php include 'core/index_header.php'; ?>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .bgwhite {
            background-color: #fff;
        }

        .padtop10 {
            padding-top: 10px;
        }

        .red {
            color: #f00;
        }

        tr {
            padding-top: 10px;
        }

        .green {
            color: #0f0;
        }
        .panel-info
        {
            width:1000px;
        }
    </style>
</head>
    <script>
        $(document).ready(function () {
            $("#device_type").change(function(){
               var user_type = $('#user_type').val();
               var device_type = $('#device_type').val();
               //ert(user_type);
               if(user_type!='' && device_type!=''){
                    if(device_type=='ios'){
                        switch (user_type) {
                            case 'student':
                                var url="https://goo.gl/HNqrPR";
                                $('#appurlanchor').attr('href',url).html(url);
                                break;
                            case 'teacher':
                                var url="https://goo.gl/cdi711";
                                $('#appurlanchor').attr('href',url).html(url);
                                break;
                            case 'sponsor':
                                var url="https://goo.gl/K1fdxE";
                                $('#appurlanchor').attr('href',url).html(url);
                                break;
                            case 'Social_Workers':
                                var url="Under construction";
                                $('#appurlanchor').attr('href',url).html(url);
                                break;
                        }
                    }else
                        if(device_type=='android') {
                            switch (user_type) {
                                case 'student':
                                    var url="https://goo.gl/G6jpu2";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    break;
                                case 'teacher':
                                    var url="https://goo.gl/89Fr11";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    break;
                                case 'sponsor':
                                    var url="https://goo.gl/zbAhi4";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    break;
                                case 'Social_Workers':
                                    var url="Under construction";
                                    $('#appurlanchor').attr('href',url).html(url);
                                    break;
                            }
                        }
               }else{
               alert('Please select user type first');}
            });
        });
    </script>

    <div style="width:800px; margin:0 auto; background-color: white;">
        <div class='col-md-10 col-md-offset-2' >
            <div class='panel panel-info' style="width: 550px;height: 500px;">
                <div class='panel-heading'>
                    <div class='panel-title'>
                        Smartcookie a rewards program for Students/Teachers/Employees/Managers/Social Workers and others
                    </div>
                </div>
                <div class='panel-body' style="text-align: center;">
                    <form method="post">
                        <table class='table'>
                            <tr>
                                <td style="padding: 27px">I am<span class='red'>*</span></td>
                                <td style="padding: 27px">
                                    <select id="user_type" name="user_type" style="width:200px">
                                        <option value="" selected="selected">Select
                                        </option>
                                        <option value="student">Student
                                        </option>
                                        <option value="teacher">Teacher
                                        </option>
                                        <option value="sponsor">Sponsor
                                        </option>
                                       <!-- <option value="employees">Employees
                                        </option>-->
                                        <!--<option value="Manager">Managers
                                        </option>-->
                                        <option value="Social_Workers">Social Workers
                                        </option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td style="padding: 27px">MY Mobile<span class='red'>*</span></td>
                                <td style="padding: 27px">
                                    <select id="device_type" name="device_type" style="width:200px">
                                        <option value="" selected="selected">Select
                                        </option>
                                        <option value="ios">ios
                                        </option>
                                        <option value="android">Android
                                        </option>

                                    </select></td>
                            </tr>
                            <tr>
                                <td style="padding: 27px">Link</td>
                                <td style="padding: 27px" id="applink">
                                    <a id="appurlanchor"></a>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'core/index_footer.php'; ?>
