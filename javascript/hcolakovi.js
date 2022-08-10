// JAVASCRIPT TIMER
let vrijeme = setInterval(timer, 1000);
let ukupnoSekundi = 0;

function timer() {
    ++ukupnoSekundi;
    let minute = Math.floor((ukupnoSekundi) / 60);
    let sekunde = ukupnoSekundi - (minute * 60);
    if (minute === 10 && sekunde === 0) {
        minute = 0;
        sekunde = 0;
        ukupnoSekundi = 0;
        document.getElementById('forma').reset();
    }
    document.querySelector("#timer").innerHTML = "Prošlo je: " + minute + "min" + " : " + sekunde + "sek";
}

// RESETIRANJE FORME
window.addEventListener('load', function () {
    document.getElementById('forma').reset();
})


// NAČIN PRIKAZA FORME
document.querySelector('#vodoravno').addEventListener('click', function () {
    document.querySelector('form').classList.remove('dodanaForma');
})

document.querySelector('#okomito').addEventListener('click', function () {
    document.querySelector('form').classList.add('dodanaForma');
})


// VALIDIRANJE ISPRAVNOSTI I VELIČINE FAJLOVA
function provjeraFajla(fajl) {
    let slika = document.getElementById("naziv");
    fajl.setAttribute('accept', '.png, .jpg, .pdf, .mp3');
    if (typeof (slika.files) != 'undefined') {
        let velicina = parseFloat(slika.files[0].size / (1000 * 1024).toFixed(2));

        if (velicina > 1) {
            alert('Slika je veća od 1MB');
        }
        else {
            console.log('Uspjesno ste uploadali sliku');
        }
    }
}


// VALIDIRANJE DATUMA
function provjeraDatuma() {
    let datumUnosa = document.getElementById("datum").value;
    let rgexp = /^([0-2][0-9])\.([0-1][1-9])\.([0-9][0-9][0-9][0-9])\.\s([0-2][0-9]:[0-5][0-9]:[0-5][0-9])$/;
    let validan = rgexp.test(datumUnosa);
    console.log(validan);

    if (rgexp.test(datumUnosa) == true) {
        document.querySelector(".labelaDatum").style.color = "black";
        document.querySelector(".labelaDatum").innerHTML = 'Datum kreiranja:';
        alert('Uspješno ste dodali datum!');
        return false;
    }
    else {
        alert('Nije dobro unešen datum! Datum mora biti formata dd.mm.yyyy ss:mm:hh');
        return true;
    }
}

// VALIDACIJA PRETRAŽIVANJA
function provjeraPretrazivanja() {
    let unos = document.querySelector('#mojUnos').value;

    if (unos === 'Štoper' || unos === 'Vezni' || unos === 'Krilni napadač' || unos === 'Napadač') {
        document.querySelector(".labelaPozicija").style.color = "black";
        document.querySelector(".labelaPozicija").innerHTML = 'Pozicija:';
        return false;
    }
    else if (unos !== 'Štoper' || unos !== 'Vezni' || unos !== 'Krilni napadač' || unos !== 'Napadač') {
        console.log('Nije dobro pretraženo!');
        return true;
    }
}


// VALIDACIJA REČENICE (RAČUNANJE GREŠAKA)
function provjeraOpisa() {
    const brojZnakova = document.querySelector('#opis').value.length;
    const znakovi = document.querySelector('#opis').value;

    let znakManje = 0;
    let znakVece = 0;
    let znakNavodnici = 0;
    let dvijeTacke = 0;

    if (brojZnakova === 0) {
        console.log('Ima 0 znakova!');
        return 0;
    }
    else if (brojZnakova > 100) {
        console.log('Ima preko 100 znakova');
        return 1;
    }
    else if (brojZnakova < 100) {
        for (let i = 0; i < znakovi.length; i++) {
            if (znakovi.charAt(i) === "<") {
                znakManje++;
            }
            else if (znakovi.charAt(i) === ">") {
                znakVece++;
            }
            else if (znakovi.charAt(i) === '"' || znakovi.charAt(i) === "'") {
                znakNavodnici++;
            }
            else if (znakovi.charAt(i) === "." && znakovi.charAt(i + 1) === ".") {
                dvijeTacke++;
            }
        }
        if (znakManje === 0 && znakVece === 0 && znakNavodnici === 0 && dvijeTacke === 0) {
            document.querySelector(".labelaOpis").style.color = "black";
            document.querySelector(".labelaOpis").innerHTML = 'Opis';
            return false;
        }
        else {
            alert('Ukupan broj grešaka iznosi: ' + Number(znakManje + znakVece + znakNavodnici + dvijeTacke) + "\n" + "---------------------------------" + "\n" + "Znakova manje ima: " + znakManje + "\n" + "Znakova veće ima: " + znakVece + "\n" + "Navodnika ima: " + znakNavodnici + "\n" + "Dvije tačke jedna do druge: " + dvijeTacke);
            return true;
        }
    }
}



