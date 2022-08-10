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
    <title>Igre na sreću</title>
</head>

<body>

    <a href="../index.php" style="position: absolute; top:10%; margin-bottom:100px;">NAZAD NA POČETNU STRANICU</a>    

    <div>
        <h1>Popis svih igara na sreću</h1>
        <?php
            $veza = new Baza();
            $veza->spojiDB();
            $sql = "SELECT igra_na_srecu_id, naziv_igre, koliko_se_brojeva_izvlaci, fond_dobitka_po_pogodjenom_broju, lutrija_id FROM Igra_na_srecu";
            $rezultat = $veza->selectDB($sql);

            ?>
            <table id="tabela" border="1" cellspacing="0" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Naziv igre</th>
                <th>Koliko se brojeva izvlači</th>
                <th>Fond dobitka po pogođenom broju</th>
                <th>Lutrija</th>
                <th>Status</th>
            </tr>
            <?php
            if (mysqli_num_rows($rezultat) > 0) {
                while($row = mysqli_fetch_assoc($rezultat)) {

                    $lutrija_id = $row['lutrija_id'];

                    $upit = "SELECT * FROM `Lutrija` WHERE ". "`lutrija_id`='{$lutrija_id}'";
                    $rezultatUpita = $veza->selectDB($upit);
                    $lutrija = mysqli_fetch_array($rezultatUpita);
                ?>
                <tr>
                    <td><?php echo $row['igra_na_srecu_id']; ?> </td>
                    <td><?php echo $row['naziv_igre']; ?> </td>
                    <?php
                    if($row['koliko_se_brojeva_izvlaci'] == 0){
                    ?>
                        <td>Nije definirano koliko se izvlači brojeva</td>
                    <?php
                    }
                    else{
                    ?>
                        <td><?php echo $row['koliko_se_brojeva_izvlaci']; ?> </td>
                    <?php
                    }
                    ?>
                    <?php
                    if($row['fond_dobitka_po_pogodjenom_broju'] == 0){
                    ?>
                        <td>Nije definiran fond dobitka po pogođenom broju</td>
                    <?php
                    }
                    else{
                    ?>
                        <td><?php echo $row['fond_dobitka_po_pogodjenom_broju']; ?> </td>
                    <?php
                    }
                    ?>
                    <td><?php echo $lutrija[1]; ?> </td>


                    <?php
                    if($row['koliko_se_brojeva_izvlaci'] == 0){
                    ?>
                        <td>Ne možete igrati ovu igru</td>
                    <?php
                    }
                    else{
                    ?>
                        <td><a href="listic.php?id=<?php echo $row['igra_na_srecu_id']; ?>?lutrija_id=<?php echo $lutrija[0]?>">Igraj</td>  
                    <?php
                    }
                    ?>
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

</body>
</html>