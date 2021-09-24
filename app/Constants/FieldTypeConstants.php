<?php


namespace App\Constants;


class FieldTypeConstants
{
    const STRING = 'string';

    const NUMBER = 'number';

    const DATE = 'date';

    const TEXT = 'text';

    const FILE = 'file';

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return [
            self::STRING,
            self::NUMBER,
            self::DATE,
            self::TEXT,
            self::FILE,
        ];
    }

    /**
     * @return string[]
     */
    public static function translatedList(): array
    {
        return [
            self::STRING => 'Строка',
            self::NUMBER => 'Целое число',
            self::DATE => 'Дата',
            self::TEXT => 'Текст',
            self::FILE => 'Файл',
        ];
    }
}
