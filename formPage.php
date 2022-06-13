<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_googleclass
 * @copyright   2022 Ricardo Villeda
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once("$CFG->libdir/tablelib.php");
require_once($CFG -> dirroot . '/local/googleclass/classes/form/table.php');
require_once($CFG -> dirroot . '/local/googleclass/classes/form/edit.php');
global $DB,$OUTPUT,$PAGE;

$courseid = required_param('id',PARAM_INT);
require_login($courseid);

$PAGE -> set_url('/local/googleclass/formPage.php', array('id' => $courseid));

$PAGE -> set_pagelayout('standard');
$PAGE -> set_title(get_string('title','local_googleclass'));

$querycourse = $DB->get_records_sql('SELECT * FROM {googleclass} WHERE course = ?;',[$courseid]);
//display our form
$mform = new edit();
$mform->set_data(array('id'=>$courseid));


// Work out the sql for the table.
$table = new test_table('uniqueid');
$table->set_sql('id,datestart,dateend,course', "{googleclass}", 'course=:course',['course'=>$courseid]);
$table->define_baseurl("$CFG->wwwroot/local/googleclass/table.php");

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Code for go back to the course
    $sesskey = sesskey();
    $params = array('id' => $courseid, 'sesskey' => $sesskey);
    redirect(new moodle_url('/course/view.php',$params));

} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.
    $recurrence = createRule($fromform);

    $recordinsert = new stdClass();
    $end = new stdClass();
    $start = new stdClass();

    $querycourse = $DB->get_record_sql('SELECT * FROM {course} WHERE id = ?;',[$courseid]);

    $recordinsert -> course = $courseid;
    $recordinsert -> dateend = gmdate("Ymd",$fromform->dateEnd);
    $recordinsert -> datestart = gmdate("Y-m-d",$fromform->dateStart) .'T'. gmdate("H:i:s.000",$fromform->dateStart).'Z';
    $recordinsert -> days = $recurrence;
    $recordinsert -> coursename = $querycourse->fullname;
    $recordinsert -> duration = $fromform->duration;
    $summary = $querycourse->fullname;

    $end -> dateTime = gmdate("Y-m-d",($fromform->dateStart + $fromform->duration)) .'T'. gmdate("H:m:s.000",($fromform->dateStart + $fromform->duration)).'Z';
    $end -> timeZone = "America/El_Salvador";


    $start -> dateTime = gmdate("Y-m-d",$fromform->dateStart) .'T'. gmdate("H:m:s.000",$fromform->dateStart).'Z';
    $start -> timeZone = "America/El_Salvador";

    $context = context_course::instance($courseid);
    //Get all users in the course
    $submissioncandidates = get_enrolled_users($context, $withcapability = '', $groupid = 0, $userfields = 'u.*', $orderby = '', $limitfrom = 0, $limitnum = 0);
    //Save each users email in array attendees 
    $attendees = [];
    foreach ($submissioncandidates as $d){
        $attendee = new stdClass();
        $attendee->email = $d->email;
        array_push($attendees,$attendee);
    } 
  
    //API CALL
    
    $var = $CFG->local_googleclass_issuer;
    $var = json_decode(json_encode($var),true);
    $issuer_id = $DB->get_record_sql('SELECT id FROM {oauth2_issuer} WHERE name = :issuername;',['issuername' =>$var]);
    $issuer = \core\oauth2\api::get_issuer($issuer_id->id);

    // Put in the returnurl the course id and sesskey
    $sesskey = sesskey();   
    $params = array('id' => $courseid, 'sesskey' => $sesskey);
    // Get an OAuth client from the issuer
    $returnurl  = new moodle_url('/course/view.php',$params);
    // Add all scopes for the API
    $scopes = 'https://www.googleapis.com/auth/calendar';
    $client = \core\oauth2\api::get_user_oauth_client($issuer, $returnurl , $scopes);
    // Check the google session
    if (!$client->is_logged_in()) {
        redirect($client->get_login_url());
    }else{   
        $service = new local_googleclass\rest($client);
        $params = [
            'summary' => $summary,
            'end' => $end,
            'start' => $start,
            'attendees' => $attendees,
            'recurrence' => array($recurrence),
        ];
        //If the google calendat event is new create one otherwise update it
        $response = $service->call('insert',[],json_encode($params)); 
        $JSON_response = json_decode($response);
                    
        $recordinsert->google_event_id = $JSON_response->id;
        $DB -> insert_record('googleclass', $recordinsert);    
    }

}

function createRule($fromform){
    $baseRule = "RRULE:FREQ=WEEKLY;UNTIL=";
    $until = gmdate("Ymd",$fromform->dateEnd);
    $array = $fromform->days;
    $temp = "";
    foreach ($array as $value){
        $temp = $temp . $value . ",";
    }
    $temp = rtrim($temp,",");
    $byDay = ";BYDAY=" . $temp;
    $finalRule = $baseRule . $until . $byDay;
    return $finalRule;

}

//Display header
echo $OUTPUT->header();
echo html_writer::tag('h2',get_string('title','local_googleclass'));
$mform -> display();
$table->out(40, true);
echo $OUTPUT -> footer();
