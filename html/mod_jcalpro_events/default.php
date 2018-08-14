<?php
/**
 * @package		JCalPro
 * @subpackage	mod_jcalpro_events

**********************************************
JCal Pro
Copyright (c) 2006-2012 Anything-Digital.com
Copyright (c) 2016-2017 Open Source Training, LLC
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
https://joomlashack.com
**********************************************

 */

defined('JPATH_PLATFORM') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
JHtml::_('script', 'com_jcalpro/modal.min.js', array('relative' => true));

$tipClass = 'hasTip';
$tipSep   = '::';
$urlparams['tmpl'] = 'component';

if (JCalPro::version()->isCompatible('3.0.0')) {
    $tipClass = 'hasTooltip';
    $tipSep   = '<br>';
}

?>
<div class="jcalpro_events<?php echo $moduleclass_sfx; ?>">
<?php if (empty($list)) : echo $empty_html; ?>
<?php else: ?>
	<?php if ($first_month) : ?>
	<h4 class="jcalpro_events_month_header"><?php echo $first_month; ?></h4>
	<?php endif; ?>
	<ul class="jcalpro_events<?php echo $moduleclass_sfx; ?>">
	<?php foreach ($list as $item) :

        $has_location             = property_exists($item, 'location_data') && !empty($item->location_data);
        $display_location_as_icon = $display_location && !$display_location_text && $has_location;
        if ($has_location) {
            $location_tooltip      = $item->location_data->title;
            $location_tooltip_body = '';
            if (!empty($item->location_data->address)) {
                $location_tooltip_body .= $item->location_data->address;
            }
            if (empty($location_tooltip_body)) {
                $location_tooltip_body .= $item->location_data->city;
                $location_tooltip_body .= ' ' . $item->location_data->state;
                $location_tooltip_body  = trim($location_tooltip_body);
                if (empty($location_tooltip_body)) {
                    $location_tooltip_body = $item->location_data->postal_code;
                }
                if (empty($location_tooltip_body)) {
                    $location_tooltip_body = $item->location_data->latitude . ', ' . $item->location_data->longitude;
                }
                if (',' === trim($location_tooltip_body)) {
                    $location_tooltip_body = '';
                }
            }
            if (!empty($location_tooltip_body)) {
                $location_tooltip .= $tipSep . $location_tooltip_body;
            }
        }

        $this_month = $item->user_datetime->monthName();
        if ($last_month && $last_month != $this_month) :
            $last_month = $this_month;
        ?>
	</ul>
	<h4 class="jcalpro_events_month_header"><?php echo $this_month; ?></h4>
	<ul class="jcalpro_events<?php echo $moduleclass_sfx; ?>">
		<?php
        endif;
    ?>
		<li class="<?php echo $item->mod_events_class; ?>">
			<?php if ($top_fields) {
    echo modJCalProEventsHelper::renderFields($top_fields, $item);
} ?>
			<?php if ($display_title) : ?>
			<span class="jcalpro_events_link">
				<?php if ($display_location_as_icon) : ?>
				<a href="<?php echo JCalProHelperUrl::location($item->location_data->id); ?>">
					<img class="<?php echo $tipClass; ?>" title="<?php echo JCalProHelperFilter::escape($location_tooltip); ?>" src="<?php echo JCalProHelperTheme::getFilePath('icon-event-location.png', 'images/events'); ?>" />
				</a>
				<?php endif; ?>
				<a href="#" title="<?php echo JCalProHelperFilter::escape($item->title); ?>" onclick="SqueezeBox.fromElement('<?php echo JCalProHelperUrl::event($item->id, true, $urlparams); ?>', {size:{x:700,y:555}, handler:'iframe'});"><?php
                    if ($limit_title) :
                        echo JCalProHelperFilter::escape(JCalProHelperFilter::truncate($item->title, $limit_title));
                    else :
                        echo JCalProHelperFilter::escape($item->title);
                    endif;
                ?></a>
			</span>
			<?php endif; ?>
			<?php if (!empty($item->mod_events_date)) : ?>
			<span class="jcalpro_events_date">
				<?php if ($display_location_as_icon && !$display_title) : ?>
				<a href="<?php echo JCalProHelperUrl::location($item->location_data->id); ?>">
					<img class="<?php echo $tipClass; ?>" title="<?php echo JCalProHelperFilter::escape($location_tooltip); ?>" src="<?php echo JCalProHelperTheme::getFilePath('icon-event-location.png', 'images/events'); ?>" />
				</a>
				<?php endif; ?>
				<?php echo $item->mod_events_date; ?>
			</span>
			<?php endif; ?>
			<?php if ($display_location && $display_location_text && $has_location) : ?>
			<span class="jcalpro_events_location">
				<a class="<?php echo $tipClass; ?>" title="<?php echo JCalProHelperFilter::escape($location_tooltip); ?>" href="<?php echo JCalProHelperUrl::location($item->location_data->id); ?>">
					<?php echo JCalProHelperFilter::escape($item->location_data->title); ?>
				</a>
			</span>
			<?php endif; ?>
			<?php if ($display_category) : ?>
			<span class="jcalpro_events_category">
				<a href="<?php
                echo JCalProHelperUrl::category($item->categories->canonical->id, true, $urlparams);
                ?>"><?php echo JCalProHelperFilter::escape($item->categories->canonical->title); ?></a>
				<?php
                if (!empty($item->categories->categories)) :
                    foreach ($item->categories->categories as $category) :
                        ?>, <a href="<?php
                        echo JCalProHelperUrl::category($category->id, true, $urlparams);
                        ?>"><?php echo JCalProHelperFilter::escape($category->title); ?></a><?php
                    endforeach;
                endif;
                ?>
			</span>
			<?php endif; ?>
			<?php if ($display_description) : ?>
			<span class="jcalpro_events_description"><?php
                $description = $display_readmore ? $item->description_intro : $item->description;
                if ($filter_description) :
                    $description = strip_tags($description);
                endif;
                if ($limit_description) :
                    $description = JCalProHelperFilter::truncate($description, $limit_description);
                endif;
                echo $description;
                if ($display_readmore) :
                    echo $item->description_readmore;
                endif;
            ?></span>
			<?php endif; ?>
			<?php if ($bottom_fields) {
    echo modJCalProEventsHelper::renderFields($bottom_fields, $item);
} ?>
		</li>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
