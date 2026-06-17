<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/includes
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quiz_Maker
 * @subpackage Quiz_Maker/includes
 * @author     AYS Pro LLC <info@ays-pro.com>
 */
class Quiz_Maker_Data {

	public static function ays_quiz_allowed_html() {
        $additionalAllowedTags = wp_kses_allowed_html('post');
        return array_merge(
            $additionalAllowedTags,
            array(
                'div' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'style'                 => true,
                    'data-*'                => true,
                    'aria-selected'         => true,
                ),
                'svg' => array(
                    'class'                 => true,
                    'width'                 => true,
                    'height'                => true,
                    'viewBox'               => true,
                    'viewbox'               => true,
                    'xmlns'                 => true,
                    'fill'                  => true,
                ),
                'path' => array(
                    'class'                 => true,
                    'd'                     => true,
                    'fill'                  => true,
                    'fill-rule'             => true,
                    'clip-rule'             => true,
                    'stroke-width'          => true,
                    'stroke-linecap'        => true,
                ),
                'circle'                    => array(
                    'style'                 => true,
                    'id'                    => true,
                    'class'                 => true,
                    'r'                     => true,
                    'cx'                    => true,
                    'cy'                    => true,
                ),
                'rect' => array(
                    'class'                 => true,
                    'x'                     => true,
                    'y'                     => true,
                    'width'                 => true,
                    'height'                => true,
                    'rx'                    => true,
                    'fill'                  => true,
                    'stroke'                => true,
                    'style'                 => true,
                    'transform'             => true,
                ),
                'defs' => array(
                    'class'                 => true,
                    'width'                 => true,
                    'height'                => true,
                    'fill'                  => true,
                    'style'                 => true,
                ),
                'pattern' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'width'                 => true,
                    'height'                => true,
                    'patternContentUnits'   => true,
                    'patterncontentunits'   => true,
                    'style'                 => true,
                ),
                'use' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'xlink'                 => true,
                    'xlink:href'            => true,
                    'transform'             => true,
                    'style'                 => true,
                ),
                'image' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'xlink'                 => true,
                    'xlink:href'            => true,
                    'width'                 => true,
                    'height'                => true,
                    'style'                 => true,
                ),
                'video' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'controls'              => true,
                    'style'                 => true,
                ),
                'source' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'src'                   => true,
                    'style'                 => true,
                ),
                'form' => array(
                    'name'                  => true,
                    'id'                    => true,
                    'action'                => true,
                    'method'                => true,
                    'data-*'                => true,
                    'style'                 => true,
                ),
                'input' => array(
                    'id'                    => true,
                    'name'                  => true,
                    'class'                 => true,
                    'type'                  => true,
                    'value'                 => true,
                    'size'                  => true,
                    'required'              => true,
                    'readonly'              => true,
                    'data-*'                => true,
                    'style'                 => true,
                ),
                'select' => array(
                    'id'                    => true,
                    'name'                  => true,
                    'class'                 => true,
                    'type'                  => true,
                    'value'                 => true,
                    'size'                  => true,
                    'required'              => true,
                    'readonly'              => true,
                    'data-*'                => true,
                    'style'                 => true,
                ),
                'option' => array(
                    'id'                    => true,
                    'class'                 => true,
                    'type'                  => true,
                    'value'                 => true,
                    'size'                  => true,
                    'required'              => true,
                    'readonly'              => true,
                    'data-*'                => true,
                    'style'                 => true,
                ),
                'progress' => array(
                    'id'                    => true,
                    'class'                 => true,
                    'max'                   => true,
                    'value'                 => true,
                    'data-*'                => true,
                    'style'                 => true,
                ),
                'img' => array(
                    'id'                    => true,
                    'class'                 => true,
                    'loading'               => true,
                    'decoding'              => true,
                    'src'                   => true,
                    'sizes'                 => true,
                    'srcset'                => true,
                    'width'                 => true,
                    'height'                => true,
                ),
                'a' => array(
                    'aria-selected'         => true,
                    'data-*'                => true,
                    'style'                 => true,
                    'target'                => true,
                ),
            ),
            $additionalAllowedTags
        );
    }

    public static function ays_quiz_custom_allowed_html() {
        $additionalAllowedTags = self::ays_quiz_allowed_html();
        return array_merge(
            $additionalAllowedTags,
            array(
                'iframe' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'width'                 => true,
                    'height'                => true,
                    'src'                   => true,
                    'title'                 => true,
                    'frameborder'           => true,
                    'allow'                 => true,
                    'allowfullscreen'       => true,
                    'loading'               => true,
                    'referrerpolicy'        => true,
                    'style'                 => true,
                ),
                'audio' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'controls'              => true,
                    'autoplay'              => true,
                    'loop'                  => true,
                    'muted'                 => true,
                    'preload'               => true,
                    'src'                   => true,
                    'style'                 => true,
                ),
                'source' => array(
                    'src'                   => true,
                    'type'                  => true,
                ),
                'track' => array(
                    'kind'                  => true,
                    'src'                   => true,
                    'srclang'               => true,
                    'label'                 => true,
                    'default'               => true,
                ),
                'video' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'width'                 => true,
                    'height'                => true,
                    'controls'              => true,
                    'autoplay'              => true,
                    'loop'                  => true,
                    'muted'                 => true,
                    'poster'                => true,
                    'preload'               => true,
                    'src'                   => true,
                    'style'                 => true,
                ),
                'picture' => array(
                    'class'                 => true,
                    'id'                    => true,
                ),
                'figure' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'style'                 => true,
                ),
                'figcaption' => array(
                    'class'                 => true,
                    'id'                    => true,
                    'style'                 => true,
                ),
            ),
            $additionalAllowedTags
        );
    }

    public static function ays_quiz_get_buttons_order(){

        $setting_actions = new Quiz_Maker_Settings_Actions(AYS_QUIZ_NAME);
        $quiz_buttons_order = $setting_actions->ays_get_setting('quiz_buttons_order');
        if($quiz_buttons_order){
            $quiz_buttons_order = json_decode( $quiz_buttons_order, true );
        }else{
            $quiz_buttons_order = array();
        }

        $settings_ordering = self::ays_quiz_get_settings_order_defaults();

        $buttons_ordering = $settings_ordering['buttons'];
        $buttons_ordering_mobile = $settings_ordering['buttons'];
    
        $buttons_default_sort = array_keys($buttons_ordering);
    

        $quiz_buttons_order_desctop  = (isset($quiz_buttons_order['desktop']) && !empty($quiz_buttons_order['desktop'])) ? $quiz_buttons_order['desktop'] : $buttons_default_sort;
        $quiz_buttons_order_mobile  = (isset($quiz_buttons_order['mobile']) && !empty($quiz_buttons_order['mobile'])) ? $quiz_buttons_order['mobile'] : $buttons_default_sort;

        $result = array();
        foreach ($quiz_buttons_order_desctop as $key){
            $result['desktop'][$key] = isset($buttons_ordering[$key]) ? $buttons_ordering[$key] : '';
            unset($buttons_ordering[$key]);
        }
        foreach($buttons_ordering as $bin=>$key){
            $result['desktop'][$bin] = $key;

        }

        foreach ($quiz_buttons_order_mobile as $key){
            $result['mobile'][$key] = isset($buttons_ordering_mobile[$key]) ? $buttons_ordering_mobile[$key] : '';
            unset($buttons_ordering_mobile[$key]);
        }
        foreach($buttons_ordering_mobile as $bin=>$key){
            $result['mobile'][$bin] = $key;

        }

        return $result;

    }

    public static function ays_quiz_get_settings_order_defaults(){
        $buttons_ordering = array(
            'clear'     =>  __('Clear','quiz-maker'),
            'prev'      =>  __('Prev','quiz-maker'),
            'finish'    =>  __('Finish','quiz-maker'),
            'next'      =>  __('Next','quiz-maker'),
            'save'      =>  __('Save','quiz-maker'),
        );

        return array(
            'buttons' => $buttons_ordering
        );
    }
}