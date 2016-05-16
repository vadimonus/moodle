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
 * The default frontpage area class.
 *
 * @package    core
 * @subpackage frontpage
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * This is the base class for Moodle frontpage area.
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since Moodle 3.2
 */
class frontpage_base {

    /**
     * The name of this plugin.
     *
     * @return string
     */
    public function name() {
        return substr(get_class($this), 10);
    }

    /**
     * Returs the full frankenstyle name for this plugin.
     *
     * @return string
     */
    public function plugin_name() {
        return get_class($this);
    }

    /**
     * Return the name of this question type in the user's language.
     * You should not need to override this method, the default behaviour should be fine.
     *
     * @return string
     */
    public function local_name() {
        return get_string('pluginname', $this->plugin_name());
    }

    /**
     * Does frontpage area requires authentification.
     *
     * @return boolean. True if frontpage area is displayed to all users, false if it's displyed for everyone.
     */
    public function requires_authentification() {
        return false;
    }

    /**
     * Outputs frontpage area content.
     *
     * @param renderer $courserenderer
     */
    public function output($courserenderer) {
    }

}
