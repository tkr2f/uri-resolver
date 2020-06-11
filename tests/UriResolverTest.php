<?php

use PHPUnit\Framework\TestCase;
use Tkr2f\UriResolver\UriResolver;

/**
 * Class UriResolverTest
 * @author Takashi Iwata <x.takashi.iwata.x@gmail.com>
 */
class UriResolverTest extends TestCase
{
    /**
     * @var UriResolver
     */
    protected $UriResolver;

    protected function setUp(): void
    {
        $this->UriResolver = new Tkr2f\UriResolver\UriResolver();
    }

    public function testResolveNormalPattern(): void
    {
        //RFC3986 5.4.1
        $this->assertEquals('g:h', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g:h'));
        $this->assertEquals('http://a/b/c/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g'));
        $this->assertEquals('http://a/b/c/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', './g'));
        $this->assertEquals('http://a/b/c/g/', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g/'));
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '/g'));
        $this->assertEquals('http://g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '//g'));
        $this->assertEquals('http://a/b/c/d;p?y', $this->UriResolver->resolve('http://a/b/c/d;p?q', '?y'));
        $this->assertEquals('http://a/b/c/g?y', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g?y'));
        $this->assertEquals('http://a/b/c/d;p?q#s', $this->UriResolver->resolve('http://a/b/c/d;p?q', '#s'));
        $this->assertEquals('http://a/b/c/g#s', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g#s'));
        $this->assertEquals('http://a/b/c/g?y#s', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g?y#s'));
        $this->assertEquals('http://a/b/c/;x', $this->UriResolver->resolve('http://a/b/c/d;p?q', ';x'));
        $this->assertEquals('http://a/b/c/g;x', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g;x'));
        $this->assertEquals('http://a/b/c/g;x?y#s', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g;x?y#s'));
        $this->assertEquals('http://a/b/c/d;p?q', $this->UriResolver->resolve('http://a/b/c/d;p?q', ''));
        $this->assertEquals('http://a/b/c/', $this->UriResolver->resolve('http://a/b/c/d;p?q', '.'));
        $this->assertEquals('http://a/b/c/', $this->UriResolver->resolve('http://a/b/c/d;p?q', './'));
        $this->assertEquals('http://a/b/', $this->UriResolver->resolve('http://a/b/c/d;p?q', '..'));
        $this->assertEquals('http://a/b/', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../'));
        $this->assertEquals('http://a/b/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../g'));
        $this->assertEquals('http://a/', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../..'));
        $this->assertEquals('http://a/', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../../'));
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../../g'));

        //additional
        $this->assertEquals('http://a/b/c#s', $this->UriResolver->resolve('http://a/b/c', '#s'));
    }

    public function testResolvePeculiarPattern(): void
    {
        //RFC3986 5.4.2
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../../../g'));
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '../../../../g'));
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '/./g'));
        $this->assertEquals('http://a/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '/../g'));
        $this->assertEquals('http://a/b/c/g.', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g.'));
        $this->assertEquals('http://a/b/c/.g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '.g'));
        $this->assertEquals('http://a/b/c/g..', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g..'));
        $this->assertEquals('http://a/b/c/..g', $this->UriResolver->resolve('http://a/b/c/d;p?q', '..g'));
        $this->assertEquals('http://a/b/g', $this->UriResolver->resolve('http://a/b/c/d;p?q', './../g'));
        $this->assertEquals('http://a/b/c/g/', $this->UriResolver->resolve('http://a/b/c/d;p?q', './g/.'));
        $this->assertEquals('http://a/b/c/g/h', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g/./h'));
        $this->assertEquals('http://a/b/c/h', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g/../h'));
        $this->assertEquals('http://a/b/c/g;x=1/y', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g;x=1/./y'));
        $this->assertEquals('http://a/b/c/y', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g;x=1/../y'));
        $this->assertEquals('http://a/b/c/g?y/./x', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g?y/./x'));
        $this->assertEquals('http://a/b/c/g?y/../x', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g?y/../x'));
        $this->assertEquals('http://a/b/c/g#s/./x', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g#s/./x'));
        $this->assertEquals('http://a/b/c/g#s/../x', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'g#s/../x'));
        $this->assertEquals('http:g', $this->UriResolver->resolve('http://a/b/c/d;p?q', 'http:g'));
    }

    public function testResolveAdditionalPattern(): void
    {
        // Uri resolving errors #2
        $this->assertEquals('http://localhost/bar/#', $this->UriResolver->resolve('http://localhost/bar/', '#'));
        $this->assertEquals('http://localhost/bar#', $this->UriResolver->resolve('http://localhost/bar', '#'));
        $this->assertEquals('http://localhost/bar#s', $this->UriResolver->resolve('http://localhost/bar', '#s'));
        $this->assertEquals('http://localhost/bar/#s', $this->UriResolver->resolve('http://localhost/bar/', '#s'));
        $this->assertEquals('http://localhost/bar?foo=1#', $this->UriResolver->resolve('http://localhost/bar?foo=1', '#'));
        $this->assertEquals('http://localhost?foo=2', $this->UriResolver->resolve('http://localhost?foo=1', '?foo=2'));
        $this->assertEquals('http://localhost?bar=2', $this->UriResolver->resolve('http://localhost?foo=1', '?bar=2'));
        $this->assertEquals('file:///foo', $this->UriResolver->resolve('file:///', '/foo'));
        $this->assertEquals('file:///foo', $this->UriResolver->resolve('file:///bar/baz', '/foo'));
        $this->assertEquals('file:///foo', $this->UriResolver->resolve('file:///', 'foo'));
        $this->assertEquals('file:///bar/foo', $this->UriResolver->resolve('file:///bar/baz', 'foo'));
    }
}
