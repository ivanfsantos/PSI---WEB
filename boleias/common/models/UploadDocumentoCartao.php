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
            $newFile = 'uploads/' . $fileName . '.' . $this->cartaoFile->extension;
            $this->cartaoFile->saveAs($newFile);
            return $newFile;
        }
            return false;
    }

}