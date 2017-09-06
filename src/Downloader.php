<?php

namespace pxgamer\YDP;

class Downloader
{

    public $vid_id, $info_url = '';
    public $info, $formats, $exploded_encodes, $status = [];

    public function __construct($vid_id = '')
    {
        $this->vid_id = $vid_id;
        $this->status = $this->init();
    }

    protected function init()
    {
        $matched = preg_match('/(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/',
            $this->vid_id, $matches);

        if (!$matched || empty($matches)) {
            return ['success' => false, 'error' => 'Invalid YouTube ID provided.'];
        }

        $this->vid_id = $matches[1];

        $this->info_url = App::YOUTUBE_URL . '/get_video_info?&video_id=' . $this->vid_id . '&asv=3&el=detailpage&hl=en_US';
        $this->info_url = $this->get($this->info_url);

        $url = $type = '';
        parse_str($this->info_url, $this->info);

        $this->info = (object)$this->info;
        if (!isset($this->info->url_encoded_fmt_stream_map)) {
            return ['success' => false, 'error' => 'Invalid YouTube ID provided.'];
        }

        $this->exploded_encodes = explode(',', $this->info->url_encoded_fmt_stream_map);

        $i = 0;
        $ipbits = $ip = $expire = $sig = $quality = $itag = '';
        foreach ($this->exploded_encodes as $format) {
            parse_str($format);
            $this->formats[$i]['itag'] = $itag;
            $this->formats[$i]['quality'] = $quality;
            $type = explode(';', $type);
            $this->formats[$i]['type'] = $type[0];
            $this->formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
            parse_str(urldecode($url));
            $this->formats[$i]['expires'] = date("G:i:s T", strtotime($expire));
            $this->formats[$i]['ipbits'] = $ipbits;
            $this->formats[$i]['ip'] = $ip;
            $i++;
        }

        return ['success' => true, 'error' => null];
    }

    protected function get($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $tmp = curl_exec($ch);
        curl_close($ch);
        return $tmp;
    }
}
