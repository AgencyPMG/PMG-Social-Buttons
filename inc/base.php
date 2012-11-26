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
 * A base class that sets up some class constants and an action system for the
 * rest of the the plugin.
 *
 * @since   1.0
 * @author  Christopher Davis <http://christopherdavis.me>
 */
abstract class PMG_Social_Buttons
{
    const SETTING = 'pmg_social_buttons';

    private static $reg = array();

    public static function init()
    {
        add_action('plugins_loaded', array(static::instance(), '_setup'));
    }

    public static function instance()
    {
        $cls = get_called_class();
        !isset(self::$reg[$cls]) && self::$reg[$cls] = new $cls();
        return self::$reg[$cls];
    }

    abstract public function _setup();

    public static function opt($key, $default='')
    {
        $opts = get_option(self::SETTING, array());
        return isset($opts[$key]) ? $opts[$key] : $default;
    }

    public final static function show($field)
    {
        return apply_filters("pmg_social_buttons_show_{$field}",
            ('on' === self::opt($field, 'on')));
    }

    public final static function enqueue($field)
    {
        return apply_filters("pmg_social_buttons_enqueue_{$field}", true);
    }

    public final function get_fields()
    {
        return apply_filters('pmg_social_buttons_buttons', array(
            'facebook'  => __('Show Facebook', 'pmg-social-buttons'),
            'twitter'   => __('Show Twitter', 'pmg-social-buttons'),
            'google'    => __('Show Google Plus', 'pmg-social-buttons'),
            'linkedin'  => __('Show LinkedIn', 'pmg-social-buttons'),
        ));
    }

    protected final function get_cls()
    {
        return esc_attr(
            apply_filters('pmg_social_buttons_container_class', 'pmg-social-buttons')
        );
    }
}
