## Kunde

`dmfh/typo3-mail-branding` (bis 04.09.2026: `dmfh/typo3-viewhelper`) — eigenes shared
Composer-Package (kein Kundenprojekt) von dermatthes-frauhofer, GitHub-Repo
`github.com/morange/typo3-viewhelper.git` (Repo-Name auf GitHub noch nicht mitumbenannt,
siehe Umgebung). Ursprünglich als generische Fluid-ViewHelper-Sammlung gestartet, dann noch
am selben Tag zu einem dedizierten Paket für settings-gesteuertes System-E-Mail-Branding
umgebaut: TYPO3 Site Set (`Configuration/Sets/MailBranding/`) mit typisierten Footer-/Logo-Settings,
das Fluid-Layout `SystemEmail.fluid.html` (Fork von `EXT:core`s Default-Layout) und der
`SiteSettingViewHelper`, der Site Settings innerhalb von `FluidEmail`-Templates lesbar macht.
Auslöser: DVL Sachsen wollte die Footer-Pflichtangaben (Adresse, Registergericht, Steuernummer
etc.) einer System-E-Mail projektübergreifend wiederverwendbar & redakteursseitig pflegbar machen,
nicht in jedem Projekt einzeln hart codieren.

## Umgebung

- TYPO3 `^14.3`, PHP `^8.3`, `typo3fluid/fluid ^5.0`
- Extension-Key `dmfh_mailbranding`, PHP-Namespace `Dmfh\MailBranding`, Fluid-Tag-Präfix bleibt `dmfh:`
- **Offener Punkt:** Der lokale Ordner wurde von `typo3-viewhelper` auf `typo3-mail-branding`
  umbenannt und `composer.json`/Namespace/Extension-Key entsprechend angepasst — das GitHub-Repo
  selbst (`morange/typo3-viewhelper`) und der git-Remote sind zum Zeitpunkt dieser Notiz noch NICHT
  umbenannt/nachgezogen. Vor dem nächsten Push/Tag prüfen: `gh repo rename typo3-mail-branding
  --repo morange/typo3-viewhelper` (GitHub behält eine Weiterleitung vom alten Namen).
- Composer-Auth-Problem (04.09.2026, gelöst): Im DDEV-Container ist eine `COMPOSER_AUTH`-Umgebungsvariable
  mit einem fine-grained GitHub-Token gesetzt (`~/.ddev/global_config.yaml`, gilt projektübergreifend
  für alle DDEV-Projekte). Diese Env-Var hat Vorrang vor einer projektlokalen `auth.json` und
  überschreibt sie komplett. Der Token ist auf bestimmte Repos beschränkt und enthielt das neue Repo
  nicht → 403 „Write access to repository not granted" beim `composer require`, obwohl derselbe
  Token per `git ls-remote` per Kommandozeile einwandfrei funktionierte (deshalb zunächst irreführend).
  Gelöst durch **Repo auf public umstellen** (passt auch zum bestehenden Muster: `typo3-deployer`
  und `brevo` sind ebenfalls public) statt den Token-Scope zu erweitern.
  **Bei erneutem 403 bei Composer-Zugriff auf ein privates eigenes Repo:** zuerst `COMPOSER_AUTH`
  im DDEV-Container prüfen (`ddev exec printenv COMPOSER_AUTH`), nicht nur `auth.json`.

## Projektspezifische Konventionen

(noch keine Abweichungen von den globalen Coding Guidelines dokumentiert)