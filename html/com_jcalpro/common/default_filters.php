<?php
/**
 * @version		$Id: default_filters.php 772 2012-04-17 19:21:09Z jeffchannell $
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

?>
<fieldset id="filter-bar">
	<div class="filter-search fltlft">
		<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
		<input type="text" name="filter_search" id="filter_search" value="<?php echo JCalProHelperFilter::escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_JCALPRO_FILTER_SEARCH_DESC'); ?>" />

		<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
		<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
	</div>
	<div class="filter-select fltrt">
		<select name="filter_published" class="inputbox" onchange="this.form.submit()">
			<option value=""><?php echo JText::_('COM_JCALPRO_SELECT_PUBLISHED');?></option>
		</select>
	</div>
</fieldset>
<div class="clr"> </div>