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
        if (isset($this->vid_id) && $this->vid_id !== '') {
            if (preg_match('/^https:\/\/w{3}?.youtube.com\//', $this->vid_id)) {
                $url = parse_url($this->vid_id);
                $this->vid_id = null;
                if (is_array($url) && count($url) > 0 && isset($url['query']) && !empty($url['query'])) {
                    $parts = explode('&', $url['query']);
                    if (is_array($parts) && count($parts) > 0) {
                        foreach ($parts as $p) {
                            $pattern = '/^v\=/';
                            if (preg_match($pattern, $p)) {
                                $this->vid_id = preg_replace($pattern, '', $p);
                                break;
                            }
                        }
                    }
                    if (!$this->vid_id) {
                        return ['status' => 'failed', 'error' => 'no video id passed in'];
                    }
                } else {
                    return ['status' => 'failed', 'error' => 'invalid url'];
                }
            } elseif (preg_match('/^https?:\/\/youtu.be/', $this->vid_id)) {
                $this->vid_id = parse_url($this->vid_id);
                $this->vid_id = preg_replace('/^\//', '', $this->vid_id['path']);
            }
        } else {
            return ['status' => 'failed', 'error' => 'no video id passed in'];
        }

        $this->info_url = App::YOUTUBE_URL . '/get_video_info?&video_id=' . $this->vid_id . '&asv=3&el=detailpage&hl=en_US';
        $this->info_url = $this->get($this->info_url);

        $url = $type = '';
        parse_str($this->info_url, $this->info);

        $this->info = (object)$this->info;
        if (!isset($this->info->url_encoded_fmt_stream_map)) {
            return ['status' => 'failed', 'error' => 'invalid id'];
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

        return ['status' => 'success', 'error' => false];
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
