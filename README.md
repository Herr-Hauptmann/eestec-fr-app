## Instalacija razvojnog okruzenja

- [XAMPP](https://www.apachefriends.org/download.html)
- [Composer](https://getcomposer.org/download/)
- Optional, neki rich text editor, licna preporuka je [VS Code](https://code.visualstudio.com/download)

## XAMPP

Nakon sto instalirate sve potrebne alate, otvorite XAMPP control panel, ukljucite apache server i MySQL. Pored MySQL ima dugme "admin". Kliknite ga i odvest ce vas do phpmyadmin. Potrebno je da kreirate praznu bazu podataka pod imenom 'frapp' koju ce FR aplikacija da koristi.

## Setup aplikacije

- (Optional) kreirajte folder za vase projekte. Lakse ce vam biti organizovati sve projekte. U ovom folderu cemo setup-ati FR aplikaciju
- otvorite command prompt, pozicionirajte se u folder gdje vam je projekat i run-ajte sljedecu komandu `composer global require laravel/installer`
- otvorite Git Bash na istoj lokaciji i klonirajte repozitorij
- u kloniranom projektu kopirajte file koji se zove .env.example i preimenujte ga u .env (file explorer vam nece dati opciju da ne date ime fileu te ovdje uskacu rich text editori poput VS Code koji ovo omogucuju). po potrebi mozete da mijenjate .env file ali je trenutno setupan da nema potrebe za tim
- Sa command prompt-om se pozicionirajte u klonirani projekat
- kucate sljedece komande (Apache server i MySQL moraju biti ukljuceni)
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- sada bi trebalo da je projekat setupan kako treba

## Pokretanje projekta 

Za pokretanje projekta, u prethodno otvorenom command prompt-u kucajte komandu `php artisan serve` koja ce najvjerovatnije pokrenuti aplikaciju na IP adresi [http://127.0.0.1:8000/](http://127.0.0.1:8000/). 

Na samom pocetku ce vam traziti da se login-ate ali trenutno nema korisnika te moramo neke hakerluke da odradimo zbog verifikacije korisnika.
- Prvo se registrujte na `http://127.0.0.1:8000/register`
- kljucna rijec je `efaraplikacija`. Kljucnu rijec mozete mijenjati u .env fileu na liniji 6 `APP_KEYWORD="efaraplikacija"`
- aplikacija ce vas preusmjeriti na dashboard ali pise da morate biti verifikovani. Ovo trenutno nije moguce jer nema admina koji vam mogu odobriti pristup ali to mozemo lahko da izmijenimo
- kroz XAMPP udjite u phpmyadmin (nacin na koji se ovo radi je prethodno objasnjeno). Otvorite **frapp** bazu podataka, tabelu **users**, nadjite sebe i promijenite vrijednost **role_id** sa 4 na 1
- Sada imate pristup aplikaciji i mozete da radite sta hocete
