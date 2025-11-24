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

        //Boleia
        $criarBoleia = $auth->createPermission('criarBoleia');
        $criarBoleia->description = 'Criar uma Boleia';
        $auth->add($criarBoleia);

        $editarBoleia = $auth->createPermission('editarBoleia');
        $editarBoleia->description = 'Editar uma Boleia';
        $auth->add($editarBoleia);

        $eliminarBoleia = $auth->createPermission('eliminarBoleia');
        $eliminarBoleia->description = 'Eliminar uma Boleia';
        $auth->add($eliminarBoleia);


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

        //Estatística
        $criarEstatistica = $auth->createPermission('criarEstatistica');
        $criarEstatistica->description = 'Criar uma estatistica';
        $auth->add($criarEstatistica);

        $updateEstatistica = $auth->createPermission('updateEstatistica');
        $updateEstatistica->description = 'Dar update a uma estatistica';
        $auth->add($updateEstatistica);

        $elimnarEstatistica = $auth->createPermission('eliminarEstatistica');
        $elimnarEstatistica->description = 'Eliminar uma estatistica';
        $auth->add($elimnarEstatistica);

        //Acessos
        $acederBackend = $auth->createPermission('acederBackend');
        $acederBackend->description = 'Aceder ao backend';
        $auth->add($acederBackend);

        $acederFrontend = $auth->createPermission('acederFrontend');
        $acederFrontend->description = 'Aceder ao frontend';
        $auth->add($acederFrontend);

        $acederEstatistica = $auth->createPermission('acederEstatistica');
        $acederEstatistica->description = 'Aceder ás estatisticas';
        $auth->add($acederEstatistica);

        $acederDocumento = $auth->createPermission('acederDocumento');
        $acederDocumento->description = 'Aceder aos documentos';
        $auth->add($acederDocumento);

        $acederPerfil = $auth->createPermission('acederPerfil');
        $acederPerfil->description = 'Aceder aos perfis';
        $auth->add($acederPerfil);

        $acederAvaliacao = $auth->createPermission('acederAvaliacao');
        $acederAvaliacao->description = 'Aceder ás avaliacoes';
        $auth->add($acederAvaliacao);

        $acederReserva = $auth->createPermission('acederReserva');
        $acederReserva->description = 'Aceder ás reservas';
        $auth->add($acederReserva);

        $acederFavorito = $auth->createPermission('acederFavorito');
        $acederFavorito->description = 'Aceder aos destinos favoritos';
        $auth->add($acederFavorito);

        $acederBoleia = $auth->createPermission('acederBoleia');
        $acederBoleia->description = 'Aceder ás boleias';
        $auth->add($acederBoleia);

        $acederViatura = $auth->createPermission('acederViatura');
        $acederViatura->description = 'Aceder ás viaturas';
        $auth->add($acederViatura);



        // ====== Definir Papéis =====

        // adciona a role "passageiro"
        $passageiro = $auth->createRole('passageiro');
        $auth->add($passageiro);


        $auth->addChild($passageiro, $acederFrontend);
        $auth->addChild($passageiro, $acederAvaliacao);
        $auth->addChild($passageiro, $acederReserva);
        $auth->addChild($passageiro, $acederFavorito);
        $auth->addChild($passageiro, $acederPerfil);
        $auth->addChild($passageiro, $criarAvaliacao);
        $auth->addChild($passageiro, $editarAvaliacao);
        $auth->addChild($passageiro, $eliminarAvaliacao);
        $auth->addChild($passageiro, $criarReserva);
        $auth->addChild($passageiro, $cancelarReserva);
        $auth->addChild($passageiro, $adicionarFavorito);
        $auth->addChild($passageiro, $removerFavorito);
        $auth->addChild($passageiro, $criarPassageiro);
        $auth->addChild($passageiro, $editarPassageiro);
        $auth->addChild($passageiro, $eliminarPassageiro);
        $auth->addChild($passageiro, $acederBoleia);



        // adiciona a role "condutor"
        $condutor = $auth->createRole('condutor');
        $auth->add($condutor);

        //Herda permissões de Passageiro
        $auth->addChild($condutor, $passageiro);

        // Permissões exclusivas de condutor
        $auth->addChild($condutor, $criarCondutor);
        $auth->addChild($condutor, $editarCondutor);
        $auth->addChild($condutor, $eliminarCondutor);
        $auth->addChild($condutor, $acederDocumento);
        $auth->addChild($condutor, $acederBoleia);
        $auth->addChild($condutor, $acederViatura);
        $auth->addChild($condutor, $criarDocumento);
        $auth->addChild($condutor, $editarDocumento);
        $auth->addChild($condutor, $eliminarDocumento);
        $auth->addChild($condutor, $criarBoleia);
        $auth->addChild($condutor, $editarBoleia);
        $auth->addChild($condutor, $eliminarBoleia);
        $auth->addChild($condutor, $criarViatura);
        $auth->addChild($condutor, $editarViatura);
        $auth->addChild($condutor, $eliminarViatura);


        // adciona a role "admin" e adicionar childs para ter as mesmas permissoes que as childs
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin , $passageiro);
        $auth->addChild($admin , $condutor);

        //Permissões exclusivas para Admin
        $auth->addChild($admin , $criarAdmin);
        $auth->addChild($admin , $editarAdmin);
        $auth->addChild($admin , $eliminarAdmin);
        $auth->addChild($admin , $acederBoleia);
        $auth->addChild($admin , $acederBackend);

        // ==== Atribuir Papéis a Utilizadores ====

        // Substituir pelos IDs reais dos utilizadores no banco de dados
        $auth->assign($admin, 1);   // Admin (ID 1)
        $auth->assign($condutor, 3);
        $auth->assign($passageiro, 4);

        echo "RBAC configurado com sucesso.\n";
    }
}