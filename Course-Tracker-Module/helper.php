<?php 

defined('_JEXEC') or die;

//defined( '_JLMS_EXEC' ) or die( 'Restricted access' );

/**
 * File       helper.php
 * Author     Nephi Andersen | support@pcturnaround.com | http://pcturnaround.com
 * Support    https://github.com/link375/
 * Copyright  Copyright (C) 2018 PCTurnaround llc. All Rights Reserved.
 * License    GNU General Public License version 2, or later.
 */
class modJlmsCourseTrackerHelper
{
	public static function getAjax()
	{

		
        // get the course ID from the URI
        $url = $_SERVER['REQUEST_URI'];
        $regex = '/(?P<digit>\d+)/';

        if (preg_match($regex, $url, $matches, PREG_OFFSET_CAPTURE)){
            $courseID = $matches['0'][0];
        } else {
        	$courseID = 0;
        }

        // get the other variables
		$user = JLMSFactory::getUser();
		$userID = $user->id;
		$courseCompleted;
		$cert;
		$lpaths = array();
		$steps = array();
		$currentStep = 0;

		/***************FIGURE OUT IF THE USER HAS COMPLETED THE COURSE *********/

		// connect to the database
		$db = JFactory::getDbo();

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


		/**************GET THE LEARNING PATHS*************/

		// connect to the database
		$db = JFactory::getDbo();

		/*
		select learnpathIDs where courseID
		make sure they are in ascending order
		since the IDs should line up based on when the 
		path was created by the course creator 
		PHP will clean up duplicates automatically
		*/ 
		$query = "SELECT learn_path_id"
		. "\n FROM #__lms_gradebook_lpaths"
		. "\n WHERE course_id = " . $db->quote($courseID)
		. "\n ORDER BY learn_path_id ASC"
		;

		// set the lpaths ID query
		$db->setQuery($query);

		// get the data from the database and assign it to the lpaths
		$lpaths = $db->loadColumn();

		/************GET THE LEARNING PATH STEP IDS*********/

		// connect to the database
		$db = JFactory::getDbo();

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

		// connect to the database
		$db = JFactory::getDbo();

		/*
		this is used when a user is in the process of going through the course
		use this to check for the latest stepID
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
		if ($currentStep == NULL && $cert == NULL){
			$query = "SELECT MAX(last_step_id)"
			. "\n FROM #__lms_learn_path_results"
			. "\n WHERE course_id = " . $db->quote($courseID)
			. "\n AND user_id = " . $db->quote($userID)
			. "\n AND user_status = 1"
			. "\n ORDER BY lpath_id DESC"
			;

		// set the query and get the data (single field)
		$db->setQuery($query);
		$currentStep = $db->loadResult();
		}
		// this is used if a user has had steps in a higher learning path passed off 
		elseif ($currentStep == 0 && $cert == NULL){
			$query = "SELECT MAX(last_step_id)"
			. "\n FROM #__lms_learn_path_results"
			. "\n WHERE course_id = " . $db->quote($courseID)
			. "\n AND user_id = " . $db->quote($userID)
			. "\n AND user_status = 0"
			. "\n ORDER BY lpath_id ASC"
		;


		// set the query and get the data (single field)
		$db->setQuery($query);
			$currentStep = $db->loadResult();
		}

		/***SET THE VALUE OF THE PROGRESS BAR TO THE LAST STEP ID IF THE COURSE IS COMPLETED *******/

		// Check the result or $cert and tell us if the user has completed the course or not
		if($cert != NULL){
		$courseCompleted = true;
		}
		elseif ($cert == NULL){
			$courseCompleted = false;
		}

		// if the course is completed set the current step to be the last index in the $steps array
		if($courseCompleted == true){
			$currentStep = end($steps);
		}

		/***************PREPARE DATA TO PASS TO HTML***********/

		// the total amount of steps 
		$total = count($steps, COUNT_RECURSIVE) - 1;

		// the current step within the steps array indexes
		$current = array_search($currentStep, $steps);

		// what percentage does the current step make?
		$percent = round(($current/$total) * 100);


		/**** IF THERE IS ONLY ONE STEP THE INDEX WILL BE 0 FOR THE STEPS ARRAY so set it to 1*********/

		if (is_nan($percent) && $currentStep != NULL){
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
