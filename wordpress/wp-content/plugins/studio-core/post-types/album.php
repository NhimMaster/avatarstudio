<?php
// Đăng ký post type 'album'
add_action('init', 'studio_register_album_post_type');

function studio_register_album_post_type()
{
    $labels = array(
        'name' => 'Albums',
        'singular_name' => 'Album',
        'add_new' => 'Thêm Album',
        'add_new_item' => 'Thêm mới Album',
        'edit_item' => 'Sửa Album',
        'new_item' => 'Album mới',
        'view_item' => 'Xem Album',
        'search_items' => 'Tìm Album',
        'not_found' => 'Không tìm thấy Album nào',
        'not_found_in_trash' => 'Không có Album nào trong thùng rác',
        'menu_name' => 'Albums',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'albums'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-format-gallery',
        'show_in_rest' => true,
    );

    register_post_type('album', $args);
}

// Thêm meta box gallery
add_action('add_meta_boxes', function () {
    add_meta_box(
        'album_gallery_box',
        'Album Gallery',
        'studio_album_gallery_box_callback',
        'album',
        'normal',
        'default'
    );
});

function studio_album_gallery_box_callback($post)
{
    $image_ids = get_post_meta($post->ID, 'album_gallery', true) ?: [];

    echo '<div id="album-gallery-container">';
    echo '<ul style="margin: 0; padding: 0;">';

    foreach ($image_ids as $image_id) {
        $thumb = wp_get_attachment_image($image_id, 'thumnails');
        echo "<li style='display:inline-block; margin-right:10px; '>$thumb</li>";
    }

    echo '</ul>';
    echo '</div>';

    echo '<input type="hidden" id="album_gallery_ids" name="album_gallery" value="' . esc_attr(implode(',', $image_ids)) . '" />';
    echo '<button type="button" class="button" id="upload_album_images">Upload Ảnh</button>';

    // Gọi media uploader
?>
    <script>
        jQuery(document).ready(function($) {
            $('#upload_album_images').click(function(e) {
                e.preventDefault();
                var image_frame;
                if (image_frame) {
                    image_frame.open();
                }

                image_frame = wp.media({
                    title: 'Chọn ảnh cho album',
                    library: {
                        type: 'image'
                    },
                    button: {
                        text: 'Chọn ảnh'
                    },
                    multiple: "add", // ✅ Cho phép chọn nhiều ảnh cùng lúc
                });

                var selectedImageIds = $("#album_gallery_ids").val().split(",");

                // Khi mở media frame, hãy truyền các ID này vào
                image_frame.on('open', function() {
                    var selection = image_frame.state().get('selection');
                    var attachments = selectedImageIds.map(function(id) {
                        return wp.media.attachment(id);
                    });
                    selection.add(attachments);
                });

                image_frame.on('select', function() {
                    var selection = image_frame.state().get('selection');
                    var ids = [];
                    $('#album-gallery-container ul').html('');
                    selection.map(function(att) {
                        att = att.toJSON();
                        if (att.id) {
                            ids.push(att.id);
                            let imageUrl = att.url;
                            console.log("check in aa", att)
                            if (att.sizes.thumbnail) {
                                imageUrl = att.sizes.thumbnail.url;
                            }
                            $('#album-gallery-container ul').append('<li style="display:inline-block; margin-right:10px; width: 80px;height: auto;aspect-ratio: 1 / 1;"><img style="aspect-ratio: 1 / 1;object-fit: fill;" src="' + imageUrl + '" /></li>');
                        }
                    });
                    $('#album_gallery_ids').val(ids.join(','));

                });
                image_frame.open();
            });

            // Xoá ảnh khỏi gallery
            $('#album-gallery-container ul').on('click', '.remove-image', function(e) {
                e.preventDefault();
                $(this).closest('li').remove();
            });
        });
    </script>
<?php
}

// Lưu dữ liệu
add_action('save_post_album', function ($post_id) {
    if (isset($_POST['album_gallery'])) {
        $ids = array_filter(array_map('intval', explode(',', $_POST['album_gallery'])));
        update_post_meta($post_id, 'album_gallery', $ids);
    }
});
