<?php defined( '_JEXEC' ) or die;?>
<?php if($params->get('displaythumbnail')):?>
<div class="tplselector<?php echo $moduleclass_sfx;?>">
	<div id="tplthumb">
		<img id="tpscurimg" src="<?php
			echo $lists['current_image'];?>" width="<?php
			echo $params->get('width', 140);?>" onerror="this.src='<?php
			echo JURI::base(true);?>/modules/mod_templateselector/images/no_image.png';"/>
	</div>
	<?php endif;?>
	<div id="tpllist">
	<?php echo $lists['list'];?>
	</div>
	<div id="tplbtns">
		<button type="button" class="btn" id="jTemplateReset">
			<?php echo $params->get('resetbtn', JText::_('MOD_TEMPLATE_SELECTOR_RESET'));?></button>
		<button type="button" class="btn" id="jTemplateChange">
			<?php echo $params->get('switchbtn', JText::_('MOD_TEMPLATE_SELECTOR_SWITCH'));?></button>
		<button type="button" class="btn" id="jTemplateRolling">
			<?php echo $params->get('rollbtn', JText::_('MOD_TEMPLATE_SELECTOR_ROLLING'));?></button>
		<input type="hidden" id="jTemplateDirectory" name="templatedirectory" value="<?php echo $lists['selected'];?>" />
	</div>
</div>