<?php
/**
 * @version		$Id: default_toolbar.php 838 2012-11-29 19:44:22Z jeffchannell $
 * @package		JCalPro
 * @subpackage	com_jcalpro

**********************************************
JCal Pro
Copyright (c) 2006-2012 Anything-Digital.com
**********************************************
JCalPro is a native Joomla! calendar component for Joomla!

JCal Pro was once a fork of the existing Extcalendar component for Joomla!
(com_extcal_0_9_2_RC4.zip from mamboguru.com).
Extcal (http://sourceforge.net/projects/extcal) was renamed
and adapted to become a Mambo/Joomla! component by
Matthew Friedman, and further modified by David McKinnis
(mamboguru.com) to repair some security holes.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This header must not be removed. Additional contributions/changes
may be added to this header as long as no information is deleted.
**********************************************
Get the latest version of JCal Pro at:
http://anything-digital.com/
**********************************************

 */

defined('JPATH_PLATFORM') or die;

$menu = JHtml::_('jcalpro.menu', isset($this->buttons) ? $this->buttons : array());
$filters = JHtml::_('jcalpro.filters');

?>
<div class="jcl_toolbar">
	<?php if (!empty($menu)) : ?>
	<div class="jcl_toolbar_buttons">
	<?php foreach ($menu as $button) : ?>
		<a title="<?php echo JCalProHelperFilter::escape($button['name']);
			?>" href="<?php echo JCalProHelperFilter::escape($button['href']);
			?>" class="<?php echo JCalProHelperFilter::escape(implode(' ', $button['class']));
			?>"<?php
			if (!empty($button['attr']) && is_array($button['attr'])) :
				foreach ($button['attr'] as $attribute => $value) : ?> <?php
					echo JCalProHelperFilter::escape($attribute) . '="' . JCalProHelperFilter::escape($value) . '"';
				endforeach;
			endif;
			?>><?php
			echo JCalProHelperFilter::escape($button['title']);
		?></a>
	<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<?php if (!empty($filters)) echo $filters; ?>
</div>
