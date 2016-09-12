<?php defined( '_JEXEC' ) or die;?>
<?php if($params->get('displaythumbnail')):?>
<div class="tplselector">
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
        <div class="col-xs-4 button-left">
            <button type="button" class="btn btn-primary" id="jTemplateReset">
                <?php echo $params->get('resetbtn', JText::_('MOD_TEMPLATE_SELECTOR_RESET'));?></button>
        </div>
        <div class="col-xs-4 button-center">
            <button type="button" class="btn btn-success" id="jTemplateChange">
                <?php echo $params->get('switchbtn', JText::_('MOD_TEMPLATE_SELECTOR_SWITCH'));?></button>
        </div>
        <div class="col-xs-4 button-right">
            <button type="button" class="btn btn-primary" id="jTemplateRolling">
                <?php echo $params->get('rollbtn', JText::_('MOD_TEMPLATE_SELECTOR_ROLLING'));?></button>
        </div>
		<input type="hidden" id="jTemplateDirectory" name="templatedirectory" value="<?php echo $lists['selected'];?>" />
	</div>
</div>