<?php

declare(strict_types=1);

namespace Dmfh\MailBranding\ViewHelpers;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns the TYPO3 language key ("default", "de", ...) of the current site/request.
 *
 * f:translate's own automatic language detection goes through
 * {@see \TYPO3\CMS\Core\Localization\Locales::createLocaleFromRequest()}, which additionally
 * requires {@see \TYPO3\CMS\Core\Http\ApplicationType::fromRequest()} to report "frontend" -
 * that check does not hold for the request as it is passed through to FluidEmail (e.g. via
 * EXT:form's EmailFinisher), so f:translate silently falls back to the backend/CLI default
 * language (English without a backend user) even though the site/language request attributes
 * are present. This ViewHelper reads those same attributes directly, without that extra gate,
 * so <f:translate languageKey="{dmfh:siteLanguage()}"> resolves correctly.
 *
 * Usage:
 * <f:translate key="..." languageKey="{dmfh:siteLanguage()}" />
 */
final class SiteLanguageViewHelper extends AbstractViewHelper
{
    public function render(): string
    {
        $request = $this->renderingContext->hasAttribute(ServerRequestInterface::class)
            ? $this->renderingContext->getAttribute(ServerRequestInterface::class)
            : null;

        $language = $request?->getAttribute('language');
        if ($language instanceof SiteLanguage) {
            return $language->getTypo3Language();
        }

        $site = $request?->getAttribute('site');
        if ($site instanceof Site) {
            return $site->getDefaultLanguage()->getTypo3Language();
        }

        return 'default';
    }
}