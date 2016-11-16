# UriResolver

It is implemented based on RFC 3986. Resolve URI reference.

The pattern of URI that can be resolved is based on RFC 3986, but if you want to know more concretely, look at the test case.

## Usage

For Static call:

```php
UriResolverFactory::get()->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```

For instance:

(You can use it when injecting instances with DI container etc.)
```php
$uriResolver = new Tkr2f\UriResolver\UriResolver();
$uriResolver->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```

## Note

This implementation relies on PHP's "parse_url" function.

In PHP 7.1, the behavior of "parse_url" function has been changed.

In the environment of PHP 7.1, it may not work.
