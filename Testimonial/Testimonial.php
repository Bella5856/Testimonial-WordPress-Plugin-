<?php
/*
* @package Testimonial
* Plugin Name: Testimonial
* Description: Manage and showcase testimonials with grid display
* Author: Izabela Andonovska

*/
if (!defined('ABSPATH')) {
    exit;
}

class Testimonial
{
    function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));
        add_action('add_meta_boxes', array($this, 'add_testimonial_meta_boxes'));
        add_action('save_post', array($this, 'save_testimonial_meta_box_data'));
        add_shortcode('display_testimonials', array($this, 'display_testimonials_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_testimonial_styles'));
    }

    function activate()
    {

        $this->custom_post_type();
        flush_rewrite_rules();

    }
    function deactivate()
    {

    }
    function uninstall()
    {
        flush_rewrite_rules();
    }

    // Register Custom Post Type
    function custom_post_type()
    {

        register_post_type('Testimonial', ['public' => true, 'label' => 'Testimonial',]);

    }

    //Add testimonial Meta Box
    function add_testimonial_meta_boxes()
    {
        add_meta_box(
            'testimonial_meta_box',
            'Testimonial Details',
            array($this, 'display_testimonial_meta_box'),
            'Testimonial',
            'normal',
            'high'
        );
    }


    // Display the Meta Box
    function display_testimonial_meta_box($post)
    {
        $customer_name = get_post_meta($post->ID, 'customer_name', true);
        $content = get_post_meta($post->ID, 'content', true);
        $rating = get_post_meta($post->ID, 'rating', true);

        wp_nonce_field('save_testimonial_meta_box_data', 'testimonial_meta_box_nonce');
        ?>
        <label for="customer_name">Customer Name:</label>
        <input type="text" name="customer_name" value="<?php echo esc_attr($customer_name); ?>" class="widefat">
        <label for="content" value="<?php echo esc_attr($content); ?>">Testimonial Content:</label>
        <textarea name="content" class="widefat"></textarea>

        <label for="rating">Rating (out of 5):</label><br>
        <label>
            <input type="radio" name="rating" value="1" <?php checked($rating, '1'); ?>> 1
        </label><br>
        <label>
            <input type="radio" name="rating" value="2" <?php checked($rating, '2'); ?>> 2
        </label><br>
        <label>
            <input type="radio" name="rating" value="3" <?php checked($rating, '3'); ?>> 3
        </label><br>
        <label>
            <input type="radio" name="rating" value="4" <?php checked($rating, '4'); ?>> 4
        </label><br>
        <label>
            <input type="radio" name="rating" value="5" <?php checked($rating, '5'); ?>> 5
        </label>
        <?php
    }

    function save_testimonial_meta_box_data($post_id)
    {
        // Check for nonce security
        if (!isset($_POST['testimonial_meta_box_nonce']) || !wp_verify_nonce($_POST['testimonial_meta_box_nonce'], 'save_testimonial_meta_box_data')) {
            return;
        }

        // Check if auto-saving
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check user permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save the fields
        if (isset($_POST['customer_name'])) {
            update_post_meta($post_id, 'customer_name', sanitize_text_field($_POST['customer_name']));
        }

        if (isset($_POST['rating'])) {
            update_post_meta($post_id, 'rating', sanitize_text_field($_POST['rating']));
        }

        $date_value = get_field('date_', $post_id);
        if (!$date_value) {
            $current_date = date('d/m/Y'); // Get current date in DD/MM/YYYY format
            update_post_meta($post_id, 'date_', $current_date);
        }

    }
    function display_testimonials_shortcode($atts)
    {
        ob_start();
        $this->get_testimonials();
        return ob_get_clean();
    }
    function get_testimonials()
    {
        $args = array(
            'post_type' => 'testimonial',
            'posts_per_page' => -1
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()) {
            echo '<div class="testimonial-grid">';
            while ($loop->have_posts()) {
                $loop->the_post();
                $customer_name = get_post_meta(get_the_ID(), 'customer_name', true);
                $rating = get_post_meta(get_the_ID(), 'rating', true);
                $customer_photo = get_field('costumers_photo');
                $date_of_testimonial = get_field('date_');
                $current_date = date('d/m/Y');
                echo '<div class="testimonial-item">';
                if ($customer_photo) {
                    echo '<div class="testimonial-img">';
                    echo '<img src="' . esc_url($customer_photo['url']) . '" alt="' . esc_attr($customer_photo['alt']) . '" />';
                    echo '</div>';
                }
                echo '<h2>' . esc_html($customer_name) . '</h2>';
                echo '<div class="testimonial-content">' . get_the_content() . '</div>';
                echo '<div class="testimonial-rating">Rating: ' . esc_html($rating) . '/5</div>';
                if (!$date_of_testimonial) {

                    echo '<div class="testimonial-date">Date' . $current_date . '</div>';
                } else {
                    echo '<div class="testimonial-date">Date: ' . esc_html($date_of_testimonial) . '</div>';
                }



                echo '</div>';
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No testimonials found.</p>';
        }
    }

    //Link css style
    function enqueue_testimonial_styles()
    {
        wp_enqueue_style('testimonial-styles', plugin_dir_url(__FILE__) . 'testimonial.css');
    }


}

$testimonial = new Testimonial();
//activation
register_activation_hook(__FILE__, array($testimonial, 'activate'));
//deactivation
register_deactivation_hook(__FILE__, array($testimonial, 'deactivate'));



