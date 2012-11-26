<?php
/**
 * PMG Social Buttons
 *
 * Copyright 2012 Performance Media Group <seo@pmg.co>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category    WordPress
 * @package     PMG_Social_Buttons
 * @copyright   2012 Performance Media Group
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 */

!defined('ABSPATH') && exit;

/**
 * Admin area functionality.
 *
 * @since   1.0
 * @author  Christopher Davis <http://christopherdavis.me>
 */
class PMG_Social_Buttons_Admin extends PMG_Social_Buttons
{
    const PAGE = 'general';

    private $fields = array();

    public function _setup()
    {
        add_action('admin_init', array($this, 'settings'));
    }

    public function settings()
    {
        register_setting(
            static::PAGE,
            static::SETTING,
            array($this, 'cleaner')
        );

        add_settings_section(
            static::SETTING,
            __('Social Sharing Buttons', 'pmg-social-buttons'),
            '__return_false',
            static::PAGE
        );

        foreach($this->get_fields() as $f => $label)
        {
            $lf = sprintf('%s[%s]', static::SETTING, $f);
            add_settings_field(
                $lf,
                $label,
                array($this, 'field_cb'),
                static::PAGE,
                static::SETTING,
                array('label_for' => $lf, 'key' => $f)
            );
        }
    }

    public function field_cb($args)
    {
        printf(
            '<input type="checkbox" name="%1$s" id="%1$s" value="%2$s" %3$s />',
            esc_attr($args['label_for']),
            esc_attr($args['key']),
            checked('on', static::opt($args['key'], 'on'), false)
        );
    }

    public function cleaner($dirty)
    {
        $clean = array();
        foreach($this->get_fields() as $f => $_)
            $clean[$f] = !empty($dirty[$f]) ? 'on' : 'off';

        return $clean;
    }
} // end class PMG_Social_Buttons_Admin
