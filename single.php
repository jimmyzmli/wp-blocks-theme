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
<?php get_header() ?>
       <section id="body">
	  <?php while( have_posts() ) : the_post() ?>
          <h2><?php the_title(); ?></h2>
          <div><?php the_content(); ?></div>
	  <?php get_template_part( 'content', 'single' ) ?>
	  <?php previous_post_link( "%link", __('Prev') ) ?>
	  <?php next_post_link( "%link", __('Next') ) ?>
          <?php endwhile; ?>
       </section>
<?php get_footer() ?>
