<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Muestra el contenido de la página
 *
 * @package   local_decalogo
 * @copyright 2021 su nombre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');  // habilita los Objetos Globales:
global $DB, $OUTPUT, $PAGE;

// Verifique todas las variables requeridas.
$courseid = required_param('id', PARAM_INT); // get del courseId

require_login($courseid);	// verificar q esta logueado

// Definimos nuestra página
$PAGE->set_url('/local/decalogo/decalogo.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');	// trae el Layout 'standard' del theme utilizado, asi generara la pagina establecida dentro de los Layouts


// Determinar si es la primera vez que se accede (insertar) o 
// no es la primera vez (desplegar y actualizar).
// x default aqui NO es miltilenguaje, pero con estos    get_string    de la API String de Moode ya lo es
echo $OUTPUT->header();  // creacion del header
echo html_writer::tag('h2',get_string('title', 'local_decalogo'));
echo html_writer::start_tag('ol');
echo html_writer::tag('li', get_string('op1', 'local_decalogo'));
echo html_writer::tag('li', get_string('op2', 'local_decalogo'));
echo html_writer::tag('li', get_string('op3', 'local_decalogo'));
echo html_writer::tag('li', get_string('op4', 'local_decalogo'));
echo html_writer::tag('li', get_string('op5', 'local_decalogo'));
echo html_writer::tag('li', get_string('op6', 'local_decalogo'));
echo html_writer::tag('li', get_string('op7', 'local_decalogo'));
echo html_writer::tag('li', get_string('op8', 'local_decalogo'));
echo html_writer::tag('li', get_string('op9', 'local_decalogo'));
echo html_writer::tag('li', get_string('op10', 'local_decalogo'));
echo html_writer::end_tag('ol');
echo $OUTPUT->footer();
