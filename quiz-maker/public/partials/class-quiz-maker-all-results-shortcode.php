<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/public
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Quiz_Maker_All_Results
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    protected $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;


    protected $settings;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version){

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_shortcode('ays_all_results', array($this, 'ays_generate_all_results_method'));

        $this->settings = new Quiz_Maker_Settings_Actions($this->plugin_name);
    }

    public function enqueue_styles(){
        wp_enqueue_style($this->plugin_name . '-dataTable-min', AYS_QUIZ_PUBLIC_URL . '/css/quiz-maker-dataTables.min.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name . '-datatable-min', AYS_QUIZ_PUBLIC_URL . '/js/quiz-maker-datatable.min.js', array('jquery'), $this->version, true);
        wp_enqueue_script( $this->plugin_name . '-all-results-public', AYS_QUIZ_PUBLIC_URL . '/js/all-results/all-results-public.js', array('jquery'), $this->version, true);

        wp_localize_script( $this->plugin_name . '-datatable-min', 'quizLangDataTableObj', array(
            "sEmptyTable"           => __( "No data available in table", 'quiz-maker' ),
            "sInfo"                 => __( "Showing _START_ to _END_ of _TOTAL_ entries", 'quiz-maker' ),
            "sInfoEmpty"            => __( "Showing 0 to 0 of 0 entries", 'quiz-maker' ),
            "sInfoFiltered"         => __( "(filtered from _MAX_ total entries)", 'quiz-maker' ),
            // "sInfoPostFix":          => __( "", 'quiz-maker' ),
            // "sInfoThousands":        => __( ",", 'quiz-maker' ),
            "sLengthMenu"           => __( "Show _MENU_ entries", 'quiz-maker' ),
            "sLoadingRecords"       => __( "Loading...", 'quiz-maker' ),
            "sProcessing"           => __( "Processing...", 'quiz-maker' ),
            "sSearch"               => __( "Search:", 'quiz-maker' ),
            // "sUrl":                  => __( "", 'quiz-maker' ),
            "sZeroRecords"          => __( "No matching records found", 'quiz-maker' ),
            "sFirst"                => __( "First", 'quiz-maker' ),
            "sLast"                 => __( "Last", 'quiz-maker' ),
            "sNext"                 => __( "Next", 'quiz-maker' ),
            "sPrevious"             => __( "Previous", 'quiz-maker' ),
            "sSortAscending"        => __( ": activate to sort column ascending", 'quiz-maker' ),
            "sSortDescending"       => __( ": activate to sort column descending", 'quiz-maker' ),
        ) );
    }

    public function get_user_reports_info( $show_publicly, $attr ){
        global $wpdb;

        $where = array();
        $where_condition = "";

        $current_user = wp_get_current_user();
        $id = $current_user->ID;

        if (! $show_publicly) {
            if($id == 0){
                return null;
            }
        }

        $category_id = (isset($attr['id']) && $attr['id'] != '') ? absint( sanitize_text_field($attr['id']) ) : null;

        if( !is_null($category_id) && $category_id > 0 ){
            $where[] = ' q.quiz_category_id = ' . $category_id;
        }

        if( ! empty($where) ){
            $where_condition = " WHERE " . implode( " AND ", $where );
        }

        $reports_table = $wpdb->prefix . "aysquiz_reports";
        $quizes_table  = $wpdb->prefix . "aysquiz_quizes";
        $sql = "SELECT q.quiz_category_id,r.quiz_id,q.title, r.start_date, r.end_date, r.duration, r.score, r.id, r.user_name, r.user_id,
                       TIMESTAMPDIFF(second, r.start_date, r.end_date) AS duration_2
                FROM $reports_table AS r
                LEFT JOIN $quizes_table AS q
                ON r.quiz_id = q.id
                ". $where_condition ."
                ORDER BY r.id DESC";
        $results = $wpdb->get_results($sql, "ARRAY_A");

        return $results;

    }

    public function ays_all_results_html( $attr ){

        global $wpdb;

        $quizes_table  = esc_sql( $wpdb->prefix . "aysquiz_quizes" );

        $quiz_settings = $this->settings;
        $quiz_settings_options = ($quiz_settings->ays_get_setting('options') === false) ? json_encode(array()) : $quiz_settings->ays_get_setting('options');
        $quiz_set_option = json_decode(stripcslashes($quiz_settings_options), true);
        
        $quiz_set_option['ays_show_result_report'] = !isset($quiz_set_option['ays_show_result_report']) ? 'on' : $quiz_set_option['ays_show_result_report'];
        $show_result_report = isset($quiz_set_option['ays_show_result_report']) && $quiz_set_option['ays_show_result_report'] == 'on' ? true : false;

        // Show publicly
        $quiz_set_option['all_results_show_publicly'] = isset($quiz_set_option['all_results_show_publicly']) ? $quiz_set_option['all_results_show_publicly'] : 'off';
        $all_results_show_publicly = (isset($quiz_set_option['all_results_show_publicly']) && $quiz_set_option['all_results_show_publicly'] == "on") ? true : false;

        $results = $this->get_user_reports_info( $all_results_show_publicly, $attr );

        // SVG icon | Pass
        $pass_svg = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="green"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>';

        // SVG icon | Fail
        $fail_svg = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="brown"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>';

        $default_all_results_columns = array(
            'user_name'  => 'user_name',
            'quiz_name'  => 'quiz_name',
            'start_date' => 'start_date',
            'end_date'   => 'end_date',
            'duration'   => 'duration',
            'score'      => 'score',
            'status'     => '',
        );
        
        $all_results_columns = (isset( $quiz_set_option['all_results_columns'] ) && !empty($quiz_set_option['all_results_columns']) ) ? $quiz_set_option['all_results_columns'] : $default_all_results_columns;
        $all_results_columns_order = (isset( $quiz_set_option['all_results_columns_order'] ) && !empty($quiz_set_option['all_results_columns_order']) ) ? $quiz_set_option['all_results_columns_order'] : $default_all_results_columns;

        $all_results_columns_order_arr = $all_results_columns_order;

        foreach( $default_all_results_columns as $key => $value ){
            if( !isset( $all_results_columns[$key] ) ){
                $all_results_columns[$key] = '';
            }

            if( !isset( $all_results_columns_order[$key] ) ){
                $all_results_columns_order[$key] = $key;
            }

            if ( ! in_array( $key , $all_results_columns_order_arr) ) {
                $all_results_columns_order_arr[] = $key;
            }
        }

        foreach( $all_results_columns_order as $key => $value ){
            if( !isset( $all_results_columns[$key] ) ){
                if( isset( $all_results_columns[$value] ) ){
                    $all_results_columns_order[$value] = $value;
                }
                unset( $all_results_columns_order[$key] );
            }
        }

        foreach ($all_results_columns_order_arr  as $key => $value) {
            if( isset( $all_results_columns_order[$value] ) ){
                $all_results_columns_order_arr[$value] = $value;
            }

            if ( is_int( $key ) ) {
                unset( $all_results_columns_order_arr[$key] );
            }
        }

        $all_results_columns_order = $all_results_columns_order_arr;

        $default_all_results_column_names = array(
            "user_name"     => __( 'User name', 'quiz-maker' ),
            "quiz_name"     => __( 'Quiz name', 'quiz-maker' ),
            "start_date"    => __( 'Start date', 'quiz-maker' ),
            "end_date"      => __( 'End date', 'quiz-maker' ),
            "duration"      => __( 'Duration', 'quiz-maker' ),
            "score"         => __( 'Score', 'quiz-maker' ),
            "status"        => __( 'Status', 'quiz-maker' ),
        );

        $ays_default_header_value = array(
            "user_name"     => "<th style='width:20%;'>" . __( "User Name", 'quiz-maker' ) . "</th>",
            "quiz_name"     => "<th style='width:20%;'>" . __( "Quiz Name", 'quiz-maker' ) . "</th>",
            "start_date"    => "<th style='width:15%;'>" . __( "Start", 'quiz-maker' ) . "</th>",
            "end_date"      => "<th style='width:15%;'>" . __( "End", 'quiz-maker' ) . "</th>",
            "duration"      => "<th style='width:10%;'>" . __( "Duration", 'quiz-maker' ) . "</th>",
            "score"         => "<th style='width:10%;'>" . __( "Score", 'quiz-maker' ) . "</th>",
            "status"        => "<th style='width:10%;'>" . __( "Status", 'quiz-maker' ) . "</th>",
        );
        if($results === null){
            $all_results_html = "<p style='text-align: center;font-style:italic;'>" . __( "You must log in to see your results.", 'quiz-maker' ) . "</p>";
            return $all_results_html;
        }

        if( empty( $results ) ){
            $all_results_html = "";
            return $all_results_html;
        }
        
        $all_results_html = "<div class='ays-quiz-all-results-container'>
        <table id='ays-quiz-all-result-score-page' class='display'>
        <thead>
        <tr>";
        
        foreach ($all_results_columns_order as $key => $value) {
            if ( isset($all_results_columns[$value]) && $all_results_columns[$value] != '' ) {
                $all_results_html .= $ays_default_header_value[$value];
            }
        }
        
        $all_results_html .= "</tr></thead>";

        $quiz_pass_score_arr = array();
        foreach($results as $key => $result){
            $id         = isset($result['id']) ? $result['id'] : null;
            $quiz_id    = isset($result['quiz_id']) ? absint($result['quiz_id']) : null;
            $user_id    = isset($result['user_id']) ? intval($result['user_id']) : 0;
            $title      = isset($result['title']) ? $result['title'] : "";
            $start_date = date_create($result['start_date']);
            $start_date = date_format($start_date, 'H:i:s M d, Y');
            $end_date   = date_create($result['end_date']);
            $end_date   = date_format($end_date, 'H:i:s M d, Y');
            $score      = isset($result['score']) ? $result['score'] : 0;
            $duration   = (isset($result['duration']) && ! is_null($result['duration']) ) ? $result['duration'] : null;
            if ($duration == null) {
                $duration = isset($result['duration_2']) ? $result['duration_2'] : 0;
            }

            $start_date_for_ordering = strtotime($result['start_date']);
            $end_date_for_ordering = strtotime($result['end_date']);
            $duration_for_ordering = $duration;
            
            $duration = Quiz_Maker_Public::secondsToWords($duration);
            if ($duration == '') {
                $duration = '0 ' . __( 'second' , 'quiz-maker' );
            }

            if ($user_id == 0) {
                $user_name = (isset($result['user_name']) && $result['user_name'] != '') ? $result['user_name'] : __('Guest', 'quiz-maker');
            }else{
                $user_name = (isset($result['user_name']) && $result['user_name'] != '') ? $result['user_name'] : '';
                if($user_name == ''){
                    $user = get_user_by('id', $user_id);
                    $user_name = $user->data->display_name ? $user->data->display_name : $user->user_login;
                }
            }

            $status     = '';
            $pass_score = 0;
            if ( ! is_null( $quiz_id ) || ! empty( $quiz_id ) ) {
                if ( ! array_key_exists( $quiz_id , $quiz_pass_score_arr ) ) {

                    $sql = "SELECT options FROM " . $quizes_table . " WHERE id=" . intval( $quiz_id );
                    $quiz_options = $wpdb->get_var( $sql );
                    $quiz_options = $quiz_options != '' ? json_decode( $quiz_options, true ) : array();
                    $pass_score = isset( $quiz_options['pass_score'] ) && $quiz_options['pass_score'] != '' ? absint( $quiz_options['pass_score'] ) : 0;

                    $quiz_pass_score_arr[ $quiz_id ] = $pass_score;

                } else {
                    $pass_score = ( isset( $quiz_pass_score_arr[ $quiz_id ] ) && $quiz_pass_score_arr[ $quiz_id ] != '' ) ? absint( $quiz_pass_score_arr[ $quiz_id ] ) : 0;
                }
                
                $user_score = absint( $score );


                $status = '';
                if( $pass_score != 0 ){
                    if( $user_score >= $pass_score ){
                        $status .= "<div class='ays-quiz-score-column-check-box'>";
                            $status .= $pass_svg;
                            $status .= "<span class='ays-quiz-score-column-check'> " . __( "Passed", 'quiz-maker' ) . "</span>";
                        $status .= "</div>";
                    }else{
                        $status .= "<div class='ays-quiz-score-column-check-box'>";
                            $status .= $fail_svg;
                            $status .= "<span class='ays-quiz-score-column-times'> " . __( "Failed", 'quiz-maker' ) . "</span>";
                        $status .= "</div>";
                    }
                }
            }

            $ays_default_html_order = array(
                "user_name"     => "<td>$user_name</td>",
                "quiz_name"     => "<td>$title</td>",
                "start_date"    => "<td data-order='". $start_date_for_ordering ."'>$start_date</td>",
                "end_date"      => "<td data-order='". $end_date_for_ordering ."'>$end_date</td>",
                "duration"      => "<td data-order='". $duration_for_ordering ."' class='ays-quiz-duration-column'>$duration</td>",
                "score"         => "<td class='ays-quiz-score-column'>$score%</td>",
                "status"        => "<td class='ays-quiz-status-column'>$status</td>",
            );

            $all_results_html .= "<tr>";
            foreach ($all_results_columns_order as $key => $value) {
                if ( isset($all_results_columns[$value]) && $all_results_columns[$value] != '' ) {
                    $all_results_html .= $ays_default_html_order[$value];
                }
            }
            $all_results_html .= "</tr>";
        }

        $all_results_html .= "</table>
            </div>";
        
        return $all_results_html;
    }

    public function ays_generate_all_results_method( $attr ) {
        $this->enqueue_styles();
        $this->enqueue_scripts();

        $all_results_html = $this->ays_all_results_html( $attr );

        return str_replace(array("\r\n", "\n", "\r"), '', $all_results_html);
    }


}
