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
 * The frontpage area showing categories list.
 *
 * @package    frontpage_categorynames
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/frontpage/frontpagebase.php');

/**
 * The class for frontpage area showing categories list.
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontpage_categorynames extends frontpage_base {

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

        echo html_writer::link('#skipcategories',
            get_string('skipa', 'access', core_text::strtolower(get_string('categories'))),
            array('class' => 'skip skip-block'));

        // Wrap frontpage category names in div container.
        echo html_writer::start_tag('div', array('id' => 'frontpage-category-names'));

        echo $OUTPUT->heading(get_string('categories'));
        echo $courserenderer->frontpage_categories_list();

        // End frontpage category names div container.
        echo html_writer::end_tag('div');

        echo html_writer::tag('span', '', array('class' => 'skip-block-to', 'id' => 'skipcategories'));
    }

}
