# UriResolver

Resolver of URI reference implemented based on RFC 3986. 

The pattern of URI that can be resolved is based on RFC 3986, look at the test case.

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

## Note

This implementation relies on PHP's "parse_url" function.

In PHP 7.1, the behavior of "parse_url" has been changed.

In the environment of PHP 7.1, it may not work.
