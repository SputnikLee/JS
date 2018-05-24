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
$uname = $psw = $cpsw = $familyname = $firstname = $id = $gender =  "";
$unameerr = $pswerr = $cpswerr = $familynameerr = $firstnameerr = $iderr = $gendererr = $provinceerr = $loanerr = "";
$house = $mastercard = $visa = $store = $other = "";
$province = 0;
$loan = array();

$servername = "localhost";
$username = "m730026044";
$password = "abc123xyz";
$dbname = "m730026044";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$sql = "SELECT * FROM usertable";
$result = $conn -> query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $creditscore = $err = 0;
    $insert = "";
    if (empty($_POST["username"])) {
        $unameerr = "<span> *Login can't be blank</span>";
        $err++;
    }
    else {
        $uname = $_POST["username"];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($uname == $row["username"]) {
                    $unameerr = "<span>*Username is already taken</span>";
                    $err++;
                    break;
                }
            }
        }
    }

    if (empty($_POST["password"])) {
        $pswerr = "<span> *Password can't be blank</span>";
        $err++;
    }
    else if (!preg_match(" /^[A-Z]+(?=.{8,})(?=.*\d{2,})(?=.*[a-z]{2,})(?=.*[!@#$%^&*? .]{2,}).+[A-Z]*$/", $_POST["password"])) {
        $pswerr = "<br><span> *Password should have:
        <ul>	
            <li>10 + characters</li>
            <li>Start and end with uppercase</li>
            <li>2 non-alphanumeric</li>
            <li>Minimum of 2 numerical characters</li>
            <li>Minimum of 2 lowercase</li>
        </ul>
        </span>";
        $err++;
    }
    else $psw = $_POST["password"];

    if (empty($_POST["passwordcheck"])) {
        $cpswerr = "<span> *Confirm your password</span>";
        $err++;
    }
    else if ($_POST["passwordcheck"] != $psw) {
        $cpswerr = "<span> *Two input password must be consistent</span>";
        $err++;
    }
    else $cpsw = $psw;

    if (empty($_POST["familyname"])) {
        $familynameerr = "<span> *Family name can't be blank</span>";
        $err++;
    }
    else $familyname = $_POST["familyname"];

    if (empty($_POST["firstname"])) {
        $firstnameerr = "<span> *First name can't be blank</span>";
        $err++;
    }
    else $firstname = $_POST["firstname"];

    if (empty($_POST["id"])) {
        $iderr = "<span> *ID card number can't be blank</span>";
        $err++;
    }
    else if (!preg_match("/^[0-9]{17}([0-9]|x|X)$/", $_POST["id"])) {
        $iderr = "<br><span> *Please enter the correct ID card number</span>";
        $err++;
    }
    else {
        $id = $_POST["id"];
        $nowtime = (int)date("m") * 100 + date("d");
        $nowyear = (int)date("Y");
        $bornyear = (int)substr($id, 6, 4);
        $borntime = (int)substr($id, 10, 4);
        if ($nowtime < $borntime)
            $age = $nowyear - $bornyear - 1;
        else $age = $nowyear - $bornyear;
    }
    if ($age < 18) {
        $iderr = "<span> *You must be at least 18</span>";
        $err++;
    }

    if (empty($_POST["gender"])) {
        $gendererr = "<span> *Gender cant't be blank</span>";
        $err++;
    }
    else {
        $gender = $_POST["gender"];
    }

    if ($_POST["province"] == 0) {
        $provinceerr = "<span> *Province cant't be blank</span>";
        $err++;
    }
    else $province = $_POST["province"];

    if (empty($_POST["loan"])) {
        $loanerr = "<span> *Loans cant't be blank</span>";
        $err++;
    }
    else {
        $loan = $_POST["loan"];
        $loannum = 0;
        for ($i = 0; $i < count($loan); ++$i) {
            if ($loan[$i] == 1){
                $house = "Y";
                $loannum += 200;
            }
            else $house = "N";
            if ($loan[$i] == 2){
                $mastercard = "Y";
                $loannum += 55;
            }
            else $mastercard = "N";
            if ($loan[$i] == 3){
                $visa = "Y";
                $loannum += 50;
            }
            else $visa = "N";
            if ($loan[$i] == 4){
                $store = "Y";
                $loannum -= 25;
            }
            else $store = "N";
            if ($loan[$i] == 5){
                $other = "Y";
                $loannum -= 100;
            }
            else $other = "N";
        }
    }

    if ($err == 0) {
        $creditscore = creditScoreCalc($age, $gender, $province, $loannum);
        $insert = insertNewMember($uname,$psw,$id,$firstname,$familyname,$age,$gender,$house,$mastercard,$visa,$store,$other,$creditscore);
    }
}
function creditScoreCalc($age, $gender, $province, $loannum)
{
    $score = 0;
    if($gender=="M"){
        if($age >= 41){
            if($age >= 61) $score = 11;
            else $score = 40;
        }
        else {
            if($age<=24) $score = -50;
            else $score = 25;
        }
    }
    else {
        if($age >= 41){
            if($age >= 61) $score = 1;
            else $score = 40;
        }
        else {
            if($age<=24) $score = 25;
            else $score = 50;
        }
    }
    switch ($province){
        case 1:
            $score += 100;
            break;
        case 2:
            $score += 60;
            break;
        case 3:
            $score += 72;
            break;
        case 4:
            $score += 123;
            break;
    }
    return $loannum + $score;
}

