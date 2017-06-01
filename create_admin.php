<?php
function create_admin(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "306_db";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $uname = "admin";
    $pw = hash('sha512','123456');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql1 = "INSERT INTO user VALUES ('".$uname."','" .$pw."',NULL,NULL,NULL,NULL,NULL,NULL);";

    if ($result = $conn->query($sql1)) {

    } else {
        die("SQL ERROR " . $conn->error);
    }
    $sql2 = "INSERT INTO admin VALUES('".$uname."');";
    if ($result = $conn->query($sql2)) {
        echo "Success";
    } else {
        die("SQL ERROR " . $conn->error);
    }

    $conn->close();
}

function create_dummy_data(){
    /*
     * Create Customers
     */

    
}


?>