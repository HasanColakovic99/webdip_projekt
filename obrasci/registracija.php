<?php    
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());

    include_once '../zaglavlje.php';
    include_once '../sesija.class.php';


    if(isset($_POST['register'])){

        // UZIMAMO SVE UNEŠENE VRIJEDNOSTI
        $ime = htmlspecialchars($_POST['imePHP']);
        $prezime = $_POST['prezimePHP'];
        $godina_rodjenja = $_POST['datumPHP'];
        $email = $_POST['emailPHP'];
        $korisnickoime = htmlspecialchars($_POST['korisnickoimePHP']);
        $password = $_POST['passwordPHP'];
        $repeatpassword = $_POST['repeatpasswordPHP'];
        $cookie= $_POST['cookiePHP'];
        $captchaPHP = $_POST['captchaPHP'];


        // PROVJERA ISPRAVNOSTI GODINE ROĐENJA
        if (!preg_match("/^([0-2][0-9])\.([0-1][1-9])\.([0-9][0-9][0-9][0-9])\.$/",$godina_rodjenja)) {
            exit(json_encode("Godina rođenja nije ispravnog formata. Format je dd.mm.yyyy."));
        }

        // PROVJERA ISPRAVNOSTI EMAILA
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            exit(json_encode("Neispravan mail!"));
        }

        // PROVJERA DA LI IME I PREZIME IMAJU BAREM 3 SLOVA
        if(strlen($ime) < 3 || strlen($prezime) < 3){
            exit(json_encode("Ime i prezime moraju imati minimalno 3 znaka!"));
        }

        // PROVJERA DA LI SE LOZINKE POKLAPAJU
        if($password != $repeatpassword){
            exit(json_encode("Lozinke se ne podudaraju!"));
        }


        // PROVJERIMO DA LI JE POTVRĐENA CAPTCHA
        if($_POST['captchaPHP'] != ""){

            // AKO SE REGISTRIRA, BIT ĆE REGISTRIRANI KORISNIK, STOGA ULOGA = 2
            $uloga_korisnika = 2;

            // SPAJAMO SE NA BAZU DA PROVJERIMO DA LI VEĆ NEKO POSTOJI SA KORISNIČKIM IMENOM
            $veza = new Baza();
            $veza->spojiDB();
            $upit = "SELECT * FROM `dz4_korisnik` WHERE ". "`kor_ime`='{$korisnickoime}'";
            $rezultat = $veza->selectDB($upit);
            $korisnik = mysqli_fetch_array($rezultat);
            $veza->zatvoriDB();

            if(mysqli_num_rows($rezultat) == 0){
                $veza = new Baza();
                $veza->spojiDB();

                // GENERIRANJE VKEY-A ZA VALIDACIJU MAILA
                $vkey = md5(time());
                // UZIMAMO TRENUTNO VRIJEME KAKO BISMO ZNALI KAD SE KORISNIK REGISTRIRAO (POTREBNO ZA VALIDIRANJE MAILA)
                $datum_registracije = date('Y-m-d H:i:s');

                // ŠALJEMO MAIL
                $to = $email;
                $subject = "VALIDACIJA EMAILA";
                $message = "Vaš ključ je: $vkey. <a href='https://barka.foi.hr/WebDiP/2021/zadaca_04/hcolakovi/obrasci/validacija.php'>Validiraj email</a>";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <hcolakovi@foi.hr>' . "\r\n";

                // DODAJEMO KORISNIKA U BAZU PODATAKA
                $sql = "INSERT INTO dz4_korisnik(`ime`,`prezime`,`godina_rodjenja`, `email`, `kor_ime`, `lozinka`, `ponovljena_lozinka`, `vkey`, `datum_registracije`, `cookies`, `uloga_korisnika_id`) "."VALUES('".$ime."','".$prezime."', '".$godina_rodjenja."', '".$email."', '".$korisnickoime."', '".$password."', '".$repeatpassword."', '".$vkey."', '".$datum_registracije."', '".$cookie."', '".$uloga_korisnika."')";

                $rezultat = $veza->selectDB($sql);

                // POVRATNA INFORMACIJA KORISNIKU
                if (mail($to,$subject,$message,$headers) && $rezultat) {
                    $veza->zatvoriDB();
                    exit(json_encode("Poslali smo mail i registrirali korisnika"));
                } else {
                    exit(json_encode("Pojavila se greška te nismo u stanju registrirati tog korisnika!"));
                }
            }
            else {
                exit(json_encode("Taj korisnik već postoji!"));
            }
            $veza->zatvoriDB();
        }
        else {
            exit(json_encode("Morate potvrditi da niste robot!"));
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../css/registracija.css">
    <title>Registracija</title>
</head>

<body>

    <header class="header">
        <a href="../index.php" target="_blank"><img class="img-logo" src="../materijali/logo.svg" alt="logo"></a>
        <a href="#naslov">
            <h1 class="h1">REGISTRACIJA</h1>
        </a>
        <a href="#meni" id="a"><i class="fa-solid fa-bars"></i></a>
    </header>

    <div class="pokusaj">
        <div class="izbornik" id="naslov">
            <ul class="linkovi" id="meni">
                <li>
                    <a href="../index.php" target="_blank">Početna</a>
                </li>
                <li>
                    <a href="../popis.php" target="_blank">Popis</a>
                </li>
                <li>
                    <a href="../era.php" target="_blank">Era</a>
                </li>
                <li>
                    <a href="../navigacija.php" target="_blank">Navigacija</a>
                </li>
                <li>
                    <a href="../multimedija.php" target="_blank">Multimedija</a>
                </li>
                <li>
                    <a href="obrazac.php" target="_blank">Obrazac</a>
                </li>
                <li>
                    <a href="prijava.php" target="_blank">Prijava</a>
                </li>
                <li>
                    <a href="../test.html" target="_blank">Test</a>
                </li>
                <li>
                    <a href="../testBrzine.html" target="_blank">Test brzine</a>
                </li>
            </ul>
        </div>

        <div class="forma">
            <h2>Registriraj se</h2>
            <i class="fa-solid fa-id-card"></i>
        </div>
        <div class="form2">
            <h3>Molimo Vas da unesete podatke</h3>
            <form id="forma" action="registracija.php" method="POST" novalidate>
                <label class="labelaIme" for="ime">Ime:</label>
                <input type="text" id="ime" name="ime">
                <br>
                <label class="labelaPrezime" for="prezime">Prezime:</label>
                <input type="text" id="prezime" name="prezime" onchange="provjeraBrojaZnakova()">
                <br>
                <label class="labelaDatum" for="datum">Datum rođenja:</label>
                <input type="text" id="datum" name="datum" onchange="provjeraDatuma()">
                <br>
                <label class="labelaEmail" for="email">Email:</label>
                <input type="text" id="email" name="email" placeholder="ldap@foi.hr" onchange="provjeraEmaila()">
                <br>
                <label class="korisnickoImeLabela" for="korisnickoime">Korisničko ime:</label>
                <input type="text" id="korisnickoime" name="korisnickoime" maxlength="25">
                <br>
                <label class="lozinkaLabela" for="password">Lozinka:</label>
                <input type="password" id="password" name="password" maxlength="50">
                <br>
                <label class="ponovljenaLozinkaLabela" for="repeatpassword">Potvrdite lozinku:</label>
                <input type="password" id="repeatpassword" name="repeatpassword" maxlength="50" onchange="provjeraLozinka()">
                <br>
                <label for="cookies">Kolačići?</label>
                <select id="cookies" name="cookies">
                    <option value="nužni">Nužni</option>
                    <option value="marketinški">Marketinški</option>
                    <option value="analitički">Analitički</option>
                </select>
                <div id="recaptcha" class="g-recaptcha" data-sitekey="6LfFc14gAAAAACr6JNU3IEo2MfsRmaA7GE4X957w" style="position: relative; top:20px; left:20px;"></div>
            </form>
            <button type="button" form="forma" id="registriraj" >Registriraj se</button>
        </div>
    </div>
    <footer>
        <img src="../materijali/HTML5.png" width="60" height="60" alt="html logo">
        <p>&copy; 2022 <a href="mailto:hasancolakovic32@gmail.com">Hasan Čolaković</a></p>
        <img src="../materijali/CSS3.png" width="60" height="60" alt="css logo">
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../javascript/registracija.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#registriraj').on('click', function(){

                var ime = $('#ime').val();
                var prezime = $('#prezime').val();
                var datum = $('#datum').val();
                var email = $('#email').val();
                var korisnickoime = $('#korisnickoime').val();
                var password = $('#password').val();
                var repeatpassword = $('#repeatpassword').val();
                var cookie = $('#cookies').val();
                var recaptcha = $('.g-recaptcha-response').val();
                

                // PROVJERA DA LI SU SVA POLJA POPUNJENA
                if(ime == "" || prezime == "" || datum == "" || email == "" || korisnickoime == "" || password == "" || password == "" || repeatpassword == ""){
                    alert("Sva polja morate popuniti!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "registracija.php",
                    data: {
                        register: 1,
                        imePHP: ime,
                        prezimePHP: prezime,
                        datumPHP: datum,
                        emailPHP: email,
                        korisnickoimePHP: korisnickoime,
                        passwordPHP: password,
                        repeatpasswordPHP: repeatpassword,
                        cookiePHP: cookie,
                        captchaPHP: recaptcha  
                    },
                    dataType: "JSON",
                    success: function(response){
                        alert(response);
                    }
                })
                }
            })

        })
    </script>
</body>

</html>