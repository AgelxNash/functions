<?php
if( ! function_exists('hide_errors')){
    /**
     * Не отображать и не логировать ошибки скриптов
     *
     * @return void
     */
    function hide_errors(){
        error_reporting(0);
        ini_set('display_errors', false);
    }
}

if( ! function_exists('show_errors')){
    /**
     * Показать все ошибки скриптов
     *
     * @return void
     */
    function show_errors(){
        error_reporting(E_ALL);
        ini_set('display_errors', true);
    }
}

if ( ! function_exists('dd')) {
    /**
     * Удалить буфер вывода, сделать дамп параметров функции и прервать выполнение скрипта
     *
     * @param  mixed
     * @return void
     */
    function dd() {
        ob_clean();
        array_map(function($x) {
            var_dump($x);
        }, func_get_args());
        die;
    }
}