function insertNewMember($uname,$psw,$id,$firstname,$familyname,$age,$gender,$house,$mastercard,$visa,$store,$other,$creditscore){
    $servername = "localhost";
    $username = "m730026044";
    $password = "abc123xyz";
    $dbname = "m730026044";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $insert = "";

    $sql = 	"insert into usertable 
    (username,password,id_number,firstname,familyname,age,gender,
    houseloan,mastercard,visacard,storecard,otherloan,creditscore)
    values ('$uname','$psw','$id','$firstname','$familyname','$age','$gender',
    '$house','$mastercard','$visa','$store','$other','$creditscore')";
    $result = $conn->query($sql);
    $conn->close();
    $insert = "<span>Create successfully!</span>";
    return $insert;
}

?>
<div class="div1">
    <h1>Registration</h1>
    plz fill your information<br><br><br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username:<br>
        <input type="text" name="username" value="<?php echo $uname ?>"><?php echo $unameerr ?><br>
        Password:<br>
        <input type="password" name="password" value="<?php echo $psw ?>"><?php echo $pswerr ?><br>
        Confirm password:<br>
        <input type="password" name="passwordcheck" value="<?php echo $cpsw ?>"><?php echo $cpswerr ?><br>
        Family Name:<br>
        <input type="text" name="familyname" value="<?php echo $familyname ?>"><?php echo $familynameerr ?><br>
        First Name:<br>
        <input type="text" name="firstname" value="<?php echo $firstname ?>"><?php echo $firstnameerr ?><br>
        ID card number:<br>
        <input type="text" name="id" value="<?php echo $id ?>"><?php echo $iderr ?><br>
        Gender:<br>
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "F") echo "checked"; ?>
               value="F">Female
        <input type="radio" name="gender" <?php if (isset($gender) && $gender == "M") echo "checked"; ?>
               value="M">Male<?php echo $gendererr ?><br>
        Province:<br>
        <select name="province">
            <option value="0" <?php if (isset($province) && $province == 0) echo "selected" ?>
            >--select your province--
            </option>
            <option value="1" <?php if (isset($province) && $province == 1) echo "selected" ?>
            >Municipalities
            </option>
            <option value="2" <?php if (isset($province) && $province == 2) echo "selected" ?>
            >Province
            </option>
            <option value="3" <?php if (isset($province) && $province == 3) echo "selected" ?>
            >Autonomous
            </option>
            <option value="4" <?php if (isset($province) && $province == 4) echo "selected" ?>
            >SAR
            </option>
        </select><?php echo $provinceerr ?><br>
        Loans:<?php echo $loanerr ?><br>
        <input type="checkbox" name="loan[]" value="1"> Loan for the house
        <input type="checkbox" name="loan[]" value="2"> Master Card<br>
        <input type="checkbox" name="loan[]" value="3"> Visa
        <input type="checkbox" name="loan[]" value="4"> Store Card
        <input type="checkbox" name="loan[]" value="5"> Other loan<br>

        <br><input type="submit" name="submit" value="Create your account"><?php echo $insert;?>
    </form>
    <a href="login.php">Link to login Page here.</a>
</div>
</body>
</html>