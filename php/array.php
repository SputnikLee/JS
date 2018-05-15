<?php

$myStuff = array("apple","cookies","milk","juice","carrot","popcorn");
$l = count($myStuff);

echo "<li>";

for($x = 0;$x < $l;$x++)
{
	echo "<ul>" . $myStuff[$x] . "</ul>";
}

echo "</li>"

?>