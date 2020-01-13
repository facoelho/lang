<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Clientes Controller
 */
class ClientesController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Clientes');
    }

    public function isAuthorized($user) {
        $Users = new UsersController;
        return $Users->validaAcesso($this->Session->read(), $this->request->controller);
        return parent::isAuthorized($user);
    }

    /**
     * index method
     */
    public function index() {

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->Filter->addFilters(
                array(
                    'filter1' => array(
                        'Origen.id' => array(
                            'select' => $origens
                        ),
                    ),
                    'filter2' => array(
                        'Corretor.id' => array(
                            'select' => $corretors
                        ),
                    ),
                    'filter3' => array(
                        'Cliente.nome' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Cliente.email' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter5' => array(
                        'Cliente.telefone' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                )
        );

        $this->Cliente->recursive = 0;
        $this->Paginator->settings = array(
            'joins' => array(
                array(
                    'table' => 'leads',
                    'alias' => 'Lead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Cliente.id = Lead.cliente_id',
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
                array(
                    'table' => 'corretors',
                    'alias' => 'Corretor',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Lead.corretor_id = Corretor.id',
                    ],
                ),
            ),
            'order' => array('nome' => 'asc')
        );

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('clientes', $this->Paginator->paginate('Cliente'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Cliente->recursive = 0;

        $clientes = $this->Cliente->read(null, $id);

        $this->set('clientes', $clientes);
    }

    /**
     * add method
     */
    public function add() {

        if ($this->request->is('post')) {
            $this->Cliente->create();
            if ($this->Cliente->save($this->request->data)) {
                $this->Session->setFlash('Mídia de referência adicionada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $this->Cliente->id = $id;
        if (!$this->Cliente->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $cliente = $this->Cliente->read(null, $id);

        debug($cliente);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Cliente->save($this->request->data)) {
                $this->Session->setFlash('Mídia de referência alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $cliente;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Cliente->delete()) {
            $this->Session->setFlash('Mídia de referência deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

}
