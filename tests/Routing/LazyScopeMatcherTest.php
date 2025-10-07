<?php

declare(strict_types=1);

namespace Tastaturberuf\ContaoLazyBundle\Tests\Routing;

use Contao\CoreBundle\Routing\Matcher\BackendMatcher;
use Contao\CoreBundle\Routing\Matcher\FrontendMatcher;
use Contao\CoreBundle\Routing\ScopeMatcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tastaturberuf\ContaoLazyBundle\Routing\LazyScopeMatcher;

class LazyScopeMatcherTest extends TestCase
{

    private Request $backendRequest;
    private Request $frontendRequest;

    protected function setUp(): void
    {
        $this->backendRequest = new Request(attributes: ['_scope' => 'backend']);
        $this->frontendRequest = new Request(attributes: ['_scope' => 'frontend']);
    }

    public function testNonContaoRequests(): void
    {
        $scopeMatcher = $this->getScopeMatcher(new Request);

        $this->assertFalse($scopeMatcher->isBackendRequest());
        $this->assertFalse($scopeMatcher->isFrontendRequest());
        $this->assertFalse($scopeMatcher->isContaoRequest());
    }

    public function testContaoRequest(): void
    {
        $scopeMatcher = $this->getScopeMatcher($this->backendRequest);

        $this->assertTrue($scopeMatcher->isContaoRequest());
    }

    public function testBackendRequest(): void
    {
        $scopeMatcher = $this->getScopeMatcher($this->backendRequest);

        $this->assertTrue($scopeMatcher->isBackendRequest());
    }

    public function testFrontendRequest(): void
    {
        $scopeMatcher = $this->getScopeMatcher($this->frontendRequest);

        $this->assertTrue($scopeMatcher->isFrontendRequest());
    }

    private function getScopeMatcher(?Request $request = null): LazyScopeMatcher
    {
        $requestStack = new RequestStack();
        $requestStack->push($request ?? new Request());

        return new LazyScopeMatcher(new ScopeMatcher(
            new BackendMatcher(),
            new FrontendMatcher(),
            $requestStack // since Contao 5.4
        ), $requestStack);
    }

}
