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
 * Handles displaying the buttons themselves in the post.
 *
 * @since   1.0
 * @author  Christopher Davis <http://christopherdavis.me>
 */
class PMG_Social_Buttons_Buttons extends PMG_Social_Buttons
{
    public function _setup()
    {
        if(apply_filters('pmg_social_buttons_add_to_content', true))
            add_filter('the_content', array($this, 'add_buttons'));

        foreach($this->get_fields() as $f => $_)
        {
            if(method_exists($this, $f) && self::show($f))
                add_action("pmg_social_buttons_field_{$f}", array($this, $f), 10, 2);
        }
    }

    public function add_buttons($c)
    {
        global $post;

        if(apply_filters(
            'pmg_social_buttons_disabled',
            !is_singular() || is_front_page() || stripos($c, '<!--nosocial-->') !== false,
            $post,
            $c
        )) return $c;

        return $this->do_buttons($post) . $c;
    }

    public function do_buttons($post)
    {
        $url = get_permalink($post);
        $cls = $this->get_cls();

        ob_start();
        echo '<div class="', $cls, '">';
        do_action('pmg_social_buttons_before', $post, $url);

        foreach($this->get_fields() as $f => $_)
        {
            do_action("pmg_social_buttons_field_before_{$f}", $post, $url);
            echo '<div class="', $cls, '-buttonwrap ', esc_attr($f), '">';
            do_action("pmg_social_buttons_field_{$f}", $post, $url);
            echo '</div>';
            do_action("pmg_social_buttons_field_after_{$f}", $post, $url);
        }

        do_action('pmg_social_buttons_after', $post, $url);
        echo '</div>';
        return ob_get_clean();
    }

    public function facebook($post, $url)
    {
        printf(
            '<div class="fb-like" data-href="%1$s" data-send="false" ' .
            'data-layout="%2$s" data-width="%3$s" data-show-faces="%4$s"></div>',
            esc_url($url),
            esc_attr(apply_filters('pmg_social_buttons_fb_layout', 'box_count', $post)),
            esc_attr(apply_filters('pmg_social_buttons_fb_width', '100', $post)),
            esc_attr(apply_filters('pmg_social_buttons_fb_faces', 'false', $post))
        );
    }

    public function twitter($post, $url)
    {
        printf(
            '<a href="https://twitter.com/share" class="twitter-share-button" '.
            'data-url="%1$s" data-via="%2$s" data-count="vertical">Tweet</a>',
            esc_url($url),
            esc_attr(apply_filters('pmg_social_buttons_twitter_via', '', $post))
        );
    }

    public function google($post, $url)
    {
        printf(
            '<div class="g-plusone" data-size="tall" data-href="%1$s"></div>',
            esc_url($url)
        );
    }

    public function linkedin($post, $url)
    {
        printf(
            '<script type="IN/Share" data-url="%1$s" data-counter="top"></script>',
            esc_url($url)
        );
    }
} // end class PMG_Social_Buttons_Buttons
