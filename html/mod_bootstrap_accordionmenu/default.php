<?php
/**
 * Joomla! module - Bootstrap Accordion Menu
 *
 * @author Yireo (info@yireo.com)
 * @copyright Copyright 2012 Yireo.com. All rights reserved
 * @license GNU Public License
 * @link http://www.yireo.com
 */

// Deny direct access
defined('_JEXEC') or die;
?>
<?php if($params->get('load_js', 1) == 1) : ?>
<script type="text/javascript">
if (typeof modBootstrapAccordionMenu_hover === "undefined") {
  var modBootstrapAccordionMenu_hover = <?php echo (int)$params->get('js_hover', 0); ?>;
}
</script>
<?php endif; ?>
<div class="accordion" id="<?php echo $tag_id; ?>">
    <ul class="accordion-group">
        <?php foreach($parents as $parent) : ?>
        <li>
        <?php $collapse_status = ($parent->active) ? 'in' : 'out'; ?>
        <div class="accordion-heading">
            <?php if(!empty($parent->childs)) : ?>
            <a class="accordion-toggle accordion-parent <?php echo implode(' ', $parent->classes); ?>" data-toggle="collapse" data-parent="#<?php echo $tag_id; ?>" data-href="<?php echo $parent->href; ?>" href="#<?php echo $parent->html_id; ?>"><?php echo $parent->title; ?></a>
            <?php else: ?>
            <?php
            switch ($parent->browserNav) :
            default:
            case 0:
            ?>
            <a class="accordion-toggle <?php echo implode(' ', $parent->classes); ?>" href="<?php echo $parent->href; ?>"><?php echo $parent->title; ?></a>

                <?php
                break;
            case 1:
            // _blank
            ?>
            <a class="accordion-toggle <?php echo implode(' ', $parent->classes); ?>" href="<?php echo $parent->href; ?>" target="_blank"><?php echo $parent->title; ?></a>
                <?php
                break;
            case 2:
            // Use JavaScript "window.open"
            $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');
            ?>
            <a class="accordion-toggle <?php echo implode(' ', $parent->classes); ?>" href="<?php echo $parent->href; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;"><?php echo $parent->title; ?></a>
                <?php
                break;
            endswitch;
                ?>
            <?php endif; ?>
        </div>
        <?php if(!empty($parent->childs)) : ?>
        <div id="<?php echo $parent->html_id; ?>" class="accordion-body collapse <?php echo $collapse_status; ?>">
            <div class="accordion-inner">
                <?php modBootstrapAccordionMenuHelper::submenu($parent->childs); ?>
            </div>
        </div>
        <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
</div>
