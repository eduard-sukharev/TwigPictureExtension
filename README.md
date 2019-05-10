TwigPictureExtension
=====================

A custom twig extension to add <picture> tags with multiple source type to aid new image types adoption (WebP now).

Installation
------------

Add the library to your app's `composer.json`:

```json
    "require": {
        "ed.sukharev/twig-picture-extension": "~1.0",
        ...
    }

```

Add the extension to the `Twig_Environment`:

```php

use PictureExtension\Twig\Extension\Picture;

$twig = new Twig_Environment(...);

$twig->addExtension(new Picture());
```

Usage
-----

The extension provides a `picture` twig function, which generates a **picture** tag with a set of **source**s and fallback **img** tag:

```twig
{{ picture('/img/path/filename.png', 'My image alt text') }}
```

Which creates following output:

```html
<picture>
    <source srcset="/img/path/filename.webp" type="image/webp">
    <source srcset="/img/path/filename.png" type="image/png">
    <img src="/img/path/filename.png" alt="My image alt text">
</picture>
```

### Arguments

The `picture` function accepts 3 arguments:

```php
picture($filename, $imgAlt, $imgClasses = [])
```

* **filename**: The filename of original image. Picture function substitutes the extension with appropriate when needed.
* **alt**: This is alternative text to be shown when image not available. Required so that you don't forget to add it.
* **imgClasses**: Array of strings to be added to `class` attribute of fallback `img` tag.


Symfony2
--------

### Add a service manually

```yaml
# app/config/config.yml

services:
    pciture_extension.twig.picture:
        class: PictureExtension\Twig\Extension\Picture
        tags:
            - { name: twig.extension }
```
