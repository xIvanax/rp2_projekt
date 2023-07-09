# Web aplikacija za nalaženje hotelskog smještaja

## Zadatak
Aplikacija sadrži nekoliko hotela u nekoliko gradova te se korisniku nudi opcija da na temelju grada, cijene, udaljenosti od centra, dobivenih ocjena nađe hotel koji mu najviše odgovara. Također može po bilo kojem od kriterija sortirati hotele. Korisnici mogu davati ocjene hotelima te ostavljati komentare, tj. recenzirati hotele, koji će kasnije biti dostupni ostalim korisnicima. Uz obične korisnike koji rezerviraju smještaj, postoje i korisnici tipa hotel. Oni mogu definirati broj soba odgovarajućeg tipa te njihove cijene, eventualno dodavati slike. Treba onemogućiti daljnju rezervaciju soba ako one postanu nedostupne za odabrane datume. 

## Postupak izrade i predaje zadatka
1. ~~Aplikaciju je preporučeno razvijati u skladu s __Model-View-Controller__ arhitekturalnim patternom. U protivnom treba dati odgovarajuće obrazloženje.~~
2. ~~Rješenje zadatka, koje uključuje (dobro komentiran) kod i kratku prezentaciju treba poslati mailom prof. Bujanoviću. Alternativno, po završetku razvoja, možete uz prezentaciju profesoru poslati link na Git repozitorij ili ga dodati kao člana sa readonly pravom ako je projekt privatan. Termin usmene obrane se dogovara s profesorom; trebate se javiti dovoljno rano (barem tjedan dana unaprijed).~~
3. ~~Mogući termini usmene obrane će biti objavljeni ovdje.~~
4. ~~Izvorni kod (source) ili link na Git repozitorij, prezentaciju s opisom aplikacije, te link na aplikaciju na rp2 serveru je potrebno poslati profesoru mailom barem dva dana prije usmene obrane.~~ Na obrani trebaju biti prisutni svi članovi projekta, te svatko treba objasniti svoju ulogu u projektu.
5. ~~Rješenje bi trebalo biti postavljeno na rp2.studenti.math.hr (osim u iznimnim situacijama i u dogovoru s profesorom).~~
6.~~Projekt treba sadržavati aspekte __i serverskog (PHP) i klijentskog (JavaScript) programiranja__. Iznimke su moguće jedino u dogovoru s profesorom.~~

## New updates
- omoguceno filtriranje u sucelju za obicne usere pomocu javascripta i uskladen css _~Ivana_
- prosiren css na sve dijelove stranice za obicne user-e, popravljeni neki buggovi za javascript i pociscen kod za kontroler i view _~Ivana_
- dodana kontrola rubnih slučajeva u dijelu s dodavanjem/editanjem soba kod premium user-a _~Ivana_

## Old updates
- baza podataka je skroz gotova (osmisljeni podaci i napravljen sql u phpmyadmin) i moze se koristiti _~Ivana_
- omoguceno uloggiravanje i registracija i prikaz pocetne stranice _~Ivana_
- omoguceno filtriranje hotela prema zahtjevima korisnika _~Ivana_
- napravila css, bilo bi bolje koristiti JavaScript u nekim dijelovima (npr. kod filtriranja, kod bookiranja da iskoci kalendar di ce odabrat, kod ocjenjivanja da moze stisnuti jednu od 10 zvjeydica da bi ostavio ocjenu itd.) _~Ivana_
- napravljen interface za premium usere gdje vide sobe koje nude i mogu ih editirati ili dodavati nove _~Kikac_
- prepravila funkciju getHighestRoomId t.d. ne vraca veci id od najveceg koji postoji nego vraca prvi dostupni id - trebali bi ju i prikladno preimenovati _~Ivana_
- omogućen je odabir željenog hotela u kojemu korisnik želi rezervirati sobu/e, omogućen je odabir termina rezervacije, te se u skladu s dostupnošću soba u tom terminu u tom hotelu omogućava odabir koliko soba svake vrste korisnik želi odabrati _~Dorotea_
* omogućen je prikaz svih rezervacija koje je korisnik napravio (one prošle i buduće) kao i svi komentari na te rezervacije, te je omogućeno sljedeće:
  * ako je rezervacija nekada u budućnosti, korisnik ju može obrisati
  * ako je rezervacija u proslosti onda ju može komentirati
  * za rezervacije za koje već postoji komentar omogućeno je uređivanje i brisanje tog komentara _~Dorotea_
