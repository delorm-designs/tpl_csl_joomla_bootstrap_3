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
<ul>
    <?php foreach($items as $item) : ?>
    <li class="<?php echo implode(' ', $item->classes); ?>">
        <?php
            switch ($item->browserNav) :
            default:
            case 0:
        ?>
        <a href="<?php echo $item->href; ?>"><?php echo $item->title; ?></a>
        <?php
                break;
            case 1:
                // _blank
        ?>
        <a href="<?php echo $item->href; ?>" target="_blank"><?php echo $item->title; ?></a>
        <?php
                break;
            case 2:
                // Use JavaScript "window.open"
                $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');
        ?>
        <a href="<?php echo $item->href; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;"><?php echo $item->title; ?></a>
        <?php
            break;
            endswitch;
        ?>
        <?php if(!empty($item->childs)) : ?>
        <?php modBootstrapAccordionMenuHelper::submenu($item->childs); ?>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
</ul>
