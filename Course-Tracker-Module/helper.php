<?php

defined('_JEXEC') or die;

/**
 * File       helper.php
 * Author     Nephi Andersen | support@pcturnaround.com | http://pcturnaround.com
 * Support    https://github.com/link375/
 * Copyright  Copyright (C) 2018 PCTurnaround llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */
class modJlmsCourseTrackerHelper
{
	public static function getAjax(){

    // get the course ID from the URI
    $url = $_SERVER['REQUEST_URI'];
    $regex = '/(?P<digit>\d+)/';

    if (preg_match($regex, $url, $matches, PREG_OFFSET_CAPTURE)){
        $courseID = $matches['0'][0];
    }
		else {
    	$courseID = 0;
    }

    // get the other variables
		$user = JLMSFactory::getUser();
		$userID = $user->id;
		$courseCompleted = false;
		$cert = NULL;
		$steps = array();
		$currentStep = 0;

		// connect to the database
		$db = JFactory::getDbo();

		/***************FIGURE OUT IF THE USER HAS COMPLETED THE COURSE *********/

		//select the crt date if it exists
		$query = "SELECT crt_date"
		. "\n FROM #__lms_certificate_users"
		. "\n WHERE user_id = " . $db->quote($userID)
		. "\n AND course_id = " . $db->quote($courseID)
		;

		// set the query
		$db->setQuery($query);

		/*
		get the data from the database
		we will check this later on
		if it is NULL the user has not completed the course
		if there is a cert date then the user has completed the course
		*/
		$cert = $db->loadResult();

		/************GET THE LEARNING PATH STEP IDS*********/

		/*
		query the db and ask for the ID ordered based on
		LP and then ordering - this should make all data consistent for all courses
		*/
		$query = "SELECT id"
		. "\n FROM #__lms_learn_path_steps"
		. "\n WHERE course_id = " . $db->quote($courseID)
		. "\n ORDER BY lpath_id, ordering ASC"
		;

		$db->setQuery($query);
		$steps = $db->loadColumn();

		/***************GET THE CURRENT STEP *************/

		/*
		this is used when a user is in the process of going through the course
		use this to check for the latest stepID in the highest incomplete path
		if none found it returns NULL
		*/
		$query = "SELECT last_step_id"
		. "\n FROM #__lms_learn_path_results"
		. "\n WHERE course_id = " . $db->quote($courseID)
		. "\n AND user_id = " . $db->quote($userID)
		. "\n AND user_status = 0"
		. "\n ORDER BY lpath_id DESC"
		;

		// set the query and get the data (single field)
		$db->setQuery($query);
		$currentStep = $db->loadResult();

		//this is used when a user has completed a learning path and hasn't completed the course
		// check the highest step id for the highest complete path
		if ($currentStep == NULL && $cert == NULL){
			$query = "SELECT MAX(last_step_id)"
			. "\n FROM #__lms_learn_path_results"
			. "\n WHERE course_id = " . $db->quote($courseID)
			. "\n AND user_id = " . $db->quote($userID)
			. "\n AND user_status = 1"
			. "\n ORDER BY lpath_id DESC"
			;

		$db->setQuery($query);
		$currentStep = $db->loadResult();
		}

		// this is used if a user has had steps in a higher learning path passed off
		// this will check for the highest ID in the last incomplete learning path
		elseif ($currentStep == 0 && $cert == NULL){
						$query = "SELECT MAX(last_step_id)"
						. "\n FROM #__lms_learn_path_results"
						. "\n WHERE course_id = " . $db->quote($courseID)
						. "\n AND user_id = " . $db->quote($userID)
						. "\n AND user_status = 0"
						. "\n ORDER BY lpath_id ASC"
						;

						$db->setQuery($query);
						$currentStep = $db->loadResult();

						// if a step ID still can't be found then look for an ID in the last completed learning path
						if ($currentStep == 0){
										 $query = "SELECT MAX(last_step_id)"
										. "\n FROM #__lms_learn_path_results"
										. "\n WHERE course_id = " . $db->quote($courseID)
										. "\n AND user_id = " . $db->quote($userID)
										. "\n AND user_status = 1"
										. "\n ORDER BY lpath_id DESC"
										;

										$db->setQuery($query);
										$currentStep = $db->loadResult();
						}
		}

		/***SET THE VALUE OF THE PROGRESS BAR TO THE LAST STEP ID IF THE COURSE IS COMPLETED *******/

		// Check the result or $cert and tell us if the user has completed the course or not
		if($cert != NULL){
						$courseCompleted = true;
						$currentStep = end($steps);
		}
		elseif ($cert == NULL){
						$courseCompleted = false;
		}

		/***************PREPARE DATA TO PASS TO HTML***********/

		// the total amount of steps
		$total = count($steps, COUNT_RECURSIVE) - 1;

		// the current step within the steps array indexes
		$current = array_search($currentStep, $steps);

		// what percentage does the current step make?
		$percent = round(($current/$total) * 100);


		/****SPECIAL CASES****/

		/***** USER IS ON THE LAST STEP AND DOES NOT HAVE A CERTIFICATE YET SET TO 99% *****/

		if (($cert == NULL && $currentStep == end($steps)) ||
				($cert == NULL && $percent == 100)){
						$total = 100;
						$current = 99;
						$percent = 99;
		}

		/**** IF THERE IS ONLY ONE STEP THE INDEX WILL BE 0 FOR THE STEPS ARRAY*********/
		// set the value to 100% if the user has a cert - otherwise keep it at 0.

		if (is_nan($percent) && $currentStep != NULL && $currentStep == $steps[0] && $cert != NULL){
						$percent = 100;
						$current = 1;
						$total = 1;
		}

		/****  USER HASN'T STARTED THE COURSE YET *******/

		// set their percent as 0 of 100%
		if ($currentStep == NULL && $courseCompleted == false){
			$percent = 0;
			$current = 0;
			$total = 100;
		}

		/** JSON ENCODING TO PASS TO AJAX REQUEST**/

		$progressBarValues = array(
			'total' => $total,
			'current' => $current,
			'percent' => $percent,
			'userID' => $userID,
      'courseID' => $courseID,
		);

		$results = json_encode($progressBarValues);

		return $results;

	}
}
