<?php
/**
 * @version		$Id: default_month_body.php 772 2012-04-17 19:21:09Z jeffchannell $
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

JHtml::_('behavior.modal');
JHtml::_('behavior.tooltip');

// begin calendar table
$archive        = JCalPro::config('archive');

?>
<?php for ($row=1-JCalProHelperDate::getFirstDay(); $row<=count($this->items); $row+=7) : ?>
	<div class="jcl_month_table">
		<table class="jcl_month_row" cellpadding="0" cellspacing="0">
			<tr>
	<?php if ($this->showWeek) : ?>
				<td class="jcl_month_week_number" align="center">
		<?php
			$key = (!array_key_exists($row + 6, $this->items) ? count($this->items) : $row + 6);
			if ($this->tpl) : ?>
			<?php echo $this->items[$key]['week_number']; ?>
		<?php else : ?>
					<a href="<?php echo JCalProHelperUrl::events($this->items[$key]['user_datetime']->toRequest(),'week') ?>"><?php
					echo $this->items[$key]['week_number'];
				?></a>
		<?php endif; ?>
				</td>
	<?php endif; ?>
				<td>
					<table class="jcl_month_inner_row" cellpadding="0" cellspacing="0">
						<tr>
<?php
		for ($col=0; $col<7; $col++) :
			$cell_day = $row + $col;
			// check if we have a stack for this day
			if (!array_key_exists($cell_day, $this->items)) {
				// cells outside the month - if negative, they are in the previous month and if not they are in the next
				$month = ($cell_day < 1 ? $this->dates->prev_month : $this->dates->next_month);
				?><td class="jcl_month_cell jcl_month_cell_empty weekdayemptyclr" align="center" valign="middle"><?php echo $month->format(JText::_('COM_JCALPRO_DATE_FORMAT_MONTH_YEAR')); ?></td><?php
			}
			// cells for this month
			else {
				// define our stack
				$stack = $this->items[$cell_day];
				
				?>
						<td class="jcl_month_cell <?php echo $stack['class']; if (!empty($stack['events'])) echo ' jcl_month_cell_events'; ?>" align="center" valign="top" onmouseover="jclMonthCell(this);return true;" onmouseout="jclMonthCell(this);return true;">
							<div class="jcl_month_cell_number jcl_left">
								<?php if (!empty($stack['events']) && !$this->tpl) : ?>
									<a href="<?php echo JCalProHelperUrl::events($stack['user_datetime']->toRequest(), 'day'); ?>" rel="nofollow"><?php
										echo $cell_day;
									?></a>
								<?php else : ?>
									<?php echo $cell_day; ?>
								<?php endif; ?>
							</div>
							<div class="jcl_month_add jcl_right">
								<?php
								// check if user is allowed to create events
								if (JCalPro::canAddEvents() && !$this->tpl && (!$archive || ($archive && $stack['user_datetime'] >= $this->dates->today))) :
									echo JHtml::_('jcalpro.addlink', JHtml::_('jcalpro.image', 'addsign.gif', $this->template, array(
										'name'   => "add$cell_day"
									,	'alt'    => JCalProHelperFilter::escape(JText::sprintf('COM_JCALPRO_ADD_NEW_EVENT_ON', $stack['user_datetime']->format(JText::_('COM_JCALPRO_DATE_FORMAT_FULL_DATE'))))
									,	'border' => 0
									)), 'noajax', array('date'=>$stack['user_datetime']->toRequest()));
								endif;
								
								?>
							</div>
							<div class="jcl_clear"><!--  --></div>
						<?php 
						if (!empty($stack['events'])) :
							foreach ($stack['events'] as $event) : ?>
							<div class="eventmiddle">
								<div class="jcl_nooverflow eventstyle" style="border-bottom-color: <?php echo $event->color; ?>;">
									<?php
									echo JHtml::_('jcalpro.image', 'events/icon-event-' . $event->icon . '.gif', $this->template, array(
										'hspace' => "2"
									,	'alt'    => ''
									,	'border' => 0
									));
									
									$title = $event->title;
									//if ($this->title_limit) $title = JCalProHelperFilter::truncate($title, $this->title_limit);
									if ($this->title_limit) $title = JHTML::_('string.truncate', $title, $this->title_limit);
									$title = JCalProHelperFilter::escape($title).' ('.$event->timedisplay.')';
									
									$description = $event->description;
									if ($this->description_limit) $description = JCalProHelperFilter::truncate($description, $this->description_limit);
									$description = JCalProHelperFilter::escape(strip_tags(JCalProHelperFilter::purify($description)));
				
									if ($this->tpl) :
										echo $title;
									else :
										?><a href="#" <?php 
										if ($this->show_description) :
											?> class="eventtitle" title="" onclick="SqueezeBox.fromElement('<?php echo JRoute::_($event->href); ?>?tmpl=component', {size:{x:700,y:555}, handler:'iframe'});"><?php
										else :
											?> class="eventtitle" title="" onclick="SqueezeBox.fromElement('<?php echo JRoute::_($event->href); ?>?tmpl=component', {size:{x:700,y:555}, handler:'iframe'});"><?php
										endif;
										echo $title; ?></a><?php
									endif;
									?>
								</div>
							</div>
							<?php
							endforeach;
						endif;
						?>
						</td>
				<?php
			}
		endfor;

	?>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
<?php endfor; ?>
<?php if (!$this->tpl) echo $this->loadTemplate('categories'); ?>