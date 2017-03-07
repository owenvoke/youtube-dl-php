# YouTube Downloader [PHP]

A quick and easy YouTube downloader/parser written in PHP.

[![GitHub release](https://img.shields.io/github/release/PXgamer/youtube-dl-php.svg)](https://github.com/PXgamer/youtube-dl-php/releases/latest) [![Scrutinizer Build](https://img.shields.io/scrutinizer/build/g/PXgamer/youtube-dl-php.svg)](https://scrutinizer-ci.com/g/PXgamer/youtube-dl-php/build-status/master) [![SensioLabs Insight](https://img.shields.io/sensiolabs/i/6d27dff5-bbde-414d-b45e-9a2d51b6dc6b.svg)](https://insight.sensiolabs.com/projects/6d27dff5-bbde-414d-b45e-9a2d51b6dc6b)

Demo: https://youtube-dl-php.pxgamer.xyz

## Usage:

- Install via Composer using `composer require pxgamer/youtube-dl-php`
- Require the `src/App.php` and `src/Downloader.php` files

Then call the `Downloader` class using:
```php
$video = new pxgamer\YDP\Downloader(VIDEO_ID_OR_URL);
```

## Parameters:

#### `YDP Class -> __construct()`  

ID          | Default | Type    | Description
----------- | ------- | ------- | ------------
`$vid_id`   | ''      | String  | The ID or URL of the video, e.g. `-YGDyPAwQz0`

## Example

![Example Image](https://cdn.pximg.xyz/ced3b11ae13747a506e4a74525b03eae.png)

## Related

[youtube-dl-php User Script](https://greasyfork.org/en/scripts/23560)  
[![On YouTube](https://cdn.pximg.xyz/e891e90ea61b38121245472727470565.png)](https://greasyfork.org/en/scripts/23560)  
