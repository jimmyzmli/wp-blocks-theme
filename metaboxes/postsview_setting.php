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

define( 'POSTS_PER_PAGE', 3 );
define( 'PAGES_IN_NAV', 10 );   

function get_postviews_page_uri( $n ) {
  $c = 0;
  $url = preg_replace( '#(&?p=)\d*#i', '${1}'.$n,  $_SERVER['REQUEST_URI'], -1, $c);
  return $c == 0 ? "$url&p=$n" : $url;
}

$p = $_GET['p'];
$p = is_numeric( $p ) && $p >= 0 ? $p : 0;
$t = wp_count_posts('post')->publish + wp_count_posts('page')->publish;
$t = round($t/POSTS_PER_PAGE)-1;
$half = floor((PAGES_IN_NAV)/2);
$beg = $p-$half; $end = $p+$half;
$beg = $beg <= 0 ? 0 : $beg;
$end = $end >= $t ? $t : $end;

add_filter('posts_orderby','posts_orderby_query');
add_filter('posts_join','posts_join_query');
$posts = get_posts( array(
  'post_type' => 'any',
  'numberposts' => POSTS_PER_PAGE,
  'offset' => $p * POSTS_PER_PAGE,
  'order' => 'desc',
  'orderby' => 'post_date',
  'suppress_filters' => false
));
remove_filter('posts_join','posts_join_query');
remove_filter('posts_orderby','posts_orderby_query');

?>
<style type="text/css">
  .name {
      width: 560px;
  }
  .views {
      width: 400px;
      text-align: right;
  }
  .page-nav {
      width: 960px;
  }
  .page-nav li {
      float: left;
  }
  .page-nav .next {
      float: right;
  }

  .linklist {
      display: block;
      width: <?=($end-$beg+1)*12?>px;
      margin: auto auto;
  }

  .linklist .pagelink {
      float: none;
      display: inline;
      width: 10px;
      margin: 0px;
      padding: 0px;
      
  }
</style>
<section id="page">
<form action="options.php" method="POST">
   <?php settings_fields("misc_opts") ?>
   <input type="hidden" name="misc_opts[reset_post_views]" value="yes"/>
   <input type="submit" name="submit" value="Clear"/>
</form>
<table>
<?php global $post; foreach( $posts as $i=>$post ) : setup_postdata($post) ?>
<?php $pid = intval(get_the_ID()); ?>
  <tr>
     <td class="name"><a href="<?php the_permalink()?>" target="_blank"><?=get_the_title()?></a></td>
     <td class="views"><?=getPostViews($pid)?> Views</td>
  </tr>
<?php endforeach; ?>
</table>
<ul class="page-nav">
    <?php if( $p > 0 ) : ?>
    <li class="last"><a href="<?=get_postviews_page_uri($p-1)?>">Last</a></li>
    <?php endif; ?>
    <?php if( count($posts) >= POSTS_PER_PAGE ) : ?>
    <li class="next"><a href="<?=get_postviews_page_uri($p+1)?>">Next</a></li>
    <?php endif; ?>
    <ul class="linklist">
      <?php for($i=$beg;$i<=$end;$i++) : ?>
	    <li class="pagelink <?=($i==$p?' current':'')?>" >
	      <a <?=($i==$p?'':'href='.get_postviews_page_uri($i))?> ><?=$i+1?></a>
	    </li>
    <?php endfor; ?>
    </ul>
    <div style="clear:both"></div>
</ul>    
</section>