<?php
  include_once('helper_funkce.php');
 
  session_start();
?>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP -->
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
    <title>Web knihovna</title>
    <script>
      // Zdroj: https://www.w3schools.com/js/js_cookies.asp
      function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        let expires = "expires="+d.toUTCString();
        //console.log(cname + "=" + cvalue + ";" + expires + ";path=/");
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }
      
      function getCookie(cname) {
          let name = cname + "=";
          let ca = document.cookie.split(';');
          for(let i = 0; i < ca.length; i++) {
              let c = ca[i];
              while (c.charAt(0) == ' ') {
                  c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
              }
          }
          return "";
      }

      function checkCookie(username) {
          let user = getCookie(username);
          if (user != "") {
              return true;
          } else {
              return false;
          }
      }

      function pridatPolozkuKosiku(knihaID) {
          let cookie_string = getCookie('kosik');
          if (cookie_string != '') {
              cookie_string = cookie_string + ',' + knihaID;
          } else {
              cookie_string = knihaID;
          }

          setCookie('kosik', cookie_string, 2);
      }

      function odebratPolozkuKosiku(knihaID) {
        let cookie_string = getCookie('kosik');
        if (cookie_string != '') { // alespon jedna polozka
          if (cookie_string.includes(',')) { // vice nez jedna polozka
            let cookie_arr = cookie_string.split(',');
            let kniha_pozice = cookie_arr.indexOf(knihaID);
            if (kniha_pozice != -1) {
              cookie_arr.splice(kniha_pozice, 1);
              cookie_string = cookie_arr.join(',');
              setCookie('kosik', cookie_string, 2);
            }
          } else { // jedna polozka
            setCookie('kosik', '', 2);
          }
          window.location.reload();
        }
      }
  </script>
</head>
<body>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <!--<a class="navbar-brand" href="<?php// echo $_SERVER["PHP_SELF"]; ?>">Domů</a>-->
      <a class="navbar-brand" aria-current="page" href="<?php echo $_SERVER['PHP_SELF'] . '?section=catalog' ?>">Katalog</a>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="main_nav">
        <ul class="navbar-nav">
          <li class="nav-item">
          <a class="nav-link" href="<?php echo $_SERVER["PHP_SELF"] . '?section=kosik'?>">Košík</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Účet
            </a>
            <ul class="dropdown-menu fade-up" aria-labelledby="navbarDropdownMenuLink">
              <?php 
                if (!isset($_SESSION['logged'])):?>
                <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?section=register'; ?>">Registrace</a></li>
                <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?section=login'; ?>">Přihlášení</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?section=user'; ?>">Detail</a></li>
                <li><a class="dropdown-item" href="<?php echo $_SERVER['PHP_SELF'] . '?section=logout'; ?>">Odhlásit</a></li>
              <?php endif; ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>



