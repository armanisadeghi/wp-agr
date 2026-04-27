#Child Theme
To create child theme, create a directory named _sst-child_

1. Create style.css inside _sst-child_ directory
2. Add following line inside style.css
```
#!text
/*
Theme Name:         SST Child Theme
Theme URI:          http://titaniummarketing.com/
Description:        SST Child Theme is a child theme created by Titanium Marketing
Version:            1.0.0
Author:             Titanium Marketing
Author URI:         http://titaniummarketing.com/
License:            Proprietary
License URI:        http://www.gnu.org/licenses/gpl-2.0.html
Text Domain:        _mok
Template:           sst-theme
*/
```
3. Create functions.php inside child theme. Add following lines of code
```
#!php
<?php
add_filter('sst_enqueue_parent_stylesheet', '__return_true');
```
4. Copy index.php from parent theme and placed it inside child theme.

#Adding composer packages
1. Browse inside framework folder using command prompt
2. If vendor folder doesn't exist, run following code in command prompt
```
#!text
composer install
```
3. If vendor folder exists, run following code on command prompt
```
#!text
composer update
```
4. To run above code, your system must able to run php in command prompt