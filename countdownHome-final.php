<?php
session_start();

?>


<!DOCTYPE html>
<html>
<head>
<style>
body {
    background-image: url(http://dianaprince.usersource.com/Heart-on-fire-1.jpg);
    background-color: black;
   }
h1 {
    color: white;
    font-style: italic;
    text-align: center;
    position: absolute;
    left: 325px;
    top: 230px;

}

</style>
</head>
<body>

<h1><?php
//first we have to get the current year
$current_array = getdate();
$current_year = $current_array['year'];

//then we format the current date
$current_stamp = mktime($current_array['hours'],$current_array['minutes'],$current_array['seconds'],$current_array['mon'],$current_array['mday'],$current_year);
$current_str = date("F d, Y", $current_stamp);

//now we add the current year to our goal date and generate the current holiday date
$deadline_stamp = mktime(0,0,0,2,14,$current_year);
$deadline_str = date("F d, Y", $deadline_stamp);

//now we have to figure out how much time remains
$timeleft = $deadline_stamp - time();

//then we have to sort the answers into two possibilities date past and date future
if ($timeleft < 0) {
$new_year = $current_year + 1;
$new_deadline_stamp = mktime(0,0,0,2,14,$new_year);
$new_deadline_str = date("F d, Y", $new_deadline_stamp);

//figure out how much time remains until next years date
$timeleft = $new_deadline_stamp - time();

//calculate how much time is left before V-day in human terms
$day = floor($timeleft / 86400);
$hr  = floor(($timeleft % 86400) / 3600);
$min = floor(($timeleft % 3600) / 60);
$sec = ($timeleft % 60);
echo "Today's date is: <br/>";
echo $current_str."<br/>";
echo "Valentine's Day is:"."<br/>";
echo $new_deadline_str."<br/>";
if($day) echo "There are $day Days, "."<br/>";
if($hr) echo "$hr Hours, "."<br/>";
if($min) echo "$min Minutes, "."<br/>";
if($sec) echo "$sec Seconds remaining... "."<br/>";

} else if ($timeleft == 0) {
echo "Happy Valentine's Day!";

} else if ($timeleft > 0) {
//calculate how much time is left before V-day in human terms
$day = floor($timeleft / 86400);
$hr  = floor(($timeleft % 86400) / 3600);
$min = floor(($timeleft % 3600) / 60);
$sec = ($timeleft % 60);
echo "Today's date is: <br/>";
echo $current_str."<br/>";
echo "Valentine's Day is:"."<br/>";
echo $deadline_str."<br/>";
if($day) echo "There are $day Days, "."<br/>";
if($hr) echo "$hr Hours, "."<br/>";
if($min) echo "$min Minutes, "."<br/>";
if($sec) echo "$sec Seconds remaining... "."<br/>";
}
echo 'Click <a href="List_form6d.php">here</a> to visit our bookstore.';

?></h1>

</body>
</html>
