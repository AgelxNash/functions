<?php
if (!function_exists('mb_lcfirst') && extension_loaded('mbstring')) {
	/**
	 * Преобразует первый символ в нижний регистр
	 *
	 * @param string|array $data строка или массив
	 * @param string $charset кодировка, по-умолчанию UTF-8
	 * @return mixed
	 */
	function mb_lcfirst($data, $charset = 'UTF-8')
	{
		return for_all($data, function($el) use ($charset) {
			$str = one_space($el);
			return mb_strtolower(mb_substr($str, 0, 1, $charset), $charset) . mb_substr($str, 1, mb_strlen($str), $charset);
		});
	}
}

if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
	/**
	 * Преобразует первый символ в верхний регистр
	 *
	 * @param mixed $data строка или массив
	 * @param string $charset кодировка, по-умолчанию UTF-8
	 * @return mixed
	 */
	function mb_ucfirst($data, $charset = 'UTF-8')
	{
		return for_all($data, function($el) use ($charset) {
			$str = one_space($el);
			return mb_strtoupper(mb_substr($str, 0, 1, $charset), $charset) . mb_substr($str, 1, mb_strlen($str), $charset);
		});
	}
}

if (!function_exists('one_space')) {
	/**
	 * Заменить множественную последовательность пробелов и табуляций на 1 пробел
	 *
	 * @param  mixed $data строка или массив
	 * @return mixed
	 */
	function one_space($data)
	{
		return for_all($data, function($el) {
			return preg_replace('/[ \t]+/', ' ', $el);
		});
	}
}

if (!function_exists('one_new_line')) {
	/**
	 * Заменить множественную последовательность перевода строки на 1 перевод
	 *
	 * @param  mixed $data строка или массив
	 * @return mixed
	 */
	function one_new_line($data)
	{
		return for_all($data, function($el) {
			return preg_replace('/(\R)+/', '$1', $el);
		});
	}
}

if (!function_exists('full_one_space')) {
	/**
	 * Заменить множественную последовательность пробелов, табуляций и переводов строк на 1 пробел
	 *
	 * @param  mixed $data строка или массив
	 * @return mixed
	 */
	function full_one_space($data)
	{
		return for_all($data, function($el) {
			return preg_replace('/\s+/', ' ', $el);
		});
	}
}

if (!function_exists('e_decode')) {
	/**
	 * Декодирование HTML сущностей в строке
	 *
	 * @param  mixed $data строка или массив
	 * @param  string $charset кодировка
	 * @return mixed
	 */
	function e_decode($data, $charset = 'UTF-8')
	{
		return for_all($data, function($el) use ($charset) {
			return one_space(str_replace("\xC2\xA0", ' ', html_entity_decode($el, ENT_COMPAT, $charset)));
		});
	}
}

if (!function_exists('e')) {
	/**
	 * Преобразование всех символов строки в HTML сущности
	 *
	 * @param  mixed $data
	 * @param  string $charset кодировка
	 * @return mixed
	 */
	function e($data, $charset = 'UTF-8')
	{
		return for_all($data, function($el) use ($charset) {
			return one_space(htmlentities($el, ENT_COMPAT | ENT_SUBSTITUTE, $charset, false));
		});
	}
}

if (!function_exists('camel_case')) {
	/**
	 * Преобразовывание строки в CamelCase формат
	 *
	 * @param string $str обрабатываемая строка
	 * @param bool $first Необходимо ли первый символ перевести в верхний регистр
	 * @return string
	 */
	function camel_case($str, $first = false)
	{
		return for_all($str, function($str) use($first) {
			$str = preg_replace('/[^-_\w\s]/', '', $str);
			$parts = preg_split('/[-_\s]/', $str);
			$out = strtolower(array_shift($parts));
			if ($first) {
				$out = ucfirst($out);
			}
			foreach ($parts as $word) {
				$out .= ucfirst(strtolower($word));
			}
			return $out;
		});
	}
}

if (!function_exists('underscore')) {
	/**
	 * Преобразовывание строки в underscore формат
	 *
	 * @param string $str обрабатываемая строка
	 * @return string
	 */
	function underscore($str)
	{
		return for_all($str, function($str) {
			$str = preg_replace('/[^-_\w\s]/', '', $str);
			$str = preg_replace('/([a-z])([A-Z])/', '$1 $2', $str);
			$str = preg_replace('/[-\s]/', '_', $str);
			return strtolower($str);
		});
	}
}

