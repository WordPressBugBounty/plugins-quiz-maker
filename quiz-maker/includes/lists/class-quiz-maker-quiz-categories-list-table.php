<?php
ob_start();
class Quiz_Categories_List_Table extends WP_List_Table{
    private $plugin_name;
    private $title_length;
    /** Class constructor */
    public function __construct($plugin_name) {
        $this->plugin_name = $plugin_name;
        $this->title_length = Quiz_Maker_Admin::get_listtables_title_length('quiz_categories');
        parent::__construct( array(
            'singular' => __( 'Quiz Category', 'quiz-maker' ), //singular name of the listed records
            'plural'   => __( 'Quiz Categories', 'quiz-maker' ), //plural name of the listed records
            'ajax'     => false //does this table support ajax?
        ) );
        add_action( 'admin_notices', array( $this, 'quiz_category_notices' ) );
    }

    /**
     * Override of table nav to avoid breaking with bulk actions & according nonce field
     */
    public function display_tablenav( $which ) {
        ?>
        <div class="tablenav <?php echo esc_attr( $which ); ?>">

            <div class="alignleft actions">
                <?php $this->bulk_actions( $which ); ?>
            </div>

            <?php
            $this->extra_tablenav( $which );
            $this->pagination( $which );
            ?>
            <br class="clear" />
        </div>
        <?php
    }

    /**
     * Disables the views for 'side' context as there's not enough free space in the UI
     * Only displays them on screen/browser refresh. Else we'd have to do this via an AJAX DB update.
     *
     * @see WP_List_Table::extra_tablenav()
     */
    public function extra_tablenav($which) {

        $quiz_cat_description = array(
            "with"    => __( "With description", 'quiz-maker'),
            "without" => __( "Without description", 'quiz-maker'),
        );

        $description_key = null;

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
        }

        ?>
 
        <div id="quiz-filter-div-<?php echo esc_attr( $which ); ?>" class="alignleft actions bulkactions">

            <select name="filterbyDescription-<?php echo esc_attr( $which ); ?>" id="bulk-action-quiz-cat-description-selector-<?php echo esc_attr( $which ); ?>">
                <option value=""><?php echo esc_html__('With/without description','quiz-maker'); ?></option>
                <?php
                    foreach($quiz_cat_description as $key => $cat_description) {
                        $selected = "";
                        if( $description_key === sanitize_text_field($key) ) {
                            $selected = "selected";
                        }
                        echo "<option ".esc_attr($selected)." value='".esc_attr( $key )."'>".esc_html($cat_description)."</option>";
                    }
                ?>
            </select>
            <input type="button" id="doaction-quiz-<?php echo esc_attr( $which ); ?>" class="ays-quiz-question-tab-all-filter-button-<?php echo esc_attr( $which ); ?> button" value="<?php echo esc_attr( __( "Filter", 'quiz-maker' ) ); ?>">
        </div>

