<?
/*
Plugin Name: Distrify Embed
Plugin URI: http://support.distrify.com/customer/portal/articles/264106-how-do-i-embed-on-a-wordpress-blog-
Description: Extends WordPress's <a href="http://codex.wordpress.org/Embeds">Embeds</a> allowing bloggers to easily embed videos from Distrify. Just go to any Distrify film page or player and copy the URL. Paste that URL in any WordPress blog and it will automatically be converted to an embedded Distrify player. If you are logged in to <a href="http://distrify.com/">distrify.com</a> it will automatically add your affiliate tracking code to your embeds. Make sure you turn on Auto-embeds in your WP settings and also make sure that the URL is on its own line and not hyperlinked (clickable when viewing the post). The plugin also extracts the still image from the film and saves it as the <a href="http://codex.wordpress.org/Post_Thumbnails">Featured Image</a> for the post. This actually works for any Embed (not just Distrify) that you embed into your WordPress blog.
Author: Distrify Limited
Version: 0.3.1
Author URI: http://www.distrify.com
License: GPL2

Copyright 2011-2013  Distrify  (email : hello@distrify.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/**
 * Does the work of adding the Distrify provider to wp_oembed
 */
function add_distrify_provider($the_content){
	require_once( ABSPATH . WPINC . '/class-oembed.php' );
  wp_oembed_add_provider('#https?://(www\.)?(distrify|muvies).com/films/.*#i', 'http://distrify.com/oembed.json', true );	
  wp_oembed_add_provider('http://muvi.es/*', 'http://distrify.com/oembed.json' );	
  wp_oembed_add_provider('#https?://.*\.muvies.com/.*reviews/.*#i', 'http://distrify.com/oembed.json', true );	
}
//add the provider on plugins_loaded.
add_action('plugins_loaded', 'add_distrify_provider');


/**
 * from http://wordpress.stackexchange.com/q/70752/1685
 * Automatically set the featured image if an oEmbed-compatible embed is found in the post content.
 * author: TheDeadMedic
 * author URI: http://wordpress.stackexchange.com/users/1685/thedeadmedic
 *
 */

add_action( 'wp_insert_post', array( 'ofi', 'init' ) );

class ofi
{
    /**
     * The post thumbnail ID
     *
     * @var int
     */
    private $_thumb_id;

    /**
     * The post ID
     *
     * @var int
     */
    private $_post_id;

    /**
     * Sets up an instance if called statically, and attempts to set the featured
     * image from an embed in the post content (if one has not already been set).
     *
     * @param  int $post_id
     * @return object|null
     */
    public function init( $post_id )
    {
        if ( ! isset( $this ) )
            return new ofi( $post_id );

        global $wp_embed;

        $this->_post_id = absint( $post_id );

        if ( ! $this->_thumb_id = get_post_meta( $this->_post_id, '_thumbnail_id', true ) ) {
            if ( $content = get_post_field( 'post_content', $this->_post_id, 'raw' ) ) {

                add_filter( 'oembed_dataparse', array( $this, 'oembed_dataparse' ), 10, 3 );
                $wp_embed->autoembed( $content );
                remove_filter( 'oembed_dataparse', array( $this, 'oembed_dataparse' ), 10, 3 );

            }
        }
    }

    /**
     * @see init()
     */
    public function __construct( $post_id )
    {
        $this->init( $post_id );
    }

    /**
     * Callback for the "oembed_dataparse" hook, which will fire on a successful
     * response from the oEmbed provider.
     *
     * @see WP_oEmbed::data2html()
     *
     * @param string $return The embed HTML
     * @param object $data   The oEmbed response
     * @param string $url    The oEmbed content URL
     */
    public function oembed_dataparse( $return, $data, $url )
    {
        if ( ! empty( $data->thumbnail_url ) && ! $this->_thumb_id ) {
            // if ( in_array( @ $data->type, array( 'video' ) ) ) // Only set for video embeds
                $this->set_thumb_by_url( $data->thumbnail_url, @ $data->title );
        }
    }

    /**
     * Attempt to download the image from the URL, add it to the media library,
     * and set as the featured image.
     *
     * @see media_sideload_image()
     *
     * @param string $url
     * @param string $title Optionally set attachment title
     */
    public function set_thumb_by_url( $url, $title = null )
    {
        /* Following assets will already be loaded if in admin */
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $temp = download_url( $url );

        if ( ! is_wp_error( $temp ) && $info = @ getimagesize( $temp ) ) {
            if ( ! strlen( $title ) )
                $title = null;

            if ( ! $ext = image_type_to_extension( $info[2] ) )
                $ext = '.jpg';

            $data = array(
                'name'     => md5( $url ) . $ext,
                'tmp_name' => $temp,
            );

            $id = media_handle_sideload( $data, $this->_post_id, $title );
            if ( ! is_wp_error( $id ) )
                return update_post_meta( $this->_post_id, '_thumbnail_id', $this->_thumb_id = $id );
        }

        if ( ! is_wp_error( $temp ) )
            @ unlink( $temp );
    }
}

?>