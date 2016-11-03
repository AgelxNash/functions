<?php
if (!function_exists('check_email')) {
	/**
	 * Проверка строки с email на наличие ошибок
	 * Если e-mail валидный, то в ответ будет получено false
	 * В противном случае имя ошибки
	 *     dns - ошибка проверки MX и A записи почтового домена
	 *     format - ошибка формата email
	 *
	 * @param string $email проверяемый email
	 * @param bool $dns проверять ли DNS записи
	 * @return false|string Результат проверки почтового ящика
	 */
	function check_email($email, $dns = true)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			list(, $domain) = explode("@", $email, 2);
			if (!$dns || ($dns && checkdnsrr($domain, "MX") && checkdnsrr($domain, "A"))) {
				$error = false;
			}else {
				$error = 'dns';
			}
		}else {
			$error = 'format';
		}
		return $error;
	}
}

if (!function_exists('generate_password')) {
	/**
	 * Генерация пароля
	 *
	 * @param string $len длина пароля
	 * @param string $data правила генерации пароля
	 * @return string Строка с паролем
	 *
	 * Расшифровка значений $data
	 *     "A": A-Z буквы
	 *     "a": a-z буквы
	 *     "0": цифры
	 *     ".": все печатные символы
	 *
	 * @example
	 *     generate_password(10,"Aa"); //nwlTVzFdIt
	 *     generate_password(8,"0"); //71813728
	 *     generate_password(11,"A"); //VOLRTMEFAEV
	 *     generate_password(5,"a0"); //4hqi7
	 *     generate_password(5,"."); //2_Vt}
	 *     generate_password(20,"."); //AMV,>&?J)v55,(^g}Z06
	 *     generate_password(20,"aaa0aaa.A"); //rtvKja5xb0\KpdiRR1if
	 */
	function generate_password($len, $data = '')
	{
		if ($data == '') {
			$data = 'Aa0.';
		}
		$opt = strlen($data);
		$pass = array();
		for ($i = $len; $i > 0; $i--) {
			switch ($data[rand(0, ($opt - 1))]) {
				case 'A': 
					$tmp = rand(65, 90);
					break;
				case 'a':
					$tmp = rand(97, 122);
					break;
				case '0':
					$tmp = rand(48, 57);
					break;
				default:
					$tmp = rand(33, 126);
			}
			$pass[] = chr($tmp);
		}
		$pass = implode("", $pass);
		return $pass;
	}
}

if (!function_exists('get_gravatar')) {
	/**
	 * Получение ссылки на аватарку с gravatar
	 *
	 * @param   string $email Почта
	 * @param   integer $size Размер аватарки
	 * @return  string
	 */
	function get_gravatar($email, $size = 32)
	{
		$url = '//www.gravatar.com/avatar/' . md5(is_scalar($email) ? $email : '') . '?s=' . (int)abs($size);
		return $url;
	}
}

if (!function_exists('share_vk')) {
	/**
	 * Получение ссылки поделиться для "Вконтакте"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_vk($url, $title = '')
	{
		return 'http://vkontakte.ru/share.php?url=' . urlencode($url) . '&title=' . urlencode($title);
	}
}

if (!function_exists('share_ok')) {
	/**
	 * Получение ссылки поделиться для "Одноклассников"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_ok($url, $title = '')
	{
		return 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl=' . urlencode($url) . '&st.comments=' . urlencode($title);
	}
}

if (!function_exists('share_google')) {
	/**
	 * Получение ссылки поделиться для "Google+"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @return string
	 */
	function share_google($url)
	{
		return 'https://plus.google.com/share?url=' . urlencode($url);
	}
}

