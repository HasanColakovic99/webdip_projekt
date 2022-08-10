<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['update'])){

        $naziv_lutrije = $_POST['nazivLutrijePHP'];
        $lokacija = $_POST['lokacijaPHP'];
        $datum_osnivanja = $_POST['datumOsnivanjaPHP'];
        $broj_ispostava = $_POST['brojIspostavaPHP'];
        $zemlja_porijekla = $_POST['zemljaPorijeklaPHP'];

        $veza = new Baza();
        $veza->spojiDB();

        $sql = "UPDATE Lutrija SET `naziv_lutrije`='".$naziv_lutrije."', `lokacija`='".$lokacija."', `datum_osnivanja`='".$datum_osnivanja."', `broj_ispostava`='".$broj_ispostava."', `zemlja_porijekla`='".$zemlja_porijekla."' WHERE naziv_lutrije='".$naziv_lutrije."'";
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
    <link rel="stylesheet" href="../css/azuriranjeLutrije.css">
    <title>Ažuriranje lutrije</title>
</head>

<body>

    <?php
        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM Zemlja_porijekla";
        $rezultat = $veza->selectDB($sql);

        ?>
        <table id="tabela" border="1" cellspacing="0" cellpadding="10">
            <caption>Zemlje porijekla</caption>
            <tr>
                <th>ID</th>
                <th>Naziv države</th>
                <th>Kontinent</th>
            </tr>
            <?php
            if (mysqli_num_rows($rezultat) > 0) {
                while($row = mysqli_fetch_assoc($rezultat)) {
                ?>
                <tr>
                    <td><?php echo $row['zemlja_porijekla_id']; ?> </td>
                    <td><?php echo $row['naziv_drzave']; ?> </td>
                    <td><?php echo $row['kontinent']; ?> </td>
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
            <h2>Ažuriranje lutrije</h2>
            <i class="fa-solid fa-pen"></i>
        </div>
        <div class="form2">
            <h3>Molimo Vas da unesete podatke</h3>
            <form id="forma" action="azuriranjeLutrije.php" method="POST" novalidate>
                <?php
                    $id = $_GET['id'];
                    $veza = new Baza();
                    $veza->spojiDB();
                    $sql = "SELECT * FROM `Lutrija` WHERE ". "`lutrija_id`='{$id}'";
                    $rezultat = $veza->selectDB($sql);
                    $row = mysqli_fetch_assoc($rezultat);
                    $veza->zatvoriDB();
                ?>
                <br>
                <label for="naziv_lutrije">Naziv lutrije:</label>
                <input type="text" id="naziv_lutrije" name="naziv_lutrije"  value = "<?php echo $row['naziv_lutrije']; ?>">
                <br>
                <label for="lokacija">Lokacija:</label>
                <input type="text" id="lokacija" name="lokacija"  value = "<?php echo $row['lokacija']; ?>">
                <br>
                <label for="datum_osnivanja">Datum osnivanja:</label>
                <input type="date" id="datum_osnivanja" name="datum_osnivanja"  value = "<?php echo $row['datum_osnivanja']; ?>">
                <br>
                <label for="broj_ispostava">Broj ispostava:</label>
                <input type="number" id="broj_ispostava" name="broj_ispostava"  value = "<?php echo $row['broj_ispostava']; ?>">
                <br>
                <label for="online_kladjenje">Online klađenje:</label>
                <!-- <input type="text" id="online_kladjenje" name="online_kladjenje"  value = "<?php echo $row['online_kladjenje']; ?>"> -->
                <select id="online_kladjenje" name="online_kladjenje">
                    <?php 
                        if($row['online_kladjenje'] == "Da"){
                            echo '<option value="Da" selected>Da</option>';
                            echo '<option value="Ne">Ne</option>';
                        }
                        else {
                            echo '<option value="Da">Da</option>';
                            echo '<option value="Ne" selected>Ne</option>';
                        }
                    ?>
                </select>
                <br>
                <label for="zemlja_porijekla">Zemlja porijekla:</label>
                <input type="text" id="zemlja_porijekla" name="zemlja_porijekla"  value = "<?php echo $row['zemlja_porijekla']; ?>">
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

                var naziv_lutrije = $('#naziv_lutrije').val();
                var lokacija = $('#lokacija').val();
                var datum_osnivanja = $('#datum_osnivanja').val();
                var broj_ispostava = $('#broj_ispostava').val();
                var online_kladjenje = $('#online_kladjenje').val();
                var zemlja_porijekla = $('#zemlja_porijekla').val();

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(naziv_lutrije == "" || lokacija == "" || datum_osnivanja == "" || broj_ispostava == "" || online_kladjenje == "" || zemlja_porijekla == ""){
                    alert("Sva polja morate popuniti!");
                }
                else if(zemlja_porijekla > 10){
                    alert("Zemlja porijekla mora biti manja od 11!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "azuriranjeLutrije.php",
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
                            alert("Uspješno ste ažurirali lutriju!")
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