<?php
require_once "db_credentials.php";

$host = 'localhost';
$db = 'jaipur';

// If on users.iee.ihu.gr, connect to the MySQL database there
if (gethostname() == 'users.iee.ihu.gr') {
    $mysqli = new mysqli($host, $USERNAME, $PASSWORD, $db, null, '/home/student/iee/2022/konsvrou/mysql/run/mysql.sock');
}

// If local, connect to the XAMPP MySQL database
else {
    $mysqli = new mysqli($host, 'root', '', $db);
}
