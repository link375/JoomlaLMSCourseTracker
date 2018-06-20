JoomlaLMS Course Tracker Module for Joomla CMS
=======================

A simple module to show the student how much progress they have completed in
the current course.

=======================

REQUIREMENTS

Joomla: 3.6.5 or greater

JoomlaLMS: 2.1.3 or greater

=======================

SETUP

1. In /components/com_joomla_lms/configs/ Replace your existing config.lms_module.json file with the one provided

or add the following entry to your JSON file

{
      "module": "mod_jlms_course_tracker",
      "allowincoursebuilder": "1",
      "singleinstance": "1"
}

This will allow you to use the module within JoomlaLMS' courses.

2. Install the prepackaged zip file like any other joomla Module

    if you would like to modify the code just download the Course-Tracker-Module directory, modify your code and package it as a zip file to upload to joomla.

3. Go to the course where you would like to implement the Module

4. Edit the course and select "Couse Layout"

5. Add a module - you should see jlms_course_tracker at the bottom

6. Edit the title for your Module

7. Save

8. Profit


===========================

TECHNICAL INFO

mod_jlms_course_tracker.xml

Tells joomla how to handle the package during the installation process.

helper.php

Gathers all of the required data from the database and returns the variables as a json encoded array.

mod_jlms_course_tracker.php

Actively monitors the DOM for ready, mousedown, mouseup events. When they are executed an ajax call is made the the helper.php file through joomla's com_ajax module. The returned values from the ajax call are then inserted into the html elements on default.php. This file will also set the default.php file as the template to be rendered when the module is in use.

default.php

Creates an html template with inline css to keep it simple
