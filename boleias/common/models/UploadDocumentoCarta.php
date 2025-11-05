<?php

namespace common\models;

use yii\base\Model;

class UploadDocumentoCarta extends Model
{
    public $cartaFile;

    public function rules()
    {
        return [
            [['cartaFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf',],
        ];
    }

    public function upload($fileName)
    {
        if ($this->validate()) {
            $newFile = 'uploads/' . $fileName . '.' . $this->cartaFile->extension;
            $this->cartaFile->saveAs($newFile);
            return $newFile;
        }
        return false;
    }

}