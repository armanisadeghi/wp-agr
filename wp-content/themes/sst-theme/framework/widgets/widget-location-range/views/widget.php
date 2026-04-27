<?php
/**
 * frontend view for widget for displaying location within given miles with map
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Widget
 * @version 1.5.6
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
?>
<?php
$title = $instance['location_title'] != '' ? $instance['location_title'] : 'Location within 10 miles';
echo $args['before_title'] . $title . $args['after_title'];
echo '<div class="widget-entry">';
echo $location_lists;
echo '</div>';