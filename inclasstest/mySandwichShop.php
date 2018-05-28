<?php

$servername = "localhost";
$username = "m730026044";
$password = "abc123xyz";
$dbname = "m730026044";
// $servername = "localhost";
// $username = "sdw1User";
// $password = "sdw1pwd";
// $dbname = "sdw1DB";
$myList = ""; // Output sandwich ingridients
$messages = ""; //
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



function getFillings($array)
{
    $fillings = "";
    foreach ($array as $value) {
        $fillings .= "$value ";
    }
    return $fillings;
}

function calculateCost($sandwich, $bread, $fillings)
{
    // add code here to calculate the cost
    $ingridients = "";
    $ingridients .= "Sandwich: $sandwich <br/>";
    $ingridients .= "Bread Type: $bread <br/>";
    $ingridients .= "Fillings: " . getFillings($fillings) . "<br/>";

    return $ingridients;
}


// If form submitted -
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $formSandwichType = $_POST['sandwichType'];
    $formBreadType = $_POST['breadType'];
    $formFillings = $_POST['fillings'];
    $formUsername = $_POST['username'];
    $formMobileNo = $_POST['mobileno'];
    $formDormAddr = "";


    // check username exist and matches mobile number

    $sql = "SELECT * FROM myCustomers WHERE username = '$formUsername'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['mobileNo'] = $formMobileNo) { // replace the TRUE with your expression between the brackets
            $messages = "Dear ".$row["username"].", your order will be delivered to ".
                $row["dormAddr"].", we will call you on ".$row["mobileNo"];
            $formDormAddr = $row['dormAddr'];
        } else {
            $messages = "Dear ".$formUsername.", your mobile mobileNo number does not match";
            $formUsername = $formMobileNo = "";

        }
        $myList = calculateCost($formSandwichType, $formBreadType, $formFillings);
        $cast = 0;
        switch ($formSandwichType){
            case "Subway Melt":
                $cast += 42;
                break;
            case "Veggie":
                $cast += 28;
                break;
            case "Club Sandwich":
                $cast += 33;
                break;
            case "Fishy wrap":
                $cast += 28;
                break;
            case "Burger":
                $cast += 48;
                break;
        }
        switch ($formBreadType){
            case "White Slice":
                $cast += 8;
                break;
            case "Brown Slice":
                $cast += 9;
                break;
            case "Baguette":
                $cast += 10;
                break;
            case "Panini":
                $cast += 12;
                break;
        }

        foreach ($formFillings as $value)
        {
            switch ($value)
            {
                case "Cumcumber":
                    $cast += 2.5;
                    break;
                case "Onions":
                    $cast += 1;
                    break;
                case "Tomatoes":
                    $cast += 3;
                    break;
                case "Cheese":
                    $cast += 5;
                    break;
            }
        }

        $myList .= "Total cost: ". $cast;

    } else {
        $messages = "Sorry, you are not a member – please register if you wish to order a sandwich";
    }
}


$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        #messages {
            color: red;
        }

        td {
            vertical-align: top;
            padding: 15px;
        }

        table {
            margin: 50px auto;
            border: 1px solid black;
        }

        div {
            text-align: center;

        }
    </style>
</head>

<body>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="Post">
    <table>
        <tr>
            <th colspan="3"><h2>My Sandwich - My Way</h2></th>
        </tr>
        <tr>
            <td>
                Username:<input type="text" name="username" id="username" value="<?php echo $formUsername; ?>"/>
            </td>
            <td>
                MobileNo:<input type="text" name="mobileno" id="mobileno" value="<?php echo $formMobileNo; ?>"/>
            </td>
            <td>
                Dorm Address:<input type="text" name="dorm" id="dorm" value="<?php echo $formDormAddr; ?>"/>
            </td>
        </tr>
        <tr>
            <td><h4>Sandwich</h4>
                <input type="radio" name="sandwichType" id="melt" value="Subway Melt"/>Subway Melt(42) <br/>
                <input type="radio" name="sandwichType" id="veggie" value="Veggie"/>Veggie(28) <br/>
                <input type="radio" name="sandwichType" id="club" value="Club Sandwich(33)"/>Club Sandwich(33)<br/>
                <input type="radio" name="sandwichType" id="Fishy" value="Fishy wrap"/>Fishy wrap(28) <br/>
                <input type="radio" name="sandwichType" id="burger" value="Burger"/>Burger(48) <br/>
            </td>
            <td><h4>Bread type</h4>
                <input type="radio" name="breadType" id="white" value="White Slice"/>White Slice(8) <br/>
                <input type="radio" name="breadType" id="brown" value="Brown Slice"/>Brown Slice(9)<br/>
                <input type="radio" name="breadType" id="baguette" value="Baguette"/>Baguette(10) <br/>
                <input type="radio" name="breadType" id="panini" value="Panini"/>Panini(12)<br/>
            </td>
            <td><h4>filling</h4>
                <input type="checkbox" name="fillings[]" value="Cumcumber"/>Cumcumber (2.5) <br/>
                <input type="checkbox" name="fillings[]" value="Onions"/>Onions(1.0) <br/>
                <input type="checkbox" name="fillings[]" value="Tomatoes"/>Tomatoes(3.0) <br/>
                <input type="checkbox" name="fillings[]" value="Cheese"/>Cheese(5.0) <br/>
            </td>
        </tr>
        <tr>
            <th colspan="3"><input type="submit" name="button" id="button" value="Order"/>
            </td>
        </tr>
    </table>
</form>

<div>
    <p id="messages"><?php echo $messages; ?></p>
    <p id="myList"><?php echo $myList; ?></p>
    <a href="registration.php">Click here too create your new account</a>
</div>
</body>
</html>
