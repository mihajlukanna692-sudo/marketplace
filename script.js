
document.getElementById("produktForm").addEventListener("submit", function(e) {
    let error = "";

    const nazwa = document.querySelector("[name='nazwa']").value.trim();
    const opis = document.querySelector("[name='opis']").value.trim();
    const cena = document.querySelector("[name='cena']").value.trim();


    if (nazwa.length < 3) {
        error += "Nazwa musi mieć co najmniej 3 znaki.<br>";
    }

    if (cena === "" || isNaN(cena)) {
        error += "Cena musi być liczbą.<br>";
    } else if (parseFloat(cena) <= 0) {
        error += "Cena musi być większa od 0.<br>";
    }

    if (opis.length > 0 && opis.length < 10) {
        error += "Opis (jeśli podany) musi mieć min. 10 znaków.<br>";
    }

    if (error !== "") {
        e.preventDefault(); 
        document.getElementById("error").innerHTML = error;
    }
});
