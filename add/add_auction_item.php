<?php
include "../creds.php";

if (!empty($_POST['auction_id']) && !empty($_POST['item_id']) && !empty($_POST['start_price'])
    && isset($_POST['actual_price']) && !empty($_POST['description'])) {
    $auction_id = $_POST['auction_id'];
    $item_id = $_POST['item_id'];
    $start_price = $_POST['start_price'];
    $actual_price = $_POST['actual_price'];
    $description = $_POST['description'];
    if (empty($actual_price)) {
        $actual_price = null;
    }
    $sql = "INSERT INTO auction_item (auction_id, item_id, start_price, actual_price, description) VALUES (:auction_id, :item_id, :start_price, :actual_price, :description)";

    //    INSERT INTO auction_item (id, auction_id, item_id, start_price, actual_price, description)

    $insert = $db->prepare($sql);
    $insert->execute(array(':auction_id'=>$auction_id, ':item_id'=>$item_id, ':start_price'=>$start_price, ':actual_price'=>$actual_price, ':description'=>$description));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");