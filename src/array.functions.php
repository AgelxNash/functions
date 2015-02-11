<?php
if( ! function_exists('for_all')){
    /**
     * Применение callback функции к каждому элементу массива, который является строкой или просто строке
     * Всем переменным не являющимися массивом или строкой, будет присвоено значение null
     *
     * @param  mixed $data     Строка или массив с данными
     * @param  Closure $callback callback функция
     * @return mixed
     */
    function for_all($data, Closure $callback){
        switch(true){
            case is_array($data):{
                foreach($data as &$val){
                    $val = for_all($val, $callback);
                }
                break;
            }
            case is_scalar($data):{
                $data = $callback($data);
                break;
            }
            default:{
                $data = null;
            }
        }
        return $data;
    }
}

if(!function_exists('get_key')){
    /**
     * Получение значения по ключу из массива, либо возврат значения по умолчанию
     *
     * @param mixed $data массив
     * @param string $key ключ массива
     * @param mixed $default null значение по умолчанию
     * @param Closure $validate null функция дополнительной валидации значения (должна возвращать true или false)
     * @return mixed
     */
    function get_key($data, $key, $default = null, $validate = null){
        $out = $default;
        if (is_array($data) && (is_int($key) || is_string($key)) && $key !== '' && array_key_exists($key, $data)) {
            $out = $data[$key];
        }
        if(!empty($validate) && is_callable($validate)){
            $out = (($validate($out) === true) ? $out : $default);
        }
        return $out;
    }
}

if(!function_exists('rename_key_array')){
    /**
     * Переменовывание элементов массива
     *
     * @param array $data массив с данными
     * @param string $prefix префикс ключей
     * @param string $suffix суффикс ключей
     * @param string $addPS разделитель суффиксов, префиксов и ключей массива
     * @param string $sep разделитель ключей при склейке многомерных массивов
     * @return array массив с переименованными ключами
     */
    function rename_key_array($data, $prefix = '', $suffix = '', $addPS = '.', $sep = '.')
    {
        $out = array();
		if(is_array($data)) {
			if( ! is_scalar($addPS)){
				$addPS = '';
			}
			$InsertPrefix = (is_scalar($prefix) && $prefix !== '') ? ($prefix . $addPS) : '';
			$InsertSuffix = (is_scalar($suffix) && $suffix !== '') ? ($addPS . $suffix) : '';
			foreach ($data as $key => $item) {
				$key = $InsertPrefix . $key;
				$val = null;
				switch (true) {
					case is_scalar($item): {
						$val = $item;
						break;
					}
					case is_array($item): {
						$val = (is_scalar($sep) && $sep !== '') ? rename_key_array($item, $key . $sep, $InsertSuffix, '', $sep) : array();
						$out = array_merge($out, $val);
						$val = '';
						break;
					}
				}
				$out[$key . $InsertSuffix] = $val;
			}
		}
        return $out;
    }
}

if(!function_exists('make_array')){
	/**
	 * Создание многомерного массива из двухмерного, в имени которого содержится разделитель
	 *
	 * @param array $data массив с данными
	 * @param string $sep разделитель ключей при склейке многомерных массивов
	 * @return array массив с переименованными ключами
	 */
	function make_array($data, $sep = '.')
	{
		$out = array();
		if(is_array($data)) {
			if (is_scalar($sep) && $sep !== '') {
				foreach ($data as $key => $val) {
					$keys = explode($sep, $key);
					$workArray = &$out;
					foreach ($keys as $i => $subKey) {
						if (!array_key_exists($subKey, $workArray)) {
							$workArray[$subKey] = ($i + 1 == count($keys)) ? $val : array();
						}
						$workArray = &$workArray[$subKey];
					}
				}
			}else{
				$out = $data;
			}
		}
		return $out;
	}
}