if (!function_exists('normalize_name')) {
	/**
	 * Нормализация имен
	 * Иванов-петров => Иванов-Петров
	 *
	 * @param string $name обрабатываемая строка
	 * @return string
	 */
	function normalize_name($name)
	{
		return for_all($name, function($name) {
			$name = ucwords(strtolower($name));
			foreach (array('-', "'") as $delimiter) {
				if (strpos($name, $delimiter) !== false) {
					$name = implode($delimiter, array_map('ucfirst', explode($delimiter, $name)));
				}
			}
			return $name;
		});
	}
}

if (!function_exists('mb_str_replace')) {
	/**
	 * Replace all occurrences of the search string with the replacement string.
	 *
	 * @author Sean Murphy <sean@iamseanmurphy.com>
	 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
	 * @license http://creativecommons.org/publicdomain/zero/1.0/
	 * @see https://gist.github.com/sgmurphy/3098836
	 * @link http://php.net/manual/function.str-replace.php
	 *
	 * @param mixed $search искомая строка
	 * @param mixed $replace строка на которую необходимо заменить искомое
	 * @param mixed $subject строка в которой производится замена
	 * @param int $count число произведенных замен в строке
	 * @return string
	 */
	function mb_str_replace($search, $replace, $subject, &$count = 0)
	{
		mb_regex_encoding('utf-8');
		if (!is_array($subject)) {
			// Normalize $search and $replace so they are both arrays of the same length
			$searches = is_array($search) ? array_values($search) : array($search);
			$replacements = is_array($replace) ? array_values($replace) : array($replace);
			$replacements = array_pad($replacements, count($searches), '');

			foreach ($searches as $key => $search) {
				$parts = mb_split(preg_quote($search), $subject);
				$count += count($parts) - 1;
				$subject = implode($replacements[$key], $parts);
			}
		}else {
			// Call mb_str_replace for each subject in array, recursively
			foreach ($subject as $key => $value) {
				$subject[$key] = mb_str_replace($search, $replace, $value, $count);
			}
		}

		return $subject;
	}
}

if (!function_exists('mb_trim_word')) {
	/**
	 * Обрезание текста по длине с поиском последнего полностью вмещающегося слова и удалением лишних крайних знаков пунктуации.
	 *
	 * @param string $html HTML текст
	 * @param integer $len максимальная длина строки
	 * @param string $encoding кодировка
	 * @return string
	 */
	function mb_trim_word($html, $len, $encoding = 'UTF-8')
	{
		$text = trim(preg_replace('|\s+|', ' ', strip_tags($html)));
		$text = mb_substr($text, 0, $len + 1, $encoding);
		if (mb_substr($text, -1, null, $encoding) == ' ') {
			$out = trim($text);
		}else {
			$out = mb_substr($text, 0, mb_strripos($text, ' ', null, $encoding), $encoding);
		}
		return preg_replace("/(([\.,\-:!?;\s])|(&\w+;))+$/ui", "", $out);
	}
}

