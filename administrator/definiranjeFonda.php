<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['assign'])){
        $naziv_igre = $_POST['nazivIgrePHP'];
        $fond_dobitka = $_POST['fondDobitkaPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $sql = "UPDATE Igra_na_srecu SET `fond_dobitka_po_pogodjenom_broju`='".$fond_dobitka."' WHERE naziv_igre='".$naziv_igre."'";
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
    <title>Definiranje fonda</title>
</head>

<body>
    <div class="forma1">
        <h2>Definiranje fonda po pogođenom broju</h2>
        <i class="fa-solid fa-sack-dollar"></i>
    </div>
    <div class="forma2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="definiranjeFonda.php" method="POST" id="formPrijava" novalidate>
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
            <label for="fond_dobitka">Fond dobitka:</label>
            <input type="currency" id="fond_dobitka" name="fond_dobitka" style="width: 66%" value = "<?php echo $row['fond_dobitka_po_pogodjenom_broju']; ?>">
            <br>
        </form>
        <button type="button" id="definiraj" form="formPrijava" name="prijaviSe">Definiraj fond</button>
        <button type="button" id="nazad" form="formPrijava" name="nazad">Nazad</button>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#definiraj').on('click', function(){

                var naziv_igre = $('#naziv_igre').val();
                var fond_dobitka = $('#fond_dobitka').val();

                if(fond_dobitka == ""){
                    alert("Morate definirati fond!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "definiranjeFonda.php",
                    data: {
                        assign: 1,
                        nazivIgrePHP: naziv_igre,
                        fondDobitkaPHP: fond_dobitka                       
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "Success"){
                            alert("Uspješno ste definirali fond dobitka po pogođenom broju!");
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