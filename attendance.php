<?php
    $roll = $_GET["roll"];
    $total = $_GET["total"];
    $totalInt = intval($total);
    $nextRoll = intval($roll) + 1;
    if($roll < 1){
        $hostServer = $_SERVER['SERVER_NAME'];
        header("Location:http://$hostServer/attendance/");
        exit();
    }
    function presentCount (){
        $myfile = fopen("attendance.txt", "r") or die("Unable to open file!");
        $date = $total = $count = '';
        if($myfile){
            $lineNumber = 0;
            while (($line = fgets($myfile)) !== false) {
                $line = trim($line);
                if($lineNumber == 0){
                    $date = $line;
                }
                if($lineNumber == 1){
                    $total = $line;
                }
                if($lineNumber == 2){
                    $count = intval($line);
                }
                $lineNumber ++;
            }
        }
        fclose($myfile);
        return [$date, $total, $count];
    }
    $totalFromTXT = intval(presentCount()[1]);
    
    if($total >= $roll && $totalInt === $totalFromTXT){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $present = isset($_POST["present"]);
            if($present){
                $arr = presentCount();
                $arr[2] = strval($arr[2] + 1);
                $attendanceData = implode("\r\n", $arr);
                $myfile = fopen("attendance.txt", "w+") or die("Unable to open file!");
                fwrite($myfile, $attendanceData);
                fclose($myfile);
                if($roll === $total){
                    $hostServer = $_SERVER['SERVER_NAME'];
                    header("Location:http://$hostServer/attendance/finished.php?page=finished");
                exit();
                }
            }else {
            }
            // print_r($_POST);
        }
    } else {
        $hostServer = $_SERVER['SERVER_NAME'];
        header("Location:http://$hostServer/attendance/");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
</head>
<body>
    Roll: <?php echo $roll?>
    <form action=<?php echo "/attendance/attendance.php?total=$total&roll=$nextRoll" ?> method="POST">
        <button name="present" value="1">Present</button>
        <button name="absent" value="0">Absent</button>
    </form>
</body>
</html>