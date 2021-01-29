<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Contaspagars Controller
 */
class ContaspagarsController extends AppController {

    function beforeFilter() {

    }

    /**
     * index method
     */
    public function index() {

        $this->set('title_for_layout', 'Contas pagar');

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->Filter->addFilters(
                array(
                    'filter1' => array(
                        'Contaspagar.contrato' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter2' => array(
                        'Corretor.corretor_id' => array(
                            'select' => $corretors
                        ),
                    ),
                    'filter3' => array(
                        'Contaspagar.dtvencimento' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                    'filter4' => array(
                        'Contaspagar.dtrecebimento' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                    'filter5' => array(
                        'Contaspagar.dtrepasse' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
//                    'filter6' => array(
//                        'Contasreceber.status' => array(
//                            'select' => $status
//                        ),
//                    ),
                )
        );

        $this->Contaspagar->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Contaspagar.id', 'Contaspagar.proprietario', 'Contaspagar.inquilino', 'Contaspagar.dtvencimento', 'Contaspagar.dtrecebimento',
                'Contaspagar.dtrepasse', 'Contaspagar.valor', 'Contaspagar.status', 'Corretor.nome'),
            'limit' => 20,
            'order' => array('Contaspagar.dtvencimento' => 'asc')
        );

        foreach ($this->Filter->getConditions() as $key => $item) :

        endforeach;

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('contaspagars', $this->paginate());

        CakeSession::write('conditions_filtro', array($this->Filter->getConditions()));
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set(compact('corretors'));

        if ($this->request->is('post')) {

            $encontrou = strrpos($this->request->data['Contaspagar']['valor'], ",");

            if ($encontrou !== false) {
                $this->request->data['Contaspagar']['valor'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Contaspagar']['valor']));
            }

            $this->request->data['Contaspagar']['user_id'] = $dadosUser['Auth']['User']['id'];
            $this->request->data['Contaspagar']['created'] = date('Y-m-d h:i:s');
            $this->request->data['Contaspagar']['dtvencimento'] = substr($this->request->data['Contaspagar']['dtvencimento'], 6, 4) . "-" . substr($this->request->data['Contaspagar']['dtvencimento'], 3, 2) . "-" . substr($this->request->data['Contaspagar']['dtvencimento'], 0, 2);

            $this->Contaspagar->create();
            if ($this->Contaspagar->save($this->request->data)) {
                $this->Session->setFlash('Contas à pagar adicionada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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

        $dadosUser = $this->Session->read();

        $this->Contaspagar->id = $id;
        if (!$this->Contaspagar->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set(compact('corretors'));

        $this->Contaspagar->recursive = 0;

        $contaspagar = $this->Contaspagar->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {

            $encontrou = strrpos($this->request->data['Contaspagar']['valor'], ",");

            if ($encontrou !== false) {
                $this->request->data['Contaspagar']['valor'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Contaspagar']['valor']));
            }

            $this->request->data['Contaspagar']['dtvencimento'] = substr($this->request->data['Contaspagar']['dtvencimento'], 6, 4) . "-" . substr($this->request->data['Contaspagar']['dtvencimento'], 3, 2) . "-" . substr($this->request->data['Contaspagar']['dtvencimento'], 0, 2);
            if (!empty($this->request->data['Contaspagar']['dtrecebimento'])) {
                $this->request->data['Contaspagar']['dtrecebimento'] = substr($this->request->data['Contaspagar']['dtrecebimento'], 6, 4) . "-" . substr($this->request->data['Contaspagar']['dtrecebimento'], 3, 2) . "-" . substr($this->request->data['Contaspagar']['dtrecebimento'], 0, 2);
            }
            if (!empty($this->request->data['Contaspagar']['dtrepasse'])) {
                $this->request->data['Contaspagar']['dtrepasse'] = substr($this->request->data['Contaspagar']['dtrepasse'], 6, 4) . "-" . substr($this->request->data['Contaspagar']['dtrepasse'], 3, 2) . "-" . substr($this->request->data['Contaspagar']['dtrepasse'], 0, 2);
            }

            if ($this->Contaspagar->save($this->request->data)) {
                $this->Session->setFlash('Contas a pagar alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $contaspagar;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Contaspagar->id = $id;
        if (!$this->Contaspagar->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Contaspagar->delete()) {
            $this->Session->setFlash('Contas à pagar deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * delete method
     */
    public function relatorio_comissoes_pagar($id = null) {

        $conditions_filtro = $this->Session->read('conditions_filtro');

        $this->Contaspagar->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Contaspagar.id', 'Contaspagar.contrato', 'Contaspagar.proprietario', 'Contaspagar.inquilino', 'Contaspagar.dtvencimento', 'Contaspagar.dtrecebimento',
                'Contaspagar.dtrepasse', 'Contaspagar.valor', 'Contaspagar.status', 'Contaspagar.corretor_id', 'Corretor.nome'),
            'limit' => '',
            'order' => array('Corretor.nome' => 'asc')
        );

        $this->Filter->setPaginate('conditions', array($conditions_filtro));

        $this->set('contaspagars', $this->paginate());
    }

}
