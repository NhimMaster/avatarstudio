<?php get_header(); ?>

<main id="primary" class="site-main">
    <section class="album-archive">
        <div class="container">
            <h1 class="archive-title">Bộ sưu tập Albums</h1>
            <div class="album-grid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="album-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="album-thumbnail">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                <?php endif; ?>
                                <h2 class="album-title"><?php the_title(); ?></h2>
                            </a>
                        </div>
                    <?php endwhile; ?>

                    <div class="pagination">
                        <?php the_posts_pagination(); ?>
                    </div>
                <?php else : ?>
                    <p>Chưa có album nào được tạo.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>