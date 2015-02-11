<?php
if(!function_exists('check_email')) {
    /**
     * Проверка строки с email на наличие ошибок
     * Если e-mail валидный, то в ответ будет получено false
     * В противном случае имя ошибки
     *     dns - ошибка проверки MX и A записи почтового домена
     *     format - ошибка формата email
     *
     * @param string $email проверяемый email
     * @param bool $dns проверять ли DNS записи
     * @return bool|string Результат проверки почтового ящика
     */
    function check_email($email, $dns = true)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            list($user, $domain) = explode("@", $email, 2);
            if (!$dns || ($dns && checkdnsrr($domain, "MX") && checkdnsrr($domain, "A"))) {
                $error = false;
            } else {
                $error = 'dns';
            }
        } else {
            $error = 'format';
        }
        return $error;
    }
}

if(!function_exists('generate_password')) {
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
                {
                    $tmp = rand(65, 90);
                    break;
                }
                case 'a':
                {
                    $tmp = rand(97, 122);
                    break;
                }
                case '0':
                {
                    $tmp = rand(48, 57);
                    break;
                }
                default:
                    {
                    $tmp = rand(33, 126);
                    }
            }
            $pass[] = chr($tmp);
        }
        $pass = implode("", $pass);
        return $pass;
    }
}

if( ! function_exists('get_gravatar')) {
    /**
     * Получение ссылки на аватарку с gravatar
     *
     * @param   string  $email Почта
     * @param   integer $size  Размер аватарки
     * @return  string
     */
   function get_gravatar($email, $size = 32) {
        $url = '//www.gravatar.com/avatar/' . md5( is_scalar($email) ? $email : '' ) . '?s=' . (int) abs($size);
        return $url;
    }
}

if( ! function_exists('share_vk')) {
    /**
     * Получение ссылки поделиться для "Вконтакте"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_vk($url, $title = '') {
        return 'http://vkontakte.ru/share.php?url='.urlencode($url).'&title='.urlencode($title);
    }
}

if( ! function_exists('share_ok')) {
    /**
     * Получение ссылки поделиться для "Одноклассников"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_ok($url, $title = '') {
        return 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st._surl='.urlencode($url).'&st.comments='.urlencode($title);
    }
}

if( ! function_exists('share_google')) {
    /**
     * Получение ссылки поделиться для "Google+"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_google($url) {
        return 'https://plus.google.com/share?url='.urlencode($url);
    }
}

if( ! function_exists('share_facebook')) {
    /**
     * Получение ссылки поделиться для "Facebook"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_facebook($url, $title ='') {
        return 'http://www.facebook.com/sharer/sharer.php?s=100&p[url]='.urlencode($url).'&p[title]='.urlencode($title);
    }
}

if( ! function_exists('share_twitter')) {
    /**
     * Получение ссылки поделиться для "Twitter"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_twitter($url, $title = '') {
        return 'https://twitter.com/intent/tweet?url='.urlencode($url).'&text='.urlencode($title);
    }
}

if( ! function_exists('share_mail')) {
    /**
     * Получение ссылки поделиться для "Mail.ru"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_mail($url, $title = '') {
        return 'http://connect.mail.ru/share?share_url='.urlencode($url).'&title='.urlencode($title);
    }
}

if( ! function_exists('share_linkedin')) {
    /**
     * Получение ссылки поделиться для "LinkedIN"
     *
     * @param  string $url   Страница которой следует поделиться
     * @param  string $title Заголовок
     * @return string
     */
    function share_linkedin($url, $title = '') {
        return 'http://www.linkedin.com/shareArticle?mini=true&url='.urlencode($url).'&title='.urlencode($title);
    }
}