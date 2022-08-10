<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['update'])){

        $naziv_lutrije = $_POST['nazivLutrijePHP'];
        $lokacija = $_POST['lokacijaPHP'];
        $datum_osnivanja = $_POST['datumOsnivanjaPHP'];
        $broj_ispostava = $_POST['brojIspostavaPHP'];
        $online_kladjenje = $_POST['onlineKladjenjePHP'];
        $zemlja_porijekla = $_POST['zemljaPorijeklaPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $upit = "SELECT * FROM `Zemlja_porijekla` WHERE ". "`naziv_drzave`='{$zemlja_porijekla}'";
        $rezultat = $veza->selectDB($upit);
        $drzava = mysqli_fetch_array($rezultat);
        $sql = "INSERT INTO Lutrija(`naziv_lutrije`,`lokacija`,`datum_osnivanja`, `broj_ispostava`, `online_kladjenje`, `zemlja_porijekla`) "."VALUES('".$naziv_lutrije."','".$lokacija."', '".$datum_osnivanja."', '".$broj_ispostava."', '".$online_kladjenje."', '".$drzava[0]."')";
        $rezultat = $veza->selectDB($sql);

        if($rezultat){
            exit(json_encode("Success"));
        }
        else {
            exit(json_encode("Nažalost došlo je do pogreške!"));
        }

        $veza->zatvoriDB();
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
    <link rel="stylesheet" href="../css/dodavanjeLutrije.css">
    <title>Dodavanje lutrije</title>
</head>

<body>

    <header class="header">
        <a href="index.php" target="_blank"><img class="img-logo" src="../materijali/logo.svg" alt="logo"></a>
        <a href="#naslov">
            <h1 class="h1">Dodavanje lutrije</h1>
        </a>
        <a href="#meni" id="a"><i class="fa-solid fa-bars"></i></a>
    </header>

    <div class="pokusaj">
        <div class="izbornik" id="naslov">
            <ul class="linkovi" id="meni">
                <!-- MENI -->
            </ul>
        </div>

        <div class="forma">
            <h2>Dodavanje lutrije</h2>
            <i class="fa-solid fa-plus"></i>
        </div>
        <div class="form2">
            <h3>Molimo Vas da unesete podatke</h3>
            <form id="forma" action="dodavanjeLutrije.php" method="POST">
                <br>
                <label for="naziv_lutrije">Naziv lutrije:</label>
                <input type="text" id="naziv_lutrije" name="naziv_lutrije">
                <br>
                <label for="lokacija">Lokacija:</label>
                <input type="text" id="lokacija" name="lokacija">
                <br>
                <label for="datum_osnivanja">Datum osnivanja:</label>
                <input type="date" id="datum_osnivanja" name="datum_osnivanja">
                <br>
                <label for="broj_ispostava">Broj ispostava:</label>
                <input type="number" id="broj_ispostava" name="broj_ispostava">
                <br>
                <label for="online_kladjenje">Online klađenje:</label>
                <select id="online_kladjenje" name="online_kladjenje">
                    <option value="Da">Da</option>
                    <option value="Ne">Ne</option>
                </select>
                <br>
                <label for="zemlja_porijekla">Zemlja porijekla:</label>
                <select id="zemlja_porijekla" name="zemlja_porijekla">
                    <option value="BiH">BiH</option>
                    <option value="Hrvatska">Hrvatska</option>
                    <option value="Srbija">Srbija</option>
                    <option value="Italija">Italija</option>
                    <option value="Švicarska">Švicarska</option>
                    <option value="SAD">SAD</option>
                    <option value="Meksiko">Meksiko</option>
                    <option value="Kina">Kina</option>
                    <option value="Japan">Japan</option>
                    <option value="Južnoafrička Republika">Južnoafrička Republika</option>
                </select>
                <br>
            </form>
            <button type="button" form="forma" id="dodaj">Dodaj lutriju</button>
            <button id="nazad">Nazad</button>
        </div>
    </div>
    <footer>
        <img src="../materijali/HTML5.png" width="60" height="60" alt="html logo">
        <p>&copy; 2022 <a href="mailto:hasancolakovic32@gmail.com">Hasan Čolaković</a></p>
        <img src="../materijali/CSS3.png" width="60" height="60" alt="css logo">
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#dodaj').on('click', function(){

                var naziv_lutrije = $('#naziv_lutrije').val();
                var lokacija = $('#lokacija').val();
                var datum_osnivanja = $('#datum_osnivanja').val();
                var broj_ispostava = $('#broj_ispostava').val();
                var online_kladjenje = $('#online_kladjenje').val();
                var zemlja_porijekla = $('#zemlja_porijekla2').val();

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(naziv_lutrije == "" || lokacija == "" || datum_osnivanja == "" || broj_ispostava == "" || online_kladjenje == "" || zemlja_porijekla == ""){
                    alert("Sva polja morate popuniti!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "dodavanjeLutrije.php",
                    data: {
                        update: 1,
                        nazivLutrijePHP: naziv_lutrije,
                        lokacijaPHP: lokacija,
                        datumOsnivanjaPHP: datum_osnivanja,
                        brojIspostavaPHP: broj_ispostava,
                        onlineKladjenjePHP: online_kladjenje,
                        zemljaPorijeklaPHP: zemlja_porijekla                        
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste dodali lutriju!")
                            window.location.href = "lutrija.php";
                        }
                        else {
                            alert(response);
                        }
                    }
                })
                }
            })
            
            $('#nazad').click(function(){
                window.location.href = "lutrija.php";
            })

        })
    </script>
</body>

</html>