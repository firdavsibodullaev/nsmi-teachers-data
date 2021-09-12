<?php


namespace App\Constants;


class FieldTypeConstants
{
    const STRING = 'string';

    const INTEGER = 'integer';

    const DOUBLE = 'double';

    const DATE = 'date';

    const TEXT = 'text';

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return [
            self::STRING,
            self::INTEGER,
            self::DOUBLE,
            self::DATE,
            self::TEXT,
        ];
    }

    /**
     * @return string[]
     */
    public static function translatedList(): array
    {
        return [
            self::STRING => 'Строка',
            self::INTEGER => 'Целое число',
            self::DOUBLE => 'Число с плавающей точкой',
            self::DATE => 'Дата',
            self::TEXT => 'Текст',
        ];
    }
}
