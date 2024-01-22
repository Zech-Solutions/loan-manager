<?php
$page = isset($_GET['page']) ? $_GET["page"] : "dashboard";

if ($page == 'dashboard') {
	require_once 'views/dashboard.php';
} else if ($page == 'loans') {
	require_once 'views/loans.php';
} else if ($page == 'suppliers') {
	require_once 'views/suppliers.php';
} else {
	require_once 'views/404.php';
}
