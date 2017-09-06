<?php

if (file_exists('../vendor/autoload.php')) {
    include '../vendor/autoload.php';
} else {
    include '../src/App.php';
    include '../src/Downloader.php';
}

if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
    header('Location: index.php');
}

$video = new pxgamer\YDP\Downloader($_REQUEST['id']);

if (!$video->status['success']) {
    header('Location: index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Youtube DL PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1><?= $video->info['title'] ?></h1>
    </div>

    <?php if (isset($video->rvs['iurlhq'])) { ?>
        <div class="form-group">
            <img class="img-thumbnail" src="<?= $video->rvs['iurlhq'] ?>"/>
        </div>
    <?php } ?>

    <table class="table">
        <tr>
            <th>
                Video ID
            </th>
            <td>
                <a target="_blank" href="<?= \pxgamer\YDP\App::YOUTUBE_URL ?>/watch/?v=<?= $video->info['video_id'] ?>">
                    <span><?= $video->info['video_id'] ?></span>
                    <span class="fa fa-fw fa-link"></span>
                </a>
            </td>
        </tr>
        <tr>
            <th>
                Uploaded By
            </th>
            <td>
                <a target="_blank" href="<?= \pxgamer\YDP\App::YOUTUBE_URL ?>/channel/<?= $video->info['ucid'] ?>">
                    <span><?= $video->info['author'] ?></span>
                    <span class="fa fa-fw fa-link"></span>
                </a>
            </td>
        </tr>
    </table>

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#main" aria-controls="main" role="tab" data-toggle="tab">Main Info</a>
        </li>
        <?php if (isset($_REQUEST['debug'])) { ?>
            <li role="presentation">
                <a href="#debug" aria-controls="debug" role="tab" data-toggle="tab">Debug Info</a>
            </li>
        <?php } ?>
    </ul>
    <br/>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="main">
            <table class="table table-hover">
                <tr>
                    <th>Quality <span class="fa fa-fw fa-hd-video"></span></th>
                    <th>Streams <span class="fa fa-fw fa-play-circle"></span></th>
                    <th>Downloads <span class="fa fa-fw fa-download"></span></th>
                </tr>
                <?php foreach ($video->formats as $f) { ?>
                    <tr>
                        <th>
                            <?= $f['quality'] ?>
                        </th>
                        <td>
                            <a target="_blank" href="<?= $f['url'] ?>">
                                <?= explode('/', $f['type'])[1] ?>
                            </a>
                        </td>
                        <td>
                            <a download href="<?= $f['url'] ?>">
                                <?= explode('/', $f['type'])[1] ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <?php if (isset($_REQUEST['debug'])) { ?>
            <div role="tabpanel" class="tab-pane" id="debug">
                <pre><?php var_dump($video) ?></pre>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>