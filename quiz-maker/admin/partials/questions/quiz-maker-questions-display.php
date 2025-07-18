<?php
global $wpdb;

$tab = 'tab1';

$action = ( isset($_GET['action']) ) ? sanitize_text_field( $_GET['action'] ) : '';
$id     = ( isset($_GET['question']) ) ? sanitize_text_field( $_GET['question'] ) : null;

if($action == 'duplicate'){
    $this->questions_obj->duplicate_question($id);
}
$example_export_path = AYS_QUIZ_ADMIN_URL . '/partials/questions/export_file/';
$plus_icon_svg = "<span class=''><img src='". AYS_QUIZ_ADMIN_URL ."/images/icons/plus-icon.svg'></span>";
$youtube_icon_svg = "<span class=''><img src='". AYS_QUIZ_ADMIN_URL ."/images/icons/youtube-video-icon.svg'></span>";

$question_max_id = $this->get_max_id('questions');

?>

<div class="wrap ays-quiz-list-table ays_questions_list_table">
    <div class="ays-quiz-heading-box ays-quiz-heading-box-margin-top">
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
    <?php do_action('ays_quiz_sale_banner'); ?>
    <div class="question-action-butons">
        <!--<div class="ays-quiz-export-import-box">
            <div class="ays-quiz-export-import-video-tutorial">
                <a href="https://www.youtube.com/watch?v=RldosodJItI&" target="_blank">
                    <?php #echo esc_attr(__('Video tutorial','quiz-maker')); ?>
                </a>
            </div>
        </div> -->
        <div class="ays-quiz-export-import-tooltip">
            <a class="ays_help mr-2" style="font-size:20px;" data-toggle="tooltip" title="<?php echo esc_attr( __("For import XLSX file your version of PHP must be over than 5.6.", 'quiz-maker') ); ?>">
                <i class="ays_fa ays_fa_info_circle"></i>
            </a>
        </div>
        <div class="dropdown ays-export-dropdown" style="">
            <a href="javascript:void(0);" data-toggle="dropdown" class="button mr-2 dropdown-toggle">
                <span class="ays-wp-loading d-none"></span>
                <?php echo esc_html__('Example', 'quiz-maker'); ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right ays-dropdown-menu">
                <a href="<?php echo esc_attr($example_export_path); ?>example_questions_export.csv"                    
                   download="example_questions_export.csv" class="dropdown-item">
                    CSV
                </a>
                <a href="<?php echo esc_attr($example_export_path); ?>example_questions_export.xlsx"
                   download="example_questions_export.xlsx" class="dropdown-item">
                    XLSX
                </a>
                <a href="<?php echo esc_attr($example_export_path); ?>example_questions_export.json"
                   download="example_questions_export.json" class="dropdown-item">
                    JSON
                </a>
                <a href="<?php echo esc_attr($example_export_path); ?>example_questions_export_simple.xlsx"
                   download="example_questions_export_simple.xlsx" class="dropdown-item">
                    Simple XLSX
                </a>
            </div>
        </div>
        <div class="ays-quiz-pro-features-box" style="position: relative; margin-right: 10px;" title="<?php echo esc_attr( __('This property available only in pro version','quiz-maker') ); ?>">
            <div class="pro_features pro_features_popup">
                <div class="pro-features-popup-conteiner">
                    <div class="pro-features-popup-title">
                        <?php echo esc_html__("Export/import questions", 'quiz-maker'); ?>
                    </div>
                    <div class="pro-features-popup-content" data-link="https://youtu.be/_lGi6PBamGg">
                        <p>
                            <?php echo  sprintf( wp_kses_post( __("The feature allows you to save time by exporting and importing already-created questions quickly and easily. You can download the example file formats %s (XLSX, CSV, JSON, Simple XLSX)%s, add your questions/answers there, and import the file to the plugin. You just need to make sure that the file you are importing has the same structure as our example file.", 'quiz-maker' ) ), 
                                '<strong>',
                                '</strong>'
                            ); ?>
                        </p>
                        <div>
                            <a href="https://quiz-plugin.com/docs/" target="_blank"><?php echo esc_html__("See Documentation", 'quiz-maker'); ?></a>
                        </div>
                    </div>
                    <div class="pro-features-popup-button" data-link="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=question-export-import-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>">
                        <?php echo esc_html__("Pricing", 'quiz-maker'); ?>
                    </div>
                </div>
            </div>
            <div> 
                <a href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=question-export-import-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank" title="<?php echo esc_attr( __('This property available only in pro version','quiz-maker') ); ?>" class="button disabled-button"><?php echo esc_html__('Export to', 'quiz-maker'); ?></a>
            </div>
        </div>
        <div class="ays-quiz-pro-features-box" style="position: relative; margin-right: 10px;" title="<?php echo esc_attr( __('This property available only in pro version','quiz-maker') ); ?>">
            <div class="pro_features pro_features_popup">
                <div class="pro-features-popup-conteiner">
                    <div class="pro-features-popup-title">
                        <?php echo esc_html__("Export/import questions", 'quiz-maker'); ?>
                    </div>
                    <div class="pro-features-popup-content" data-link="https://youtu.be/_lGi6PBamGg">
                        <p>
                            <?php echo wp_kses_post( __("The feature allows you to save time by exporting and importing already-created questions quickly and easily. You can download the example file formats (XLSX, CSV, JSON, Simple XLSX), add your questions/answers there, and import the file to the plugin. You just need to make sure that the file you are importing has the same structure as our example file.", 'quiz-maker') ); ?>
                        </p>
                        <div>
                            <a href="https://quiz-plugin.com/docs/" target="_blank"><?php echo esc_html__("See Documentation", 'quiz-maker'); ?></a>
                        </div>
                    </div>
                    <div class="pro-features-popup-button" data-link="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=question-export-import-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>">
                        <?php echo esc_html__("Pricing", 'quiz-maker'); ?>
                    </div>
                </div>
            </div>
            <div>
                <a href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=question-export-import-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank" title="<?php echo esc_attr( __('This property available only in pro version','quiz-maker') ); ?>" class="button disabled-button" aria-expanded="false"><?php echo esc_html__('Import', 'quiz-maker'); ?></a>
            </div>
        </div>
    </div>
    <div class="ays-quiz-heading-box ays-quiz-unset-float">
        <div class="ays-quiz-wordpress-user-manual-box ays-quiz-wordpress-text-align">
            <a href="https://www.youtube.com/watch?v=_lGi6PBamGg" target="_blank">
                <?php echo esc_html__("How to export/import questions - video", 'quiz-maker'); ?>
            </a>
        </div>
    </div>

    <div class="nav-tab-wrapper">
        <a href="#tab1" class="nav-tab <?php echo ($tab == 'tab1') ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html__("Questions", 'quiz-maker'); ?>
        </a>
        <a href="#tab2" class="nav-tab <?php echo ($tab == 'tab2') ? 'nav-tab-active' : ''; ?>">
            <?php echo esc_html__("Reports", 'quiz-maker'); ?>
        </a>
    </div>

    <div id="tab1" style="margin-top: 20px;" class="ays-quiz-tab-content <?php echo ($tab == 'tab1') ? 'ays-quiz-tab-content-active' : ''; ?>">
        <div class="ays-quiz-add-new-button-box">
            <?php
                echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action button-primary ays-quiz-add-new-button ays-quiz-add-new-button-new-design"> %s '  . esc_html__('Add New', 'quiz-maker') . '</a>', esc_attr( $_REQUEST['page'] ), 'add', $plus_icon_svg);
            ?>
        </div>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder">
                <div id="post-body-content">
                    <div class="meta-box-sortables ui-sortable">
                        <?php
                            $this->questions_obj->views();
                        ?>
                        <form method="post">
                            <?php
                                $this->questions_obj->prepare_items();
                                $search = esc_html__( "Search", 'quiz-maker' );
                                $this->questions_obj->search_box($search, 'quiz-maker');
                                $this->questions_obj->display();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <br class="clear">
        </div>

        <div class="ays-quiz-add-new-button-box">
            <?php
                echo sprintf( '<a href="?page=%s&action=%s" class="page-title-action button-primary ays-quiz-add-new-button ays-quiz-add-new-button-new-design"> %s '  . esc_html__('Add New', 'quiz-maker') . '</a>', esc_attr( $_REQUEST['page'] ), 'add', $plus_icon_svg);
            ?>
        </div>

        <?php if($question_max_id <= 9): ?>
        <div class="ays-quiz-create-survey-video-box" style="margin: 0px auto 30px;">
            <div class="ays-quiz-create-survey-title">
                <h4><?php echo esc_html__( "All Question Types Explained in One Video", 'quiz-maker' ); ?></h4>
            </div>
            <div class="ays-quiz-create-survey-youtube-video">
                <div class="ays-quiz-youtube-placeholder" data-video-id="ok6f59iV_R0">
                    <img src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL .'/images/youtube/all-question-type.webp'); ?>" loading="lazy" width="560" height="315">
                </div>
            </div>
            <div class="ays_quiz_small_hint_text_for_message_variables" style="text-align: center;">
                <?php echo esc_html__( 'The video preview will disappear after you create 10 questions.', 'quiz-maker' ); ?>
            </div>
            <div class="ays-quiz-create-survey-youtube-video-button-box">
                <?php echo sprintf( '<a href="?page=%s&action=%s" class="ays-quiz-add-new-button-video ays-quiz-add-new-button-new-design"> %s ' . esc_html__('Add New', 'quiz-maker') . '</a>', esc_attr( $_REQUEST['page'] ), 'add', wp_kses_post( $plus_icon_svg ));?>
            </div>
        </div>
        <?php else: ?>
        <div class="ays-quiz-create-survey-video-box ays-quiz-create-survey-video-box-only-link" style="margin: auto;">
            <div class="ays-quiz-create-survey-title">
                <?php echo wp_kses_post($youtube_icon_svg); ?>
                <a href="https://www.youtube.com/watch?v=ok6f59iV_R0" target="_blank" title="YouTube video player"><?php echo esc_html__("All Question Types Explained in One Video", 'quiz-maker'); ?></a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div id="tab2" class="ays-quiz-tab-content <?php echo ($tab == 'tab2') ? 'ays-quiz-tab-content-active' : ''; ?>">
        <div class="row" style="margin: 0; margin-top:20px;">
            <div class="col-sm-12 only_pro">
                <div class="pro_features pro_features_popup_only_hover">

                </div>
                <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL.'/images/question_reports_screen.png' ); ?>" alt="<?php echo esc_attr( __( "Question Reports", 'quiz-maker' ) ); ?>" style="width:100%;" >
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

                                <div class="pro-features-popup-modal-right-box-footer-text">
                                    <span class="ays_quiz_small_hint_text_for_message_variables"><?php echo esc_html__( "One-time payment", 'quiz-maker' ); ?></span>
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