- nisam još nigdje nadodala koja je sveukupna cijena rezervacije _~Dorotea_
- za sada se kod prikaza rezervacija, svaka soba prikazuje kao zasebna rezervacija iako sam omogućila da se u jednoj rezervaciji odabere vise različitih soba, to možemo popraviti ako ćemo imati vremena, ili ostaviti ovako, čini mi se da ne bi trebalo biti problema _~Dorotea_
- također sam napravila da kada se korisnik ulogira te prikaže svoje rezervacije, automatski se sve rezervacije koje se prilikom zadnjeg ulogiravanja bile nekada u budućnosti (te samim time korisnik na njih još nije mogao ostaviti komentar), ako se prilikom trenutnog ulogiravanja prešao datum check-ina u sobu, omogući komentiranje smještaja _~Dorotea_
- za sada je onemogućeno ostavljanje samo komentara ili samo ocjene za hotel, to možemo promijeniti naknadno, ako ćemo htjet i imat vremena _~Dorotea_
- Omogućila sam korištenje pop up kalendara kod rezervacije soba i prilagodila sam kontroler tom kalendaru (prije je vukao informacije iz select-ova i to). Dodala sam i dosta css-a da bi donekle to sve radilo, i dalje ima mogućih poboljšanja (npr. pri smanjivanju prozora), ali nisam ih uspjela napraviti pa ako netko drugi misli da može - please go ahead. _~Ivana_
- Omogucen je sort po ratingu, udaljenosti i cijeni na naslovnoj stranici koristeci javascript. _~Ivana_
- Dodan ispis najnize cijene sobe za svaki hotel an naslovnoj stranici u svrhu sorta po cijeni. _~Kiki_
- Popravila sam jos neke greske od doroteinog pusha i popravila greske koje je uzrokovo kikijev zadnji push. Pliz provjeravajte jel sve funkcionira i nakon sto nes izmijenite i pushate. _~Ivana_
- omogucen sort u sucelju za premium usere i uskladen css tog sučelja s ostatkom stranice _~Ivana_

## Baza podataka _~Ivana_
Napravila sam bazu podataka na phpadmin-u, sva imena pocinju s _projekt_.
Imamo odvojene tablice za:
  - __hotele__ (ime, grad, udaljenost od centra i id)
  - __ocjene__ koje su gosti ostavili za hotel (id hotela, id ocjene, username gosta, komentar gosta, ocjena)
  - __sobe__ (cijena u eurima, id hotela u kojem je soba, id sobe, tip sobe)
  - __sobe_datumi__ (id_sobe, datum zauzeca, datum oslobodenja; nema primary key jer jedna soba moze biti zauzeta u vise perioda)
 -  __user-e__ (željeni datum dolaska u hotel, željeni datum odlaska iz hotela, id user-a, username, email, je li se registrirao do kraja, hashirani password, registracijski kod, id_hotela koji je -1 ako je obični user, odnosno id hotela za koje ima privilegije ako je privilegiran - sada je možda i beskorisna tablica projekt_posebni_useri) -> mislim da ovdje ipak ne trebaju datumi i da ih je dovoljno pohraniti u sobe_datumi, al nisam sigurna (ovdje nisam stavila da je id user-a primary key ako zelimo omoguciti da jedan user moze rezervirati vise razlicith datuma - ovo ce otezati dodejljivanje novog id-a za novog user-a tj. trebat ce se koristiti Set kao struktura podataka pri odredivanju novog nepostojeceg id-a; također, datum moze biti i null jer user ne mora nista imati rezervirano
 -  napravila sam novu tablicu projekt_rezervacije(id_osobe, id_hotela, dolazak, odlazak)
 -  u projekt_sobe_datumi dodala sam id_usera
 -  napravila neke promijene u tablici projekt_ocjene _~Dorotea_

Resources: https://tableconvert.com/excel-to-sql (pretvaranje excel tablice u sql naredbe), [booking.com](https://www.booking.com/) (informacije za hotele, imaju i komentare korisnika s ocjenama, ideje za tipove soba, cijene itd. - ugl. korisno da ne moramo izmisljat nego mozemo samo copy pasteat hrpu tog)
