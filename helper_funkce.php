<?php
/**
 *  HELPER FUNKCE PRO DB
 */


// slouží k připojení databázového handlu
// info k db je napsané napevno
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

function pre_r($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}
?>