if (!function_exists('share_facebook')) {
	/**
	 * Получение ссылки поделиться для "Facebook"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_facebook($url, $title = '')
	{
		return 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]=' . urlencode($url) . '&p[title]=' . urlencode($title);
	}
}

if (!function_exists('share_twitter')) {
	/**
	 * Получение ссылки поделиться для "Twitter"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_twitter($url, $title = '')
	{
		return 'https://twitter.com/intent/tweet?url=' . urlencode($url) . '&text=' . urlencode($title);
	}
}

if (!function_exists('share_mail')) {
	/**
	 * Получение ссылки поделиться для "Mail.ru"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_mail($url, $title = '')
	{
		return 'http://connect.mail.ru/share?share_url=' . urlencode($url) . '&title=' . urlencode($title);
	}
}

if (!function_exists('share_linkedin')) {
	/**
	 * Получение ссылки поделиться для "LinkedIN"
	 *
	 * @param  string $url Страница которой следует поделиться
	 * @param  string $title Заголовок
	 * @return string
	 */
	function share_linkedin($url, $title = '')
	{
		return 'http://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($url) . '&title=' . urlencode($title);
	}
}

if (!function_exists('qr_code')) {
	/**
	 * Генерация QR-кода для строки
	 *
	 * @param string $str строка
	 * @param int $size размер картинки
	 * @return string
	 */
	function qr_code($str, $size = 230)
	{
		$size = (int)$size;
		$size = implode("x", array($size, $size));
		return '//chart.apis.google.com/chart?cht=qr&chs=' . $size . '&chl=' . (is_scalar($str) ? urlencode($str) : '');
	}
}

if (!function_exists('get_user_ip')) {
	/**
	 * Получение реального ip текущего пользователя
	 *
	 * @param string $out IP адрес который будет отдан функцией, если больше ничего не обнаружено
	 * @return string IP пользователя
	 *
	 * @see http://stackoverflow.com/questions/5036443/php-how-to-block-proxies-from-my-site
	 */
	function get_user_ip($out = '127.0.0.1')
	{
		$_getEnv = function($data) {
			switch (true) {
				case (isset($_SERVER[$data])):
					$out = $_SERVER[$data];
					break;
				case (isset($_ENV[$data])):
					$out = $_ENV[$data];
					break;
				case ($tmp = getenv($data)):
					$out = $tmp;
					break;
				case (function_exists('apache_getenv') && $tmp = apache_getenv($data, true)):
					$out = $tmp;
					break;
				default:
					$out = false;
			}
			unset($tmp);
			return $out;
		};

		//Порядок условий зависит от приоритетов
		switch (true === true) {
			case ($tmp = $_getEnv('HTTP_COMING_FROM')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_X_COMING_FROM')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_VIA')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_FORWARDED')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_FORWARDED_FOR')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_X_FORWARDED')):
				$out = $tmp;
				break;
			case ($tmp = $_getEnv('HTTP_X_FORWARDED_FOR')):
				$out = $tmp;
				break;
			case (!empty($_SERVER['REMOTE_ADDR'])):
				$out = $_SERVER['REMOTE_ADDR'];
				break;
		}
		unset($tmp);
		return (is_scalar($out) && preg_match('|^(?:[0-9]{1,3}\.){3,3}[0-9]{1,3}$|', $out, $matches)) ? $out : false;
	}
}

