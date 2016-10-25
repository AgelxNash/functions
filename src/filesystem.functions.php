<?php
if (!function_exists('get_max_upload_size')) {
	/**
	 * Максимальный размер закачиваемого файла
	 *
	 * @return string
	 */

	function get_max_upload_size()
	{
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
		return $upload_mb;
	}
}

if (!function_exists('get_extension')) {
	/**
	 * Расширение имени файла
	 *
	 * @param string $file путь к файлу
	 * @return string
	 */
	function get_extension($file)
	{
		return pathinfo($file, PATHINFO_EXTENSION);
	}
}

if (!function_exists('dir_list_files')) {
	/**
	 * Получить список файлов в директории
	 *
	 * @param string $path путь к папке
	 * @return array
	 */
	function dir_list_files($path)
	{
		$dir = opendir($path);
		$files = array();
		if (!empty($dir)) {
			while (false !== ($file = readdir($dir))) {
				if ($file != '.' && $file != '..') {
					$files[] = $file;
				}
			}
			closedir($dir);
		}
		return $files;
	}
}

if (!function_exists('sanitize_path')) {
	/**
	 * Удаление из строки символов, определяющих перемещение вверх по дереву каталогов
	 * @see https://github.com/modxcms/revolution/commit/10248d06ebb7c933d33129272623d0a64d528a82#diff-9ec30f895e27297f4307c80efb483bb8
	 *
	 * @param string $path путь к папке
	 * @return string
	 */
	function sanitize_path($path ){
		return preg_replace(array("/\.*[\/|\\\]/i", "/[\/|\\\]+/i"), array('/', '/'), $path);
	}
}