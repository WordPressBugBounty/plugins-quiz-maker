<?php
$action = (isset($_GET['action'])) ? sanitize_text_field( $_GET['action'] ) : '';
$heading = '';
$loader_iamge = '';
$id = ( isset( $_GET['question_category'] ) ) ? absint( intval( $_GET['question_category'] ) ) : null;
$question_category = array(
    'id'            => '',
    'title'         => '',
    'description'   => '',
    'published'     => '1'
);
switch( $action ) {
    case 'add':
        $heading = __('Add new category', $this->plugin_name);
        break;
    case 'edit':
        $heading = __('Edit category', $this->plugin_name);
        $question_category = $this->question_categories_obj->get_question_category( $id );
        break;
}

$nex_question_cat_id = "";
$prev_question_cat_id = "";
if ( isset( $id ) && !is_null( $id ) ) {
    $nex_question_cat = $this->get_next_or_prev_row_by_id( $id, "next", "aysquiz_categories" );
    $nex_question_cat_id = (isset( $nex_question_cat['id'] ) && $nex_question_cat['id'] != "") ? absint( $nex_question_cat['id'] ) : null;

    $prev_question_cat = $this->get_next_or_prev_row_by_id( $id, "prev", "aysquiz_categories" );
    $prev_question_cat_id = (isset( $prev_question_cat['id'] ) && $prev_question_cat['id'] != "") ? absint( $prev_question_cat['id'] ) : null;
}

// General Settings | options
$gen_options = ($this->settings_obj->ays_get_setting('options') === false) ? array() : json_decode( stripcslashes($this->settings_obj->ays_get_setting('options') ), true);

$loader_iamge = "<span class='display_none ays_quiz_loader_box'><img src='". AYS_QUIZ_ADMIN_URL ."/images/loaders/loading.gif'></span>";

if( isset( $_POST['ays_submit'] ) ) {
    $_POST['id'] = $id;
    $result = $this->question_categories_obj->add_edit_question_category();
}
if(isset($_POST['ays_apply'])){
    $_POST["id"] = $id;
    $_POST['ays_change_type'] = 'apply';
    $this->question_categories_obj->add_edit_question_category();
}

if(isset($_POST['ays_save_new'])){
    $_POST["id"] = $id;
    $_POST['ays_change_type'] = 'save_new';
    $this->question_categories_obj->add_edit_question_category();
}

$question_category_title = (isset($question_category['title']) && $question_category['title'] != '') ? stripslashes( esc_attr($question_category['title']) ) : "";
$question_category_description = (isset($question_category['description']) && $question_category['description'] != '') ? stripslashes($question_category['description']) : "";
$question_category_published = (isset($question_category["published"]) && $question_category["published"] != '') ? stripslashes(esc_attr($question_category["published"])) : 1;

// WP Editor height
$quiz_wp_editor_height = (isset($gen_options['quiz_wp_editor_height']) && $gen_options['quiz_wp_editor_height'] != '') ? absint( sanitize_text_field($gen_options['quiz_wp_editor_height']) ) : 100 ;

