<?php
if ( ! function_exists('request_method')){
    /**
     * Тип запроса REQUEST_METHOD в нижнем регистре
     *
     * @return string
     */
    function request_method(){
        return strtolower(get_key($_SERVER, 'REQUEST_METHOD', null));
    }
}

if ( ! function_exists('isPost')){
    /**
     * Запрошена ли страница методом POST
     *
     * @return bool
     */
    function isPost(){
        return (request_method() === 'post');
    }
}

if (!function_exists('isGet')){
    /**
     * Запрошена ли страница методом GET
     *
     * @return bool
     */
    function isGet(){
        return (request_method() === 'get');
    }
}

if ( ! function_exists('isAjax')) {
    /**
     * Проверяет AJAX запрос или нет
     *
     * @return bool
     */
    function isAjax() {
        return (strtolower(get_key($_SERVER, 'HTTP_X_REQUESTED_WITH', null)) === 'xmlhttprequest');
    }
}

if( !function_exists('isCli')){
    /**
     * Проверяет запущен ли скрипт в CLI режиме
     *
     * @return bool
     */
    function isCli(){
        return defined('STDIN') || ( empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0);
    }
}

if( ! function_exists('isHttps')) {
    /**
     * Проверка протокола HTTPS
     *
     * @return bool
     */
    function isHttps() {
        $type = strtolower(get_key($_SERVER, 'HTTPS', null));
        return (! empty($type)  && $type != 'off');
    }
}