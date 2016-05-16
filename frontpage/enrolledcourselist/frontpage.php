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
 * The frontpage area showing enrolled courses for current user.
 *
 * @package    frontpage_enrolledcourselist
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/frontpage/frontpagebase.php');

/**
 * The class for frontpage area showing enrolled courses for current user.
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontpage_enrolledcourselist extends frontpage_base {

    /**
     * Does frontpage area requires authentification
     *
     * @return boolean. True if frontpage area is displayed to all users, false if it's displyed for everyone.
     */
    public function requires_authentification() {
        return true;
    }

    /**
     * Outputs frontpage area content
     *
     * @param renderer $courserenderer
     */
    public function output($courserenderer) {
        global $OUTPUT;

        $mycourseshtml = $courserenderer->frontpage_my_courses();
        if (!empty($mycourseshtml)) {
            echo html_writer::link('#skipmycourses',
                get_string('skipa', 'access', core_text::strtolower(get_string('mycourses'))),
                array('class' => 'skip skip-block'));

            // Wrap frontpage course list in div container.
            echo html_writer::start_tag('div', array('id' => 'frontpage-course-list'));

            echo $OUTPUT->heading(get_string('mycourses'));
            echo $mycourseshtml;

            // End frontpage course list div container.
            echo html_writer::end_tag('div');

            echo html_writer::tag('span', '', array('class' => 'skip-block-to', 'id' => 'skipmycourses'));
            return;
        }

        // If there are no enrolled courses - show 'Available courses'.
        $availablecourseshtml = $courserenderer->frontpage_available_courses();
        if (!empty($availablecourseshtml)) {
            echo html_writer::link('#skipavailablecourses',
                get_string('skipa', 'access', core_text::strtolower(get_string('availablecourses'))),
                array('class' => 'skip skip-block'));

            // Wrap frontpage course list in div container.
            echo html_writer::start_tag('div', array('id' => 'frontpage-course-list'));

            echo $OUTPUT->heading(get_string('availablecourses'));
            echo $availablecourseshtml;

            // End frontpage course list div container.
            echo html_writer::end_tag('div');

            echo html_writer::tag('span', '', array('class' => 'skip-block-to', 'id' => 'skipavailablecourses'));
        }
    }

}
