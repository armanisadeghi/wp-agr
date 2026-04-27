<?php
/**
 * admin view for widget for displaying location within given miles with map
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Widget
 * @version 1.5.6
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
?>

<p>
    <label for="<?php echo $this->get_field_id( 'location_title' ); ?>">Title:</label>
    <input type="text" class="widefat"
           id="<?php echo $this->get_field_id( 'location_title' ); ?>"
           name="<?php echo $this->get_field_name( 'location_title' ); ?>"
           value="<?php echo $instance['location_title']; ?>">
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'location_range' ); ?>">Range:</label>
    <input type="number" class="widefat"
           id="<?php echo $this->get_field_id( 'location_range' ); ?>"
           name="<?php echo $this->get_field_name( 'location_range' ); ?>"
           value="<?php echo $instance['location_range']; ?>" required>
</p>
