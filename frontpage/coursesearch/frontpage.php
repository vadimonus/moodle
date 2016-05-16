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
 * The frontpage area showing course search field.
 *
 * @package    frontpage_coursesearch
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/frontpage/frontpagebase.php');

/**
 * The class for frontpage area showing course search field.
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontpage_coursesearch extends frontpage_base {

    /**
     * Does frontpage area requires authentification
     *
     * @return boolean. True if frontpage area is displayed to all users, false if it's displyed for everyone.
     */
    public function requires_authentification() {
        return false;
    }

    /**
     * Outputs frontpage area content
     *
     * @param renderer $courserenderer
     */
    public function output($courserenderer) {
        global $OUTPUT;

        echo $OUTPUT->box($courserenderer->course_search_form('', 'short'), 'mdl-align');
    }

}
