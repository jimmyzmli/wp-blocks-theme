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

?>
<?php get_header(); ?>
<section id="body">
  <section id="main">
    <section id="top-promo">
      <h2>Top News Story</h2>
      <section class="promo-title">
	<h2>News Title</h2>
	<article class="promo-desc">
	  NEWS NEWS NEWS NEWS NEWS LOL
	</article>
      </section>
      <img src="http://placehold.it/450x259" class="promo-img"/>
      <div style="clear:both"></div>
    </section>

    <?php foreach( $cats as $i=>$c ) : ?>
    <section class="news-promo">
      <h2><?=$c->name?></h2>
      <?php foreach( $c->tileInfo['tiles'] as $j=>$tile ) : ?>
      <section class="news-tile-<?=get_size_name($tile['size'])?>" style="height:<?=intval($tile['height'])*150?>px">
	<?php foreach( get_posts_for_cat($c->cat_ID,1) as $k=>$post ) : setup_postdata($post) ?>
	<section class="promo-story">
	  <img src="<?=get_the_post_thumbnail($p->id, array(300,200))?>" class="promo-img"/>
	  <div class="promo-title">
	    <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
          </div>
	  <section class="promo-desc"><?php the_excerpt() ?></section>
	</section>
        <?php endforeach; wp_reset_postdata(); ?>
      </section>
      <?php endforeach; ?>
      <div style="clear:both"></div>
    </section>
    <?php endforeach; ?>
    <div style="clear:both"></div>
  </section> <!-- #main -->

  <section id="side">
    <section id="about">
      <h2>About <?=bloginfo('name')?></h2>
      <div class="desc">About here BLAH BLAH BLAH BLAH BLAH</div>
    </section>
    <?php get_sidebar() ?>
  </section> <!-- #side -->
<div style="clear:both"></div>
</section> <!-- #body -->
<div style="clear:both"></div>
</section>
<?php get_footer() ?>
