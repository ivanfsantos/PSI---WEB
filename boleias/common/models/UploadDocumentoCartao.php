<?php

namespace common\models;

use yii\base\Model;

class UploadDocumentoCartao extends Model
{
    public $cartaoFile;

    public function rules()
    {
        return [
            [['cartaoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf',],
        ];
    }

    public function upload($fileName)
    {
        if ($this->validate()) {
            $path = \Yii::getAlias('@frontend/web/uploads/') . $fileName . '.' . $this->cartaoFile->extension;
            $this->cartaoFile->saveAs($path);
            return $fileName . '.' . $this->cartaoFile->extension;
        }
        return false;
    }

}