<?php get_header(); ?>

<div class="container">
    <h1><?php the_title(); ?></h1>

    <div class="album-description">
        <?php the_content(); ?>
    </div>

    <div class="album-gallery">
        <?php
        $images = get_post_meta(get_the_ID(), 'album_gallery', true);
        if ($images && is_array($images)) {
            foreach ($images as $image_id) {
                $src = wp_get_attachment_image_url($image_id, 'large');
                echo '<div class="item-gallery"><img src="' . esc_url($src) . '" style="max-width:100%; max-height:100%;" /></div>';
            }
        } else {
            echo '<p>Không có ảnh nào trong album.</p>';
        }
        ?>
    </div>
    <!-- <div class="custom-masonry-gallery-container">
        <?php
        $images = get_post_meta(get_the_ID(), 'album_gallery', true);
        if ($images && is_array($images)) {
            foreach ($images as $image_id) {
                $src = wp_get_attachment_image_url($image_id, 'large');
                echo '<a class="custom-masonry-item" data-src="' . esc_url($src) . '"><img src="' . esc_url($src) . '" style="max-width:100%; max-height:100%;" /></a>';
            }
        } else {
            echo '<p>Không có ảnh nào trong album.</p>';
        }
        ?>
    </div> -->
</div>
<script>
    jQuery(document).ready(function($) {
        $('.album-gallery').justifiedGallery({
            rowHeight: 220,
            maxRowHeight: 300,
        });

    });
</script>
<?php get_footer(); ?>