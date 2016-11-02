<?php

namespace Tkr2f\UriResolver;

/**
 * Class UriResolverFactory
 * @package Tkr2f\UriResolver
 * @author Takashi Iwata <x.takashi.iwata.x@gmail.com>
 */
class UriResolverFactory
{
    /**
     * @var UriResolver
     */
    private static $uriResolver = null;

    /**
     * @return UriResolver
     */
    public static function get()
    {
        if (is_null(self::$uriResolver)) {
            self::$uriResolver = new UriResolver();
        }

        return self::$uriResolver;
    }
}