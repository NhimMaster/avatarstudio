jQuery(document).ready(function ($) {
    var $grid = $('.custom-masonry-gallery-container');

    // Khởi tạo Masonry khi các hình ảnh đã được tải xong
    // $grid.imagesLoaded(function () {
        $grid.masonry({
            itemSelector: '.custom-masonry-item',
            columnWidth: '.custom-masonry-item',
            gutter: 10
        });
        // Khởi tạo Lightgallery
        // lightGallery(document.querySelector('.custom-masonry-gallery-container'));
    // });
});