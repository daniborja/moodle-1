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
 * Settings for the HTML block
 *
 * @copyright 2021 Su nombre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package   local_bilingual
 */

defined('MOODLE_INTERNAL') || die;

// Asegúrese de que las configuraciones para este sitio estén establecidas
if ($hassiteconfig) {
    // Crea la nueva página de configuración
    // - en un plugin local esto no está definido como estándar
    $settings = new admin_settingpage( 
        'local_bilingual', 
        get_string('settingbilingual', 'local_bilingual') 
    );

    // Crear la opción en admin
    $ADMIN->add( 'localplugins', $settings );

    // Agregar un campo de configuración a la configuración de esta página
    $settings->add(
        new admin_setting_configcheckbox(
            'local_bilingual/remove', 
            get_string('removebilingual', 'local_bilingual')
        )
    );
    // 
    $languages = get_string_manager()->get_list_of_translations(); 
    $currentlang = current_language();
    //
    $settings->add(
        new admin_setting_configselect(
            'local_bilingue/primarylanguage', 
            get_string('primarylang', 'local_bilingue'), 
            get_string('primarylang_desc', 'local_bilingue'), 
            $currentlang, 
            $languages
        )
    ); 
    //
    $settings->add(
        new admin_setting_configselect(
            'local_bilingue/secondarylanguage',   
            get_string('secondarylang', 'local_bilingue'), 
            get_string('secondarylang_desc', 'local_bilingue'), 
            $currentlang, 
            $languages
        )
    ); 
}






