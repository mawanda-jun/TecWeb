const mq = window.matchMedia('handheld, screen and (max-width: 680px), only screen and (max-device-width:600px)');
var menuIsOpen = false;
var menuIsFixed = false;
var menuvoice;
var menudiv;
var header;
var menu;

window.onscroll = changeHeader;

window.onload = function () {
    //immagini zoommabili
    [].forEach.call(document.getElementById("contenuto").getElementsByTagName("img"), makezoomable);

    //menu per i dispositivi mobili, sostituisce il css hover se possibile
    menuvoice = document.getElementById('menuvoice');
    //per il menu fixed
    menudiv = document.getElementById("menudiv");
    header = document.getElementById("header");
    menu = document.getElementById("menu");

    mq.addListener(ChangeResolutionCheck);

    function ChangeResolutionCheck() {
        if (mq.matches) //solo su mobile
        {
            if (menuIsFixed)
                unFixMenu();
            //blocco il hover
            var siblingstart = menuvoice.nextElementSibling;
            while (siblingstart != null) {
                siblingstart.style.display = 'none';
                siblingstart = siblingstart.nextElementSibling;
            }
            //setto attraverso il click
            menuvoice.onclick = function () {
                var sibling = this.nextElementSibling;
                if (menuIsOpen) {
                    while (sibling != null) {
                        sibling.style.display = 'none';
                        sibling = sibling.nextElementSibling;
                    }
                    menuIsOpen = false;
                }
                else {
                    while (sibling != null) {
                        sibling.style.display = 'block';
                        sibling = sibling.nextElementSibling;
                    }
                    menuIsOpen = true;
                }
            }
        }
        else //su pc - se c'è necessità rimuovo lo stile precedentemente settato
        {
            //sblocco il hover
            var siblingstart = menuvoice.nextElementSibling;
            while (siblingstart != null) {
                siblingstart.style.display = 'block';
                siblingstart = siblingstart.nextElementSibling;
            }
            menuopen = true;
            changeHeader();
        }
    }

    ChangeResolutionCheck();
}

function makezoomable(image) {
    image.classList.add('zoomable');
    image.classList.remove('zoomableout');
    image.addEventListener("click", function () {
        zoom(image);
    });
}

function zoom(image) {
    image.style.width = "95%";
    image.style.float = "none";
    image.classList.remove('zoomable');
    image.classList.add('zoomableout');
    image.removeEventListener("click", function () {
        zoom(image);
    });
    image.addEventListener("click", function () {
        zoomout(image);
    });
}

function zoomout(image) {
    if (image.style.removeProperty) {
        image.style.removeProperty('width');
        image.style.removeProperty('float');
    }
    else {
        //IE < 9
        image.style.removeAttribute('width');
        image.style.removeAttribute('float');
    }
    image.classList.add('zoomable');
    image.classList.remove('zoomableout');
    image.addEventListener("click", function () {
        zoom(image);
    });
    image.removeEventListener("click", function () {
        zoomout(image);
    });
}

//validazione form
function validateForm() {
    var nome = document.forms["leavecommentform"]["nameinput"].value;
    var commento = document.forms["leavecommentform"]["commentoinput"].value;
    var validata = validateString("nome", nome) & validateString("commento", commento) & validateEmail();
    if (validata == 0) {
        document.getElementById("erroreinvio").innerHTML = "*impossibile inviare";
        return false;
    }
    else
        return true;
}

function validateFormAddNews() {
    var titolo = document.forms["addnewsform"]["titleform"].value;
    var imgCopertina = document.forms["addnewsform"]["imageform"].value;
    var imgUploadCopertina = document.getElementById("fileupload").files.length;
    var descrizione = document.forms["addnewsform"]["imgdescrform"].value;
    var testo = document.forms["addnewsform"]["textform"].value;
    var validate = validateString("titolo", titolo) & validateStringImage(imgCopertina, imgUploadCopertina) & validateString("descrizione", descrizione) & validateString("testo", testo);
    if (validate == false) {
        document.getElementById("erroreAdd").innerHTML = "*impossibile inviare";
        return false;
    }
    else
        return true;
}


function validateFormInsertAdmin() {
    var nome = document.forms["addadmin"]["usernameinput"].value;
    var email = document.forms["addadmin"]["emailinput"].value;
    var password = document.forms["addadmin"]["passwordinput"].value;
    var validate = validateString("nome", nome) & validateEmailAdmin("email", email) & validateString("password", password);
    if (validate == false) {
        document.getElementById("erroreNewAdmin").innerHTML = "*impossibile inviare";
        return false;
    }
    else
        return true;
}

