<?php
  
$con = "";
   
try {
    $servername = "localhost";
    $dbname = "knihovna";
    $username = "root";
    $password = "";
   
    $con = new PDO(
        "mysql:host=$servername; dbname=knihovna",
        $username, $password
    );
      
   $con->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
  
?>