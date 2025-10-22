<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\filters\auth\AuthInterface;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // Limpar todos os papéis e permissões para resetar o RBAC
        $auth->removeAll();

        // ==== Definir Permissões ====

        //Passageiro
        $criarPassageiro = $auth->createPermission('criarPassageiro');
        $criarPassageiro->description = 'Criar um  perfil de Passageiro';
        $auth->add($criarPassageiro);

        $editarPassageiro = $auth->createPermission('editarPassageiro');
        $editarPassageiro->description = 'Editar um  perfil de Passageiro';
        $auth->add($editarPassageiro);

        $eliminarPassageiro = $auth->createPermission('eliminarPassageiro');
        $eliminarPassageiro->description = 'Eliminar um  perfil de Passageiro';
        $auth->add($eliminarPassageiro);

        //Condutor
        $criarCondutor = $auth->createPermission('criarCondutor');
        $criarCondutor->description = 'Criar um  perfil de Condutor';
        $auth->add($criarCondutor);

        $editarCondutor = $auth->createPermission('editarCondutor');
        $editarCondutor->description = 'Editar um perfil de Condutor';
        $auth->add($editarCondutor);

        $eliminarCondutor = $auth->createPermission('eliminarCondutor');
        $eliminarCondutor->description = 'Eliminar um perfil de Condutor';
        $auth->add($eliminarCondutor);

        //Admin
        $criarAdmin = $auth->createPermission('criarAdmin');
        $criarAdmin->description = 'Criar um  perfil de Administrador';
        $auth->add($criarAdmin);

        $editarAdmin = $auth->createPermission('editarAdmin');
        $editarAdmin->description = 'Editar um perfil de Administrador';
        $auth->add($editarAdmin);

        $eliminarAdmin = $auth->createPermission('eliminarAdmin');
        $eliminarAdmin->description = 'Eliminar um perfil de Administrador';
        $auth->add($eliminarAdmin);

        //Documentos
        $criarDocumento = $auth->createPermission('criarDocumento');
        $criarDocumento->description = 'Criar um Documento';
        $auth->add($criarDocumento);

        $editarDocumento = $auth->createPermission('editarDocumento');
        $editarDocumento->description = 'Editar um Documento';
        $auth->add($editarDocumento);

        $eliminarDocumento = $auth->createPermission('eliminarDocumento');
        $eliminarDocumento->description = 'Eliminar um Documento';
        $auth->add($eliminarDocumento);

        //Avaliações
        $criarAvaliacao = $auth->createPermission('criarAvaliacao');
        $criarAvaliacao->description = 'Criar uma Avaliacao';
        $auth->add($criarAvaliacao);

        $editarAvaliacao = $auth->createPermission('editarAvaliacao');
        $editarAvaliacao->description = 'Editar uma Avaliacao';
        $auth->add($editarAvaliacao);

        $eliminarAvaliacao = $auth->createPermission('eliminarAvaliacao');
        $eliminarAvaliacao->description = 'Eliminar uma Avaliacao';
        $auth->add($eliminarAvaliacao);

        //Reservas
        $criarReserva = $auth->createPermission('criarReserva');
        $criarReserva->description = 'Criar uma Reserva';
        $auth->add($criarReserva);

        $cancelarReserva = $auth->createPermission('cancelarReserva');
        $cancelarReserva->description = 'Cancelar uma Reserva';
        $auth->add($cancelarReserva);

        //Viaturas
        $criarViatura = $auth->createPermission('criarViatura');
        $criarViatura->description = 'Criar uma Viatura';
        $auth->add($criarViatura);

        $editarViatura = $auth->createPermission('editarViatura');
        $editarViatura->description = 'Editar uma Viatura';
        $auth->add($editarViatura);

        $eliminarViatura = $auth->createPermission('eliminarViatura');
        $eliminarViatura->description = 'Eliminar uma Viatura';
        $auth->add($eliminarViatura);

        //Destinos Favoritos
        $adicionarFavorito = $auth->createPermission('adicionarFavorito');
        $adicionarFavorito->description = 'Adicionar um destino favorito';
        $auth->add($adicionarFavorito);

        $removerFavorito = $auth->createPermission('removerFavorito');
        $removerFavorito->description = 'Remover um destino favorito';
        $auth->add($removerFavorito);




        // adciona a role "passageiro"
        $passageiro = $auth->createRole('passageiro');
        $auth->add($passageiro);

        // adciona a role "motorista"
        $motorista = $auth->createRole('motorista');
        $auth->add($motorista);

        // adciona a role "admin" e adicionar childs para ter as mesmas permissoes que as childs
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin , $passageiro);
        $auth->addChild($admin , $motorista);



    }
}