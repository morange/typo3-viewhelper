# Changelog — dmfh/typo3-viewhelper

# ################################################################################################
## 04.09.2026 (Initial-Setup)

### Paket-Grundgerüst
- [TASK] `composer.json`, `LICENSE`, `README.md`, `.gitignore`: Neues Composer-Paket `dmfh/typo3-viewhelper` als TYPO3-Extension (`dmfh_viewhelper`) angelegt — Sammelrepo für wiederverwendbare Fluid-ViewHelper über mehrere Projekte hinweg. Auslöser: DVL Sachsen brauchte einen ViewHelper, um Site Settings in `FluidEmail`-Templates (System-/Formular-Mails) lesbar zu machen, was sich als projektübergreifend nützlich herausstellte.

### ViewHelper
- [FEATURE] `Classes/ViewHelpers/SiteSettingViewHelper.php`: `<dmfh:siteSetting path="..." default="..." />` liest eine typisierte Site-Setting per Punkt-Pfad. Nutzt, dass `FluidEmail::setRequest()` den PSR-7-Request bereits als Rendering-Context-Attribut ablegt — kein explizites `assign()` in aufrufendem Code nötig.