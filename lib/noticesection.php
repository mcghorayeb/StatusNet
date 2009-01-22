<?php
/**
 * Laconica, the distributed open-source microblogging tool
 *
 * Base class for sections showing lists of notices
 *
 * PHP version 5
 *
 * LICENCE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Widget
 * @package   Laconica
 * @author    Evan Prodromou <evan@controlyourself.ca>
 * @copyright 2009 Control Yourself, Inc.
 * @license   http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @link      http://laconi.ca/
 */

if (!defined('LACONICA')) {
    exit(1);
}

define('NOTICES_PER_SECTION', 6);

/**
 * Base class for sections showing lists of notices
 *
 * These are the widgets that show interesting data about a person
 * group, or site.
 *
 * @category Widget
 * @package  Laconica
 * @author   Evan Prodromou <evan@controlyourself.ca>
 * @license  http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @link     http://laconi.ca/
 */

class NoticeSection extends Section
{
    function showContent()
    {
        $notices = $this->getNotices();

        $cnt = 0;

        $this->out->elementStart('table', 'notices');

        while ($notices->fetch() && ++$cnt <= NOTICES_PER_SECTION) {
            $this->showNotice($notices);
        }

        $this->out->elementEnd('table');

        return ($cnt > NOTICES_PER_SECTION);
    }

    function getNotices()
    {
        return null;
    }

    function showNotice($notice)
    {
        $profile = $notice->getProfile();
        $this->out->elementStart('tr');
        $this->out->elementStart('td');
        $avatar = $profile->getAvatar(AVATAR_MINI_SIZE);
        $this->out->element('img', array('src' => (($avatar) ? common_avatar_display_url($avatar) :  common_default_avatar(AVATAR_MINI_SIZE)),
                                         'width' => AVATAR_MINI_SIZE,
                                         'height' => AVATAR_MINI_SIZE,
                                         'class' => 'avatar photo',
                                         'alt' =>  ($profile->fullname) ?
                                         $profile->fullname :
                                         $profile->nickname));
        $this->out->elementEnd('a');
        $this->out->elementEnd('td');
        $this->out->elementStart('td');
        $this->out->elementStart('a', array('title' => ($profile->fullname) ?
                                            $profile->fullname :
                                            $profile->nickname,
                                            'href' => $profile->noticeurl,
                                            'rel' => 'contact member',
                                            'class' => 'url'));
        $this->out->element('span', 'fn nickname', $profile->nickname);
        $this->out->elementEnd('td');
        $this->out->elementStart('td');
        $this->out->raw($notice->rendered);
        $this->out->elementEnd('td');
        if ($notice->value) {
            $this->out->elementStart('td');
            $this->out->text($notice->value);
            $this->out->elementEnd('td');
        }
        $this->out->elementEnd('tr');
    }
}