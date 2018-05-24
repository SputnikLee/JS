<html>
<head>
	<style>
		table{
			border-collapse:collapse;
			font-family: "Calibri";
			
		}
	</style>
</head>
<body>
<?php
	$servername = "localhost";
	$username = "m730026044";
	$password = "abc123xyz";
	$dbname = "m730026044";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM usertable";
	$result = $conn -> query($sql);
	if($result->num_rows >0)
	{
		echo "<table border='1' style='font-family:Calibri'>
		<tr>
		<th width='150px'>Family name</th>
		<th width='200px'>Id name</th>
		<th width='100px'>Age</th>
		<th width='100px'>Gender</th>
		<th width='100px'>Credit score</th>
		</tr>";
		while($row = $result -> fetch_assoc())
		{
			echo "<center><tr>
			<td>".$row["firstname"]."</td>
			<td>".$row["id_number"]."</td>
			<td>".$row["age"]."</td>
			<td>".$row["gender"]."</td>
			<td>".$row["creditscore"]."</td>
			</tr></center>";
		}
		echo "</table>";
	}
?>
</body>
<html>