function validateFormModifyAdmin() {
    var email = document.forms["editaccountinfo"]["newemailinput"].value;
    if (validateEmailAdmin("nuova_email", email)===false) {
        document.getElementById("erroreMod").innerHTML = "*impossibile inviare";
        return false;
    }
    else
        return true;
}


function validateFormAddChapter() {
    var title = document.forms["addchapterform"]["title"].value;
    var titleeng = document.forms["addchapterform"]["titleeng"].value;
    var titleita = document.forms["addchapterform"]["titleita"].value;
    var imagedescr = document.forms["addchapterform"]["imagedescr"].value;
    var number = document.forms["addchapterform"]["number"].value;
    var year = document.forms["addchapterform"]["year"].value;
    var plot = document.forms["addchapterform"]["plot"].value;
    var validate = validateString("titolo", title) & validateString("titolo_inglese", titleeng) & validateString("titolo_italiano", titleita) & validateString("image_descr", imagedescr) &
        validateString("numero", number) & validateYear("anno", year) & validateString("testo", plot);
    if (validate == false) {
        document.getElementById("erroreNewChapter").innerHTML = "*impossibile inviare";
        return false;
    }
    else
        return true;
}


function validateString(tipo, stringa) {
    var errore = "errore".concat(tipo);
    var messageTitle = tipo;
    if((tipo === "titolo") || (tipo === "titolo_italiano") || (tipo === "titolo_inglese")) {
        messageTitle = "titolo";
    }
    if((tipo == "image_descr")) {
        messageTitle = "immagine valida"
    }
    document.getElementById(errore).innerHTML = '';
    if ((stringa == "") && (messageTitle == "immagine valida")) {
        document.getElementById(errore).innerHTML = "*inserire una " + messageTitle;
        return false;
    }
    else if ((stringa == "")) {
        document.getElementById(errore).innerHTML = "*inserire un " + messageTitle;
        return false;
    }
    else
        return true;
}

function validateStringc(tipo1, tipo2, stringa) {
    var errore = "errore".concat(tipo1, tipo2);
    document.getElementById(errore).innerHTML = '';
    if (stringa == "") {
        document.getElementById(errore).innerHTML = "*inserire un ".concat(tipo1, " per l' ", tipo2);
        return false;
    }
    else
        return true;
}


function validateYear(tipo, year) {
    var errore = "errore".concat(tipo);
    var regExpYear = /^(197\d|2\d\d\d)$/;
    document.getElementById(errore).innerHTML = '';
    if (year.match(regExpYear)) {
        return true;
    }
    else {
        document.getElementById(errore).innerHTML = "*inserire un anno maggiore del 1970";
        return false;
    }
}

function validateStringImage(stringa, upload) {
    document.getElementById("erroretitoloimmagine").innerHTML = '';
    if (upload == 0 && stringa == "") {
        document.getElementById("erroretitoloimmagine").innerHTML = "*inserire il nome di una immagine o caricarne una nuova";
        return false;
    }
    else
        return true;
}


function validateEmailAdmin(tipo, email) {
    var errore = "errore".concat(tipo);
    document.getElementById(errore).innerHTML = '';
    var regExpMail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    if (email.match(regExpMail))
        return true;
    else {
        document.getElementById(errore).innerHTML = "*inserire un' e-mail valida";
        return false;
    }
}

function validateEmail() {
    var email = document.forms["leavecommentform"]["emailinput"].value;
    document.getElementById("erroreemail").innerHTML = '';
    var regExpMail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    if (email.match(regExpMail))
        return true;
    else {
        document.getElementById("erroreemail").innerHTML = '*inserire un <span xml:lang="en">e-mail</span> valida';
        return false;
    }
}

function changeHeader() {
    if (!mq.matches)
        if (window.pageYOffset > 2 + header.clientHeight - menu.clientHeight) //mi serve davvero impostarlo
        {
            if (!menuIsFixed) //e non e' ancora impostato -> imposto
                fixMenu();
        }
        else //se invece non mi serve impostarlo
        if (menuIsFixed) //ma e' impostato -> lo rimuovo
            unFixMenu();
}

function fixMenu() {
    header.style.borderWidth = "0";
    menudiv.style.position = "fixed";
    menudiv.style.top = "0";
    menudiv.style.bottom = "auto";
    menudiv.style.width = header.clientWidth + "px";
    menu.style.top = "0";
    menu.style.bottom = "auto";
    menuIsFixed = true;
}

function unFixMenu() {
    header.style.borderWidth = "1pt";
    menudiv.style.position = "initial";
    menudiv.style.top = "auto";
    menudiv.style.bottom = "0";
    menudiv.style.width = "100%";
    menu.style.top = "auto";
    menu.style.bottom = "0";
    menuIsFixed = false;
}
