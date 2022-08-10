<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['assign'])){
        $naziv_lutrije = $_POST['nazivLutrijePHP'];
        $moderator_id = $_POST['moderator_idPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM `dz4_korisnik` WHERE ". "`uloga_korisnika_id`='3'";
        $rezultat = $veza->selectDB($sql);
        $row = mysqli_fetch_assoc($rezultat);
        $veza->zatvoriDB();

        if($row['korisnik_id'] == $moderator_id){

            $veza = new Baza();
            $veza->spojiDB();
            $sql = "UPDATE Lutrija SET `moderator`='".$moderator_id."' WHERE naziv_lutrije='".$naziv_lutrije."'";
            $rezultat = $veza->updateDB($sql);

            exit(json_encode("success"));
        }
        else {
            exit(json_encode("Moderator sa tim ID-om ne postoji! (pogledaj tabelu sa lijeve strane)"));
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
    <meta name='description' content="Ožujak 17, 2022">

    <script src="https://kit.fontawesome.com/76a4e1efc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/dodjelaModeratoraLutriji.css">
    <title>Dodjelivanje moderatora lutriji</title>
</head>

<body>

    <?php
        $veza = new Baza();
        $veza->spojiDB();
        $sql = "SELECT * FROM `dz4_korisnik` WHERE ". "`uloga_korisnika_id`='3'";
        $rezultat = $veza->selectDB($sql);
    ?>
    <table id="tabela" border="1" cellspacing="0" cellpadding="10" style="margin-left:80px; margin-top:150px;">
        <caption style="color: #ce003d; font-size:25px;">Moderatori</caption>
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Prezime</th>
        </tr>
        <?php
        if (mysqli_num_rows($rezultat) > 0) {
            while($row = mysqli_fetch_assoc($rezultat)) {
            ?>
            <tr>
                <td><?php echo $row['korisnik_id']; ?> </td>
                <td><?php echo $row['ime']; ?> </td>
                <td><?php echo $row['prezime']; ?> </td>
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



    <div class="forma1">
        <h2>Dodjela moderatora lutriji</h2>
        <i class="fa-solid fa-circle-plus"></i>
    </div>
    <div class="forma2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="dodjelaModeratoraLutriji.php" method="POST" id="formPrijava" novalidate>
            <?php
                $id = $_GET['id'];
                $veza = new Baza();
                $veza->spojiDB();
                $sql = "SELECT * FROM `Lutrija` WHERE ". "`lutrija_id`='{$id}'";
                $rezultat = $veza->selectDB($sql);
                $row = mysqli_fetch_assoc($rezultat);
                $veza->zatvoriDB();
            ?>
            <label for="naziv_lutrije">Naziv lutrije:</label>
            <input type="text" id="naziv_lutrije" name="naziv_lutrije" value="<?php echo $row['naziv_lutrije']; ?>" style="width: 67.5%" disabled>
            <br>
            <label for="moderator_id">ID moderatora:</label>
            <input type="number" id="moderator_id" name="moderator_id" style="width: 65%">
            <br>
        </form>
        <button type="button" id="dodijeli" form="formPrijava" name="prijaviSe">Dodijeli</button>
        <button type="button" id="nazad" form="formPrijava" name="nazad">Nazad</button>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#dodijeli').on('click', function(){

                var naziv_lutrije = $('#naziv_lutrije').val();
                var moderator_id = $('#moderator_id').val();

                if(moderator_id == ""){
                    alert("Morate popuniti id moderatora!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "dodjelaModeratoraLutriji.php",
                    data: {
                        assign: 1,
                        nazivLutrijePHP: naziv_lutrije,
                        moderator_idPHP: moderator_id                       
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "success"){
                            alert("Uspješno ste dodijeli moderatora lutriji!");
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