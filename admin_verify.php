
<?php
  
include_once('connection.php');
	 
function connectDB() {
    $con = mysqli_connect("localhost","root","","knihovna");
    if (!$con) {
        die("Connect Error: " . mysqli_connect_error());
    }
    return $con;
}

function disconnectDB($con) {
    mysqli_close($con);
}

function selectQuery($con, $query) {
    $q = mysqli_query($con, $query);
    $resArr = array();
    if (!$q) return NULL;
    while ($res = mysqli_fetch_assoc($q)) {
        array_push($resArr, $res);
    }
    return $resArr;
}

function test_input($data) {
      
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
   

   
if ($_SERVER["REQUEST_METHOD"]== "POST") {
      
    $adminname = test_input($_POST["adminlogin"]);
    $password = test_input($_POST["adminheslo"]);
    $stmt = $con->prepare("SELECT * FROM adminlogin");
    $stmt->execute();
    $users = $stmt->fetchAll();
      
    foreach($users as $user) {
          
        if(($user['adminlogin'] == $adminname) && 
            ($user['adminheslo'] == $password)) {
                header("Location: admin_add.php");
        }
        else { ?>
            <script>
              alert('Chybně zadané údaje!');
              location.href = 'admin.php';
            </script> <?php
        }
    }
}
  ?>