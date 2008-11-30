<?php
/*
 * DateFormatHelper
 * @author	Manfred Weber
 * @date	30/11/08
 * @see		http://dschini.googlecode.com/
 */
class DateFormatHelper {
	
	/*
	 * RFC822
	 */
	public static function RFC822($datetime)
	{
		$datetime = new DateTime($datetime);
		return $datetime->format('D, d M Y G:i:s');
	}
}
