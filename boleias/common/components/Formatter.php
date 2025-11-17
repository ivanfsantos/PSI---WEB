<?php

namespace common\components;

class Formatter extends \yii\i18n\Formatter
{
    public function asRating($value)
    {
        if ($value === null || $value === '') {
            return null;
        }
        return $value . '/5';
    }
}
