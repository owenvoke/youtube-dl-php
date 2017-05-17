# YouTube Downloader [PHP]

A quick and easy YouTube downloader/parser written in PHP.

Demo: https://youtube-dl-php.pxgamer.xyz

## Usage:

- Start a new instance of the site with Composer using `composer create-project pxgamer/youtube-dl-php`
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

## Related

[User Script for YouTube](https://greasyfork.org/en/scripts/23560)
