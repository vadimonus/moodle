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
 * The frontpage area showing course section.
 *
 * @package    frontpage_topicsection
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/frontpage/frontpagebase.php');

/**
 * The class for frontpage area showing list of all courses
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontpage_topicsection extends frontpage_base {

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
        global $OUTPUT, $SITE, $CFG, $PAGE;

        $editing = $PAGE->user_is_editing();

        // Print Section or custom info.
        $siteformatoptions = course_get_format($SITE)->get_format_options();
        $modinfo = get_fast_modinfo($SITE);
        $modnames = get_module_types_names();
        $modnamesplural = get_module_types_names(true);
        $modnamesused = $modinfo->get_used_module_names();
        $mods = $modinfo->get_cms();

        if (!empty($CFG->customfrontpageinclude)) {
            include($CFG->customfrontpageinclude);

        } else {
            if ($siteformatoptions['numsections'] > 0) {
                if ($editing) {
                    // Make sure section with number 1 exists.
                    course_create_sections_if_missing($SITE, 1);
                    // Re-request modinfo in case section was created.
                    $modinfo = get_fast_modinfo($SITE);
                }
                $section = $modinfo->get_section_info(1);
                if (($section && (!empty($modinfo->sections[1]) or !empty($section->summary))) or $editing) {
                    echo $OUTPUT->box_start('generalbox sitetopic');

                    // If currently moving a file then show the current clipboard.
                    if (ismoving($SITE->id)) {
                        $stractivityclipboard = strip_tags(get_string('activityclipboard', '', $USER->activitycopyname));
                        echo '<p><font size="2">';
                        echo "$stractivityclipboard&nbsp;&nbsp;(<a href=\"course/mod.php?cancelcopy=true&amp;sesskey=".sesskey()."\">";
                        echo get_string('cancel') . '</a>)';
                        echo '</font></p>';
                    }

                    $context = context_course::instance(SITEID);

                    // If the section name is set we show it.
                    if (!is_null($section->name)) {
                        echo $OUTPUT->heading(
                            format_string($section->name, true, array('context' => $context)),
                            2,
                            'sectionname'
                        );
                    }

                    $summarytext = file_rewrite_pluginfile_urls($section->summary,
                        'pluginfile.php',
                        $context->id,
                        'course',
                        'section',
                        $section->id);
                    $summaryformatoptions = new stdClass();
                    $summaryformatoptions->noclean = true;
                    $summaryformatoptions->overflowdiv = true;

                    echo format_text($summarytext, $section->summaryformat, $summaryformatoptions);

                    if ($editing && has_capability('moodle/course:update', $context)) {
                        $streditsummary = get_string('editsummary');
                        echo "<a title=\"$streditsummary\" ".
                             " href=\"course/editsection.php?id=$section->id\"><img src=\"" . $OUTPUT->pix_url('t/edit') . "\" ".
                             " class=\"iconsmall\" alt=\"$streditsummary\" /></a><br /><br />";
                    }

                    $courserenderer = $PAGE->get_renderer('core', 'course');
                    echo $courserenderer->course_section_cm_list($SITE, $section);

                    echo $courserenderer->course_section_add_cm_control($SITE, $section->section);
                    echo $OUTPUT->box_end();
                }
            }
        }

        // Include course AJAX.
        include_course_ajax($SITE, $modnamesused);
    }

}
