<?php
$mysqli = new mysqli("localhost", "root", "", "holidays");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
if(!empty($_GET["year"])){
    $query = "SELECT id,title,start_date,end_date FROM holiday WHERE YEAR(start_date) = " . $_GET["year"] . " ORDER BY start_date DESC LIMIT 10";
} else {
    $query = "SELECT id,title,YEAR(start_date) as 'year',start_date,end_date FROM holiday ORDER BY start_date DESC LIMIT 10";
}

if ($result = $mysqli->query($query)) {
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