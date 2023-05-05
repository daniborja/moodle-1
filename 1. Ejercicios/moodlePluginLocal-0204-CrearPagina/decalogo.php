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
// x default aqui NO es miltilenguaje
echo $OUTPUT->header();  // creacion del header
echo html_writer::tag('h2',"Decálogo del buen profesor");
echo html_writer::start_tag('ol');
echo html_writer::tag('li', "Demuestre interés en su materia: Si el profesor se aburre toda la clase se aburre.");
echo html_writer::tag('li', "Domine su materia: Si un tema no le interesa personalmente, no lo enseñe, porque usted no será capaz de enseñarlo adecuadamente.");
echo html_writer::tag('li', "Sea experto en las vías del conocimiento: el mejor medio para aprender algo es descubrirlo por sí mismo.");
echo html_writer::tag('li', "Trate de leer en el rostro de sus estudiantes, intente adivinar su esperanzas y sus dificultades; póngase en su lugar.");
echo html_writer::tag('li', "No les dé únicamente “saber” sino “saber hacer”- el hábito de un trabajo metódico: El conocimiento consiste, parte en “información” y parte en “saber hacer”");
echo html_writer::tag('li', "Enséñeles a conjeturar. Primero imaginar, después probar. Así es como procede el descubrimiento, en la mayor parte de los casos.");
echo html_writer::tag('li', "Enséñeles a demostrar: Las matemáticas son una buena escuela de razonamiento demostrativo.");
echo html_writer::tag('li', "En el problema que esté tratando, distinga lo que puede servir, más tarde a resolver otros problemas-intente revelar el modelo general que subyace en el fondo de la situación concreta que afronta: Cuando presente la solución de un problema, subraye sus rasgos instructivos.");
echo html_writer::tag('li', "No revele de pronto toda la solución; deje que los estudiantes hagan suposiciones, déjelos descubrir por sí mismos siempre que sea posible: Cuando se empieza a discutir la solución de un problema, deje que los estudiantes adivinen su solución.");
echo html_writer::tag('li', "No inculques por la fuerza, sugiere: Se trata de dejar a los estudiantes tanta libertad e iniciativa como sea posible, teniendo en cuenta las condiciones existentes de la enseñanza.");
echo html_writer::end_tag('ol');
echo $OUTPUT->footer();
