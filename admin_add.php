
<head>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    

<div class="container">
        <div class="row justify-content-center mt-5">
        <div class="col-5 center">
            <form method="POST" action="" enctype="multipart/form-data">

                <div class="mb-2">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label for="titulek" class="form-label">Název knihy</label>
                    <input type="text" name="titulek" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" name="autor" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="obal" class="form-label">Obal Knihy</label>
                    <input type="file" name="obal"  class="form-control" >
                </div>

                <div class="mb-2">
                    <label for="popis" class="form-label">Popis Knihy</label>
                    <textarea name="popis" cols="60" rows="3" class = "form control"></textarea>
                </div>

                <div class="mb-2">
                    <label for="cena" class="form-label">Cena</label>
                    <input type="text" name="cena" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="vydavatel_id" class="form-label">Vydavatelství</label>
                    <input type="vydavatel_id" name="vydavatel_id" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label for="pocet_skladem" class="form-label">Počet Skladem</label>
                    <input type="pocet_skladem" name="pocet_skladem" class="form-control" required>
                </div>

                <div class="mb 2">
                    <button type="submit" name="add" class="btn btn-primary" value="submit">Přidat</button>
                    <button type="reset" name= "domu" class="btn btn-primary" value="cancel" onclick="window.location.href = 'index.php';">Domů</button>
                    <button type="reset" name= "del" class="btn btn-primary" value="cancel" onclick="window.location.href = 'admin_delete.php';">Smazat ISBN </button>
                </div>
            </form>
</div>
        </div>
        </div>
            
        </body>                    
          <div class="container">
                
                <?php
                //require 'helper_funkce.php';
                require 'connection.php';

                function connectDB() {
                  $con = mysqli_connect("localhost","root","","knihovna");
                  if (!$con) {
                      die("Connect Error: " . mysqli_connect_error());
                  }
                  return $con;
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
                


                 // if (isset($SESSION['admin_add.php'])) {
                    $isbn = $_POST['isbn'];                
                    $titulek = $_POST['titulek'];
                    $autor = $_POST['autor'];
                    //$obal = $_POST['obal'];
                    $popis = $_POST['popis'];
                    $cena = $_POST['cena'];
                    $vydavatel_id = $_POST['vydavatel_id'];
                    $pocet_skladem = $_POST['pocet_skladem'];
                  //}
                  
                    //přidat obal
                      /*if(isset($_FILES['obal'] && $_FILES['obal']['nazev'] != ""){
                        $image = $_FILES['obal']['nazev'];
                        $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
                        $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "img/";
                        $uploadDirectory .= $image;
                        move_uploaded_file($_FILES['obal']['tmp_name'], $uploadDirectory);
                      }*/
                      

                    $con = connectDB();
                    if ($con) {
                      $query1 = 'SELECT isbn FROM knihy WHERE isbn = "' . $isbn->isbn . '"';
                      $res = selectQuery($con, $query1);
                      var_dump($res);
                        if ($res != null) {
                          ?>
                            <script>
                              alert('isbn duplicitní.');
                              location.href = 'admin_add.php';
                            </script>
                          <?php
                          } else {
                              $query2 = 'INSERT INTO knihy (isbn, titulek, autor, obal, popis, cena, vydavatel_id, pocet_skladem) VALUES ("' . $isbn . '", "' . $titulek . '", "' . $autor . '", "' . $obal . '", "' . $popis . '", "' . $cena . '", "' . $vydavatel_id . '", "' . $pocet_skladem  . '")';
                              var_dump($query2);
                              
                              $res = mysqli_query($con, $query2);
                              var_dump($res);
                              
                              ?>
                              <script>
                              alert('Kniha přidána do databáze.');
                              console.log("<?php echo $res ?>")
                              location.href = 'admin_add.php';
                              </script>
                            <?php
                        }
                      }
                  
                      if(isset($conn)) {mysqli_close($conn);}
                      require_once "footer.php";
 
                  ?>


              

