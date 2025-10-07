<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\Routing;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * A utility class for managing request scopes and matching various request contexts.
 * Since Contao 5.4 you can use the Contao ScopeMatcher directly, but this class is still needed for older versions.
 */
final class LazyScopeMatcher
{

    private Request $request {
        get => $this->requestStack->getCurrentRequest() ?? new Request();
    }

    public function __construct(
        public readonly ScopeMatcher $scopeMatcher,
        public readonly RequestStack $requestStack,
    )
    {
    }

    public function isBackendRequest(?Request $request = null): bool
    {
        return $this->scopeMatcher->isBackendRequest($request ?? $this->request);
    }

    public function isFrontendRequest(?Request $request = null): bool
    {
        return $this->scopeMatcher->isFrontendRequest($request ?? $this->request);
    }

    public function isContaoRequest(?Request $request = null): bool
    {
        return $this->scopeMatcher->isContaoRequest($request ?? $this->request);
    }

}
