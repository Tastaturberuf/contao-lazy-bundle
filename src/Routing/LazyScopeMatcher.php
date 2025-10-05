<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyDevBundle\Routing;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class LazyScopeMatcher
{

    public bool $isBackendRequest {
        get => $this->isBackendRequest();
    }

    public bool $isFrontendRequest {
        get => $this->isFrontendRequest();
    }

    public bool $isContaoRequest {
        get => $this->isContaoRequest();
    }

    public Request $request {
        get => $this->request ?? $this->requestStack->getCurrentRequest() ?? new Request();
        set => $value;
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
