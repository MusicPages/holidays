<?php
$mysqli = new mysqli("localhost", "root", "", "holidays");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

if ($result = $mysqli->query("SELECT DISTINCT(YEAR(start_date)) year FROM holiday ORDER BY year DESC")) {
    /* printf("Select returned %d rows.\n", $result->num_rows); */

    $json = array();
    while($row = mysqli_fetch_assoc($result)){
        $json[] = $row;
    }
    
    echo json_encode($json);
    
    /* free result set */
    $result->close();
}

$mysqli->close();
?>