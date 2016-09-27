# YouTube Downloader [PHP]

A quick and easy YouTube downloader/parser written in PHP.

## Usage:

- `include` or `require` the `ydp.class.php` file  
- Call the `YDP` class using `$ydp = new YDP ('id');`

## Parameters:

#### `YDP Class -> __construct()`  

ID          | Default | Type    | Description
----------- | ------- | ------- | ------------
`$vid_id`   | ''      | String  | The ID of the video, e.g. `-YGDyPAwQz0`
`$download` | false   | Boolean | Whether the video should be downloaded or just to preview information
`$debug`    | false   | Boolean | Whether the class should be dumped with `var_dump`