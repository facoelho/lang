<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Contasrecebers Controller
 */
class ContasrecebersController extends AppController {

    function beforeFilter() {

    }

    /**
     * index method
     */
    public function index() {

        $this->set('title_for_layout', 'Contas receber');

        $filter_status = '';

        $status = array('A' => 'ABERTO', 'F' => 'FECHADO');

        $this->Filter->addFilters(
                array(
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
                    'filter6' => array(
                        'Negociacao.endereco' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Contasrecebermov.dtvencimento' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                    'filter7' => array(
                        'Contasrecebermov.dtpagamento' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                    'filter5' => array(
                        'Contasreceber.status' => array(
                            'select' => $status
                        ),
                    ),
                )
        );

        $this->Contasreceber->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('DISTINCT Contasreceber.id', 'Negociacao.id', 'Negociacao.cliente_vendedor', 'Negociacao.cliente_comprador', 'Negociacao.endereco', 'Negociacao.referencia', 'Contasreceber.status', 'Contasreceber.parcelas', 'Contasreceber.valor_total', 'User.nome', 'User.sobrenome'),
            'joins' => array(
                array(
                    'table' => 'contasrecebermovs',
                    'alias' => 'Contasrecebermov',
                    'type' => 'LEFT',
                    'conditions' => array('Contasreceber.id = Contasrecebermov.contasreceber_id')
                ),
            ),
            'limit' => 20,
            'order' => array('Contasreceber.id' => 'asc')
        );

        foreach ($this->Filter->getConditions() as $key => $item) :
            if ($key == 'Contasreceber.status =') {
                $filter_status = 1;
            }
        endforeach;

        if (empty($filter_status)) {
            $conditions[] = 'Contasreceber.status NOT IN (' . "'F'" . ')';
        }

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions(), $conditions));

        $this->set('contasrecebers', $this->paginate());

        CakeSession::write('conditions_filtro', array($this->Filter->getConditions()));
    }

    /**
     * relatorio_contas_receber method
     */
    public function relatorio_contas_receber($param = null) {

        $conditions_filtro = $this->Session->read('conditions_filtro');

        if (!empty($param)) {
            $conditions_filtro = 'Contasreceber.id = ' . $param;
        }

        $this->Contasreceber->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Negociacao.id', 'Negociacao.cliente_vendedor', 'Negociacao.cliente_comprador', 'Contasreceber.negociacao_id', 'Contasreceber.status', 'Contasreceber.parcelas', 'Contasreceber.valor_total', 'Contasrecebermov.contasreceber_id',
                'Contasrecebermov.valorparcela', 'Contasrecebermov.dtvencimento', 'Contasrecebermov.dtpagamento', 'Negociacaocorretor.corretor_id', 'Corretor.nome'),
            'joins' => array(
                array(
                    'table' => 'contasrecebermovs',
                    'alias' => 'Contasrecebermov',
                    'type' => 'LEFT',
                    'conditions' => array('Contasreceber.id = Contasrecebermov.contasreceber_id')
                ),
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
            'conditions' => $conditions_filtro,
            'limit' => '',
            'order' => array('Contasreceber.id' => 'asc', 'Contasrecebermov.dtvencimento' => 'asc')
        );

        $this->set('contasrecebers', $this->paginate());
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

        $dadosUser = $this->Session->read();

        $this->Contasreceber->id = $id;
        if (!$this->Contasreceber->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->Contasreceber->recursive = 0;

        $contasreceber = $this->Contasreceber->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['Contasreceber']['confirma'] == 'N') {
                $dadosFormulario = $this->request->data;
                $this->set('dadosFormulario', $dadosFormulario);
                CakeSession::write('dadosFormulario', $dadosFormulario);
                $this->render('lancarparcelas');
            } else {

                $this->Contasreceber->saveField('parcelas', $this->request->data['Contasreceber']['parcelas']);
                foreach ($this->request->data['dtvencimento'] as $key => $item) :
                    $this->Contasreceber->query('insert into contasrecebermovs(contasreceber_id, valorparcela, user_id, dtvencimento, created)
                                                  values(' . $id . ',' . str_replace(',', '.', $this->request->data['valorparcela'][$key]) . ',' . $dadosUser['Auth']['User']['id'] . ',' . "'" . substr($this->request->data['dtvencimento'][$key], 6, 4) . '-' . substr($this->request->data['dtvencimento'][$key], 3, 2) . '-' . substr($this->request->data['dtvencimento'][$key], 0, 2) . "'" . ',' . "'" . date('Y-m-d H:i') . "'" . ')');
                endforeach;

                $this->Session->setFlash('Parcelas lançadas com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $contasreceber;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Contasreceber->id = $id;
        if (!$this->Contasreceber->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Contasreceber->delete()) {
            $this->Session->setFlash('Contas a receber deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    public function pagar($id = null, $negociacao_id = null) {

        $dadosUser = $this->Session->read();

        $this->Contasreceber->id = $id;
        if (!$this->Contasreceber->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        //contasreceber_id
        $this->set('contasreceber_id', $id);
        //negociacao_id
        $this->set('negociacao_id', $negociacao_id);

        $this->Contasreceber->recursive = 0;

        $this->Paginator->settings = array(
            'fields' => array('Contasrecebermov.id', 'Contasrecebermov.valorparcela', 'Contasrecebermov.dtvencimento',
                'Contasrecebermov.dtpagamento', 'Lancamento.contasrecebermov_id', 'Contasrecebermov.contasreceber_id', 'Contasreceber.negociacao_id'),
            'joins' => array(
                array(
                    'table' => 'contasrecebermovs',
                    'alias' => 'Contasrecebermov',
                    'type' => 'INNER',
                    'conditions' => array('Contasrecebermov.contasreceber_id = Contasreceber.id')
                ),
                array(
                    'table' => 'lancamentos',
                    'alias' => 'Lancamento',
                    'type' => 'LEFT',
                    'conditions' => array('Lancamento.contasrecebermov_id = Contasrecebermov.id')
                ),
            ),
            'limit' => '',
            'conditions' => array('Contasreceber.id' => $id),
            'order' => array('Contasrecebermov.dtvencimento' => 'asc')
        );

        $this->set('contasrecebers', $this->Paginator->paginate('Contasreceber'));

        if ($this->request->is('post') || $this->request->is('put')) {

            try {

                $this->Contasreceber->begin();

                foreach ($this->request->data['valorparcela'] as $key => $item) :
                    $this->Contasreceber->query('update contasrecebermovs
                                                    set valorparcela = ' . str_replace(',', '.', $this->request->data['valorparcela'][$key]) . '
                                                  where id = ' . $key);
                endforeach;

                foreach ($this->request->data['dtvencimento'] as $key => $item) :
                    $this->Contasreceber->query('update contasrecebermovs
                                                    set dtvencimento = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . '-' . substr($item, 0, 2) . "'" . '
                                                  where id = ' . $key);
                endforeach;

                foreach ($this->request->data['dtpagamento'] as $key => $item) :

                    if (!empty($item)) {

                        //
                        //CRIA MOVIMENTACAO DE CONTAS A RECEBER
                        //

                        $this->Contasreceber->query('update contasrecebermovs
                                                        set dtpagamento  = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . '-' . substr($item, 0, 2) . "'" . '
                                                      where id = ' . $key);

                        $result = $this->Contasreceber->query('select count(*) cont from caixas where dtcaixa = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . '-' . substr($item, 0, 2) . "'");

                        if ($result[0][0]['cont'] == 0) {
                            $this->Contasreceber->query('insert into caixas(dtcaixa, created, user_id, empresa_id, status, saldo)
                                                     values(' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . '-' . substr($item, 0, 2) . "'" . ',' . "'" . date('Y-m-d H:i') . "'" . ',' . $dadosUser['Auth']['User']['id'] . ',' . $dadosUser['empresa_id'] . ',' . "'A'" . ',' . 0 . ')', false);

                            $caixa = $this->Contasreceber->query('select max(id) id from caixas', false);
                        } else {
                            $caixa = $this->Contasreceber->query('select id from caixas where dtcaixa = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . '-' . substr($item, 0, 2) . "'", false);
                        }

                        $this->Contasreceber->query('insert into lancamentos(caixa_id, descricao, valor, user_id, categoria_id, created, contasrecebermov_id)
                                                 values(' . $caixa[0][0]['id'] . ',' . "'" . 'RECEBIMENTO NEGOCIACAO CÓDIGO: ' . $negociacao_id . "'" . ',' . str_replace(',', '.', $this->request->data['valorparcela'][$key]) . ',' . $dadosUser['Auth']['User']['id'] . ',' . 77 . ',' . "'" . date('Y-m-d H:i') . "'" . ',' . $key . ')');
                    }
                endforeach;

                $result = $this->Contasreceber->query('select count(*) cont from contasrecebermovs where dtpagamento is null and contasreceber_id = ' . $id);

                if ($result[0][0]['cont'] == 0) {
                    $this->Contasreceber->query('update contasrecebers set status = ' . "'F'" . ' where id = ' . $id);
                }

                //
                //CRIA DESEMPENHO
                //

//                $corretors = $this->Contasreceber->query('select corretor_id cont from negociacaocorretors where negociacao_id = ' . $negociacao_id);
//
//                $result = $this->Contasreceber->query('select count(*) cont from desempenhos where anomes = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . "'");
//
//                if ($result[0][0]['cont'] == 0) {
//                    $this->Contasreceber->query('insert into desempenhos(anomes) values(' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . "'" . ')', false);
//                    $desempenho = $this->Contasreceber->query('select max(id) id from desempenhos');
//                } else {
//                    $desempenho = $this->Contasreceber->query('select id from desempenhos where anomes = ' . "'" . substr($item, 6, 4) . '-' . substr($item, 3, 2) . "'");
//                }
//
//                foreach ($corretors as $corretor) :
//                    $result = $this->Contasreceber->query('select count(*) cont where corretor_id = ' . $corretor[0]['corretor_id'] . ' and desempenho_id = ' . $desempenho[0][0]['id']);
//                    if ($result[0][0]['cont'] == 0) {
//                        $this->Contasreceber->query('insert into');
//                    }
//                endforeach;

                $this->Contasreceber->commit();

                $this->Session->setFlash('Pagamento lançado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } catch (Exception $id) {
                $this->Contasreceber->rollback();
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    public function add_parcela($contasreceber_id = null, $negociacao_id = null) {

        $dadosUser = $this->Session->read();

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->Contasreceber->query('insert into contasrecebermovs(contasreceber_id, valorparcela, user_id, created, dtvencimento)
                                          values(' . $contasreceber_id . ',' . str_replace(',', '.', $this->request->data['Contasreceber']['valorparcela']) . ',' . $dadosUser['Auth']['User']['id'] . ',' . "'" . date('Y-m-d H:i') . "'" . ',' . "'" . substr($this->request->data['Contasreceber']['dtvencimento'], 6, 4) . '-' . substr($this->request->data['Contasreceber']['dtvencimento'], 3, 2) . '-' . substr($this->request->data['Contasreceber']['dtvencimento'], 0, 2) . "'" . ')');

            $this->redirect(array('action' => 'pagar/' . $contasreceber_id . '/' . $negociacao_id));
        }
    }

    public function delete_parcela($contasrecebermov_id = null, $contasreceber_id = null, $negociacao_id = null) {

        $this->Contasreceber->query('delete from contasrecebermovs where id = ' . $contasrecebermov_id);

        $result = $this->Contasreceber->query('select count(*) cont from contasrecebermovs where contasreceber_id = ' . $contasreceber_id);

        $this->Contasreceber->query('update contasrecebers set parcelas = ' . $result[0][0]['cont'] . ' where id = ' . $contasreceber_id);

        $this->Session->setFlash('Parcela deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
        $this->redirect(array('action' => 'pagar/' . $contasreceber_id . '/' . $negociacao_id));
    }

    public function calcula_saldo($id = null) {
        $result = $this->Contasreceber->query('select sum(valorparcela) saldo
                                                 from contasrecebers, contasrecebermovs
                                                where contasrecebers.id = contasrecebermovs.contasreceber_id
                                                  and dtpagamento is null
                                                  and contasrecebers.id = ' . $id);

        return $result[0][0]['saldo'];
    }

    public function busca_parcelas($id = null) {
        $result = $this->Contasreceber->query('select dtvencimento, valorparcela, dtpagamento
                                                 from contasrecebers, contasrecebermovs
                                                where contasrecebers.id = contasrecebermovs.contasreceber_id
                                                  and contasrecebers.id = ' . $id . '
                                                order by dtvencimento');

        return $result;
    }

}
