<?php
$mysqli = new mysqli("localhost", "root", "", "holidays");

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
if(!empty($_GET["holidayid"])){
    $query = "SELECT title, start_date, end_date FROM holiday WHERE id = " . $_GET["holidayid"];

    if ($result = $mysqli->query($query)) {
        /* printf("Select returned %d rows.\n", $result->num_rows); */
    
        while($row = mysqli_fetch_assoc($result)){
            
            $holiday = array(
                            'title' => $row['title'],
                            'start_date' => $row['start_date'],
                            'end_date' => $row['end_date']
                            );

            $legs = array();
            $legsquery = "SELECT id, title, start_date FROM leg WHERE holiday_id = " . $_GET["holidayid"];

            if ($legsresult = $mysqli->query($legsquery)) {
                while($legsrow = mysqli_fetch_assoc($legsresult)){
                    $legs[] = $legsrow;
                }
            }
            
            $holiday['legs'] = $legs;
            
            $json = array($holiday);
            echo json_encode($json);
        }
        
        /* free result set */
        $result->close();
    }
}

$mysqli->close();
?>