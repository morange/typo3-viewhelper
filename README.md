# dmfh/typo3-mail-branding

Settings-driven system-email branding for TYPO3 v14+. Pull this in as a Composer dependency
instead of copying a `SystemEmail.fluid.html` override, footer XLIFF labels, and typed site
settings into every site package by hand.

---

## What it provides

- A **TYPO3 Site Set** (`Configuration/Sets/MailBranding/`) with typed settings for a
  system-email logo and legal/contact footer (organization name, address, phone, fax, email,
  representative, register court/number/type, tax number) — editable per site in the TYPO3
  backend "Website-Einstellungen" module once a site depends on the set.
- A **Fluid Layout** (`Resources/Private/Layouts/SystemEmail.fluid.html`) — a fork of
  `EXT:core`'s default system-email layout with the logo and footer driven by those settings.
  Falls back to TYPO3's own default logo/branding logic when no custom logo is configured.
- The **`<dmfh:siteSetting>` ViewHelper**, which reads a typed site setting inside `FluidEmail`
  templates — a context where TYPO3 does not automatically expose a `{settings}` Fluid variable.

## Requirements

| Requirement        | Version |
|---------------------|---------|
| TYPO3                | ^14.3   |
| PHP                  | ^8.3    |
| typo3fluid/fluid     | ^5.0    |

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

Then provide the actual values in your site package's `settings.yaml` (or let editors fill
them in via the site settings backend module):

```yaml
mailBranding:
  logo:
    path: 'EXT:my_sitepackage/Resources/Public/Images/logo.png'
    alt: 'My Organization'
  footer:
    organizationName: 'My Organization e.V.'
    street: 'Example Street 1'
    postalCode: '01234'
    city: 'Example City'
    phone: '01234 / 567890'
    fax: '01234 / 567891'
    email: 'info@example.org'
    representative: 'Jane Doe'
    registerCourt: 'Amtsgericht Example'
    registerNumber: 'VR 1234'
    registerType: 'Eintragung im Vereinsregister'
    taxNumber: '123/456/78901'
```

Any `FluidEmail`-based template that uses `<f:layout name="SystemEmail" />` — TYPO3 core system
notifications, EXT:form email finishers — then renders with this branding automatically. No
code changes or explicit variable assignment required.

### `<dmfh:siteSetting>` (standalone use)

The ViewHelper that powers the Layout above can also be used directly in any other `FluidEmail`
template, for settings this package doesn't define itself:

```html
<html xmlns:dmfh="http://typo3.org/ns/Dmfh/MailBranding/ViewHelpers">
    <dmfh:siteSetting path="mailBranding.footer.phone" default="" />
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