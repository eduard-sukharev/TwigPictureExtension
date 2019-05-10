<?php

namespace PictureExtension\Twig\Extension;

use Twig_Extension;

/**
 * A Twig extension that creates <picture> tag with fallback <img> tag with single filepath.
 */
class Picture extends Twig_Extension
{
    private $mimeMap = array(
        'webp' => 'image/webp',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'jfif' => 'image/jpeg',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'qif' => 'image/x-quicktime',
        'qti' => 'image/x-quicktime',
        'qtif' => 'image/x-quicktime',
        'tif' => 'image/tiff',
    );

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'picture',
                array($this, 'picture'),
                array(
                    'is_safe' => array('html')
                )
            ),
        );
    }

    public function getName()
    {
        return 'picture';
    }

    /**
     * Creates <picture> tag with a set of sources (defaults to original and WebP sources) and fallback <img>
     *
     * @param $filename string Original image filename
     * @param $imgAlt string Alt text to be added to `alt` attribute of an `img` tag
     * @param $imgClasses array|string[] Array of classes to be added to `class` attribute of an `img` tag
     * @return string
     */
    public function picture($filename, $imgAlt, $imgClasses = array())
    {
        $pathinfo = pathinfo($filename);

        $result = '<picture>';
        $result .= sprintf('<source srcset="%s/%s.webp" type="image/webp">', $pathinfo['dirname'], $pathinfo['filename']);
        $result .= sprintf('<source srcset="%s" type="%s">', $filename, $this->getMimeType($filename));
        $result .= '<img ';
        $result .= sprintf('src="%s" alt="%s"', $filename, $imgAlt);
        $result .= $imgClasses ? sprintf(' class="%s"', implode(' ', $imgClasses)) : '';
        $result .= '>';
        $result .= '</picture>';

        return $result;
    }

    private function getMimeType($filename)
    {
        if (function_exists('mime_content_type') && is_readable($filename)) {
            return mime_content_type($filename);
        }
        $pathinfo = pathinfo($filename);
        if (array_key_exists($pathinfo['extension'], $this->mimeMap)) {
            return $this->mimeMap[$pathinfo['extension']];
        }

        return sprintf('image/%s', ltrim($pathinfo['extension'], '.'));
    }
}
