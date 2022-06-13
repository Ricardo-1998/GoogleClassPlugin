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

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    //Add elements to form
    public function definition() {
       
        $mform = $this->_form; // Don't forget the underscore! 
        $current = $this->_customdata['current'];
        //Add elemente to get de days
        $days = array('MO'=>'Monday','TU'=>'Tuesday','WE'=>'Wednesday','TH'=>'Thursday','FR'=> 'Friday','SA'=> 'Saturday', 'SU'=>'Sunday');
        $select = $mform->addElement('select', 'days', 'days', $days);
        $select -> setMultiple(true);

        //Add element date start
        $mform->addElement('date_time_selector', 'dateStart', get_string('dateStart', 'local_googleclass'));

        //Add element date end
        $mform->addElement('date_selector', 'dateEnd', 'end');

        //Add element to get de duration of the event
        $mform->addElement('duration', 'duration', 'time');

        $mform->addElement('hidden', 'id', $current->id);
        $mform->setType('id', PARAM_INT);

        $this -> add_action_buttons();
        $this->set_data($current);
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}