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
 * Archivo de funciones auxiliares lib.php
 *
 * @package   local_bilingue
 * @copyright 2021 su nombre
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace local_bilingue;
class bilingue_string_manager extends \core_string_manager_standard { 

    /** 
    * Implementation of the get_string() method to display both simplified 
    * Chinese and UK English simultaneously. 
    * 
    * @param string $identifier the identifier of the string to search for 
    * @param string $component the component the string is provided by 
    * @param string|object|array $a optional data placeholder 
    * @param string $langmoodle translation language, null means use 
    * current 
    * @return string 
    */ 
    public function get_string($identifier, $component = '', $a = null, $lang = null) { 

        $string = parent::get_string($identifier, $component, $a, 'en'); 

        $es_mx = parent::get_string($identifier, $component, $a, 'es_mx'); 

        if(strlen($es_mx) > 0) { 
            $string .= ' | ' . $es_mx; 
        } 

        return $string; 
    } 
} 