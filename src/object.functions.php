<?php
if (! function_exists('value')) {
    /**
     * Если аргумент это замыкание, то вычисляется его значение и отдается в виде результата
     * В противном случае возвращается сам аргумент
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('is_serialized')) {
    /**
     * Проверка переменной на предмет наличия в ней сериализованных данных
     *
     * @param  mixed $data данные которые необходимо проверить
     * @return bool
     */
    function is_serialized($data)
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
                return ('"' === $data[$length - 2]);
            case 'a':
            case 'O':
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                return (bool)preg_match("/^{$token}:[0-9.E-]+;\$/", $data);
        }

        return false;
    }
}

if (! function_exists('var_switch')) {
    /**
     * Поменять местами значения двух переменных
     *
     * @param $var1
     * @param $var2
     * @return void
     */
    function var_switch(&$var1, &$var2)
    {
        list($var2, $var1) = [$var1, $var2];
    }
}

if (! function_exists('arity')) {
    /**
     * Сколько параметров принимает данное замыкание
     *
     * @param Closure $callback
     * @return int
     */
    function arity(Closure $callback)
    {
        $r = new ReflectionObject($callback);
        $m = $r->getMethod('__invoke');

        return $m->getNumberOfParameters();
    }
}
