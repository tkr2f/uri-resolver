# UriResolver

[![CircleCI](https://img.shields.io/circleci/build/github/tkr2f/uri-resolver.svg?style=flat-square)](https://circleci.com/gh/tkr2f/uri-resolver)
[![GitHub licence](https://img.shields.io/github/license/tkr2f/uri-resolver.svg?style=flat-square)](https://github.com/tkr2f/uri-resolver/blob/master/LICENSE)

Resolver of URI reference implemented based on RFC 3986.

The pattern of URI that can be resolved is based on RFC 3986, look at the test case.

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

## Tests

```
./test.sh
```
