<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ashibh.com
 * @since      1.0.0
 *
 * @package    Job_Board
 * @subpackage Job_Board/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Job_Board
 * @subpackage Job_Board/admin
 * @author     Ashi <ashfaqchand786@gmail.com>
 */
class Job_Board_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/job-board-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style( "style.css", plugin_dir_url( __FILE__ ) . 'css/style.css', array() );

       

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Job_Board_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Job_Board_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/job-board-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function jobs_board_cpt() {

		$labels = array(
			'name'                  => _x( 'All Jobs', 'Post Type General Name', 'twentyfive' ),
			'singular_name'         => _x( 'Job Board', 'Post Type Singular Name', 'twentyfive' ),
			'menu_name'             => __( 'Jobs Board', 'twentyfive' ),
			'name_admin_bar'        => __( 'Jobs Board', 'twentyfive' ),
			'archives'              => __( 'Jobs Board Archives', 'twentyfive' ),
			'attributes'            => __( 'Jobs Board Attributes', 'twentyfive' ),
			'parent_item_colon'     => __( 'Parent Job Board:', 'twentyfive' ),
			'all_items'             => __( 'All Jobs', 'twentyfive' ),
			'add_new_item'          => __( 'Add New Job', 'twentyfive' ),
			'add_new'               => __( 'Add New Job', 'twentyfive' ),
			'new_item'              => __( 'New Job ', 'twentyfive' ),
			'edit_item'             => __( 'Edit Job', 'twentyfive' ),
			'update_item'           => __( 'Update Job', 'twentyfive' ),
			'view_item'             => __( 'View Job', 'twentyfive' ),
			'view_items'            => __( 'View Jobs', 'twentyfive' ),
			'search_items'          => __( 'Search Jobs', 'twentyfive' ),
			'not_found'             => __( 'Jobs Not found', 'twentyfive' ),
			'not_found_in_trash'    => __( 'Jobs Not found in Trash', 'twentyfive' ),
			'featured_image'        => __( 'Featured Image Jobs Board', 'twentyfive' ),
			'set_featured_image'    => __( 'Set featured Job image', 'twentyfive' ),
			'remove_featured_image' => __( 'Remove featured image Job ', 'twentyfive' ),
			'use_featured_image'    => __( 'Use as featured image Jobs Board', 'twentyfive' ),
			'insert_into_item'      => __( 'Insert into Jobs Board', 'twentyfive' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Jobs Board', 'twentyfive' ),
			'items_list'            => __( 'Jobs list', 'twentyfive' ),
			'items_list_navigation' => __( 'Jobs list navigation', 'twentyfive' ),
			'filter_items_list'     => __( 'Filter Jobs list', 'twentyfive' ),
		);
		$args = array(
			'label'                 => __( 'Job Board', 'twentyfive' ),
			'description'           => __( 'This is Jobs Board custom type', 'twentyfive' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor','custom-fields', 'thumbnail', 'post-formats' ),
			//'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-shortcode',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
		);
	 	register_post_type( 'jobs_board_cpt', $args );
         

	}

    function register_jobs_board_import_page() {
        add_submenu_page(
            'edit.php?post_type=jobs_board_cpt',
            'Import Jobs',       // Page title
            'Import Jobs',       // Menu title
            'manage_options',    // Capability
            'import-jobs',       // Menu slug
           [$this,'render_import_jobs_page'] // Callback function
        );
    }
   
  

function render_import_jobs_page() {
    ?>
    <div class="wrap">
        <h1>Import Jobs</h1>
        <?php if (get_transient('jobs_import_success')) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo get_transient('jobs_import_success'); ?></p>
            </div>
            <?php delete_transient('jobs_import_success'); ?>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('import_jobs_csv_action', 'import_jobs_csv_nonce'); ?>
            <input type="file" name="import_jobs_csv" accept=".csv" required>
            <?php submit_button('Import CSV'); ?>
        </form>
    </div>
    <?php
}



function handle_import_jobs_csv() {
    if (isset($_FILES['import_jobs_csv'])) {
        // Check nonce for security
        if (!isset($_POST['import_jobs_csv_nonce']) || !wp_verify_nonce($_POST['import_jobs_csv_nonce'], 'import_jobs_csv_action')) {
           // wp_die('Security check failed');
        }

        $file = $_FILES['import_jobs_csv']['tmp_name'];

        if (($handle = fopen($file, "r")) !== FALSE) {
            // Read the header row
            $header = fgetcsv($handle, 1000, ",");

            // Loop through the rest of the CSV file
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Combine header and data
                $job_data = array_combine($header, $data);

                // Log the job data for debugging
                error_log(print_r($job_data, true));

                // Create a new job post
                $post_id = wp_insert_post(array(
                    'post_title'   => sanitize_text_field($job_data['title']),
                    'post_content' => sanitize_textarea_field($job_data['description']),
                    'post_type'    => 'jobs_board_cpt',
                    'post_status'  => 'publish',
                ));

                if (is_wp_error($post_id)) {
                    error_log('Post creation error: ' . $post_id->get_error_message());
                } else {
                    // Add custom fields if the post was created successfully
                    update_post_meta($post_id, 'job_salary', sanitize_text_field($job_data['salary']));
                    update_post_meta($post_id, 'job_location', sanitize_text_field($job_data['location']));
                }
                
            }
            

            fclose($handle);
            // Set a transient to show a success message
            set_transient('jobs_import_success', "$jobs_created job(s) successfully created.", 30);
        }
    }
}
 
 


    
		
	// Add meta boxes for jobs_board_cpt custom post type
public function add_jobs_board_meta_boxes() {
    add_meta_box(
        'job_salary_meta_box',
        'Salary',
       array($this,'render_job_salary_meta_box'),
        'jobs_board_cpt',
        'normal',
        'high'
    );

    add_meta_box(
        'job_location_meta_box',
        'Location',
        array($this,'render_job_location_meta_box'),
        'jobs_board_cpt',
        'normal',
        'high'
    );
}

	
//add_action('add_meta_boxes', 'add_jobs_board_meta_boxes');

// Render job salary meta box
public function render_job_salary_meta_box($post) {
    $salary = get_post_meta($post->ID, 'job_salary', true);
    ?>
    <label for="job_salary">Salary:</label>
    <input type="text" id="job_salary" name="job_salary" value="<?php echo esc_attr($salary); ?>">
    <?php
}

// Render job location meta box
public function render_job_location_meta_box($post) {
    $location = get_post_meta($post->ID, 'job_location', true);
    ?>
    <label for="job_location">Location:</label>
    <input type="text" id="job_location" name="job_location" value="<?php echo esc_attr($location); ?>">
    <?php
}

// Save job board meta data
public function save_jobs_board_meta_data($post_id) {
   // Check if nonce is set
    // if (!isset($_POST['jobs_board_meta_nonce'])) {
    //     return;
    // }

  // Verify nonce
    // if (!wp_verify_nonce($_POST['jobs_board_meta_nonce'], 'jobs_board_nonce_action')) {
    //     return;
    // }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save meta data for salary
    if (isset($_POST['job_salary'])) {
        update_post_meta($post_id, 'job_salary', sanitize_text_field($_POST['job_salary']));
    }

    // Save meta data for location
    if (isset($_POST['job_location'])) {
        update_post_meta($post_id, 'job_location', sanitize_text_field($_POST['job_location']));
    }
}
//add_action('save_post', 'save_jobs_board_meta_data');

	 
// Method to register custom post type
    public function register_application_post_type() {
      
        $labels = array(
            'name'               => 'Applications',
            'singular_name'      => 'Application',
            'all_items'          => 'All Applications',
            'view_item'          => 'View Application',
            'search_items'       => 'Search Applications',
            'not_found'          => 'No applications found',
            'not_found_in_trash' => 'No applications found in Trash',
            'menu_name'          => 'Applications'
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'application'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'show_in_rest'       => true,
            'supports'           => array('title'),
            'capabilities'       => array(
                'create_posts' => 'do_not_allow', // Disable adding new posts
            ),
            'map_meta_cap'       => true, // So that create_posts is handled correctly
        );

        register_post_type('application', $args);
    }
    function remove_application_add_new() {
        global $submenu;
        if (isset($submenu['edit.php?post_type=application'])) {
            // Remove 'Add New'
            unset($submenu['edit.php?post_type=application'][10]);
        }
    }
   // add_action('admin_menu', 'remove_application_add_new');

    

    // Method to add meta boxes
    public function custom_application_metabox() {
        add_meta_box(
            'custom-application-metabox',
            'Application Details',
        array($this,'custom_application_metabox_callback'),
            'application',
            'normal',
            'high'
        );
    }

    // Method to render meta box content
  public  function custom_application_metabox_callback($post) {
        // Retrieve existing values for fields
        $name = get_post_meta($post->ID, 'applicant_name', true);
        $email = get_post_meta($post->ID, 'applicant_email', true);
        $phoneNumber = get_post_meta($post->ID, 'applicant_phoneNumber', true);
         
        $city = get_post_meta($post->ID, 'applicant_city', true);
        $file_url = get_post_meta($post->ID, 'application_file_url', true);
         ?>
             
        <div>
            <label for="applicant_name">Name:</label><br>
            <input type="text" id="applicant_name" name="applicant_name" value="<?php echo esc_attr($name); ?>">
  </div>
        <div>
            <label for="applicant_email">Email:</label><br>
            <input type="email" id="applicant_email" name="applicant_email" value="<?php echo esc_attr($email); ?>">
            <div>
        <label for="applicant_phoneNumber">Phone Number:</label><br>
        <input type="text" id="applicant_phoneNumber" name="applicant_phoneNumber" value="<?php echo esc_attr($phoneNumber); ?>">
  </div>
         
        <div>
            <label for="applicant_city">City:</label><br>
            <input type="text" id="applicant_city" name="applicant_city" value="<?php echo esc_attr($city); ?>">
  </div>
         
             <br/>
           <div>
    <?php if (!empty($file_url)) : ?>
       <a href="<?php echo esc_url($file_url); ?>" class="button-link" target="_blank">CV Download</a>     <?php else : ?>
        No file uploaded
    <?php endif; ?>
</div>

        
        <?php
    }
     
 
function register_application_admin_page() {
    add_submenu_page(
        'edit.php?post_type=application',
        'Export Applications',  // Page title
        'Export Applications',  // Menu title
        'manage_options',    // Capability
        'export-applications',  // Menu slug
      [$this,'render_export_applications_page'] // Callback function
    );
}
//add_action('admin_menu', 'register_application_admin_page');
 

function render_export_applications_page() {
    ?>
    <div class="wrap">
        <h1>Export Applications</h1>
        <h4>Export Applications Between The Date</h4>
        <form method="post" action="">
            <input type="hidden" name="export_applications_csv" value="true">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date">
            <?php submit_button('Export CSV'); ?>
        </form>
        <div id="success-message" style="display:none; margin-top: 20px;" class="notice notice-success is-dismissible">
            <p>File exported successfully.</p>
        </div>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                form.addEventListener('submit', function() {
                    document.getElementById('success-message').style.display = 'block';
                });
            });
        </script>
    </div>
    <?php
}



