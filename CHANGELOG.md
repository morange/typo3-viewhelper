# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.3.1] — 2026-09-04

### Fixed

- Restore the inline `style` attribute (color, text-align, font-family, font-size, line-height)
  on the two footer `<p>` tags. The v0.3.0 rewrite based the footer on `EXT:core`'s default
  layout, which relies solely on the `.footerContainer .textContent p` rule in the `<style>`
  block — but the original DVL Sachsen override additionally inlined those exact properties on
  the elements themselves, since many email clients strip `<style>` blocks entirely. Lost during
  the v0.2.0/v0.3.0 rewrites; footer text would have rendered unstyled (default black,
  left-aligned) in style-stripping clients.

## [0.3.0] — 2026-09-04

### Changed

- **[!!!]** Stop defining a parallel `mailBranding.footer.*`/`mailBranding.logo.*` settings tree.
  `oliverthiele/ot-sitekit-base` already ships `sitekit.project.companyName`, `addressLine1`,
  `addressLine2`, `postalCode`, `city`, `telephone`, and `email` under the `Sitekit.project`
  category — this package now reads those directly instead of duplicating them, and adds
  `oliverthiele/ot-sitekit-base` as a Site Set dependency. Consuming projects that already set
  these `sitekit.project.*` values (as most SiteKit projects do, for the website itself) need no
  extra configuration for the email footer beyond the genuinely new fields below.
- Rename the remaining new settings to live under `Sitekit.project`/`Sitekit.project.brand`
  instead of a standalone `MailBranding` category: `sitekit.project.fax`,
  `sitekit.project.representative`, `sitekit.project.registerCourt`,
  `sitekit.project.registerNumber`, `sitekit.project.registerType`, `sitekit.project.taxNumber`,
  `sitekit.project.brand.logo.file.email`.

### Added

- Add `sitekit.project.brand.logo.file.emailDark` — optional dark-mode logo variant, shown to
  `prefers-color-scheme: dark` email clients via a CSS light/dark image-swap (falls back to the
  light logo when unset).
- Footer now conditionally omits `companyName2`, `addressLine2`, and fax when unset, instead of
  rendering an empty value with a stray separator.

## [0.2.1] — 2026-09-04

### Fixed

- Fix `settings.definitions.yaml`: top-level `MailBranding` category was declared as `~` (null)
  while `MailBranding.logo`/`MailBranding.footer` referenced it via `parent:` — TYPO3 requires a
  category referenced as a parent to be a full definition with a `label`, not null. This disabled
  the entire Site Set backend-wide ("Site set 'dmfh/mail-branding' is disabled due to invalid
  category definitions") for any consuming site.

## [0.2.0] — 2026-09-04

### Changed

- **[!!!]** Rescoped the package from a generic Fluid ViewHelper collection to a dedicated
  system-email branding package. Renamed `dmfh/typo3-viewhelper` → `dmfh/typo3-mail-branding`,
  extension key `dmfh_viewhelper` → `dmfh_mailbranding`, PHP namespace `Dmfh\ViewHelper` →
  `Dmfh\MailBranding`. Consuming projects must update their `composer.json` require and any
  `xmlns:dmfh` declarations to the new namespace URI.

### Added

- Add a TYPO3 Site Set (`Configuration/Sets/MailBranding/`) with typed settings for a
  system-email logo and legal/contact footer (organization name, address, phone, fax, email,
  representative, register court/number/type, tax number).
- Add `Resources/Private/Layouts/SystemEmail.fluid.html` and `.fluid.txt` — a fork of
  `EXT:core`'s default system-email layout with the logo and footer driven by those settings,
  falling back to TYPO3's own default logo/branding logic when unconfigured.
- Add `Resources/Private/Language/locallang.xlf` (+ German translation) with the structural
  footer labels (Contact, Phone, Fax, Email, Represented by, Registered court, Registration
  number, Register entry, Tax number).

## [0.1.0] — 2026-09-04

### Added

- Add `<dmfh:siteSetting>` ViewHelper to read a typed TYPO3 site setting by dotted path