if (!function_exists('whois_query')) {
	/**
	 * Получение whois информации о домене
	 * @see http://www.jonasjohn.de/snippets/php/whois-query.htm
	 *
	 * @param string $domain домен
	 * @return string
	 */
	function whois_query($domain)
	{

		// fix the domain name:
		$domain = strtolower(trim($domain));
		$domain = preg_replace('/^http:\/\//i', '', $domain);
		$domain = preg_replace('/^www\./i', '', $domain);
		$domain = explode('/', $domain);
		$domain = trim($domain[0]);

		// split the TLD from domain name
		$_domain = explode('.', $domain);
		$lst = count($_domain) - 1;
		$ext = $_domain[$lst];

		// You find resources and lists
		// like these on wikipedia:
		//
		// <a href="http://de.wikipedia.org/wiki/Whois">http://de.wikipedia.org/wiki/Whois</a>
		//
		$servers = array(
			"biz" => "whois.neulevel.biz",
			"com" => "whois.internic.net",
			"us" => "whois.nic.us",
			"coop" => "whois.nic.coop",
			"info" => "whois.nic.info",
			"name" => "whois.nic.name",
			"net" => "whois.internic.net",
			"gov" => "whois.nic.gov",
			"edu" => "whois.internic.net",
			"mil" => "rs.internic.net",
			"int" => "whois.iana.org",
			"ac" => "whois.nic.ac",
			"ae" => "whois.uaenic.ae",
			"at" => "whois.ripe.net",
			"au" => "whois.aunic.net",
			"be" => "whois.dns.be",
			"bg" => "whois.ripe.net",
			"br" => "whois.registro.br",
			"bz" => "whois.belizenic.bz",
			"ca" => "whois.cira.ca",
			"cc" => "whois.nic.cc",
			"ch" => "whois.nic.ch",
			"cl" => "whois.nic.cl",
			"cn" => "whois.cnnic.net.cn",
			"cz" => "whois.nic.cz",
			"de" => "whois.nic.de",
			"fr" => "whois.nic.fr",
			"hu" => "whois.nic.hu",
			"ie" => "whois.domainregistry.ie",
			"il" => "whois.isoc.org.il",
			"in" => "whois.ncst.ernet.in",
			"ir" => "whois.nic.ir",
			"mc" => "whois.ripe.net",
			"to" => "whois.tonic.to",
			"tv" => "whois.tv",
			"ru" => "whois.ripn.net",
			"org" => "whois.pir.org",
			"aero" => "whois.information.aero",
			"nl" => "whois.domain-registry.nl"
		);

		if (!isset($servers[$ext])) {
			throw new ErrorException('No matching nic server found!');
		}

		$nic_server = $servers[$ext];

		$output = '';

		// connect to whois server:
		if ($conn = fsockopen($nic_server, 43)) {
			fputs($conn, $domain . "\r\n");
			while (!feof($conn)) {
				$output .= fgets($conn, 128);
			}
			fclose($conn);
		}else {
			throw new ErrorException('Could not connect to ' . $nic_server . '!');
		}

		return $output;
	}
}

if (!function_exists('copyright')) {
	/**
	 * Геренатор года для подстановки в копирайты
	 *
	 * @param string $year год запуска проекта
	 * @param string $sep разделитель годов
	 * @return string
	 */
	function copyright($year, $sep = ' - ')
	{
		$y = date('Y');
		return ($y != $year) ? ($year . $sep . $y) : $year;
	}
}

if (!function_exists('mime_file')) {
	/**
	 * Получение MIME типа файла
	 *
	 * @param string $fname путь к файлу
	 * @return string
	 */
	function mime_file($fname)
	{
		$out = null;
		switch (true) {
			case class_exists('\finfo'):
				$fi = new \finfo(FILEINFO_MIME);
				$out = $fi->file($fname);
				break;
			case function_exists('mime_content_type'):
				list($out) = explode(';', @mime_content_type($fname));
				break;
			default:
				/**
				 * @see: http://www.php.net/manual/ru/function.finfo-open.php#112617
				 */
				$fh = fopen($fname, 'rb');
				if ($fh) {
					$bytes6 = fread($fh, 6);
					fclose($fh);
					switch (true) {
						case ($bytes6 === false):
							break;
						case (substr($bytes6, 0, 3) == "\xff\xd8\xff"):
							$out = 'image/jpeg';
							break;
						case ($bytes6 == "\x89PNG\x0d\x0a"):
							$out = 'image/png';
							break;
						case ($bytes6 == "GIF87a" || $bytes6 == "GIF89a"):
							$out = 'image/gif';
							break;
						default:
							$out = 'application/octet-stream';
					}
				}
		}
		return $out;
	}
}

if (!function_exists('image_size')) {
	/**
	 * Определение размеров картинки
	 *
	 * @param string $image путь к картинке
	 * @param string|null $mode какой размер ширину/высоту или все вместе
	 * @return array|int
	 */
	function image_size($image, $mode = null)
	{
		$width = $height = 0;
		if (is_scalar($image) && is_file($image)) {
			$size = @getimagesize($image);
			$width = isset($size[0]) ? $size[0] : 0;
			$height = isset($size[1]) ? $size[1] : 0;
		}
		switch ($mode) {
			case 'w':
			case 'width':
				$out = $width;
				break;
			case 'h':
			case 'height':
				$out = $height;
				break;
			default:
				$out = array($width, $height);
		}
		return $out;
	}
}

