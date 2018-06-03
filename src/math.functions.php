<?php
if (! function_exists('is_even')) {
    /**
     * Четное ли число хранится внутри переменной
     *
     * @param int $n проверяемая ли переменная
     * @return bool
     */
    function is_even($n)
    {
        return (is_numeric($n) && ($n % 2 == 0));
    }
}

if (! function_exists('plus_minus')) {
    /**
     * Подстановка +/- перед значением переменной
     *
     * @param mixed $num обрабатываемая переменная
     * @param string $plus префикс положительного значения
     * @param string $minus префикс отрицательного значения
     * @return string
     */
    function plus_minus($num, $plus = '+', $minus = '-')
    {
        if (! is_scalar($num)) {
            $num = 0;
        }
        if ($num < 0) {
            $out = $minus . abs($num);
        } elseif ($num > 0) {
            $out = $plus . abs($num);
        } else {
            $out = 0;
        }

        return $out;
    }
}

if (! function_exists('strip_non_numeric')) {
    /**
     * Удаление из переменной всех не числовых символов
     *
     * @param mixed $string обрабатываемая переменная
     * @return null|int
     */
    function strip_non_numeric($string)
    {
        return is_scalar($string) ? (int)preg_replace('/[^0-9]+/', '', $string) : null;
    }
}

if (! function_exists('clean_ids')) {
    /**
     * Удаление из массива значений меньше нуля, а так же значений из массива запрещенных значений
     *
     * @param mixed $IDs обрабатываемые значения
     * @param string $sep если $IDs является строкой, то $sep выступает в роли разделителя значений
     * @param array $ignore массив запрещенных значений
     * @return array
     */
    function clean_ids($IDs, $sep = ',', $ignore = [])
    {
        $out = [];
        if (! is_array($IDs)) {
            $IDs = is_scalar($IDs) ? explode($sep, $IDs) : [];
        }
        foreach ($IDs as $item) {
            $item = trim($item);
            if ((is_scalar($item) && (int)$item >= 0) && (empty($ignore) || ! in_array((int)$item, $ignore, true))) {
                $out[] = (int)$item;
            }
        }
        $out = array_unique($out);

        return $out;
    }
}

if (! function_exists('is_number')) {
    /**
     * Является ли переменная истинным числом
     *
     * @param mixed $var проверяемая переменная
     * @return bool
     */
    function is_number($var)
    {
        return (is_numeric($var) && ! is_string($var));
    }
}
