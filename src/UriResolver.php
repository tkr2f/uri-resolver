<?php

namespace Tkr2f\UriResolver;

/**
 * Class UriResolver
 *
 * @package Tkr2f¥UriResolver
 * @author  Takashi Iwata <x.takashi.iwata.x@gmail.com>
 */
class UriResolver
{
    /**
     * @param string $baseUri
     * @param string $referenceUri
     *
     * @return string
     */
    public function resolve(string $baseUri, string $referenceUri): string
    {
        $baseUri = parse_url($baseUri);
        $referenceUri = parse_url($referenceUri);

        $targetUri = [];
        if (!isset($referenceUri['scheme']) or $referenceUri['scheme'] === '') {
            $targetUri = $this->caseNoScheme($baseUri, $referenceUri,
                $targetUri);
        } else {
            $targetUri['scheme'] = $referenceUri['scheme'];
            $targetUri['host'] = isset($referenceUri['host'])
                ? $referenceUri['host'] : '';
            $targetUri['path'] = isset($referenceUri['path'])
                ? $this->removeDotSegments($referenceUri['path']) : '';
            $targetUri['query'] = isset($referenceUri['query'])
                ? $referenceUri['query'] : '';
        }

        $targetUri['fragment'] = isset($referenceUri['fragment'])
            ? $referenceUri['fragment'] : '';

        return $this->recomposition($targetUri);
    }

    /**
     * @param $baseUri      array
     * @param $referenceUri array
     * @param $targetUri    array
     *
     * @return array
     */
    private function caseNoScheme($baseUri, $referenceUri, $targetUri)
    {
        $targetUri['scheme'] = $baseUri['scheme'];

        if (!isset($referenceUri['host']) or $referenceUri['host'] === '') {
            $targetUri = $this->caseNoHost($baseUri, $referenceUri, $targetUri);
        } else {
            $targetUri['host'] = $referenceUri['host'];
            $targetUri['path'] = isset($referenceUri['path'])
                ? $this->removeDotSegments($referenceUri['path']) : '';
            $targetUri['query'] = isset($referenceUri['query'])
                ? $referenceUri['query'] : '';
        }

        return $targetUri;

    }

    /**
     * @param $baseUri      array
     * @param $referenceUri array
     * @param $targetUri    array
     *
     * @return array
     */
    private function caseNoHost($baseUri, $referenceUri, $targetUri)
    {
        $targetUri['host'] = $baseUri['host'];

        if (!isset($referenceUri['path']) or $referenceUri['path'] === '') {
            $targetUri = $this->caseNoPath($baseUri, $referenceUri, $targetUri);
        } else {
            if (strpos($referenceUri['path'], '/') === 0) {
                $targetUri['path']
                    = self::removeDotSegments($referenceUri['path']);
            } else {
                $targetUri['path'] = self::mergePath($baseUri,
                    $referenceUri['path']);
                $targetUri['path']
                    = self::removeDotSegments($targetUri['path']);
            }

            $targetUri['query'] = isset($referenceUri['query'])
                ? $referenceUri['query'] : '';
        }

        return $targetUri;
    }

    /**
     * @param $baseUri      array
     * @param $referenceUri array
     * @param $targetUri    array
     *
     * @return array
     */
    private function caseNoPath($baseUri, $referenceUri, $targetUri)
    {
        $targetUri['path'] = $baseUri['path'];
        $targetUri['query'] = isset($referenceUri['query'])
            ? $referenceUri['query']
            : (isset($baseUri['query']) ? $baseUri['query'] : '');

        return $targetUri;
    }

    /**
     * @param $baseUri array
     * @param $path    string
     *
     * @return string
     */
    private function mergePath($baseUri, $path)
    {
        if (isset($baseUri['host']) and empty($baseUri['path'])) {
            return '/' . $path;
        }

        return preg_replace('#[^/]*$#', '', $baseUri['path']) . $path;
    }

    /**
     * @param $input string
     *
     * @return string
     */
    public function removeDotSegments($input)
    {
        $output = [];

        while ($input !== '') {
            // remove [../] [./]
            $regex = '#^(\.\.|\./)#u';
            if (preg_match($regex, $input) === 1) {
                $input = preg_replace($regex, '', $input);

                continue;
            }

            // replace [/./] [/.] to [/]
            // ref. RFC3986 appendix A
            $regex = '#^(/\./|(/\.)(?![\.\w\d\-._~%:?\#\[\]@!$&\'()*+,;=]))#u';
            if (preg_match($regex, $input) === 1) {
                $input = preg_replace($regex, '/', $input);

                continue;
            }

            // replace [/../] [/..] to [/]
            // ref. RFC3986 appendix A
            $regex
                = '#^(/\.\./|(/\.\.)(?![\.\w\d\-._~%:?\#\[\]@!$&\'()*+,;=]))#u';
            if (preg_match($regex, $input) === 1) {
                $input = preg_replace($regex, '/', $input);
                if (!empty($output)) {
                    $last = array_pop($output);
                    if ($last == '/') {
                        array_pop($output);
                    }
                }

                continue;
            }

            // remove [.] [..]
            $regex = '#^[\.]*$#u';
            if (preg_match($regex, $input) === 1) {
                $input = preg_replace($regex, '', $input);

                continue;
            }

            // move first segment
            $regex = '#^(/?[^/]*)#u';
            if (preg_match($regex, $input, $match) === 1) {
                if (!empty($match[1])) {
                    $output [] = $match[1];
                }
                $input = preg_replace($regex, '', $input);

                continue;
            }
        }

        return implode(array_filter($output));
    }

    /**
     * @param $targetUri array
     *
     * @return string
     */
    private function recomposition($targetUri)
    {
        $uri = '';

        if ($targetUri['scheme'] !== '') {
            $uri .= $targetUri['scheme'] . ':';
        }

        if ($targetUri['host'] !== '') {
            $uri .= '//' . $targetUri['host'];
        }

        if ($targetUri['path'] !== '') {
            $uri .= $targetUri['path'];
        }

        if ($targetUri['query'] !== '') {
            $uri .= '?' . $targetUri['query'];
        }

        if ($targetUri['fragment'] !== '') {
            $uri .= '#' . $targetUri['fragment'];
        }

        return $uri;
    }
}
