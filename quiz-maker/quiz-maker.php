<?php
ob_start();
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ays-pro.com/
 * @since             3.0.0
 * @package           Quiz_Maker
 *
 * @wordpress-plugin
 * Plugin Name:       Quiz Maker
 * Plugin URI:        https://ays-pro.com/wordpress/quiz-maker
 * Description:       Create powerful and engaging quizzes, tests, and exams in minutes. Build an unlimited number of quizzes and questions.
 * Version:           6.7.0.33
 * Author:            Quiz Maker team
 * Author URI:        https://ays-pro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quiz-maker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AYS_QUIZ_NAME_VERSION', '6.7.0.33' );
define( 'AYS_QUIZ_VERSION', '6.7.0.33' );
define( 'AYS_QUIZ_NAME', 'quiz-maker' );

if( ! defined( 'AYS_QUIZ_BASENAME' ) )
    define( 'AYS_QUIZ_BASENAME', plugin_basename( __FILE__ ) );

if( ! defined( 'AYS_QUIZ_DIR' ) )
    define( 'AYS_QUIZ_DIR', plugin_dir_path( __FILE__ ) );

if( ! defined( 'AYS_QUIZ_BASE_URL' ) ) {
    define( 'AYS_QUIZ_BASE_URL', plugin_dir_url(__FILE__ ) );
}
if( ! defined( 'AYS_QUIZ_ADMIN_URL' ) )
    define( 'AYS_QUIZ_ADMIN_URL', plugin_dir_url( __FILE__ ) . 'admin' );

