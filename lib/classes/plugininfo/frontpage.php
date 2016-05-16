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
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
namespace core\plugininfo;

use moodle_url, part_of_admin_tree, admin_settingpage;

defined('MOODLE_INTERNAL') || die();

/**
 * Class for frontpage areas
 *
 * @package    core
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
class frontpage extends base {

    /**
     * Return the node name to use in admin settings menu for this plugin.
     *
     * @return string node name
     */
    public function get_settings_section_name() {
        return 'frontpagesettings' . $this->name;
    }

    /**
     * Loads plugin settings to the settings tree
     *
     * This function usually includes settings.php file in plugins folder.
     * Alternatively it can create a link to some settings page (instance of admin_externalpage)
     *
     * @param \part_of_admin_tree $adminroot
     * @param string $parentnodename
     * @param bool $hassiteconfig whether the current user has moodle/site:config capability
     */
    public function load_settings(part_of_admin_tree $adminroot, $parentnodename, $hassiteconfig) {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE; // In case settings.php wants to refer to them.
        $ADMIN = $adminroot; // May be used in settings.php.
        $plugininfo = $this; // Also can be used inside settings.php.

        if (!$this->is_installed_and_upgraded()) {
            return;
        }

        if (!$hassiteconfig or !file_exists($this->full_path('settings.php'))) {
            return;
        }

        $section = $this->get_settings_section_name();

        $settings = new admin_settingpage($section, $this->displayname, 'moodle/course:update');
        include($this->full_path('settings.php')); // This may also set $settings to null.

        if (!empty($settings)) {
            $ADMIN->add($parentnodename, $settings);
        }
    }

    /**
     * Should there be a way to uninstall the plugin via the administration UI.
     *
     * By default uninstallation is not allowed, plugin developers must enable it explicitly!
     *
     * @return bool
     */
    public function is_uninstall_allowed() {
        $coreplugins = array('allcourselist', 'categorycombo', 'categorynames', 'coursesearch', 'enrolledcourselist', 'news');
        if (in_array($this->name, $coreplugins)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Pre-uninstall hook.
     *
     * This is intended for disabling of plugin, some DB table purging, etc.
     */
    public function uninstall_cleanup() {
        global $CFG;

        $settings = array('frontpage', 'frontpageloggedin');
        foreach ($settings as $setting) {
            if (empty($CFG->$setting)) {
                continue;
            }
            $plugins = $CFG->$setting;
            $plugins = explode(',', $plugins);
            $plugins = array_combine($plugins, $stringfilters);
            unset($plugins[$this->name]);
            set_config($setting, implode(',', $plugins));
        }
        parent::uninstall_cleanup();
    }
}

