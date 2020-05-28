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
                                                     bairro_preferencial_id  = ' . $this->request->data['Caracteristica']['bairro_preferencial_id'] . ',
                                                     obs                     = ' . "'" . $this->request->data['Caracteristica']['obs'] . "'" . '
                                               where id = ' . $id);
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

    /**
     * sucess method
     */
    public function perfil_leads() {

        $conditions = array();

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('id' => 'desc')));
        $this->set('origens', $origens);

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->loadModel('Operacaotipo');
        $operacaotipos = $this->Operacaotipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('operacaotipos', $operacaotipos);

        $this->loadModel('Bairro');
        $bairros = $this->Bairro->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('bairros', $bairros);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $imoveltipos);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $imoveltipos);

        $this->loadModel('Dormitorio');
        $dormitorios = $this->Dormitorio->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $dormitorios);

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
                        'Operacaotipo.id' => array(
                            'select' => $operacaotipos
                        ),
                    ),
                    'filter4' => array(
                        'Bairro.id' => array(
                            'select' => $bairros
                        ),
                    ),
                    'filter5' => array(
                        'Imoveltipo.id' => array(
                            'select' => $imoveltipos
                        ),
                    ),
                    'filter6' => array(
                        'Dormitorio.id' => array(
                            'select' => $dormitorios
                        ),
                    ),
                )
        );

        $this->Caracteristica->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Caracteristica.id', 'Lead.id', 'Origen.descricao', 'Cliente.nome', 'Cliente.telefone', 'Cliente.email', 'Caracteristica.valor_max',
                'Corretor.nome', 'Bairro.nome', 'Origen.descricao', 'Operacaotipo.descricao', 'Imoveltipo.descricao', 'Dormitorio.descricao'),
            'joins' => array(
                array(
                    'table' => 'leads',
                    'alias' => 'Lead',
                    'type' => 'INNER',
                    'conditions' => array('Caracteristica.lead_id = Lead.id')
                ),
                array(
                    'table' => 'clientes',
                    'alias' => 'Cliente',
                    'type' => 'INNER',
                    'conditions' => array('Lead.cliente_id = Cliente.id')
                ),
                array(
                    'table' => 'bairros',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array('Lead.bairro_preferencial_id = Bairro.id')
                ),
                array(
                    'table' => 'corretors',
                    'alias' => 'Corretor',
                    'type' => 'INNER',
                    'conditions' => array('Lead.corretor_id = Corretor.id')
                ),
                array(
                    'table' => 'importacaoleads',
                    'alias' => 'Importacaolead',
                    'type' => 'INNER',
                    'conditions' => array('Lead.importacaolead_id = Importacaolead.id')
                ),
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => array('Importacaolead.origen_id = Origen.id')
                ),
                array(
                    'table' => 'caracoperacaotipos',
                    'alias' => 'Caracoperacaotipo',
                    'type' => 'LEFT',
                    'conditions' => array('Caracteristica.id = Caracoperacaotipo.caracteristica_id')
                ),
                array(
                    'table' => 'operacaotipos',
                    'alias' => 'Operacaotipo',
                    'type' => 'LEFT',
                    'conditions' => array('Operacaotipo.id = Caracoperacaotipo.operacaotipo_id')
                ),
                array(
                    'table' => 'caracimoveltipos',
                    'alias' => 'Caracimoveltipo',
                    'type' => 'LEFT',
                    'conditions' => array('Caracteristica.id = Caracimoveltipo.caracteristica_id')
                ),
                array(
                    'table' => 'imoveltipos',
                    'alias' => 'Imoveltipo',
                    'type' => 'LEFT',
                    'conditions' => array('Imoveltipo.id = Caracimoveltipo.imoveltipo_id')
                ),
                array(
                    'table' => 'caracdormitorios',
                    'alias' => 'Caracdormitorio',
                    'type' => 'LEFT',
                    'conditions' => array('Caracteristica.id = Caracdormitorio.caracteristica_id')
                ),
                array(
                    'table' => 'dormitorios',
                    'alias' => 'Dormitorio',
                    'type' => 'LEFT',
                    'conditions' => array('Dormitorio.id = Caracdormitorio.dormitorio_id')
                ),
            ),
            'order' => array('Caracteristica.nome' => 'asc')
        );

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('caracteristicas', $this->Paginator->paginate('Caracteristica'));

        CakeSession::write('conditions_filtro', array($this->Filter->getConditions()));
    }

    /**
     * relatorio_contas_receber method
     */
    public function perfil_leads_graficos() {

        $conditions_filtro = $this->Session->read('conditions_filtro');

        //OPERAÇÃO (COMPRA, VENDA, LOCACAO)
        $result = $this->Caracteristica->query('select distinct operacaotipos.descricao, count(*) as cont
                                                  from caracteristicas,
                                                       operacaotipos,
                                                       caracoperacaotipos,
                                                       leads,
                                                       importacaoleads
                                                 where caracteristicas.id = caracoperacaotipos.caracteristica_id
                                                   and operacaotipos.id   = caracoperacaotipos.operacaotipo_id
                                                   and caracteristicas.lead_id = leads.id
                                                   and importacaoleads.id      = leads.importacaolead_id
                                                   and importacaoleads.origen_id = ' . $conditions_filtro[0]['Origen.id ='] . '
                                                 group by operacaotipos.descricao ');

        //
        //GRAFICO DE PIZZA
        //
        $operacaopiechart = new GoogleCharts();
        $operacaopiechart->type("PieChart");
        $operacaopiechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $operacaopiechart->columns(array(
            'descricao' => array(
                'type' => 'string',
                'label' => 'Empreendimento'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        foreach ($result as $key => $item) :
            $operacaopiechart->addRow(array('descricao' => $item[0]['descricao'], $item[0]['cont'], 'cont' => $item[0]['cont']));
        endforeach;

        $this->set(compact('operacaopiechart'));

        //SITUAÇÃO(PLANTA OU PRONTO)
        $result = $this->Caracteristica->query('select distinct imovelsituacaos.descricao, count(*) as cont
                                                  from caracteristicas,
                                                       imovelsituacaos,
                                                       caracimovelsituacaos,
                                                       leads,
                                                       importacaoleads
                                                 where caracteristicas.id        = caracimovelsituacaos.caracteristica_id
                                                   and imovelsituacaos.id        = caracimovelsituacaos.imovelsituacao_id
                                                   and caracteristicas.lead_id   = leads.id
                                                   and importacaoleads.id        = leads.importacaolead_id
                                                   and importacaoleads.origen_id = ' . $conditions_filtro[0]['Origen.id ='] . '
                                                 group by imovelsituacaos.descricao ');

        //
        //GRAFICO DE PIZZA
        //
        $situacaopiechart = new GoogleCharts();
        $situacaopiechart->type("PieChart");
        $situacaopiechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $situacaopiechart->columns(array(
            'descricao' => array(
                'type' => 'string',
                'label' => 'Empreendimento'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        foreach ($result as $key => $item) :
            $situacaopiechart->addRow(array('descricao' => $item[0]['descricao'], $item[0]['cont'], 'cont' => $item[0]['cont']));
        endforeach;

        $this->set(compact('situacaopiechart'));

        //TIPO DE IMOVEL(CASA, APARTAMENTO, TERRENO)
        $result = $this->Caracteristica->query('select distinct imoveltipos.descricao, count(*) as cont
                                                  from caracteristicas,
                                                       imoveltipos,
                                                       caracimoveltipos,
                                                       leads,
                                                       importacaoleads
                                                 where caracteristicas.id        = caracimoveltipos.caracteristica_id
                                                   and imoveltipos.id            = caracimoveltipos.imoveltipo_id
                                                   and caracteristicas.lead_id   = leads.id
                                                   and importacaoleads.id        = leads.importacaolead_id
                                                   and importacaoleads.origen_id = ' . $conditions_filtro[0]['Origen.id ='] . '
                                                 group by imoveltipos.descricao ');

        //
        //GRAFICO DE PIZZA
        //
        $tipopiechart = new GoogleCharts();
        $tipopiechart->type("PieChart");
        $tipopiechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $tipopiechart->columns(array(
            'descricao' => array(
                'type' => 'string',
                'label' => 'Empreendimento'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        foreach ($result as $key => $item) :
            $tipopiechart->addRow(array('descricao' => $item[0]['descricao'], $item[0]['cont'], 'cont' => $item[0]['cont']));
        endforeach;

        $this->set(compact('tipopiechart'));

        //DORMITORIOS NÚMERO
        $result = $this->Caracteristica->query('select distinct dormitorios.descricao, count(*) as cont
                                                  from caracteristicas,
                                                       dormitorios,
                                                       caracdormitorios,
                                                       leads,
                                                       importacaoleads
                                                 where caracteristicas.id        = caracdormitorios.caracteristica_id
                                                   and dormitorios.id            = caracdormitorios.dormitorio_id
                                                   and caracteristicas.lead_id   = leads.id
                                                   and importacaoleads.id        = leads.importacaolead_id
                                                   and importacaoleads.origen_id = ' . $conditions_filtro[0]['Origen.id ='] . '
                                                 group by dormitorios.descricao ');

        //
        //GRAFICO DE PIZZA
        //
        $dormitoriopiechart = new GoogleCharts();
        $dormitoriopiechart->type("PieChart");
        $dormitoriopiechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $dormitoriopiechart->columns(array(
            'descricao' => array(
                'type' => 'string',
                'label' => 'Empreendimento'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        foreach ($result as $key => $item) :
            $dormitoriopiechart->addRow(array('descricao' => $item[0]['descricao'], $item[0]['cont'], 'cont' => $item[0]['cont']));
        endforeach;

        $this->set(compact('dormitoriopiechart'));
    }

}
