<?php
include "../creds.php";
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM item WHERE id = :id";
    $delete = $db->prepare($sql);
    $delete->execute(array(':id'=>$id));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");