if (!function_exists('strip_tags_smart')) {
	/**
	 * Более продвинутый аналог strip_tags() для корректного вырезания тагов из html кода.
	 * Функция strip_tags(), в зависимости от контекста, может работать не корректно.
	 * Возможности:
	 *   - корректно обрабатываются вхождения типа "a < b > c"
	 *   - корректно обрабатывается "грязный" html, когда в значениях атрибутов тагов могут встречаться символы < >
	 *   - корректно обрабатывается разбитый html
	 *   - вырезаются комментарии, скрипты, стили, PHP, Perl, ASP код, MS Word таги, CDATA
	 *   - автоматически форматируется текст, если он содержит html код
	 *   - защита от подделок типа: "<<fake>script>alert('hi')</</fake>script>"
	 *
	 * @param   string $s
	 * @param   array $allowable_tags Массив тагов, которые не будут вырезаны
	 *                                      Пример: 'b' -- таг останется с атрибутами, '<b>' -- таг останется без атрибутов
	 * @param   bool $is_format_spaces Форматировать пробелы и переносы строк?
	 *                                      Вид текста на выходе (plain) максимально приближеется виду текста в браузере на входе.
	 *                                      Другими словами, грамотно преобразует text/html в text/plain.
	 *                                      Текст форматируется только в том случае, если были вырезаны какие-либо таги.
	 * @param   array $pair_tags массив имён парных тагов, которые будут удалены вместе с содержимым
	 *                               см. значения по умолчанию
	 * @param   array $para_tags массив имён парных тагов, которые будут восприниматься как параграфы (если $is_format_spaces = true)
	 *                               см. значения по умолчанию
	 * @return  string
	 *
	 * @license  http://creativecommons.org/licenses/by-sa/3.0/
	 * @author   Nasibullin Rinat, http://orangetie.ru/
	 * @charset  ANSI
	 * @version  4.0.14
	 */
	function strip_tags_smart(
		/*string*/
		$s,
		array $allowable_tags = null,
		/*boolean*/
		$is_format_spaces = true,
		array $pair_tags = array('script', 'style', 'map', 'iframe', 'frameset', 'object', 'applet', 'comment', 'button', 'textarea', 'select'),
		array $para_tags = array('p', 'td', 'th', 'li', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'form', 'title', 'pre')
	)
	{
		//return strip_tags($s);
		static $_callback_type = false;
		static $_allowable_tags = array();
		static $_para_tags = array();
		#regular expression for tag attributes
		#correct processes dirty and broken HTML in a singlebyte or multibyte UTF-8 charset!
		static $re_attrs_fast_safe = '(?![a-zA-Z\d])  #statement, which follows after a tag
                                   #correct attributes
                                   (?>
                                       [^>"\']+
                                     | (?<=[\=\x20\r\n\t]|\xc2\xa0) "[^"]*"
                                     | (?<=[\=\x20\r\n\t]|\xc2\xa0) \'[^\']*\'
                                   )*
                                   #incorrect attributes
                                   [^>]*+';

		if (is_array($s)) {
			if ($_callback_type === 'strip_tags') {
				$tag = strtolower($s[1]);
				if (!empty($_allowable_tags)) {
					#tag with attributes
					if (array_key_exists($tag, $_allowable_tags)) {
						return $s[0];
					}

					#tag without attributes
					if (array_key_exists('<' . $tag . '>', $_allowable_tags)) {
						if (substr($s[0], 0, 2) === '</') {
							return '</' . $tag . '>';
						}
						if (substr($s[0], -2) === '/>') {
							return '<' . $tag . ' />';
						}
						return '<' . $tag . '>';
					}
				}
				if ($tag === 'br') {
					return "\r\n";
				}
				if (!empty($_para_tags) && array_key_exists($tag, $_para_tags)) {
					return "\r\n\r\n";
				}
				return '';
			}
			trigger_error('Unknown callback type "' . $_callback_type . '"!', E_USER_ERROR);
		}

		if (($pos = strpos($s, '<')) === false || strpos($s, '>', $pos) === false) {
			#speed improve
		{
			#tags are not found
			return $s;
		}
		}

		$length = strlen($s);

		#unpaired tags (opening, closing, !DOCTYPE, MS Word namespace)
		$re_tags = '~  <[/!]?+
                   (
                       [a-zA-Z][a-zA-Z\d]*+
                       (?>:[a-zA-Z][a-zA-Z\d]*+)?
                   ) #1
                   ' . $re_attrs_fast_safe . '
                   >
                ~sxSX';

		$patterns = array(
			'/<([\?\%]) .*? \\1>/sxSX', #встроенный PHP, Perl, ASP код
			'/<\!\[CDATA\[ .*? \]\]>/sxSX', #блоки CDATA
			#'/<\!\[  [\x20\r\n\t]* [a-zA-Z] .*?  \]>/sxSX',  #:DEPRECATED: MS Word таги типа <![if! vml]>...<![endif]>

			'/<\!--.*?-->/sSX', #комментарии

			#MS Word таги типа "<![if! vml]>...<![endif]>",
			#условное выполнение кода для IE типа "<!--[if expression]> HTML <![endif]-->"
			#условное выполнение кода для IE типа "<![if expression]> HTML <![endif]>"
			#см. http://www.tigir.com/comments.htm
			'/ <\! (?:--)?+
               \[
               (?> [^\]"\']+ | "[^"]*" | \'[^\']*\' )*
               \]
               (?:--)?+
           >
         /sxSX',
		);
		if (!empty($pair_tags)) {
			#парные таги вместе с содержимым:
			foreach ($pair_tags as $k => $v) {
				$pair_tags[$k] = preg_quote($v, '/');
			}
			$patterns[] = '/ <((?i:' . implode('|', $pair_tags) . '))' . $re_attrs_fast_safe . '(?<!\/)>
                         .*?
                         <\/(?i:\\1)' . $re_attrs_fast_safe . '>
                       /sxSX';
		}
		#d($patterns);

		$i = 0; #защита от зацикливания
		$max = 99;
		while ($i < $max) {
			$s2 = preg_replace($patterns, '', $s);
			if (preg_last_error() !== PREG_NO_ERROR) {
				$i = 999;
				break;
			}
			$is_html = false;

			if ($i == 0) {
				$is_html = ($s2 != $s || preg_match($re_tags, $s2));
				if (preg_last_error() !== PREG_NO_ERROR) {
					$i = 999;
					break;
				}
				if ($is_html) {
					if ($is_format_spaces) {
						/*
						В библиотеке PCRE для PHP \s - это любой пробельный символ, а именно класс символов [\x09\x0a\x0c\x0d\x20\xa0] или, по другому, [\t\n\f\r \xa0]
						Если \s используется с модификатором /u, то \s трактуется как [\x09\x0a\x0c\x0d\x20]
						Браузер не делает различия между пробельными символами, друг за другом подряд идущие символы воспринимаются как один
							$s2 = str_replace(array("\r", "\n", "\t"), ' ', $s2);
							$s2 = strtr($s2, "\x09\x0a\x0c\x0d", '    ');
						*/
						$s2 = preg_replace('/  [\x09\x0a\x0c\x0d]++
                                         | <((?i:pre|textarea))' . $re_attrs_fast_safe . '(?<!\/)>
                                           .+?
                                           <\/(?i:\\1)' . $re_attrs_fast_safe . '>
                                           \K
                                        /sxSX', ' ', $s2);
						if (preg_last_error() !== PREG_NO_ERROR) {
							$i = 999;
							break;
						}
					}

					#массив тагов, которые не будут вырезаны
					if (!empty($allowable_tags)) {
						$_allowable_tags = array_flip($allowable_tags);
					}

					#парные таги, которые будут восприниматься как параграфы
					if (!empty($para_tags)) {
						$_para_tags = array_flip($para_tags);
					}
				}
			}#if

			#tags processing
			if ($is_html) {
				$_callback_type = 'strip_tags';
				$s2 = preg_replace_callback($re_tags, __FUNCTION__, $s2);
				$_callback_type = false;
				if (preg_last_error() !== PREG_NO_ERROR) {
					$i = 999;
					break;
				}
			}

			if ($s === $s2) {
				break;
			}
			$s = $s2;
			$i++;
		}#while
		if ($i >= $max) {
			$s = strip_tags($s);
		}
		#too many cycles for replace...

		if ($is_format_spaces && strlen($s) !== $length) {
			#remove a duplicate spaces
			$s = preg_replace('/\x20\x20++/sSX', ' ', trim($s));
			#remove a spaces before and after new lines
			$s = str_replace(array("\r\n\x20", "\x20\r\n"), "\r\n", $s);
			#replace 3 and more new lines to 2 new lines
			$s = preg_replace('/[\r\n]{3,}+/sSX', "\r\n\r\n", $s);
		}
		return $s;
	}
}

if (!function_exists('last_implode')) {
	/**
	 * Склеивание всех элементов массива по разделителю. Для последнего элемента используется специфичный разделитель
	 *
	 * @param string $sep разделитель элементов массива
	 * @param array $data массив
	 * @param string $last разделитель для последнего элемента массива
	 * @return mixed|string
	 */
	function last_implode($sep, $data, $last = null)
	{
		$end = array_pop($data);
		$out = implode($sep, $data);
		if (is_nop($last)) {
			$last = $sep;
		}
		return empty($out) ? $end : $out . $last . $end;
	}
}

if (!function_exists('is_nop')) {
	/**
	 * Является ли строка пустой
	 *
	 * @param string $val проверяемая строка
	 * @return bool
	 */
	function is_nop($val)
	{
		return (is_scalar($val) && empty($val) && $val != '0');
	}
}

if (!function_exists('first_word')) {
	/**
	 * Получение первого слова из строки
	 *
	 * @param string $string
	 * @return string
	 */
	function first_word($string)
	{
		return is_scalar($string) ? current(explode(" ", $string)) : '';
	}
}