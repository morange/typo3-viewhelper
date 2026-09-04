# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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