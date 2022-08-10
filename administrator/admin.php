<?php

    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';

    if(isset($_POST['changeStatus'])){

        $korisnickoime = $_POST['korisnickoimePHP'];
        $blokiran = $_POST['blokiranPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $sql = "UPDATE dz4_korisnik SET blokiran=".$blokiran." WHERE kor_ime='".$korisnickoime."'";
        $rezultat = $veza->updateDB($sql);


        if($blokiran == 1){
            exit(json_encode("Blokiran"));
        }
        else{
            exit(json_encode("Odblokiran"));
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
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin</title>
</head>
<body>

    <a href="../index.php" style="position: absolute; top:10%; margin-bottom:100px;">NAZAD NA POČETNU STRANICU</a>    
    <a href="igraNaSrecu.php" target="_blank" style="position: absolute; top:10%; left: 25%">POPIS IGARA NA SREĆU</a>
    <a href="lutrija.php" target="_blank" style="position: absolute; top:10%; right:25%">POPIS LUTRIJA</a>

    <div>
        <h1>Popis svih korisnika</h1>
        <?php
            $veza = new Baza();
            $veza->spojiDB();
            $sql = "SELECT korisnik_id, ime, prezime, godina_rodjenja, email, kor_ime, lozinka, blokiran FROM dz4_korisnik";
            $rezultat = $veza->selectDB($sql);

            ?>
            <table id="tabela" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
                <th>Datum rođenja</th>
                <th>Korisničko ime</th>
                <th>Lozinka</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($rezultat) > 0) {
                while($row = mysqli_fetch_assoc($rezultat)) {

                    $blokiran = $row['blokiran'];
                    $kor_ime = $row['kor_ime'];
                    $text = "";

                    if($blokiran == 0){
                        $text = "Blokiraj";
                    }
                    else {
                        $text = "Odblokiraj";
                    }

                    // DODJELJUJEMO BUTTON-U VRIJEDNOST "Blokiraj" ili "Odblokiraj"
                    // OSIM TOGA, U ID STAVLJAMO I KORISNIČKO IME KORISNIKA KAKO BISMO ZNALI KOJEG KORISNIKA TAČNO TREBAMO BLOKIRATI/ODBLOKIRATI
                    $button = "<button class='active' id='active_".$kor_ime."'>".$text."</button>";
                ?>
                <tr>
                    <td><?php echo $row['korisnik_id']; ?> </td>
                    <td><?php echo $row['ime']; ?> </td>
                    <td><?php echo $row['prezime']; ?> </td>
                    <td><?php echo $row['email']; ?> </td>
                    <td><?php echo $row['godina_rodjenja']; ?> </td>
                    <td><?php echo $row['kor_ime']; ?> </td>
                    <td><?php echo $row['lozinka']; ?> </td>
                    <td><?php echo $button; ?> </td>
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
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">

        $(document).ready(function (){
            $('.active').click(function(){

                var korisnik = this.id;
                var split_korisnik = korisnik.split("_");
                // MORAMO SPLITAT DOHVAĆENI BUTTON KAKO BISMO DOŠLI DO KORISNIČKOG IMENA
                var korisnickoime = split_korisnik[1];
                var btnText = $(this).text();


                var blokiran = 0;
                if(btnText == "Blokiraj"){
                    blokiran = 1;
                }
                else {
                    blokiran = 0;
                }

                $.ajax({
                    method: "POST",
                    url: "admin.php",
                    data: {
                        changeStatus: 1,
                        korisnickoimePHP: korisnickoime,
                        blokiranPHP: blokiran
                    },
                    dataType: "JSON",
                    success: function(response){

                        if(response == "Blokiran"){
                            alert("Uspješno ste blokirali korisnika!"); 
                            $("#"+korisnik).html("Odblokiraj");
                        }
                        else if(response == "Odblokiran"){
                            alert("Uspješno ste odblokirali korisnika!");
                            $("#"+korisnik).html("Blokiraj");
                        }
                    }
                });
            })
        })

    </script>

</body>
</html>