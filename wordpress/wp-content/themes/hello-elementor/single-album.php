<?php
get_header();
while ( have_posts() ) :
    the_post();
    $image_ids = get_post_meta( get_the_ID(), 'album_gallery', true ) ?: [];

    // Tạo một tên duy nhất cho slideshow dựa trên ID của bài viết
    $slideshow_name = 'album-' . get_the_ID();
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
                        <a href="<?php echo esc_url( $full_url ); ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="<?php echo esc_attr($slideshow_name); ?>">
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
        grid-template-columns: repeat(auto-fill, minmax(125px, 1fr));
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
    /* Tùy chỉnh màu nền và kích thước của các nút chuyển ảnh */
    .e-lightbox__arrow {
        background-color: rgba(0, 0, 0, 0.5) !important; /* Nền màu đen mờ */
        border-radius: 50% !important; /* Bo tròn tạo hình tròn */
        width: 40px !important; /* Chiều rộng */
        height: 40px !important; /* Chiều cao */
        transition: background-color 0.3s ease;
    }

    /* Tùy chỉnh màu khi di chuột vào */
    .e-lightbox__arrow:hover {
        background-color: rgba(0, 0, 0, 0.8) !important; /* Nền màu đen đậm hơn */
    }

    /* Tùy chỉnh biểu tượng mũi tên */
    .e-lightbox__arrow svg {
        color: #fff !important; /* Màu mũi tên trắng */
        font-size: 20px !important; /* Kích thước mũi tên */
    }

    /* Vị trí của các nút */
    .e-lightbox__arrow__left {
        left: 20px !important;
    }

    .e-lightbox__arrow__right {
        right: 20px !important;
    }

    /* Tùy chỉnh màu nền tổng thể của lightbox */
    .e-lightbox {
        background-color: rgba(0, 0, 0, 0.9) !important;
    }
</style>

<?php
endwhile;
get_footer();
?>