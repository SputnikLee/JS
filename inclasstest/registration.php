<html>
<head>
    <style>
        .div1 {
            position: relative;
            width: 400px;
            padding: 30px 0px 50px 100px;
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            font-family: "Calibri";
            border: 1px solid black;
        }

        span {
            color: red;
        }
    </style>
</head>
<body>
<?php
$dbservername = "localhost";
$dbusername = "m730026044";
$dbpassword = "abc123xyz";
$dbname = "m730026044";
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $err = 0;
    $insert = "";
    if (empty($_POST["username"])) {
        $usernameerr = "<span> *Login can't be blank</span>";
        $err++;
    } else {
        if (!preg_match("/^[i-m][0-9]{9}$/", $_POST["username"])) {
            $usernameerr = "<span>*Your Username is not correct</span>";
            $err++;
        }
        else {
            $username = $_POST["username"];
            $sql = "SELECT * FROM myCustomers WHERE username = '$username'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $usernameerr = "<span>*You have already have a account</span>";
                $err++;

            }
        }
    }

    if (empty($_POST["mobileno"])) {
        $mobilenoerr = "<span> *MobileNo can't be blank</span>";
        $err++;
    } else {
        if (!preg_match("/^[0-9]{11}$/", $_POST["mobileno"])) {
            $mobilenoerr = "<span> *MobileNo is not correct</span>";
            $err++;
        } else {
            $mobileno = $_POST["mobileno"];
        }
    }

    if (empty($_POST["dorm"])) {
        $dormerr = "<span> *Dorm Address can't be blank</span>";
        $err++;
    } else {
        if (!preg_match("/^[V][0-9]{2}$/", $_POST["dorm"])) {
            $dormerr = "<span> *Dorm Address is not correct</span>";
            $err++;
        } else {
            $dorm = $_POST["dorm"];
        }
    }

    if ($err == 0) {
        $sql = "insert into myCustomers (username,mobileNo,dormAddr) values ('$username','$mobileno','$dorm')";
        $result = $conn->query($sql);
        $conn->close();
        $insert = "<span>Create successfully!</span>";
    }
}

$conn->close();
?>
<div class="div1">
    <h1>Registration</h1>
    Create your account<br><br><br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username:<br>
        <input type="text" name="username" value="<?php echo $username ?>"><?php echo $usernameerr ?><br>
        MobileNo:<br>
        <input type="text" name="mobileno" value="<?php echo $mobileno ?>"><?php echo $mobilenoerr ?><br>
        Dorm Address:<br>
        <input type="text" name="dorm" value="<?php echo $dorm ?>"><?php echo $dormerr ?><br>
        <br><input type="submit" name="submit" value="Create your account"><?php echo $insert; ?>
    </form>
    <a href="mySandwichShop.php">Link to login Page here.</a>
</div>
</body>
</html>