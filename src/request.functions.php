<?php
if (! function_exists('request_method')) {
    /**
     * Тип запроса REQUEST_METHOD в нижнем регистре
     *
     * @return string
     */
    function request_method()
    {
        return strtolower(get_key($_SERVER, 'REQUEST_METHOD', null));
    }
}

if (! function_exists('is_post')) {
    /**
     * Запрошена ли страница методом POST
     *
     * @return bool
     */
    function is_post()
    {
        return (request_method() === 'post');
    }
}

if (! function_exists('is_get')) {
    /**
     * Запрошена ли страница методом GET
     *
     * @return bool
     */
    function is_get()
    {
        return (request_method() === 'get');
    }
}

if (! function_exists('is_ajax')) {
    /**
     * Проверяет AJAX запрос или нет
     *
     * @return bool
     */
    function is_ajax()
    {
        return (strtolower(get_key($_SERVER, 'HTTP_X_REQUESTED_WITH', null)) === 'xmlhttprequest');
    }
}

if (! function_exists('is_cli')) {
    /**
     * Проверяет запущен ли скрипт в CLI режиме
     *
     * @return bool
     */
    function is_cli()
    {
        return defined('STDIN') ||
            (empty($_SERVER['REMOTE_ADDR']) && ! isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0);
    }
}

if (! function_exists('is_https')) {
    /**
     * Проверка протокола HTTPS
     *
     * @return bool
     */
    function is_https()
    {
        $type = strtolower(get_key($_SERVER, 'HTTPS', null));

        return (! empty($type) && $type !== 'off');
    }
}

if (! function_exists('build_query')) {
    /**
     * Создание URL-кодированной строки запроса с пропуском пустых значений
     *
     * @param array $arr массив значений
     * @return string
     */
    function build_query($arr)
    {
        return http_build_query(array_clean($arr, ['', false, null]));
    }
}
