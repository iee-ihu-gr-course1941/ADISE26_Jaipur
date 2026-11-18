<?php
$host = 'localhost';
$db = 'ADISE26_Jaipur';

require_once "db_config.php";
$user = $USERNAME;
$pass = $PASSWORD;

if (gethostname() == 'users.iee.ihu.gr') {
    $mysqli = new mysqli($host, $user, $pass, $db, null, '/home/student/iee/2022/konsvrou/mysql/run/mysql.sock');
}

else {
    $mysqli = new mysqli($host, $user, $pass, $db);
}

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
