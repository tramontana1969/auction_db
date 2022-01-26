<?php
include "../creds.php";

if (!empty($_POST['name'])) {
    $name = $_POST['name'];
    $sql = "INSERT INTO customer (name) VALUES (:name)";
    $insert = $db->prepare($sql);
    $insert->execute(array(':name'=>$name));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");