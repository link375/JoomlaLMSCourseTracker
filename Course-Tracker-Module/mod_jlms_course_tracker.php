<?php

defined('_JEXEC') or die;

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

// js script to run when the mouse is moved
$js = <<<JS
(function ($) {
	$(document).on('ready mousedown mouseup', function () {
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
			}
		});
		return false;
	});
})(jQuery)
JS;

$doc->addScriptDeclaration($js);

require JModuleHelper::getLayoutPath('mod_jlms_course_tracker');
