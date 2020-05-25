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
        $this->Auth->allow('caracteristicas', 'lead_caracteristicas', 'sucess', 'corretor_sucess');
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
     * lead_caracteristicas method
     */
    public function lead_caracteristicas($id = null) {

        $result = $this->Caracteristica->query('select count(*) as cont from caracteristicas where lead_id = ' . $id);

        if ($result[0][0]['cont'] > 0) {
            $this->redirect('corretor_sucess');
        }

        $this->loadModel('Lead');
        $lead = $this->Lead->find('all', array(
            'fields' => array('Lead.id', 'Lead.obs_cliente', 'Lead.dt_alteracao', 'Importacaolead.created', 'Cliente.nome', 'Cliente.email', 'Origen.descricao', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone', 'Corretor.id', 'Corretor.nome'),
            'conditions' => array('Lead.id' => $id),
            'joins' => array(
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => [
                        'Origen.id = Importacaolead.origen_id',
                    ],
                ),
            ),
        ));

        $this->set('lead', $lead);

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

        $this->loadModel('Bairro');
        $bairros = $this->Bairro->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('bairros', $bairros);

        if ($this->request->is('post')) {

            $this->request->data['Caracteristica']['lead_id'] = $id;
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

                $this->Caracteristica->query('update leads
                                                 set dt_alteracao = ' . "'" . date('Y-m-d') . "'" . ',
                                          bairro_preferencial_id  = ' . $this->request->data['Caracteristica']['bairro_preferencial_id'] . 'where id = ' . $id);
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
            $this->redirect('corretor_sucess');
        }
    }

    /**
     * sucess method
     */
    public function corretor_sucess() {

    }

}
