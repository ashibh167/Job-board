<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ashibh.com
 * @since      1.0.0
 *
 * @package    Job_Board
 * @subpackage Job_Board/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Job_Board
 * @subpackage Job_Board/public
 * @author     Ashi <ashfaqchand786@gmail.com>
 */
class Job_Board_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/job-board-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( "style.css", plugin_dir_url( __FILE__ ) . 'css/style.css', array() );

	}
 
	//wp_enqueue_style( "bootstrap.min.css", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array());
	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/job-board-public.js', array( 'jquery' ), $this->version, false );
      // wp_enqueue_script(  "application-form.js", plugin_dir_url( __FILE__ ) . 'js/application-form.js', array( 'jquery' ), $this->version, true );

	}
	 public function jobs_board_shortcode($atts) {
					// Shortcode attributes
					$atts = shortcode_atts(array(
						'posts_per_page' => -1, // Number of posts to display
						'post_type' => 'jobs_board_cpt', // Custom post type slug
					), $atts);
				
					// Initialize output
					$output = '';
				
 
$output .= '<form method="post" class="filter-form">';
$output .= '<div class="form-group">';
$output .= '<label for="salary-from">Salary:</label>';
$output .= '<input type="number" id="salary-from" name="salary-from" min="10000" max="200000" step="10000" value="10000">';
$output .= '</div>';
$output .= '<div class="form-group">';
$output .= '<label for="salary-to">To:</label>';
$output .= '<input type="number" id="salary-to" name="salary-to" min="10000" max="200000" step="10000" value="200000">';
$output .= '</div>';
$output .= '<div class="form-group">';
$output .= '<label for="location-filter">Location:</label>';
$output .= '<select id="location-filter" name="location-filter">';
$output .= '<option value="">All</option>';
$output .= $this->get_meta_values('job_location');
$output .= '</select>';
$output .= '</div>';
$output .= '<input type="submit" name="submit" value="Filter">';
$output .= '</form>';


				
					// Form submission handling
					if (!isset($_POST['submit'])) {
						// Fetch all posts if form is not submitted
						$args = array(
							'post_type' => $atts['post_type'],
							'posts_per_page' => $atts['posts_per_page'],
						);
				
						$query = new WP_Query($args);
				
						// Output all posts
						$output .= '<ul>';
						if ($query->have_posts()) {
							while ($query->have_posts()) {
								$query->the_post();
								$salary = get_post_meta(get_the_ID(), 'job_salary', true);
								$location = get_post_meta(get_the_ID(), 'job_location', true);
								$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() .'</a>';
								// Append salary and location meta values to the output
								if ($salary) {
									$output .= '<br><strong>Salary:</strong> ' . $salary;
								}
								if ($location) {
									$output .= '<br><strong>Location:</strong> ' . $location;
								}
								$output .= '</li>';
							}
						} else {
							$output .= '<li>No posts found.</li>';
						}
						$output .= '</ul>';
				
						// Restore original post data
						wp_reset_postdata();
					} else {
						// If form is submitted, filter the posts based on selected options
						$salary_from = isset($_POST['salary-from']) ? sanitize_text_field($_POST['salary-from']) : '';
						$salary_to = isset($_POST['salary-to']) ? sanitize_text_field($_POST['salary-to']) : '';
						$location_filter = isset($_POST['location-filter']) ? sanitize_text_field($_POST['location-filter']) : '';
				
						// Query arguments
						$args = array(
							'post_type' => $atts['post_type'],
							'posts_per_page' => $atts['posts_per_page'],
							'meta_query' => array(),
						);
				
						if (!empty($salary_from) && !empty($salary_to)) {
							$args['meta_query'][] = array(
								'key' => 'job_salary',
								'value' => array($salary_from, $salary_to),
								'type' => 'numeric',
								'compare' => 'BETWEEN',
							);
						}
				
						if (!empty($location_filter)) {
							$args['meta_query'][] = array(
								'key' => 'job_location',
								'value' => $location_filter,
								'compare' => '=',
							);
						}
				
						// The Query
						$query = new WP_Query($args);
				
						// Output filtered posts
						$output .= '<ul>';
						if ($query->have_posts()) {
							while ($query->have_posts()) {
								$query->the_post();
								$salary = get_post_meta(get_the_ID(), 'job_salary', true);
								$location = get_post_meta(get_the_ID(), 'job_location', true);
								$output .= '<li><a href="' . get_permalink() . '">' . get_the_title() .'</a>';
								// Append salary and location meta values to the output
								if ($salary) {
									$output .= '<br><strong>Salary:</strong> ' . $salary;
								}
								if ($location) {
									$output .= '<br><strong>Location:</strong> ' . $location;
								}
								$output .= '</li>';
							}
						} else {
							$output .= '<li>No posts found.</li>';
						}
						$output .= '</ul>';
				
						// Restore original post data
						wp_reset_postdata();
					}
				
					return $output;
				}
				
				// Helper function to retrieve distinct meta values for a given meta key
				private function get_meta_values($meta_key) {
					global $wpdb;
					$meta_values = $wpdb->get_col($wpdb->prepare("
						SELECT DISTINCT meta_value
						FROM $wpdb->postmeta
						WHERE meta_key = %s
					", $meta_key));
					$options = '';
					foreach ($meta_values as $value) {
						$options .= '<option value="' . esc_attr($value) . '">' . esc_html($value) . '</option>';
					}
					return $options;
				}
 

 

				
				public function load_custom_template($template) {
			if (is_singular('jobs_board_cpt')) {
				// Path to your custom template file
				$custom_template = plugin_code_plugin_dir .'public/partials/single-jobs_board_cpt.php';
	
				// Check if the custom template file exists, then use it
				if (file_exists($custom_template)) {
					return $custom_template;
				}
			}
	
			// Return original template if not "jobs_board_cpt" post type or custom template doesn't exist
			  return $template;
		}

		 
	
		
	 

		public function handle_application_form_submission() {
			if (isset($_POST['submit_application'])) {
				$name = sanitize_text_field($_POST['name']);
				$email = sanitize_email($_POST['email']);
				
				$phoneNumber =  sanitize_text_field($_POST['phoneNumber']); // Remove non-numeric characters from phone number
				$city = sanitize_text_field($_POST['city']);
				$post_title = sanitize_text_field($_POST['post_title']);
				
				// Flag to track if all required fields are filled
				$required_fields_filled = true;
				
				// Check if required fields are not empty
				if (empty($name) || empty($email)  || empty($phoneNumber) || empty($city) || empty($post_title)) {
					echo "Required fields are missing.";
					$required_fields_filled = false;
				}
		
				
				
				// Proceed only if all required fields are filled and valid
				if ($required_fields_filled) {
					// Check if file is uploaded
					if (!empty($_FILES['application_file_upload']['name'])) {
						$file = $_FILES['application_file_upload'];
						$file_name = sanitize_file_name($file['name']);
						$file_tmp_name = $file['tmp_name'];
						$file_type = wp_check_filetype($file_name);
						$allowed_types = array('pdf', 'doc', 'docx');
		
						if (in_array($file_type['ext'], $allowed_types)) {
							$upload_dir = wp_upload_dir();
							$file_path = $upload_dir['path'] . '/' . $file_name;
							$file_url = $upload_dir['url'] . '/' . $file_name;
		
							// Check if the file already exists
							if (!file_exists($file_path)) {
								if (!move_uploaded_file($file_tmp_name, $file_path)) {
									echo "Error uploading file.";
									return; // Stop further processing
								}
							} else {
								echo "A file with the same name already exists.";
								return; // Stop further processing
							}
						} else {
							echo "File type not allowed.";
							return; // Stop further processing
						}
					} else {
						echo "File upload is empty.";
						return; // Stop further processing
					}
		
					// Create application post
					$post_args = array(
						'post_title' => $post_title,
						'post_type' => 'application',
						'post_status' => 'publish',
					);
					$post_id = wp_insert_post($post_args);
		
					// Insert meta fields
					if ($post_id) {
						update_post_meta($post_id, 'applicant_name', $name);
						update_post_meta($post_id, 'applicant_email', $email);
						update_post_meta($post_id, 'applicant_phoneNumber', $phoneNumber);
						update_post_meta($post_id, 'applicant_city', $city);
						// Save file path as meta field
						update_post_meta($post_id, 'application_file_url', $file_url);
					}
				
			
		
		
		
		
	// Email to the user
$user_subject = "Application Submission Confirmation";
$user_message = "Dear $name,\n\nThank you for submitting your application. We have received your details and will process your application shortly.\n\nBest Regards,\nAshiTech";
wp_mail($email, $user_subject, $user_message);

// Email to the admin
$admin_email = get_option('admin_email'); // Retrieve admin email from WordPress settings
$admin_subject = "New Application Received";
$admin_message = "A new application has been received.\n\nDetails:\nName: $name\nEmail: $email\nPhone No: $phoneNumber\nCity: $city\nFile: $file_url";
wp_mail($admin_email, $admin_subject, $admin_message);					
						// Display success message with button to home page
				echo "Data inserted successfully.<br>";
				echo '<a href="' . home_url() . '" class="button">Go to Home Page</a>';
						// Redirect after form submission
						//  wp_redirect(home_url());
						//  exit();
					}
					
				}  
			}
 


 

		 }

 
		
			
		 