<?php

use PHPUnit\Framework\TestCase;
use Tkr2f\UriResolver\UriResolver;
use Tkr2f\UriResolver\UriResolverFactory;

/**
 * Class UriResolverFactoryTest
 * @author Takashi Iwata <x.takashi.iwata.x@gmail.com>
 */
class UriResolverFactoryTest extends TestCase
{
    public function testGetMethodReturnUriResolverInstance(): void
    {
        $this->assertInstanceOf(UriResolver::class, UriResolverFactory::get());
    }

    public function testGetMethodReturnSameUriResolverInstance(): void
    {
        $uriResolver = UriResolverFactory::get();
        $this->assertSame($uriResolver, UriResolverFactory::get());
    }
}
