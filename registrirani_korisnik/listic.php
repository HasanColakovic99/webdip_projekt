<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(array_key_exists('generiraj', $_POST)) {
        generiraj();
    }
    function generiraj() {
        $pocetniBroj = $_POST['pocetni_broj'];
        $zavrsniBroj = $_POST['zavrsni_broj'];
        $broj = $_POST['broj'];

        echo "Nasumično generirani brojevi su: ";
        for($i=0; $i<$broj; $i++){
            echo rand($pocetniBroj, $zavrsniBroj).', ';

            if($i+1 == $broj){
                echo rand($pocetniBroj, $zavrsniBroj).'.';
            }
        }
    }

    if(isset($_POST['add'])){

        $naziv_igre = $_POST['nazivIgrePHP'];
        $naziv_lutrije = $_POST['nazivLutrijePHP'];
        $brojeviBezSplita = $_POST['brojevi'];
        $brojevi = $_POST['brojeviPHP'];
        $telefon = $_POST['telefonPHP'];
        $email = $_POST['emailPHP'];
        $adresa = $_POST['adresaPHP'];
        $slika = $_POST['slikaPHP'];
        $putanja ="https://barka.foi.hr/WebDiP/2021/zadaca_04/hcolakovi/materijali/".$slika;

        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM Igra_na_srecu WHERE ". "`naziv_igre`='{$naziv_igre}'";
        $rezultat = $veza->selectDB($sql);
        $igra_na_srecu = mysqli_fetch_array($rezultat);

        $sql2 = "SELECT * FROM Lutrija WHERE ". "`naziv_lutrije`='{$naziv_lutrije}'";
        $rezultat2 = $veza->selectDB($sql2);
        $lutrija = mysqli_fetch_array($rezultat2);

        if($igra_na_srecu[2] == count($brojevi)){

            $veza = new Baza();
            $veza->spojiDB();
            $sql = "INSERT INTO Listici(`korisnik_id`, `lutrija_id`,`igra_na_srecu_id`,`uneseni_brojevi`, `telefon`, `email`, `adresa`, `img_dir`) "."VALUES('1','".$lutrija[0]."','".$igra_na_srecu[0]."', '".$brojeviBezSplita."', '".$telefon."', '".$email."', '".$adresa."', '".$putanja."')";
            $rezultat = $veza->selectDB($sql);

            if($rezultat){
                exit(json_encode("Success"));
            }
            else {
                exit(json_encode("Nažalost nismo dodali listić, pokušajte ponovo!"));
            }
        }
        else{
            exit(json_encode("Morate unijeti ".$igra_na_srecu[2]." brojeva!"));
        }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Hasan Čolaković">
    <meta name='description' content="Lipanj 13, 2022">
    <script src="https://kit.fontawesome.com/76a4e1efc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/listic.css">
    <title>Ažuriranje lutrije</title>
</head>

<body>

    <div class="generatorBrojeva" style="    
    position: relative;
    margin-top: 5%;
    left: 3%;
    border: 1px solid #ce003d;
    border-radius: 20px;
    width: 25%;
    text-align: center;
    padding: 15px;
    box-shadow: 1px 0px 10px 0px rgb(0 0 0 / 50%);
    ">
        <form method="POST">
            <h3 style="color: #ce003d;">GENERATOR SLUČAJNIH BROJEVA</h3>
            <label for="pocetni_broj">Početni broj:</label>
            <input type="number" id="pocetni_broj" name="pocetni_broj" style="border:1px solid #ce003d;">
            <br>
            <br>
            <label for="zavrsni_broj">Završni broj:</label>
            <input type="number" id="zavrsni_broj" name="zavrsni_broj" style="border:1px solid #ce003d;">
            <br>
            <br>
            <label for="broj">Koliko brojeva želite:</label>
            <input type="number" id="broj" name="broj" style="width: 27%; border:1px solid #ce003d;">
            <br>
            <br>
            <input type="submit" name="generiraj" class="button" value="GENERIRAJ" style="font-weight: bold; border-radius: 8px; border: 1px solid #ce003d; color: #fff; background-color: #ce003d; padding:10px;"/>
        </form>
    </div>

    <?php
        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM Igra_na_srecu";
        $rezultat = $veza->selectDB($sql);

        ?>
        <table id="tabela" border="1" cellspacing="0" cellpadding="10">
            <caption>Igre na sreću</caption>
            <tr>
                <th>ID</th>
                <th>Naziv igre</th>
                <th>Koliko se izvlači brojeva</th>
            </tr>
            <?php
            if (mysqli_num_rows($rezultat) > 0) {
                while($row = mysqli_fetch_assoc($rezultat)) {
                ?>
                <tr>
                    <td><?php echo $row['igra_na_srecu_id']; ?> </td>
                    <td><?php echo $row['naziv_igre']; ?> </td>
                    <td><?php echo $row['koliko_se_brojeva_izvlaci']; ?> </td>
                <tr>
                <?php
                }
            } 
            else { ?>
                <tr>
                <td colspan="8">Nismo pronašli nikakve podatke u bazi!</td>
                </tr>
                <?php } ?>
    </table>

    <div class="forma">
        <h2>Kreiranje listića</h2>
        <i class="fa-solid fa-file-circle-plus"></i>
    </div>
    <div class="form2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form id="forma" action="listic.php" method="POST">
            <?php
                $id = $_GET['id'];
                $veza = new Baza();
                $veza->spojiDB();
                $sql1 = "SELECT * FROM `Igra_na_srecu` WHERE ". "`igra_na_srecu_id`='{$id}'";
                $rezultat1 = $veza->selectDB($sql1);
                $row1 = mysqli_fetch_assoc($rezultat1);

                $lutrija_id = $row1['lutrija_id'];

                $sql2 = "SELECT * FROM `Lutrija` WHERE ". "`lutrija_id`='{$lutrija_id}'";
                $rezultat2 = $veza->selectDB($sql2);
                $row2 = mysqli_fetch_assoc($rezultat2);

                $veza->zatvoriDB();
            ?>
            <br>
            <label for="naziv_igre">Naziv igre:</label>
            <input type="text" id="naziv_igre" name="naziv_igre"  value = "<?php echo $row1['naziv_igre']; ?>" disabled>
            <br>
            <label for="naziv_lutrije">Naziv lutrije:</label>
            <input type="text" id="naziv_lutrije" name="naziv_lutrije"  value = "<?php echo $row2['naziv_lutrije']; ?>" disabled>
            <br>
            <label for="brojevi">Unesite brojeve:</label>
            <input type="text" id="brojevi" name="brojevi" placeholder="npr. 1,2,3,4,5...">
            <br>
            <label for="telefon">Broj telefona:</label>
            <input type="text" id="telefon" name="telefon" placeholder="npr. +385 12 345 6789">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="npr. hcolakovi@foi.hr">
            <br>
            <label for="adresa">Adresa:</label>
            <input type="text" id="adresa" name="adresa">
            <br>
            <label for="slika">Slika listića:</label>
            <input type="file" id="slika" name="slika" accept="image/png, image/jpg">
            <br>
        </form>
        <button type="button" form="forma" id="dodaj" name="dodaj">Dodaj</button>
        <button id="nazad">Nazad</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            $('#dodaj').on('click', function(){

                var naziv_igre = $('#naziv_igre').val();
                var naziv_lutrije = $('#naziv_lutrije').val();
                var brojevi = $('#brojevi').val();
                var telefon = $('#telefon').val();
                var email = $('#email').val();
                var adresa = $('#adresa').val();
                var slika = $('#slika').val().split("\\");
                var array = $('#brojevi').val().split(",");

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(naziv_igre == "" || naziv_lutrije == "" ||  array == "" || telefon == "" || email == "" || adresa == "" || slika == ""){
                    alert("Sva polja morate popuniti!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "listic.php",
                    data: {
                        add: 1,
                        nazivIgrePHP: naziv_igre,
                        nazivLutrijePHP: naziv_lutrije,
                        brojevi: brojevi,
                        brojeviPHP: array,
                        telefonPHP: telefon,
                        emailPHP: email,
                        adresaPHP: adresa,
                        slikaPHP: slika[2]                      
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste uplatili listić!")
                            window.location.href = "index.php";
                        }
                        else {
                            alert(response);
                        }
                    }
                })
                }
            }) 


            $('#nazad').click(function(){
                window.location.href = "index.php";
            })

        })
    </script>
</body>

</html>