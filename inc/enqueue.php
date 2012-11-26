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
 * Enqueue the various social JS as well as some styles for this plugin.
 *
 * @since   1.0
 * @author  Christopher Davis <http://christopherdavis.me>
 */
class PMG_Social_Buttons_Enqueue extends PMG_Social_Buttons
{
    public function _setup()
    {
        foreach($this->get_fields() as $f => $_)
        {
            if(method_exists($this, $f))
                add_action('wp_footer', array($this, $f));
        }

        add_action('wp_enqueue_scripts', array($this, 'li_enqueue'));
        add_action('wp_head', array($this, 'print_style'));
    }

    public function facebook()
    {
        if(self::enqueue('facebook') && self::show('facebook')):
        ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=366740156714342";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <?php
        endif;
    }

    public function twitter()
    {
        if(self::enqueue('twitter') && self::show('twitter')):
        ?>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
        </script>
        <?php
        endif;
    }

    public function google()
    {
        if(self::enqueue('google') && self::show('google')):
        ?>
        <script type="text/javascript">
          (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = 'https://apis.google.com/js/plusone.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
          })();
        </script>
        <?php
        endif;
    }

    public function li_enqueue()
    {
        if(self::enqueue('linkedin') && self::show('linkedin'))
        {
            wp_enqueue_script(
                'linkedin-social',
                'http://platform.linkedin.com/in.js',
                array(),
                NULL,
                true
            );
        }
    }

    public function print_style()
    {
        if(self::enqueue('style')):
        $cls = $this->get_cls();
        ?>
        <style type="text/css">
            .<?php echo $cls; ?> {
                float: left;
                margin: 0 1em 1em 0;
            }

            .<?php echo $cls; ?>-buttonwrap {
                text-align: center;
                margin-top: 0.5em;
            }

            .<?php echo $cls; ?> .<?php echo $cls; ?>-buttonwrap:first-child {
                margin-top: 0;
            }

            <?php do_action('pmg_social_buttons_style'); ?>
        </style>
        <?php
        endif;
    }
} // end class PMG_Social_Buttons_Enqueue
