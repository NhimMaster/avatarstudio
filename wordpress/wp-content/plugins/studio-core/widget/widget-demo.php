<?php
// Ngăn chặn truy cập trực tiếp
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class My_Custom_Widget extends WP_Widget {

    // 1. Hàm khởi tạo (Constructor)
    function __construct() {
        parent::__construct(
            'my_custom_widget', // ID của widget
            esc_html__( 'Widget Tùy Chỉnh Của Tôi', 'text_domain' ), // Tên hiển thị
            array( 'description' => esc_html__( 'Một widget đơn giản', 'text_domain' ) ) // Mô tả
        );
    }

    // 2. Hàm hiển thị widget (Frontend)
    public function widget( $args, $instance ) {
        // ... (phần code này giữ nguyên)
        $bg_color = ! empty( $instance['bg_color'] ) ? esc_attr( $instance['bg_color'] ) : '#ffffff';
        $text_color = ! empty( $instance['text_color'] ) ? esc_attr( $instance['text_color'] ) : '#000000';
        $border = ! empty( $instance['border'] ) ? esc_attr( $instance['border'] ) : '1px solid #cccccc';

        echo $args['before_widget'];
        echo '<div style="background-color: ' . $bg_color . '; color: ' . $text_color . '; border: ' . $border . '; padding: 15px;">';

        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }
        echo '<p>' . esc_html( $instance['text'] ) . '</p>';

        echo '</div>';
        echo $args['after_widget'];
    }

    // 3. Hàm tạo form trong trang quản trị (Backend)
    public function form( $instance ) {
        // ... (phần code này giữ nguyên)
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $text = ! empty( $instance['text'] ) ? $instance['text'] : '';
        $bg_color = ! empty( $instance['bg_color'] ) ? $instance['bg_color'] : '#ffffff';
        $text_color = ! empty( $instance['text_color'] ) ? $instance['text_color'] : '#000000';
        $border = ! empty( $instance['border'] ) ? $instance['border'] : '1px solid #cccccc';
        ?>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Tiêu đề:', 'text_domain' ); ?></label> 
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_attr_e( 'Nội dung:', 'text_domain' ); ?></label> 
        <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $text ); ?></textarea>
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>"><?php esc_attr_e( 'Màu nền:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'bg_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'bg_color' ) ); ?>" type="color" value="<?php echo esc_attr( $bg_color ); ?>">
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>"><?php esc_attr_e( 'Màu chữ:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_color' ) ); ?>" type="color" value="<?php echo esc_attr( $text_color ); ?>">
        </p>
        <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'border' ) ); ?>"><?php esc_attr_e( 'Border:', 'text_domain' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'border' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border' ) ); ?>" type="text" value="<?php echo esc_attr( $border ); ?>">
        <small>Ví dụ: 1px solid #cccccc</small>
        </p>
        <?php 
    }

    // 4. Hàm cập nhật dữ liệu (Update)
    public function update( $new_instance, $old_instance ) {
        // ... (phần code này giữ nguyên)
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['text'] = ( ! empty( $new_instance['text'] ) ) ? sanitize_textarea_field( $new_instance['text'] ) : '';
        $instance['bg_color'] = sanitize_hex_color( $new_instance['bg_color'] );
        $instance['text_color'] = sanitize_hex_color( $new_instance['text_color'] );
        $instance['border'] = sanitize_text_field( $new_instance['border'] );
        return $instance;
    }
}