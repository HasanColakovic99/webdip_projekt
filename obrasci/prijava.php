<?php    

    session_start();
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());

    include_once '../zaglavlje.php';
    include_once '../sesija.class.php';
    require_once '../https.php';

    if(isset($_POST['login'])){

        $korisnickoime = htmlspecialchars($_POST['korisnickoimePHP']);
        $password = $_POST['passwordPHP'];
        $checkBox = $_POST['checkboxPHP'];

        $veza = new Baza();
        $veza->spojiDB();

        $upit = "SELECT * FROM `dz4_korisnik` WHERE ". "`kor_ime`='{$korisnickoime}'";
        $rezultat = $veza->selectDB($upit);

        
        if(mysqli_num_rows($rezultat) == 0){
            exit(json_encode("Nema korisnika"));
        }

        $korisnik = mysqli_fetch_array($rezultat);
        $veza->zatvoriDB();

        if($korisnik[5] == $korisnickoime){
            if($korisnik[13] == 1){
                exit(json_encode("Blokiran"));
            }
            if($korisnik[6] == $password && $korisnik[9] == "1"){
                $broj_pokusaja = 0;
                $veza = new Baza();
                $veza->spojiDB();
                $sql = "UPDATE dz4_korisnik SET `broj_pokusaja`='".$broj_pokusaja."' WHERE korisnik_id='".$korisnik[0]."'";
                $rezultat = $veza->updateDB($sql);
                $_SESSION['uloga_korisnika'] = $korisnik[12];
                if($checkBox == "on"){
                    setcookie("autentificiran", $korisnickoime, false, '/', false);
                }
                exit(json_encode("Uspješna prijava"));
                // exit("Uspješna prijava");
            }
            else if($korisnik[9] != "1"){
                exit(json_encode("Niste validarali Vaš email!"));
            }
            else{
                $veza = new Baza();
                $veza->spojiDB();
                $broj_pokusaja = $korisnik[14]+1;
                if($broj_pokusaja == 5 || $korisnik[13] == 1){
                    $sql = "UPDATE dz4_korisnik SET `blokiran`='1' WHERE kor_ime='".$korisnickoime."'";
                    $rezultat = $veza->updateDB($sql);
                    exit(json_encode("Blokiran"));
                }
                else {
                    $preostalo_pokusaja = 5-$broj_pokusaja;
                    $sql = "UPDATE dz4_korisnik SET `broj_pokusaja`='".$broj_pokusaja."' WHERE korisnik_id='".$korisnik[0]."'";
                    $rezultat = $veza->updateDB($sql);
                    $tip = $korisnik[9];
                    exit(json_encode("Lozinka nije ispravna. Pokušajte ponovo! Broj preostalih pokušaja je ".$preostalo_pokusaja));
                }
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
    <meta name='description' content="Ožujak 17, 2022">

    <script src="https://kit.fontawesome.com/76a4e1efc0.js" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="../css/prijava.css">
    <title>Prijava</title>
</head>

<body>

    <header class="header">
        <a href="../index.php" target="_blank"><img class="img-logo" src="../materijali/logo.svg" alt="logo"></a>
        <a href="#naslov">
            <h1 class="h1">PRIJAVA</h1>
        </a>
        <a href="#meni" class="a"><i class="fa-solid fa-bars"></i></a>
    </header>

    <div class="izbornik" id="naslov">
        <ul class="linkovi" id="meni">
            <li>
                <a href="../index.php" target="_blank">Početna</a>
            </li>
            <li>
                <a href="registracija.php" target="_blank">Registracija</a>
            </li>
        </ul>
    </div>

    <div class="forma">
        <h2>Prijavi se</h2>
        <i class="fa-solid fa-arrow-right-to-bracket"></i>
    </div>
    <div class="form2">
        <h3>Molimo Vas da unesete podatke</h3>
        <form action="prijava.php" method="POST" id="formPrijava" novalidate>
            <label id="korisnickoImeLabela" for="korisnickoime">Korisničko ime:</label>
            <input type="text" id="korisnickoime" name="korisnickoime" <?php if(isset($_COOKIE['autentificiran'])){echo "value='".$_COOKIE['autentificiran']."'";}  ?> maxlength="30">
            <br>
            <label id="passwordLabela" for="password">Lozinka:</label>
            <input type="password" id="password" name="password" maxlength="30">
            <br>
            <p>Želite li ostati prijavljeni?</p>
            <label class="switch" for="check">
                <input type="checkbox" id="check">
                <span class="slider round"></span>
            </label>
        </form>
        <button type="button" id="login" form="formPrijava" name="prijaviSe">Prijavi se</button>
        <p><a href="zaboravljenalozinka.php" target="_blank">Zaboravili ste lozinku?</a></p>
    </div>

    <footer>
        <img src="../materijali/HTML5.png" width="60" height="60" alt="html logo">
        <p>&copy; 2022 <a href="mailto:hasancolakovic32@gmail.com">Hasan Čolaković</a></p>
        <img src="../materijali/CSS3.png" width="60" height="60" alt="css logo">
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            $("#login").on("click", function(){
                var korisnickoime = $("#korisnickoime").val();
                var password = $("#password").val();

                var checkBox = "";
                if($("#check").prop('checked') == true){
                    checkBox = "on";
                }
                else {
                    checkBox = "off";
                }
            
                if(korisnickoime == "" || password == ""){
                    alert("Molimo Vas unesite korisničko ime i lozinku!");
                }
                else {
                    $.ajax({
                    method: "POST",
                    url: "prijava.php",
                    data: {
                        login: 1,
                        korisnickoimePHP: korisnickoime,
                        passwordPHP: password,
                        checkboxPHP: checkBox
                    },
                    dataType: "json",
                    success: function(response){
                        if(response == "Uspješna prijava"){
                            alert("Uspješno ste se logirali");
                            window.location.href = "../index.php";
                        }
                        else if(response == "Blokiran"){
                            alert("Blokirani ste!");
                        }
                        else if(response == "Nema korisnika"){
                            $("#korisnickoime").attr("style","border-color:red");
                            $("#password").attr("style","border-color:red");
                            $("#korisnickoImeLabela").attr("style","color:red");
                            $("#passwordLabela").attr("style","color:red");
                            alert("Taj korisnik ne postoji u bazi podataka!");
                        }
                        // else if(response == "Niste validirali Vaš email!"){
                        //     alert("Niste validirali Vaš email!");
                        // }
                        else{
                            $("#korisnickoime").attr("style","border-color:red");
                            $("#password").attr("style","border-color:red");
                            $("#korisnickoImeLabela").attr("style","color:red");
                            $("#passwordLabela").attr("style","color:red");
                            alert(response);
                        }
                    },
                });
                }
            })
        })

    </script>
</body>
</html>