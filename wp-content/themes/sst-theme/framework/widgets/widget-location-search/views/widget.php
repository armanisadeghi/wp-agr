<?php
/**
 * frontend view for widget for displaying location based on zip code
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
echo '<div class="widget-entry">'; ?>
    <form action="/locations" method="POST" data-hook="zip-search" class="zip-search">
        <div id="custom-search-input">
            <div class="input-group">
                <input name="search-zip-code" class="search-query form-control" placeholder="Enter Zip Code" required="">

                <div class="select-group">
                    Within
                    <select name="search-range" id="search-range">
                        <option value="25">25 miles</option>
                        <option value="100">100 miles</option>
                        <option value="200">200 miles</option>
                    </select>
                </div>
                <span class="input-group-btn">
                    <button class="button primary" type="submit">
                        Search
                    </button>
                </span>
            </div>
        </div>
    </form>
    <div class="zip-form-loader" style="display: none">Please wait...</div>
<?php
echo $location_lists;
echo '</div>';