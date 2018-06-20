<?php 

defined('_JEXEC') or die;

//defined( '_JLMS_EXEC' ) or die( 'Restricted access' );

/**
 * File       mod_jlms_course_tracker.php
 * Author     Nephi Andersen | support@pcturnaround.com | http://pcturnaround.com
 * Support    https://github.com/link375
 * Copyright  Copyright (C) 2018 PCTurnaround llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */

// Include the helper.
require_once __DIR__ . '/helper.php';

// Instantiate global document object
$doc = JFactory::getDocument();

// js script to run when the button is pressed
$js = <<<JS
(function ($) {
	$(document).on('click', '#ajaxButton', function () {
			request = {
					'option' : 'com_ajax',
					'module' : 'jlms_course_tracker',
					'format' : 'raw'
				};
		$.ajax({
			type   : 'POST',
			data   : request,
			success: function (response) {
				var results = JSON.parse(response);
				$('.progressBar').attr('max', results.total);
				$('.progressBar').attr('value', results.current);
				$('.current').html("Current step: " + results.current);
				$('.total').html("Total steps: " + results.total);
				$('.percent').html("Percent complete: " + results.percent + "%");
				$('.userID').html("userID: " + results.userID);
				$('.courseID').html("courseID: " +results.courseID);
			}
		});
		return false;
	});
})(jQuery)
JS;

$doc->addScriptDeclaration($js);


// js script to run automatically when the timer reaches 0
$js2 = <<<JS
(function ($) {
	$(document).on('load', '.progressBar', function () {
			request = {
					'option' : 'com_ajax',
					'module' : 'jlms_course_tracker',
					'format' : 'raw'
				};
		$.ajax({
			type   : 'POST',
			data   : request,
			success: function (response) {
				var results = JSON.parse(response);
				$('.progressBar').attr('max', results.total);
				$('.progressBar').attr('value', results.current);
				$('.current').html("Current step: " + results.current);
				$('.total').html("Total steps: " + results.total);
				$('.percent').html("Percent complete: " + results.percent + "%");
				$('.userID').html("userID: " + results.userID);
				$('.courseID').html("courseID: " +results.courseID);
			}
		});
		return false;
	});
})(jQuery)
JS;

$doc->addScriptDeclaration($js2);


require JModuleHelper::getLayoutPath('mod_jlms_course_tracker');