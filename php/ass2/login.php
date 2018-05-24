<html>
<head>
    <style>
        .div1{
            position: relative;
            width: 400px;
            padding-top: 50px;
            padding-bottom: 50px;
            margin-top: 200px;
            margin-left: auto;
            margin-right: auto;
            font-family: "Calibri";
            border: 1px solid black;
        }
        .err{
            color: red;
        }
        .table{
            border-collapse:collapse;
        }
    </style>
</head>
<body>
<?php
$mes = $name = $psw = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["username"]))
        $mes = "<div class='err'>*Plz input your account</div>";
    else if(empty($_POST["password"]))
    {
        $mes = "<div class='err'>*Plz input your password</div>";
        $name = $_POST["username"];
    }
    else
    {
        $psw = $_POST["password"];
        $name = $_POST["username"];

        $servername = "localhost";
        $username = "m730026044";
        $password = "abc123xyz";
        $dbname = "m730026044";

        $conn = mysqli_connect($servername, $username, $password, $dbname);


        $sql = "SELECT * FROM usertable";
        $result = $conn -> query($sql);

        if($result->num_rows >0)
        {
            while($row = $result -> fetch_assoc())
            {
                if($row["username"]==$name && $row["password"]==$psw)
                {
                    $mes = "<br><h3>Here is your information:</h3>
                    <table class='table' border='1px'>
                        <tr>
                            <td width='100px'>name</td>
                            <td width='150px'>".$row["firstname"]." ".$row["familyname"]."</td>
                        </tr>
                        <tr>
                            <td>Age</td>
                            <td>".$row["age"]."</td>
                        </tr>
                        <tr>
                            <td>Credit Score</td>
                            <td>".$row["creditscore"]."</td>
                        </tr>
                    </table><br>";

                    break;
                }
            }
            if(empty($mes))
            {
                $mes = "<div class='err'>Plz check your user name and password!</div>";
            }
        }
    }
    $conn->close();
}
?>
<div class="div1">
    <center><form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Username:<br><input type="text" name="username" value="<?php echo $name?>"><br>
            <br>
        Password:<br><input type="password" name="password" value="<?php echo $psw?>"><br><br>
        <input type="submit" name="submit" value="submit"><br>
        </form>
    <a href="regisration.php">Create your account here!</a><br>
    <?php echo $mes?></center>
</div>

</body>
<html>
