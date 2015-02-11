<?php
if ( ! function_exists('value')) {
    /**
     * Если аргумент это замыкание, то вычисляется его значение и отдается в виде результата
     * В противном случае возвращается сам аргумент
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value) {
        return $value instanceof Closure ? $value() : $value;
    }
}

if ( ! function_exists('with')) {
    /**
     * Синтаксический сахар реализующий возможности PHP 5.4 "получение доступа к члену класса при создании экземпляра"
     *     PHP >= 5.4: (new test())->run();
     *     PHP <= 5.3: with(new test())->run();
     *
     * @param  mixed  $object объект
     * @return mixed
     */
    function with($object) {
        return $object;
    }
}

if( ! function_exists('isSerialized')) {
    /**
     * Проверка переменной на предмет наличия в ней сериализованных данных
     *
     * @param  mixed $data данные которые необходимо проверить
     * @return bool
     */
    function isSerialized($data)
    {
        if (! is_string($data)) {
            return false;
        }
        $data = trim($data);
        if ('N;' == $data) {
            return true;
        }
        $length = strlen($data);
        if ($length < 4) {
            return false;
        }
        if (':' !== $data[1]) {
            return false;
        }
        $lastc = $data[$length - 1];
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
        $token = $data[0];
        switch ($token) {
            case 's':
            if ('"' !== $data[$length-2]) {
                return false;
            }
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                return (bool) preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }
        return false;
    }
}