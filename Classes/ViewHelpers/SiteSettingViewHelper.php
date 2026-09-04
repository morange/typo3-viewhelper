<?php

declare(strict_types=1);

namespace Dmfh\MailBranding\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Reads a typed TYPO3 site setting by dotted path.
 *
 * Unlike PAGEVIEW-rendered frontend templates, {@see \TYPO3\CMS\Core\Mail\FluidEmail}
 * does not automatically expose a `{settings}` variable. It does, however, store the
 * current PSR-7 request as a rendering-context attribute (via `FluidEmail::setRequest()`),
 * which is where the site (and its settings) are read from here — no explicit `assign()`
 * call is required in the calling code.
 *
 * Usage:
 * <dmfh:siteSetting path="sitekit.project.telephone" default="" />
 */
final class SiteSettingViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('path', 'string', 'Dotted path into the site settings, e.g. "sitekit.project.telephone"', true);
        $this->registerArgument('default', 'mixed', 'Fallback value when no site or setting is available', false, '');
    }

    public function render(): mixed
    {
        $request = $this->renderingContext->hasAttribute(ServerRequestInterface::class)
            ? $this->renderingContext->getAttribute(ServerRequestInterface::class)
            : null;

        $site = $request?->getAttribute('site');
        if (!$site instanceof Site) {
            return $this->arguments['default'];
        }

        return $site->getSettings()->get($this->arguments['path'], $this->arguments['default']);
    }
}