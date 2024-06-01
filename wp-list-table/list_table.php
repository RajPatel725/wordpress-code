
<?php
if(is_admin())
{
    new Paulund_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Paulund_Wp_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'add_menu_example_list_table_page' ));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_list_table_page()
    {
        add_menu_page( 'List Table', 'List Table', 'manage_options', 'list-table.php', array($this, 'list_table_page') );
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $exampleListTable = new Example_List_Table();
        

        if( isset($_POST['s']) ){
            $exampleListTable->prepare_items($_POST['s']);
        } else {
            $exampleListTable->prepare_items();
        }
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2>Example List Table Page</h2>

                <form method="post">
                    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                    <?php $exampleListTable->search_box('Search Posts', 'search_id'); ?>
                    <?php $exampleListTable->display(); ?>
                </form>

            </div>
            
        <?php
    }
}

    
// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Example_List_Table extends WP_List_Table
{
    
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 2;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;

        $this->process_bulk_action();
    }

	/**
	 * WP list table row actions
	*/
    public function handle_row_actions( $item, $column_name, $primary ) {

		if( $primary !== $column_name ) {
			return '';
		}

		$action = [];
		$action['edit'] = '<a href="#TB_inline?&width=600&height=550&inlineId=wlt_content_id" class="thickbox own_edit">'.__( 'Edit').'</a>';
		$action['delete'] = '<a href="" class="delete-post">'.__( 'Delete').'</a>';
		$action['quick-edit'] = '<a>'.__( 'Update').'</a>';
		$action['view'] = '<a>'.__( 'View').'</a>';

		return $this->row_actions( $action );
	}

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'cb'          => '<input type="checkbox" class="post-selected" />',
            'wlt_id'      => 'ID',
            'title'       => 'Title',
            'image'       => 'Image',
            'description' => 'Description',
            'year'        => 'Year',
            'email'       => 'Email',
            'rating'      => 'Rating'
        );

        return $columns;
    }
	/**
	 * Rows check box
	 */
	public function column_cb( $postRes ) {

        
        // print_r($items);
        foreach ( $postRes as $postres ){
            
            return sprintf('<input type="checkbox" name="post-selected[]" value="%s" class="post-selected" />',$postres);

        }
	}

    /**
	 * Wp list table bulk actions 
	 */
	public function get_bulk_actions() {

		return array(

			'delete'	=> __( 'Delete'),
            'save'      => __( 'Save' )
		);
    }

    public function process_bulk_action() {

        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();

        switch ( $action ) {

            case 'delete*Today update (13-07-22)*
*Learning R & D (6:45)*
- Working on wp-list-table in bulk action
*AWAG india (01-00)*
- Testing live website
*musicroyaltypayment (01:00)*
- multi language plugin in small setting':
                $post_ids = isset( $_REQUEST['post-selected'] ) ? $_REQUEST['post-selected'] : [];
                wp_delete_post($post_ids);
                wp_die( 'Delete something' );
                return;
                break;

            case 'save':
                wp_die( 'Save something' );
                break;

            default:
                // do nothing or something else
                return;
                break;
        }

        return;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('title' => array('title', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();
      
        $args = [
		    'post_type'      	=> 'post',
		    'post_status'    	=> 'publish',
		    'posts_per_page' 	=> -1,
		    'fields' 			=> 'ids'
		];

		$my_posts = get_posts( $args );
        if ($my_posts){
            foreach ( $my_posts as $postRes )
            {
                $post_title = get_the_title( $postRes );

                $url = get_edit_post_link( $postRes );
                $post_content = get_the_content( $postRes );
                $content_post = get_post( $postRes );
				$post_content = $content_post->post_content;
                $email = get_post_meta($postRes ,'email',true);
                $image = '<img src="'.get_the_post_thumbnail_url( $postRes , array('thumbnail') ).'"  />';

                $link = '<a data-post-email="'.$email.'" data-post-id="'.$postRes.'" data-post-img="'.get_the_post_thumbnail_url( $postRes ).'" data-post-title="'.$post_title.'" data-post-content="'.$post_content.'" class="post_id_title" href="'. esc_url( $url ) . '">' . $postRes .'</a>';

                $data[] = array(
                    'wlt_id'      => $postRes,
                    'title'       => $post_title,
                    'image'       => $image,
                    'description' => $post_content,
                    'year'        => '1994',
                    'email'       => $email,
                    'rating'      => '9.3'
                );
            }
        }

        return $data;
        
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'wlt_id':
            case 'title':
            case 'image':
            case 'description':
            case 'year':
            case 'email':
            case 'rating':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'title';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}