if (!function_exists('plural')) {
	/**
	 * Определение падежа слова в зависимости от числового значения
	 *
	 * @param int|string $number число
	 * @param array $titles массив слов в разных склонениях (1 яблоко, 2 яблока, 5 яблок)
	 * @return string
	 */
	function plural($number, array $titles = array())
	{
		$cases = array(2, 0, 1, 1, 1, 2);
		$number = (int)$number;
		$position = ($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[($number % 10 < 5) ? $number % 10 : 5];
		$out = isset($titles[$position]) ? $titles[$position] : '';
		return $out;
	}
}

if (!function_exists('validate_date')) {
	/**
	 * Проверка валидности даты
	 *
	 * Пример валидации даты через дополнительную проверку $validator
	 * function($date, $iterval){
	 * 		return ($iterval->format('%R') == '+');
	 * }
	 * Таким образом все даты которые уже прошли будут помечены как не валидные
	 *
	 * @param string $date проверяемая дата
	 * @param string $fromFormat в каком формате записана исходная дата
	 * @param string $toFormat в каком формате вернуть дату, если она валидна
	 * @param Closure $validator метод для дополнительной проверки даты
	 * @return null|string
	 */
	function validate_date($date, $fromFormat = 'Y-m-d', $toFormat = 'Y-m-d', Closure $validator = null) {
		$validTime = false;
		$datetime2 = null;
		if (is_scalar($date)) {
			$datetime1 = new \DateTime("NOW");
			$datetime2 = \DateTime::createFromFormat($fromFormat, $date);
			if ($datetime2 instanceof \DateTime) {
				$interval = $datetime1->diff($datetime2);
				$validTime = is_callable($validator) ? (bool)$validator($datetime2, $interval) : true;
			}
		}
		return $validTime ? $datetime2->format($toFormat) : null;
	}
}
if (!function_exists('format_bytes')) {
	/**
	 * Преобразование из байт в другие порядки (кило, мега, гига) с добавлением префикса
	 *
	 * @param string $bytes Обрабатываемое число
	 * @param integer $precision До какого числа после запятой округлять
	 * @param array $suffixes Массив суффиксов
	 * @return string
	 */
	function format_bytes($bytes, $precision = 2, $suffixes = array('Байт', 'Кбайт', 'Мбайт', 'Гбайт', 'Тбайт')) {
		$bytes = (float)$bytes;
		if(empty($bytes)) {
			return 0;
		}
		$base = log($bytes, 1024);
		return trim(round(pow(1024, $base - floor($base)), $precision) . ' ' .get_key($suffixes, (int)$base, '', 'is_scalar'));
	}
}

if(!function_exists('format_microtime')){
	/**
	 * Форматирование microtime времени
	 * @param string $time microtime время 
	 * @param int $len Кол-во символов после точки
	 */
	function format_microtime($time, $len = 4){
		return sprintf("%.".(int)$len."f", $time);
	}
}
if(!function_exists('ip_in_range')){
	/**
	 * Входит ли указанный IP в заданный диапазон
	 *
	 * @param string $ip IP клиента
	 * @param string $lower Начальный IP диапазона
	 * @param string $upper Конечный IP диапазона
	 * @return bool
	 */
	function in_ip_range($ip, $lower, $upper){
		return (ip2long($lower) <= ip2long($ip) && ip2long($upper) >= ip2long($ip)) ? TRUE : FALSE;
	}
}

if(!function_exists('make_csv')){
	/**
	 * Формирование правильной CSV строки
	 *
     * @see: https://stackoverflow.com/questions/3933668/convert-array-into-csv
	 * @param array $data Массив с данными
	 * @return string
     */
    function make_csv($data){
        // Create a stream opening it with read / write mode
        $stream = fopen('data://text/plain,' . "", 'w+');

        // Iterate over the data, writting each line to the text stream
        fputcsv($stream, $data);

        // Rewind the stream
        rewind($stream);

        // You can now echo it's content
        $out = stream_get_contents($stream);

        // Close the stream
        fclose($stream);
        return $out;
    }
}