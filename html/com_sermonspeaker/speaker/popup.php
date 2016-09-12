<?php
/**
 * @package     SermonSpeaker
 * @subpackage  Component.Site
 * @author      Thomas Hunziker <admin@sermonspeaker.net>
 * @copyright   (C) 2014 - Thomas Hunziker
 * @license     http://www.gnu.org/licenses/gpl.html
 **/

defined('_JEXEC') or die();

JHtml::_('bootstrap.tooltip');

if (!$this->item->pic) {
	$this->item->pic = 'media/com_sermonspeaker/images/' . $this->params->get('defaultpic', 'nopict.jpg');
}
?>
<div class="ss-speaker-container<?php echo htmlspecialchars($this->params->get('pageclass_sfx')); ?>" >
	<div class="<?php echo ($this->item->state) ? '' : 'system-unpublished'; ?>">
		<div class="page-header">
			<a href="<?php echo JRoute::_(SermonspeakerHelperRoute::getSpeakerRoute($this->item->slug)); ?>" target="_parent">
				<h1><?php echo $this->item->title; ?></h1>
			</a>
			<?php if (!$this->item->state) : ?>
				<span class="label label-warning"><?php echo JText::_('JUNPUBLISHED'); ?></span>
			<?php endif; ?>
		</div>
		<a href="<?php echo JRoute::_(SermonspeakerHelperRoute::getSpeakerRoute($this->item->slug)); ?>">
			<img class="img-polaroid pull-left item-image" src="<?php echo SermonspeakerHelperSermonspeaker::makelink($this->item->pic); ?>">
		</a>
		<?php if (in_array('speaker:intro', $this->columns) and $this->item->intro) : ?>
			<div>
				<?php echo JHtml::_('content.prepare', $this->item->intro, '', 'com_sermonspeaker.intro'); ?>
			</div>
		<?php endif;

		if (in_array('speaker:bio', $this->columns) and $this->item->bio) : ?>
			<div>
				<?php echo JHtml::_('content.prepare', $this->item->bio, '', 'com_sermonspeaker.bio'); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
