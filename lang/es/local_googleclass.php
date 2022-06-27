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

$string['dateStart']='Fecha de inicio';
$string['days']='Dias de clase';
$string['dateEnd']='Fecha final';
$string['duration']='Duración de la clase';
$string['noneselection']='Selecciona los dias de clase';

//Days
$string['MO']='Lunes';
$string['TU']='Martes';
$string['WE']='Miercoles';
$string['TH']='Jueves';
$string['FR']='Viernes';
$string['SA']='Sabado';
$string['SU']='Domingo';

//Rules
$string['validateDays']='Debes seleccionar al menos 1 dia';
$string['validateDuration']='El tiempo de duracion debe ser mayor a 0';
$string['validateDate']='La fecha final tiene que ser mayor que la fecha inicial';


//Table Headers
$string['colId']='Id';
$string['colDateStart']='Fecha inicio';
$string['colDateEnd']='Fecha final';
$string['colDuration']='Duracion en minutos';
$string['colEliminate']='Eliminar';

//Api response messages
$string['succesMessage']='Evento creado exitosamente';
$string['errorMessage']='Error al crear evento';

//DB response message
$string['succesDeleteMessage']='Evento eliminado exitosamente';
$string['errorDeleteMessage']='Error al eliminar el evento';