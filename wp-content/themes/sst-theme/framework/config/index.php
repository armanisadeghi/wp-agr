<?php
/**
 * Loads configuration of post type, post meta, term meta and theme options
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */


\Carbon_Fields\Carbon_Fields::boot();

require 'post-type.php';
require 'post-meta.php';
require 'term-meta.php';
require 'sst-option.php';
require 'c-post-meta.php';
require 'c-widget-options.php';