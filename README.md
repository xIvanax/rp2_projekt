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
  - __hotele__ (ime, grad, udaljenost od centra i id)
  - __ocjene__ koje su gosti ostavili za hotel (id hotela, id ocjene, username gosta, komentar gosta, ocjena)
  - __sobe__ (cijena u eurima, id hotela u kojem je soba, id sobe, tip sobe)
  - __sobe_datumi__ (id_sobe, datum zauzeca, datum oslobodenja; nema primary key jer jedna soba moze biti zauzeta u vise perioda)
 -  __user-e__ (željeni datum dolaska u hotel, željeni datum odlaska iz hotela, id user-a, username, email, je li se registrirao do kraja, hashirani password, registracijski kod, id_hotela koji je -1 ako je obični user, odnosno id hotela za koje ima privilegije ako je privilegiran - sada je možda i beskorisna tablica projekt_posebni_useri) -> mislim da ovdje ipak ne trebaju datumi i da ih je dovoljno pohraniti u sobe_datumi, al nisam sigurna (ovdje nisam stavila da je id user-a primary key ako zelimo omoguciti da jedan user moze rezervirati vise razlicith datuma - ovo ce otezati dodejljivanje novog id-a za novog user-a tj. trebat ce se koristiti Set kao struktura podataka pri odredivanju novog nepostojeceg id-a; također, datum moze biti i null jer user ne mora nista imati rezervirano

__Vjerojatno bi bilo najbolje popuniti ih iz php-a, a ne u phpmyadmin jer ak kasnije skuzimo da nes ne valja s tablicom lakse cemo popravit.__

Resources: https://tableconvert.com/excel-to-sql (pretvaranje excel tablice u sql naredbe), [booking.com](https://www.booking.com/) (informacije za hotele, imaju i komentare korisnika s ocjenama, ideje za tipove soba, cijene itd. - ugl. korisno da ne moramo izmisljat nego mozemo samo copy pasteat hrpu tog)

## Updates
- baza podataka je skroz gotova (osmisljeni podaci i napravljen sql u phpmyadmin) i moze se koristiti _~Ivana_
- omoguceno uloggiravanje i registracija i prikaz pocetne stranice _~Ivana_
- omoguceno filtriranje hotela prema zahtjevima korisnika _~Ivana_
- napravila css, bilo bi bolje koristiti JavaScript u nekim dijelovima (npr. kod filtriranja, kod bookiranja da iskoci kalendar di ce odabrat, kod ocjenjivanja da moze stisnuti jednu od 10 zvjeydica da bi ostavio ocjenu itd.) _~Ivana_
- napravljen interface za premium usere gdje vide sobe koje nude i mogu ih editirati ili dodavati nove _~Kikac_
- prepravila funkciju getHighestRoomId t.d. ne vraca veci id od najveceg koji postoji nego vraca prvi dostupni id - trebali bi ju i prikladno preimenovati _~Ivana_
- omogućen je odabir hotela, te nakon sto se odabere hotel moze se izabrati datum boravka te odabrati koje sobe i koliko tih soba zeli rezervirati

## Korisno
### JavaScript
- pitala sam ChatGPT gdje bi i zašto u našoj aplikaciji za hotele trebalo koristiti JavaScript umjesto PHP-a i zašto pa mi je ovo rekao (neke od tih stvari ćemo tek raditi na predavanjima): ~Ivana
"Yes, there can be several benefits to using JavaScript in your web application alongside PHP, HTML, and a database. Here are a few reasons why you might consider incorporating JavaScript into your application:

- Enhancing User Experience: JavaScript allows you to create dynamic and interactive elements on your web pages. You can use JavaScript to implement features like form validation, dropdown menus, auto-suggestions, sliders, and other interactive components. These enhancements can improve the overall user experience and make your application more user-friendly.

- Asynchronous Operations: JavaScript supports asynchronous programming, which means you can make AJAX (Asynchronous JavaScript and XML) requests to the server without reloading the entire page. This can be useful for implementing features such as real-time updates, dynamic content loading, and seamless interactions with the server, providing a smoother user experience.

- Client-Side Form Validation: While server-side validation with PHP is crucial, JavaScript can provide immediate feedback to users by performing client-side form validation before submitting the data to the server. This can reduce the number of round trips to the server and provide a quicker response to users.

- Dynamic Content Manipulation: JavaScript can manipulate the DOM (Document Object Model) dynamically, allowing you to change the content and appearance of your web pages based on user actions or other events. For example, you can show or hide elements, update information without reloading the page, or create dynamic menus based on user preferences.

- Integration with APIs and Libraries: JavaScript has a wide range of libraries and APIs available that can greatly simplify development tasks. You can leverage JavaScript libraries like jQuery, React, or Vue.js to streamline common tasks, handle DOM manipulation, and build complex user interfaces more efficiently.

- Asynchronous Task Processing: JavaScript can offload certain tasks from the server to the client-side, reducing the server load and improving scalability. For example, you can perform client-side calculations, data processing, or rendering that don't require server interaction.

Remember that PHP primarily handles server-side tasks, such as database interactions and server logic, while JavaScript focuses on client-side interactions and user interface enhancements. By combining the strengths of both languages, you can build a more powerful and interactive web application."
