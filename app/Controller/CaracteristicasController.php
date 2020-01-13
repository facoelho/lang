<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('GoogleCharts', 'GoogleCharts.Lib');

/**
  class Caracteristicas Controller
 */
class CaracteristicasController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Caracteristicas');
        $this->Auth->allow('caracteristicas', 'sucess');
    }

    /**
     * caracteristicas method
     */
    public function caracteristicas($param_aux = null) {

        $param = explode(',', $param_aux);

        $this->set('nome', $param[0]);
        $this->set('email', $param[1]);

        if (!empty($param[0])) {
            $this->Caracteristica->query('insert into logs(nome, email)' .
                    'values(' . "'" . $param[0] . "'" . ',' . "'" . $param[1] . "'" . ')');
        }

        $this->loadModel('Operacaotipo');
        $operacaotipos = $this->Operacaotipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('id')));
        $this->set('operacaotipos', $operacaotipos);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'conditions' => array('questionario_cliente' => 'S'),
            'order' => array('id')));
        $this->set('imoveltipos', $imoveltipos);

        $this->loadModel('Imovelsituacao');
        $imovelsituacaos = $this->Imovelsituacao->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imovelsituacaos', $imovelsituacaos);

        $this->loadModel('Dormitorio');
        $dormitorios = $this->Dormitorio->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('id')));
        $this->set('dormitorios', $dormitorios);

        if ($this->request->is('post')) {

            if (!empty($this->request->data['Caracteristica']['emailaux'])) {
                $this->request->data['Caracteristica']['email'] = $this->request->data['Caracteristica']['emailaux'];
            }
            $this->request->data['Caracteristica']['nome'] = $this->request->data['Caracteristica']['nomeaux'];
            $this->request->data['Caracteristica']['valor_max'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Caracteristica']['valor_max']));
            $this->request->data['Caracteristica']['data'] = date('Y-m-d h:m');

            $this->Caracteristica->create();

            if ($this->Caracteristica->save($this->request->data['Caracteristica'])) {

                $caracteristica_id = $this->Caracteristica->getLastInsertId();

                foreach ($this->request->data['operacao'] as $key => $valor) :
                    if ($valor > 0) {
                        $this->Caracteristica->query('insert into caracoperacaotipos(operacaotipo_id, caracteristica_id)' .
                                'values(' . $key . ',' . $caracteristica_id . ')');
                    }
                endforeach;

                foreach ($this->request->data['tipoimovel'] as $key => $valor) :
                    if ($valor > 0) {
                        if ($valor == 4) {
                            $this->Caracteristica->query('insert into caracimoveltipos(imoveltipo_id, caracteristica_id, obs)' .
                                    'values(' . $key . ',' . $caracteristica_id . ',' . "'" . $this->request->data['Caracteristica']['outro'] . "'" . ')');
                        } else {
                            $this->Caracteristica->query('insert into caracimoveltipos(imoveltipo_id, caracteristica_id)' .
                                    'values(' . $key . ',' . $caracteristica_id . ')');
                        }
                    }
                endforeach;

                foreach ($this->request->data['dormitorio'] as $key => $valor) :
                    if ($valor > 0) {
                        $this->Caracteristica->query('insert into caracdormitorios(dormitorio_id, caracteristica_id)' .
                                'values(' . $key . ',' . $caracteristica_id . ')');
                    }
                endforeach;

                foreach ($this->request->data['situacao'] as $key => $valor) :
                    if ($valor > 0) {
                        $this->Caracteristica->query('insert into caracimovelsituacaos(imovelsituacao_id, caracteristica_id)' .
                                'values(' . $key . ',' . $caracteristica_id . ')');
                    }
                endforeach;
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
            $this->redirect('sucess');
        }
    }

    /**
     * sucess method
     */
    public function sucess() {

    }

}
