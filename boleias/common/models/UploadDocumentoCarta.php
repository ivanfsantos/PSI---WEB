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
            $path = \Yii::getAlias('@frontend/web/uploads/') . $fileName . '.' . $this->cartaFile->extension;

            $this->cartaFile->saveAs($path);

            return $fileName . '.' . $this->cartaFile->extension;
        }
        return false;
    }

}