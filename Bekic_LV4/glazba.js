let svePjesme = []; 
let playlista = [];
let trenutnoPrikazanePjesme = [];
/*
Fetch učitava CSV datoteku. 
PapaParse zatim pretvara CSV u niz objekata, 
a map priprema podatke da ih lakše koristiš u tablici.
*/
fetch("glazba.csv")
    .then(response => response.text())
    .then(csv => {
        const rezultat = Papa.parse(csv, {
            header: true,
            skipEmptyLines: true
        });

        svePjesme = rezultat.data.map(pjesma => ({
            id: pjesma.ID,
            naslov: pjesma.Naslov,
            izvodac: pjesma.Izvođač,
            zanr: pjesma.Žanr,
            bpm: Number(pjesma.BPM),
            godina: Number(pjesma.Godina),
            popularnost: Number(pjesma.Popularnost),
            raspolozenje: pjesma.Raspoloženje
        }));

        trenutnoPrikazanePjesme = svePjesme;
        prikaziTablicu(trenutnoPrikazanePjesme);
    })
    .catch(error => {
        console.error("Greška pri učitavanju CSV datoteke:", error);
    });

function prikaziTablicu(pjesme) {
    const tbody = document.querySelector("#tablica-glazba tbody");
    tbody.innerHTML = "";

    if (pjesme.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6">Nema pjesama za odabrane filtere.</td>
            </tr>
        `;
        return;
    }

    pjesme.forEach(pjesma => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${pjesma.izvodac}</td>
            <td>${pjesma.naslov}</td>
            <td>${pjesma.zanr}</td>
            <td>${pjesma.godina}</td>
            <td>${pjesma.bpm}</td>
            <td>
                ${
                    playlista.some(p => p.id === pjesma.id)
                    ? "<span class='btn-added'>Dodano</span>"
                    : `<button class="btn-playlist" onclick="dodajUPlaylistu('${pjesma.id}')">
                            Dodaj
                    </button>`
                }
            </td>
        `;

        tbody.appendChild(row);
    });
}

function dohvatiZanrove() {
    const checkboxovi = document.querySelectorAll('#filter-genre input[type="checkbox"]:checked');
    return Array.from(checkboxovi).map(cb => cb.value);
}

const bpmInput = document.getElementById("filter-bpm");
const bpmValue = document.getElementById("bpm-value");

bpmInput.addEventListener("input", () => {
    bpmValue.textContent = bpmInput.value;
});

document.getElementById("filtriraj").addEventListener("click", filtrirajPjesme);

function filtrirajPjesme() {
    const odabraniZanrovi = dohvatiZanrove();
    const godinaOd = Number(document.getElementById("filter-year").value);
    const minimalniBpm = Number(document.getElementById("filter-bpm").value);

    const filtriranePjesme = svePjesme.filter(pjesma => {

        // ŽANR (više odabira)
        const zanrOdgovara =
            odabraniZanrovi.length === 0 ||
            odabraniZanrovi.some(z => pjesma.zanr.includes(z));

        // GODINA
        const godinaOdgovara =
            !godinaOd || pjesma.godina >= godinaOd;

        // BPM
        const bpmOdgovara =
            pjesma.bpm >= minimalniBpm;

        return zanrOdgovara && godinaOdgovara && bpmOdgovara;
    });

    trenutnoPrikazanePjesme = filtriranePjesme;
    prikaziTablicu(trenutnoPrikazanePjesme);
}

function dodajUPlaylistu(id) {
    const pjesma = svePjesme.find(p => p.id === id);

    if (!pjesma) return;

    if (playlista.some(p => p.id === id)) {
        return;
    }

    playlista.push(pjesma);
    prikaziPlaylistu();

    prikaziTablicu(trenutnoPrikazanePjesme);
}

function prikaziPlaylistu() {
    const lista = document.getElementById("lista-playlist");
    lista.innerHTML = "";

    if (playlista.length === 0) {
        lista.innerHTML = "<li>Playlista je trenutno prazna.</li>";
        return;
    }

    playlista.forEach((pjesma, index) => {
        const li = document.createElement("li");

        li.innerHTML = `
            <span>${pjesma.izvodac} - ${pjesma.naslov}</span>
            <button onclick="ukloniIzPlayliste(${index})">Ukloni</button>
        `;

        lista.appendChild(li);
    });
}

function ukloniIzPlayliste(index) {
    playlista.splice(index, 1);
    prikaziPlaylistu();

    prikaziTablicu(trenutnoPrikazanePjesme);
}

document.getElementById("otvori-playlistu").addEventListener("click", () => {
    prikaziPlaylistu();
    document.getElementById("playlist-modal").style.display = "flex";
});

document.getElementById("zatvori-modal").addEventListener("click", () => {
    document.getElementById("playlist-modal").style.display = "none";
});

window.addEventListener("click", (event) => {
    const modal = document.getElementById("playlist-modal");

    if (event.target === modal) {
        modal.style.display = "none";
    }
});

document.getElementById("potvrdi").addEventListener("click", () => {
    const poruka = document.getElementById("poruka-playliste");

    if (playlista.length === 0) {
        poruka.textContent = "Playlista je prazna.";
        return;
    }

    poruka.textContent = `Playlista uspješno spremljena! Broj pjesama: ${playlista.length}`;

    playlista = [];
    prikaziPlaylistu();
});