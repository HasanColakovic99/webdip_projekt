<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['assign'])){
        $naziv_igre = $_POST['nazivIgrePHP'];
        $koliko_se_izvlaci_brojeva = $_POST['brojeviPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $sql = "UPDATE Igra_na_srecu SET `koliko_se_brojeva_izvlaci`='".$koliko_se_izvlaci_brojeva."' WHERE naziv_igre='".$naziv_igre."'";
        $rezultat = $veza->updateDB($sql);

        if($rezultat){
            exit(json_encode("Success"));
        }
        else {
            exit(json_encode("Nažalost došlo je do pogreške, pokušajte ponovo!"));
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
    <link rel="stylesheet" href="../css/dodjelaModeratoraLutriji.css">
    <title>Definiranje koliko se izvlači brojeva</title>
</head>

<body>
    <div class="forma1">
        <h2>Definiraj koliko se brojeva izvlači</h2>
        <i class="fa-solid fa-arrow-up-1-9"></i>
    </div>
    <div class="forma2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="kolikoSeBrojevaIzvlaci.php" method="POST" id="formPrijava" novalidate>
            <?php
                $id = $_GET['id'];
                $veza = new Baza();
                $veza->spojiDB();
                $sql = "SELECT * FROM `Igra_na_srecu` WHERE ". "`igra_na_srecu_id`='{$id}'";
                $rezultat = $veza->selectDB($sql);
                $row = mysqli_fetch_assoc($rezultat);
                $veza->zatvoriDB();
            ?>
            <label for="naziv_igre">Naziv igre:</label>
            <input type="text" id="naziv_igre" name="naziv_igre" value="<?php echo $row['naziv_igre']; ?>" style="width: 69.5%" disabled>
            <br>
            <label for="brojevi">Koliko se brojeva izvlači:</label>
            <input type="number" id="brojevi" name="brojevi" style="width: 51%" value = "<?php echo $row['koliko_se_brojeva_izvlaci']; ?>">
            <br>
        </form>
        <button type="button" id="definiraj" form="formPrijava" name="prijaviSe">Definiraj broj brojeva</button>
        <button type="button" id="nazad" form="formPrijava" name="nazad">Nazad</button>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#definiraj').on('click', function(){

                var naziv_igre = $('#naziv_igre').val();
                var brojevi = $('#brojevi').val();

                if(brojevi == ""){
                    alert("Morate unijeti koliko se izvlači brojeva!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "kolikoSeBrojevaIzvlaci.php",
                    data: {
                        assign: 1,
                        nazivIgrePHP: naziv_igre,
                        brojeviPHP: brojevi                       
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste definirali koliko se izvlači brojeva!");
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