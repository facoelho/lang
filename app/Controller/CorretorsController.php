<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('GoogleCharts', 'GoogleCharts.Lib');

/**
 * Corretors Controller
 */
class CorretorsController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Corretores');
    }

    /**
     * index method
     */
    public function index() {

        $this->Corretor->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('nome' => 'asc')
        );
        $this->set('corretors', $this->Paginator->paginate('Corretor'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Corretor->id = $id;
        if (!$this->Corretor->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Corretor->recursive = 0;

        $corretors = $this->Corretor->read(null, $id);

        $this->set('corretors', $corretors);
    }

    /**
     * add method
     */
    public function add() {

        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'S'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        if ($this->request->is('post')) {
            $this->Corretor->create();
            if ($this->Corretor->save($this->request->data)) {
                $this->Session->setFlash('Corretor adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Corretor->id = $id;
        if (!$this->Corretor->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'S'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $corretors = $this->Corretor->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Corretor->save($this->request->data)) {
                $this->Session->setFlash('Corretor alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $corretors;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Corretor->id = $id;
        if (!$this->Corretor->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Corretor->delete()) {
            $this->Session->setFlash('Corretor deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Funções ajax
     */
    public function buscaCorretors($chave) {

        $this->layout = 'ajax';

        $this->Corretor->recursive = 0;

        $corretors_aux = $this->Corretor->find('all', array(
            'fields' => array('DISTINCT id', 'nome'),
            'joins' => array(
                array(
                    'table' => 'leads',
                    'alias' => 'Lead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Lead.corretor_id = Corretor.id',
                    ],
                ),
                array(
                    'table' => 'importacaoleads',
                    'alias' => 'Importacaolead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.id = Lead.importacaolead_id',
                    ],
                ),
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.origen_id = Origen.id',
                    ],
                ),
            ),
            'conditions' => array('Origen.id' => $this->request->data['Relatorio']['origen_id']),
            'order' => array('Corretor.nome' => 'asc'),
        ));

        foreach ($corretors_aux as $key => $item) :
            $corretors[$item['Corretor']['id']] = $item['Corretor']['nome'];
        endforeach;

        $this->set('corretors', $corretors);
    }

}
