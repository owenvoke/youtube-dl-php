<?php

class YDP
{

    private $vid_id, $info_url = '';
    private $debug = false;
    private $info, $formats, $exploded_encodes = [];

    function __construct($vid_id = '', $debug = false)
    {
        $this->debug = $debug;
        $this->vid_id = $vid_id;
        $this->init();
        $this->display();
    }

    function init()
    {
        if (isset($this->vid_id) && $this->vid_id !== '') {
            if (preg_match('/^https:\/\/w{3}?.youtube.com\//', $this->vid_id)) {
                $url = parse_url($this->vid_id);
                $this->vid_id = NULL;
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
                        echo '<p>No video id passed in</p>';
                        exit;
                    }
                } else {
                    echo '<p>Invalid url</p>';
                    exit;
                }
            } elseif (preg_match('/^https?:\/\/youtu.be/', $this->vid_id)) {
                $this->vid_id = parse_url($this->vid_id);
                $this->vid_id = preg_replace('/^\//', '', $this->vid_id['path']);
            }
        } else {
            echo '<p>No video id passed in</p>';
            exit;
        }

        $this->info_url = 'https://www.youtube.com/get_video_info?&video_id=' . $this->vid_id . '&asv=3&el=detailpage&hl=en_US';
        $this->info_url = $this->GET($this->info_url);

        $url = $url_encoded_fmt_stream_map = $type = $title = '';
        parse_str($this->info_url, $this->info);

        $this->info = (object)$this->info;

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
            $this->formats[$i]['expires'] = date("G:i:s T", $expire);
            $this->formats[$i]['ipbits'] = $ipbits;
            $this->formats[$i]['ip'] = $ip;
            $i++;
        }

    }

    function GET($URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $tmp = curl_exec($ch);
        curl_close($ch);
        return $tmp;
    }

    function display()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <script src="https://code.jquery.com/jquery-3.1.1.min.js"
                    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
                  integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
                  crossorigin="anonymous">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
                    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                    crossorigin="anonymous"></script>
        </head>
        <body>
        <div class="container">
            <?php
            echo '<h1>' . $this->info->title . '</h1>
                    
                    <div class="form-group">
                        <img class="img-thumbnail" src="' . $this->info->iurlmq . '"/>
                    </div>
                          
                   <table class="table">
                      <tr>
                           <th>
                              Video ID
                           </th>
                           <td>
                           <a target="_blank" href="https://www.youtube.com/watch/?v=' . $this->info->video_id . '">' . $this->info->video_id . ' <span class="glyphicon glyphicon-link"></span></a>
                           </td>
                      </tr>
                      <tr>
                           <th>
                              Uploaded By
                           </th>
                           <td>
                            <a target="_blank"  href="https://www.youtube.com/channel/' . $this->info->ucid . '">' . $this->info->author . ' <span class="glyphicon glyphicon-link"></span></a>
                           </td>
                      </tr>
                   </table>
                   
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">Main Info</a></li>
                        ' . (($this->debug) ? '<li role="presentation"><a href="#debug" aria-controls="debug" role="tab" data-toggle="tab">Debug Info</a></li>' : '') . '
                    </ul>
                <br/>
                <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="main">
                   <table class="table table-hover">
                        <tr>
                            <th>Quality <span class="glyphicon glyphicon-hd-video"></span></th>
                            <th>Streams <span class="glyphicon glyphicon-play-circle"></span></th>
                            <th>Downloads <span class="glyphicon glyphicon-download"></span></th>
                        </tr>';
            foreach ($this->formats as $f) {
                echo '<tr><th>' . $f['quality'] . '</th><td><a target="_blank" href="' . $f['url'] . '">' . explode('/', $f['type'])[1] . '</a></td><td><a download href="' . $f['url'] . '">' . explode('/', $f['type'])[1] . '</a></td></tr>';
            }
            echo '</table></div>';

            if ($this->debug) {
                echo '<div role="tabpanel" class="tab-pane" id="debug"><pre>';
                var_dump($this);
                echo '</pre></div>';
            }
            echo '</div>';
            ?>
        </div>
        </body>
        </html>
        <?php
    }
}