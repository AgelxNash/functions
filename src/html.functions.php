<?php
if (! function_exists('html_implode')) {
    /**
     * Каждый элемент массива обернуть в html тег
     *
     * @param array $arr
     * @param string $el тег
     * @return string
     */
    function html_implode(array $arr, $el)
    {
        return "<$el>" . implode("</$el><$el>", $arr) . "</$el>";
    }
}

if (! function_exists('html_table')) {
    /**
     * Создать таблицу из массива
     *
     * @param array $rows массив строк таблицы (с тегами td)
     * @param array|string $table шапка таблицы
     * @param array $attr аттрибуты которые необходимо добавить к основному тегу table
     * @return string
     */
    function html_table($rows, $table = '', array $attr = [])
    {
        if (isset($table['head'])) {
            $thead = $table['head'];
        } elseif (is_array($table)) {
            $thead = html_implode($table, 'th');
        } else {
            $thead = $table;
        }
        if (! empty($thead)) {
            $thead = html_wrap('thead', html_wrap('tr', $thead));
        }

        return html_wrap(
            'table',
            $thead . html_wrap('tbody', (is_array($rows) ? html_implode($rows, 'tr') : $rows)),
            $attr
        );
    }
}

if (! function_exists('html_wrap')) {
    /**
     * Обернуть некий текст в html тег
     *
     * @param string $tag имя тега
     * @param string $content содержимое тега
     * @param array $attr аттрибуты которые необходимод обавить к тегу $tag
     * @return string
     */
    function html_wrap($tag, $content, $attr = [])
    {
        $attribs = html_attrs($attr);

        return "<{$tag}{$attribs}>{$content}</{$tag}>";
    }
}

if (! function_exists('empty_tag')) {
    /**
     * Создать пустой html тег
     *
     * @param string $tag имя тега
     * @param array $attr аттрибуты которые необходимод обавить к тегу $tag
     * @return string
     */
    function empty_tag($tag, $attr = [])
    {
        $attribs = html_attrs($attr);

        return "<{$tag}{$attribs}/>";
    }
}

if (! function_exists('html_attrs')) {
    /**
     * Создать список аттрибутов для html тега
     *
     * @param array $attr ассоциативный массив со списком аттрибутов
     * @param array $noEscape имена аттрибутов, значения которых не следует экранировать
     * @return string
     */
    function html_attrs($attr, $noEscape = ['href', 'src'])
    {
        $html = '';
        if (is_array($attr)) {
            foreach ($attr as $key => $val) {
                switch (true) {
                    case (is_scalar($val) && is_scalar($key)):
                        $html .= ' ' . $key . '="' . (in_array($key, $noEscape) ? $val : e($val)) . '"';
                        break;
                    case ($val === true && is_scalar($key)):
                        $html .= ' ' . $key;
                        break;
                }
            }
        }

        return $html;
    }
}

if (! function_exists('make_options')) {
    /**
     * Создать html список select для формы
     *
     * @param string $name имя select формы
     * @param array $data многомерный ассоциативный массив с возможными значениями. Ключи массива - текст для возможного значения, а содержимое - аттрибуты
     * @param null $current текущее значение которое должно быть отмечено как активное
     * @param null $default значение по умолчанию (если текущее значение отсутствует в возможных значениях или вообще не определено)
     * @param array $main_attr аттрибуты для основного html тега select
     * @return string
     */
    function make_options($name, $data = [], $current = null, $default = null, $main_attr = [])
    {
        $out = '';
        $options = [];
        $selected = false;
        foreach ($data as $title => $value) {
            if (! is_array($value)) {
                $value = [
                    'value' => $value
                ];
            }
            $val = get_key($value, 'value', '');
            if (is_int($title)) {
                $title = get_key($value, 'value', $title);
            }
            if ((string)$val === (string)$current) {
                $value['selected'] = true;
                $selected = true;
            } else {
                unset($value['selected']);
            }

            $options[$title] = $value;
        }
        foreach ($options as $title => $attr) {
            if (! $selected && get_key($attr, 'value', '') == $default) {
                $attr['selected'] = true;
            }
            $out .= html_wrap('option', $title, $attr);
        }
        $main_attr['name'] = $name;

        return html_wrap('select', $out, $main_attr);
    }
}

if (! function_exists('img_tag')) {
    /**
     * Создать html тег img
     *
     * @param string $src путь к картинке
     * @param array $attr массив аттрибутов для тега img
     * @return string
     */
    function img_tag($src, $attr = [])
    {
        $attr['src'] = $src;

        return empty_tag('img', $attr);
    }
}

