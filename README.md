# UriResolver

[![CircleCI](https://img.shields.io/circleci/build/github/tkr2f/uri-resolver.svg?style=flat-square)](https://circleci.com/gh/tkr2f/uri-resolver)
[![GitHub licence](https://img.shields.io/github/license/tkr2f/uri-resolver.svg?style=flat-square)](https://github.com/tkr2f/uri-resolver/blob/master/LICENSE)

Resolver of URI reference implemented based on RFC 3986.

```php
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
```

UriResolver requires PHP 7.2.0 or newer.

## Usage

Static call:

```php
UriResolverFactory::get()->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```

Instance:

```php
$uriResolver = new Tkr2f\UriResolver\UriResolver();
$uriResolver->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```

## Test

```
./test.sh
```
