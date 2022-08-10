<?php    

    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());

    function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    include_once '../zaglavlje.php';
    include_once '../sesija.class.php';

    if(isset($_POST['login'])){

        $email = $_POST['emailPHP'];
        $veza = new Baza();
        $veza->spojiDB();
        $upit = "SELECT * FROM `dz4_korisnik` WHERE ". "`email`='{$email}'";
        $rezultat = $veza->selectDB($upit);

        if(mysqli_num_rows($rezultat) == 0){
            exit(json_encode("Vaš email nije ispravan. Pokušajte ponovo!"));
        }

        $korisnik = mysqli_fetch_array($rezultat);
        $veza->zatvoriDB();

        if($korisnik[4] == $email){

            $password = generateRandomString();

            // ŠALJEMO MAIL
            $to = $email;
            $subject = "VAŠA LOZINKA JE RESETIRANA";
            $message = "Vaša nova lozinka je: $password. <a href='https://barka.foi.hr/WebDiP/2021/zadaca_04/hcolakovi/obrasci/prijava.php'>Prijavite se sa novom lozinkom</a>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: <hcolakovi@foi.hr>' . "\r\n";

            $veza = new Baza();
            $veza->spojiDB();
            $sql1 = "UPDATE dz4_korisnik SET `lozinka`='".$password."' WHERE email='".$email."'";
            $sql2 = "UPDATE dz4_korisnik SET `ponovljena_lozinka`='".$password."' WHERE email='".$email."'";
            $rezultat = $veza->updateDB($sql1);
            $rezultat = $veza->updateDB($sql2);

            if (mail($to,$subject,$message,$headers) && $rezultat) {
                $veza->zatvoriDB();
                exit(json_encode("success"));
            } else {
                exit(json_encode("Pojavila se greška te nismo u stanju promijeniti lozinku i poslati Vam mail!"));
            }
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
    <meta name='description' content="Lipanj 09, 2022">
    <script src="https://kit.fontawesome.com/76a4e1efc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/zaboravljenaLozinka.css">
    <title>Zaboravljena lozinka</title>
</head>

<body>
    <div class="forma">
        <h2>Zaboravljena lozinka</h2>
        <i class="fa-solid fa-trash-arrow-up"></i>
    </div>
    <div class="form2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="zaboravljenalozinka.php" method="POST" id="formPrijava">
            <label id="emailLabela" for="email">Vaš email:</label>
            <input type="text" id="email" name="email">
        </form>
        <button type="button" id="login" form="formPrijava" name="prijaviSe">Potvrdi</button>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#login").on("click", function(){
                var email = $("#email").val();
            
                if(email == ""){
                    alert("Morate popuniti sva polja!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "zaboravljenalozinka.php",
                    data: {
                        login: 1,
                        emailPHP: email,
                    },
                    dataType: "JSON",
                    success: function(response){
                        if(response == "success"){
                            alert("Provjerite Vaš mail kako biste saznali novu lozinku!");
                            window.location.href = "prijava.php";
                        }
                        else {
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