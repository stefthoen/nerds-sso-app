# Readme

## Log

Na het ontvangen van de opdracht heb ik besloten om het met Laravel en PHP te bouwen. Ik dacht in eerste instantie een custom PHP applicatie te bouwen, maar de opdracht was dusdanig complex dat ik niet binnen de tijd het 'from scratch' zou kunnen bouwen, dus greep ik naar Laravel, die daar wel de tools voor heeft (Laravel Passport). 

Het client gedeelte wou ik implementeren met een Next.js app die NextAuth.js implementeert. Ik had de [NextAuth](https://github.com/nextauthjs/next-auth-example) demo in een repo gegooid met het idee om die aan te passen en er een 'logout' API call mee te doen naar de Laravel app, die de bearer token revoked.

Het is alweer een tijdje geleden dat ik iets met Laravel gedaan heb, dus ik was wat tijd kwijt met uitvinden waar alles ook alweer stond en hoe dingen veranderd zijn sinds de laatste keer dat ik het gebruikt heb. Tevens heb niet eerder oAuth2 zelf geimplementeerd. Ik heb het alleen maar SSO geconsumeerd (van Google, GitHub, etc.).

Aan het einde van de ochtend had ik het volgende staan:
- Authenticatie met user/pass waarin je in een omgeving komt waarin je clients kunt aanmaken.
- Bij het aanmaken van een client krijg je een secret en client id terug.

Als volgende stap wou ik in Postman gaan testen of ik hiermee succesvol kon inloggen. Ik kreeg een foutmelding dat hij het key-pair niet kon vinden. Ik veranderde de locatie van het key-pair en probeerde het daarna weer, maar hij gaf dezelfde foutmelding. Ik heb toen meerdere commando's uitgevoerd om caching leeg te gooien of op een andere manier de state van de app te resetten, maar ik kreeg het niet werkend. Ten slotte startte ik mijn computer maar opnieuw op om te kijken of dat effect had.

Na de reboot, wou hij http://localhost niet meer laden. Ik ben vervolgens 3 uur bezig geweest met Laravel, Sail, Docker en Linux te debuggen, maar ik heb het niet kunnen vinden. Ik heb een nieuw Sail project gestart en dat opgestart, en ook daar wou hij localhost niet laden. Ik heb toen deze Loom video opgenomen: https://www.loom.com/share/6644cf2fb3b94b13b57a8e5eadb88624?sid=e3103a50-738d-4cfd-a8ac-ccfbd671423e. En ben dit gaan schrijven. 

In de tijd die ik over had, ben ik toen maar een Next.js app met NextAuth.js gaan bouwen, om een SSO van een grote provider te consumeren, zoals bijv. GitHub. Ik was hier mee bezig en ik had mijn browser open staan en toen zag ik dat mijn Sail project ineens geladen was. Frustrerend dat ik zoveel tijd kwijt was geraakt, maar ik kon i.i.g. weer verder met het SSO gedeelte, ook al heb ik geen antwoord voor waarom hij het 3 uur lang niet deed, want ik had werkelijk niets veranderd. Onderdeel van die 3 uur was ook dat Composer i.c.m. Laravel ineens plat lag, waardoor ik Laravel niet kon downloaden. Ik had nog 2 uur.

Ik heb het probleem met het key-pair kunnen fixen en het is mij gelukt om via Postman een bearer token te krijgen. Ik heb een filmpje opgenomen met een demonstratie: https://www.loom.com/share/fbdfbb333ce34fdfa2c34898b25493a5?sid=b99ae71e-929b-4421-88d9-fa57644357c0

In de laatste minuten heb ik het revoken van het bearer token bij het uitloggen nog kunnen toevoegen, maar dit heb ik niet meer kunnen testen.

## Setup

Ik heb Sails gebruikt om Laravel op Linux te installeren. Ik denk dat je het volgende kunt doen om het bij jou werkend te krijgen:

### Laravel

1. `git clone git@github.com:stefthoen/nerds-sso-app.git`
2. Ga naar de root van het project en run `composer install` en `npm install`
3. Start Sails met `./vendor/bin/sails up` (voor OS-specifieke setup, check de [Laravel documentatie](https://laravel.com/docs/11.x/installation#docker-installation-using-sail))
4. Run de migrations met `/vendor/bin/sails artisan migrate`
5. [Volg de installatie stappen van Passport](https://laravel.com/docs/11.x/passport#installation)
6. [Voeg keys toe aan je `.env` file](https://laravel.com/docs/11.x/passport#loading-keys-from-the-environment)

### Postman call #1

Zoals ik zei had ik geen tijd om de PoC app te implementeren, maar ik heb in Postman wel de werking van de Laravel app gesimuleerd. In de Loom video's kun je het denk ik wel volgen, maar ik zal het hier ook even typen.

1. Ga naar http://localhost en maak daar een account aan.
2. Voeg een client toe. Naam mag van alles zijn. Callback is http://localhost/callback.
3. In het scherm  dat je dan te zien krijgt, zie je je secret. Kopieer die, want de secret die ik op http://localhost/dashboard/clients laat zien toont de encrypted secret.
4. Voeg een GET request toe met deze URL: http://localhost/oauth/authorize. Gebruik de volgende Params: [client_id, <kopieer hier de client id in de app, waarschijnlijk 1 voor de eerste>], [redirect_uri, "http://localhost/callback"], [response_type, "code"], [scope, ""], [state, <random string van 40 characters: asdfasdfasdfasdfasdfasdfasdfasdfasdfasdf>]
5. Neem de URL die Postman genereert en plak die in je browser. Je krijgt een 404, maar in de URL zie je dat de code is ingevuld. Kopieer deze code.

### Postman call #2

1. Maak een POST request in Postman met deze URL: http://localhost/oauth/token
2. Vul daar bij Body -> form-data de volgende key-value pairs in: [grant_type, "authorization_code"]. Verder kun je `client_id`, `client_secret` en `redirect_url` overnemen van de GET call. Ook `code` neem je over, maar daar plak je de code die je bij `Postman call #1 stap 5 hebt gekregen.
3. Druk <Send> en je krijgt een JSON response met de bearer token in het `access_token` veld.

## Overige documentatie Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
