<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Desempenhoindivids Controller
 */
class DesempenhoindividsController extends AppController {

    function beforeFilter() {

    }

    /**
     * index method
     */
    public function index() {

        $this->loadModel('Desempenho');
        $desempenho_aux = $this->Desempenho->find('all', array('fields' => array('id', 'dtinicio', 'dtfim'),
            'order' => array('dtfim')));

        foreach ($desempenho_aux as $key => $item) :
            $desempenhos[$item['Desempenho']['id']] = $item['Desempenho']['dtinicio'] . ' à ' . $item['Desempenho']['dtfim'];
        endforeach;

        $this->set('desempenhos', $desempenhos);

        if ($this->request->is('post') || $this->request->is('put')) {
            CakeSession::write('conditions', $this->request->data);
            $this->redirect(array('action' => 'qualify_desempenho'));
        }
    }

    /**
     * qualify_desempenho method
     */
    public function qualify_desempenho($id = null) {

        $conditions = $this->Session->read('conditions');

        $desempenho_id = $conditions['Relatorio']['desempenho_id'];
        $corretor_id = $conditions['Relatorio']['corretor_id'];

        $desempenhoindivids = $this->Desempenhoindivid->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Desempenhoindivid']['vgv_avulso'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Desempenhoindivid']['vgv_avulso']));
            $this->request->data['Desempenhoindivid']['vgv_emp'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Desempenhoindivid']['vgv_emp']));
            if ($this->Desempenhoindivid->save($this->request->data)) {
                $this->Session->setFlash('Registro alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Desempenhos', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $desempenhoindivids;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Desempenhoiten->id = $id;
        if (!$this->Desempenhoiten->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Desempenhoiten->delete()) {
            $this->Session->setFlash('Registro deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

}
