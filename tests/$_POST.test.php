<?php

// Usage:    /tests/$_POST.test.php | POST STRING: vid_id=*
// Example:  /tests/$_POST.test.php | POST STRING: vid_id=-YGDyPAwQz0

require('../ydp.class.php');

if (isset($_POST['vid_id'])) {
    new YDP($_POST['vid_id'], false);
} else {
    echo 'No ID Provided.';
}
