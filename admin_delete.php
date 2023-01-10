<?php
	
	require_once "connection.php";
	function connectDB() {
		$con = mysqli_connect("localhost","root","","knihovna");
		if (!$con) {
			die("Chyba připojení: " . mysqli_connect_error());
		}
		return $con;
	}

	//require_once "helper_funkce.php";
	
	$isbn = $_POST['isbn']; 
	$con = connectDB();
    	if ($con) {
			//$query1 = 'SELECT isbn FROM knihy WHERE isbn = "' . $isbn->isbn . '"';
			$query = 'DELETE FROM knihy WHERE isbn = "' . $isbn->isbn . '"';

			$res = mysqli_query($con, $query);
	}
	header("Location: admin_add.php");
}
	
?>