// VALIDACIJA UNEŠENOG BROJA MOBITELA
function provjeraMobitela() {
    let brojMobitela = [];
    brojMobitela = document.querySelector('#br_mobitela').value;

    if ((brojMobitela.length === 16) && (brojMobitela[0] === '+') && (brojMobitela[1] >= 0 && brojMobitela[1] <= 9) && (brojMobitela[2] >= 0 && brojMobitela[2] <= 9) && (brojMobitela[3] >= 0 && brojMobitela[3] <= 9) && (brojMobitela[4] === ' ' && (brojMobitela[5] >= 0 && brojMobitela[5] <= 9)) && (brojMobitela[6] >= 0 && brojMobitela[6] <= 9) && (brojMobitela[7] === ' ') && (brojMobitela[8] >= 0 && brojMobitela[8] <= 9) && (brojMobitela[9] >= 0 && brojMobitela[9] <= 9) && (brojMobitela[10] >= 0 && brojMobitela[10] <= 9) && (brojMobitela[11] === ' ') && (brojMobitela[12] >= 0 && brojMobitela[12] <= 9) && (brojMobitela[13] >= 0 && brojMobitela[13] <= 9) && (brojMobitela[14] >= 0 && brojMobitela[14] <= 9) && (brojMobitela[15] >= 0 && brojMobitela[15] <= 9)) {
        document.querySelector(".labelaMobitel").style.color = "black";
        document.querySelector(".labelaMobitel").innerHTML = 'Broj mobitela:';
        return false;
    }
    else {
        console.log('Nije dobar broj mobitela!');
        return true;
    }
}


// ZAVRŠNA VALIDACIJA FORME
const file = document.querySelector('#naziv').value;
const forma = document.getElementById('forma');
const button = document.getElementById('registriraj');
forma.addEventListener('submit', (e) => {
    let poruke = [];
    var file = document.forms["forma"]["naziv"].value;

    if (file === '') {
        poruke.push('Niste odabrali fajl');
        document.querySelector('.labelaNaziv').style.color = 'red';
        document.querySelector('.labelaNaziv').innerHTML = '*Naziv';
    }
    else {
        document.querySelector('.labelaNaziv').style.color = 'black';
        document.querySelector('.labelaNaziv').innerHTML = 'Naziv';
    }

    // DATUM
    if (provjeraDatuma() === true) {
        poruke.push('Niste unijeli dobar datum');
        document.querySelector('.labelaDatum').style.color = 'red';
        document.querySelector('.labelaDatum').innerHTML = '*Datum kreiranja:';
    }

    // PRETRAŽIVANJE
    if (provjeraPretrazivanja() === true) {
        poruke.push('Morate pretražiti poziciju');
        document.querySelector('.labelaPozicija').style.color = 'red';
        document.querySelector('.labelaPozicija').innerHTML = '*Pozicija:';
    }

    // OPIS
    if (provjeraOpisa() === true || provjeraOpisa() === 0) {
        poruke.push('Vaša rečenica ima grešaka ili niste unijeli nijedan znak');
        document.querySelector(".labelaOpis").style.color = "red";
        document.querySelector(".labelaOpis").innerHTML = '*Opis';
    }

    // MOBITEL
    if (provjeraMobitela() === true) {
        poruke.push('Niste dobro unijeli broj mobitela');
        document.querySelector('.labelaMobitel').style.color = 'red';
        document.querySelector('.labelaMobitel').innerHTML = '*Broj mobitela:';
    }


    if (poruke.length > 0) {
        e.preventDefault();
        alert(poruke);
    }
})