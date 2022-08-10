<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Hasan Čolaković">
    <meta name='description' content="Ožujak 17, 2022">
    <script src="https://kit.fontawesome.com/76a4e1efc0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/novi.css">
    <title>Početna</title>
</head>

<body>


    <header class="header">
        <a href="index.php" target="_blank"><img class="img-logo" src="./materijali/logo.svg" alt="logo"></a>
        <a href="#naslov">
            <h1 class="h1">POČETNA</h1>
        </a>
        <a href="#meni" class="a"><i class="fa-solid fa-bars"></i></a>
    </header>

    <div class="izbornik" id="naslov">
        <ul class="linkovi" id="meni">

            <?php
                session_start();
                if(isset($_SESSION['uloga_korisnika'])){
                    if($_SESSION['uloga_korisnika'] == 4){
                        echo'
                            <li>
                                <a href="./administrator/lutrija.php" target="_blank">Lutrije</a>
                            </li>
                            <li>
                                <a href="./administrator/admin.php" target="_blank">Popis korisnika</a>
                            </li>
                            <li>
                                <a href="./administrator/igraNaSrecu.php" target="_blank">Igre na sreću</a>
                            </li>
                            <li>
                                <a href="o_autoru.html" target="_blank">O autoru</a>
                            </li>
                            <li>
                                <a href="dokumentacija.html" target="_blank">Dokumentacija</a>
                            </li>
                            <li>
                                <a href="./obrasci/logout.php" target="_blank">Odjava</a>
                            </li>
                        ';
                    }
                    else if($_SESSION['uloga_korisnika'] == 2){
                        echo'
                            <li>
                                <a href="./registrirani_korisnik/index.php" target="_blank">Igre na sreću</a>
                            </li>
                            <li>
                                <a href="o_autoru.html" target="_blank">O autoru</a>
                            </li>
                            <li>
                                <a href="dokumentacija.html" target="_blank">Dokumentacija</a>
                            </li>
                            <li>
                                <a href="./obrasci/logout.php" target="_blank">Odjava</a>
                            </li>
                        ';
                    }
                    else if($_SESSION['uloga_korisnika'] == 1){
                        echo'
                        <li>
                            <a href="./obrasci/registracija.php" target="_blank">Registracija</a>
                        </li>
                        <li>
                            <a href="./obrasci/prijava.php" target="_blank">Prijava</a>
                        </li>
                        <li>
                            <a href="o_autoru.html" target="_blank">O autoru</a>
                        </li>
                        <li>
                            <a href="dokumentacija.html" target="_blank">Dokumentacija</a>
                        </li>
                        <li>
                            <a href="./obrasci/logout.php" target="_blank">Odjava</a>
                        </li>
                        ';
                    }
                }
                else{
                    echo'
                    <li>
                        <a href="./obrasci/registracija.php" target="_blank">Registracija</a>
                    </li>
                    <li>
                        <a href="./obrasci/prijava.php" target="_blank">Prijava</a>
                    </li>
                    <li>
                        <a href="o_autoru.html" target="_blank">O autoru</a>
                    </li>
                    <li>
                        <a href="dokumentacija.html" target="_blank">Dokumentacija</a>
                    </li>
                    <li>
                        <a href="./obrasci/logout.php" target="_blank">Odjava</a>
                    </li>
                ';
                }
            ?>
        </ul>
    </div>
    <main>

        <figure class="animacija">

        </figure>


        <div class=" row">
            <div class="column left">
                <h3><a href="https://www.marca.com/en/football/real-madrid/2022/03/26/623ee928e2704ea8678b4596.html"
                        target="_blank">"I'd bet everything that Florentino Perez has signed Mbappe and Haaland"</a>
                </h3>
                <i>26.03.2022 - 17:34</i>
                <p>Florentino Perez and Real Madrid's story started back in 2000, when he won the presidency thanks to
                    the signing of Luis Figo from Barcelona.</p>
                <a href="https://www.marca.com/en/football/real-madrid/2022/03/26/623ee928e2704ea8678b4596.html"
                    target="_blank">Saznaj
                    više...</a>
            </div>
            <div class="column middle">
                <h3><a href="https://www.marca.com/en/football/barcelona/2022/03/25/623e1f15ca4741952e8b4629.html"
                        target="_blank">Barcelona consider Salah and Lewandowski as Haaland alternatives</a></h3>
                <i>25.03.2022 - 15:40</i>
                <p>Barcelona have big dreams for the summer transfer window despite the financial limitations that the
                    club are facing, and are continuing to work on a way to sign Erling Haaland. That failing, they want
                    either Mohamed Salah or Robert Lewandowski.</p>
                <a href="https://www.marca.com/en/football/barcelona/2022/03/25/623e1f15ca4741952e8b4629.html"
                    target="_blank">Saznaj
                    više...</a>
            </div>
            <div class="column right">
                <h3><a href="https://www.marca.com/en/football/real-madrid/2022/03/25/623dff78268e3e6e778b45e5.html"
                        target="_blank">Hazard will undergo further fibula surgery</a></h3>
                <i>25.03.2022 - 14:18</i>
                <p> Real Madrid and Eden Hazard is a partnership which simply can't catch a break, and the Belgian will
                    be absent for another month due to further fibula surgery.</p>
                <a href="https://www.marca.com/en/football/real-madrid/2022/03/25/623dff78268e3e6e778b45e5.html"
                    target="_blank">Saznaj
                    više...</a>
            </div>
        </div>
    </main>

    <footer>
        <img src="./materijali/HTML5.png" width="60" height="60" alt="html logo">
        <p>&copy; 2022 <a href="mailto:hasancolakovic32@gmail.com">Hasan Čolaković</a></p>
        <img src="./materijali/CSS3.png" width="60" height="60" alt="css logo">
    </footer>


</body>

</html>