if (! function_exists('a_tag')) {
    /**
     * Создать html тег a
     *
     * @param string $url ссылка
     * @param string $text текст ссылки
     * @param array $options массив аттрибутов для тега a
     * @return string
     */
    function a_tag($url, $text, $options = [])
    {
        $options['href'] = $url;
        $options['title'] = strip_tags(get_key($options, 'title', $text));

        return html_wrap('a', $text, $options);
    }
}

if (! function_exists('input_tag')) {
    /**
     * Создать html тег input
     *
     * @param string $name имя input тега
     * @param string $value значение тега
     * @param string $type тип input тега
     * @param array $options дополнительные аттрибуты тега
     * @return string
     */
    function input_tag($name, $value = '', $type = 'text', $options = [])
    {
        return empty_tag('input', array_merge($options, [
            'type'  => $type,
            'name'  => $name,
            'value' => $value
        ]));
    }
}

if (! function_exists('stylesheet_link_tag')) {
    /**
     * Создать html тег для подключения файла с CSS стилями
     *
     * @param string $css путь к файлу со стилями
     * @param array $options дополнительный массив аттрибутов тега link
     * @return string
     */
    function stylesheet_link_tag($css, $options = [])
    {
        $options['href'] = $css;
        $options['rel'] = 'stylesheet';
        $options['type'] = 'text/css';

        return empty_tag('link', $options);
    }
}

if (! function_exists('javascript_include_tag')) {
    /**
     * Создать html тег для подключения файла с JavaScript
     *
     * @param string $js путь к файлу
     * @param array $options массив аттрибутов тега script
     * @return string
     */
    function javascript_include_tag($js, $options = [])
    {
        $options['src'] = $js;
        $options['type'] = 'text/javascript';

        return html_wrap('script', '', $options);
    }
}

if (! function_exists('between_tag')) {
    /**
     * Вырезание текста между HTML тэгов
     *
     * @param string $html HTML текст
     * @param string $tag HTML тэг в котором производить поиск
     * @return array
     */
    function between_tag($html, $tag = 'pre')
    {
        $replace = $count = [];
        $j = 0;
        do {
            $new = false;
            //Поиск открывающего тэга (одного!)
            preg_match('%(<' . $tag . '[^>]*>)(.*)%s', $html, $m);

            if (isset($m[1], $m[2])) {
                //Начинаем поиски закрывающих тегов (всех до конца документа)
                preg_match_all('%</' . $tag . '[^>]*>%is', $m[2], $tmp, PREG_OFFSET_CAPTURE);
                if (! empty($tmp[0])) {
                    foreach ($tmp[0] as $j => $subTmp) {
                        $closeTag = $subTmp[0]; //закрывающий тэг
                        $subText = substr($m[2], 0, $subTmp[1]); //Тексту внутри тэгов

                        //подсчет открывающих тэгов внутри полученного текста
                        preg_match_all('%(<' . $tag . '[^>]*>)%s', $subText, $count);
                        if (count($count[0]) == $j) {
                            $replace[] = [$m[1], $subText, $closeTag];
                            $new = true;
                            break;
                        }
                    }
                    $html = substr($m[2], $tmp[0][$j][1] + strlen($tmp[0][$j][0]));
                }
                if (! $new) {
                    if (isset($tmp[0][$j]) && $j < $count[0]) {
                        $subTmp = $tmp[0][$j];
                        $closeTag = $subTmp[0];

                        $subText = substr($m[2], 0, $subTmp[1]) . $closeTag;
                        $html = substr($m[2], $subTmp[1] + strlen($closeTag));
                        $replace[] = [$m[1], $subText, $closeTag];
                    } else {
                        $replace[] = [$m[1], $m[2], ''];
                        $html = '';
                    }
                }
            } else {
                $html = '';
            }
        } while (! empty($html));

        return $replace;
    }
}

if (! function_exists('clear_html')) {
    /**
     * Удаление комментариев, переносов и лишних пробелов из html строки
     *
     * @param string $html HTML текст
     * @return string
     */
    function clear_html($html)
    {
        $filters = [
            '/<!--([^\[|(<!)].*)-->/i' => '', // Remove HTML Comments (breaks with HTML5 Boilerplate)
            '/(?<!\S)\/\/\s*[^\r\n]*/' => '', // Remove comments in the form /* */
            '/\s{2,}/'                 => ' ', // Shorten multiple white spaces
            '/(\r?\n)/'                => '', // Collapse new lines
        ];

        return is_scalar($html) ? preg_replace(array_keys($filters), array_values($filters), $html) : '';
    }
}
