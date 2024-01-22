<?php
include '../core/config.php';

$supplier_id    = (int) $_POST['supplier_id'];
$supplier_name	= $_POST['supplier_name'];

$form_data = array(
	'supplier_name'	=> $supplier_name,
);

$sql = $supplier_id > 0? sql_update("tbl_suppliers", $form_data, "supplier_id = '$supplier_id'") : sql_insert("tbl_suppliers", $form_data);
$mysqli->query($sql);

echo json_encode($form_data);
