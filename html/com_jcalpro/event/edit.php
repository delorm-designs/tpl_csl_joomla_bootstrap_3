<?php
/**
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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

JText::script('COM_JCALPRO_VALIDATION_FORM_FAILED');
JText::script('COM_JCALPRO_VALIDATION_JFORM_TITLE_FAILED');
JText::script('COM_JCALPRO_VALIDATION_JFORM_CANONICAL_ID_FAILED');
JText::script('COM_JCALPRO_INVALID_DATE');

$detailsForm      = $this->form->getFieldset('event');
$hiddenForm       = $this->form->getFieldset('hidden');
$repeatForm       = $this->form->getFieldset('repeat');
$contactForm      = $this->form->getFieldset('contact');
$durationForm     = $this->form->getFieldset('duration');
$startDateForm    = $this->form->getFieldset('startdate');
$registrationForm = $this->form->getFieldset('registration');
$customfieldsForm = $this->form->getFieldset('customfields');
$metadataForm     = $this->form->getFieldset('jmetadata');
$nonextra = array('event', 'hidden', 'repeat', 'contact', 'duration', 'startdate', 'registration', 'customfields', 'jmetadata');
// this is kinda backwards :)
$customfieldsFormTitle = '';
$fieldsets = $this->form->getFieldsets();
foreach ($fieldsets as $fieldset) {
	if ('customfields' != $fieldset->name) continue;
	$customfieldsFormTitle = $fieldset->label;
	break;
}

// permissions
$canonical = null;
$formcanonical = $this->form->getValue('canonical');
if (!empty($formcanonical)) $canonical = $formcanonical;
$canCreatePrivate = JCalPro::canDo('core.create.private', $canonical);
$canCreatePublic  = JCalPro::canDo('core.create', $canonical);
$canModerate      = JCalPro::canDo('core.moderate', $canonical);
$canEditState     = JCalPro::canDo('core.edit.state', $canonical);
?>
<script type="text/javascript">
	window.jclAcl = {
		moderate: <?php echo (int) $canModerate; ?>
	,	createPrivate: <?php echo (int) $canCreatePrivate; ?>
	,	createPublic: <?php echo (int) $canCreatePublic; ?>
	,	editState: <?php echo (int) $canEditState; ?>
	};
	Joomla.submitbutton = function(task) {
		if ('undefined' != typeof window.jclDateTimeCheckActive) {
			JCalPro.debug('Cannot save yet - waiting for date validation...');
			window.jclDateTimeCheckSubmitTask = task;
			window.jclDateTimeCheckSubmitTimer = setTimeout(function() {
				Joomla.submitbutton(window.jclDateTimeCheckSubmitTask);
			}, 200);
			return;
		}
		if (task == 'event.cancel' || document.formvalidator.isValid(document.id('event-form'))) {
			try {
				<?php echo $this->form->getField('description')->save(); ?>
			}
			catch (err) {
				// tinyMCE not in use
			}
			Joomla.submitform(task, document.getElementById('event-form'));
		}
		else {
			var fields = ['jform_title', 'jform_canonical_id'], found = false;
			JCalPro.each(fields, function(el, idx) {
				if (found) return;
				if ('' == $(el).value) {
					found = true;
					alert(Joomla.JText._('COM_JCALPRO_VALIDATION_' + el.toUpperCase() + '_FAILED'));
				}
			});
			if (!found) alert(Joomla.JText._('COM_JCALPRO_VALIDATION_FORM_FAILED'));
		}
	}
</script>
<div id="jcl_component" class="<?php echo $this->viewClass; ?>">
	<div class="jcl_event">
		<div class="jcl_subtitlebar">
			<div class="jcl_left"><?php echo JText::_('COM_JCALPRO_MAINMENU_' . ($this->item->id ? 'EDIT' : 'ADD')); ?></div>
			<div class="jcl_clear"><!--  --></div>
		</div>
		<h3 class="jcl_header"><?php
			echo JText::_('COM_JCALPRO_EVENT_DETAILS');
		?></h3>
		
		<form action="<?php echo JRoute::_('index.php?option=com_jcalpro&task=event.save&id=' . (int) $this->item->id); ?>" method="post" id="event-form" enctype="multipart/form-data">
        <?php foreach ($detailsForm as $name => $field) : ?>
            <div class="form-group">
                <?php echo $field->label; ?>
                <?php echo $field->input; ?>
            </div>
        <?php endforeach; ?>
        <?php foreach ($metadataForm as $name => $field) : ?>
            <div class="form-group">
                <?php echo $field->label; ?>
                <?php echo $field->input; ?>
            </div>
        <?php endforeach; ?>
                    <?php
					echo JText::_('COM_JCALPRO_EVENT_DATE_AND_TIME');
				?>
                        <?php
						echo $startDateForm['jform_start_date_array']->input;
					?>
                <?php
						echo $startDateForm['jform_timezone']->input;
					?>


				<div class="jcl_clear"><!--  --></div>
				
				<div class="jcl_form_label jcl_left"><?php
					echo JText::_('COM_JCALPRO_DURATION');
				?></div>
				<div class="jcl_form_element jcl_left">
					<div class="jcl_form_subelement"><?php
						printf($this->form->getInput('duration_type')
							, '</label>'
							. $this->form->getLabel('end_date_array')
							. $this->form->getInput('end_date_array')
							. '<label>'
							, '</label>'
							. $this->form->getInput('end_days')
							. $this->form->getLabel('end_days')
							. $this->form->getInput('end_hours')
							. $this->form->getLabel('end_hours')
							. $this->form->getInput('end_minutes')
							. $this->form->getLabel('end_minutes')
							. '<label class="jcl_block">'
						);
					?></div>
				</div>
				<div class="jcl_clear"><!--  --></div>
			</div>
<?php if (!empty($customfieldsFormTitle)) : ?>
			<h3 class="jcl_header"><?php
				echo JCalProHelperFilter::escape($customfieldsFormTitle);
			?></h3>
	<?php foreach ($customfieldsForm as $name => $field) : ?>
			<div class="jcl_row">
				<div class="jcl_form_label jcl_left"><?php
					echo $field->label;
				?></div>
				<div class="jcl_form_element jcl_left"><?php
					echo $field->input;
				?></div>
				<div class="jcl_clear"><!--  --></div>
			</div>
	<?php endforeach; ?>
<?php endif; ?>
			<div id="recurrence_open">
				<h3 class="jcl_header">
					<span class="recurrence_button"><?php
						echo JHtml::_('jcalpro.image', 'icon-plus.gif', $this->template, array(
							'class' => 'jcal_recurrence_button jcal_recurrence_plus'
						,	'alt'   => JText::_('COM_JCALPRO_EXPAND')
						));
					?></span>
					<?php echo JText::_('COM_JCALPRO_REPEAT_EVENT'); ?>
				</h3>
				<div id="recur_message" class="jcl_row jcl_message" align="center"><?php
					echo JText::_('COM_JCALPRO_EVENT_DOES_NOT_REPEAT');
				?></div>
			</div>
			<div id="recurrence_close">
				<h3 class="jcl_header">
					<span class="recurrence_button"><?php
						echo JHtml::_('jcalpro.image', 'icon-minus.gif', $this->template, array(
							'class' => 'jcal_recurrence_button jcal_recurrence_minus'
						,	'alt'   => JText::_('COM_JCALPRO_COLLAPSE')
						));
					?></span>
					<?php echo JText::_('COM_JCALPRO_REPEAT_EVENT'); ?>
				</h3>
				<div class="jcal_categories"><?php
					echo JText::_('COM_JCALPRO_REPEAT_METHOD');
				?></div>
				<div class="jcl_row">
					<div class="jcl_form_label jcl_left"><?php
						echo $repeatForm['jform_recur_type']->input;
					?></div>
					<div class="jcl_form_element jcl_left">
						<div id="jcl_rec_none_options"> </div>
						<div id="jcl_rec_daily_options">
							<ul>
								<li><?php
									printf($repeatForm['jform_rec_daily_period']->label, 'X', '</label>' . $repeatForm['jform_rec_daily_period']->input . '<label>');
								?></li>
							</ul>
						</div>
						<div id="jcl_rec_weekly_options">
							<ul>
								<li><?php
									printf($repeatForm['jform_rec_weekly_period']->label, 'X', '</label>' . $repeatForm['jform_rec_weekly_period']->input . '<label>');
								?><br /><?php
									echo $repeatForm['jform_rec_weekly_on_sunday']->input;
									echo $repeatForm['jform_rec_weekly_on_sunday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_monday']->input;
									echo $repeatForm['jform_rec_weekly_on_monday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_tuesday']->input;
									echo $repeatForm['jform_rec_weekly_on_tuesday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_wednesday']->input;
									echo $repeatForm['jform_rec_weekly_on_wednesday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_thursday']->input;
									echo $repeatForm['jform_rec_weekly_on_thursday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_friday']->input;
									echo $repeatForm['jform_rec_weekly_on_friday']->label;
									
									echo $repeatForm['jform_rec_weekly_on_saturday']->input;
									echo $repeatForm['jform_rec_weekly_on_saturday']->label;
								?></li>
							</ul>
						</div>
						<div id="jcl_rec_monthly_options">
							<ul>
								<li><?php
									printf($repeatForm['jform_rec_monthly_period']->label, 'X', '</label>' . $repeatForm['jform_rec_monthly_period']->input . '<label>');
								?><br /><?php
									printf(
										$repeatForm['jform_rec_monthly_type']->input
									, '</label>' . $repeatForm['jform_rec_monthly_day_number']->input . '<label>'
									, '</label>' . $repeatForm['jform_rec_monthly_day_order']->input . ' ' . $repeatForm['jform_rec_monthly_day_type']->input . '<label>'
									);
								?></li>
							</ul>
						</div>
						<div id="jcl_rec_yearly_options">
							<ul>
								<li><?php
									printf($repeatForm['jform_rec_yearly_period']->label, 'X', 'X', '</label>' . $repeatForm['jform_rec_yearly_period']->input . '<label>', '</label>' . $repeatForm['jform_rec_yearly_on_month']->input . '<label>');
								?><br /><?php
									printf(
										$repeatForm['jform_rec_yearly_type']->input
									, '</label>' . $repeatForm['jform_rec_yearly_day_number']->input . '<label class="jcl_block jcl_clear">'
									, '</label>' . $repeatForm['jform_rec_yearly_day_order']->input . ' ' . $repeatForm['jform_rec_yearly_day_type']->input . '<label>'
									);
								?></li>
							</ul>
						</div>
					</div>
					<div class="jcl_clear"><!--  --></div>
				</div>
				<div class="jcalrepeatend">
					<div class="jcal_categories"><?php
						echo JText::_('COM_JCALPRO_REPEAT_END_DATE');
					?></div>
					<div class="jcl_row"><?php
						printf($repeatForm['jform_recur_end_type']->input, '</label>' . $repeatForm['jform_recur_end_count']->input . '<label>', '</label>' . $repeatForm['jform_recur_end_until']->input . '<label>');
					?></div>
				</div>
			</div>
<?php if ($this->item->allow_registration && !empty($registrationForm)) : ?>
			<div id="jcl_registration">
				<div id="registration_open">
					<h3 class="jcl_header">
						<span class="registration_button"><?php
							echo JHtml::_('jcalpro.image', 'icon-plus.gif', $this->template, array(
								'class' => 'jcal_registration_button jcal_registration_plus'
							,	'alt'   => JText::_('COM_JCALPRO_EXPAND')
							));
						?></span>
						<?php echo JText::_('COM_JCALPRO_REGISTRATION'); ?>
					</h3>
					<div id="registration_message" class="jcl_row jcl_message"><?php
						echo JText::_('COM_JCALPRO_EVENT_NO_REGISTRATION');
					?></div>
				</div>
				<div id="registration_close">
					<h3 class="jcl_header">
						<span class="registration_button"><?php
							echo JHtml::_('jcalpro.image', 'icon-minus.gif', $this->template, array(
								'class' => 'jcal_registration_button jcal_registration_minus'
							,	'alt'   => JText::_('COM_JCALPRO_COLLAPSE')
							));
						?></span>
						<?php echo JText::_('COM_JCALPRO_REGISTRATION'); ?>
					</h3>
					<div class="jcl_row">
						<div class="jcl_form_label jcl_left"><?php
							echo $registrationForm['jform_registration']->input;
						?></div>
						<div class="jcl_form_element jcl_left">
							<div id="jcl_registration_off_options"> </div>
							<div id="jcl_registration_on_options">
								<ul class="formlist">
								<?php foreach ($registrationForm as $name => $field) : if ('jform_registration' == $name) continue; ?>
									<li><?php
										echo $field->label . ' ' . $field->input;
									?></li>
								<?php endforeach; ?>
								</ul>
							</div>
						</div>
						<div class="jcl_clear"><!--  --></div>
					</div>
				</div>
			</div>
<?php endif; ?>
<?php
	foreach ($this->form->getFieldsets() as $fieldset) :
		if (in_array($fieldset->name, $nonextra)) continue;
		$fields = $this->form->getFieldset($fieldset->name);
		if (empty($fields)) continue;
		$showFieldset = true;
		foreach ($fields as $field) :
			if (!$showFieldset) break;
			$showFieldset = $showFieldset && strlen((string) $field->label);
		endforeach;
		if ($showFieldset) :
?>
			<h3 class="jcl_header"><?php
				echo JCalProHelperFilter::escape(JText::_($fieldset->label));
			?></h3>
			<?php foreach ($fields as $name => $field) : ?>
			<div class="jcl_row">
				<div class="jcl_form_label jcl_left"><?php
					echo $field->label;
				?></div>
				<div class="jcl_form_element jcl_left"><?php
					echo $field->input;
				?></div>
				<div class="jcl_clear"><!--  --></div>
			</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div style="display:none">
			<?php foreach ($fields as $name => $field) echo $field->input; ?>
			</div>
		<?php endif; ?>
<?php endforeach; ?>
			<div class="jcal_categories">
				<input class="button" type="submit" value="<?php echo JText::_('COM_JCALPRO_BUTTON_' . ($this->item->id ? 'EDIT' : 'ADD') . '_EVENT'); ?>" />
				<input class="button" type="submit" value="<?php echo JText::_('COM_JCALPRO_BUTTON_BACK'); ?>" name="cancel_add_event" onclick="document.getElementById('event-task').value='event.cancel';return true;" />
				<?php echo JHtml::_('form.token'); ?>
				<?php foreach ($hiddenForm as $field) echo $field->input; ?>
				<input type="hidden" id="event-task" name="task" value="event.save" />
				<input type="hidden" id="event-catid" name="catid" value="<?php echo JFactory::getApplication()->input->get('catid', 0, 'uint'); ?>" />
				<input type="hidden" id="event-id" name="id" value="<?php echo $this->item->id; ?>" />
			</div>
		</form>
	</div>
<?php
// display the footer
echo JHtml::_('jcalpro.footer', $this->template);
?>
</div>

<?php echo $this->loadTemplate('debug');
