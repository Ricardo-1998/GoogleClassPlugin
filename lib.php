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

defined('MOODLE_INTERNAL') || die();

function local_googleclass_extend_settings_navigation($settingsnav,$context){
    global $PAGE,$CFG;

    if(!$PAGE->course or $PAGE->course->id==1){
        return;
    }

    if(!has_capability(
        'moodle/backup:backupcourse',
        context_course::instance($PAGE->course->id))){
            return;
    }

    if(!empty($CFG->local_googlecalendar_remove)){
        return;
    }

    if($settingnode = $settingsnav->find('courseadmin',navigation_node::TYPE_COURSE)){
        $strfoo = get_string('pluginname','local_googleclass');
        $url = new moodle_url(
            '/local/googleclass/formPage.php',
            array('id'=> $PAGE->course->id)
        );
        $foonode = navigation_node::create(
            $strfoo,
            $url,
            navigation_node::NODETYPE_LEAF,
            'googleclass',
            'googleclass',
            new pix_icon('t/switch_plus', $strfoo)
        );
        if($PAGE->url->compare($url, URL_MATCH_BASE)){
            $foonode->make_active();
        }
        $settingnode->add_node($foonode);
    }
}