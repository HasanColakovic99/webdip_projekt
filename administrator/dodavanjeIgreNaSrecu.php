<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['add'])){

        $naziv_igre = $_POST['nazivIgrePHP'];
        $brojevi = $_POST['brojeviPHP'];
        $fond_dobitka = $_POST['fondDobitkaPHP'];
        $lutrija_id = $_POST['lutrijaIdPHP'];

        $veza = new Baza();
        $veza->spojiDB();

        $sql = "INSERT INTO Igra_na_srecu(`naziv_igre`,`koliko_se_brojeva_izvlaci`,`fond_dobitka_po_pogodjenom_broju`, `lutrija_id`) "."VALUES('".$naziv_igre."','".$brojevi."', '".$fond_dobitka."', '".$lutrija_id."')";
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
    <link rel="stylesheet" href="../css/dodavanjeIgreNaSrecu.css">
    <title>Dodavanje igre na sreću</title>
</head>

<body>

    <?php
        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM Lutrija";
        $rezultat = $veza->selectDB($sql);
    ?>
    <table id="tabela" border="1" cellspacing="0" cellpadding="10">
        <caption>Lutrije</caption>
        <tr>
            <th>ID</th>
            <th>Naziv lutrije</th>
        </tr>
        <?php
        if (mysqli_num_rows($rezultat) > 0) {
            while($row = mysqli_fetch_assoc($rezultat)) {
            ?>
            <tr>
                <td><?php echo $row['lutrija_id']; ?> </td>
                <td><?php echo $row['naziv_lutrije']; ?> </td>
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
        <h2>Dodavanje igre na sreću</h2>
        <i class="fa-solid fa-plus"></i>
    </div>
    <div class="form2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form id="forma" action="dodavanjeIgreNaSrecu.php" method="POST">
            <br>
            <label for="naziv_igre">Naziv igre:</label>
            <input type="text" id="naziv_igre" name="naziv_igre">
            <br>
            <label for="brojevi">Koliko se brojeva izvlači:</label>
            <input type="number" id="brojevi" name="brojevi">
            <br>
            <label for="fond_dobitka">Fond dobitka po broju:</label>
            <input type="currency" id="fond_dobitka" name="fond_dobitka" placeholder="0HRK">
            <br>
            <label for="lutrija">Lutrija:</label>
            <input type="number" id="lutrija" name="lutrija">
            <br>
        </form>
        <button type="button" form="forma" id="dodaj">Dodaj igru na sreću</button>
        <button id="nazad">Nazad</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#dodaj').on('click', function(){

                var naziv_igre = $('#naziv_igre').val();
                var brojevi = $('#brojevi').val();
                var fond_dobitka = $('#fond_dobitka').val();
                var lutrija_id = $('#lutrija').val();

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(naziv_igre == "" || brojevi == "" || fond_dobitka == "" || lutrija_id == ""){
                    alert("Sva polja morate popuniti!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "dodavanjeIgreNaSrecu.php",
                    data: {
                        add: 1,
                        nazivIgrePHP: naziv_igre,
                        brojeviPHP: brojevi,
                        fondDobitkaPHP: fond_dobitka,
                        lutrijaIdPHP: lutrija_id                       
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste dodali igru na sreću!")
                            window.location.href = "igraNaSrecu.php";
                        }
                        else {
                            alert(response);
                        }
                    }
                })
                }
            })
            
            $('#nazad').click(function(){
                window.location.href = "igraNaSrecu.php";
            })

        })
    </script>
</body>

</html>