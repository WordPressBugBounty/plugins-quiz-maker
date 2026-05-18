<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * The admin-facing custom post type functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      6.6.9.4
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/includes
 */

/**
 * The admin-facing custom post type functionality of the plugin.
 *
 * Defines the plugin name, version, flush version, name prefix
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Quiz_Maker_Custom_Post_Type {

    private $plugin_name;
    private $version;
    private $ays_quiz_flush_version;
    public  $name_prefix;

    public function __construct($plugin_name, $version){
        $this->plugin_name = $plugin_name;
        $this->name_prefix = 'ays-';
        $this->version = $version;
        $this->ays_quiz_flush_version = '1.0.0';
        add_action( 'init', array( $this, 'ays_quiz_register_custom_post_type' ) );
        add_filter( 'the_content', array( $this, 'ays_quiz_add_preview_notice_to_content' ), 9 );
    }

    public function ays_quiz_register_custom_post_type(){
        $args = array(
            'public'  => true,
            'rewrite' => true,
            'show_in_menu' => false,
            'exclude_from_search' => false, 
            'show_ui' => false,
            'show_in_nav_menus' => false,
            'show_in_rest' => false
        );

        register_post_type( $this->name_prefix . $this->plugin_name, $args );
        $this->ays_quiz_custom_rewrite_rule();
        $this->ays_quiz_flush_permalinks();
    }

    public static function ays_quiz_add_custom_post($args, $update = true){
        
        $quiz_id    = (isset($args['quiz_id']) && $args['quiz_id'] != '' && $args['quiz_id'] != 0) ? esc_attr($args['quiz_id']) : '';
        $quiz_title = (isset($args['quiz_title']) && $args['quiz_title'] != '') ? esc_attr($args['quiz_title']) : '';
        $author_id  = (isset($args['author_id']) && $args['author_id'] != '') ? esc_attr($args['author_id']) : get_current_user_id();

        $post_content = '[ays_quiz id="'.$quiz_id.'"]';

        $new_post = array(
            'post_title'    => $quiz_title,
            'post_author'   => $author_id,
            'post_type'     => 'ays-quiz-maker', // Custom post type name is -> ays-quiz-maker
            'post_content'  => $post_content,
            'post_status'   => 'draft',
            'post_date'     => current_time( 'mysql' ),
        );
        $post_id = wp_insert_post($new_post);
        if($update){
            if(isset($post_id) && $post_id > 0){
                self::update_quizzes_table_custom_post_id($post_id, $quiz_id);
            }
        }
        return $post_id;
    }

    public static function update_quizzes_table_custom_post_id($custom_post_id, $quiz_id){
        global $wpdb;
        $table = esc_sql( $wpdb->prefix . "aysquiz_quizes" );
        $result = $wpdb->update(// phpcs:ignore WordPress.DB.DirectDatabaseQuery
            $table,
            array('custom_post_id' => $custom_post_id),
            array('id' => $quiz_id),
            array('%d'),
            array('%d')
        );
    }

    public function ays_quiz_flush_permalinks(){
        if ( get_site_option( 'ays_quiz_flush_version' ) != $this->ays_quiz_flush_version ) {
            flush_rewrite_rules();
        }
        update_option( 'ays_quiz_flush_version', $this->ays_quiz_flush_version );            
    }
    
    public function ays_quiz_custom_rewrite_rule() {
        add_rewrite_rule(
            'ays-quiz-maker/([^/]+)/?',
            'index.php?post_type=ays-quiz-maker&name=$matches[1]',
            'top'
        );
    }

    public function ays_quiz_add_preview_notice_to_content( $content ) {
        global $post;

        if ( ! is_singular( $this->name_prefix . $this->plugin_name ) || ! is_main_query() || ! in_the_loop() ) {
            return $content;
        }

        $is_preview = get_query_var( 'preview' );

        if ( $is_preview !== 'true' && $is_preview !== true ) {
            return $content;
        }

        $post_type = isset( $post->post_type ) && $post->post_type != "" ? sanitize_text_field($post->post_type) : '';
        
        if( $post_type !== 'ays-quiz-maker' ){
            return $content;
        }

        return $this->ays_quiz_get_preview_notice_html() . $content;
    }

    private function ays_quiz_get_preview_notice_html() {
        global $post;

        $post_id   = isset( $post->ID ) ? absint( $post->ID ) : 0;
        $shortcode = isset( $post->post_content ) ? $this->ays_quiz_get_shortcode_from_content( $post->post_content ) : '';

        if ( $shortcode === '' && $post_id > 0 ) {
            $shortcode = $this->ays_quiz_get_shortcode_by_custom_post_id( $post_id );
        }

        $content   = array();

        $content[] = '<div id="ays-quiz-preview-notice-main-container" class="ays-quiz-preview-notice-wrap">';
            $content[] = '<div role="status" aria-live="polite" class="ays-quiz-preview-notice">';
                $content[] = '<span class="ays-quiz-preview-notice-icon" aria-hidden="true">';
                    $content[] = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
                        $content[] = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>';
                        $content[] = '<circle cx="12" cy="12" r="3"></circle>';
                    $content[] = '</svg>';
                $content[] = '</span>';
                $content[] = '<div class="ays-quiz-preview-notice-text">';
                    $content[] = '<strong>' . esc_html__( 'This is a preview page.', 'quiz-maker' ) . '</strong> ';
                    $content[] = esc_html__( 'Other users cannot access this link. To publish this quiz, copy its shortcode and add it to a post or page.', 'quiz-maker' );
                $content[] = '</div>';

                if ( $shortcode !== '' ) {
                    $content[] = '<div class="ays-quiz-preview-shortcode-actions">';
                        $content[] = '<button type="button" class="ays-quiz-preview-copy-shortcode" data-shortcode="' . esc_attr( $shortcode ) . '" data-label="' . esc_attr__( 'Copy Shortcode', 'quiz-maker' ) . '" data-copied-label="' . esc_attr__( 'Copied', 'quiz-maker' ) . '">';
                            $content[] = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">';
                                $content[] = '<rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>';
                                $content[] = '<path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>';
                            $content[] = '</svg>';
                            $content[] = '<span class="ays-quiz-preview-copy-shortcode-label">' . esc_html__( 'Copy Shortcode', 'quiz-maker' ) . '</span>';
                        $content[] = '</button>';
                        $content[] = '<code class="ays-quiz-preview-shortcode-text">&#91;' . esc_html( $shortcode ) . '&#93;</code>';
                    $content[] = '</div>';
                }
            $content[] = '</div>';
        $content[] = '</div>';

        return implode( '', $content );
    }

    private function ays_quiz_get_shortcode_from_content( $content ) {
        if ( preg_match( '/\[ays_quiz[^\]]*id\s*=\s*([\'"]?)(\d+)\1[^\]]*\]/', $content, $matches ) ) {
            return "ays_quiz id='" . absint( $matches[2] ) . "'";
        }

        return '';
    }

    private function ays_quiz_get_shortcode_by_custom_post_id( $custom_post_id ) {
        global $wpdb;

        $table     = esc_sql( $wpdb->prefix . 'aysquiz_quizes' );
        $quiz_id = $wpdb->get_var(// phpcs:ignore WordPress.DB.DirectDatabaseQuery
            $wpdb->prepare(
                "SELECT id FROM {$table} WHERE custom_post_id = %d",
                $custom_post_id
            )
        );

        if ( $quiz_id > 0 ) {
            return "ays_quiz id='" . absint( $quiz_id ) . "'";
        }

        return '';
    }
}
