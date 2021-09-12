<?php


namespace App\Constants;


class PostConstants
{

    const SUPER_ADMIN = 'super_admin';

    const ADMIN = 'admin';

    const MODERATOR = 'moderator';

    const RECTOR = 'rector';

    const VICE_RECTOR = 'vice_rector';

    const DEAN = 'dean';

    const VICE_DEAN = 'vice_dean';

    const DEPARTMENT_HEAD = 'department_head';

    const TEACHER = 'teacher';

    /**
     * Список должностей на работе
     * @return string[]
     */
    public static function translatedList(): array
    {
        return [
            static::SUPER_ADMIN => 'Супер админ',
            static::ADMIN => 'Админ',
            static::MODERATOR => 'Модератор',
            static::RECTOR => 'Ректор',
            static::VICE_RECTOR => 'Проректор',
            static::DEAN => 'Декан',
            static::VICE_DEAN => 'Зам. декан',
            static::DEPARTMENT_HEAD => 'Зав. кафедры',
            static::TEACHER => 'Учитель',
        ];
    }

    /**
     * Ключи списка должностей на работе
     * @return string[]
     */
    public static function list(): array
    {
        return [
            static::SUPER_ADMIN,
            static::ADMIN,
            static::MODERATOR,
            static::RECTOR,
            static::VICE_RECTOR,
            static::DEAN,
            static::VICE_DEAN,
            static::DEPARTMENT_HEAD,
            static::TEACHER,
        ];
    }
}
