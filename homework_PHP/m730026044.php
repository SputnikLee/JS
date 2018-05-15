<html>
<head>
    <style>
        p {
            color: #FF0000;
        }
    </style>
</head>
<body>


<?php
error_reporting(E_ALL ^ E_NOTICE);
$name = $id = $dob = $gend = $prog = $dob = $fruout = "";
$nameerr = $iderr = $doberr = $genderr = $progerr = $doberr = $faverr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameerr = "<p>Name is required</p>";
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["id"])) {
        $iderr = "<p>ID is required</p>";
    } else {
        if (!preg_match("/^[A-Za-z][0-9]{9}$/", $_POST["id"])) {
            $iderr = "<p>plz input a an correct UIC ID</p>";
        } else $id = $_POST["id"];
    }

    if (empty($_POST["gend"])) {
        $genderr = "<p>gender is required</p>";
    } else {
        $gend = $_POST["gend"];
    }

    if (empty($_POST["prog"])) {
        $progerr = "<p>Programme is required</p>";
    } else {
        $progfull = prog($_POST["prog"]);
        if ($progfull == 1) $progerr = "<p>plz input a DST programme</p>";
        else {
            $prog = $_POST["prog"];
            $progout = $progfull . " (" . $_POST["prog"] . ")";
        }
    }

    if (empty($_POST["dob"])) {
        $doberr = "<p>Date of birth is required</p>";
    } else {
        $dob = $_POST["dob"];
        $fru = fruitiac($dob[5] * 10 + $dob[6], $dob[8] * 10 + $dob[9]);
        $dobout = $dob[8] . $dob[9] . " ";
        switch ($dob[5] * 10 + $dob[6]) {
            case 1:
                $dobout = $dobout . "January";
                break;
            case 2:
                $dobout = $dobout . "February";
                break;
            case 3:
                $dobout = $dobout . "March";
                break;
            case 4:
                $dobout = $dobout . "April";
                break;
            case 5:
                $dobout = $dobout . "May";
                break;
            case 6:
                $dobout = $dobout . "June";
                break;
            case 7:
                $dobout = $dobout . "July";
                break;
            case 8:
                $dobout = $dobout . "August";
                break;
            case 9:
                $dobout = $dobout . "September";
                break;
            case 10:
                $dobout = $dobout . "October";
                break;
            case 11:
                $dobout = $dobout . "November";
                break;
            case 12:
                $dobout = $dobout . "December";
                break;
        }
        $dobout = $dobout . " " . $dob[0] . $dob[1] . $dob[2] . $dob[3];
    }

    if (empty($_POST["fav"])) {
        $faverr = "<p>You need to choose your favourite things</p>";
    } else {
        $fav = $_POST["fav"];

        for ($i = 0; $i <= count($fav); $i++) {
            $favout = $favout . $fav[$i] . "<br>";
        }
    }
}


function fruitiac($mm, $dd)
{
    //allocate friut depending on the date of birth
    if (($mm == 1 && $dd >= 14) || $mm == 2 || ($mm == 3 && $dd <= 2))
        $fruitiac = "Cherry";
    else if (($mm == 3 && $dd >= 10) || ($mm == 4 && $dd <= 27))
        $fruitiac = "Durian";
    else if ($mm == 6 && $dd >= 5 && $dd <= 29)
        $fruitiac = "Starfruit";
    else if (($mm == 7 && $dd >= 11) || ($mm == 8 && $dd <= 27))
        $fruitiac = "Orange";
    else if (($mm == 9 && $dd >= 17) || ($mm == 10 && $dd <= 21))
        $fruitiac = "Banana";
    else if (($mm == 1 && $dd <= 5) || $mm == 12 || ($mm == 11 && $dd >= 3))
        $fruitiac = "Lychees";
    else $fruitiac = "You only like vegetables";

    return $fruitiac;
}

function prog($prog)
{
    //use PHP switch statement
    switch ($prog) {
        case "CST":
            $progTitle = "Computer Science and Technology";
            break;
        case "APSY":
            $progTitle = "Applied Psychology";
            break;
        case "DS":
            $progTitle = "Date Science";
            break;
        case "ENVS":
            $progTitle = "Environmental Science";
            break;
        case "FM":
            $progTitle = "Financial Mathematics";
            break;
        case "FST":
            $progTitle = "Food Science and Technology";
            break;
        case "STAT":
            $progTitle = "Statistics";
            break;
        default:
            $progTitle = 1;
    }

    return $progTitle;
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    plz input your Name <input type="text" name="name" value="<?php echo $name; ?>"><br>
    plz input your UIC ID <input type="text" name="id" value="<?php echo $id; ?>"><br>
    plz input your date of birth <input type="date" name="dob" value="<?php echo $dob; ?>"><br>
    plz input your programme from DST <input type="text" name="prog" value="<?php echo $prog; ?>"><br>
    plz select your gender
    <input type="radio" name="gend" <?php if (isset($gend) && $gend == "female") echo "checked"; ?> value="female">Female
    <input type="radio" name="gend" <?php if (isset($gend) && $gend == "male") echo "checked"; ?> value="male">Male
    <input type="radio" name="gend" <?php if (isset($gend) && $gend == "other") echo "checked"; ?> value="other">Other
    <br>
    plz select your favourite things[0-8]:<br>

    <input type="checkbox" name="fav[]" value="Watching movies">Watching movies
    <br>
    <input type="checkbox" name="fav[]" value="Collecting Stamps">Collecting Stamps
    <br>
    <input type="checkbox" name="fav[]" value="Eating out">Eating out
    <br>
    <input type="checkbox" name="fav[]" value="Badminton">Badminton
    <br>
    <input type="checkbox" name="fav[]" value="Table Tennis">Table Tennis
    <br>
    <input type="checkbox" name="fav[]" value="playing the guitar">playing the guitar
    <br>
    <input type="checkbox" name="fav[]" value="coffee with friends">coffee with friends
    <br>
    <input type="checkbox" name="fav[]" value="playing on my phone">playing on my phone
    <br><br>
    <input type="submit" name="submit" value="submit"><br>
</form>
<?php
echo $nameerr . $iderr . $genderr . $progerr . $doberr . $faverr;
echo "<table border='1'><tr><th width='200'>Name</th><td width='300'>" . $name . "</td></tr>";
echo "<tr><th>UIC ID</th><td>" . $id . "</td></tr>";
echo "<tr><th>Gender</th><td>" . $gend . "</td></tr>";
echo "<tr><th>Programme</th><td>" . $progout . "</td></tr>";
echo "<tr><th>DOB</th><td>" . $dobout . "</td></tr>";
echo "<tr><th>Fruitiac</th><td>" . $fru . "</td></tr>";
echo "<tr><th>List of favourites</th><td>";
echo $favout;

echo "</td></tr></table>";
?>
</html>
