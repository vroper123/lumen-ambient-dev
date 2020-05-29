<?php
/**
 * ARTICLE PART (NO COMMENTS)
 *
 * This part can be used IN THE LOOP to output a single article (sans comments).
 */
use \NV\Theme\Utilities\Theme;
?>

<article id="article-<?php the_ID() ?>" class="<?php echo implode(get_post_class(),' ') ?>"  itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
<div class="blog-post">
    <?php if(!is_single()):?>
   <header class="entry-head">
    <h1 class="article-head" itemprop="headline"><a href="<?php echo esc_url(get_permalink());?>"><?php the_title() ?></a></h1>
    </header>
    <?php else:?>
        <header class="entry-head">
    <h1 class="article-head" itemprop="headline"><?php the_title() ?></h1>
    </header>
    <?php endif;?>
    <?php Theme::posted_on(); ?>

    <?php the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ) ?>
    <div class="entry-content" itemprop="text">
    
     <?php if ( false == get_theme_mod( 'lumen_full_content', false ) ) : 
        the_excerpt();  
     else:
         the_content();
     endif;?>
     </div>
    <a class="button" href="<?php echo esc_url(get_permalink());?>">Read On</a>
    <footer class="entry-meta">
    <?php Theme::posted_in();?>
    </footer>
</div>  
</article>


