<?php
/**
 * Plugin Name: PMG Social Buttons
 * Plugin URI: http://pmg.co
 * Description: Add social sharing buttons to the website.
 * Version: 1.0
 * Text Domain: apex
 * Author: Christopher Davis
 * Author URI: http://pmg.co/people/chris
 * License: GPL2
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

add_action('plugins_loaded', 'pmg_social_buttons_load', 1);
function pmg_social_buttons_load()
{
    static $p = null, $ds = DIRECTORY_SEPARATOR;

    is_null($p) && $p = dirname(__FILE__) . "{$ds}inc{$ds}";

    require_once($p . 'base.php');

    if(is_admin() && (!defined('DOING_AJAX') || !DOING_AJAX))
    {
        require_once($p . 'admin.php');
        PMG_Social_Buttons_Admin::init();
    }
    else
    {
        require_once($p . 'enqueue.php');
        require_once($p . 'buttons.php');
        
        PMG_Social_Buttons_Enqueue::init();
        PMG_Social_Buttons_Buttons::init();
    }
}
