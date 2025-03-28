# Cowork Reservations

Cowork Reservations je PHP aplikacija za upravljanje rezervacijama coworking prostora. Ovaj projekat omogućava korisnicima da pregledaju dostupne prostore, vide njihove detalje, sortiraju prostore po različitim kriterijumima (cena, kapacitet) te kreiraju i upravljaju rezervacijama. Projekat koristi PHP sesije i cookie-je (putem `PHPSESSID`) za održavanje sesija, a svi korisnički podaci obrađuju se sigurno pomoću sanitizacije (npr. `htmlspecialchars()`) kako bi se zaštitili od XSS napada. Projekt je organizovan u klase radi modularnosti i lakšeg održavanja, a sadrži i funkcionalnost za upload fajlova.

## Sadržaj projekta

- **PHP stranice:**
  - `index.php` – Početna stranica sa informacijama i navigacijom.
  - `login.php` – Forma za prijavu korisnika.
  - `register.php` – Forma za registraciju korisnika, uključujući upload profilne slike.
  - `prostorije.php` – Stranica koja prikazuje listu dostupnih coworking prostora s mogućnošću sortiranja preko dropdown menija (sortiranje po ceni i kapacitetu, rastuće i opadajuće).
  - `detalji.php` – Stranica koja prikazuje detaljne informacije o odabranom prostoru (slika, adresa, kapacitet, cena) te formu za rezervaciju termina.
  - `rezervacije.php` – Stranica na kojoj korisnici mogu videti sve svoje rezervacije, s prikazom slike, naziva, adrese, datuma i vremena te opcijom brisanja rezervacije (s PHP potvrdom).
  - `logout.php` – Skripta za odjavu korisnika (uništava sesiju i preusmerava na početnu stranicu).
  - `obrisi_rezervaciju.php` – Skripta za brisanje rezervacije nakon potvrde (koja se vrši na posebnoj PHP stranici bez JavaScript-a).
  - `confirm_delete.php` – Stranica koja prikazuje potvrdu brisanja rezervacije s opcijama "Da, izbriši" i "Ne, odustani".

- **Klase (u folderu `classes`):**
  - `Database.php` – Klasa za konekciju sa MySQL bazom.
  - `Korisnik.php` – Klasa koja modelira korisnike i sadrži metode za registraciju i prijavu.
  - `Prostor.php` – Klasa koja modelira coworking prostore te omogućava dohvat svih dostupnih prostora s opcijama sortiranja.
  - `Rezervacija.php` – Klasa koja upravlja rezervacijama, uključujući kreiranje rezervacija (s provjerom da se ne rezerviše termin za prošli dan, ili za termin koji je već zauzet, te onemogućava rezervaciju termina u prošlosti) i dohvat korisničkih rezervacija (preko JOIN-a s tabelom `prostor`).

- **Baza podataka (MySQL):**
  - Tabela `korisnik` – Čuva podatke o korisnicima (ime, prezime, mejl, šifra, eventualno putanja do profilne slike).
  - Tabela `prostor` – Čuva podatke o coworking prostorima (naziv, slika, adresa, kapacitet, cena po satu, status).  
    _Napomena:_ Kolona `adresa` je dodata kako bi se prikazivale adrese prostora.
  - Tabela `rezervacije` – Čuva rezervacije koje korisnici kreiraju (referenca na korisnika i prostor, datum, početno i krajnje vreme).

- **CSS:**
  - Stilovi su definisani u folderu `css` (fajl `styles.css`) i obezbeđuju responzivan dizajn, centralizovan izgled sadržaja te konzistentan prikaz navigacije, formi, kartica prostora i tabela.
  - Stilovi osiguravaju da slike u karticama i detaljima imaju fiksne dimenzije uz `object-fit: cover`, a sve forme i dugmad koriste globalnu klasu `.btn` za ujednačen izgled.

