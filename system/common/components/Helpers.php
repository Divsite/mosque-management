<?php
namespace common\components;

class Helpers
{
    public static function relationValue($model, $relationName, $attributeName = 'name', $default = '-')
    {
        return $model->{$relationName}?->{$attributeName} ?? $default;
    }
}
