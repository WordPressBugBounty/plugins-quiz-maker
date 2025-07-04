<?php
    /**
     * Enqueue front end and editor JavaScript
     */

    function ays_quiz_gutenberg_scripts() {
        global $current_screen;
        global $wp_version;
        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.3';
        $versionCompare = ays_quiz_versionCompare($version1, $operator, $version2);

        if( ! $current_screen ){
            return null;
        }

        if( ! $current_screen->is_block_editor ){
            return null;
        }
        
        wp_enqueue_script( "jquery-effects-core");
        wp_enqueue_script( AYS_QUIZ_NAME . '-block_select2js', AYS_QUIZ_PUBLIC_URL . '/js/quiz-maker-select2.min.js', array('jquery'), AYS_QUIZ_VERSION, true);
        wp_enqueue_script( AYS_QUIZ_NAME . '-rateingjs', AYS_QUIZ_PUBLIC_URL . '/js/rating.min.js', array('jquery'), AYS_QUIZ_VERSION, true);
        wp_enqueue_script( AYS_QUIZ_NAME . '-ajax-public', AYS_QUIZ_PUBLIC_URL . '/js/quiz-maker-public-ajax.js', array('jquery'), AYS_QUIZ_VERSION, true);
        wp_enqueue_script( AYS_QUIZ_NAME, AYS_QUIZ_PUBLIC_URL . '/js/quiz-maker-public.js', array('jquery'), AYS_QUIZ_VERSION, true);
        wp_localize_script( AYS_QUIZ_NAME . '-ajax-public', 'quiz_maker_ajax_public', array('ajax_url' => admin_url('admin-ajax.php')));

        // Enqueue the bundled block JS file
        if ( $versionCompare ) {
            wp_enqueue_script(
                'quiz-maker-block-js',
                AYS_QUIZ_BASE_URL ."/quiz/quiz-maker-block-new.js",
                array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
                AYS_QUIZ_VERSION, true //( AYS_QUIZ_BASE_URL . 'quiz-maker-block.js' )
            );
        } else {
            wp_enqueue_script(
                'quiz-maker-block-js',
                AYS_QUIZ_BASE_URL ."/quiz/quiz-maker-block.js",
                array( 'jquery', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ),
                AYS_QUIZ_VERSION, true //( AYS_QUIZ_BASE_URL . 'quiz-maker-block.js' )
            );
        }
        wp_localize_script('ays-gutenberg-block-js', 'ays_quiz_block_ajax', array('aysDoShortCode' => admin_url( 'admin-ajax.php' )));
        
        wp_enqueue_style( AYS_QUIZ_NAME . '-block-font-awesome', AYS_QUIZ_PUBLIC_URL . '/css/quiz-maker-font-awesome.min.css', array(), AYS_QUIZ_VERSION, 'all');
        wp_enqueue_style( AYS_QUIZ_NAME . '-block-animate', AYS_QUIZ_PUBLIC_URL . '/css/animate.css', array(), AYS_QUIZ_VERSION, 'all');
        wp_enqueue_style( AYS_QUIZ_NAME . '-rating', AYS_QUIZ_PUBLIC_URL . '/css/rating.min.css', array(), AYS_QUIZ_VERSION, 'all');
        wp_enqueue_style( AYS_QUIZ_NAME . '-block-select2', AYS_QUIZ_PUBLIC_URL . '/css/quiz-maker-select2.min.css', array(), AYS_QUIZ_VERSION, 'all');
        wp_enqueue_style( AYS_QUIZ_NAME, AYS_QUIZ_PUBLIC_URL . '/css/quiz-maker-public.css', array(), AYS_QUIZ_VERSION, 'all');
        
        // Enqueue the bundled block CSS file
        if ( $versionCompare ) {
            wp_enqueue_style(
                'quiz-maker-block-css',
                AYS_QUIZ_BASE_URL ."/quiz/quiz-maker-block-new.css",
                array(),
                AYS_QUIZ_VERSION, 'all'
            );
        } else {
            wp_enqueue_style(
                'quiz-maker-block-css',
                AYS_QUIZ_BASE_URL ."/quiz/quiz-maker-block.css",
                array(),
                AYS_QUIZ_VERSION, 'all'
            );
        }
    }

    function ays_quiz_gutenberg_block_register() {
        
        global $wpdb;
        $block_name = 'quiz';
        $block_namespace = 'quiz-maker/' . $block_name;
        
        $sql = "SELECT id, title FROM ". $wpdb->prefix . "aysquiz_quizes WHERE published = 1 ORDER BY id DESC";
        $results = $wpdb->get_results($sql, "ARRAY_A");
        
        register_block_type(
            $block_namespace, 
            array(
                'render_callback'   => 'quizmaker_render_callback',                
                'editor_script'     => 'quiz-maker-block-js',  // The block script slug
                'style'             => 'quiz-maker-block-css',
                'attributes'	    => array(
                    'idner' => $results,
                    'metaFieldValue' => array(
                        'type'  => 'integer', 
                    ),
                    'shortcode' => array(
                        'type'  => 'string',				
                    ),
                    'className' => array(
                        'type'  => 'string',				
                    ),
                    'openPopupId' => array(
                        'type'  => 'string',
                    ),
                ),
            )
        );
    }    
    
    function quizmaker_render_callback( $attributes ) {
        $ays_html = "<div class='ays-quiz-render-callback-box'></div>";

        if(isset($attributes["metaFieldValue"]) && $attributes["metaFieldValue"] === 0) {
            return $ays_html;
        }

        if(isset($attributes["shortcode"]) && $attributes["shortcode"] != '') {
            $ays_html = do_shortcode( $attributes["shortcode"] );
        }
        return $ays_html;
    }

    function ays_quiz_versionCompare($version1, $operator, $version2) {
   
        $_fv = intval ( trim ( str_replace ( '.', '', $version1 ) ) );
        $_sv = intval ( trim ( str_replace ( '.', '', $version2 ) ) );
       
        if (strlen ( $_fv ) > strlen ( $_sv )) {
            $_sv = str_pad ( $_sv, strlen ( $_fv ), 0 );
        }
       
        if (strlen ( $_fv ) < strlen ( $_sv )) {
            $_fv = str_pad ( $_fv, strlen ( $_sv ), 0 );
        }
       
        return version_compare ( ( string ) $_fv, ( string ) $_sv, $operator );
    }

    if(function_exists("register_block_type")){
        global $wp_version;

        $version1 = $wp_version;
        $operator = '>=';
        $version2 = '5.2';
        $versionCompare = ays_quiz_versionCompare($version1, $operator, $version2);

        if ( $versionCompare && empty($_GET['page']) ) {
            // Hook scripts function into block editor hook
            add_action( 'enqueue_block_editor_assets', 'ays_quiz_gutenberg_scripts' );

            if ( version_compare( get_bloginfo( 'version' ), '5.9', '>=' ) ) {
                add_action( 'enqueue_block_assets', 'ays_quiz_gutenberg_scripts' );
            }

            add_action( 'init', 'ays_quiz_gutenberg_block_register' );
        }
    } 

    function ays_quiz_maker_is_chat_available() {

        // Define the working days and working hours
        $workingDays = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday');
        $startHour = 9; // 09:00 AM
        $endHour = 18;  // 06:00 PM

        // Get the current WordPress time (in server's timezone)
        $currentTime = current_time('timestamp'); // Server's current time in WordPress timezone

        // Get the server's GMT offset (in hours)
        $gmtOffset = get_option('gmt_offset'); // e.g., -4 for GMT-4 or +3 for GMT+3

        // Convert the server's time to your desired timezone
        // Calculate the difference between the server's time and our time
        $desiredOffset = 4;
        $offsetDifference = $desiredOffset - $gmtOffset;

        // Adjust the time based on the offset difference
        $adjustedTime = $currentTime + ($offsetDifference * 3600); // Add or subtract hours

        // Create a DateTime object from the adjusted time
        $adjustedDateTime = date('Y-m-d H:i:s', $adjustedTime); // Format it in a readable format

        // Get the day of the week and the hour in the adjusted time
        $dayOfWeek = date('l', strtotime($adjustedDateTime)); // e.g., 'Monday'
        $hour = (int) date('G', strtotime($adjustedDateTime)); // Get the hour in 24-hour format

        // Check if the current time is within working hours and working days
        if (in_array($dayOfWeek, $workingDays) && $hour >= $startHour && $hour < $endHour) {
            return true; // Chat is available
        } else {
            return false; // Chat is not available
        }
    }