<?php if (JCalProHelperAccess::canAddEvents() && (int) $params->get('display_add', 1)) : ?>
	<span class="jcalpro_events_add">
		<a href="<?php echo JCalProHelperUrl::task('event.add', true, $urlparams); ?>" title="<?php echo JCalProHelperFilter::escape(JText::_('MOD_JCALPRO_EVENTS_DISPLAY_ADD_TEXT')); ?>"><?php
            echo JCalProHelperFilter::escape(JText::_('MOD_JCALPRO_EVENTS_DISPLAY_ADD_TEXT'));
        ?></a>
	</span>
<?php endif; ?>
<?php if ((int) $params->get('display_events_link', 1)) : ?>
	<span class="jcalpro_events_link">
		<a href="<?php echo JCalProHelperUrl::events('', 'month', true, $urlparams); ?>" title="<?php echo JCalProHelperFilter::escape(JText::_('MOD_JCALPRO_EVENTS_DISPLAY_EVENTS_LINK_TEXT')); ?>"><?php
            echo JCalProHelperFilter::escape(JText::_('MOD_JCALPRO_EVENTS_DISPLAY_EVENTS_LINK_TEXT'));
        ?></a>
	</span>
<?php endif; ?>
<?php if (defined('JDEBUG') && JDEBUG && (int) $params->get('debug', 0)) : JCalProHelperTheme::addStyleSheet('module_debug'); ?>
	<div class="jcalpro_module_debug">
	<?php foreach (JCalPro::debugger(null, null, 'mod_jcalpro_events') as $name => $debugger) : ?>
		<h3><?php echo $name; ?></h3>
		<?php JCalPro::debug($debugger); ?>
	<?php endforeach; ?>
	</div>
<?php endif; ?>
</div>
