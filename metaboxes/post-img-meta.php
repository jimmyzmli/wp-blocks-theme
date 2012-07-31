<?php global $ma; ?>
<script type="text/javascript">
  jQuery(function($) {
      function changeDetect() {
	  $("input[class|='mediafield']").each( function() {
	      if( this.oldvalue != this.value )
		  $(this).siblings("img").attr('src',this.value);
	      this.oldvalue = this.value;
	  });
      }
      setInterval( changeDetect, 1000 );
  });
</script>
<div class="my_meta_control metabox">
  
  <?php $mb->the_field('desc'); ?>
  <p>
    A short description of the post (If not filled the default excerpt will be used)
    <textarea name="<?=$mb->get_the_name()?>"><?=( $mb->get_the_value() )?></textarea>
  </p>  

  <?php $mb->the_field('featured_thumb_img'); ?>  
  <?php $ma->setGroupName('nn')->setInsertButtonLabel('Insert'); ?>
  <p>
    <img src="<?=$mb->get_the_value()?>" style="width:70px;height:70px;"/>
    <?php echo $ma->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
    <?php echo $ma->getButton(); ?>
  </p>

  <?php $mb->the_field('slideshow_img'); ?>
  <?php $ma->setGroupName('nn2')->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
  <p>
    <img src="<?=$mb->get_the_value()?>" style="width:225px;height:130px;"/>
    <?php echo  $ma->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
    <?php echo $ma->getButton(array('label' => 'Add Image From Library')); ?>
  </p>
</div>
