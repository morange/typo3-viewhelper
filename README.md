# dmfh/typo3-mail-branding

Settings-driven system-email branding for TYPO3 v14+. Pull this in as a Composer dependency
instead of copying a `SystemEmail.fluid.html` override, footer XLIFF labels, and typed site
settings into every site package by hand.

---

## What it provides

- A **TYPO3 Site Set** (`Configuration/Sets/MailBranding/`) that adds the settings a system-email
  footer needs — logo (light + dark variant), representative, register court/number/type, tax
  number — as siblings of `oliverthiele/ot-sitekit-base`'s existing `Sitekit.project` category.
  It deliberately does **not** redefine organization name, address, phone, or email: those
  already exist as `sitekit.project.companyName`/`addressLine1`/`addressLine2`/`postalCode`/
  `city`/`telephone`/`email`, and this package reads them directly rather than duplicating them
  under a second, parallel set of settings.
- A **Fluid Layout** (`Resources/Private/Layouts/SystemEmail.fluid.html` + `.fluid.txt`) — a fork
  of `EXT:core`'s default system-email layout with the logo and footer driven by those settings.
  Falls back to TYPO3's own default logo/branding logic when no custom logo is configured, and
  supports separate light/dark-mode logo images via `prefers-color-scheme`.
- The **`<dmfh:siteSetting>` ViewHelper**, which reads a typed site setting inside `FluidEmail`
  templates — a context where TYPO3 does not automatically expose a `{settings}` Fluid variable.

## Requirements

| Requirement                  | Version |
|--------------------------------|---------|
| TYPO3                          | ^14.3   |
| PHP                            | ^8.3    |
| typo3fluid/fluid               | ^5.0    |
| oliverthiele/ot-sitekit-base   | any     |

This package is built for TYPO3 sites on the OliverThiele SiteKit framework — it depends on
`oliverthiele/ot-sitekit-base`'s `Sitekit.project` settings category and reuses its
organization/address/contact fields rather than shipping its own. It is not meant for non-SiteKit
projects.

## Installation

Add the repository once per project, then require the package:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/morange/typo3-viewhelper.git"
        }
    ]
}
```

```bash
composer require dmfh/typo3-mail-branding
```

The package is a composer-mode-only TYPO3 extension (no `ext_emconf.php` needed) with
extension key `dmfh_mailbranding`. Releases are tagged `vMAJOR.MINOR.PATCH`; consuming projects
pin a version constraint in their own `composer.json`.

## Usage

Depend on the Site Set from your own site package's `config.yaml`:

```yaml
dependencies:
  - dmfh/mail-branding
```

`sitekit.project.companyName`, `addressLine1`/`addressLine2`, `postalCode`, `city`, `telephone`,
and `email` are already provided by `oliverthiele/ot-sitekit-base` — set them as usual (typically
already done for the site's frontend). This package adds the remaining settings on top, in
`config/sites/<site>/settings.yaml` (or via the "Website-Einstellungen" backend module):

```yaml
sitekit.project.fax: '01234 / 567891'
sitekit.project.representative: 'Jane Doe'
sitekit.project.registerCourt: 'Amtsgericht Example'
sitekit.project.registerNumber: 'VR 1234'
sitekit.project.registerType: 'Eintragung im Vereinsregister'
sitekit.project.taxNumber: '123/456/78901'
sitekit.project.brand.logo.file.email: 'EXT:my_sitepackage/Resources/Public/Images/logo.png'
sitekit.project.brand.logo.file.emailDark: 'EXT:my_sitepackage/Resources/Public/Images/logo-dark.png'
```

`sitekit.project.brand.logo.file.email` must be a raster image (PNG/JPG) — email clients do not
reliably render SVG, unlike `sitekit.project.brand.logo.file.svg` used for the website itself.
`...emailDark` is optional; when unset, the light logo is reused for dark-mode clients too.

Any `FluidEmail`-based template that uses `<f:layout name="SystemEmail" />` — TYPO3 core system
notifications, EXT:form email finishers — then renders with this branding automatically. No
code changes or explicit variable assignment required.

### `<dmfh:siteSetting>` (standalone use)

The ViewHelper that powers the Layout above can also be used directly in any other `FluidEmail`
template, for settings this package doesn't define itself:

```html
<html xmlns:dmfh="http://typo3.org/ns/Dmfh/MailBranding/ViewHelpers">
    <dmfh:siteSetting path="sitekit.project.telephone" default="" />
</html>
```

It works without any explicit `assign()` call because `FluidEmail::setRequest()` already
stores the current PSR-7 request on the Fluid rendering context; this ViewHelper reads the
site (and its settings) from there.

Arguments:

| Argument  | Type   | Required | Description                                                  |
|-----------|--------|----------|----------------------------------------------------------------|
| `path`    | string | yes      | Dotted path into the site settings                             |
| `default` | mixed  | no       | Fallback when no site is resolvable or the setting is unset    |

## License

MIT — see [LICENSE](LICENSE)

## Author

Steffen Matthes — [dermatthes-frauhofer.de](https://dermatthes-frauhofer.de)