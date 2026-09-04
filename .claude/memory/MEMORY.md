## Kunde

`dmfh/typo3-viewhelper` — eigenes shared Composer-Package (kein Kundenprojekt) von
dermatthes-frauhofer, GitHub-Repo `github.com/morange/typo3-viewhelper.git`. Sammlung
wiederverwendbarer Fluid-ViewHelper für TYPO3 v14+ Projekte, wird von anderen Projekten per
VCS-Repository eingebunden (siehe README.md).

## Umgebung

- TYPO3 `^14.3`, PHP `^8.3`, `typo3fluid/fluid ^5.0`
- Composer-Auth-Problem (04.09.2026): Im DDEV-Container ist eine `COMPOSER_AUTH`-Umgebungsvariable
  mit einem fine-grained GitHub-Token gesetzt. Diese Env-Var hat Vorrang vor einer projektlokalen
  `auth.json` und überschreibt sie komplett — eine lokal angelegte `auth.json` wirkt dadurch nicht
  und wurde deshalb wieder entfernt.
  Das Token ist auf bestimmte Repos beschränkt; `morange/typo3-viewhelper` gehörte zum Diagnosezeitpunkt
  noch nicht zum erlaubten Scope, was beim `composer require dmfh/typo3-viewhelper` aus einem
  konsumierenden Projekt zu einem 403 führte.
  **Bei erneutem 403 bei Composer-Zugriff auf dieses Repo:** zuerst `COMPOSER_AUTH` im DDEV-Container
  prüfen (nicht nur `auth.json`), und ob der Token-Scope `morange/typo3-viewhelper` inzwischen enthält,
  bevor man an einer lokalen `auth.json` weitersucht.

## Projektspezifische Konventionen

(noch keine Abweichungen von den globalen Coding Guidelines dokumentiert)