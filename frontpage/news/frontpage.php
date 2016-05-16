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
 * The frontpage area showing site news.
 *
 * @package    frontpage_news
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/frontpage/frontpagebase.php');

/**
 * The class for frontpage area showing site news.
 *
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class frontpage_news extends frontpage_base {

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
        global $OUTPUT, $SITE, $CFG, $SESSION, $USER;

        if ($SITE->newsitems) {
            // Print forums only when needed.
            require_once($CFG->dirroot . '/mod/forum/lib.php');

            if (!$newsforum = forum_get_course_forum($SITE->id, 'news')) {
                print_error('cannotfindorcreateforum', 'forum');
            }

            // Fetch news forum context for proper filtering to happen.
            $newsforumcm = get_coursemodule_from_instance('forum', $newsforum->id, $SITE->id, false, MUST_EXIST);
            $newsforumcontext = context_module::instance($newsforumcm->id, MUST_EXIST);

            $forumname = format_string($newsforum->name, true, array('context' => $newsforumcontext));
            echo html_writer::link('#skipsitenews', get_string('skipa', 'access', core_text::strtolower(strip_tags($forumname))),
                    array('class' => 'skip-block skip'));

            // Wraps site news forum in div container.
            echo html_writer::start_tag('div', array('id' => 'site-news-forum'));

            if (isloggedin()) {
                $SESSION->fromdiscussion = $CFG->wwwroot;
                $subtext = '';
                if (\mod_forum\subscriptions::is_subscribed($USER->id, $newsforum)) {
                    if (!\mod_forum\subscriptions::is_forcesubscribed($newsforum)) {
                        $subtext = get_string('unsubscribe', 'forum');
                    }
                } else {
                    $subtext = get_string('subscribe', 'forum');
                }
                echo $OUTPUT->heading($forumname);
                $suburl = new moodle_url('/mod/forum/subscribe.php', array('id' => $newsforum->id, 'sesskey' => sesskey()));
                echo html_writer::tag('div', html_writer::link($suburl, $subtext), array('class' => 'subscribelink'));
            } else {
                echo $OUTPUT->heading($forumname);
            }

            forum_print_latest_discussions($SITE, $newsforum, $SITE->newsitems, 'plain', 'p.modified DESC');

            // End site news forum div container.
            echo html_writer::end_tag('div');

            echo html_writer::tag('span', '', array('class' => 'skip-block-to', 'id' => 'skipsitenews'));
        }
    }

}
