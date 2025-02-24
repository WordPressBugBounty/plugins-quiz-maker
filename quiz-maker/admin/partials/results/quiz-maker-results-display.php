<?php

if(isset($_GET['ays_result_tab'])){
    $tab = sanitize_key( $_GET['ays_result_tab'] );
}else{
    $tab = 'poststuff';
}

$reviews_page_url = sprintf('?page=%s', $this->plugin_name."-all-reviews");
$quiz_results_plugin_nonce = wp_create_nonce( 'quiz-maker-ajax-results-nonce' );

?>
<div class="wrap ays-quiz-list-table ays_results_list_table">
    <div class="ays-quiz-heading-box">
        <div class="ays-quiz-wordpress-user-manual-box">
            <a href="https://quiz-plugin.com/docs/" target="_blank">
                <i class="ays_fa ays_fa_file_text" ></i> 
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo esc_html__("View Documentation", "quiz-maker"); ?></span>
            </a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
        <?php
        echo esc_html(get_admin_page_title());
        ?>
    </h1>
    <div class="ays-quiz-export-import-box">
        <div class="only_pro">
            <div class="pro_features pro_features_popup">
                <div class="pro-features-popup-conteiner">
                    <div class="pro-features-popup-title">
                        <?php echo esc_html__("Export Results", 'quiz-maker'); ?>
                    </div>
                    <div class="pro-features-popup-content" data-link="https://www.youtube.com/watch?v=vHiXPuHM7CA">
                        <p>
                            <?php echo esc_html__("The WordPress Quiz Maker plugin allows you to export the result pages easily.", 'quiz-maker'); ?>
                        </p>
                        <p>
                            <?php echo sprintf( wp_kses_post( __("You also have an opportunity to filter whose results and what quiz results you want to export. Filter %s by Users, Quizzes, by both Users and Quizzes, %s and also select the period by choosing the date.", 'quiz-maker') ),
                                "<strong>",
                                "</strong>"
                            ); ?>
                        </p>
                        <p>
                            <?php echo esc_html__("Here for filtering you have two more checkboxes- export only guest’s results or include guests who do not have any personal data. The choice is yours. Just choose the best variant for you.", 'quiz-maker'); ?>
                        </p>
                        <p>
                            <?php echo sprintf( wp_kses_post( __("After filtering you should choose the file format for exporting the results page. You have three variants- %s CSV, XLSX, and JSON. %s", 'quiz-maker') ),
                                "<strong>",
                                "</strong>"
                            ); ?>
                        </p>
                        <div>
                            <a href="https://quiz-plugin.com/docs/" target="_blank"><?php echo esc_html__("See Documentation", 'quiz-maker'); ?></a>
                        </div>
                    </div>
                    <div class="pro-features-popup-button" data-link="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pro-popup-export-results">
                        <?php echo esc_html__("Upgrade PRO NOW", 'quiz-maker'); ?>
                    </div>
                </div>
            </div>
            <div>
                <a href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pro-popup-export-results" target="_blank" class="ays-quiz-export-button-link">
                    <button class="disabled-button" title="<?php echo esc_attr( __( "This property available only in pro version", 'quiz-maker' ) ); ?>" ><?php echo esc_html__('Export','quiz-maker'); ?></button>
                </a>
            </div>
        </div>
    </div>
    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab <?php echo ($tab == 'poststuff') ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Results','quiz-maker'); ?></a>
        <a href="#tab2" class="nav-tab <?php echo ($tab == 'statistics') ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Statistics','quiz-maker')?></a>
        <a href="#tab3" class="nav-tab <?php echo ($tab == 'leaderboard') ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Leaderboard','quiz-maker')?></a>
        <a href="<?php echo esc_url($reviews_page_url); ?>" class="no-js nav-tab <?php echo ($tab == 'reviews') ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('Reviews','quiz-maker')?></a>
    </div>
    <div id="tab1" class="ays-quiz-tab-content <?php echo ($tab == 'poststuff') ? 'ays-quiz-tab-content-active' : ''; ?>">
        <div id="poststuff">
            <div id="post-body" class="metabox-holder">
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <?php
                            $this->results_obj->views();
                        ?>
                        <form method="post">
                            <?php
                            $this->results_obj->prepare_items();
                            $this->results_obj->search_box('Search', 'quiz-maker');
                            $this->results_obj->display();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <br class="clear">
        </div>
    </div>

    <div id="tab2" class="ays-quiz-tab-content <?php echo ($tab == 'statistics') ? 'ays-quiz-tab-content-active' : ''; ?>">
        <br>
        <div class="row" style="margin:0;">
            <div class="col-sm-12 only_pro">
                <div class="pro_features pro_features_popup_only_hover">

                </div>
                <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/chart_screen.png' ); ?>" alt="Statistics" style="width:100%;">
                <a href="https://ays-pro.com/wordpress/quiz-maker" target="_blank" class="ays-quiz-new-upgrade-button-link">
                    <div class="ays-quiz-new-upgrade-button-box">
                        <div>
                            <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/icons/locked_24x24.svg' ); ?>">
                            <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/icons/unlocked_24x24.svg' ); ?>" class="ays-quiz-new-upgrade-button-hover">
                        </div>
                        <div class="ays-quiz-new-upgrade-button"><?php echo esc_html__("Upgrade", "quiz-maker"); ?></div>
                    </div>
                </a>
                <div class="ays-quiz-center-big-main-button-box ays-quiz-new-big-button-flex">
                    <div class="ays-quiz-center-big-upgrade-button-box">
                        <a href="https://ays-pro.com/wordpress/quiz-maker" target="_blank" class="ays-quiz-new-upgrade-button-link">
                            <div class="ays-quiz-center-new-big-upgrade-button">
                                <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/icons/locked_24x24.svg' ); ?>" class="ays-quiz-new-button-img-hide">
                                <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/icons/unlocked_24x24.svg' ); ?>" class="ays-quiz-new-upgrade-button-hover">  
                                <?php echo esc_html__("Upgrade", "quiz-maker"); ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="tab3" class="ays-quiz-tab-content <?php echo ($tab == 'leaderboard') ? 'ays-quiz-tab-content-active' : ''; ?>">
        <p class="ays-subtitle"><?php echo esc_html__('Leaderboard','quiz-maker')?></p>
        <hr class="ays-quiz-bolder-hr">
        <?php 
            global $wpdb;
            $sql = "SELECT quiz_id, user_id, AVG(CAST(`score` AS DECIMAL(10))) AS avg_score
                    FROM {$wpdb->prefix}aysquiz_reports
                    WHERE user_id != 0
                    GROUP BY user_id
                    ORDER BY avg_score DESC
                    LIMIT 10";
            $result = $wpdb->get_results($sql, 'ARRAY_A');

            $c = 1;
            $content = "<div class='ays_lb_container'>
            <ul class='ays_lb_ul' style='width: 100%;'>
                <li class='ays_lb_li'>
                    <div class='ays_lb_pos'>".esc_html__("Pos.", 'quiz-maker')."</div>
                    <div class='ays_lb_user'>".esc_html__("Name", 'quiz-maker')."</div>
                    <div class='ays_lb_score'>".esc_html__("Score", 'quiz-maker')."</div>
                </li>";

            foreach ($result as $val) {
                $score = round($val['avg_score'], 2);
                $user = get_user_by('id', $val['user_id']);
                if ($user !== false) {
                    $user_name = $user->data->display_name ? $user->data->display_name : $user->user_login;

                    $content .= "<li class='ays_lb_li'>
                                    <div class='ays_lb_pos'>".$c.".</div>
                                    <div class='ays_lb_user'>".$user_name."</div>
                                    <div class='ays_lb_score'>".$score." %</div>
                                </li>";
                    $c++;   
                }
            }
            $content .= "</ul>
            </div>";
            echo $content;
        ?>
    </div>
    
    <div id="ays-results-modal" class="ays-modal">
        <div class="ays-modal-content">
            <div class="ays-quiz-preloader">
                <img class="loader" src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL); ?>/images/loaders/3-1.svg">
            </div>
            <div class="ays-modal-header">
                <span class="ays-close" id="ays-close-results">&times;</span>
                <h2><?php echo esc_html__("Results for", 'quiz-maker'); ?></h2>
            </div>
            <div class="ays-modal-body" id="ays-results-body">
            </div>
        </div>
        <input type="hidden" id="ays_quiz_ajax_results_nonce" name="ays_quiz_ajax_results_nonce" value="<?php echo esc_attr($quiz_results_plugin_nonce); ?>">
    </div>

    <div class="ays-modal" id="pro-features-popup-modal">
        <div class="ays-modal-content">
            <!-- Modal Header -->
            <div class="ays-modal-header">
                <span class="ays-close-pro-popup">&times;</span>
                <!-- <h2></h2> -->
            </div>

            <!-- Modal body -->
            <div class="ays-modal-body">
               <div class="row">
                    <div class="col-sm-6 pro-features-popup-modal-left-section">
                    </div>
                    <div class="col-sm-6 pro-features-popup-modal-right-section">
                       <div class="pro-features-popup-modal-right-box">
                            <div class="pro-features-popup-modal-right-box-icon"><i class="ays_fa ays_fa_lock"></i></div>

                            <div class="pro-features-popup-modal-right-box-title"></div>

                            <div class="pro-features-popup-modal-right-box-content"></div>

                            <div class="pro-features-popup-modal-right-box-button">
                                <a href="#" class="pro-features-popup-modal-right-box-link" target="_blank"></a>
                            </div>
                       </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="ays-modal-footer" style="display:none">
            </div>
        </div>
    </div>
    
</div>
