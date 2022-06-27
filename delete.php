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

$courseid = required_param('id',PARAM_INT);
$eventid = required_param('event',PARAM_INT);
$PAGE -> set_url('/local/googleclass/delete.php', array('id' => $courseid,'event'=>$eventid));
GLOBAL $DB,$CFG;


//Obtenerlo de la base de datos
$event = $DB->get_record_sql('SELECT * FROM {googleclass} WHERE id = ?',[$eventid]);
//
$var = $CFG->local_googleclass_issuer;
$var = json_decode(json_encode($var),true);
$issuer_id = $DB->get_record_sql('SELECT id FROM {oauth2_issuer} WHERE name = :issuername;',['issuername' =>$var]);
$issuer = \core\oauth2\api::get_issuer($issuer_id->id);
// Put in the returnurl the course id and sesskey
$sesskey = sesskey();   
$params = array('id' => $courseid, 'sesskey' => $sesskey);
 // Get an OAuth client from the issuer
$returnurl  = new moodle_url('/local/googleclass/formPage.php',$params);
// Add all scopes for the API
$scopes = 'https://www.googleapis.com/auth/calendar';
$client = \core\oauth2\api::get_user_oauth_client($issuer, $returnurl , $scopes);

$service = new local_googleclass\rest($client);

$params = [
    'eventId' => $event->google_event_id,
];

$response = $service->call('delete',$params,[]); 
//Eliminarlo de la base de datos
if($DB->delete_records('googleclass', ['id'=>$event->id]) == TRUE){
    \core\notification::success(get_string('succesDeleteMessage','local_googleclass'),'local_googlecalendar');

}else{
    \core\notification::error(get_string('errorDeleteMessage','local_googleclass'),'local_googlecalendar');

}


//Volver
redirect($returnurl);

