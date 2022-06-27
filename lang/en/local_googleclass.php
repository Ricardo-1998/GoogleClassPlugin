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
 * @copyright   2022 Javier Mejia
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname']='Google class';

$string['title']='Google Class';
$string['dateStart']='Start Date';
$string['days']='Class Days';
$string['dateEnd']='End Date';
$string['duration']='Class Duration';
$string['noneselection']='Select class days';

//days
$string['MO']='Monday';
$string['TU']='Tuesday';
$string['WE']='Wednesday';
$string['TH']='Thursday';
$string['FR']='Friday';
$string['SA']='Saturday';
$string['SU']='Sunday';

//Rules
$string['validateDays']='You need to select at least 1 day';
$string['validateDuration']='The duration time has to be more than 0';
$string['validateDate']='The final date has to be greater than the initial date';


//Table Headers
$string['colId']='Id';
$string['colDateStart']='Date Start';
$string['colDateEnd']='Date End';
$string['colDuration']='Duration in minutes';
$string['colEliminate']='Eliminate';

//Api response messages
$string['succesMessage']='Event created successfully';
$string['errorMessage']='Error creating event';

//DB response message
$string['succesDeleteMessage']='Event deleted successfully';
$string['errorDeleteMessage']='Error deleting event';