<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Perfil Clientes Controller
 */
class PerfilclientesController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Perfil clientes');
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

        $this->Filter->addFilters(
                array(
                    'filter1' => array(
                        'Perfilcliente.usuario' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter2' => array(
                        'Perfilcliente.nome' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter3' => array(
                        'Perfilcliente.email' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Perfilcliente.telefone' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                )
        );

        $this->Perfilcliente->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('nome' => 'asc')
        );

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('perfilclientes', $this->Paginator->paginate('Perfilcliente'));
    }

    public function email() {
//        debug($this->request->data);
//        die();
    }

    public function send() {

        debug($this->request->data);
        debug($this->data);
        die();

        $this->Email->from = 'contato@eduardolang.com.br';
    }

}
