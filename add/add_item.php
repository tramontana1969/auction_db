<?php
include '../creds.php';

if (!empty($_POST['name']) && isset($_POST['lot']) && !empty($_POST['seller_id']) && isset($_POST['customer_id'])) {
    $name = $_POST['name'];
    $lot = $_POST['lot'];
    $seller_id = $_POST['seller_id'];
    $customer_id = $_POST['customer_id'];
    if(empty($lot)) {
        $lot = null;
    }
    if(empty($customer_id)) {
        $customer_id = null;
    }
    $sql = "INSERT INTO item (name, lot, seller_id, customer_id) VALUES (:name, :lot, :seller_id, :customer_id)";
    $insert = $db->prepare($sql);
    $insert->execute(array(':name'=>$name, ':lot'=>$lot, ':seller_id'=>$seller_id, 'customer_id'=>$customer_id));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");