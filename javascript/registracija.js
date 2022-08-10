// 5 PROVJERA NA STRANI KLIJENTA

// PROVJERA BROJA ZNAKOVA KOD IMENA I PREZIMENA
function provjeraBrojaZnakova() {
    let ime = document.getElementById('ime').value;
    let prezime = document.getElementById('prezime').value;

    if (ime.length >= 3 || prezime.length >= 3) {
        document.querySelector(".labelaIme").style.color = "black";
        document.querySelector(".labelaIme").innerHTML = 'Ime:';
        document.querySelector(".labelaPrezime").style.color = "black";
        document.querySelector(".labelaPrezime").innerHTML = 'Prezime:';
        return false;
    }
    else {
        return true;
    }
}

// PROVJERA DATUMA ROĐENJA
function provjeraDatuma() {
    let datumUnosa = document.getElementById("datum").value;
    let rgexp = /^([0-2][0-9])\.([0-1][1-9])\.([0-9][0-9][0-9][0-9])\.$/;

    if (rgexp.test(datumUnosa) == true) {
        document.querySelector(".labelaDatum").style.color = "black";
        document.querySelector(".labelaDatum").innerHTML = 'Datum rođenja:';
        return false;
    }
    else {
        return true;
    }
}

//PROVJERA EMAILA
function provjeraEmaila() {
    let uneseniEmail = document.getElementById('email').value;
    let rgexp = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (rgexp.test(uneseniEmail) == true) {
        document.querySelector(".labelaEmail").style.color = "black";
        document.querySelector(".labelaEmail").innerHTML = 'Email:';
        return false;
    }
    else {
        return true;
    }
}

// PROVJERA DA LI SE LOZINKE POKLAPAJU
function provjeraLozinka() {
    let password = document.getElementById('password').value;
    let repeatpassword = document.getElementById('repeatpassword').value;

    if (password == repeatpassword) {
        document.querySelector(".lozinkaLabela").style.color = "black";
        document.querySelector(".lozinkaLabela").innerHTML = 'Lozinka:';
        document.querySelector(".ponovljenaLozinkaLabela").style.color = "black";
        document.querySelector(".ponovljenaLozinkaLabela").innerHTML = 'Potvrdite lozinku:';
        return false;
    }
    else {
        return true;
    }
}


document.getElementById('registriraj').addEventListener('click', function (e) {
    let poruke = [];

    if (provjeraBrojaZnakova() === true) {
        poruke.push("Ime i prezime moraju biti minimalno dužine 3 znaka")
        document.querySelector(".labelaIme").style.color = "red";
        document.querySelector(".labelaIme").innerHTML = '*Ime:';
        document.querySelector(".labelaPrezime").style.color = "red";
        document.querySelector(".labelaPrezime").innerHTML = '*Prezime:';
    }

    if (provjeraDatuma() === true) {
        poruke.push(' Nije dobro unešen datum. Datum mora biti formata dd.mm.yyyy.');
        document.querySelector('.labelaDatum').style.color = 'red';
        document.querySelector('.labelaDatum').innerHTML = '*Datum rođenja:';
    }

    if (provjeraEmaila() === true) {
        poruke.push(' Neispravan mail');
        document.querySelector('.labelaEmail').style.color = 'red';
        document.querySelector('.labelaEmail').innerHTML = '*Email:';
    }

    if (provjeraLozinka() === true) {
        poruke.push(' Lozinke se ne poklapaju')
        document.querySelector(".lozinkaLabela").style.color = "red";
        document.querySelector(".lozinkaLabela").innerHTML = '*Lozinka:';
        document.querySelector(".ponovljenaLozinkaLabela").style.color = "red";
        document.querySelector(".ponovljenaLozinkaLabela").innerHTML = '*Potvrdite lozinku:';
    }

    if (poruke.length > 0) {
        e.preventDefault();
        alert(poruke);
    }
})