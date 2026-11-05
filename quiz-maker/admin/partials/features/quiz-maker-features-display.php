<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Created by PhpStorm.
 * User: biggie18
 * Date: 7/30/18
 * Time: 12:08 PM
 */
// $url = "https://quiz-plugin.com/pricing/";
// wp_safe_redirect( $url );
// exit;
?>

<div class="wrap ays-quiz-features-wrap-box">
    <div class="ays-quiz-heading-box ays-quiz-heading-box-margin-top">
        <div class="ays-quiz-wordpress-user-manual-box">
            <a href="https://quiz-plugin.com/docs/" target="_blank">
                <i class="ays_fa ays_fa_file_text" ></i>
                <span style="margin-left: 3px;text-decoration: underline;"><?php echo esc_html__("View Documentation", "quiz-maker"); ?></span>
            </a>
        </div>
    </div>
    <h1 class="wp-heading-inline">
        <?php echo esc_html__( 'PRO Features' , 'quiz-maker'); ?>
    </h1>
    <?php do_action('ays_quiz_sale_banner'); ?>
    <h3 class="wp-heading" style="text-align: center;">
        <?php echo esc_html__( 'Limited Offer' , 'quiz-maker'); ?>
    </h3>
    <div class="ays-quiz-features-wrap">
        <div class="ays-quiz-features-toggle ays-quiz-features-toggle-mobile">
            <label for="ays_quiz_pricing_period_mobile">
                <?php echo esc_html__( "Yearly", 'quiz-maker' ); ?>
            </label>
            <div class="ays-quiz-toggle-switch-container">
                <label class="ays-quiz-toggle-switch" for="ays_quiz_pricing_period_mobile">
                    <input type="checkbox" id="ays_quiz_pricing_period_mobile" value="on" autocomplete="off">
                    <span class="slider round"></span>
                </label>
            </div>
            <label for="ays_quiz_pricing_period_mobile">
                <?php echo esc_html__( "Lifetime", 'quiz-maker' ); ?>
            </label>
        </div>
        <div class="comparison">
            <table>
                <thead>
                    <tr>
                        <th class="tl tl2"></th>
                        <th class="product" style="background:#69C7F1; border-top-left-radius: 5px; border-left:0px;">
                            <span style="display: block"><?php echo esc_html__('Personal','quiz-maker'); ?></span>
                            <img src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL) . '/images/avatars/personal_avatar.png'; ?>" alt="Free" title="Free" width="100" height="100"/>
                        </th>
                        <th class="product" style="background:#69C7F1;">
                            <span style="display: block"><?php echo  esc_html__('Business','quiz-maker'); ?></span>
                            <img src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL) . '/images/avatars/business_avatar.png'; ?>" alt="Business" title="Business" width="100" height="100"/>
                        </th>
                        <th class="product" style="border-top-right-radius: 5px; background:#69C7F1;">
                            <span style="display: block"><?php echo esc_html__('Developer','quiz-maker'); ?></span>
                            <img src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL) . '/images/avatars/pro_avatar.png'; ?>" alt="Developer" title="Developer" width="100" height="100"/>
                        </th>
                        <th class="product" style="border-top-right-radius: 5px; border-right:0px; background:#69C7F1;">
                            <span style="display: block"><?php echo esc_html__('Agency','quiz-maker'); ?></span>
                            <img src="<?php echo esc_url(AYS_QUIZ_ADMIN_URL) . '/images/avatars/agency_avatar.png'; ?>" alt="Agency" title="Agency" width="100" height="100"/>
                        </th>
                    </tr>
                    <tr>
                        <th>
                            <div class="ays-quiz-features-toggle ays-quiz-features-toggle-pc">
                                <label for="ays_quiz_pricing_period">
                                    <?php echo esc_html__( "Yearly", 'quiz-maker' ); ?>
                                </label>
                                <div class="ays-quiz-toggle-switch-container">
                                    <label class="ays-quiz-toggle-switch" for="ays_quiz_pricing_period">
                                        <input type="checkbox" id="ays_quiz_pricing_period" value="on" autocomplete="off">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <label for="ays_quiz_pricing_period">
                                    <?php echo esc_html__( "Lifetime", 'quiz-maker' ); ?>
                                </label>
                            </div>
                        </th>
                        <th class="price-info">
                            <div class="price-now"><span><?php echo esc_html__('Free','quiz-maker')?></span></div>
                        </th>
                        <th class="price-info">
                            <div class="price-now">
                                <div class="ays-quiz-features-annual sale-price">$75</div>
                                <div class="ays-quiz-features-lifetime sale-price display_none">$196</div>
                            </div>
                            <div class="price-now">
                                <span class="ays-quiz-features-annual">$49</span>
                                <span class="ays-quiz-features-lifetime display_none">$147</span>
                            </div>
                            <!-- <div class="price-now"><span style="color: red; font-size: 12px;">Black Friday</span>
                            </div> -->
                            <div class="ays-quiz-pracing-table-td-flex">
                                <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-business-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                                <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                                <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                            </div>
                        </th>
                        <th class="price-info">
                            <div class="price-now">
                                <div class="ays-quiz-features-annual sale-price">$250</div>
                                <div class="ays-quiz-features-lifetime sale-price display_none">$516</div>
                            </div>
                            <div class="price-now">
                                <span class="ays-quiz-features-annual">$129</span>
                                <span class="ays-quiz-features-lifetime display_none">$387</span>
                            </div>
                            <!-- <div class="price-now"><span style="color: red; font-size: 12px;">Black Friday</span>
                            </div> -->
                            <div class="ays-quiz-pracing-table-td-flex">
                                <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-developer-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                                <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                                <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                            </div>
                        </th>
                        <th class="price-info">
                            <div class="price-now">
                                <div class="ays-quiz-features-annual sale-price">$450</div>
                                <div class="ays-quiz-features-lifetime sale-price display_none">$996</div>
                            </div>
                            <div class="price-now">
                                <span class="ays-quiz-features-annual">$249</span>
                                <span class="ays-quiz-features-lifetime display_none">$747</span>
                            </div>
                            <!-- <div class="price-now"><span style="color: red; font-size: 12px;">Black Friday</span>
                            </div> -->
                            <div class="ays-quiz-pracing-table-td-flex">
                                <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-agency-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                                <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                                <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td colspan="4"><?php echo esc_html__('Usage Limit','quiz-maker')?></td>
                    </tr>
                    <tr>
                        <td><?php echo esc_html__('Usage Limit','quiz-maker')?></td>
                        <td><span>–</span></td>
                        <td><?php echo esc_html__('1 site','quiz-maker')?></td>
                        <td><?php echo esc_html__('10 sites','quiz-maker')?></td>
                        <td><?php echo esc_html__('30 sites','quiz-maker')?></td>
                    </tr>
                <tr>
                    <td> </td>
                    <td colspan="4"><?php echo esc_html__('Unlimited quizzes & attempts','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Unlimited quizzes & attempts','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="4"><?php echo esc_html__('Capture leads & contact info','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Capture leads & contact info','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="4"><?php echo esc_html__('Randomize questions & answers','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Randomize questions & answers','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td> </td>
                    <td colspan="4"><?php echo esc_html__('Reports in dashboard','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Reports in dashboard','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Question weight','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Question weight','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Points system','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Points system','quiz-maker')?></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Reporting and Analysis','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Reporting and Analysis','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('AI question builder','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('AI question builder','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('User Dashboard','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('User Dashboard','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Paypal and Stripe Integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Paypal and Stripe Integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Conditional Results','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Conditional Results','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Save and Resume','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Save and Resume','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Advanced Timer','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Advanced Timer','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Leaderboards','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Leaderboards','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Advanced Flashcards','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Advanced Flashcards','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Export and import','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Export and import','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Popup Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Popup Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Summary Emails','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Summary Emails','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('reCAPTCHA','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('reCAPTCHA','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Google sheets integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Google sheets integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Mailchimp integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Mailchimp integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Campaign Monitor integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Campaign Monitor integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Zapier integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Zapier integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Slack integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Slack integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('ActiveCampaign integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('ActiveCampaign integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('URL Parameters','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('URL Parameters','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Advanced Display Quizzes','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Advanced Display Quizzes','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Category Selective Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Category Selective Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Training Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Training Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Brevo integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Brevo integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Klaviyo integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Klaviyo integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Woocommerce integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Woocommerce integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Easy Digital Downloads integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Easy Digital Downloads integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Extra Shortcodes','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Extra Shortcodes','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Track Users','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Track Users','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Chained Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Chained Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('MyCred integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('MyCred integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('GamiPress integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('GamiPress integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Uncanny integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Uncanny integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Gemini integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Gemini integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Chat Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Chat Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Generate Quiz','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Generate Quiz','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Frontend Request','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Frontend Request','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('DeepSeek integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('DeepSeek integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Razorpay integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Razorpay integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Aweber integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Aweber integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Frontend Statistics','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Frontend Statistics','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('MailerLite integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('MailerLite integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><?php echo esc_html__('Mailpoet integration','quiz-maker')?></td>
                </tr>
                <tr>
                    <td><?php echo esc_html__('Mailpoet integration','quiz-maker')?></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><span>–</span></td>
                    <td><i class="ays_fa ays_fa_check"></i></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-see-all-features-business-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>#quiz-Features" target="_blank" class="ays-quiz-features-see-all"><?php echo esc_html__('See All Features','quiz-maker')?></a></td>
                    <td><a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-see-all-features-developer-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>#quiz-Features" target="_blank" class="ays-quiz-features-see-all"><?php echo esc_html__('See All Features','quiz-maker')?></a></td>
                    <td><a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-see-all-features-agency-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>#quiz-Features" target="_blank" class="ays-quiz-features-see-all"><?php echo esc_html__('See All Features','quiz-maker')?></a></td>
                </tr>

                <tr>
                    <td> </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="ays-quiz-pracing-table-td-flex">
                            <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-business-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                            <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                            <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="ays-quiz-pracing-table-td-flex">
                            <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-developer-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                            <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                            <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                        </div>
                    </td>
                    <td>
                        <div class="ays-quiz-pracing-table-td-flex">
                            <a href="https://quiz-plugin.com/pricing/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-table-agency-<?php echo esc_attr( AYS_QUIZ_UTM_VERSION ); ?>" class="price-buy"><?php echo esc_html__('Buy now','quiz-maker')?><span class="hide-mobile"></span></a>
                            <span class="ays-quiz-features-annual"><?php echo esc_html__('(Billed yearly)', 'quiz-maker'); ?></span>
                            <span class="ays-quiz-features-lifetime display_none"><?php echo esc_html__('(One-time payment)', 'quiz-maker'); ?></span>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="ays-quiz-heading-box ays-quiz-unset-float ays-quiz-heading-box-center" style="gap: 20px;">
        <div class="ays-quiz-wordpress-user-manual-box">
            <a href="<?php echo esc_url('https://quiz-plugin.com/features/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-menu-all-features-' . AYS_QUIZ_UTM_VERSION); ?>" target="_blank" style="text-decoration: none;font-size: 20px;">
                <i class="ays_fa ays_fa_file_text" width="24"></i>
                <span style="margin-left: 3px; text-decoration: underline; font-size: 18px;"><?php echo esc_html__('All Features', "quiz-maker"); ?></span>
            </a>
        </div>
        <div class="ays-quiz-wordpress-user-manual-box">
            <a href="https://www.youtube.com/watch?v=y-uCWOVmdEE" target="_blank" style="text-decoration: none;font-size: 20px;">
                <span><img src='<?php echo esc_url(AYS_QUIZ_ADMIN_URL); ?>/images/icons/youtube-video-icon.svg' width="24"></span>
                <span style="margin-left: 3px; text-decoration: underline; font-size: 18px;"><?php echo esc_html__('Watch plans comparison video', "quiz-maker"); ?></span>
            </a>
        </div>
    </div>
    <?php if( 1 == 1 ): ?>
    <div class="ays-quiz-heading-box ays-quiz-unset-float ays-quiz-heading-box-center" style="gap: 20px; margin-top: 30px;">
        <div class="ays-quiz-wordpress-user-manual-box">
            <a href="<?php echo esc_url('https://quiz.ays-plugins.com/?utm_source=dashboard&utm_medium=quiz-free&utm_campaign=pricing-menu-live-demo-' . AYS_QUIZ_UTM_VERSION); ?>" target="_blank" class="ays-quiz-comparison-secondary-button" style="text-decoration: none;font-size: 20px;">
                <span style="margin-left: 3px; font-size: 18px;"><?php echo esc_html__('Try Pro Version Admin demo', "quiz-maker"); ?></span>
            </a>
        </div>
    </div>
    <?php endif; ?>
    <div class="ays-quiz-sm-content-row-sg">
        <div class="ays-quiz-sm-guarantee-container-sg ays-quiz-sm-center-box-sg">
            <img src="<?php echo esc_url( AYS_QUIZ_ADMIN_URL ); ?>/images/money_back_logo.webp" alt="Best money-back guarantee logo">
            <div class="ays-quiz-sm-guarantee-text-container-sg">
                <h3><?php echo esc_html__("30 day money back guarantee !!!", 'quiz-maker'); ?></h3>
                <p>
                    <?php echo esc_html__("We're sure that you'll love our Quiz Maker plugin, but, if for some reason, you're not
                    satisfied in the first 30 days of using our product, there is a money-back guarantee and
                    we'll issue a refund.", 'quiz-maker'); ?>

                </p>
            </div>
        </div>
    </div>
</div>

