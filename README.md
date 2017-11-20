# youtube-dl-php

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Style CI][ico-styleci]][link-styleci]
[![Code Coverage][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A quick and easy YouTube downloader/parser written in PHP.

## Structure

```
public/
src/
tests/
vendor/
```

## Install

Via Composer

``` bash
$ composer create-project pxgamer/youtube-dl-php
```

## Usage

```php
$video = new pxgamer\YDP\Downloader(VIDEO_ID_OR_URL);
```

ID          | Default | Type    | Description
----------- | ------- | ------- | ------------
`$vid_id`   | ''      | String  | The ID or URL of the video, e.g. `-YGDyPAwQz0`

#### Related

[Live Demo](https://youtube-dl-php.pxgamer.xyz)
[User Script for YouTube](https://greasyfork.org/en/scripts/23560)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email owzie123@gmail.com instead of using the issue tracker.

## Credits

- [pxgamer][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/pxgamer/youtube-dl-php.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/pxgamer/youtube-dl-php/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/69379142/shield
[ico-code-quality]: https://img.shields.io/codecov/c/github/pxgamer/youtube-dl-php.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/pxgamer/youtube-dl-php.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/pxgamer/youtube-dl-php
[link-travis]: https://travis-ci.org/pxgamer/youtube-dl-php
[link-styleci]: https://styleci.io/repos/69379142
[link-code-quality]: https://codecov.io/gh/pxgamer/youtube-dl-php
[link-downloads]: https://packagist.org/packages/pxgamer/youtube-dl-php
[link-author]: https://github.com/pxgamer
[link-contributors]: ../../contributors
