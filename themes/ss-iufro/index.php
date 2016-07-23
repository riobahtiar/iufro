<?php 
    global $wp, $wp_query;
    get_header(); 
?>
    
    <div id="content" class="general">

        <div class="container">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>

            <div class="post">                  
                <header>
                    <?php iufro_post_thumbnail(); ?>              
                    <h3 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>                   
                </header>
                <article class="entry">
                    <div class="post-meta">
                        <div class="left">
                            <div class="category"><?php the_category(', ') ?> </div>
                        </div>
                        <div class="right">
                            <div class="time left"><i class="fa fa-clock-o fa-fw"></i> <?php the_time('jS F, Y') ?> </div>
                            <div class="comments right"><i class="fa fa-comments fa-fw"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>
                        </div>
                        <div class="clear"></div>
                    </div>          
                   

                    <div class="excerpt">
                        <?php 
                            iufro_excerpt('iufro_index','iufro_post_readmore');
                        ?>
                    </div>
                
                    <div class="clear"></div>
                </article>
                <footer></footer>
            </div>                
            
            <?php endwhile; ?>

        <?php 
        /*
            $big = 999999999; // need an unlikely integer
             
            echo paginate_links( array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => max( 1, get_query_var('paged') ),
                'total' => $wp_query->max_num_pages,
                'prev_text' => '<i class="fa fa-angle-left"></i>',
                'next_text' => '<i class="fa fa-angle-right"></i>'
            ) );
        */
            $paged = 1;
            $paged = get_query_var('paged')?get_query_var('paged'):$paged;
            $paged = (empty($paged) && get_query_var('page'))?get_query_var('page'):$paged;          
        ?>      
            
        <?php endif; ?>

        </div>

    </div>
        
<?php get_footer(); ?>