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

    public $components = array('Paginator');

    /**
     * index method
     */
    public function index($negociacao = null) {

//        if (empty($negociacao)) {
//            $negociacao = $negociacao;
//        }

        $this->set('negociacao', $negociacao);

        $dadosUser = $this->Session->read();
        $this->set('dadosUser', $dadosUser);

        $tipopessoa = array('F' => 'Física', 'J' => 'Jurídica');

        $this->Filter->addFilters(
                array(
                    'filter1' => array(
                        'Cliente.tipopessoa' => array(
                            'select' => $tipopessoa
                        ),
                    ),
                    'filter2' => array(
                        'Cliente.razaosocial' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter3' => array(
                        'Cliente.nomefantasia' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Cliente.nome' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter5' => array(
                        'Cliente.cpf' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    )
                )
        );

        $this->Cliente->recursive = 0;

        $this->Paginator->settings = array('Cliente.nome' => 'asc');

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('clientes', $this->Paginator->paginate('Cliente'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $dadosUser = $this->Session->read();

        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Cliente->recursive = 1;

        $cliente = $this->Cliente->read(null, $id);

        $this->set('cliente', $cliente);
    }

    /**
     * add method
     */
    public function add() {

        $loja_id = '';
        $users = array();

        $dadosUser = $this->Session->read();

        $tipopessoa = array('F' => 'Física', 'J' => 'Jurídica');

        $this->set('tipopessoa', $tipopessoa);

        if ($this->request->is('post')) {

            if ($this->request->data['Cliente']['tipopessoa'] == 'F') {
                if ((empty($this->request->data['Cliente']['cpfCliente'])) or (empty($this->request->data['Cliente']['nome']))) {
                    $this->Session->setFlash('CPF, nome e sobrenome do cliente são obrigatórios.', 'default', array('class' => 'mensagem_erro'));
                    return;
                }
            }

            if ($this->request->data['Cliente']['tipopessoa'] == 'J') {
                if ((empty($this->request->data['Cliente']['cnpjCliente'])) or (empty($this->request->data['Cliente']['razaosocial']))) {
                    $this->Session->setFlash('CNPJ e Razão Social do cliente são obrigatórios.', 'default', array('class' => 'mensagem_erro'));
                    return;
                }
            }

            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Cliente']['cnpj'] = str_replace($separadores, '', $this->request->data['Cliente']['cnpjCliente']);
            $this->request->data['Cliente']['cpf'] = str_replace($separadores, '', $this->request->data['Cliente']['cpfCliente']);
            $this->request->data['Cliente']['telefone'] = str_replace($separadores, '', $this->request->data['Cliente']['telefoneCliente']);
            $this->Cliente->create();
            if ($this->Cliente->save($this->request->data)) {
                $this->Session->setFlash('Cliente adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $this->Cliente->recursive = 1;
        $cliente = $this->Cliente->read(null, $id);

        $tipopessoa = array('F' => 'Física', 'J' => 'Jurídica');

        $this->set('tipopessoa', $tipopessoa);

        if ($this->request->is('post') || $this->request->is('put')) {
            $separadores = array(".", "-", "/", "(", ")");
            $this->request->data['Cliente']['cnpj'] = str_replace($separadores, '', $this->request->data['Cliente']['cnpjCliente']);
            $this->request->data['Cliente']['cpf'] = str_replace($separadores, '', $this->request->data['Cliente']['cpfCliente']);
            $this->request->data['Cliente']['telefone'] = str_replace($separadores, '', $this->request->data['Cliente']['telefoneCliente']);
            if ($this->Cliente->save($this->request->data)) {
                $this->Session->setFlash('Cliente alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
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

        $dadosUser = $this->Session->read();

        $this->Cliente->id = $id;
        if (!$this->Cliente->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Cliente->delete()) {
            $this->Session->setFlash('Cliente deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

}

