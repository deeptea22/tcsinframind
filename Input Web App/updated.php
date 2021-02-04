<html>
<body>
<?php
	$arr = array("C001","C002","C003","C004","C005","C006","C007","C008","C009","C010");
	$rand = array_rand($arr);
	$filename = $_FILES["image"]["name"];
	$tempname = $_FILES["image"]["tmp_name"];
	$folder = "C:/Users/deept/Documents/Deepthi/XAMPP/php/www/image/".$filename;	
	$conn = mysqli_connect("localhost","root","");
	if(!$conn){
		die("unable to connect host");
	}
	mysqli_select_db($conn,"tcsproject");	
	$bval = '$_POST[b1]';	
	$sql = "INSERT INTO custfeedback(custid,emoji,feedback,image,rating)VALUES('$arr[$rand]','$_POST[emoji]','$_POST[feedback]','$filename','$_POST[b1]')";	
	if(!mysqli_query($conn,$sql)){
		die('Error: '.mysqli_error($conn));
	}
	move_uploaded_file($tempname,$folder);
	mysqli_close($conn);
	echo "<p align='center'> <font color=lightblue size='10px'> Success! </font> </p>";
?>
</body>
</html>