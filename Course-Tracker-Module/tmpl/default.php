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
<!-- OLD STUFF
<form>
	<input type="text" name="data">
	<input type="submit" />
</form>
<div class="status"></div>
-->

<!-- CSS STYLING -->

<style type="text/css">

#courseTracker {
        width: 100%;
        height: 250px;
}

#progressBarTitle {
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
        background: #EEE;
        border-radius: 3px;
        box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;

}

.progressBar progress::-webkit-progress-bar {
        background: #EEE;
        box-shadow: 0 2px 3px rgba(0,0,0,0.2) inset;
        border-radius: 3px;
}

.progressBar progress::-webkit-progress-value {
        background-color: #EEE;
        border-radius: 3px;
}

.progressBar progress::-moz-progress-bar {
        background-color: #EEE;
        border-radius: 3px;
}

#ajaxButton {
        display: inline-block;
        border-radius: 4px;
        background-color: #f4511e;
        border: none;
        color: #FFFFFF;
        text-align: center;
        font-size: 16px;
        padding: 10px;
        width: 100%;
        transition: all 0.5s;
        cursor: pointer;
        margin: 5px;
}

#ajaxButton span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
}

#ajaxButton span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -5px;
        transition: 0.5s;
}

#ajaxButton:hover span {
        padding-right: 5px;
}

#ajaxButton:hover span:after {
        opacity: 1;
        right: 0;
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
        font-weight: bold;
        width: 100%;
        text-align: center;
}

</style>



<!-- html progressbar -->

<div id="CourseTracker">
        <div id="progressBarTitle">Course Progress</div>
                <progress class="progressBar"></progress>
</div>

<!-- values
<div class="total"></div>
<div class="current"></div>
-->

<div class="percent"></div>

<!-- DEBUGGING
<div class="userID"></div>
<div class="courseID"></div>
<button id="ajaxButton" type="button">Check Course Progress</button>
-->