- **Sigurnost:**
  - Svi ulazi se sanitizuju pomoću `htmlspecialchars()` (i eventualno drugih sanitizacijskih funkcija) radi zaštite od XSS napada.
  - Koriste se pripremljene izjave (prepared statements) za sve SQL upite kako bi se sprečile SQL injekcije.
  - Upload fajlova (npr. profilna slika prilikom registracije) je implementiran s validacijom tipa fajla i veličine, a fajlovi se smeštaju u odgovarajući folder (`uploads/` ili `images/`).

- **Cookie-jevi:**
  - PHP sesije se koriste za održavanje stanja korisnika. Kada se pozove `session_start()`, PHP automatski postavlja cookie (najčešće `PHPSESSID`), što zadovoljava zahtev za korišćenjem cookie-ja.

## Tehnologije korišćene u projektu

- **Backend:** PHP, MySQL  
- **Frontend:** HTML, CSS (osnovna funkcionalnost je ostvarena isključivo u PHP-u, mada se mogu dodati i neki JavaScript elementi)
- **Alati:** XAMPP/WAMP, phpMyAdmin, Visual Studio Code

## Instalacija i pokretanje

2. **Postavi projekat na lokalni server:**

   Koristi XAMPP, WAMP ili sličan paket. Projekat postavi u `htdocs` folder (ili odgovarajući folder za tvoj server).

3. **Kreiraj bazu podataka:**
   - Uđi u phpMyAdmin i kreiraj bazu (npr. `cowork_reservations`).
   - Kreiraj tabele `korisnik`, `prostor` i `rezervacije` prema specifikacijama.
   - Ako tabela `prostor` nema kolonu `adresa`, dodaj je pomoću sledećeg SQL upita:
     
     ```sql
     ALTER TABLE prostor ADD COLUMN adresa VARCHAR(255) AFTER slika;
     ```
     
   - Ubaci početne podatke za prostore. Primer SQL upita:
     
     ```sql
     INSERT INTO prostor (naziv, slika, adresa, kapacitet, cena_po_satu, status) VALUES
     ('Open Space Deluxe', 'openspace_deluxe.jpg', 'Bulevar oslobođenja 12, Beograd', 15, 600, 'dostupno'),
     ('Sala za Sastanke Premium', 'sala-sastanaka_premium.jpg', 'Ulica Kralja Petra 8, Novi Sad', 8, 1100, 'dostupno'),
     ('Creative Corner', 'creative_corner.jpg', 'Trg oslobođenja 3, Niš', 10, 800, 'dostupno'),
     ('Innovation Hub', 'innovation_hub.jpg', 'Ulica Inovatora 5, Beograd', 20, 750, 'dostupno'),
     ('Startup Space', 'startup_space.jpg', 'Tech Park 9, Novi Sad', 12, 650, 'dostupno'),
     ('Creative Studio', 'creative_studio.jpg', 'Industrijska zona 3, Niš', 8, 500, 'dostupno');
     ```

4. **Konfiguriši konekciju u `classes/Database.php`:**
   - Proveri da li su podaci za konekciju (host, username, password, naziv baze, port) ispravni.

5. **Pristupi aplikaciji preko pretraživača:**
   - Na primer, otvorite `http://localhost/cowork-reservations/index.php`

## Sigurnost

- **Sanitizacija unosa:** Svi ulazi se obrađuju pomoću `htmlspecialchars()` i drugih sanitizacijskih funkcija, čime se štiti aplikacija od XSS napada.
- **SQL Prepared Statements:** Svi SQL upiti se izvršavaju korišćenjem pripremljenih izjava kako bi se sprečile SQL injekcije.
- **File Upload:** Upload fajlova (npr. profilna slika pri registraciji) validira tip fajla i veličinu, te se fajlovi smeštaju u odgovarajući folder.
- **Sesije i Cookie-jevi:** PHP sesije koriste cookie-je (npr. `PHPSESSID`) za održavanje stanja korisnika, što zadovoljava zahteve vezane za korišćenje cookie-ja.

## Autor

- Ime: [Vukašin Patković]
- GitHub: [https://github.com/patkovicvukasin]
- Email: [vukasinpatkovic@gmail.com]
