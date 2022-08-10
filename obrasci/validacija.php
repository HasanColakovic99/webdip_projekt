<?php    

    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());

    include_once '../zaglavlje.php';
    include_once '../sesija.class.php';

    if(isset($_POST['validate'])){

        $email = $_POST['emailPHP'];
        $kljuc = $_POST['kljucPHP'];

        $veza = new Baza();
        $veza->spojiDB();
        $upit = "SELECT * FROM `dz4_korisnik` WHERE ". "`email`='{$email}'";
        $rezultat = $veza->selectDB($upit);

        if(mysqli_num_rows($rezultat) == 0){
            exit(json_encode("Niste unijeli dobar email!"));
        }

        $korisnik = mysqli_fetch_array($rezultat);
        $veza->zatvoriDB();
        
        $vrijemeRegistracije = $korisnik[10];
        $trenutnoVrijeme = date('Y-m-d H:i:s');
        $sekunde = strtotime($trenutnoVrijeme) - strtotime($vrijemeRegistracije);
        $brojSati = $sekunde / 60 /  60;

        if($korisnik[4] == $email){

            if($brojSati > 7){
                $veza = new Baza();
                $veza->spojiDB();
                $upit = "DELETE FROM `dz4_korisnik` WHERE email = '".$email."'";
                $rezultat = $veza->selectDB($upit);
                exit(json_encode("Prošlo je 7 sati od Vaše registracije. To znači da ne možete validirati Vaš mail te je Vaš račun obrisan!"));
            }

            if($korisnik[8] == $kljuc){
                $veza = new Baza();
                $veza->spojiDB();
                $sql = "UPDATE dz4_korisnik SET `validate`='1' WHERE email='".$email."'";
                $rezultat = $veza->updateDB($sql);

                exit(json_encode("success"));
            }
            else {
                exit(json_encode("Ključ koji ste unijeli nije ispravan!"));
            }

        }
        else {
            exit(json_encode("Email adresa koju ste unijeli nije ispravna!"));
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
    <link rel="stylesheet" href="../css/validacija.css">
    <title>Validiranje emaila</title>
</head>

<body>
    <div class="forma">
        <h2>Validiranje emaila</h2>
        <i class="fa-solid fa-envelope-circle-check"></i>
    </div>
    <div class="form2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="validraj.php" method="POST" id="formPrijava" novalidate>
            <label for="email">Vaš email:</label>
            <input type="text" id="email" name="email" style="width: 71.5%">
            <br>
            <label for="kljuc">Vaš ključ:</label>
            <input type="password" id="kljuc" name="kljuc" style="width: 72%">
            <br>
        </form>
        <button type="button" id="validiraj" form="formPrijava" name="prijaviSe">Validiraj</button>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#validiraj").on("click", function(){
                var email = $("#email").val();
                var kljuc = $("#kljuc").val();
            
                if(email == "" || kljuc == ""){
                    alert("Morate popuniti sva polja!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "validacija.php",
                    data: {
                        validate: 1,
                        emailPHP: email,
                        kljucPHP: kljuc,
                    },
                    dataType: "json",
                    success: function(response){
                        if(response == "success"){
                            alert("Uspješno ste verificirali Vaš email. Sada se možete prijaviti!")
                            window.location.href = "prijava.php";
                        }
                        else if(response == "Prošlo je 7 sati od Vaše registracije. To znači da ne možete validirati Vaš mail te je Vaš račun obrisan!"){
                            alert("Prošlo je 7 sati od Vaše registracije. To znači da ne možete validirati Vaš mail te je Vaš račun obrisan!");
                            window.location.href = "registracija.php";
                        }
                        else if (response != "success"){
                            alert(response);
                        }
                    }
                });
                }
            })
        })

    </script>

</body>
</html>