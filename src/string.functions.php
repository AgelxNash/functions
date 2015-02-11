<?php
if ( ! function_exists('mb_lcfirst') && extension_loaded('mbstring')) {
    /**
     * Преобразует первый символ в нижний регистр
     *
     * @param mixed $data строка или массив
     * @param string $charset кодировка, по-умолчанию UTF-8
     * @return mixed
     */
    function mb_lcfirst($data, $charset='UTF-8'){
        return for_all($data, function($el) use($charset){
            $str = one_space($el);
            return mb_strtolower(mb_substr($str, 0, 1, $charset), $charset).mb_substr($str, 1, mb_strlen($str), $charset);
        });
    }
}

if ( ! function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
    /**
     * Преобразует первый символ в верхний регистр
     *
     * @param mixed $data строка или массив
     * @param string $charset кодировка, по-умолчанию UTF-8
     * @return mixed
     */
    function mb_ucfirst($data, $charset='UTF-8') {
        return for_all($data, function($el) use($charset){
            $str = one_space($el);
            return mb_strtoupper(mb_substr($str, 0, 1, $charset), $charset). mb_substr($str, 1, mb_strlen($str), $charset);
        });
    }
}

if( ! function_exists('one_space')) {
    /**
     * Заменить множественную последовательность пробелов и табуляций на 1 пробел
     *
     * @param  mixed $data строка или массив
     * @return mixed
     */
    function one_space($data){
        return for_all($data, function($el){
           return preg_replace('/[ \t]+/', ' ', $el);
        });
    }
}

if( ! function_exists('one_new_line')) {
	/**
	 * Заменить множественную последовательность перевода строки на 1 перевод
	 *
	 * @param  mixed $data строка или массив
	 * @return mixed
	 */
	function one_new_line($data){
		return for_all($data, function($el){
			return preg_replace('/(\R)+/', '$1', $el);
		});
	}
}
if( ! function_exists('full_one_space')) {
	/**
	 * Заменить множественную последовательность пробелов, табуляций и переводов строк на 1 пробел
	 *
	 * @param  mixed $data строка или массив
	 * @return mixed
	 */
	function full_one_space($data){
		return for_all($data, function($el){
			return preg_replace('/\s+/', ' ', $el);
		});
	}
}
if( ! function_exists('e_decode')){
    /**
     * Декодирование HTML сущностей в строке
     *
     * @param  mixed $data    строка или массив
     * @param  string $charset кодировка
     * @return mixed
     */
    function e_decode($data, $charset = 'UTF-8'){
        return for_all($data, function($el) use($charset){
            return one_space(str_replace("\xC2\xA0", ' ', html_entity_decode($el, ENT_COMPAT, $charset)));
        });
    }
}

if ( ! function_exists('e')) {
    /**
     * Преобразование всех символов строки в HTML сущности
     *
     * @param  mixed $data
     * @return mixed
     */
    function e($data, $charset = 'UTF-8') {
        return for_all($data, function($el) use($charset){
            return one_space(htmlentities($el, ENT_COMPAT, $charset, false));
        });
    }
}

if ( ! function_exists('escape_modx')) {
    /**
     * Преобразование MODX тегов в сущности
     *
     * @param  mixed $data    строка или массив
     * @param  string $charset кодировка
     * @return mixed
     */
    function escape_modx($data, $charset = 'UTF-8')
    {
        return for_all($data, function($el) use($charset){
            return str_replace(
                array('[', '%5B', ']', '%5D', '{', '%7B', '}', '%7D', '`', '%60'),
                array('&#91;', '&#91;', '&#93;', '&#93;', '&#123;', '&#123;', '&#125;', '&#125;', '&#96;', '&#96;'),
                e($el, $charset)
            );
        });
    }
}