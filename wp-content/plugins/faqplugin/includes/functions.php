<?php
	function setFlashData($key, $value)
	{
		$_SESSION['flash_data'][$key] = $value;
		return true;
	}
	
	function getFlashData($key)
	{
		$message = (ISSET($_SESSION['flash_data'][$key])) ? $_SESSION['flash_data'][$key] : '';
		unset($_SESSION['flash_data'][$key]);
		return $message;
	}
	
	function getCategoryTableName()
	{
		global $wpdb;
		return $wpdb->prefix.'faq_category';
	}
	
	function getFaqTableName()
	{
		global $wpdb;
		return $wpdb->prefix.'faq';
	}
	
	function getPluginName()
	{
		return 'faqplugin';
	}
?>