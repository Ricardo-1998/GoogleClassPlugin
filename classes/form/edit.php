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
        $days = array('MO'=>get_string('MO', 'local_googleclass'),'TU'=>get_string('TU', 'local_googleclass'),'WE'=>get_string('WE', 'local_googleclass'),'TH'=>get_string('TH', 'local_googleclass'),'FR'=> get_string('FR', 'local_googleclass'),'SA'=> get_string('SA', 'local_googleclass'), 'SU'=>get_string('SU', 'local_googleclass'));
        //$select = $mform->addElement('select', 'days', get_string('days', 'local_googleclass'), $days);
        //$select -> setMultiple(true);
        $options = array(
            'multiple' => true,
            'noselectionstring' => get_string('noneselection', 'local_googleclass'),
        );
        $mform->addElement('autocomplete', 'days', get_string('days', 'local_googleclass'), $days, $options);

        //Add element date start
        $mform->addElement('date_time_selector', 'dateStart', get_string('dateStart', 'local_googleclass'));

        //Add element date end
        $mform->addElement('date_selector', 'dateEnd', get_string('dateEnd', 'local_googleclass'));

        //Add element to get de duration of the event
        $mform->addElement('duration', 'duration', get_string('duration', 'local_googleclass'));

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