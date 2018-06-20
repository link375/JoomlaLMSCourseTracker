<?php 

defined('_JEXEC') or die;

//defined( '_JLMS_EXEC' ) or die( 'Restricted access' );


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
        width: 100%;
        margin: 5px;
}

</style>


<!-- html progress bar without values -->       

<div id="CourseTracker">
        <div id="progressBarTitle">Course Progress</div>
                <progress class="progressBar"></progress>
</div>

<!-- this is where we get our sample text--> 
<div class="total"></div>
<div class="current"></div>
<div class="percent"></div>
<div class="userID"></div>
<div class="courseID"></div>

<button id="ajaxButton" type="button">Refresh Progress Bar</button>

