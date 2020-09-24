<?php


namespace App\Helpers;


class TranslationHelper
{
    public static function columnFill(string $column, array $values): array
    {
        $nonEmpty = array_values(
            array_filter($values, function ($value) {
                return $value !== null;
            })
        );

        if (!count($nonEmpty)) {
            return $values;
        }

        return array_map(function ($value) use ($nonEmpty) {
            return $value === null ? $nonEmpty[0] : $value;
        }, $values);
    }
}
