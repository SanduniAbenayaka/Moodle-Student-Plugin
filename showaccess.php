<?php
require_once(dirname(__FILE__) . '/../../config.php');


function get_date_options() {
    global $SITE,$month,$DB,$datesr;
    $days =30;
    
    $date =date('jS M Y');
    $d= new DateTime($date);
    $dates=array();
    for($i=0;$i<$days;$i++)
    {
        //$a=strtotime(yesterday);
        //echo date('d-M-Y',mktime(date("d")-1));
        $dates[$i] =$d->format('jS F Y');
        $d->modify('-1 day');

    }
    echo'<br>';
    for($i=0;$i<$days;$i++){
        $datesr=array_reverse($dates);
        $log['labels'][$i]=$datesr[$i];
    }
    echo'<br>';
    return $log['labels'];
}

// function block_graph_get_selected_semester($courseid){
//     global $DB,$course;
//     $course_id=$courseid;

//     $course = $DB->get_records_sql("SELECT category FROM {course} WHERE id='$course_id'");
    
//     foreach ($course as $c=>$fullname) {
//         $semester_id =$fullname->category; 
//         echo $semester_id; 
                   
// }

//     return $course_list;
// }

// function block_graph_get_semester_course($courseid){
//     global $DB,$course_list;
//     $course_list=array();
//     $i=0;
//     $course = $DB->get_records_sql("SELECT id FROM {course} WHERE category =(SELECT category FROM {course} WHERE id='$course_id')");
    
//     foreach ($course as $c=>$fullname) {
//         $course_list[$i] =$fullname->id;
//         $i++;   
                   
// }
//     return $course_list;
// }

//get courses names from course table
// function get_course_names($semester_id ){  

//     global $CFG,$DB,$i;
//     $label=array();
//     $label2=array();
//     $i=0;
   
//     $course_loga=$DB->get_records_sql("SELECT id,fullname,startdate,shortname FROM {course} WHERE category ='$semester_id' AND id IN '$course_elist'"); 
   
//     foreach ($course as $c=>$fullname) {
//             $label[$i] =$fullname->fullname;
//             $label2[$i] =$fullname->id;

//             $i++;              
//     }
  
//     return $label;
// }

function block_graph_get_enrol_course($userid,$courseid){
    global $DB,$course,$instance,$CFG,$semester_id,$course_elist;
    $userid=$userid;
    $course_id=$courseid;
    $label=array();
    $course_elist=array();
    $x=0;
    $i=0;
    //echo "sfgg";
    // $course_sem = $DB->get_records_sql("SELECT id,shortname FROM {role} ");
    // foreach($course_sem as $record_r=>$new_n)
    // {
    //     echo $semester_id=$new_n->id."........".$new_n->shortname;
    
    // }

    $sql1="SELECT * FROM {role_assignments} WHERE  roleid='5' AND userid='$userid';";
    $role = $DB->get_records_sql($sql1);
    foreach ($role as $renew=>$new)
    {
        $contextid1= $new->contextid;
        $instance= $DB->get_records_sql("SELECT instanceid FROM {context} WHERE id='$contextid1' AND contextlevel='50'");
        foreach($instance as $record=> $new ){
            $instanceid = $new->instanceid.'<br>';
            $course=$DB->get_records_sql("SELECT id,fullname,startdate,shortname FROM {course} WHERE id ='$instanceid'");
            foreach($course as $record=>$newid){
                $course_elist[$x]=$newid->id;
                $course_elist[$x].'<br>';
                $x++;
            }
        } 
    }  
    //return $course_elist;
    $course = $DB->get_records_sql("SELECT category FROM {course} WHERE id='$course_id'");
    
    foreach ($course as $c=>$fullname) {
        $semester_id =$fullname->category; 
        echo $semester_id; 
                   
    }
    $course_loga=$DB->get_records_sql("SELECT id,fullname,startdate,shortname FROM {course} WHERE category='$semester_id'  AND 
    id IN ('2','3','4')");

    /*$course_loga=$DB->get_records_sql("SELECT id,fullname,startdate,shortname FROM {course} WHERE category='$semester_id' AND 
    id IN 
    (SELECT id,fullname,startdate,shortname FROM {course} WHERE contextlevel='50' AND id IN
    (SELECT instanceid FROM {context} WHERE id IN 
    (SELECT * FROM {role_assignments} WHERE  roleid='5' AND userid='$userid')  )) "); */
   
    foreach ($course_loga as $c=>$fullname) {
            //$label[$i] =$fullname->fullname;
            echo $label[$i] =$fullname->id;

            $i++;              
    }
    return $label;
}

function get_course_names($subjects){  

    global $CFG,$DB,$i;
    $label=array();
    $i=0;
   
    $course=$DB->get_records_sql("SELECT fullname,startdate,shortname FROM {course} WHERE id IN ('2','3','4') "); 
   
    foreach ($course as $c=>$fullname) {
            $label[$i] =$fullname->fullname;
            $i++;              
    }
  
    return $label;
}
