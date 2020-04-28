<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('GoogleCharts', 'GoogleCharts.Lib');

/**
 * Escalas Controller
 */
class EscalasController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Escala de plantão');
    }

    /**
     * index method
     */
    public function index() {

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array(
            'fields' => array('nome', 'nome'),
            'conditions' => array('ativo' => 'S'),
            'order' => array('nome' => 'asc')
        ));
        $this->set('corretors', $corretors);

        if ($this->request->is('post') || $this->request->is('put')) {
            CakeSession::write('escala', $this->request->data);
            $this->redirect(array('action' => 'imprimir_escala'));
        }
    }

    /**
     * view method
     */
    public function imprimir_escala() {

        $escala = $this->Session->read('escala');

        $participantes = $escala['Relatorio']['corretor'];
        $this->set('participantes', $participantes);
        $this->set('participantes_aux', $participantes);

        $dtinicio = substr($escala['Relatorio']['anomes'], 3, 4) . '-' . substr($escala['Relatorio']['anomes'], 0, 2) . '-01';

        $mes = substr($escala['Relatorio']['anomes'], 0, 2);
        $ano = substr($escala['Relatorio']['anomes'], 3, 4);
        $diafim = $dtfim = date("t", mktime(0, 0, 0, $mes, '01', $ano));
        $dtfim = date("t", mktime(0, 0, 0, $mes, '01', $ano)) . '-' . $mes . '-' . $ano;

        $this->set('dtinicio', $dtinicio);
        $this->set('diafim', $diafim);
        $this->set('mes', $mes);
        $this->set('ano', $ano);
    }

}