<?php
  $section = '';
  if (!empty($_GET['section'])) {
    switch($_GET['section']){
      case 'login':
      case 'user':
        $section = 'user';
        break;
      case 'catalog':
        $section = 'catalog';
        break;
      case 'register':
        $section = 'register';
        break;
      case 'logout':
        $section = 'logout';
        break;
      case 'kosik':
        $section = 'kosik';
        break;
      default:
        break;
    }
  }

  if ($section === 'catalog') {
      ?><div class="container"><?php
      $con = connectDB();

      $res = selectQuery($con, 'SELECT * FROM knihy');
      
      foreach($res as $r) {
        ?>
          <div class="row mt-3 gray-bg" >
            <tr>
              <td><div class="col-1"><img src="img/<?php echo $r['obal'];?>" width="80rem" height="100rem" alt="<?php echo $r['titulek']?>"></div></td>
              <td><div class="col-9 p-3 rounded-corners mx-auto"></td>
              <td><p class="fs-3 m-0 p-0"><?php echo $r['titulek']; ?></p></td>
              <td><p class="fs-6 m-0 p-0"><?php echo '(' . $r['isbn'] . ')'; ?></p></td>
              <td><p class="fs-6 m-0 p-0">Autor: <?php echo $r['autor']; ?></p></td>
              <td><p class="fs-6 m-0 p-0">Cena: <?php echo $r['cena']; ?></p></td>
            </tr> 
            </div>
            <div class="col-2">
              <button class="cart-button" onclick="<?php echo 'pridatPolozkuKosiku(\'' . $r['isbn'] . '\');'; ?>"><img class="cart" src="img/shopping_cart.svg" alt="Přidat do košíku"/></button>
            </div>
          </div>
        <?php
      }
      $res = selectQuery($con, 'SELECT * FROM uzivatele');

      /*foreach($res as $r) {
          echo '<div class="row"><div class="col">' . $r['uzivatel_id'] . ' | ' . $r['jmeno'] . ' | ' . $r['email'] . ' | ' . $r['ulice'] . ' | ' . $r['psc'] . ' | ' . $r['mesto'] . '</div></div>';
      }*/
      disconnectDB($con);
      ?></div><?php
  }
  else if ($section === 'user') {
    if (isset($_SESSION['logged'])) { //user info
      echo '<script>console.log("' . $_SESSION['logged'] . '");</script>';
      $con = connectDB();
      $query = 'SELECT * FROM uzivatele WHERE email = "' . $_SESSION['logged'] . '"';
      $res = selectQuery($con, $query)[0];
      ?>
        <div class="container">

          <div class="row justify-content-center mt-5 px-2 py-4 gray-bg rounded-corners">
            <div class="row">
              <div class="col-5">
                <h1 class="fs-3">Přehled uživatele</h1>
              </div>
            </div>

            <div class="row">
              <div class="col-5 ml-5">
                <p>Jméno: <?php echo $res['jmeno'] ?><br>
                E-mail: <?php echo $res['email'] ?><br>
                Adresa: <?php echo $res['ulice'] . ', ' . $res['mesto'] . ' ' . $res['psc'] ?></p>
              </div>
            </div>
        </div>
      <?php
    } else { //login page
      if (isset($_POST['login'])) {
        $login = new stdClass();
        $login->email = $_POST['email'];
        $login->heslo = $_POST['heslo'];
        $con = connectDB();
        $query = 'SELECT email, heslo FROM uzivatele WHERE email = "' . $login->email . '"';
        $res = selectQuery($con, $query);
        if ($res != null) {
          if (md5($login->heslo) === $res[0]['heslo']){
            $_SESSION['logged'] = $login->email;
            ?>
            <script>
              location.href = 'index.php?section=user';
            </script>
            <?php
          }
        }
      }
      ?>
      <div class="container">
        <div class="row justify-content-center mt-5">
          <div class="col-5 center">
            <form method="post" action="">
              <div class="mb-2">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" />
              </div>

              <div class="mb-2">
                <label for="heslo" class="form-label">Heslo:</label>
                <input type="password" name="heslo" id="heslo" class="form-control"/>
              </div> 
              <button type="submit" name="login" class="btn btn-primary">Přihlásit</button>
            </form>
          </div>
        </div>
      </div>
      <?php
    }
  }
  else if ($section === 'register') {
    if (isset($_POST['register'])) {
      $user = new stdClass();
      $user->email = $_POST['email'];
      $user->jmeno = $_POST['jmeno'];
      $user->ulice = $_POST['ulice'];
      $user->mesto = $_POST['mesto'];
      $user->psc = $_POST['psc'];
      $user->heslo = md5($_POST['heslo']);

      $con = connectDB();
      if ($con) {
        $query = 'SELECT email FROM uzivatele WHERE email = "' . $user->email . '"';
        $res = selectQuery($con, $query);

        if ($res != null) {
          ?>
            <script>
              alert('Tento e-mail se již používá.');
              location.href = 'index.php?section=user';
            </script>
          <?php
        } else {
          $query = 'INSERT INTO uzivatele (email, heslo, jmeno, ulice, mesto, psc, is_admin) VALUES ("' . $user->email .'","' . $user->heslo . '","' . $user->jmeno . '","' . $user->ulice .'","'. $user->mesto . '","' . $user->psc . '", "0")';
          $res = mysqli_query($con, $query);

          ?>
          <script>
          //alert('query odeslána.');
          //console.log("<?php echo $res ?>")
          //location.href = 'index.php?section=user';
          //</script>
        <?php
          if ($res) {
            ?>
              <script>
                alert('Registrace proběhla úspěšně. Nyní se prosím přihlašte.');
                location.href = 'index.php?section=login';
              </script>
            <?php
          } else {
            ?>
              <script>
                alert('Registrace se nezdařila zkuste to prosím znovu.');
                location.href = 'index.php?section=register';
              </script>
            <?php
          }          
        }
      }
      disconnectDB($con); 
    }
    ?>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-5 center">
          <form method="post" action=''>

            <div class="mb-2">
              <label for="email" class="form-label">E-mail:</label>
              <input type="email" id="email" name="email" class="form-control" required/>
            </div>

            <div class="mb-2">
              <label for="jmeno" class="form-label">Jméno a Příjmení:</label>
              <input type="text" id="jmeno" name="jmeno" class="form-control" required/>
            </div>

            <div class="mb-2">
              <label for="ulice" class="form-label">Ulice a číslo popisné:</label>
              <input type="text" id="ulice" name="ulice" class="form-control" required/>
            </div>

            <div class="mb-2">
              <label for="mesto" class="form-label">Město:</label>
              <input type="text" id="mesto" name="mesto" class="form-control" required/>
            </div>

            <div class="mb-2">
              <label for="psc" class="form-label">Poštovní směrovací číslo:</label>
              <input type="text" id="psc" name="psc" class="form-control" required/>
            </div>

            <div class="mb-2">
              <label for="heslo" class="form-label">Heslo:</label>
              <input type="password" id="heslo" name="heslo" class="form-control" required/>
            </div> 
            <button type="submit" name="register" class="btn btn-primary" value="submit">Registrovat</button>
          </form>
        </div>
      </div>
    </div>
    <?php
  } else if ($section == 'logout') {
    session_destroy();
    ?>
    <script>
      location.href = 'index.php?section=login';
    </script>
<?php
  } else if ($section == 'kosik') {
    if (isset($_COOKIE['kosik']) && $_COOKIE['kosik'] != '') {
      $kosik_string = $_COOKIE['kosik'];
      $kosik_arr = array();
      if (strpos($kosik_string, ',') != -1) {
        $kosik_arr = explode(',', $kosik_string);
      } else {
        $kosik_arr[0] = $kosik_string;
      }

      $kosik_arr_unikatni = array_merge($kosik_arr, $kosik_arr);

      $con = connectDB();
      if ($con) {
        if (count($kosik_arr_unikatni) > 1) {
          $query = 'SELECT * FROM knihy WHERE isbn IN ("' . implode('","', $kosik_arr_unikatni) . '")';
        } else {
          $query = 'SELECT * FROM knihy WHERE isbn = "' . $kosik_arr_unikatni[0] . '"';
        }

        $res = selectQuery($con, $query);

        echo '<div class="container">';
        foreach($res as $kl => $hod) {
          ?>
            <div class="row justify-content-center mt-5 p-0 gray-bg rounded-corners">
            <div class="col-1"><img src="img/<?php echo $hod['obal'];?>" width="80rem" height="100rem" alt="<?php echo $hod['titulek']?>"></div>
              <div class="col-10">
                <h5><?php echo $hod['titulek']; ?></h5>
                <h6><?php echo 'Autor: ' . $hod['autor']; ?></h6>
                <p><?php echo 'Cena: ' . $hod['cena']; ?></p>
                <p>
                  <?php
                    $pocet = 0;
                    foreach($kosik_arr as $h) {
                      if ($h == $hod['isbn']) $pocet++; 
                    }
                    echo 'Počet: ' . $pocet;
                  ?>
                </p>
              </div>
              <div class="col-12">
              <button onclick="window.location.href = 'checkout.php';" href="checkout.php" class="cart-checkout" <?= ($pocet > 1) ? '' : 'disabled'; ?>><img class="cart" src="img/shopping_cart.svg" alt="Přidat do košíku"/></button>
              </div>
              <div class="col-12">
                <button class="cart-button-remove" onclick="<?php echo 'odebratPolozkuKosiku(\'' . $hod['isbn'] . '\');'; ?>"><img class="cart" src="img/shopping_cart.svg" alt="Přidat do košíku"/></button>   
              </div>
            </div>

          <?php
        }
        echo '</div>';
      }
      disconnectDB($con);
    } else {
      ?>
        <div class="row">
          <div class="col-5">
            <h1>Košík je prázdný.</h1>
          </div>
        </div>
      <?php
    }

  } 
  ?>
  <script src="js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <footer>
  <?php
  echo "<footer class='footer'>";
    if(isset($conn)) {mysqli_close($conn);}
    require_once "footer.php";
  echo "</footer>";
  ?>
  </footer>
</body>
</html>
