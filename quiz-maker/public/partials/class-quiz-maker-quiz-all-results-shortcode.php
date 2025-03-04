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
class Quiz_Maker_Quiz_All_Results
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
    protected $default_texts;

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

        add_shortcode('ays_quiz_all_results', array($this, 'ays_generate_quiz_all_results_method'));

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

    public function get_user_reports_info( $quiz_id, $show_publicly ){
        global $wpdb;

        $current_user = wp_get_current_user();
        $id = $current_user->ID;

        if ( empty($quiz_id) || is_null($quiz_id) ) {
            return null;
        }

        if (! $show_publicly) {
            if($id == 0){
                return null;
            }
        }

        $reports_table = $wpdb->prefix . "aysquiz_reports";
        $quizes_table = $wpdb->prefix . "aysquiz_quizes";
        $sql = "SELECT q.title, r.start_date, r.end_date, r.duration, r.score, r.id, r.user_name, r.user_id,
                       TIMESTAMPDIFF(second, r.start_date, r.end_date) AS duration_2
                FROM $reports_table AS r
                LEFT JOIN $quizes_table AS q
                ON r.quiz_id = q.id
                WHERE r.quiz_id = ". $quiz_id ."
                ORDER BY r.id DESC";
        $results = $wpdb->get_results($sql, "ARRAY_A");

        return $results;

    }

    public function ays_quiz_all_results_html( $quiz_id ){

        $quiz_settings = $this->settings;
        $quiz_settings_options = ($quiz_settings->ays_get_setting('options') === false) ? json_encode(array()) : $quiz_settings->ays_get_setting('options');
        $quiz_set_option = json_decode(stripcslashes($quiz_settings_options), true);
        
        $quiz_set_option['ays_show_result_report'] = !isset($quiz_set_option['ays_show_result_report']) ? 'on' : $quiz_set_option['ays_show_result_report'];
        $show_result_report = isset($quiz_set_option['ays_show_result_report']) && $quiz_set_option['ays_show_result_report'] == 'on' ? true : false;

        // Show publicly
        $quiz_set_option['quiz_all_results_show_publicly'] = isset($quiz_set_option['quiz_all_results_show_publicly']) ? $quiz_set_option['quiz_all_results_show_publicly'] : 'off';
        $quiz_all_results_show_publicly = (isset($quiz_set_option['quiz_all_results_show_publicly']) && $quiz_set_option['quiz_all_results_show_publicly'] == "on") ? true : false;

        $results = $this->get_user_reports_info( $quiz_id, $quiz_all_results_show_publicly );

        $default_quiz_all_results_columns = array(
            'user_name'  => 'user_name',
            'start_date' => 'start_date',
            'end_date'   => 'end_date',
            'duration'   => 'duration',
            'score'      => 'score',
        );
        
        $quiz_all_results_columns = (isset( $quiz_set_option['quiz_all_results_columns'] ) && !empty($quiz_set_option['quiz_all_results_columns']) ) ? $quiz_set_option['quiz_all_results_columns'] : $default_quiz_all_results_columns;
        $quiz_all_results_columns_order = (isset( $quiz_set_option['quiz_all_results_columns_order'] ) && !empty($quiz_set_option['quiz_all_results_columns_order']) ) ? $quiz_set_option['quiz_all_results_columns_order'] : $default_quiz_all_results_columns;

        $ays_default_header_value = array(
            "user_name"     => "<th style='width:20%;'>" . __( "User Name", 'quiz-maker' ) . "</th>",
            "start_date"    => "<th style='width:17%;'>" . __( "Start", 'quiz-maker' ) . "</th>",
            "end_date"      => "<th style='width:17%;'>" . __( "End", 'quiz-maker' ) . "</th>",
            "duration"      => "<th style='width:13%;'>" . __( "Duration", 'quiz-maker' ) . "</th>",
            "score"         => "<th style='width:13%;'>" . __( "Score", 'quiz-maker' ) . "</th>",
        );
        if($results === null){
            $all_results_html = "<p style='text-align: center;font-style:italic;'>" . __( "You must log in to see your results.", 'quiz-maker' ) . "</p>";
            return $all_results_html;
        }

        if( empty( $results ) ){
            $all_results_html = "";
            return $all_results_html;
        }
        
        $all_results_html = "<div class='ays-individual-quiz-all-results-container'>
        <table class='ays-individual-quiz-all-result-score-page' class='display'>
        <thead>
        <tr>";
        
        foreach ($quiz_all_results_columns_order as $key => $value) {
            if (isset($quiz_all_results_columns[$value])) {
                $all_results_html .= $ays_default_header_value[$value];
            }
        }
        
        $all_results_html .= "</tr></thead>";


        foreach($results as $key => $result){
            $id         = isset($result['id']) ? $result['id'] : null;
            $user_id    = isset($result['user_id']) ? intval($result['user_id']) : 0;
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
            $ays_default_html_order = array(
                "user_name" => "<td>$user_name</td>",
                "start_date" => "<td data-order='". $start_date_for_ordering ."'>$start_date</td>",
                "end_date" => "<td data-order='". $end_date_for_ordering ."'>$end_date</td>",
                "duration" => "<td data-order='". $duration_for_ordering ."' class='ays-quiz-duration-column'>$duration</td>",
                "score" => "<td class='ays-quiz-score-column'>$score%</td>",
            );

            $all_results_html .= "<tr>";
            foreach ($quiz_all_results_columns_order as $key => $value) {
                if (isset($quiz_all_results_columns[$value])) {
                    $all_results_html .= $ays_default_html_order[$value];
                }
            }
            $all_results_html .= "</tr>";
        }

        $all_results_html .= "</table>
            </div>";
        
        return $all_results_html;
    }

    public function ays_generate_quiz_all_results_method( $attr ) {
        $id = (isset($attr['id']) && $attr['id'] != '') ? absint(intval($attr['id'])) : null;

        $this->default_texts = Quiz_Maker_Public::ays_set_quiz_default_texts( $this->plugin_name, array() );

        if (is_null($id)) {
            $quiz_all_results_html = "<p class='wrong_shortcode_text' style='color:red;'>" . $this->default_texts['wrongShortcode'] . "</p>";
            return str_replace(array("\r\n", "\n", "\r"), '', $quiz_all_results_html);
        }

        $this->enqueue_styles();
        $this->enqueue_scripts();
        
        $quiz_all_results_html = $this->ays_quiz_all_results_html( $id );

        return str_replace(array("\r\n", "\n", "\r"), '', $quiz_all_results_html);
    }


}
