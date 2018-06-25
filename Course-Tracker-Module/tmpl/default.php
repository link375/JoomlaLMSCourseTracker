<?php

defined('_JEXEC') or die;

/**
 * File       default.php
 * Author     Nephi Andersen | support@pcturnaround.com | http://pcturnaround.com
 * Support    https://github.com/link375/
 * Copyright  Copyright (C) 2018 PCTurnaround llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */

?>

<!-- CSS STYLING -->
<style type="text/css">

.courseTracker {
        width: 100%;
        height: 250px;
}

.progressBarTitle {
        color: #0088cc;
        font-size: 20px;
        text-align: center;
        font-weight: bold;
}

.progressBar {

        /* Reset the default appearance */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;

        width: 100%;
        height: 20px;
        margin: 5px;

        /* Firefox */
        border: none;
        background: #D3D3D3;
        border-radius: 3px;
        box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;
}

progress::-webkit-progress-bar {
        background: #D3D3D3;
        box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;
        border-radius: 3px;
}

progress::-webkit-progress-value {
        background-color: #FF9900;
        border-radius: 3px;
}

progress::-moz-progress-bar {
        background-color: #FF9900;
        border-radius: 3px;
}

.total {
        font-weight: bold;
        width: 100%;
        text-align: center;
}

.current {
        font-weight: bold;
        width: 100%;
        text-align: center;
}

.percent {
        font-size: 20px;
        font-weight: bold;
        width: 100%;
        text-align: center;
}

</style>

<!-- html progressbar -->

<div class="CourseTracker">
        <div class="progressBarTitle">Course Progress</div>
                <progress class="progressBar"></progress>
</div>

<div class="percent"></div>

<!-- DEBUGGING
<div class="total"></div>
<div class="current"></div>
<div class="userID"></div>
<div class="courseID"></div>
-->
