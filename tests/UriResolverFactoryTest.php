<?php

use Tkr2f\UriResolver\UriResolver;

/**
 * Class UriResolverFactoryTest
 * @author Takashi Iwata <x.takashi.iwata.x@gmail.com>
 */
class UriResolverFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodReturnUriResolverInstance()
    {
        $this->assertInstanceOf(UriResolver::class, \Tkr2f\UriResolver\UriResolverFactory::get());
    }
}