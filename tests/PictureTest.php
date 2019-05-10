<?php

namespace PictureExtension\Twig\Extension\Test;

use PHPUnit_Framework_TestCase;
use PictureExtension\Twig\Extension\Picture;

class PictureTest extends PHPUnit_Framework_TestCase
{
    protected $picture;

    /**
     * @dataProvider dataProvider
     */
    public function testPicture($expected, $filename, $imgAlt, $imgClass = null)
    {
        $this->assertEquals(
            $expected,
            $this->picture->picture($filename, $imgAlt, $imgClass)
        );
    }

    public function dataProvider()
    {
        return array(
            'png -> .webp, .png (image/png)' => array(
                '<picture><source srcset="/path/to/file.webp" type="image/webp"><source srcset="/path/to/file.png" type="image/png"><img src="/path/to/file.png" alt="Alt text"></picture>',
                '/path/to/file.png',
                'Alt text',
            ),
            '.jpg.png -> .webp, .jpg.png (image/png)' => array(
                '<picture><source srcset="/path/to/file.jpg.webp" type="image/webp"><source srcset="/path/to/file.jpg.png" type="image/png"><img src="/path/to/file.jpg.png" alt="Alt text"></picture>',
                '/path/to/file.jpg.png',
                'Alt text',
            ),
            '.jpg -> .webp, .jpg (image/jpeg)' => array(
                '<picture><source srcset="/path/to/file.webp" type="image/webp"><source srcset="/path/to/file.jpg" type="image/jpeg"><img src="/path/to/file.jpg" alt="Alt text"></picture>',
                '/path/to/file.jpg',
                'Alt text',
            ),
            '.png -> .webp, .png, with class' => array(
                '<picture><source srcset="/path/to/file.webp" type="image/webp"><source srcset="/path/to/file.jpg" type="image/jpeg"><img src="/path/to/file.jpg" alt="Alt text" class="foobar"></picture>',
                '/path/to/file.jpg',
                'Alt text',
                array('foobar'),
            ),
            '.gif -> .webp, .gif, with classes' => array(
                '<picture><source srcset="/path/to/file.webp" type="image/webp"><source srcset="/path/to/file.gif" type="image/gif"><img src="/path/to/file.gif" alt="Alt text" class="foo bar buz"></picture>',
                '/path/to/file.gif',
                'Alt text',
                array('foo', 'bar', 'buz'),
            ),
        );
    }

    protected function setUp()
    {
        $this->picture = new Picture();
    }
}