function handle_export_applications_csv() {
    if (isset($_POST['export_applications_csv']) && $_POST['export_applications_csv'] === 'true') {
        // Get the start and end dates from the form
        $start_date = isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
        $end_date = isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';

        // Prepare date query
        $date_query = array();
        if ($start_date) {
            $date_query['after'] = $start_date;
        }
        if ($end_date) {
            $date_query['before'] = $end_date;
        }
        if ($start_date || $end_date) {
            $date_query['inclusive'] = true;
        }

        // Fetch all applications within the date range
        $args = array(
            'post_type' => 'application',
            'posts_per_page' => -1,
            'date_query' => $date_query
        );
        $applications = new WP_Query($args);

        // Output CSV headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=applications.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Title','Name', 'Email', 'PhoneNumber', 'City')); // Column headers

        // Loop through applications and output them to CSV
        if ($applications->have_posts()) {
            while ($applications->have_posts()) {
                $applications->the_post();
                $application_id = get_the_ID();
                $title = get_the_title();
                $name = get_post_meta($application_id, 'applicant_name', true);
                $email = get_post_meta($application_id, 'applicant_email', true);
                
                $phoneNumber = get_post_meta($application_id, 'applicant_phoneNumber', true);
                $city = get_post_meta($application_id, 'applicant_city', true);
              //  $uploaded_file = get_post_meta($application_id, 'application_file_url', true);

                fputcsv($output, array($title, $name, $email, $phoneNumber, $city));
            }
        }

        fclose($output);
        exit();
    }
}
 

//add_action('admin_init', 'handle_export_applications_csv');


 


          }

        