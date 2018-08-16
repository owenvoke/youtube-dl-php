<?php

namespace pxgamer\YDP;

/**
 * Class Downloader
 */
class Downloader
{
    /**
     * Constant base URL for YouTube
     */
    const YOUTUBE_URL = 'https://www.youtube.com';

    /**
     * @var string
     */
    public $info_url;
    /**
     * @var string
     */
    public $vid_id;
    /**
     * @var array
     */
    public $info;
    /**
     * @var array
     */
    public $formats;
    /**
     * @var array
     */
    public $exploded_encodes;
    /**
     * @var array
     */
    public $status;
    /**
     * @var array
     */
    public $rvs;

    /**
     * Downloader constructor.
     * @param string $vid_id
     */
    public function __construct($vid_id = '')
    {
        $this->vid_id = $vid_id;
        $this->status = $this->init();
    }

    /**
     * Populate the class variables based on the provided ID.
     * @return array
     */
    protected function init()
    {
        $matched = preg_match(
            '/(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)?([a-zA-Z0-9_-]{6,11})/',
            $this->vid_id,
            $matches
        );

        if (!$matched || empty($matches)) {
            return [
                'success' => false,
                'error'   => 'Invalid YouTube ID provided.',
            ];
        }

        $this->vid_id = $matches[1];

        $this->info_url = self::YOUTUBE_URL.'/get_video_info?&video_id='.$this->vid_id.'&asv=3&el=detailpage&hl=en_US';
        $this->info_url = $this->get($this->info_url);

        parse_str($this->info_url, $this->info);

        if (!isset($this->info['url_encoded_fmt_stream_map'])) {
            return [
                'success' => false,
                'error'   => 'Invalid YouTube ID provided.',
            ];
        }

        $this->exploded_encodes = explode(
            ',',
            $this->info['url_encoded_fmt_stream_map']
        );

        $i = 0;
        foreach ($this->exploded_encodes as $format) {
            parse_str($format, $formatData);
            $this->formats[$i]['itag'] = $formatData['itag'];
            $this->formats[$i]['quality'] = $formatData['quality'];

            $type = explode(';', $formatData['type']);
            $this->formats[$i]['type'] = $type[0];
            $this->formats[$i]['url'] = urldecode($formatData['url']);

            parse_str(urldecode($formatData['url']), $urlSegments);
            $this->formats[$i]['expires'] = date("G:i:s T", strtotime($urlSegments['expire']));
            $this->formats[$i]['ipbits'] = $urlSegments['ipbits'];
            $this->formats[$i]['ip'] = $urlSegments['ip'];
            $i++;
        }

        if (isset($this->info['rvs'])) {
            parse_str($this->info['rvs'], $this->rvs);
        }

        return [
            'success' => true,
            'error'   => null,
        ];
    }

    /**
     * Run a cURL request to a URL.
     * @param string $URL
     * @return mixed
     */
    protected function get($URL)
    {
        $connection = curl_init();
        curl_setopt_array($connection, [
            CURLOPT_URL            => $URL,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => 1,
        ]);

        $response = curl_exec($connection);
        curl_close($connection);

        return $response;
    }
}
