<?php
/*
	Copyright (c) 2012 Jimmy Li (JzL)

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php

$opts = get_option("layout_opts");
$opts = is_array($opts) ? $opts : array();
$layout = is_array( $opts['layout'] ) ? $opts['layout'] : array();

$cats = get_cats($layout);

$posts = get_posts( array('meta_key' => 'post_banner_image') );
$slidelist = get_option( 'slide_opts' );
$slidelist = is_array($slidelist) ? $slidelist : array();

foreach( $posts as $i=>$post )
    if( in_array( $post->ID, $slidelist ) ) unset($posts[$i]);

$slides = array();
foreach( $slidelist as $i=>$postID ) {
  $post = get_post( $postID );
  $p = new stdClass;
  $catID = wp_get_post_categories( get_the_ID() );
  $catID = $catID[0];
  $catID = is_numeric($catID) && $catID >= 0 ? $catID : 0;
  $catName = get_category( $catID )->name;
  
  setup_postdata( $post );
  $p->img = get_post_meta_img($postID,'slideshow');
  $p->post_ID = $postID;
  $p->title = get_the_title();
  $p->link = get_permalink();
  $p->cat = $catName;
  $p->catLink = get_category_link( $catID );
  $p->desc = get_the_excerpt();

  array_push( $slides, $p );
}
?>
<?php get_header(); ?>
<script type="text/javascript">
  var slidesInfo=<?php echo json_encode($slides)?>;
  jQuery(function($) {
      $(".slider").jslides( slidesInfo, {start:1} );
  });
</script>
<section id="body">
  <section id="main">
    <section id="top-promo" class="slider"></section>
    <?php foreach( $cats as $i=>$c ) : ?>
    <section class="news-promo">
      <h2><a href="<?php echo get_category_link( $c->cat_ID ) ?>"><?php echo $c->name?></a></h2>
    <?php

      $img_count = intval(get_meta_option('misc_opts','tiles_img_count'));
      $font_size = intval(get_meta_option('misc_opts','tiles_font_size'));
      $line_count = intval(get_meta_option('misc_opts','tiles_lines_per_post'));
      $posts_needed = 0;
      foreach( $c->tileInfo['tiles'] as $j=>$tile ) $posts_needed += intval($tile['height']);
      $posts = get_featured_posts( array( 'category'=>$c->cat_ID, 'numberposts'=>$posts_needed ) );
      $postn = 0;
				   
      foreach( $c->tileInfo['tiles'] as $j=>$tile ) :
        $n = intval($tile['height']);
	$imgh = intval(round(1/$tile['size'] * 260));
	$i = 0;
    ?>
      <section class="news-tile-<?php echo get_size_name($tile['size'])?> tile clearfix" style="min-height:<?php echo $imgh*$img_count+$n*($line_count*$font_size+50)?>px">
	<?php
		global $post;
		while( --$n >= 0 && isset($posts[$postn]) ) :
	        $post = $posts[$postn];
		setup_postdata($post); $i++; $postn++;
	?>
	<section class="promo-story">
	  <div class="promo-title">
	    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
          </div>
	  <div class="promo-desc" <?php echo ($i<=$img_count?'style="padding-bottom: '.$imgh.'px;"':'');?>>
	        <?php if( $i<=$img_count ) : ?>
	   	<img src="<?php echo get_post_meta_img(get_the_ID(),'slideshow')?>" class="promo-img" style="height:<?php echo $imgh ?>PX;"/>
		<?php endif; ?>
	  	<?php the_excerpt() ?>
	  </div>
	</section>
        <?php endwhile; wp_reset_postdata(); /* End post loop */ ?>
      </section>
      <?php endforeach; /* End Tile loop */ ?>
      <div style="clear:both"></div>
    </section>
    <?php endforeach; /* End category loop */ ?>
    <div style="clear:both"></div>
  </section> <!-- #main -->
  <?php get_sidebar() ?>
<div style="clear:both"></div>
</section> <!-- #body -->
<div style="clear:both"></div>
</section>
<?php get_footer() ?>
