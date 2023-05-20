# rp2_projekt
Web aplikacija za nalaženje hotelskog smještaja

## Zadatak
Aplikacija sadrži nekoliko hotela u nekoliko gradova te se korisniku nudi opcija da na temelju grada, cijene, udaljenosti od centra, dobivenih ocjena nađe hotel koji mu najviše odgovara. Također može po bilo kojem od kriterija sortirati hotele. Korisnici mogu davati ocjene hotelima te ostavljati komentare, tj. recenzirati hotele, koji će kasnije biti dostupni ostalim korisnicima. Uz obične korisnike koji rezerviraju smještaj, postoje i korisnici tipa hotel. Oni mogu definirati broj soba odgovarajućeg tipa te njihove cijene, eventualno dodavati slike. Treba onemogućiti daljnju rezervaciju soba ako one postanu nedostupne za odabrane datume. 

## Postupak izrade i predaje zadatka
1. Aplikaciju je preporučeno razvijati u skladu s __Model-View-Controller__ arhitekturalnim patternom. U protivnom treba dati odgovarajuće obrazloženje.
2. Rješenje zadatka, koje uključuje (dobro komentiran) kod i kratku prezentaciju treba poslati mailom prof. Bujanoviću. Alternativno, po završetku razvoja, možete uz prezentaciju profesoru poslati link na Git repozitorij ili ga dodati kao člana sa readonly pravom ako je projekt privatan. Termin usmene obrane se dogovara s profesorom; trebate se javiti dovoljno rano (barem tjedan dana unaprijed).
3. Mogući termini usmene obrane će biti objavljeni ovdje.
4. Izvorni kod (source) ili link na Git repozitorij, prezentaciju s opisom aplikacije, te link na aplikaciju na rp2 serveru je potrebno poslati profesoru mailom barem dva dana prije usmene obrane. Na obrani trebaju biti prisutni svi članovi projekta, te svatko treba objasniti svoju ulogu u projektu.
5. Rješenje bi trebalo biti postavljeno na rp2.studenti.math.hr (osim u iznimnim situacijama i u dogovoru s profesorom). Možete koristiti i vanjske JavaScript/HTML/CSS biblioteke, poput jQuery, Bootstrap i sličnih. Ne smijete koristiti gotova ili skoro gotova rješenja zadatka kojeg rješavate -- takva ili bilo koja druga vrsta plagiranja nije prihvatljiva!
6. Projekt treba sadržavati aspekte __i serverskog (PHP) i klijentskog (JavaScript) programiranja__. Iznimke su moguće jedino u dogovoru s profesorom.

## Baza podataka _~Ivana_
Napravila sam bazu podataka na phpadmin-u, sva imena pocinju s _projekt_.
Imamo odvojene tablice za:
  - __hotele__ (ime, grad, ~~broj slobodnih soba, ukupan broj soba,~~ udaljenost od centra i id)
  - __ocjene__ koje su gosti ostavili za hotel (id hotela, id ocjene, ~~id gosta~~, username gosta, komentar gosta, ocjena)
  - __posebne user-e__ tj. one koji mogu mijenjati cijene soba i sl. (id, id hotela nad kojim ima ovlasti)
  - __sobe__ (cijena u eurima, id hotela u kojem je soba, id sobe, tip sobe te ~~datum zauzeća i oslobođenja koji se gledaju samo ako je soba zauzeta što se može provjeriti preko atributa "slobodna" koji je 1 ako je slobodna, a 0 ako nije~~)
  - __sobe_datumi__ (id_sobe, datum zauzeca, datum oslobodenja; nema primary key jer jedna soba moze biti zauzeta u vise perioda) - nema primary key iz slicnog razloga kao obični useri (pogledaj dolje)
 -  __obične user-e__ (željeni datum dolaska u hotel, željeni datum odlaska iz hotela, id user-a, username, ~~ime, prezime~~) -> mislim da ovdje ipak ne trebaju datumi i da ih je dovoljno pohraniti u sobe_datumi, al nisam sigurna (ovdje nisam stavila da je id user-a primary key ako zelimo omoguciti da jedan user moze rezervirati vise razlicith datuma - ovo ce otezati dodejljivanje novog id-a za novog user-a tj. trebat ce se koristiti Set kao struktura podataka pri odredivanju novog nepostojeceg id-a; također, datum moze biti i null jer user ne mora nista imati rezervirano

__Vjerojatno bi bilo najbolje popuniti ih iz php-a, a ne u phpmyadmin jer ak kasnije skuzimo da nes ne valja s tablicom lakse cemo popravit.__

Resources: https://tableconvert.com/excel-to-sql (pretvaranje excel tablice u sql naredbe), [booking.com](https://www.booking.com/) (informacije za hotele, imaju i komentare korisnika s ocjenama, ideje za tipove soba, cijene itd. - ugl. korisno da ne moramo izmisljat nego mozemo samo copy pasteat hrpu tog)

## Updates
- baza podataka je skroz gotova (osmisljeni podaci i napravljen sql u phpmyadmin) i moze se koristiti _~Ivana_
