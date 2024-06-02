<?php
// Get header
get_header();

// Start the loop
while (have_posts()) : the_post();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>

        <?php
        // Display custom meta fields (salary and location)
        $salary = get_post_meta(get_the_ID(), 'job_salary', true);
        $location = get_post_meta(get_the_ID(), 'job_location', true);

        if (!empty($salary)) {
            echo '<p><strong>Salary:</strong> ' . $salary . '</p>';
        }

        if (!empty($location)) {
            echo '<p><strong>Location:</strong> ' . $location . '</p>';
        }
        ?>
    </div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; // End of the loop.
?>
<h1> Apply for this job</h1>
 
 <form id="application-form" method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('application_form_nonce', 'security'); ?>
    <input type="hidden" name="post_title" value="<?php echo get_the_title(); ?>">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div><br>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div><br>
    <div>
        <label for="phone">Phone No:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" pattern="\d*" title="Phone number must contain only digits" required>
    </div><br>
    <div>
        <label for="city">City:</label>
        <input type="text" id="city" name="city" required>
    </div><br>
    <div>
        <label for="application_file_upload">Upload CV:</label>
        <input type="file" id="application_file_upload" name="application_file_upload" accept=".pdf,.doc,.docx" required>
    </div><br>
    <input type="submit" name="submit_application" value="Submit">
</form>

<script>
// JavaScript to restrict phone number input to integers only
document.getElementById("phoneNumber").addEventListener("input", function() {
    this.value = this.value.replace(/[^\d]/g, "");
});
</script>


<?php
// Get footer
get_footer();

 