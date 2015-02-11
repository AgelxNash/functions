<?php
if( ! function_exists('getMaxUploadSize')) {
	/**
     * Максимальный размер закачиваемого файла
     *
     * @return string
     */
    
	function getMaxUploadSize() {
		$max_upload = (int)(ini_get('upload_max_filesize'));
		$max_post = (int)(ini_get('post_max_size'));
		$memory_limit = (int)(ini_get('memory_limit'));
		$upload_mb = min($max_upload, $max_post, $memory_limit);
		return $upload_mb;
	}
}

if( ! function_exists('getExtension')) {
	/**
	* Расширение имени файла
	*
	* @param string $file путь к файлу
	* @return string
	*/
	function getExtension($file) {
		return pathinfo($file, PATHINFO_EXTENSION);
	}
}