<?php
    $putanja = dirname($_SERVER['REQUEST_URI'],2);
    $direktorij = dirname(getcwd());
    include_once '../zaglavlje.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Hasan Čolaković">
    <meta name='description' content="Lipanj 13, 2022">
    <link rel="stylesheet" href="../css/lutrija.css">
    <title>Lutrije</title>
</head>

<body>

    <a href="../index.php" style="position: absolute; top:1.5%; margin-bottom:100px;">NAZAD NA POČETNU STRANICU</a>    
    <a href="igraNaSrecu.php" target="_blank" style="position: absolute; top:1.5%; left: 25%;">POPIS IGARA NA SREĆU</a>
    <a href="admin.php" target="_blank" style="position: absolute; top:1.5%; right:25%;">POPIS KORISNIKA</a>

    <div>
        <h1>Popis svih lutrija</h1>
        <?php
            $veza = new Baza();
            $veza->spojiDB();
            $sql = "SELECT lutrija_id, naziv_lutrije, lokacija, datum_osnivanja, broj_ispostava, online_kladjenje, zemlja_porijekla, moderator FROM Lutrija";
            $rezultat = $veza->selectDB($sql);

            ?>
            <table id="tabela" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Naziv lutrije</th>
                <th>Lokacija</th>
                <th>Datum osnivanja</th>
                <th>Broj ispostava</th>
                <th>Online klađenje</th>
                <th>Zemlja porijekla</th>
                <th>Moderator</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($rezultat) > 0) {
                while($row = mysqli_fetch_assoc($rezultat)) {
                    $moderator = $row['moderator'];

                    $upit = "SELECT * FROM `dz4_korisnik` WHERE ". "`korisnik_id`='{$moderator}'";
                    $rezultatUpita = $veza->selectDB($upit);
                    $korisnik = mysqli_fetch_array($rezultatUpita);
                ?>
                <tr>
                    <td><?php echo $row['lutrija_id']; ?> </td>
                    <td><?php echo $row['naziv_lutrije']; ?> </td>
                    <td><?php echo $row['lokacija']; ?> </td>
                    <td><?php echo $row['datum_osnivanja']; ?> </td>
                    <td><?php echo $row['broj_ispostava']; ?> </td>
                    <td><?php echo $row['online_kladjenje']; ?> </td>
                    <td><?php echo $row['zemlja_porijekla']; ?> </td>
                    <?php
                        if($moderator != 0){
                    ?>
                            <td><?php echo "{$korisnik[1]} {$korisnik[2]}"?></td>
                    <?php
                        }
                        else{
                    ?>
                            <td><a href="dodjelaModeratoraLutriji.php?id=<?php echo $row['lutrija_id']; ?>">Dodijeli moderatora</td>
                    <?php
                        }
                    ?>
                    <td><a href="azuriranjeLutrije.php?id=<?php echo $row['lutrija_id']; ?>">Ažuriraj</td>
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
    <button id="dodaj">Dodaj lutriju</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function(){

            $('#dodaj').click(function(){
                window.location.href = "dodavanjeLutrije.php";
            })

        })            
    </script>

</body>
</html>