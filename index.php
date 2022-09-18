<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $date = DateTime::createFromFormat('Y-m-d', $_POST["date"]);
    $total = intval($_POST["totalStudent"]);

    $isDateValidated = isset($_POST["date"]) && $date != false;
    $isTotalValidated = isset($_POST["totalStudent"]) &&  gettype($total) == "integer" && $total > 0;

    // var_dump($total);
    // var_dump($isTotalValidated);
    $isSubmitted = $isTotalValidated && $isDateValidated;
    if($isSubmitted){
        $myfile = fopen("attendance.txt", "w") or die("Unable to open file!");
        $totalStudent = $_POST["totalStudent"];
        $date = $_POST["date"];
        $attendanceData = implode("\r\n",array($date, $totalStudent, "0"));
        fwrite($myfile, $attendanceData);
        fclose($myfile);
        $hostServer = $_SERVER['SERVER_NAME'];
        header("Location:http://$hostServer/attendance/attendance.php?total=$totalStudent&roll=1");
        exit();
    }
    else {
        $hostServer = $_SERVER['SERVER_NAME'];
        header("Location:http://$hostServer/attendance/");
        exit();
    }
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendence</title>
</head>
<body>
    
    <form action="" method='POST'>
        Total Student : <input type="number" name="totalStudent" id="totalStudent"><br/><br/>
        Date : <input type="date" name="date" id="date"><br/><br/>
        <input type="submit" value="Submit">
    </form>
</body>
</html>