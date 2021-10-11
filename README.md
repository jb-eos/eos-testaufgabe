# eos.uptrade Testaufgabe


## Aufgabenstellung
> Schreib eine einfache API (unter Nutzung des Symfony Framework), um eine Liste von
Benutzern anzuzeigen, neuen Benutzer zu erstellen und einen vorhandenen Benutzer zu
ändern oder löschen. Ziel ist es, die Datenquelle (etwa eine Datenbank, eine XML Datei, ...)
für Benutzer auszutauschen, ohne den Code berühren zu müssen, der die Datenquelle
verwendet und die Antwort zurückgibt. Stelle bitte eine Dokumentation zum Konsumieren
der API bereit. Es wäre großartig, wenn Du uns Deine Antwort mit einem GitHub-Link und
einer kleinen ReadMe-Datei senden würdest. Viel Spaß!


## Setup

### 1. PHP
Sofern PHP 8 lokal installiert ist:
```
php -S localhost:8080 -t ./public
```

Wenn PHP 8 nicht lokal installiert ist, aber Docker vorhanden ist:
```
docker compose up -d
```

### 2. Composer
Egal mit welcher lokalen PHP Version:
```
composer install --ignore-platform-reqs
```

### 3. API-Dokumentation
In [Postman](https://www.postman.com/) unter ```File``` => ```Import``` die ```openapi.yaml``` Datei aus dem Root-Verzeichnis des Projektordners importieren.

### 4. Start
Aktuell stehen zwei Datenquellen zur Auswahl. Eine SQLite Datenbank und eine Users.json Datei. Beide sind auch bereits angelegt. Es muss also nichts weiter unternommen werden.

Die eigentliche Auswahl der Datenquelle kann ganz unten in der ```config/services.yaml``` Datei geändert werden:
```yaml
$adapter: '@App\Adapter\DatabaseAdapter'
oder
$adapter: '@App\Adapter\JsonAdapter'
```


## Umsetzung
Zuerst einmal hoffe ich, dass ich die Aufgabe richtig verstanden habe...

Wenn dem so ist, dann wird ein Interface benötigt, welches die jeweiligen Adapter für die unterschiedlichen Datenquellen implementieren müssen.

Die Klassen, die dann später mit der Datenquelle arbeiten wollen (Controller, UserManager, ...), können somit auf das Interface 'type hinten' und der Service Container 'injected' je nach config die eigentliche Implementierung.

## Disclaimer
- Mir ist durchaus bewusst, dass hier einige edge cases nicht abgefangen werden. Das würde die Aufgabe nur unnötig verlängern. Normalerweise würde ich die natürlich abfangen.
- Auch die Validierung im Controller würde ich in einer echten Anwendung über unterschiedliche Validators laufen lassen und nicht einfach nur ```empty()``` nutzen.
- Der UserManager ist im aktuellen Fall nutzlos. Ist mir aber erst am Ende aufgefallen. Bleibt jetzt also einfach drin. 😉