<link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

	
	session_start();
	require_once "connection.php";
	//
	//require_once "objFunkce.php";




?>
	<table class="table">
		<tr>
			<th>Kniha</th>
			<th>Cena</th>
	    	<th>Množství</th>
	    	<th>Celková cena</th>
	    </tr>
	    	<?php
			    foreach($_SESSION['kosik'] as $isbn => $pocet){
					$con = connectDB();
					$kniha = mysqli_fetch_assoc(ziskIsbn($con, $isbn));
			?>
		<tr>
			<td><?php echo $book['titulek'] . " by " . $book['autor']; ?></td>
			<td><?php echo "$" . $book['cena']; ?></td>
			<td><?php echo $mnozstvi; ?></td>
			<td><?php echo "$" . $pocet * $kniha['cena']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $_SESSION['kosik']; ?></th>
			<th><?php echo "$" . $_SESSION['kosik']; ?></th>
		</tr>
	</table>
	<div class="container">
        <div class="row justify-content-center mt-5">
        <div class="col-5 center">
            <form method="POST" action="" enctype="multipart/form-data">

                <div class="mb-2">
                    <label for="jmeno" class="form-label">Jméno</label>
                    <input type="text" name="jmeno" class="form-control" required>
                </div>
				<div class="mb-2">
                    <label for="prijmeni" class="form-label">Přijmení</label>
                    <input type="text" name="prijmeni" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="adresa" class="form-label">Adresa</label>
                    <input type="text" name="adresa" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="mesto" class="form-label">Město</label>
                    <input type="text" name="mesto" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="psc" class="form-label">PSČ</label>
                    <input type="text" name="psc"  class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="knihy" class="form-label">Knihy</label>
                    <input type="text" name="knihy"  class="form-control" required>
                </div>

				<div class="mb-2">
                    <label for="mnozstvi" class="form-label">Množství</label>
                    <input type="number" name="mnozstvi"  class="form-control" required>
                </div>
                <div class="mb 2">
                    <button type="submit" name="add" class="btn btn-primary" value="submit">Objednat</button>
                    <button type="reset" name= "domu" class="btn btn-primary" value="cancel" onclick="window.location.href = 'index.php?section=catalog';">Domů</button>
                </div>
            </form>
</div>
        </div>
        </div>

<?php
$jmeno = $_POST['jmeno'];                
$prijmeni = $_POST['prijmeni'];
$adresa = $_POST['adresa'];
$mesto = $_POST['mesto'];
$psc = $_POST['psc'];
$knihy = $_POST['knihy'];
$mnozstvi = $_POST['mnozstvi'];


$con = connectDB();
if ($con) {
  $query = 'INSERT INTO objednavky (jmeno, prijmeni, adresa, mesto, psc, knihy, mnozstvi) VALUES ("' . $jmeno . '", "' . $prijmeni . '", "' . $adresa . '", "' . $mesto . '", "' . $psc . '", "' . $knihy . '", "' . $mnozstvi . '")';
  $res = mysqli_query($con, $query);
  var_dump($res);
  ?>
  <script>
  alert('Objednávka úspěšná.');
  console.log("<?php echo $res ?>")
  location.href = 'index.php?section=catalog';
  </script>
<?php
	  } 
?>