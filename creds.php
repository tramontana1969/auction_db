<?php
$host = '0.0.0.0';
$port = '6033';
$dbname = 'auction_db';
$user = 'administrator';
$password = '12345';
$db = new PDO("mysql:host=$host; port=$port; dbname=$dbname", $user, $password);