        <a style="" href="?page=<?php echo esc_attr( sanitize_text_field( $_REQUEST['page'] ) ); ?>" class="button"><?php echo esc_html__( "Clear filters", 'quiz-maker' ); ?></a>
        <?php
    }

    
    protected function get_views() {
        $published_count = $this->published_quiz_categories_count();
        $unpublished_count = $this->unpublished_quiz_categories_count();
        $all_count = $this->all_record_count();
        $selected_all = "";
        $selected_0 = "";
        $selected_1 = "";
        if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){

            $fstatus  = absint( $_REQUEST['fstatus'] );

            switch( $fstatus ){
                case 0:
                    $selected_0 = " style='font-weight:bold;' ";
                    break;
                case 1:
                    $selected_1 = " style='font-weight:bold;' ";
                    break;
                default:
                    $selected_all = " style='font-weight:bold;' ";
                    break;
            }
        }else{
            $selected_all = " style='font-weight:bold;' ";
        }

        $admin_url = get_admin_url( null, 'admin.php' );
        $get_properties = http_build_query($_GET);

        $status_links_url = $admin_url . "?" . $get_properties;
        $publish_url = esc_url( add_query_arg('fstatus', 1, $status_links_url) );
        $unpublish_url = esc_url( add_query_arg('fstatus', 0, $status_links_url) );

        $status_links = array(
            "all"           => "<a ".$selected_all." href='?page=".esc_attr( $_REQUEST['page'] )."'>". __( 'All', 'quiz-maker' )." (".$all_count.")</a>",
            "published"     => "<a ".$selected_1." href='". $publish_url ."'>". __( 'Published', 'quiz-maker' )." (".$published_count.")</a>",
            "unpublished"   => "<a ".$selected_0." href='". $unpublish_url ."'>". __( 'Unpublished', 'quiz-maker' )." (".$unpublished_count.")</a>"
        );
        return $status_links;
    }

    
    /**
     * Retrieve customers data from the database
     *
     * @param int $per_page
     * @param int $page_number
     *
     * @return mixed
     */
    public static function get_quiz_categories( $per_page = 20, $page_number = 1, $search = '' ) {

        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}aysquiz_quizcategories";

        $where = array();

        if( $search != '' ){
            $where[] = $search;
        }

        if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
            if( esc_sql( $_REQUEST['fstatus'] ) != '' ){
                $fstatus  = absint( esc_sql( $_REQUEST['fstatus'] ) );
                $where[] = " published = ".$fstatus." ";
            }
        }

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
            
            switch ( $description_key ) {
                case 'with':
                    $where[] = ' `description` != "" ';
                    break;
                case 'without':
                default:
                    $where[] = ' `description` = "" ';
                    break;
            }
        }

        if( ! empty($where) ){
            $sql .= " WHERE " . implode( " AND ", $where );
        }

        if ( ! empty( $_REQUEST['orderby'] ) ) {

            $order_by  = ( isset( $_REQUEST['orderby'] ) && sanitize_text_field( $_REQUEST['orderby'] ) != '' ) ? sanitize_text_field( $_REQUEST['orderby'] ) : 'id';
            $order_by .= ( ! empty( $_REQUEST['order'] ) && strtolower( $_REQUEST['order'] ) == 'asc' ) ? ' ASC' : ' DESC';

            $sql_orderby = sanitize_sql_orderby($order_by);

            if ( $sql_orderby ) {
                $sql .= ' ORDER BY ' . $sql_orderby;
            } else {
                $sql .= ' ORDER BY id DESC';
            }

        }else{
            $sql .= ' ORDER BY id DESC';
        }

        $sql .= " LIMIT $per_page";
        $sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


        $result = $wpdb->get_results( $sql, 'ARRAY_A' );

        return $result;
    }

    public function get_quiz_category( $id ) {
        global $wpdb;

        $sql = "SELECT * FROM {$wpdb->prefix}aysquiz_quizcategories WHERE id=" . absint( intval( $id ) );

        $result = $wpdb->get_row($sql, 'ARRAY_A');

        return $result;
    }

    public function add_edit_quiz_category(){
        global $wpdb;
        $quiz_category_table = $wpdb->prefix . 'aysquiz_quizcategories';
        $ays_change_type = (isset($_POST['ays_change_type'])) ? sanitize_text_field( $_POST['ays_change_type'] ) : '';
        if( isset($_POST["quiz_category_action"]) && wp_verify_nonce( sanitize_text_field( $_POST["quiz_category_action"] ), 'quiz_category_action' ) ){
            
            $id = absint( sanitize_text_field( $_POST['id'] ) );
            $title = stripslashes( sanitize_text_field( $_POST['ays_title'] ) );
            $description =  wp_kses_post( $_POST['ays_description'] );
            $publish = absint( sanitize_text_field( $_POST['ays_publish'] ) );
            $message = '';
            if( $id == 0 ){
                $result = $wpdb->insert(
                    $quiz_category_table,
                    array(
                        'title'         => $title,
                        'description'   => $description,
                        'published'     => $publish
                    ),
                    array(
                        '%s', //title
                        '%s', //description
                        '%d'  //published
                    )
                );
                $message = 'created';
            }else{
                $result = $wpdb->update(
                    $quiz_category_table,
                    array(
                        'title'         => $title,
                        'description'   => $description,
                        'published'     => $publish
                    ),
                    array( 'id' => $id ),
                    array( 
                        '%s', //title
                        '%s', //description
                        '%d'  //published
                    ),
                    array( '%d' )
                );
                $message = 'updated';
            }

            if( $result >= 0  ) {
                if($ays_change_type != ''){
                    if($id == null){
                        $url = esc_url_raw( add_query_arg( array(
                            "action"    => "edit",
                            "quiz_category"  => $wpdb->insert_id,
                            "status"    => $message
                        ) ) );
                    }else{
                        $url = esc_url_raw( remove_query_arg(false) ) . '&status=' . $message;
                    }
                    wp_redirect( $url );
                }else{
                    $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category')  ) ) . '&status=' . $message;
                    wp_redirect( $url );
                }
            }
        }
    }

    /**
     * Delete a customer record.
     *
     * @param int $id customer ID
     */
    public static function delete_quiz_categories( $id ) {
        global $wpdb;
        $wpdb->delete(
            "{$wpdb->prefix}aysquiz_quizcategories",
            array( 'id' => $id ),
            array( '%d' )
        );
    }

    public static function ays_quiz_published_unpublished_quiz_categories( $id, $status = 'published' ) {
        global $wpdb;

        $quizcategories_table = esc_sql( $wpdb->prefix . "aysquiz_quizcategories" );

        if ( is_null( $id ) || absint( sanitize_text_field( $id ) ) == 0 ) {
            return null;
        }

        $id = absint( sanitize_text_field( $id ) );

        switch ( $status ) {
            case 'published':
                $published = 1;
                break;
            case 'unpublished':
                $published = 0;
                break;
            default:
                $published = 1;
                break;
        }

        $categories_result = $wpdb->update(
            $quizcategories_table,
            array(
                'published' => $published,
            ),
            array( 'id' => $id ),
            array(
                '%d'
            ),
            array( '%d' )
        );
    }

    public function duplicate_quiz_categories( $id ){
        global $wpdb;

        if ( is_null( $id ) || empty($id) || $id == 0 ) {
            return;
        }

        $quiz_category_table = $wpdb->prefix . 'aysquiz_quizcategories';
        $quiz_category_data = $this->get_quiz_categories_by_id($id);
        
        $title = (isset($quiz_category_data['title']) && $quiz_category_data['title'] != "") ? stripslashes( sanitize_text_field( $quiz_category_data['title'] ) ) : __("Copy", 'quiz-maker');
        $description =  (isset($quiz_category_data['description']) && $quiz_category_data['description'] != "") ? wp_kses_post( $quiz_category_data['description'] ) : "";
        $publish = (isset($quiz_category_data['published']) && $quiz_category_data['published'] != "") ? absint( sanitize_text_field( $quiz_category_data['published'] ) ) : 0;

        $result = $wpdb->insert(
            $quiz_category_table,
            array(
                'title'         =>  "Copy - " . $title,
                'description'   => $description,
                'published'     => $publish
            ),
            array(
                '%s', //title
                '%s', //description
                '%d'  //published
            )
        );
        if( $result >= 0 ){
            $message = "duplicated";
            $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category')  ) ) . '&status=' . $message;
            wp_redirect( $url );
        }
        
    }


    /**
     * Returns the count of records in the database.
     *
     * @return null|string
     */
    public static function record_count() {
        global $wpdb;

        $where = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories";

        $search = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( $_REQUEST['s'] ) : false;
        if( $search ){
            $where[] = sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) );
        }

        if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
            if( esc_sql( $_REQUEST['fstatus'] ) != '' ){
                $fstatus  = absint( esc_sql( $_REQUEST['fstatus'] ) );
                $where[] = " published = ".$fstatus." ";
            }
        }

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
            
            switch ( $description_key ) {
                case 'with':
                    $where[] = ' `description` != "" ';
                    break;
                case 'without':
                default:
                    $where[] = ' `description` = "" ';
                    break;
            }
        }

        if(count($where) !== 0){
            $sql .= " WHERE ".implode(" AND ", $where);
        }

        return $wpdb->get_var( $sql );
    }

    public static function all_record_count() {
        global $wpdb;

        $where = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories";

        $search = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( $_REQUEST['s'] ) : false;
        if( $search ){
            $where[] = sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) );
        }

        // if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
        //     if( esc_sql( $_REQUEST['fstatus'] ) != '' ){
        //         $fstatus  = absint( esc_sql( $_REQUEST['fstatus'] ) );
        //         $where[] = " published = ".$fstatus." ";
        //     }
        // }

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
            
            switch ( $description_key ) {
                case 'with':
                    $where[] = ' `description` != "" ';
                    break;
                case 'without':
                default:
                    $where[] = ' `description` = "" ';
                    break;
            }
        }

        if(count($where) !== 0){
            $sql .= " WHERE ".implode(" AND ", $where);
        }

        return $wpdb->get_var( $sql );
    }

    public static function published_quiz_categories_count() {
        global $wpdb;

        $where = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories ";

        $where[] = ' `published` = 1 ';

        $search = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( $_REQUEST['s'] ) : false;
        if( $search ){
            $where[] = sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) );
        }

        // if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
        //     if( esc_sql( $_REQUEST['fstatus'] ) != '' ){
        //         $fstatus  = absint( esc_sql( $_REQUEST['fstatus'] ) );
        //         $where[] = " published = ".$fstatus." ";
        //     }
        // }

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
            
            switch ( $description_key ) {
                case 'with':
                    $where[] = ' `description` != "" ';
                    break;
                case 'without':
                default:
                    $where[] = ' `description` = "" ';
                    break;
            }
        }

        if(count($where) !== 0){
            $sql .= " WHERE ".implode(" AND ", $where);
        }

        return $wpdb->get_var( $sql );
    }
    
    public static function unpublished_quiz_categories_count() {
        global $wpdb;

        $where = array();
        $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizcategories ";

        $where[] = ' `published` = 0 ';

        $search = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( $_REQUEST['s'] ) : false;
        if( $search ){
            $where[] = sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) );
        }

        // if( isset( $_REQUEST['fstatus'] ) && is_numeric( $_REQUEST['fstatus'] ) && ! is_null( sanitize_text_field( $_REQUEST['fstatus'] ) ) ){
        //     if( esc_sql( $_REQUEST['fstatus'] ) != '' ){
        //         $fstatus  = absint( esc_sql( $_REQUEST['fstatus'] ) );
        //         $where[] = " published = ".$fstatus." ";
        //     }
        // }

        if( isset( $_GET['filterbyDescription'] ) && sanitize_text_field( $_GET['filterbyDescription'] ) != ""){
            $description_key = sanitize_text_field( $_GET['filterbyDescription'] );
            
            switch ( $description_key ) {
                case 'with':
                    $where[] = ' `description` != "" ';
                    break;
                case 'without':
                default:
                    $where[] = ' `description` = "" ';
                    break;
            }
        }

        if(count($where) !== 0){
            $sql .= " WHERE ".implode(" AND ", $where);
        }

        return $wpdb->get_var( $sql );
    }

    public function get_quiz_categories_by_id( $id ){
        global $wpdb;

        $quiz_category_table = $wpdb->prefix . 'aysquiz_quizcategories';

        $sql = "SELECT * FROM {$quiz_category_table} WHERE id=" . absint( sanitize_text_field( $id ) );

        $result = $wpdb->get_row($sql, 'ARRAY_A');

        return $result;
    }

    /** Text displayed when no customer data is available */
    public function no_items() {
        echo esc_html__( 'There are no quiz categories yet.', 'quiz-maker' );
    }


    /**
     * Render a column when no column specific method exist.
     *
     * @param array $item
     * @param string $column_name
     *
     * @return mixed
     */
    public function column_default( $item, $column_name ) {
        switch ( $column_name ) {
            case 'title':
            case 'description':
                return Quiz_Maker_Admin::ays_restriction_string("word",stripslashes($item[ $column_name ]), 15);
                break;
            case 'items_count':
            case 'published':
            case 'id':
                return $item[ $column_name ];
                break;
            default:
                return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    /**
     * Render the bulk edit checkbox
     *
     * @param array $item
     *
     * @return string
     */
    function column_cb( $item ) {
        
        if(intval($item['id']) === 1){
            return;
        }
        
        return sprintf(
            '<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
        );
    }


    /**
     * Method for name column
     *
     * @param array $item an array of DB data
     *
     * @return string
     */
    function column_title( $item ) {
        $delete_nonce = wp_create_nonce( $this->plugin_name . '-delete-quiz-category' );

        $quiz_categories_title_length = intval( $this->title_length );

        $column_t = esc_attr( stripcslashes($item['title']) );
        $t = esc_attr($column_t);

        $restitle = Quiz_Maker_Admin::ays_restriction_string("word", $column_t, $quiz_categories_title_length);
        $title = sprintf( '<a href="?page=%s&action=%s&quiz_category=%d" title="%s"><strong>%s</strong></a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ), $t, $restitle );

        $actions = array(
            'edit' => sprintf( '<a href="?page=%s&action=%s&quiz_category=%d">'. __('Edit', 'quiz-maker') .'</a>', esc_attr( $_REQUEST['page'] ), 'edit', absint( $item['id'] ) ),
            'duplicate' => sprintf( '<a href="?page=%s&action=%s&quiz_category=%d">'. __('Duplicate', 'quiz-maker') .'</a>', esc_attr( $_REQUEST['page'] ), 'duplicate', absint( $item['id'] ) ),
        );
        
        if(intval($item['id']) !== 1){
            $actions['delete'] = sprintf( '<a class="ays_confirm_del" data-message="%s" href="?page=%s&action=%s&quiz_category=%s&_wpnonce=%s">'. __('Delete', 'quiz-maker') .'</a>', $restitle, esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce );
        }

        return $title . $this->row_actions( $actions );
    }

    function column_description( $item ) {

        $desc = stripslashes( esc_html( strip_tags($item[ 'description' ]) ) );
        $description = Quiz_Maker_Admin::ays_restriction_string("word", $desc, 15);

        $description = "<div class='ays-quiz-list-table-description-column' title='". $desc ."'> ". $description ." </div>";

        return $description;
    }

    function column_shortcode( $item ) {
        $shortcode = htmlentities('[ays_quiz_cat id="'.$item["id"].'" display="all/random" count="5" layout="list/grid"]');
        return '<input type="text" onClick="this.setSelectionRange(0, this.value.length)" readonly value="'.$shortcode.'" />';
    }

    function column_published( $item ) {

        $status = (isset( $item['published'] ) && $item['published'] != '') ? absint( sanitize_text_field( $item['published'] ) ) : '';

        $status_html = '';
        switch( $status ) {
            case 1:
                $status_html = '<span class="ays-publish-status"><i class="ays_fa ays_fa_check_square_o" aria-hidden="true"></i>'. __('Published','quiz-maker') . '</span>';
                break;
            case 0:
                $status_html = '<span class="ays-publish-status"><i class="ays_fa ays_fa_square_o" aria-hidden="true"></i>'. __('Unpublished','quiz-maker') . '</span>';
                break;
            default:
                $status_html = '<span class="ays-publish-status"><i class="ays_fa ays_fa_square_o" aria-hidden="true"></i>'. __('Unpublished','quiz-maker') . '</span>';
                break;
        }

        return $status_html;
    }

    function column_items_count( $item ) {
        global $wpdb;

        $result = '';
        if ( isset( $item['id'] ) && absint( $item['id'] ) > 0 && ! is_null( sanitize_text_field( $item['id'] ) ) ) {
            $id = absint( esc_sql( $item['id'] ) );

            $sql = "SELECT COUNT(*) FROM {$wpdb->prefix}aysquiz_quizes WHERE quiz_category_id = " . $id;

            $result = $wpdb->get_var($sql);

            if ( ! is_null( $result ) && $result > 0 ) {
                $result = sprintf( '<a href="?page=%s&filterby=%d" target="_blank">%s</a>', 'quiz-maker', $id, $result );
            }
        }

        return "<p style='text-align:center;font-size:14px;'>" . $result . "</p>";
    }


    /**
     *  Associative array of columns
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'title'         => __( 'Title', 'quiz-maker' ),
            'description'   => __( 'Description', 'quiz-maker' ),
            'shortcode'     => __( 'Shortcode', 'quiz-maker' ),
            'items_count'   => __( 'Quizzes Count', 'quiz-maker' ),
            'published'     => __( 'Status', 'quiz-maker' ),
            'id'            => __( 'ID', 'quiz-maker' ),
        );

        if( isset( $_GET['action'] ) && ( $_GET['action'] == 'add' || $_GET['action'] == 'edit' ) ){
            return array();
        }

        return $columns;
    }


    /**
     * Columns to make sortable.
     *
     * @return array
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'title'         => array( 'title', true ),
            'id'            => array( 'id', true ),
        );

        return $sortable_columns;
    }

    /**
     * Returns an associative array containing the bulk action
     *
     * @return array
     */
    public function get_bulk_actions() {
        $actions = array(
            'bulk-published'    => __('Publish', 'quiz-maker'),
            'bulk-unpublished'  => __('Unpublish', 'quiz-maker'),
            'bulk-delete'       => __('Delete', 'quiz-maker'),
        );

        return $actions;
    }


    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items() {
        global $wpdb;

        $this->_column_headers = $this->get_column_info();

        /** Process bulk action */
        $this->process_bulk_action();

        $per_page     = $this->get_items_per_page( 'quiz_categories_per_page', 20 );
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args( array(
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ) );

        $search = ( isset( $_REQUEST['s'] ) ) ? sanitize_text_field( $_REQUEST['s'] ) : false;

        $do_search = ( $search ) ? sprintf(" title LIKE '%%%s%%' ", esc_sql( $wpdb->esc_like( $search ) ) ) : '';

        $this->items = self::get_quiz_categories( $per_page, $current_page , $do_search );
    }

    public function process_bulk_action() {

        //Detect when a bulk action is being triggered...
        if ( 'delete' === $this->current_action() ) {

            // In our file that handles the request, verify the nonce.
            $nonce = esc_attr( $_REQUEST['_wpnonce'] );

            if ( ! wp_verify_nonce( $nonce, $this->plugin_name . '-delete-quiz-category' ) ) {
                die( 'Go get a life script kiddies' );
            }
            else {
                self::delete_quiz_categories( absint( $_GET['quiz_category'] ) );

                // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
                // add_query_arg() return the current url

                $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category', '_wpnonce')  ) ) . '&status=deleted';
                wp_redirect( $url );
            }

        }

        // If the delete bulk action is triggered
        if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' ) || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' ) ) {

            $delete_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and delete them
            foreach ( $delete_ids as $id ) {
                self::delete_quiz_categories( $id );

            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category', '_wpnonce')  ) ) . '&status=deleted';
            wp_redirect( $url );
        } elseif ((isset($_POST['action']) && $_POST['action'] == 'bulk-published')
                  || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-published')
        ) {

            $published_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and mark as read them

            foreach ( $published_ids as $id ) {
                self::ays_quiz_published_unpublished_quiz_categories( $id , 'published' );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category', '_wpnonce')  ) ) . '&status=published';
            wp_redirect( $url );
        } elseif ((isset($_POST['action']) && $_POST['action'] == 'bulk-unpublished')
                  || (isset($_POST['action2']) && $_POST['action2'] == 'bulk-unpublished')
        ) {

            $unpublished_ids = ( isset( $_POST['bulk-delete'] ) && ! empty( $_POST['bulk-delete'] ) ) ? esc_sql( $_POST['bulk-delete'] ) : array();

            // loop over the array of record IDs and mark as read them

            foreach ( $unpublished_ids as $id ) {
                self::ays_quiz_published_unpublished_quiz_categories( $id , 'unpublished' );
            }

            // esc_url_raw() is used to prevent converting ampersand in url to "#038;"
            // add_query_arg() return the current url
            $url = esc_url_raw( remove_query_arg(array('action', 'quiz_category', '_wpnonce')  ) ) . '&status=unpublished';
            wp_redirect( $url );
        }
    }



    public function quiz_category_notices(){
        $status = (isset($_REQUEST['status'])) ? sanitize_text_field( $_REQUEST['status'] ) : '';

        if ( empty( $status ) )
            return;

        if ( 'created' == $status )
            $updated_message = esc_html( __( 'Quiz category created.', 'quiz-maker' ) );
        elseif ( 'updated' == $status )
            $updated_message = esc_html( __( 'Quiz category saved.', 'quiz-maker' ) );
        elseif ( 'deleted' == $status )
            $updated_message = esc_html( __( 'Quiz category deleted.', 'quiz-maker' ) );
        elseif ( 'published' == $status )
            $updated_message = esc_html( __( 'Quiz category(s) published.', 'quiz-maker' ) );
        elseif ( 'unpublished' == $status )
            $updated_message = esc_html( __( 'Quiz category(s) unpublished.', 'quiz-maker' ) );
        elseif ( 'duplicated' == $status )
            $updated_message = esc_html( __( 'Quiz category duplicated.', 'quiz-maker' ) );
        
        if ( empty( $updated_message ) )
            return;

        ?>
            <div class="notice notice-success is-dismissible">
                <p> <?php echo esc_html($updated_message); ?> </p>
            </div>
        <?php
    }
}