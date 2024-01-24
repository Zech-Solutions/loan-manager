<?php $page = isset($_GET['page']) ? $_GET["page"] : "dashboard"; ?>
<!-- Sidebar - Brand -->
<li class="nav-item">
    <a class="nav-link" href="index.php">
      <center><img class="img-fluid" src="assets/img/logo.png" style="width: 50%;"></center>
    </a>
</li>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?=$page == 'dashboard'?'active':'';?>">
    <a class="nav-link" href="index.php">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Transaction
</div>

<!-- Nav Item - Tables -->
<li class="nav-item <?= $page == 'events' ?' active':'';?>">
    <a class="nav-link" href="index.php?page=loans">
        <i class="fas fa-fw fa-table"></i>
        <span>Loans</span></a>
</li>

<!-- Heading -->
<div class="sidebar-heading mt-2">
    Master Data
</div>

<li class="nav-item <?=$page == 'suppliers'?'active':'';?>">
    <a class="nav-link" href="index.php?page=suppliers">
        <i class="fas fa-fw fa-list"></i>
        <span>Suppliers</span></a>
</li>

<!-- Heading -->
<div class="sidebar-heading mt-2">
    Reports
</div>

<li class="nav-item <?=$page == 'event-category'?'active':'';?>">
    <a class="nav-link" href="index.php?page=report-salary-payable">
        <i class="fas fa-fw fa-list"></i>
        <span>Payable by Salary</span></a>
</li>

<li class="nav-item <?=$page == 'event-category'?'active':'';?>">
    <a class="nav-link" href="index.php?page=report-salary-payable">
        <i class="fas fa-fw fa-list"></i>
        <span>Accounts Payable</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
