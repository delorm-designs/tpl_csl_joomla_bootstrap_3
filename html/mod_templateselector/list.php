<?php defined( '_JEXEC' ) or die;?>
<?php
if(count($lists) < 1) return;
$displayThumb = $params->get('displaythumbnail');
$baseUrl = JURI::base(true);
$thumbWidth = intval($params->get('width', 140));
$width = '';
if($thumbWidth){
	$width = ' width="'. $thumbWidth. '"';
}
?>
<ul class="tplselector<?php echo $moduleclass_sfx;?>">
<?php foreach($lists as $k => $row):?>
	<?php
		$title = htmlentities($row->text, ENT_COMPAT, 'UTF-8');
	?>
	<li class="tplselectoritem<?php echo ($k%2? ' odd':'');?><?php
		echo ($row->current? ' active':'');?>">
		<?php if(!$row->current):?>
		<a href="javascript:void(0);" onclick="jQuery.jTemplateSelectorWrite(<?php
			echo $row->value;?>);window.location.reload();" title="<?php
			echo $title;?>">
		<?php endif;?>
			<?php if($displayThumb):?>
			<img align="center"<?php echo $width;?> src="<?php
				echo $baseUrl. '/templates/'. $row->template
						.'/template_thumbnail.png';?>" alt="<?php
				echo $title;?>" onerror="this.src='<?php
				echo $baseUrl;?>/modules/mod_templateselector/images/no_image.png';"/><br />
			<?php endif;?>
			<span><?php echo $title;?></span>
		<?php if(!$row->current):?>
		</a>
		<?php endif;?>
	</li>
<?php endforeach;?>
</ul>