JoomlaLMS Course Tracker Module for Joomla CMS
=======================

A simple module to show the student how much progress they have completed in
the current course.

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

3. Go to the course where you would like to implement the Module

4. Edit the course and select "Couse Layout"

5. Add a module - you should see jlms_course_tracker at the bottom

6. Edit the title for your Module

7. Save

8. Profit


===========================

ADDITIONAL INFO

The stats will be refreshed using AJAX to query the database for the user's information within the given course. The ajax request will be triggered on the following events: ready, mousedown, mouseup
