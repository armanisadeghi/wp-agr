<?php
/**
 * Admin view for widget for displaying location based on zip code
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
    <label for="<?php echo $this->get_field_id( 'location_number' ); ?>">Number of location to show:</label>
    <input type="number" class="widefat"
           id="<?php echo $this->get_field_id( 'location_number' ); ?>"
           name="<?php echo $this->get_field_name( 'location_number' ); ?>"
           value="<?php echo $instance['location_number']; ?>" required>
</p>
<p><label for="<?php echo $this->get_field_id( 'type' ); ?>">Location Type</label>
    <select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>"
            id="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat">
        <option value="0" <?php echo 0 == $instance['type'] ? 'selected' : '' ?>>All</option>
		<?php
		$location_types = get_terms( [
			'taxonomy'   => 'type',
			'hide_empty' => false,
		] );
		foreach ( $location_types as $type ):?>
            <option value="<?php echo $type->term_id ?>" <?php echo $type->term_id == $instance['type'] ? 'selected' : '' ?>><?php echo $type->name; ?></option>
		<?php endforeach; ?>
    </select>
</p>