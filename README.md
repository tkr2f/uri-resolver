# UriResolver

Based on RFC3986.

## Usage

```php
UriResolverFactory::get()->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```
otherwise
```php
$uriResolver = new Tkr2f\UriResolver\UriResolver();
$uriResolver->resolve('http://a/b/c/d;p?q', '../../../g'); //return http://a/g
```
