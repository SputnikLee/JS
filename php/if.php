<?php


$number = date("H");
if($number > 23) echo "$number is larger than 23";
else if($number < 23) echo "$number is smaller than 23";
else echo "$number is equal to 23";
echo "<br>";

?>