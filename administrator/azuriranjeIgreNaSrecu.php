<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['update'])){

        $naziv_igre = $_POST['nazivIgrePHP'];
        $koliko_se_brojeva_izvlaci = $_POST['brojeviPHP'];
        $fond_dobitka = $_POST['fondDobitkaPHP'];
        $lutrija_id = $_POST['lutrijaIdPHP'];

        $veza = new Baza();
        $veza->spojiDB();

        $sql = "UPDATE Igra_na_srecu SET `naziv_igre`='".$naziv_igre."', `koliko_se_brojeva_izvlaci`='".$koliko_se_brojeva_izvlaci."', `fond_dobitka_po_pogodjenom_broju`='".$fond_dobitka."', `lutrija_id`='".$lutrija_id."' WHERE naziv_igre='".$naziv_igre."'";
        $rezultat = $veza->updateDB($sql);

        if($rezultat){
            exit(json_encode("Success"));
        }
        else {
            exit(json_encode("Nažalost došlo je do pogreške!"));
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
    <link rel="stylesheet" href="../css/azuriranjeIgreNaSrecu.css">
    <title>Ažuriranje igre na sreću</title>
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
            <h2>Ažuriranje igre na sreću</h2>
            <i class="fa-solid fa-pen"></i>
        </div>
        <div class="form2">
            <h3>Molimo Vas da unesete podatke</h3>
            <form id="forma" action="azuriranjeIgreNaSrecu.php" method="POST" novalidate>
                <?php
                    $id = $_GET['id'];
                    $veza = new Baza();
                    $veza->spojiDB();
                    $sql = "SELECT * FROM `Igra_na_srecu` WHERE ". "`igra_na_srecu_id`='{$id}'";
                    $rezultat = $veza->selectDB($sql);
                    $row = mysqli_fetch_assoc($rezultat);
                    $veza->zatvoriDB();
                ?>
                <br>
                <label for="naziv_igre">Naziv igre:</label>
                <input type="text" id="naziv_igre" name="naziv_igre"  value = "<?php echo $row['naziv_igre']; ?>">
                <br>
                <label for="brojevi">Koliko se izvlači brojeva:</label>
                <input type="number" id="brojevi" name="brojevi" value = "<?php echo $row['koliko_se_brojeva_izvlaci']; ?>">
                <br>
                <label for="fond_dobitka">Fond dobitka po pogođenom broju:</label>
                <input type="currency" id="fond_dobitka" name="fond_dobitka"  value = "<?php echo $row['fond_dobitka_po_pogodjenom_broju']; ?>">
                <br>
                <label for="lutrija">Lutrija:</label>
                <input type="number" id="lutrija" name="lutrija"  value = "<?php echo $row['lutrija_id']; ?>">
                <br>
            </form>
            <button type="button" form="forma" id="azuriraj" >Ažuriraj</button>
            <button id="nazad">Nazad</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#azuriraj').on('click', function(){

                var naziv_igre = $('#naziv_igre').val();
                var brojevi = $('#brojevi').val();
                var fond_dobitka = $('#fond_dobitka').val();
                var lutrija_id = $('#lutrija').val();

                console.log(naziv_igre);
                console.log(brojevi);
                console.log(fond_dobitka);
                console.log(lutrija_id);

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(naziv_igre == "" || brojevi == "" || fond_dobitka == "" || lutrija_id == ""){
                    alert("Sva polja morate popuniti!");
                }
                else if(lutrija_id > 10){
                    alert("Lutrija može imati maksimalnu vrijednost 10!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "azuriranjeIgreNaSrecu.php",
                    data: {
                        update: 1,
                        nazivIgrePHP: naziv_igre,
                        brojeviPHP: brojevi,
                        fondDobitkaPHP: fond_dobitka,
                        lutrijaIdPHP: lutrija_id                     
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste ažurirali igru na sreću!")
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