?>
<div class="wrap">
    <div class="container-fluid">
        <div class="ays-quiz-heading-box">
            <div class="ays-quiz-wordpress-user-manual-box">
                <a href="https://quiz-plugin.com/docs/" target="_blank">
                    <i class="ays_fa ays_fa_file_text" ></i> 
                    <span style="margin-left: 3px;text-decoration: underline;"><?php echo __("View Documentation", "quiz-maker"); ?></span>
                </a>
            </div>
        </div>
        <h1><?php echo $heading; ?></h1>
        <hr/>
        <form class="ays-quiz-category-form ays-quiz-questions-real-category-form" id="ays-quiz-category-form" method="post">
            <input type="hidden" class="quiz_wp_editor_height" value="<?php echo $quiz_wp_editor_height; ?>">
            <div class="form-group row">
                <div class="col-sm-2">
                    <label for='ays-title'>
                        <?php echo __('Title', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Title of the question category',$this->plugin_name)?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-10">
                    <input class='ays-text-input' id='ays-title' name='ays_title' required type='text' value='<?php echo $question_category_title; ?>'>
                </div>
            </div>

            <hr/>
            <div class='ays-field form-group row'>
                <div class="col-sm-2">
                    <label for='ays-description'>
                        <?php echo __('Description', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Provide more information about the question category',$this->plugin_name)?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>
                <div class="col-sm-10">
                <?php
                    $content = $question_category_description;
                    $editor_id = 'ays-description';
                    $settings = array('editor_height'=> $quiz_wp_editor_height,'textarea_name'=>'ays_description','editor_class'=>'ays-textarea');
                    wp_editor($content, $editor_id, $settings);
                ?>
                </div>
            </div>

            <hr/>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label>
                        <?php echo __('Category status', $this->plugin_name); ?>
                        <a class="ays_help" data-toggle="tooltip" title="<?php echo __('Choose whether the question category is active or not. If you choose Unpublished option, the question category won’t be shown anywhere on your website',$this->plugin_name)?>">
                            <i class="ays_fa ays_fa_info_circle"></i>
                        </a>
                    </label>
                </div>

                <div class="col-sm-3">
                    <div class="form-check form-check-inline">
                        <input type="radio" id="ays-publish" name="ays_publish" value="1" <?php echo ( $question_category_published == '' ) ? "checked" : ""; ?> <?php echo ( $question_category_published == '1') ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="ays-publish"> <?php echo __('Published', $this->plugin_name); ?> </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="ays-unpublish" name="ays_publish" value="0" <?php echo ( $question_category_published  == '0' ) ? 'checked' : ''; ?> />
                        <label class="form-check-label" for="ays-unpublish"> <?php echo __('Unpublished', $this->plugin_name); ?> </label>
                    </div>
                </div>
            </div>

            <hr/>
            <div class="form-group row ays-question-button-box">
                <div class="col-sm-8 ays-question-button-first-row" style="padding: 0;">
                <?php
                    wp_nonce_field('question_category_action', 'question_category_action');
                    $other_attributes = array( 'id' => 'ays-button' );
                    submit_button( __( 'Save and close', $this->plugin_name ), 'primary ays-button ays-quiz-loader-banner', 'ays_submit', false, $other_attributes );
                    $other_attributes = array('id' => 'ays-button-save-new-top');
                    submit_button(__('Save and new', $this->plugin_name), 'primary ays-button ays-quiz-loader-banner', 'ays_save_new', false, $other_attributes);

                    $other_attributes = array( 
                        'id' => 'ays_apply',
                        'title' => 'Ctrl + s',
                        'data-toggle' => 'tooltip',
                        'data-delay'=> '{"show":"1000"}'
                    );
                    
                    submit_button( __( 'Save', $this->plugin_name), 'ays-button ays-quiz-loader-banner', 'ays_apply', false, $other_attributes);
                    echo $loader_iamge;
                ?>
                </div>
                <div class="col-sm-4 ays-question-button-second-row">
                <?php
                    if ( $prev_question_cat_id != "" && !is_null( $prev_question_cat_id ) ) {

                        $other_attributes = array(
                            'id'            => 'ays-question-category-prev-button',
                            'data-message'  => __( 'Are you sure you want to go to the previous question category page?', $this->plugin_name),
                            'href'          => sprintf( '?page=%s&action=%s&question_category=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $prev_question_cat_id ) )
                        );
                        submit_button(__('Prev Question Category', $this->plugin_name), 'button button-primary ays_default_btn ays-quiz-category-next-button-class ays-button', 'ays_question_cat_prev_button', false, $other_attributes);
                    }

                    if ( $nex_question_cat_id != "" && !is_null( $nex_question_cat_id ) ) {

                        $other_attributes = array(
                            'id'            => 'ays-question-category-next-button',
                            'data-message'  => __( 'Are you sure you want to go to the next question category page?', $this->plugin_name),
                            'href'          => sprintf( '?page=%s&action=%s&question_category=%d', esc_attr( $_REQUEST['page'] ), 'edit', absint( $nex_question_cat_id ) )
                        );
                        submit_button(__('Next Question Category', $this->plugin_name), 'button button-primary ays_default_btn ays-quiz-category-next-button-class ays-button', 'ays_question_cat_next_button', false, $other_attributes);
                    }
                ?>
                </div>
            </div>
        </form>
    </div>
</div>