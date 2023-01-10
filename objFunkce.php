<?php
require "helper_funkce.php";


function ziskatCenu($isbn){
    $con = connectDB();
    $query = "SELECT cena FROM knihy WHERE isbn = '$isbn'";
    $res = mysqli_query($con, $query);
        if(!$res){
        echo "Chyba " . mysqli_error($con);
            exit;
        }
    $row = mysqli_fetch_assoc($res);
    return $row['cena'];
}

function celkCena($kosik){
    $cena = 0.0;
        if(is_array($kosik)){
            foreach($kosik as $isbn => $pocet){
               $cenaKnihy = ziskatCenu($isbn);
                if($cenaKnihy){
                    $cena += $cenaKnihy * $pocet;
              }
            }
        }
        return $price;
      }

function ziskIsbn($con, $isbn){
    $query = "SELECT titulek, autor, cena FROM knihy WHERE isbn = '$isbn'";
        $res = mysqli_query($con, $query);
        if(!$res){
            echo "Nelze získat data " . mysqli_error($conn);
        exit;
    }
    return $res;
}
?>