<?php
include "../creds.php";

if (!empty($_POST['date']) && !empty($_POST['time']) && !empty($_POST['place']) && !empty($_POST['description'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $place = $_POST['place'];
    $description = $_POST['description'];

    $sql = "INSERT INTO auction (date, time, place, description) VALUES (:date, :time, :place, :description)";
    $insert = $db->prepare($sql);
    $insert->execute(array(':date'=>$date, ':time'=>$time, ':place'=>$place, ':description'=>$description));
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");