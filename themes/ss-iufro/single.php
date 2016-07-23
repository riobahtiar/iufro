<?php get_header(); ?>
    
    <div id="content" class="post">

        <div class="container">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            
                    <div class="post-thumbnail">
						<?php echo the_post_thumbnail('medium') ?>
					</div>
					
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                    <span class="category"><?php the_category(', ') ?> </span>
					<span class="time left"><i class="fa fa-clock-o fa-fw"></i> <?php the_time('jS F, Y') ?> </span>
					<span class="like-post"><?php echo get_simple_likes_button( get_the_ID() ); ?></span>
					<span class="comments right"><i class="fa fa-comments fa-fw"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span>
									
                    <div class="entry">
                        <?php the_content(); ?>
                        <?php //edit_post_link('+ Edit', '<p>', '</p>'); ?>
                    </div>
                    
                    <div class="comment">
                        <?php
                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;
                        ?>
                    </div>
					<?php custom_set_post_views(get_the_ID());?>
                </div>
            
            <?php endwhile; ?>
        <?php endif; ?>
        
        </div>

    </div>
        
<?php get_footer(); ?>