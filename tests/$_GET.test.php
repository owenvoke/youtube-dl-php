<?php

// Usage:    /tests/$_GET.test.php?vid_id=*
// Example:  /tests/$_GET.test.php?vid_id=-YGDyPAwQz0

require('../ydp.class.php');

if (isset($_GET['vid_id'])) {
    new YDP($_GET['vid_id'], false);
} else {
    echo 'No ID Provided.';
}