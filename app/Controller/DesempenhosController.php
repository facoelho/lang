<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Desempenhos Controller
 */
class DesempenhosController extends AppController {

    function beforeFilter() {

    }

    /**
     * index method
     */
    public function index() {

        $this->Desempenho->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('desempenhos', $this->Paginator->paginate('Desempenho'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Desempenho->id = $id;
        if (!$this->Desempenho->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Desempenho->recursive = 0;

        $desempenho = $this->Desempenho->read(null, $id);

        $this->set('desempenhoiten', $desempenho);
    }

    /**
     * add method
     */
    public function add() {

        $this->loadModel('Corretor');

        $corretors = $this->Corretor->find('list', array(
            'fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome' => 'asc')
        ));
        $this->set('corretors', $corretors);

        if ($this->request->is('post')) {

            $this->request->data['Desempenho']['anomes'] = substr($this->request->data['Desempenho']['anomes'], 3, 4) . substr($this->request->data['Desempenho']['anomes'], 0, 2);

            try {

                $this->Desempenho->begin();

                $this->Desempenho->create();
                if ($this->Desempenho->save($this->request->data)) {
                    $desempenho_id = $this->Desempenho->getLastInsertId();
                    foreach ($this->request->data['Desempenho']['corretor'] as $key => $item) :
                        $this->Desempenho->query('insert into public.desempenhoindivids(desempenho_id, corretor_id)'
                                . 'values(' . $desempenho_id . ',' . $item . ')');
                    endforeach;

                    $this->Desempenho->commit();

                    $this->Session->setFlash('Registro adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
                }
            } catch (Exception $id) {
                $this->Desempenho->rollback();
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Desempenho->id = $id;
        if (!$this->Desempenho->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Desempenho->recursive = 0;

        $desempenho = $this->Desempenho->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Desempenho->save($this->request->data)) {
                $this->Session->setFlash('Registro alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $desempenho;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Desempenho->id = $id;
        if (!$this->Desempenho->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Desempenho->delete()) {
            $this->Session->setFlash('Registro deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    public function busca_desempenho_corretors($id) {

        $this->layout = 'ajax';

        $corretors = $this->Desempenho->find('all', array(
            'fields' => array('Desempenhoindivid.id', 'Corretor.nome', 'Corretor.foto'),
            'joins' => array(
                array(
                    'table' => 'desempenhoindivids',
                    'alias' => 'Desempenhoindivid',
                    'type' => 'INNER',
                    'conditions' => [
                        'Desempenhoindivid.desempenho_id = Desempenho.id',
                    ],
                ),
                array(
                    'table' => 'corretors',
                    'alias' => 'Corretor',
                    'type' => 'INNER',
                    'conditions' => [
                        'Desempenhoindivid.corretor_id = Corretor.id',
                    ],
                ),
            ),
            'conditions' => array('Desempenho.id' => $id),
            'order' => array('Corretor.nome' => 'asc'),
        ));

        return $corretors;
    }

}
