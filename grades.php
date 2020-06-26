<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/blocks/coursegraph/lib.php');

define('USER_SMALL_CLASS', 20);   
define('USER_LARGE_CLASS', 200);  
define('DEFAULT_PAGE_SIZE', 20);
define('SHOW_ALL_PAGE_SIZE', 5000);

$id       = required_param('coursegraphid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$userid   = required_param('userid',PARAM_INT);
$page     = optional_param('page', 0, PARAM_INT); 
$perpage  = optional_param('perpage', DEFAULT_PAGE_SIZE, PARAM_INT); 
$group    = optional_param('group', 0, PARAM_INT); 

$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = block_coursegraph_course_context($courseid);

$loginblock = $DB->get_record('block_instances', array('id' => $id), '*', MUST_EXIST);
$loginsconfig = unserialize(base64_decode($loginblock->configdata));

$PAGE->set_course($course);

$PAGE->set_url(
    '/blocks/coursegraph/grades.php',
    array(
        'coursegraphid' => $id,
        'courseid' => $courseid,
        'page' => $page,
        'perpage' => $perpage,
        'group' => $group,
    )
);

$PAGE->set_context($context);
$title = 'Overview of Quiz Result';
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->navbar->add($title);

require_login($course, false);

echo $OUTPUT->header();
echo $OUTPUT->heading($title, 2);

echo $OUTPUT->container_start('block_coursegraph');

echo '<div class="grades">';

//block_graph_get_enrol_course($userid);
quiz($userid,$courseid);
//get_activity_details($userid,$courseid );
echo '</div>';

echo $OUTPUT->container_end();

echo $OUTPUT->footer();
