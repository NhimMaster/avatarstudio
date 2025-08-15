<?php
function studio_list_albums_shortcode($atts)
{
    ob_start();

    $args = array(
        'post_type'      => 'album',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
    );

    $albums = new WP_Query($args);

    if ($albums->have_posts()) {
        echo '<div class="studio-albums" style="display:flex; flex-wrap:wrap; gap:20px;">';

        while ($albums->have_posts()) {
            $albums->the_post();

            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium');
            $title     = get_the_title();
            $excerpt   = wp_trim_words(get_the_content(), 20);
            $link      = get_permalink();

            echo '<div class="album-item" style="width:250px;">';
            echo '<a href="' . esc_url($link) . '">' . $thumbnail . '</a>';
            echo '<h3><a href="' . esc_url($link) . '">' . esc_html($title) . '</a></h3>';
            echo '<p>' . esc_html($excerpt) . '</p>';
            echo '<a class="button" href="' . esc_url($link) . '">Xem chi tiết</a>';
            echo '</div>';
        }

        echo '</div>';
    } else {
        echo '<p>Chưa có album nào.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('list_albums', 'studio_list_albums_shortcode');

// Hàm để thêm các script và stylesheet
function my_custom_masonry_scripts()
{

    wp_enqueue_style('style', MY_STUDIO_CORE_PLUGIN_URL . 'assets/css/style.css');
    // Đăng ký và enqueue stylesheet
    // wp_enqueue_style('custom-masonry-style', plugin_dir_url(__FILE__) . 'assets/css/custom-masonry.css');
    // /var/www/html/wp-content/plugins/studio-core/includes/
    wp_enqueue_style('custom-masonry-style', MY_STUDIO_CORE_PLUGIN_URL . 'assets/css/custom-masonry.css');
    // Đăng ký và enqueue thư viện Masonry
    if (! wp_script_is('masonry', 'enqueued')) {
        wp_enqueue_script('masonry', MY_STUDIO_CORE_PLUGIN_URL . 'assets/js/masonry.pkgd.min.js', array(), '4.2.2', true);
    }

    // Đăng ký và enqueue script khởi tạo Masonry
    //wp_enqueue_script('custom-masonry-init', MY_STUDIO_CORE_PLUGIN_URL . 'assets/js/custom-masonry.js', array('jquery', 'masonry'), '1.0.0', false);

    // Lightgallery CSS
    wp_enqueue_style('lightgallery-css', 'https://cdn.jsdelivr.net/npm/lightgallery@latest/css/lightgallery.min.css');

    // Lightgallery JS
    wp_enqueue_script('lightgallery-js', 'https://cdn.jsdelivr.net/npm/lightgallery@latest/lightgallery.min.js', array('jquery'), null, true);
    wp_enqueue_script('lg-thumbnail', 'https://cdn.jsdelivr.net/npm/lightgallery@latest/plugins/thumbnail/lg-thumbnail.min.js', array('jquery', 'lightgallery-js'), null, true);
}
add_action('wp_enqueue_scripts', 'my_custom_masonry_scripts');


function my_custom_justified_gallery()
{
    wp_enqueue_style('justified-gallery-style', MY_STUDIO_CORE_PLUGIN_URL . "assets/css/justifiedGallery.min.css");
    // Đăng ký và enqueue thư viện justified_gallery
    wp_enqueue_script('justified-gallery', MY_STUDIO_CORE_PLUGIN_URL . 'assets/js/jquery.justifiedGallery.min.js', array(), '3.8.0', true);
}
add_action('wp_enqueue_scripts', 'my_custom_justified_gallery');

// Tự động tạo shortcode cho gallery
function my_custom_masonry_gallery_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'ids' => '',
        'columns' => 3,
    ), $atts);

    $ids = explode(',', $atts['ids']);
    $output = '';

    if (! empty($ids)) {
        $output .= '<div class="custom-masonry-gallery-container">';
        foreach ($ids as $id) {
            $image_url = wp_get_attachment_url($id);
            if ($image_url) {
                $output .= '<div class="custom-masonry-item">';
                $output .= '<img src="' . esc_url($image_url) . '" alt="" />';
                $output .= '</div>';
            }
        }
        $output .= '</div>';
    }

    return $output;
}
add_shortcode('masonry_gallery', 'my_custom_masonry_gallery_shortcode');


function add_custom_social_buttons()
{
?>
    <div class="social-buttons">
        <a href="https://zalo.me/0902645993" class="social-button zalo" target="_blank">
            <img src="https://avatarstudio.vn/wp-content/uploads/2025/08/Icon_of_Zalo.svg_.png" width="50" height="50" />

        </a>
        <a href="https://m.me/avatarstudio22" class="social-button messenger" target="_blank">
            <img src="https://avatarstudio.vn/wp-content/uploads/2025/08/icon-messenger.png" width="50" height="50" />
        </a>
    </div>
<?php
}
add_action('wp_footer', 'add_custom_social_buttons');

add_filter( 'big_image_size_threshold', '__return_false' );