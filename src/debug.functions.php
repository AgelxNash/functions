<?php
if (! function_exists('hide_errors')) {
    /**
     * Не отображать и не логировать ошибки скриптов
     *
     * @return void
     */
    function hide_errors()
    {
        error_reporting(0);
        ini_set('display_errors', false);
    }
}

if (! function_exists('show_errors')) {
    /**
     * Показать все ошибки скриптов
     *
     * @return void
     */
    function show_errors()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
    }
}

if (! function_exists('dd')) {
    /**
     * Удалить буфер вывода, сделать дамп параметров функции и прервать выполнение скрипта
     *
     * @param  mixed
     * @return void
     */
    function dd()
    {
        ob_clean();
        array_map(function ($x) {
            var_dump($x);
        }, func_get_args());
        die;
    }
}

if (! function_exists('array_code')) {
    /**
     * Печать массива в том виде, в котором его понимает php
     *
     * @param array $arr Массив с выходными данными
     * @param int $level До какого уровня вложенности строить массив
     * @return string
     */
    function array_code($arr, $level = 1)
    {
        $php = $tabs = $breaks = '';
        if (is_array($arr)) {
            for ($n = 0; $n < $level; $n++) {
                $tabs .= "\t";
                if ($n > 0) {
                    $breaks .= "\t";
                }
            }
            $vals = [];
            foreach ($arr as $key => $val) {
                $vals[] = is_array($val) ?
                    "'" . $key . "'=>" . array_code($val, $level + 1) :
                    "'" . $key . "'=>'" . $val . "'";
            }
            $php = "array(\r" . $tabs . implode(",\r" . $tabs, $vals) . "\r" . $breaks . ")";
        }

        return $php;
    }
}

if (! function_exists('show_var')) {
    /**
     * Показать содержимое переменной
     * @param mixed $html
     * @return string
     */
    function show_var($html)
    {
        return html_wrap('pre', e(print_r($html, 1)));
    }
}
if (! function_exists('point_info')) {
    /**
     * Информация о ресурсах потребляемых на каком-то участке кода
     * @param string $key Имя метки
     * @param bool $store Необходимо ли сохранить информацию о метке в памяти
     * @param bool $clear Нужно ли выполнить сброс меток
     */
    function point_info($key, $store = false, $clear = false)
    {
        static $marks = [];
        $out = [];

        if (is_scalar($key) && ! empty($key)) {
            if ($store) {
                $marks[$key] = [
                    'time'   => microtime(true),
                    'memory' => memory_get_usage()
                ];
                $out = [
                    'memory' => format_bytes($marks[$key]['memory']),
                    'time'   => format_microtime($marks[$key]['time'])
                ];
            } else {
                $out = get_key($marks, $key, [
                    'time'   => get_key($_SERVER, 'REQUEST_TIME_FLOAT', 0),
                    'memory' => 0
                ], 'is_array');
                $out['time'] = format_microtime(microtime(true) - $out['time']);
                $out['memory'] = format_bytes(memory_get_usage() - $out['memory']);
            }
        }

        if ($clear) {
            $marks = [];
        }

        return $out;
    }
}

if (! function_exists('call_private_method')) {
    /**
     * Возможность вызвать любой метод (даже приватный)
     * call_private_method($myObject, 'myMethod', array('myValue1', 'myValue2'));
     *
     * @see http://gostash.it/ru/stashes/236
     * @param mixed $object Объект у которого требуется обратиться к методу
     * @param string $method Вызываемый метод
     * @param array $args Параметры метода
     */
    function call_private_method($object, $method, $args)
    {
        $classReflection = new \ReflectionClass(get_class($object));
        $methodReflection = $classReflection->getMethod($method);
        $methodReflection->setAccessible(true);
        $result = $methodReflection->invokeArgs($object, $args);
        $methodReflection->setAccessible(false);

        return $result;
    }
}

if (! function_exists('format_exception')) {
    /**
     * Форматировавние исключений для логирования или удобоваримого отображения
     *
     * @param Exception $exception обрабатываемое исключение
     * @param bool $trace включить ли трассировку в отчет
     * @param null|string $file Файл в котором вызвана обработка исключения
     *                          Удобнее всего передавать константу __FILE__ в качестве аргумента
     * @param null|int $line Строка в файле где вызвана обработка исключения
     *                       Удобнее всего передавать константу __LINE__ в качестве аргумента
     * @return string
     */
    function format_exception(Exception $exception, $trace = false, $file = null, $line = null)
    {
        $msg = get_class($exception);

        $code = $exception->getCode();
        if (! empty($code)) {
            $msg .= ':' . $exception->getCode();
        }
        $msg .= PHP_EOL;

        $tmp = $exception->getMessage();
        if (! empty($tmp)) {
            $msg .= $exception->getMessage();
            $msg .= PHP_EOL;
        }

        if ($trace === true) {
            $msg .= PHP_EOL;
            $msg .= $exception->getTraceAsString();
            $msg .= PHP_EOL . PHP_EOL;
        }

        if ($file !== null) {
            $msg .= $file;
            if ($line !== null) {
                $msg .= ':' . $line;
            }
            $msg .= PHP_EOL;
        }

        $msg .= $exception->getFile() . ':' . $exception->getLine();

        return $msg;
    }
}