if( ! defined( 'AYS_QUIZ_PUBLIC_URL' ) )
    define( 'AYS_QUIZ_PUBLIC_URL', plugin_dir_url( __FILE__ ) . 'public' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quiz-maker-activator.php
 */
function activate_quiz_maker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quiz-maker-activator.php';
	Quiz_Maker_Activator::ays_quiz_update_db_check();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quiz-maker-deactivator.php
 */
function deactivate_quiz_maker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quiz-maker-deactivator.php';
	Quiz_Maker_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quiz_maker' );
register_deactivation_hook( __FILE__, 'deactivate_quiz_maker' );

add_action( 'plugins_loaded', 'activate_quiz_maker' );

if(get_option('ays_quiz_rate_state') === false){
    add_option( 'ays_quiz_rate_state', 0 );
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quiz-maker.php';

require plugin_dir_path( __FILE__ ) . 'quiz/quiz-maker-block.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_quiz_maker() {
    // add_action( 'activated_plugin', 'quiz_maker_activation_redirect_method' );
    add_action('admin_notices', 'quiz_maker_general_admin_notice');
	$plugin = new Quiz_Maker();
	$plugin->run();

}

function qm_get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function quiz_maker_activation_redirect_method( $plugin ) {
    if( $plugin == plugin_basename( __FILE__ ) ) {
        exit( wp_redirect( esc_url( admin_url( 'admin.php?page=' . AYS_QUIZ_NAME ) ) ) );
    }
}

function quiz_maker_general_admin_notice(){
    global $wpdb;
    if ( isset( $_GET['page'] ) && strpos( sanitize_text_field( $_GET['page'] ), AYS_QUIZ_NAME ) !== false ) {
        $is_chat_available = ays_quiz_maker_is_chat_available();
        ?>
         <div class="ays-notice-banner">
            <div class="navigation-bar">
                <div id="navigation-container">
                    <div class="ays-quiz-logo-container-upgrade">
                        <div class="logo-container">
                            <a href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=quiz-maker-top-banner-logo-link-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank" style="display: inline-block;box-shadow: none;">
                                <img  class="quiz-logo" src="<?php echo esc_url( plugin_dir_url( __FILE__ ) . 'admin/images/icons/quiz-maker-logo.png' ); ?>" alt="<?php echo esc_attr( __( "Quiz Maker", 'quiz-maker' ) ); ?>" title="<?php echo esc_attr( __( "Quiz Maker", 'quiz-maker' ) ); ?>"/>
                            </a>
                        </div>
                        <div class="ays-quiz-upgrade-container">
                            <a href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=quiz-top-banner-upgrade-button-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank" target="_blank">
                                <!-- <img src="<?php #echo esc_attr(AYS_QUIZ_ADMIN_URL) . '/images/icons/lightning.svg'; ?>"> -->
                                <img src="<?php echo esc_attr(AYS_QUIZ_ADMIN_URL . '/images/icons/lightning-white.svg'); ?>" class="ays-quiz-svg-light-hover">
                                <span><?php echo esc_html__( "Upgrade", 'quiz-maker' ); ?></span>
                            </a>
                            <span class="ays-quiz-logo-container-one-time-text"><?php echo esc_html__( "One-time payment", 'quiz-maker' ); ?></span>
                        </div>

                        <div class="ays-quiz-coupon-container">
                            <div class="ays-quiz-coupon-box ays-quiz-copy-element-box-parent">
                                <!-- <img src="<?php echo esc_attr(AYS_QUIZ_ADMIN_URL . '/images/icons/receipt-solid.svg'); ?>" class="ays-quiz-svg-light-hover"> -->
                                <span onClick="selectAndCopyElementContents(this)" class="ays-quiz-copy-element-box" data-toggle="tooltip" title="<?php echo esc_html__( "Click for copy", 'quiz-maker' ); ?>"><?php echo esc_html( "summer2025", 'quiz-maker' ); ?></span>
                            </div>
                            <span class="ays-quiz-logo-container-one-time-text"><?php echo esc_html__( "Extra 20% Coupon", 'quiz-maker' ); ?></span>
                        </div>
                    </div>
                    <ul id="menu">
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=quiz-maker-top-banner-pricing-link-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank"><?php echo esc_html__( "Pricing", 'quiz-maker' ); ?></a></li>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://quiz-plugin.com/wordpress-quiz-plugin-free-demo/" target="_blank"><?php echo esc_html__( "Demo", 'quiz-maker' ); ?></a></li>
                        <li class="modile-ddmenu-lg modile-ddmenu-lg-custom"><a class="ays-btn" href="https://wordpress.org/support/plugin/quiz-maker/" target="_blank"><?php echo esc_html__( "Free Support", 'quiz-maker' ); ?></a></li>
                        <!-- <li class="modile-ddmenu-lg take_survay modile-ddmenu-lg-custom"><a class="ays-btn" href="https://ays-demo.com/quiz-maker-plugin-feedback-survey/" target="_blank"><?php echo esc_html__( "Make a Suggestion", 'quiz-maker' ); ?></a></li> -->
                        <li class="modile-ddmenu-lg ays_quiz_take_gift modile-ddmenu-lg-custom"><a class="ays-btn" href="https://quiz-plugin.com/quiz-addon-as-a-gift/" target="_blank"><?php echo __( "Grab your GIFT", 'quiz-maker' ); ?></a></li>
                        <?php if($is_chat_available): ?>
                        <li class="modile-ddmenu-xs"><a class="ays-btn" href="https://ays-pro.com/onlinesupport/" target="_blank"><?php echo esc_html__( "Live Chat", 'quiz-maker' ); ?></a></li>
                        <?php endif; ?>
                        <li class="modile-ddmenu-lg"><a class="ays-btn" href="https://ays-pro.com/contact" target="_blank"><?php echo esc_html__( "Contact us", 'quiz-maker' ); ?></a></li>
                        <li class="modile-ddmenu-md">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">
                                <li><a class="ays-btn" href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=quiz-maker-top-banner-pricing-link-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank"><?php echo esc_html__( "Pricing", 'quiz-maker' ); ?></a></li>
                                <!-- <li class="take_survay"><a class="ays-btn" href="https://ays-demo.com/quiz-maker-plugin-feedback-survey/" target="_blank"><?php echo esc_html__( "Make a Suggestion", 'quiz-maker' ); ?></a></li> -->
                                <li class="ays_quiz_take_gift"><a class="ays-btn" href="https://quiz-plugin.com/quiz-addon-as-a-gift/" target="_blank"><?php echo __( "Grab your GIFT", 'quiz-maker' ); ?></a></li>
                                <li><a class="ays-btn" href="https://quiz-plugin.com/wordpress-quiz-plugin-free-demo/" target="_blank"><?php echo esc_html__( "Demo", 'quiz-maker' ); ?></a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/quiz-maker/" target="_blank"><?php echo esc_html__( "Free Support", 'quiz-maker' ); ?></a></li>
                                <li><a class="ays-btn" href="https://ays-pro.com/contact" target="_blank"><?php echo esc_html__( "Contact us", 'quiz-maker' ); ?></a></li>
                            </ul>
                        </li>
                        <li class="modile-ddmenu-sm">
                            <a class="toggle_ddmenu" href="javascript:void(0);"><i class="ays_fa ays_fa_ellipsis_h"></i></a>
                            <ul class="ddmenu" data-expanded="false">
                                <li><a class="ays-btn" href="https://ays-pro.com/wordpress/quiz-maker?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=quiz-maker-top-banner-pricing-link-<?php echo esc_attr( AYS_QUIZ_VERSION ); ?>" target="_blank"><?php echo esc_html__( "Pricing", 'quiz-maker' ); ?></a></li>
                                <li><a class="ays-btn" href="https://quiz-plugin.com/wordpress-quiz-plugin-free-demo/" target="_blank"><?php echo esc_html__( "Demo", 'quiz-maker' ); ?></a></li>
                                <li><a class="ays-btn" href="https://wordpress.org/support/plugin/quiz-maker/" target="_blank"><?php echo esc_html__( "Free Support", 'quiz-maker' ); ?></a></li>
                                <!-- <li class="take_survay"><a class="ays-btn" href="https://ays-demo.com/quiz-maker-plugin-feedback-survey/" target="_blank"><?php echo esc_html__( "Make a Suggestion", 'quiz-maker' ); ?></a></li> -->
                                <li class="ays_quiz_take_gift"><a class="ays-btn" href="https://quiz-plugin.com/quiz-addon-as-a-gift/" target="_blank"><?php echo __( "Grab your GIFT", 'quiz-maker' ); ?></a></li>
                                <?php if($is_chat_available): ?>
                                <li><a class="ays-btn" href="https://ays-pro.com/onlinesupport/" target="_blank"><?php echo esc_html__( "Live Chat", 'quiz-maker' ); ?></a></li>
                                <?php endif; ?>
                                <li><a class="ays-btn" href="https://ays-pro.com/contact" target="_blank"><?php echo esc_html__( "Contact us", 'quiz-maker' ); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
         </div>

        <!-- Ask a question box start -->
        <?php if($is_chat_available): ?>
            <?php
            if(get_option('ays_quiz_agree_terms') === 'true'): ?>
            <div class="ays-quiz-crisp-chat-online-status">
            </div>
            <?php else: ?>
            <div class="ays_live_chat_ask_question_content ays_ask_question_content">
                <div class="ays_ask_question_content_inner">
                    <a href="https://ays-pro.com/onlinesupport/" class="ays_quiz_question_link" target="_blank">
                        <span class="ays-ask-question-content-inner-question-mark-text"></span>
                        <span class="ays-ask-question-content-inner-hidden-text"><?php echo esc_html__( "Live Chat", 'quiz-maker' ); ?></span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        <?php else: ?>
        <div class="ays_ask_question_content">
            <div class="ays_ask_question_content_inner">
                <a href="https://wordpress.org/support/plugin/quiz-maker/" class="ays_quiz_question_link" target="_blank">
                    <span class="ays-ask-question-content-inner-question-mark-text">?</span>
                    <span class="ays-ask-question-content-inner-hidden-text"><?php echo esc_html__( "Ask a question", 'quiz-maker' ); ?></span>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <!-- Ask a question box end -->
         <?php
            $ays_quiz_rate = intval(get_option('ays_quiz_rate_state'));
            $sql = "SELECT COUNT(*) AS res_count FROM {$wpdb->prefix}aysquiz_reports";
            $results = $wpdb->get_row($sql, 'ARRAY_A');
            if (!is_null($results) && !empty($results)) {
                if(($results['res_count'] >= 5000) && ($ays_quiz_rate < 4)){
                    update_option('ays_quiz_rate_state', 4);
                    ays_quiz_rate_message(5000);
                }elseif(($results['res_count'] >= 1000) && ($ays_quiz_rate < 3)){                
                    update_option('ays_quiz_rate_state', 3);
                    ays_quiz_rate_message(1000);
                }elseif(($results['res_count'] >= 500) && ($ays_quiz_rate < 2)){                
                    update_option('ays_quiz_rate_state', 2);
                    ays_quiz_rate_message(500);
                }elseif(($results['res_count'] >= 100) && ($ays_quiz_rate < 1)){                
                    update_option('ays_quiz_rate_state', 1);
                    ays_quiz_rate_message(100);
                }
            }
    }
}
    
function ays_quiz_rate_message($count){
     ?>
     <div class="quiz_toast__container">
        <div class="quiz_toast__cell">
            <div class="quiz_toast quiz_toast--red">
                <div class="quiz_toast__main">
                    <div class="quiz_toast__icon">
                        <svg version="1.1" class="quiz_toast__svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 301.691 301.691" style="enable-background:new 0 0 301.691 301.691;" xml:space="preserve">
                            <g>
                                <polygon points="119.151,0 129.6,218.406 172.06,218.406 182.54,0  "></polygon>
                                <rect x="130.563" y="261.168" width="40.525" height="40.523"></rect>
                            </g>
                        </svg>
                    </div>
                    <div class="quiz_toast__content">
                        <p class="quiz_toast__type">
                            <?php 
                                echo sprintf( esc_attr( __('Wow!!! Excellent job!! Your quizzes was passed by more than %s people!!', 'quiz-maker') ), intval($count));
                            ?>
                        </p>
                        <p class="quiz_toast__message">
                            <?php echo sprintf( '<span>%s</span> <a class="quiz_toast__rate_button" href="https://wordpress.org/support/plugin/quiz-maker/reviews/?rate=5#new-post" target="_blank">%s</a>', 'Satisfied with our Quiz Maker plugin? It brings a lot of user to your website? Then it\'s time to rate us!! ', esc_attr(__('Rate Us', 'quiz-maker'))); ?>
                        </p>
                    </div>
                </div>
                <div class="quiz_toast__close">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 15.642 15.642">
                        <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <?php
}
run_quiz_maker();
