<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

require_once "__db_config.block.php";

$db_conn = DB_Config::getInstance()->getConnection();

$sql_block = "Select * from blocks";
$blocks = mysqli_query($db_conn, $sql_block);


$sql_admin = "Select * from admin";
$total_admin = mysqli_num_rows(mysqli_query($db_conn, $sql_admin));
$total_vill = 0;
$blocks_arr = array();
$blockVill_arr = array();
$admin_fullname = "";
$admin_email = "";
$sql_getAdmin = "SELECT full_name, email FROM admin WHERE email = ?";
if ($stmt = $db_conn->prepare($sql_getAdmin)) {
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $stmt->bind_result($full, $em);
    if ($stmt->fetch()) {
        $admin_email = $em;
        $admin_fullname = $full;
    }
    $stmt->close();
}


while ($row = $blocks->fetch_assoc()) {
    $block = $row['name'];
    array_push($blocks_arr, $block);
    $sql_vill = "SELECT * FROM " . $block;
    $vill = mysqli_query($db_conn, $sql_vill);
    array_push($blockVill_arr,mysqli_num_rows($vill));
    $total_vill += mysqli_num_rows($vill);
}


$block_data = array_combine($blocks_arr,$blockVill_arr);
$total_blocks = mysqli_num_rows($blocks);

$sql_users = "SELECT * FROM login";
$users = mysqli_query($db_conn, $sql_users);
$total_users = mysqli_num_rows($users);
