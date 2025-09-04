<?php
/**
 * Template Name: Single Album Template
 * Template Post Type: album
 */

get_header();

while ( have_posts() ) :
    the_post();
    $image_ids = get_post_meta( get_the_ID(), 'albums', true ) ?: [];
?>

<div class="album-container">
    <h1 class="album-title"><?php the_title(); ?></h1>
    <div class="album-description">
        <?php the_content(); ?>
    </div>

    <div class="image-grid-container">
        <?php
        if ( is_array( $image_ids ) && !empty( $image_ids ) ) {
            foreach ( $image_ids as $image_id ) {
                $thumb_url = wp_get_attachment_image_url( $image_id, 'medium' );
                $full_url = wp_get_attachment_image_url( $image_id, 'full' );
                if ( $thumb_url && $full_url ) {
                    ?>
                    <div class="image-item">
                        <a href="<?php echo esc_url( $full_url ); ?>" data-elementor-open-lightbox="yes">
                            <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
                        </a>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>

<style>
    /* CSS để tạo layout grid và làm ảnh hình vuông */
    .image-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }
    .image-item {
        position: relative;
        padding-bottom: 100%;
        overflow: hidden;
        cursor: pointer;
    }
    .image-item img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .image-item img:hover {
        transform: scale(1.05);
    }
    .album-container {
        max-width: 960px;
        margin: 0 auto;
        padding: 20px;
    }
    .album-title {
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<?php
endwhile;
get_footer();
?>