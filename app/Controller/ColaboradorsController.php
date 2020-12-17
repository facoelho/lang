<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Colaboradors Controller
 */
class ColaboradorsController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Funcionarios');
    }

    /**
     * index method
     */
    public function index() {

        $this->Colaborador->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('nome' => 'asc')
        );
        $this->set('colaboradors', $this->Paginator->paginate('Colaborador'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Colaborador->id = $id;
        if (!$this->Colaborador->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Colaborador->recursive = 0;

        $colaboradors = $this->Corretor->read(null, $id);

        $this->set('colaboradors', $colaboradors);
    }

    /**
     * add method
     */
    public function add() {

        $opcoes = array('S' => 'SIM', 'N' => 'NÃO');
        $this->set('opcoes', $opcoes);

        if ($this->request->is('post')) {

            $this->Colaborador->create();
            if ($this->Colaborador->save($this->request->data)) {
                $this->Session->setFlash('Colaborador adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $this->Colaborador->id = $id;
        if (!$this->Colaborador->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $opcoes = array('S' => 'SIM', 'N' => 'NÃO');
        $this->set('opcoes', $opcoes);

        $this->Colaborador->recursive = 0;

        $colaborador = $this->Colaborador->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->Colaborador->save($this->request->data)) {
                $this->Session->setFlash('Colaborador alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $colaborador;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Colaborador->id = $id;
        if (!$this->Colaborador->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Colaborador->recursive = 0;

        if ($this->Colaborador->delete()) {
            $this->Session->setFlash('Colaborador deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Funções ajax
     */
    public function buscaColaboradors($chave) {

        $this->layout = 'ajax';

        $this->Colaborador->recursive = 0;

        $colaboradors = $this->Colaborador->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));

        $this->set('corretors', $corretors);
    }

}
