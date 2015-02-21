<?php
if (!function_exists('hide_errors')) {
	/**
	 * Не отображать и не логировать ошибки скриптов
	 *
	 * @return void
	 */
	function hide_errors()
	{
		error_reporting(0);
		ini_set('display_errors', false);
	}
}

if (!function_exists('show_errors')) {
	/**
	 * Показать все ошибки скриптов
	 *
	 * @return void
	 */
	function show_errors()
	{
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
}

if (!function_exists('dd')) {
	/**
	 * Удалить буфер вывода, сделать дамп параметров функции и прервать выполнение скрипта
	 *
	 * @param  mixed
	 * @return void
	 */
	function dd()
	{
		ob_clean();
		array_map(function ($x) {
			var_dump($x);
		}, func_get_args());
		die;
	}
}

if (!function_exists('array_code')) {
	/**
	 * Печать массива в том виде, в котором его понимает php
	 *
	 * @param array $arr Массив с выходными данными
	 * @param int $level До какого уровня вложенности строить массив
	 * @return string
	 */
	function array_code($arr, $level = 1)
	{
		$php = $tabs = $breaks = '';
		if (is_array($arr)) {
			for ($n = 0; $n < $level; $n++) {
				$tabs .= "\t";
				if ($n > 0) {
					$breaks .= "\t";
				}
			}
			$vals = array();
			foreach ($arr as $key => $val) {
				$vals[] = is_array($val) ? "'" . $key . "'=>" . array_code($val, $level + 1) : "'" . $key . "'=>'" . $val . "'";
			}
			$php = "array(\r" . $tabs . implode(",\r" . $tabs, $vals) . "\r" . $breaks . ")";
		}

		return $php;
	}
}

if (!function_exists('show_var')) {
	/**
	 * Показать содержимое переменной
	 * @param mixed $html
	 * @return string
	 */
	function show_var($html)
	{
		return html_wrap('pre', e(print_r($html, 1)));
	}
}