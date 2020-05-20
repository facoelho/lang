<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Negociacaostats Controller
 */
class NegociacaostatsController extends AppController {

    function beforeFilter() {

    }

    /**
     * add method
     */
    public function add($id) {

        $dadosUser = $this->Session->read();

        $contasreceber = $this->Negociacaostat->query('select count(*) as cont from contasrecebers where negociacao_id = ' . $id);

        if ($contasreceber[0][0]['cont'] > 0) {
            $status = array('E' => 'EM ANDAMENTO', 'A' => 'ACEITA', 'F' => 'FINALIZADO');
        } else {
            $status = array('E' => 'EM ANDAMENTO', 'A' => 'ACEITA', 'F' => 'FINALIZADO', 'C' => 'CANCELADO');
        }

        $this->set('status', $status);

        $this->Negociacaostat->Negociacao->recursive = 0;

        $negociacao = $this->Negociacaostat->Negociacao->read(null, $id);

        $this->set('negociacao', $negociacao);

        if ($this->request->is('post')) {

            $this->request->data['Negociacaostat']['negociacao_id'] = $id;
            $this->request->data['Negociacaostat']['user_id'] = $dadosUser['Auth']['User']['id'];
            $this->request->data['Negociacaostat']['created'] = date('Y-m-d');

            $this->Negociacaostat->create();

            if ($this->Negociacaostat->save($this->request->data)) {

                $this->Negociacaostat->Negociacao->id = $id;
                $this->Negociacaostat->Negociacao->saveField('status', $this->request->data['Negociacaostat']['status']);

                $this->Session->setFlash('Registro adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Negociacaos', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

}
