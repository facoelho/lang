<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Origens Controller
 */
class OrigensController extends AppController {

    function beforeFilter() {

    }

    /**
     * index method
     */
    public function index() {

        $this->Origen->recursive = 0;
        $this->Paginator->settings = array(
            'order' => array('descricao' => 'asc')
        );
        $this->set('origens', $this->Paginator->paginate('Origen'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Origen->id = $id;
        if (!$this->Origen->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Origen->recursive = 0;

        $origens = $this->Origen->read(null, $id);

        $this->set('origens', $origens);
    }

    /**
     * add method
     */
    public function add() {

        $opcao = array('S' => 'SIM', 'N' => 'NÃO');
        $this->set('opcao', $opcao);

        if ($this->request->is('post')) {
            $this->request->data['Origen']['valor_investido'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Origen']['valor_investido']));
            $this->Origen->create();
            if ($this->Origen->save($this->request->data)) {
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

        $this->Origen->id = $id;
        if (!$this->Origen->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Origen->recursive = 0;
        $origens = $this->Origen->read(null, $id);

        $opcao = array('S' => 'SIM', 'N' => 'NÃO');
        $this->set('opcao', $opcao);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Origen']['valor_investido'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Origen']['valor_investido']));
            if ($this->Origen->save($this->request->data)) {
                $this->Session->setFlash('Mídia de referência alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $origens;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Origen->id = $id;
        if (!$this->Origen->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Origen->delete()) {
            $this->Session->setFlash('Mídia de referência deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * Funções ajax
     */
    public function buscaOrigens($chave) {

        $this->layout = 'ajax';

        debug($this->request->data);
        $this->Origen->recursive = 0;

        $origens_aux = $this->Origen->find('all', array(
            'fields' => array('DISTINCT id', 'descricao'),
            'joins' => array(
                array(
                    'table' => 'importacaoleads',
                    'alias' => 'Importacaolead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.origen_id = Origen.id',
                    ],
                ),
                array(
                    'table' => 'leads',
                    'alias' => 'Lead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.id = Lead.importacaolead_id',
                    ],
                ),
            ),
            'conditions' => array('Lead.corretor_id' => $this->request->data['Relatorio']['corretor_id']),
            'order' => array('Origen.descricao' => 'asc'),
        ));

        foreach ($origens_aux as $key => $item) :
            $origens[$item['Origen']['id']] = $item['Origen']['descricao'];
        endforeach;

        $this->set('origens', $origens);
    }

}
