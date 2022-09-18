<?php
$finished = $_GET["page"];
$myfile = fopen("attendance.txt", "r") or die("Unable to open file!");
if($myfile){
    $date = $total = $count = '';
    $lineNumber = 0;
    while (($line = fgets($myfile)) !== false) {
        if($lineNumber == 0){
            $date = $line;
        }
        if($lineNumber == 1){
            $total = intval($line);
        }
        if($lineNumber == 2){
            $count = intval($line);
        }
        $lineNumber ++;
    }
    fclose($myfile);
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
    Date: <?php echo $date ?> <br/>
    Attendance are done. <br/>
    Total Student: <?php echo $total ?><br/>
    Present: <?php echo $count?><br/>
    Absent: <?php echo $total - $count?><br/>
</body>
</html>