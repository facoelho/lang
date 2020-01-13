<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Negociacaohistoricos Controller
 */
class NegociacaohistoricosController extends AppController {

    function beforeFilter() {

    }

    /**
     * add method
     */
    public function add($id) {

        $dadosUser = $this->Session->read();

        $this->loadModel('Corretor');

        if ($this->request->is('post')) {

            $this->request->data['Negociacaohistorico']['negociacao_id'] = $id;
            $this->request->data['Negociacaohistorico']['user_id'] = $dadosUser['Auth']['User']['id'];
            $this->request->data['Negociacaohistorico']['created'] = substr($this->request->data['Negociacaohistorico']['created'], 6, 4) . "-" . substr($this->request->data['Negociacaohistorico']['created'], 3, 2) . "-" . substr($this->request->data['Negociacaohistorico']['created'], 0, 2);

            $this->Negociacaohistorico->create();
            if ($this->Negociacaohistorico->save($this->request->data)) {

                $this->Negociacaohistorico->Negociacao->id = $id;
                $this->Negociacaohistorico->Negociacao->saveField('dt_ultima_etapa', $this->request->data['Negociacaohistorico']['created']);

                $this->Session->setFlash('Registro adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Negociacaos', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

}
