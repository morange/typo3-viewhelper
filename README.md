# dmfh/typo3-viewhelper

Shared collection of reusable Fluid ViewHelpers for TYPO3 v14+ projects. Pull this in as a
Composer dependency instead of re-implementing the same ViewHelper in every site package.

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
composer require dmfh/typo3-viewhelper
```

The package is a composer-mode-only TYPO3 extension (no `ext_emconf.php` needed) with
extension key `dmfh_viewhelper`.

## ViewHelpers

### `<dmfh:siteSetting>`

Reads a typed TYPO3 site setting by dotted path, for use in contexts where TYPO3 does not
automatically expose a `{settings}` Fluid variable — most notably `FluidEmail`-based email
templates (system emails, EXT:form finisher emails), which only get `{settings}` when the
calling code explicitly assigns it.

It works without any explicit `assign()` call because `FluidEmail::setRequest()` already
stores the current PSR-7 request on the Fluid rendering context; this ViewHelper reads the
site (and its settings) from there.

```html
<html xmlns:dmfh="http://typo3.org/ns/Dmfh/ViewHelper/ViewHelpers">
    <dmfh:siteSetting path="mail.footer.phone" default="" />
</html>
```

Arguments:

| Argument  | Type   | Required | Description                                              |
|-----------|--------|----------|------------------------------------------------------------|
| `path`    | string | yes      | Dotted path into the site settings                        |
| `default` | mixed  | no       | Fallback when no site is resolvable or the setting is unset |

## Versioning

Tag releases as `vMAJOR.MINOR.PATCH`. Consuming projects pin a version constraint in their
own `composer.json`.