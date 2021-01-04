<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('GoogleCharts', 'GoogleCharts.Lib');

/**
 * Negociacaos Controller
 */
class NegociacaosController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Negociação');
    }

    /**
     * index method
     */
    public function index() {

        $dadosUser = $this->Session->read();

        $conditions = array();
        $filter_status = '';

        $this->set('adminholding', $dadosUser['Auth']['User']['adminholding']);

        $status = array('E' => 'EM ANDAMENTO', 'F' => 'FINALIZADO', 'C' => 'CANCELADO');

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->Negociacao->recursive = 1;

        $this->Filter->addFilters(
                array(
                    'filter7' => array(
                        'Negociacao.id' => array(
                            'operator' => '=',
                        )
                    ),
                    'filter6' => array(
                        'Negociacaocorretor.corretor_id' => array(
                            'select' => $corretors
                        ),
                    ),
                    'filter1' => array(
                        'Negociacao.referencia' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter2' => array(
                        'Negociacao.cliente_vendedor' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter3' => array(
                        'Negociacao.cliente_comprador' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Negociacao.dt_ultima_etapa' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                    'filter5' => array(
                        'Negociacao.status' => array(
                            'select' => $status
                        ),
                    ),
                )
        );

        foreach ($this->Filter->getConditions() as $key => $item) :
            if ($key == 'Negociacao.status =') {
                $filter_status = 1;
            }
        endforeach;

        if (empty($filter_status)) {
            $conditions[] = 'Negociacao.status NOT IN (' . "'F', 'C'" . ')';
        }

        $this->Paginator->settings = array(
            'fields' => array('DISTINCT Negociacao.id', 'Negociacao.dtalerta', 'Negociacao.referencia', 'Negociacao.unidade', 'Negociacao.endereco', 'Negociacao.cliente_vendedor',
                'Negociacao.cliente_comprador', 'Negociacao.valor_imovel', 'Negociacao.valor_proposta', 'Negociacao.status', 'Negociacao.dt_ultima_etapa'),
            'joins' => array(
                array(
                    'table' => 'negociacaocorretors',
                    'alias' => 'Negociacaocorretor',
                    'type' => 'INNER',
                    'conditions' => [
                        'Negociacaocorretor.negociacao_id = Negociacao.id',
                    ],
                ),
            ),
            'order' => array('Negociacao.dt_ultima_etapa' => 'desc')
        );

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions(), $conditions));

        $this->set('negociacaos', $this->paginate());

        CakeSession::write('conditions_filtro', array($this->Filter->getConditions()));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Negociacao->id = $id;
        if (!$this->Negociacao->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Negociacao->recursive = 1;

        $negociacao = $this->Negociacao->read(null, $id);

        $this->set('negociacao', $negociacao);
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        $this->loadModel('Corretor');

        $corretors = $this->Corretor->find('list', array(
            'fields' => array('id', 'nome'),
            'conditions' => array('ativo' => 'S'),
            'order' => array('nome' => 'asc')
        ));
        $this->set('corretors', $corretors);

        $status = array('E' => 'EM ANDAMENTO');
        $this->set('status', $status);

        if ($this->request->is('post')) {

            $this->request->data['Negociacao']['user_id'] = $dadosUser['Auth']['User']['id'];
            $this->request->data['Negociacao']['valor_imovel'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['valor_imovel']));
            $this->request->data['Negociacao']['valor_proposta'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['valor_proposta']));
            $this->request->data['Negociacao']['created'] = date('Y-m-d H:i:s');
            $this->request->data['Negociacao']['modified'] = date('Y-m-d H:i:s');
            $this->request->data['Negociacao']['status'] = 'E';
            $this->request->data['Negociacao']['nota_imobiliaria'] = 'N';
            $this->request->data['Negociacao']['nota_corretor'] = 'N';

            try {

                $this->Negociacao->begin();

                $this->Negociacao->create();

                if ($this->Negociacao->save($this->request->data)) {
                    $negociacao_id = $this->Negociacao->getLastInsertId();

                    $this->Negociacao->id = $negociacao_id;
                    $this->Negociacao->saveField('dt_ultima_etapa', date('Y-m-d'));

                    foreach ($this->request->data['Negociacao']['corretor'] as $key => $item) :
                        $this->Negociacao->query('insert into public.negociacaocorretors(negociacao_id, corretor_id)'
                                . 'values(' . $negociacao_id . ',' . $item . ')');
                    endforeach;

                    $this->Negociacao->query('insert into public.negociacaohistoricos(negociacao_id, obs, created, user_id)'
                            . 'values(' . $negociacao_id . ',' . "'SEM PRÓXIMA ACAO'" . ',' . "'" . date('Y-m-d') . "'" . ',' . $dadosUser['Auth']['User']['id'] . ')');

                    $this->Negociacao->query('insert into public.negociacaostats(negociacao_id, status, obs, created, user_id)'
                            . 'values(' . $negociacao_id . ',' . "'E'" . ',' . "'" . $this->request->data['Negociacaostat']['obs'] . "'" . ',' . "'" . date('Y-m-d') . "'" . ',' . $dadosUser['Auth']['User']['id'] . ')');

                    $this->Negociacao->commit();

                    $this->Session->setFlash('Registro adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
                }
            } catch (Exception $id) {
                $this->Negociacao->rollback();
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $dadosUser = $this->Session->read();

        $this->loadModel('Corretor');

        $corretors = $this->Corretor->find('list', array(
            'fields' => array('id', 'nome'),
//            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome' => 'asc')
        ));
        $this->set(compact('corretors'));

        $this->Negociacao->id = $id;
        if (!$this->Negociacao->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $negociacao = $this->Negociacao->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {

            debug($this->request->data['Negociacao']['valor_imovel']);

            $this->request->data['Negociacao']['user_alt_id'] = $dadosUser['Auth']['User']['id'];
            $this->request->data['Negociacao']['modified'] = date('Y-m-d H:i:s');
            $this->request->data['Negociacao']['valor_imovel'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['valor_imovel']));
            $this->request->data['Negociacao']['valor_proposta'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['valor_proposta']));

            //validação campos
            $this->request->data['Negociacao']['honorarios'] = 0;
            $this->request->data['Negociacao']['perc_fechamento'] = 0;
            $this->request->data['Negociacao']['vgv_final'] = 0;
//            $this->request->data['Negociacao']['dtvenda'] = '';

            debug($this->request->data['Negociacao']['valor_imovel']);
//            die();

            if ($this->Negociacao->save($this->request->data)) {
                $this->Session->setFlash('Registro alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                debug($this->Negociacao->validationErrors); //show validationErrors
                debug($this->Negociacao->getDataSource()->getLog(false, false));
                die();

                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $negociacao['Negociacao']['valor_imovel'] = str_replace('.', ',', $negociacao['Negociacao']['valor_imovel']);
            $negociacao['Negociacao']['valor_proposta'] = str_replace('.', ',', $negociacao['Negociacao']['valor_proposta']);
            $this->request->data = $negociacao;
        }
    }

    /**
     * pagar method
     */
    public function pagar($id) {

        $dadosUser = $this->Session->read();

        $this->Negociacao->recursive = 0;

        $negociacao = $this->Negociacao->read(null, $id);

        $this->set('negociacao', $negociacao);

        $opcoes = array('N' => 'NÃO', 'S' => 'SIM');
        $this->set('opcoes', $opcoes);

        if ($this->request->is('post')) {

            $this->Negociacao->id = $id;

            $this->request->data['Negociacao']['honorarios'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['honorarios']));
            $this->request->data['Negociacao']['perc_fechamento'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['perc_fechamento']));
            $this->request->data['Negociacao']['vgv_final'] = str_replace(',', '.', str_replace('.', '', $this->request->data['Negociacao']['vgv_final']));
            $this->request->data['Negociacao']['dtvenda'] = substr($this->request->data['Negociacao']['dtvenda'], 6, 4) . "-" . substr($this->request->data['Negociacao']['dtvenda'], 3, 2) . "-" . substr($this->request->data['Negociacao']['dtvenda'], 0, 2);

            if ($this->Negociacao->save($this->request->data)) {

                //Insere contas a receber
                $this->request->data['Negociacao']['Contasreceber']['negociacao_id'] = $id;
                $this->request->data['Negociacao']['Contasreceber']['valor_total'] = $this->request->data['Negociacao']['honorarios'];
                $this->request->data['Negociacao']['Contasreceber']['status'] = 'A';
                $this->request->data['Negociacao']['Contasreceber']['user_id'] = $dadosUser['Auth']['User']['id'];
                $this->request->data['Negociacao']['Contasreceber']['created'] = date('Y-m-d H:i:s');

                $this->Negociacao->Contasreceber->save($this->request->data['Negociacao']['Contasreceber']);

                $this->Session->setFlash('Registro adicionado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Negociacaos', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Negociacao->id = $id;
        if (!$this->Negociacao->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Negociacao->delete()) {
            $this->Session->setFlash('Registro deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * relatorio_negociacaos method
     */
    public function relatorio_negociacaos() {

        $conditions_filtro = $this->Session->read('conditions_filtro');

        $conditions[] = 'Negociacao.status NOT IN (' . "'F', 'C'" . ')';

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->Contasreceber->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('DISTINCT Negociacao.id', 'Negociacao.cliente_vendedor', 'Negociacao.id', 'Negociacao.cliente_comprador', 'Negociacao.valor_proposta', 'Corretor.id', 'Corretor.nome'),
            'joins' => array(
                array(
                    'table' => 'negociacaocorretors',
                    'alias' => 'Negociacaocorretor',
                    'type' => 'LEFT',
                    'conditions' => array('Negociacaocorretor.negociacao_id = Negociacao.id')
                ),
                array(
                    'table' => 'corretors',
                    'alias' => 'Corretor',
                    'type' => 'LEFT',
                    'conditions' => array('Negociacaocorretor.corretor_id = Corretor.id')
                ),
            ),
            'limit' => '',
            'conditions' => array($conditions_filtro, $conditions),
            'order' => 'Corretor.nome asc, Negociacao.cliente_vendedor asc',
        );

        $this->set('negociacaos', $this->paginate());
    }

    /**
     * indicadores method
     */
    public function indicadores() {

        $piechart = new GoogleCharts();
        $piechart->type("PieChart");
        $piechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $piechart->columns(array(
            'status' => array(
                'type' => 'string',
                'label' => 'Status'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        $result = $this->Negociacao->query('select count(*) cont,
                                                   CASE WHEN status = ' . "'E'" . ' THEN' . "'EM ANDAMENTO'" . '
                                                        WHEN status = ' . "'A'" . 'THEN ' . "'ACEITO'" . '
                                                        WHEN status = ' . "'F'" . 'THEN ' . "'FINALIZADO'" . '
                                                        ELSE ' . "'CANCELADO'" . ' END as status
                                              from negociacaos
                                              group by status');

        foreach ($result as $key => $item) :
            $piechart->addRow(array('status' => $item[0]['status'], $item[0]['status'], 'cont' => $item[0]['cont']));
        endforeach;

        $this->set(compact('piechart'));

        //
        //VALOR EM PROPOSTAS
        //
        $piechart_proposta = new GoogleCharts();
        $piechart_proposta->type("PieChart");
        $piechart_proposta->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $piechart_proposta->columns(array(
            'status' => array(
                'type' => 'string',
                'label' => 'Status'
            ),
            'valor_proposta' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        $result = $this->Negociacao->query('select sum(valor_proposta) valor_proposta,
                                                   CASE WHEN status = ' . "'E'" . ' THEN' . "'EM ANDAMENTO'" . '
                                                        WHEN status = ' . "'A'" . 'THEN ' . "'ACEITO'" . '
                                                        WHEN status = ' . "'F'" . 'THEN ' . "'FINALIZADO'" . '
                                                        ELSE ' . "'CANCELADO'" . ' END as status
                                              from negociacaos
                                              group by status');

        foreach ($result as $key => $item) :
            $piechart_proposta->addRow(array('status' => $item[0]['status'], $item[0]['status'], 'valor_proposta' => round($item[0]['valor_proposta'], 2)));
        endforeach;

        $this->set(compact('piechart_proposta'));
    }

}
