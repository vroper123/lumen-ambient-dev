<?php
/**
 * ARTICLE PART WITH COMMENTS
 *
 * This part can be used IN THE LOOP to output a single article with comments.
 */
use \NV\Theme\Utilities\Theme;
?>
<article id="article-<?php the_ID() ?>" class="<?php echo implode(get_post_class(),' ') ?>"  itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

    <h1 class="article-head" itemprop="headline"><?php the_title() ?></h1>

    <?php the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ) ?>

    <div class="entry-content" itemprop="text">
     <?php the_content() ?>
    </div>
   
    <footer class="entry-meta">
      <?php Theme::posted_in();?> <?php ?>
        <div id="comments">
            <?php comments_template( '/parts/comments/comments.php' ); ?>
        </div>
    </footer>

</article>