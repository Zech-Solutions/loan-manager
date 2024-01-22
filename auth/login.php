<?php
session_start();
if(isset($_SESSION['loan']['user_id'])){
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>eTally - Login</title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .bg-gradient-etally {
            background-color: #1cc88a;
            background-image: linear-gradient(180deg,#254d2c 10%,#3faf53 100%);
            background-size: cover;
        }
        .bg-login-image-etally {
            background: url(../assets/img/logo_login.png);
            background-position: center;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-gradient-etally">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image-etally"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">E-Tally: Event Organizer and Scoring Tabulation</h1>
                                    </div>
                                    <form id="frmLogin" class="user">
                                        <div class="form-group">
                                            <input name="username" type="username" class="form-control form-control-user"
                                                id="username" aria-describedby="emailHelp"
                                                placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control form-control-user"
                                                id="password" placeholder="Password" required>
                                        </div>
                                        <div class="bd-example login-response"></div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#" onclick="createProtest()">Submit a Protest</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>E-Tally: Event Organizer and Scoring Tabulation &copy; 2023</span>
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalProtest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Create a Protest</h5>
                </div>
                <div class="modal-body">
                <form class="forms-sample" id="formProtest">
                    <div class="form-group">
                        <label for="judge_ids">Event</label>
                        <select name="event_id" id="event_id" class="form-control" style="width: 100%;" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="judge_ids">Remarks</label>
                        <textarea class="form-control" name="protest" id="protest" cols="30" rows="5" placeholder="Discuss your protest here, don't worry you are anonymous!" required></textarea>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-outline-success" form="formProtest" type="submit" id="btn_submit_protest">
                        <span class="fa fa-check-circle"></span> Submit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" data-dismiss="modal">
                        <span class="fa fa-times-circle"></span> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>
    <script src="../assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>

    <script>
        $("#frmLogin").submit(function(e){
            e.preventDefault();
            $.post("ajax/login.php",$(this).serialize(),function(data,status){
                if(data == 1){
                    var index = 3;
                    $(".login-response").html(`<div class="alert alert-success" role="alert">Successfully login, redirecting in <b>3</b>.</div>`);
                    setInterval(function(){
                        $(".login-response").html(`<div class="alert alert-success" role="alert">Successfully login, redirecting in <b>${index}</b>.</div>`);
                        index--;
                        if(index < 0){
                            window.location = "../index.php";
                        }
                    },1000);
                }else{
                    $(".login-response").html(`<div class="alert alert-danger" role="alert">Account does not match</div>`);
                }
            });
        });

        
        $("#formProtest").submit(function(e){
            e.preventDefault();
            $.post("../ajax/add_protest.php",$(this).serialize(),function(data,status){
                $("#modalProtest").modal('hide');
                if(data == 1){
                    Swal.fire("Protest", "Successfully submit protest!", 'success');
                }else{
                    Swal.fire("Protest", "Error occur while processing data!", 'error');
                }
            });
        });

        function createProtest(){
            $("#event_id").html("<option value=''> Please Select </option>");
            $("#protest").val("");
            $("#modalProtest").modal('show');
            $.post("../ajax/get_events.php",{
                params:"WHERE event_status != 'S'"
            },function(data,status){
                var res = JSON.parse(data);
                for(let eventIndex = 0; eventIndex <= res.data.length; eventIndex++){
                    const event_row = res.data[eventIndex];
                    $("#event_id").append(`<option value='${event_row.event_id}'> ${event_row.event_name} </option>`);
                }
            });
        }
    </script>

</body>

</html>