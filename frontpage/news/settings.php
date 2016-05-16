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
 * The settings page for frontpage area showing site news.
 *
 * @package    frontpage_news
 * @copyright  2016 Vadim Dvorovenko <Vadimon@mail.ru>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$settings->add(new admin_setting_sitesetselect('newsitems', new lang_string('newsitemsnumber'), '', 3,
     array('0' => '0',
           '1' => '1',
           '2' => '2',
           '3' => '3',
           '4' => '4',
           '5' => '5',
           '6' => '6',
           '7' => '7',
           '8' => '8',
           '9' => '9',
           '10' => '10')));
