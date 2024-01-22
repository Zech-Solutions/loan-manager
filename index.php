<?php
session_start();
// echo json_encode($_SESSION);
if(!isset($_SESSION['loan']['user_id'])){
    header("location:auth/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>eTally</title>
  <!-- base:css -->
  <!-- Custom fonts for this template-->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet">
      
  <!-- Custom styles for this template-->
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
  
  <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/vendor/sweet-alert/sweetalert2.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">

  <style>
    .bg-gradient-etally {
      background-color: #1cc88a;
      background-image: linear-gradient(180deg,#254d2c 10%,#3faf53 100%);
      background-size: cover;
    }

    .bg-etally {
      background-color: #33673c;
    }

    .bg-gradient-primary-to-secondary {
        background-color: #0061f2 !important;
        background-image: linear-gradient(135deg, #0061f2 0%, rgba(105, 0, 199, 0.8) 100%) !important;
    }

    .bg-gradient-etally2 {
        background-color: #00dd8d;
        background-image: linear-gradient(180deg,#36cf51 10%,#3fd15a 100%);
        background-size: cover;
        color: #fff;
    }
  </style>

  

  <!-- Bootstrap core JavaScript-->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Page level plugins -->
  <script src="assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="assets/js/sb-admin-2.js"></script>
  <script src="assets/vendor/sweet-alert/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
	function swal_error(title = "Data Entry", desc = '') {
		Swal.fire(title, desc, 'error');
	}

	function success_add(title = 'Data Entry') {
		Swal.fire(title, "Successfully added new entry!", 'success');
	}

  function success_update(title = 'Data Entry') {
		Swal.fire(title, "Successfully updated entry!", 'success');
	}

  function success_delete(title = 'Data Entry') {
		Swal.fire(title, "Successfully deleted entry!", 'success');
	}

	function swal_warning(title = "Data Entry", desc = '') {
		Swal.fire(title, desc, 'warning');
	}

	function swal_info(title, desc = '') {
		Swal.fire(title, desc, 'info');
	}

  function swal_success(title, desc = '') {
    Swal.fire(title, desc, 'success');
  }
  </script>
</head>
<style>
  /* .nav-fixed>#wrapper>#content-wrapper{
    margin-left: 224px;
  }
  .nav-fixed.sidebar-toggled>#wrapper>#content-wrapper{
    margin-left: 104px !important;
  } */
</style>

<body id="page-top" class="nav-fixed">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-etally sidebar sidebar-dark accordion" id="accordionSidebar">
          <?php require 'template/sidebar.php'; ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require 'template/navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php require 'routes/routes.php'; ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>E-Tally: Event Organizer and Scoring Tabulation</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
</body>
</html>