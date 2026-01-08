<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\Tarefa;

class TarefaController extends Controller
{
    /**
     * Lista todas as tarefas.
     */
    public function actionIndex($id = null) {
        // $id é opcional, se você quiser filtrar tarefas do usuário
        $query = \common\models\Tarefa::find();
        if ($id) {
            $query->andWhere(['atribuido' => $id]);
        }
        $tarefas = $query->all();

        return $this->render('index', ['tarefas' => $tarefas]);
    }


    /**
     * Atualiza apenas o estado da tarefa
     */
    public function actionUpdateEstado($id)
    {
        $tarefa = $this->findModel($id);

        // Apenas permitir alterar se o usuário for atribuído
        if ($tarefa->atribuido != Yii::$app->user->id) {
            throw new \yii\web\ForbiddenHttpException('Você não pode alterar esta tarefa.');
        }

        // Só alterar o atributo 'estado'
        if (Yii::$app->request->isPost) {
            $novoEstado = Yii::$app->request->post('estado');
            if (in_array($novoEstado, array_keys(Tarefa::optsEstado()))) {
                $tarefa->estado = $novoEstado;
                $tarefa->save(false);
            }
        }

        // Redireciona para o index com id do usuário
        return $this->redirect(['index', 'id' => Yii::$app->user->id]);
    }

    protected function findModel($id)
    {
        if (($model = Tarefa::findOne($id)) !== null) {
            return $model;
        }

        throw new \yii\web\NotFoundHttpException('Tarefa não encontrada.');
    }



}
