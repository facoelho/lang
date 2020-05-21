<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('GoogleCharts', 'GoogleCharts.Lib');

App::uses('CakeEmail', 'Network/Email');

/**
 * Leads Controller
 */
class LeadsController extends AppController {

    var $components = array('Email');

    function beforeFilter() {
        $this->Auth->allow('qualify_lead_corretor');
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Lead->Importacaolead->recursive = 0;

        $leads = $this->Lead->find('all', array(
            'fields' => array('Lead.id', 'Lead.corretor_id', 'Lead.obs_cliente', 'Origen.descricao', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone', 'Corretor.nome'),
            'conditions' => array('Importacaolead.id' => $id),
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
            'order' => array('Cliente.nome' => 'asc')
        ));

        $this->set('leads', $leads);

        $this->loadModel('Corretor');

        $corretors = $this->Corretor->find('list', array(
            'fields' => array('id', 'nome'),
            'order' => array('nome' => 'asc')
        ));
        $this->set('corretors', $corretors);

        if ($this->request->is('post') || $this->request->is('put')) {

            try {

                $this->Lead->begin();

                foreach ($this->request->data['corretor_id'] as $key => $item) :
                    $this->Lead->id = $key;
                    $this->Lead->saveField('corretor_id', $item);
                endforeach;

                $this->Lead->commit();

                $this->Session->setFlash('Leads alterados com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Importacaoleads', 'action' => 'index'));
            } catch (Exception $id) {
                $this->Lead->rollback();
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $leads;
        }
    }

    /**
     * qualify method
     */
    public function qualify() {

        $this->set('title_for_layout', 'Qualificação leads');

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        $options = array('S' => 'Sim', 'N' => 'Não');
        $this->set('options', $options);

        if ($this->request->is('post') || $this->request->is('put')) {
            CakeSession::write('conditions', $this->request->data['Relatorio']);
            $this->redirect(array('action' => 'qualify_lead'));
        }
    }

    /**
     * qualify_lead method
     */
    public function qualify_lead() {

        $dadosUser = $this->Session->read();

        $alteracao = '';

        $envia_email = 0;

        $conditions_aux = $this->Session->read('conditions');

        $conditions = array('origen_id' => $conditions_aux['origen_id'], 'corretor_id' => $conditions_aux['corretor_id']);

        if (!empty($conditions_aux['sem_atendimento'])) {
            if ($conditions_aux['sem_atendimento'] == 'S') {
                $conditions['sem_atendimento'] = 'S';
            } else {
                $conditions['sem_atendimento'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_contato'])) {
            if ($conditions_aux['sem_contato'] == 'S') {
                $conditions['sem_contato'] = 'S';
            } else {
                $conditions['sem_contato'] = 'N';
            }
        }

        if (!empty($conditions_aux['ficha'])) {
            if ($conditions_aux['ficha'] == 'S') {
                $conditions['ficha'] = 'S';
            } else {
                $conditions['ficha'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_interesse'])) {
            if ($conditions_aux['sem_interesse'] == 'S') {
                $conditions['sem_interesse'] = 'S';
            } else {
                $conditions['sem_interesse'] = 'N';
            }
        }

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $temperatura = array('F' => 'Frio', 'M' => 'Morno', 'Q' => 'Quente');
        $this->set('temperatura', $temperatura);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $imoveltipos);

        $this->loadModel('Bairro');
        $bairros = $this->Bairro->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('bairros', $bairros);

        $this->Lead->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Lead.id', 'Origen.descricao', 'Corretor.id', 'Corretor.nome', 'Cliente.id', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone',
                'Lead.sem_contato', 'Lead.ficha', 'Lead.compra', 'Lead.preco', 'Lead.localizacao', 'Lead.bairro_preferencial_id', 'Lead.imoveltipo_id', 'Lead.obs', 'Lead.fone',
                'Lead.email', 'Lead.whats', 'Lead.material_enviado', 'Lead.sem_interesse', 'Lead.fone_tentativas', 'Lead.sem_atendimento', 'Lead.dt_alteracao', 'Importacaolead.created'),
            'joins' => array(
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.origen_id = Origen.id',
                    ],
                ),
            ),
            'conditions' => $conditions,
            'order' => array('Lead.id' => 'desc'),
            'limit' => '',
        );

        $this->set('leads', $this->Paginator->paginate('Lead'));

        if ($this->request->is('post') || $this->request->is('put')) {
            foreach ($this->request->data['id'] as $key => $value) :
                $this->Lead->id = $key;
                if ($this->request->data['corretor_id'][$key] > 0) {
                    $this->Lead->saveField('corretor_id', $this->request->data['corretor_id'][$key]);
                    $this->Lead->query('insert into public.transferleadcorretors(user_id, lead_id, corretor_old_id, corretor_new_id, created)
                                         values(' . $dadosUser['Auth']['User']['id'] . ',' . $key . ',' . $this->request->data['Lead']['corretor_id'] . ',' . $this->request->data['corretor_id'][$key] . ',' . "'" . date('Y-m-d H:i:s') . "'" . ')', false);

                    $alteracao_id = $this->Lead->query('select max(id) id from public.transferleadcorretors', false);

                    $alteracao[] = $alteracao_id[0][0]['id'];
                    $envia_email = 1;
                }
                if ($this->request->data['dt_alteracao'][$key] > 0) {
                    $this->Lead->saveField('dt_alteracao', date('Y-m-d'));
                }
                if ($this->request->data['fone'][$key] > 0) {
                    $this->Lead->saveField('fone', 'S');
                } else {
                    $this->Lead->saveField('fone', 'N');
                }
                if ($this->request->data['fone_tentativas'][$key] > 0) {
                    $this->Lead->saveField('fone_tentativas', $this->request->data['fone_tentativas'][$key]);
                } else {
                    $this->Lead->saveField('fone_tentativas', '');
                }
                if ($this->request->data['whats'][$key] > 0) {
                    $this->Lead->saveField('whats', 'S');
                } else {
                    $this->Lead->saveField('whats', 'N');
                }
                if ($this->request->data['email'][$key] > 0) {
                    $this->Lead->saveField('email', 'S');
                } else {
                    $this->Lead->saveField('email', 'N');
                }
                if ($this->request->data['sem_atendimento'][$key] > 0) {
                    $this->Lead->saveField('sem_atendimento', 'S');
                } else {
                    $this->Lead->saveField('sem_atendimento', 'N');
                }
                if ($this->request->data['sem_contato'][$key] > 0) {
                    $this->Lead->saveField('sem_contato', 'S');
                } else {
                    $this->Lead->saveField('sem_contato', 'N');
                }
                if ($this->request->data['material_enviado'][$key] > 0) {
                    $this->Lead->saveField('material_enviado', 'S');
                } else {
                    $this->Lead->saveField('material_enviado', 'N');
                }
                if ($this->request->data['sem_interesse'][$key] > 0) {
                    $this->Lead->saveField('sem_interesse', 'S');
                } else {
                    $this->Lead->saveField('sem_interesse', 'N');
                }
                if ($this->request->data['ficha'][$key] > 0) {
                    $this->Lead->saveField('ficha', 'S');
                } else {
                    $this->Lead->saveField('ficha', 'N');
                }
                if ($this->request->data['compra'][$key] > 0) {
                    $this->Lead->saveField('compra', 'S');
                } else {
                    $this->Lead->saveField('compra', 'N');
                }
                if ($this->request->data['preco'][$key] > 0) {
                    $this->Lead->saveField('preco', 'S');
                } else {
                    $this->Lead->saveField('preco', 'N');
                }
                if ($this->request->data['localizacao'][$key] > 0) {
                    $this->Lead->saveField('localizacao', 'S');
                } else {
                    $this->Lead->saveField('localizacao', 'N');
                }
                $this->Lead->saveField('bairro_preferencial_id', $this->request->data['bairro_preferencial_id'][$key]);
                $this->Lead->saveField('imoveltipo_id', $this->request->data['imoveltipo_id'][$key]);
                $this->Lead->saveField('obs', $this->request->data['obs'][$key]);
            endforeach;

            if ($envia_email > 0) {

                $Email = new CakeEmail();

                foreach ($alteracao as $key => $item) :
                    $result = $this->Lead->query('select clientes.nome as cliente, clientes.email, old.nome corretorold, new.nome corretornew
                                                    from clientes,
                                                         corretors new,
                                                         corretors old,
                                                         transferleadcorretors,
                                                         leads
                                                   where transferleadcorretors.corretor_old_id = old.id
                                                     and transferleadcorretors.corretor_new_id = new.id
                                                     and transferleadcorretors.lead_id = leads.id
                                                     and leads.cliente_id = clientes.id
                                                     and transferleadcorretors.id = ' . $item);

                    $mensagem[] = $result[0][0];
                endforeach;

                CakeSession::write('mensagem', $mensagem);

                $Email->template('alterar_corretor', null)
                        ->subject('Alterar corretor 🙂')
                        ->emailFormat('html')
                        ->to('rafaelpaiva74@gmail.com')
                        ->from(array('contato@eduardolang.com.br' => 'Eduardo Lang Imóveis'))
                        ->send();
            }
            $this->Session->setFlash('Leads qualificados com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'qualify'));
        }
    }

    /**
     * qualify_lead_corretor method
     */
    public function qualify_lead_corretor($id) {

        $this->set('id', $id);

        $dadosUser = $this->Session->read();

        $alteracao = '';

        $envia_email = 0;

        $conditions_aux = $this->Session->read('conditions');

        $conditions[] = array('Lead.id' => $id);

        if (!empty($conditions_aux['sem_atendimento'])) {
            if ($conditions_aux['sem_atendimento'] == 'S') {
                $conditions['sem_atendimento'] = 'S';
            } else {
                $conditions['sem_atendimento'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_contato'])) {
            if ($conditions_aux['sem_contato'] == 'S') {
                $conditions['sem_contato'] = 'S';
            } else {
                $conditions['sem_contato'] = 'N';
            }
        }

        if (!empty($conditions_aux['ficha'])) {
            if ($conditions_aux['ficha'] == 'S') {
                $conditions['ficha'] = 'S';
            } else {
                $conditions['ficha'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_interesse'])) {
            if ($conditions_aux['sem_interesse'] == 'S') {
                $conditions['sem_interesse'] = 'S';
            } else {
                $conditions['sem_interesse'] = 'N';
            }
        }

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $temperatura = array('F' => 'Frio', 'M' => 'Morno', 'Q' => 'Quente');
        $this->set('temperatura', $temperatura);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $imoveltipos);

        $this->loadModel('Bairro');
        $bairros = $this->Bairro->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('bairros', $bairros);

        $this->Lead->recursive = 0;

        $this->Paginator->settings = array(
            'fields' => array('Lead.id', 'Origen.descricao', 'Corretor.id', 'Corretor.nome', 'Cliente.id', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone',
                'Lead.sem_contato', 'Lead.ficha', 'Lead.compra', 'Lead.preco', 'Lead.localizacao', 'Lead.bairro_preferencial_id', 'Lead.imoveltipo_id', 'Lead.obs', 'Lead.fone',
                'Lead.email', 'Lead.whats', 'Lead.material_enviado', 'Lead.sem_interesse', 'Lead.fone_tentativas', 'Lead.sem_atendimento', 'Lead.dt_alteracao', 'Importacaolead.created'),
            'joins' => array(
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.origen_id = Origen.id',
                    ],
                ),
            ),
            'conditions' => $conditions,
            'order' => array('Lead.id' => 'desc'),
            'limit' => '',
        );

        $this->set('leads', $this->Paginator->paginate('Lead'));

        if ($this->request->is('post') || $this->request->is('put')) {
            foreach ($this->request->data['id'] as $key => $value) :
                $this->Lead->id = $key;

                $this->Lead->saveField('dt_alteracao', date('Y-m-d'));

                if ($this->request->data['fone'][$key] > 0) {
                    $this->Lead->saveField('fone', 'S');
                } else {
                    $this->Lead->saveField('fone', 'N');
                }
                if ($this->request->data['fone_tentativas'][$key] > 0) {
                    $this->Lead->saveField('fone_tentativas', $this->request->data['fone_tentativas'][$key]);
                } else {
                    $this->Lead->saveField('fone_tentativas', '');
                }
                if ($this->request->data['whats'][$key] > 0) {
                    $this->Lead->saveField('whats', 'S');
                } else {
                    $this->Lead->saveField('whats', 'N');
                }
                if ($this->request->data['email'][$key] > 0) {
                    $this->Lead->saveField('email', 'S');
                } else {
                    $this->Lead->saveField('email', 'N');
                }
                if ($this->request->data['sem_atendimento'][$key] > 0) {
                    $this->Lead->saveField('sem_atendimento', 'S');
                } else {
                    $this->Lead->saveField('sem_atendimento', 'N');
                }
                if ($this->request->data['sem_contato'][$key] > 0) {
                    $this->Lead->saveField('sem_contato', 'S');
                } else {
                    $this->Lead->saveField('sem_contato', 'N');
                }
                if ($this->request->data['material_enviado'][$key] > 0) {
                    $this->Lead->saveField('material_enviado', 'S');
                } else {
                    $this->Lead->saveField('material_enviado', 'N');
                }
                if ($this->request->data['sem_interesse'][$key] > 0) {
                    $this->Lead->saveField('sem_interesse', 'S');
                } else {
                    $this->Lead->saveField('sem_interesse', 'N');
                }
                if ($this->request->data['ficha'][$key] > 0) {
                    $this->Lead->saveField('ficha', 'S');
                } else {
                    $this->Lead->saveField('ficha', 'N');
                }
                if ($this->request->data['compra'][$key] > 0) {
                    $this->Lead->saveField('compra', 'S');
                } else {
                    $this->Lead->saveField('compra', 'N');
                }
                if ($this->request->data['preco'][$key] > 0) {
                    $this->Lead->saveField('preco', 'S');
                } else {
                    $this->Lead->saveField('preco', 'N');
                }
                if ($this->request->data['localizacao'][$key] > 0) {
                    $this->Lead->saveField('localizacao', 'S');
                } else {
                    $this->Lead->saveField('localizacao', 'N');
                }
                $this->Lead->saveField('bairro_preferencial_id', $this->request->data['bairro_preferencial_id'][$key]);
                $this->Lead->saveField('imoveltipo_id', $this->request->data['imoveltipo_id'][$key]);
                $this->Lead->saveField('obs', $this->request->data['obs'][$key]);
            endforeach;

            $this->Session->setFlash('Lead qualificado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'qualify_lead_corretor/' . $id));
        }
    }

    /**
     * relatorio_leads_corretor method
     */
    public function relatorio_leads_corretor() {

        $conditions_aux = $this->Session->read('conditions');

        $conditions = array('origen_id' => $conditions_aux['origen_id'], 'corretor_id' => $conditions_aux['corretor_id']);

        if (!empty($conditions_aux['sem_atendimento'])) {
            if ($conditions_aux['sem_atendimento'] == 'S') {
                $conditions['sem_atendimento'] = 'S';
            } else {
                $conditions['sem_atendimento'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_contato'])) {
            if ($conditions_aux['sem_contato'] == 'S') {
                $conditions['sem_contato'] = 'S';
            } else {
                $conditions['sem_contato'] = 'N';
            }
        }

        if (!empty($conditions_aux['ficha'])) {
            if ($conditions_aux['ficha'] == 'S') {
                $conditions['ficha'] = 'S';
            } else {
                $conditions['ficha'] = 'N';
            }
        }

        if (!empty($conditions_aux['sem_interesse'])) {
            if ($conditions_aux['sem_interesse'] == 'S') {
                $conditions['sem_interesse'] = 'S';
            } else {
                $conditions['sem_interesse'] = 'N';
            }
        }

        $temperatura = array('F' => 'Frio', 'M' => 'Morno', 'Q' => 'Quente');
        $this->set('temperatura', $temperatura);

        $this->loadModel('Imoveltipo');
        $imoveltipos = $this->Imoveltipo->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('imoveltipos', $imoveltipos);

        $this->Lead->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Lead.id', 'Origen.descricao', 'Corretor.nome', 'Cliente.id', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone',
                'Lead.sem_atendimento', 'Lead.sem_contato', 'Lead.ficha', 'Lead.compra', 'Lead.preco', 'Lead.localizacao', 'Lead.imoveltipo_id', 'Lead.obs', 'Lead.fone', 'Lead.email', 'Lead.whats', 'Lead.material_enviado'),
            'joins' => array(
                array(
                    'table' => 'origens',
                    'alias' => 'Origen',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.origen_id = Origen.id',
                    ],
                ),
            ),
            'conditions' => $conditions,
            'order' => array('Cliente.nome' => 'asc'),
            'limit' => '',
        );

        $this->set('leads', $this->Paginator->paginate('Lead'));
    }

    /**
     * leads_corretor method
     */
    public function leads_corretor() {

        $this->set('title_for_layout', 'Leads/Corretor');

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        $tipo = array('DL' => 'DISTRIBUIÇÃO LEADS', 'CC' => 'CONTATO COM CLIENTE', 'D' => 'DESEMPENHO');
        $this->set('tipo', $tipo);

        $formato = array('C' => 'CORRETOR', 'T' => 'TIPO');
        $this->set('formato', $formato);

        $grafico = array('B' => 'Barras', 'L' => 'Linhas', 'P' => 'Pizza');
        $this->set('grafico', $grafico);

        if ($this->request->is('post') || $this->request->is('put')) {

            CakeSession::write('corretors', $this->request->data['Relatorio']['corretor']);
            CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
            CakeSession::write('grafico', $this->request->data['Relatorio']['grafico']);

            if ($this->request->data['Relatorio']['tipo'] == 'DL') {

                if ((empty($this->request->data['Relatorio']['dtinicio'])) or ( empty($this->request->data['Relatorio']['dtfim']))) {
                    $this->Session->setFlash('Período obrigatório.', 'default', array('class' => 'mensagem_erro'));
                    return;
                }
                $periodo['dtinicio'] = substr($this->request->data['Relatorio']['dtinicio'], 6, 4) . '-' . substr($this->request->data['Relatorio']['dtinicio'], 3, 2) . '-' . substr($this->request->data['Relatorio']['dtinicio'], 0, 2) . ' 00:00:00';
                $periodo['dtfim'] = substr($this->request->data['Relatorio']['dtfim'], 6, 4) . '-' . substr($this->request->data['Relatorio']['dtfim'], 3, 2) . '-' . substr($this->request->data['Relatorio']['dtfim'], 0, 2) . ' 23:59:59';
                CakeSession::write('periodo', $periodo);

                if ($this->request->data['Relatorio']['grafico'] == 'L') {
                    $this->redirect(array('action' => 'leads_corretor_linhas'));
                } elseif ($this->request->data['Relatorio']['grafico'] == 'P') {
                    $this->redirect(array('action' => 'leads_corretor_pizza'));
                } elseif ($this->request->data['Relatorio']['grafico'] == 'B') {
                    $this->redirect(array('action' => 'leads_corretor_barras'));
                }
                // Gráficos de DESEMPENHO
            } elseif ($this->request->data['Relatorio']['tipo'] == 'CC') {
                if ($this->request->data['Relatorio']['grafico'] == 'B') {
                    if ($this->request->data['Relatorio']['formato'] == 'C') {
                        $this->redirect(array('action' => 'desempenho_barras'));
                    } else {
                        $this->redirect(array('action' => 'desempenho_barras_consolidado'));
                    }
                } elseif ($this->request->data['Relatorio']['grafico'] == 'P') {
                    if ($this->request->data['Relatorio']['formato'] == 'C') {
                        $this->redirect(array('action' => 'desempenho_pizza'));
                    } else {
                        $this->redirect(array('action' => 'desempenho_pizza_consolidado'));
                    }
                }
                // Gráficos de APROVEITAMENTO
            } elseif ($this->request->data['Relatorio']['tipo'] == 'D') {
                if ($this->request->data['Relatorio']['grafico'] == 'B') {
                    $this->redirect(array('action' => 'aproveitamento_barras'));
                }
            }
        }
    }

    /**
     * leads_corretor_grafico method
     */
    public function leads_corretor_linhas() {

        $cont = 0;
        $corretors = '';
        $origen_id = $this->Session->read('origen_id');
        $periodo = $this->Session->read('periodo');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $corretors = $this->Lead->query('select DISTINCT corretors.id, corretors.nome
                                           from corretors,
                                                leads,
                                                importacaoleads
                                          where corretors.id = leads.corretor_id
                                            and importacaoleads.id = leads.importacaolead_id
                                            and importacaoleads.origen_id in (' . $origen_id . ')
                                          order by nome');

        $this->set('corretors', $corretors);

        foreach ($corretors as $corretor) {

            $datas = array();
            $columns_linha = array();

            $result = $this->Lead->query('select nome,
                                             to_char(created, ' . "'dd/mm/yyyy'" . ') as data' . ',
                                             count(leads.id) as cont
                                        from corretors,
                                             leads,
                                             importacaoleads
                                       where corretors.id = leads.corretor_id
                                         and importacaoleads.id = leads.importacaolead_id
                                         and importacaoleads.created between ' . "'" . $periodo['dtinicio'] . "'" . ' and ' . "'" . $periodo['dtfim'] . "'" . '
                                         and importacaoleads.origen_id in (' . $origen_id . ')
                                         and corretors.id in (' . $corretor[0]['id'] . ')
                                       group by nome, created
                                       order by nome, created asc');

            $columns_linha['data'] = array('type' => 'string', 'label' => 'Data');
            foreach ($result as $key => $item) :
                $datas[$key] = $item;
                $columns_linha[$item[0]['nome']] = array('type' => 'number', 'label' => $item[0]['nome']);
                $columns_linha[] = array('type' => 'number', 'role' => 'annotation');
            endforeach;

            $column_chart_linha[$cont] = new GoogleCharts();

            $column_chart_linha[$cont]->type('AreaChart');

            $column_chart_linha[$cont]->options(array(
                'width' => '80%',
                'heigth' => '70%',
                'title' => '',
                'vAxis' => array('minValue' => 0),
                'titleTextStyle' => array('color' => 'grenn'),
                'fontSize' => 12,
            ));

            $column_chart_linha[$cont]->columns($columns_linha);

            foreach ($datas as $chave => $data):
                foreach ($result as $key => $item) :
                    if ($data[0]['data'] == $item[0]['data']) {
                        $string = array();
                        $string['data'] = $item[0]['data'];
                        $string[$item[0]['nome']] = $item[0]['cont'];
                        $string[] = $item[0]['cont'];
                        $column_chart_linha[$cont]->addRow($string);
                    }
                endforeach;
            endforeach;

            $this->set(compact('column_chart_linha'));

            $cont++;
        }

        $this->set('cont', $cont);
    }

    /**
     * leads_corretor_grafico method
     */
    public function leads_corretor_barras() {

        $cont = 0;
        $corretors = '';
        $origen_id = $this->Session->read('origen_id');
        $periodo = $this->Session->read('periodo');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $corretors = $this->Lead->query('select DISTINCT corretors.id, corretors.nome
                                           from corretors,
                                                leads,
                                                importacaoleads
                                          where corretors.id = leads.corretor_id
                                            and importacaoleads.id = leads.importacaolead_id
                                            and importacaoleads.origen_id in (' . $origen_id . ')
                                          order by nome');

        $this->set('corretors', $corretors);

        foreach ($corretors as $corretor) {

            $datas = array();
            $columns_linha = array();

            $result = $this->Lead->query('select nome,
                                                to_char(created, ' . "'dd/mm/yyyy'" . ') as data' . ',
                                                count(leads.id) as cont
                                           from corretors,
                                                leads,
                                                importacaoleads
                                          where corretors.id = leads.corretor_id
                                            and importacaoleads.id = leads.importacaolead_id
                                            and importacaoleads.created between ' . "'" . $periodo['dtinicio'] . "'" . ' and ' . "'" . $periodo['dtfim'] . "'" . '
                                            and importacaoleads.origen_id in (' . $origen_id . ')
                                            and corretors.id in (' . $corretor[0]['id'] . ')
                                          group by nome, created
                                          order by nome, created');

            $columns_linha['data'] = array('type' => 'string', 'label' => 'Data');
            foreach ($result as $key => $item) :
                $datas[$key] = $item;
                $columns_linha[$item[0]['nome']] = array('type' => 'number', 'label' => $item[0]['nome']);
                $columns_linha[] = array('type' => 'number', 'role' => 'annotation');
            endforeach;

            $column_chart_linha[$cont] = new GoogleCharts();

            $column_chart_linha[$cont]->type('ColumnChart');

            $column_chart_linha[$cont]->options(array(
                'width' => '80%',
                'heigth' => '70%',
                'title' => '',
                'vAxis' => array('minValue' => 0),
                'titleTextStyle' => array('color' => 'grenn'),
                'fontSize' => 12,
            ));

            $column_chart_linha[$cont]->columns($columns_linha);

            foreach ($datas as $chave => $data):
                foreach ($result as $key => $item) :
                    if ($data[0]['data'] == $item[0]['data']) {
                        $string = array();
                        $string['data'] = $item[0]['data'];
                        $string[$item[0]['nome']] = $item[0]['cont'];
                        $string[] = $item[0]['cont'];
                        $column_chart_linha[$cont]->addRow($string);
                    }
                endforeach;
            endforeach;

            $this->set(compact('column_chart_linha'));

            $cont++;
        }

        $this->set('cont', $cont);
    }

    /**
     * desempenho_barras method
     */
    public function desempenho_barras() {

        $origen_id = $this->Session->read('origen_id');
        $corretors = $this->Session->read('corretors');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $cont = 0;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'tipo');
        $result = $this->busca_desempenho($origen_id, 1); // qualquer código de corretor, para somente buscar os parametros

        foreach ($result as $key => $item) :
            $columns_barras[$key] = array('type' => 'number', 'label' => $key);
            $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        if (!empty($corretors)) {

            foreach ($corretors as $key => $corretor) :

                $string = array();

                $column_chart_barras[$cont] = new GoogleCharts();

                $column_chart_barras[$cont]->type('ColumnChart');

                $column_chart_barras[$cont]->options(array(
                    'width' => '80%',
                    'heigth' => '70%',
                    'title' => '',
                    'vAxis' => array('minValue' => 0),
                    'titleTextStyle' => array('color' => 'grenn'),
                    'fontSize' => 12,
                ));

                $column_chart_barras[$cont]->columns($columns_barras);

                $result = $this->busca_desempenho($origen_id, $corretor);

                foreach ($result as $key => $valor) :
                    $string[$key] = $valor;
                    $string[] = $valor;
                endforeach;

                $column_chart_barras[$cont]->addRow($string);

                $cont++;

            endforeach;

            $this->set(compact('column_chart_barras'));

            $this->set('cont', $cont);
            $this->set('corretors', $corretors);
        }
    }

    /**
     * desempenho_barras method
     */
    public function desempenho_barras_consolidado() {

        $origen_id = $this->Session->read('origen_id');
        $corretors_aux = $this->Session->read('corretors');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $params = array('sem_atendimento' => 'sem_atendimento', 'fone' => 'fone', 'whats' => 'whats', 'material_enviado' => 'material_enviado', 'sem_interesse' => 'sem_interesse', 'email' => 'Leads.email', 'sem_contato' => 'sem_contato', 'ficha' => 'ficha', 'compra' => 'compra', 'preco' => 'preco', 'localizacao' => 'localizacao');

        foreach ($corretors_aux as $key => $corretor) :
            if (empty($corretors)) {
                $corretors .= $corretor;
            } else {
                $corretors .= ',' . $corretor;
            }
        endforeach;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Data');
        foreach ($corretors_aux as $key => $item) :
            $nome = $this->busca_nome_corretor($item);
            $columns_barras[$nome] = array('type' => 'number', 'label' => $nome);
//            $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        $column_chart_barras = new GoogleCharts();

        $column_chart_barras->type('ColumnChart');

        $column_chart_barras->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_barras->columns($columns_barras);

        foreach ($params as $key => $param) :

            $string = '';
            $string_fim = '';
            $string['data'] = $param;

            $result = $this->busca_desempenho_consolidado($origen_id, $corretors, $param);

            foreach ($result as $k => $item):
                $string[$item[0]['nome']] = $item[0]['count'];
//                $string[] = $item[0]['count'];
            endforeach;
            $string_fim[] = $string;
            $column_chart_barras->addRow($string_fim[0]);
            $this->set(compact('column_chart_barras'));
        endforeach;

        $this->set('corretors', $corretors);
    }

    /**
     * leads_corretor_grafico method
     */
    public function leads_corretor_pizza() {

        $contador = 0;
        $corretors = '';
        $origen_id = $this->Session->read('origen_id');
        $periodo = $this->Session->read('periodo');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        //
        //GRAFICO DE PIZZA
        //

        $piechart = new GoogleCharts();
        $piechart->type("PieChart");
        $piechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $piechart->columns(array(
            'nome' => array(
                'type' => 'string',
                'label' => 'Nome'
            ),
            'cont' => array(
                'type' => 'number',
                'label' => 'Quantidade',
                'format' => '#,###',
                'role' => 'annotation'
            )
        ));

        $result = $this->Lead->query('select nome,
                                             count(leads.id) as cont
                                        from corretors,
                                             leads,
                                             importacaoleads
                                       where corretors.id = leads.corretor_id
                                         and importacaoleads.id = leads.importacaolead_id
                                         and importacaoleads.created between ' . "'" . $periodo['dtinicio'] . "'" . ' and ' . "'" . $periodo['dtfim'] . "'" . '
                                         and importacaoleads.origen_id in (' . $origen_id . ')
                                        group by nome
                                        order by nome');

        foreach ($result as $item) {
            $piechart->addRow(array('nome' => $item[0]['nome'], $item[0]['cont'], 'cont' => $item[0]['cont']));
        }

        $this->set(compact('piechart'));
    }

    /**
     * desempenho_pizza method
     */
    public function desempenho_pizza() {

        $origen_id = $this->Session->read('origen_id');
        $corretors = $this->Session->read('corretors');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $cont = 0;

        if (!empty($corretors)) {

            foreach ($corretors as $key => $corretor) :
                //
                //GRAFICO DE PIZZA
                //

                $piechart[$cont] = new GoogleCharts();
                $piechart[$cont]->type("PieChart");
                $piechart[$cont]->options(array(
                    'width' => '80%',
                    'title' => '',
                    'titleTextStyle' => array('color' => 'blue'),
                    'fontSize' => 12));
                $piechart[$cont]->columns(array(
                    'nome' => array(
                        'type' => 'string',
                        'label' => 'Nome'
                    ),
                    'cont' => array(
                        'type' => 'number',
                        'label' => 'Quantidade',
                        'format' => '#,###',
                        'role' => 'annotation'
                    )
                ));

                $result = $this->busca_desempenho_sem_total($origen_id, $corretor);
                foreach ($result as $key => $valor) :
                    $piechart[$cont]->addRow(array('nome' => $key, $valor, 'cont' => $valor));
                endforeach;

                $this->set(compact('piechart'));

                $cont++;

            endforeach;

            $this->set('cont', $cont);
            $this->set('corretors', $corretors);
        }
    }

    /**
     * desempenho_pizza method
     */
    public function desempenho_pizza_consolidado() {

        $origen_id = $this->Session->read('origen_id');
        $corretors_aux = $this->Session->read('corretors');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $cont = 0;

        $params = array('fone' => 'fone', 'whats' => 'whats', 'material_enviado' => 'material_enviado', 'sem_interesse' => 'sem_interesse', 'email' => 'Leads.email', 'sem_contato' => 'sem_contato', 'ficha' => 'ficha', 'compra' => 'compra', 'preco' => 'preco', 'localizacao' => 'localizacao');

        foreach ($corretors_aux as $key => $corretor) :
            if (empty($corretors)) {
                $corretors .= $corretor;
            } else {
                $corretors .= ',' . $corretor;
            }
        endforeach;

        if (!empty($corretors)) {

            foreach ($params as $key => $param) :
                //
                //GRAFICO DE PIZZA
                //

                $piechart[$cont] = new GoogleCharts();
                $piechart[$cont]->type("PieChart");
                $piechart[$cont]->options(array(
                    'width' => '80%',
                    'title' => '',
                    'titleTextStyle' => array('color' => 'blue'),
                    'fontSize' => 12));
                $piechart[$cont]->columns(array(
                    'nome' => array(
                        'type' => 'string',
                        'label' => 'Nome'
                    ),
                    'cont' => array(
                        'type' => 'number',
                        'label' => 'Quantidade',
                        'format' => '#,###',
                        'role' => 'annotation'
                    )
                ));

                $result = $this->busca_desempenho_consolidado($origen_id, $corretors, $param);
                foreach ($result as $key => $item) :
                    $piechart[$cont]->addRow(array('nome' => $item[0]['nome'], $item[0]['count'], 'cont' => $item[0]['count']));
                endforeach;

                $params_aux[$cont] = $param;
                $cont++;

            endforeach;

            $this->set(compact('piechart'));
            $this->set('cont', $cont);
            $this->set('corretors', $corretors);
            $this->set('params_aux', $params_aux);
        }
    }

    /**
     * desempenho_barras method
     */
    public function aproveitamento_barras() {

        $origen_id = $this->Session->read('origen_id');
        $corretors = $this->Session->read('corretors');

        $origen = $this->Lead->query('select descricao from origens where id = ' . $origen_id);
        $this->set('origen', $origen);

        $cont = 0;

        $columns_ficha_barras['data'] = array('type' => 'string', 'label' => 'Ficha');
        foreach ($corretors as $key => $item) :
            $nome = $this->busca_nome_corretor($item);
            $columns_ficha_barras[$nome] = array('type' => 'number', 'label' => $nome);
            $columns_ficha_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        $column_chart_ficha_barras = new GoogleCharts();

        $column_chart_ficha_barras->type('ColumnChart');

        $column_chart_ficha_barras->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_ficha_barras->columns($columns_ficha_barras);
        $string = array();
        foreach ($corretors as $key => $corretor) :
            $nome = $this->busca_nome_corretor($corretor);
            $total = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and corretor_id = ' . $corretor . '
                                            and importacaoleads.origen_id = ' . $origen_id);

            $aproveitamento = $this->Lead->query('select count(*) as cont' . '
                                                    from leads, importacaoleads, corretors
                                                   where leads.importacaolead_id = importacaoleads.id
                                                     and corretors.id = leads.corretor_id
                                                     and corretor_id = ' . $corretor . '
                                                     and ficha = ' . "'S'" . '
                                                     and importacaoleads.origen_id = ' . $origen_id);

            if ($aproveitamento[0][0]['cont'] > 0) {
                $string[$nome] = round((($aproveitamento[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
                $string[] = round((($aproveitamento[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
            } else {
                $string[$nome] = 0;
                $string[] = 0;
            }
        endforeach;

        $column_chart_ficha_barras->addRow($string);

        $this->set(compact('column_chart_ficha_barras'));

        //DESEMPENHO EM COMPRA
        $columns_compra_barras['data'] = array('type' => 'string', 'label' => 'Ficha');
        foreach ($corretors as $key => $item) :
            $nome = $this->busca_nome_corretor($item);
            $columns_compra_barras[$nome] = array('type' => 'number', 'label' => $nome);
            $columns_compra_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        $column_chart_compra_barras = new GoogleCharts();

        $column_chart_compra_barras->type('ColumnChart');

        $column_chart_compra_barras->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_compra_barras->columns($columns_compra_barras);
        $string = array();
        foreach ($corretors as $key => $corretor) :
            $nome = $this->busca_nome_corretor($corretor);
            $total = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and corretor_id = ' . $corretor . '
                                            and importacaoleads.origen_id = ' . $origen_id);

            $aproveitamento = $this->Lead->query('select count(*) as cont' . '
                                                    from leads, importacaoleads, corretors
                                                   where leads.importacaolead_id = importacaoleads.id
                                                     and corretors.id = leads.corretor_id
                                                     and corretor_id = ' . $corretor . '
                                                     and compra = ' . "'S'" . '
                                                     and importacaoleads.origen_id = ' . $origen_id);

            if ($aproveitamento[0][0]['cont'] > 0) {
                $string[$nome] = round((($aproveitamento[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
                $string[] = round((($aproveitamento[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
            } else {
                $string[$nome] = 0;
                $string[] = 0;
            }
        endforeach;

        $column_chart_compra_barras->addRow($string);

        $this->set(compact('column_chart_compra_barras'));
    }

    /**
     * leads_empreendimentos method
     */
    public function leads_empreendimentos() {

        $this->set('title_for_layout', 'Leads/Empreendimento');

        $dadosUser = $this->Session->read();

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'N'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'conditions' => array('compoem_indicador' => 'S'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        if ($dadosUser['Auth']['User']['adminholding'] == 1) {
            $tipo = array('CE' => 'CORRETOR POR EMPREENDIMENTO', 'DE' => 'DESEMPENHO EMPREENDIMENTO', 'PE' => 'PERCENTUAL GERAL POR EMPREENDIMENTO', 'PG' => 'PERCENTUAL GERAL', 'CL' => 'CONVERSÃO FINANCEIRA DOS LEADS');
        } else {
            $tipo = array('CE' => 'CORRETOR POR EMPREENDIMENTO', 'DE' => 'DESEMPENHO EMPREENDIMENTO', 'PE' => 'PERCENTUAL GERAL POR EMPREENDIMENTO', 'PG' => 'PERCENTUAL GERAL');
        }

        $this->set('tipo', $tipo);

        $grafico = array('B' => 'Barras', 'P' => 'Pizza');
        $this->set('grafico', $grafico);

        if ($this->request->is('post') || $this->request->is('put')) {
            CakeSession::write('corretor_id', $this->request->data['Relatorio']['corretor_id']);
            CakeSession::write('grafico', $this->request->data['Relatorio']['grafico']);
            if ($this->request->data['Relatorio']['tipo'] == 'CE') {
                CakeSession::write('origen_id', $this->request->data['Relatorio']['origenaux']);
                $this->redirect(array('action' => 'leads_corretor_empreedimento'));
            } else if ($this->request->data['Relatorio']['tipo'] == 'DE') {
                CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
                if ($this->request->data['Relatorio']['grafico'] == 'B') {
                    $this->redirect(array('action' => 'leads_desempenho_empreedimento_barras'));
                } else {
                    $this->redirect(array('action' => 'leads_desempenho_empreedimento_pizza'));
                }
            } else if ($this->request->data['Relatorio']['tipo'] == 'PE') {
                CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
                $this->redirect(array('action' => 'leads_empreedimento_percentual'));
            } else if ($this->request->data['Relatorio']['tipo'] == 'PG') {
                CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
                $this->redirect(array('action' => 'leads_empreedimento_percentual_geral'));
            } else if ($this->request->data['Relatorio']['tipo'] == 'CL') {
                CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
                $this->redirect(array('action' => 'leads_empreendimento_conversao'));
            }
        }
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_corretor_empreedimento() {

        $origens = $this->Session->read('origen_id');
        $corretor_id = $this->Session->read('corretor_id');

        $nome = $this->busca_nome_corretor($corretor_id);
        $this->set('nome', $nome);

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Empreendimento');
        foreach ($origens as $key => $item) :
            $descricao = $this->busca_nome_empreendimento($item);
            $columns_barras[$descricao] = array('type' => 'number', 'label' => $descricao);
            $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        $column_chart_barras = new GoogleCharts();

        $column_chart_barras->type('ColumnChart');

        $column_chart_barras->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_barras->columns($columns_barras);
        $string = array();
        foreach ($origens as $key => $origen) :
            $descricao = $this->busca_nome_empreendimento($origen);
            $cont = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and corretor_id = ' . $corretor_id . '
                                            and importacaoleads.origen_id = ' . $origen);

            $string[$descricao] = $cont[0][0]['cont'];
            $string[] = $cont[0][0]['cont'];
        endforeach;

        $column_chart_barras->addRow($string);

        $this->set(compact('column_chart_barras'));

        //
        //GRAFICO DE PIZZA
        //

        $piechart = new GoogleCharts();
        $piechart->type("PieChart");
        $piechart->options(array(
            'width' => '80%',
            'title' => '',
            'titleTextStyle' => array('color' => 'blue'),
            'fontSize' => 12));
        $piechart->columns(array(
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

        foreach ($string as $key => $item) :
            if (!is_numeric($key)) {
                $piechart->addRow(array('descricao' => $key, $item, 'cont' => $item));
            }
        endforeach;

        $this->set(compact('piechart'));
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_desempenho_empreedimento_barras() {

        $origens = $this->Session->read('origen_id');

        $cont = 0;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'tipo');
        $result = $this->busca_desempenho(1, 1); // qualquer código de corretor, para somente buscar os parametros

        foreach ($result as $key => $item) :
            $columns_barras[$key] = array('type' => 'number', 'label' => $key);
            $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        endforeach;

        foreach ($origens as $key => $origen) :

            $string = array();

            $column_chart_barras[$cont] = new GoogleCharts();

            $column_chart_barras[$cont]->type('ColumnChart');

            $column_chart_barras[$cont]->options(array(
                'width' => '80%',
                'heigth' => '70%',
                'title' => '',
                'vAxis' => array('minValue' => 0),
                'titleTextStyle' => array('color' => 'grenn'),
                'fontSize' => 12,
            ));

            $column_chart_barras[$cont]->columns($columns_barras);

            $result = $this->busca_desempenho($origen, null);

            foreach ($result as $key => $valor) :
                $string[$key] = $valor;
                $string[] = $valor;
            endforeach;

            $column_chart_barras[$cont]->addRow($string);

            $cont++;

        endforeach;

        $this->set(compact('column_chart_barras'));

        $this->set('cont', $cont);
        $this->set('origens', $origens);
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_desempenho_empreedimento_pizza() {

        $origens = $this->Session->read('origen_id');

        $cont = 0;

        foreach ($origens as $key => $origen) :

            //
            //GRAFICO DE PIZZA
            //

            $piechart[$cont] = new GoogleCharts();
            $piechart[$cont]->type("PieChart");
            $piechart[$cont]->options(array(
                'width' => '80%',
                'title' => '',
                'titleTextStyle' => array('color' => 'blue'),
                'fontSize' => 12));
            $piechart[$cont]->columns(array(
                'descricao' => array(
                    'type' => 'string',
                    'label' => 'Descrição'
                ),
                'cont' => array(
                    'type' => 'number',
                    'label' => 'Quantidade',
                    'format' => '#,###',
                    'role' => 'annotation'
                )
            ));

            $string = array();

            $result = $this->busca_desempenho_sem_total($origen, null);

            foreach ($result as $key => $item) :
                $piechart[$cont]->addRow(array('descricao' => $key, $item, 'cont' => $item));
            endforeach;

            $cont++;

        endforeach;

        $this->set(compact('piechart'));

        $this->set('cont', $cont);
        $this->set('origens', $origens);
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_empreedimento_percentual() {

        $origens = $this->Session->read('origen_id');

        $cont = 0;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Empreendimento');
        $columns_barras['ficha'] = array('type' => 'number', 'label' => 'Ficha');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        $columns_barras['compra'] = array('type' => 'number', 'label' => 'Compra');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');

        foreach ($origens as $key => $origen) :

            $string = array();

            $column_chart_barras[$cont] = new GoogleCharts();

            $column_chart_barras[$cont]->type('ColumnChart');

            $column_chart_barras[$cont]->options(array(
                'width' => '80%',
                'heigth' => '70%',
                'title' => '',
                'vAxis' => array('minValue' => 0),
                'titleTextStyle' => array('color' => 'grenn'),
                'fontSize' => 12,
            ));

            $column_chart_barras[$cont]->columns($columns_barras);

            $total = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and importacaoleads.origen_id = ' . $origen);

            $ficha = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and ficha = ' . "'S'" . '
                                            and importacaoleads.origen_id = ' . $origen);

            $compra = $this->Lead->query('select count(*) as cont' . '
                                            from leads, importacaoleads, corretors
                                           where leads.importacaolead_id = importacaoleads.id
                                             and corretors.id = leads.corretor_id
                                             and compra = ' . "'S'" . '
                                             and importacaoleads.origen_id = ' . $origen);

//            $result = $this->Lead->query('select coalesce((' . '(' . $ficha[0][0]['cont'] . '*100)' . '/' . $total[0][0]['cont'] . '), 0) as ficha' . ',
//                                                 coalesce((' . '(' . $compra[0][0]['cont'] . '*100)' . '/' . $total[0][0]['cont'] . '), 0) as compra');

            $string['ficha'] = round((($ficha[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
            $string[] = round((($ficha[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
            $string['compra'] = round((($compra[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
            $string[] = round((($compra[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);

            $column_chart_barras[$cont]->addRow($string);

            $cont++;
        endforeach;

        $this->set('cont', $cont);
        $this->set('origens', $origens);

        $this->set(compact('column_chart_barras'));
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_empreedimento_percentual_geral() {

        $cont = 0;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Empreendimento');
        $columns_barras['ficha'] = array('type' => 'number', 'label' => 'Ficha');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        $columns_barras['compra'] = array('type' => 'number', 'label' => 'Compra');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');

        $string = array();

        $column_chart_barras[$cont] = new GoogleCharts();

        $column_chart_barras[$cont]->type('ColumnChart');

        $column_chart_barras[$cont]->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_barras[$cont]->columns($columns_barras);

        $total = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id');

        $ficha = $this->Lead->query('select count(*) as cont' . '
                                          from leads, importacaoleads, corretors
                                         where leads.importacaolead_id = importacaoleads.id
                                           and corretors.id = leads.corretor_id
                                           and ficha = ' . "'S'");

        $compra = $this->Lead->query('select count(*) as cont' . '
                                            from leads, importacaoleads, corretors
                                           where leads.importacaolead_id = importacaoleads.id
                                             and corretors.id = leads.corretor_id
                                             and compra = ' . "'S'");

//        $result = $this->Lead->query('select coalesce((' . '(' . $ficha[0][0]['cont'] . '*100)' . '/' . $total[0][0]['cont'] . '), 0) as ficha' . ',
//                                                 coalesce((' . '(' . $compra[0][0]['cont'] . '*100)' . '/' . $total[0][0]['cont'] . '), 0) as compra');

        $string['ficha'] = round((($ficha[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
        $string[] = round((($ficha[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
        $string['compra'] = round((($compra[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);
        $string[] = round((($compra[0][0]['cont'] * 100) / $total[0][0]['cont']), 2);

        $column_chart_barras[$cont]->addRow($string);

        $cont++;

        $this->set('cont', $cont);

        $this->set(compact('column_chart_barras'));
    }

    /**
     * corretor_empreendimento method
     */
    public function leads_empreendimento_conversao() {

        $origens = $this->Session->read('origen_id');

        $cont = 0;

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Empreendimento');
        $columns_barras['investimento'] = array('type' => 'number', 'label' => 'Investimento');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        $columns_barras['custo_lead'] = array('type' => 'number', 'label' => 'Custo/Lead');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        $columns_barras['custo_ficha'] = array('type' => 'number', 'label' => 'Custo/Ficha');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');
        $columns_barras['custo_compra'] = array('type' => 'number', 'label' => 'Custo/Compra');
        $columns_barras[] = array('type' => 'number', 'role' => 'annotation');

        foreach ($origens as $key => $origen) :

            $string = array();

            $column_chart_barras[$cont] = new GoogleCharts();

            $column_chart_barras[$cont]->type('ColumnChart');

            $column_chart_barras[$cont]->options(array(
                'width' => '80%',
                'heigth' => '70%',
                'title' => '',
                'vAxis' => array('minValue' => 0),
                'titleTextStyle' => array('color' => 'grenn'),
                'fontSize' => 12,
            ));

            $column_chart_barras[$cont]->columns($columns_barras);

            $investimento = $this->Lead->query('select valor_investido from origens where id = ' . $origen);

            $lead = $this->Lead->query('select (' . $investimento[0][0]['valor_investido'] . '/count(*)) as custo_lead' . '
                                          from leads, importacaoleads, corretors
                                         where leads.importacaolead_id = importacaoleads.id
                                           and corretors.id = leads.corretor_id
                                           and importacaoleads.origen_id = ' . $origen);

            $string['investimento'] = $investimento[0][0]['valor_investido'];
            $string[] = $investimento[0][0]['valor_investido'];
            $string['custo_lead'] = $lead[0][0]['custo_lead'];
            $string[] = $lead[0][0]['custo_lead'];

            $ficha = $this->Lead->query('select count(*) cont' . '
                                          from leads, importacaoleads, corretors
                                         where leads.importacaolead_id = importacaoleads.id
                                           and corretors.id = leads.corretor_id
                                           and ficha = ' . "'S'" . '
                                           and importacaoleads.origen_id = ' . $origen);

            if ($ficha[0][0]['cont'] > 0) {
                $ficha = $this->Lead->query('select (' . $investimento[0][0]['valor_investido'] . '/count(*)) as custo_ficha' . '
                                          from leads, importacaoleads, corretors
                                         where leads.importacaolead_id = importacaoleads.id
                                           and corretors.id = leads.corretor_id
                                           and ficha = ' . "'S'" . '
                                           and importacaoleads.origen_id = ' . $origen);

                $string['custo_ficha'] = $ficha[0][0]['custo_ficha'];
                $string[] = $ficha[0][0]['custo_ficha'];
            } else {
                $string['custo_ficha'] = 0;
                $string[] = 0;
            }

            $compra = $this->Lead->query('select count(*) as cont' . '
                                            from leads, importacaoleads, corretors
                                           where leads.importacaolead_id = importacaoleads.id
                                             and corretors.id = leads.corretor_id
                                             and compra = ' . "'S'" . '
                                             and importacaoleads.origen_id = ' . $origen);

            if ($compra[0][0]['cont'] > 0) {
                $compra = $this->Lead->query('select (' . $investimento[0][0]['valor_investido'] . '/count(*)) as custo_compra' . '
                                                from leads, importacaoleads, corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and corretors.id = leads.corretor_id
                                                 and compra = ' . "'S'" . '
                                                 and importacaoleads.origen_id = ' . $origen);

                $string['custo_compra'] = $compra[0][0]['custo_compra'];
                $string[] = $compra[0][0]['custo_compra'];
            } else {
                $string['custo_compra'] = 0;
                $string[] = 0;
            }

            $column_chart_barras[$cont]->addRow($string);

            $cont++;

        endforeach;

        $this->set(compact('column_chart_barras'));

        $this->set('cont', $cont);
        $this->set('origens', $origens);
    }

    /**
     * busca_nome_corretor method
     */
    public function busca_nome_corretor($corretor_id) {
        $nome = $this->Lead->query('select nome from corretors where id = ' . $corretor_id);

        return $nome[0][0]['nome'];
    }

    /**
     * busca_nome_empreendimento method
     */
    public function busca_nome_empreendimento($origen_id) {
        $nome = $this->Lead->query('select descricao from origens where id = ' . $origen_id);

        return $nome[0][0]['descricao'];
    }

    /**
     * busca_desempenho_consolidado method
     */
    public function busca_desempenho_consolidado($origen_id, $corretors, $param) {

        $result = $this->Lead->query('select corretors.nome, count(' . $param . ')
                                        from leads,
                                             importacaoleads,
                                             corretors
                                       where leads.importacaolead_id = importacaoleads.id
                                         and importacaoleads.origen_id = ' . $origen_id . '
                                         and corretors.id = leads.corretor_id
                                         and ' . $param . ' = ' . "'S'" . '
                                         and corretor_id in (' . $corretors . ')' . '
                                       group by corretors.nome
                                       order by corretors.nome');

        return $result;
    }

    /**
     * busca_desempenho_sem_total method
     */
    public function busca_desempenho_sem_total($origen_id, $corretor_id) {

        if (empty($corretor_id)) {
            $corretors = $this->Lead->query('select id from corretors where gerencia = ' . "'N' order by id");
            foreach ($corretors as $key => $item) :
                if (empty($corretor_id)) {
                    $corretor_id = $item[0]['id'];
                } else {
                    $corretor_id .= ',' . $item[0]['id'];
                }
            endforeach;
        }

        $result = $this->Lead->query('select (select count(sem_atendimento)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_atendimento = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_atendimento,
                                             (select count(sem_contato)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_contato = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_contato,
                                             (select count(ficha)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and ficha = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as ficha,
                                             (select count(fone)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and fone = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as fone,
                                             (select count(whats)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and whats = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as whats,
                                             (select count(material_enviado)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and material_enviado = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as material_enviado,
                                             (select count(sem_interesse)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_interesse = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_interesse,
                                             (select count(leads.email)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and leads.email = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as email,
                                             (select count(compra)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and compra = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as compra,
                                             (select count(preco)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and preco = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as preco,
                                              (select count(localizacao)
                                                 from leads,
                                                      importacaoleads,
                                                      corretors
                                                where leads.importacaolead_id = importacaoleads.id
                                                  and importacaoleads.origen_id = ' . $origen_id . '
                                                  and corretors.id = leads.corretor_id
                                                  and localizacao = ' . "'S'" . '
                                                  and corretor_id in (' . $corretor_id . ')) as localizacao');

        return $result[0][0];
    }

    /**
     * busca_fichas method
     */
    public function busca_desempenho($origen_id, $corretor_id) {

        if (empty($corretor_id)) {
            $corretors = $this->Lead->query('select id from corretors where gerencia = ' . "'N' order by id");
            foreach ($corretors as $key => $item) :
                if (empty($corretor_id)) {
                    $corretor_id = $item[0]['id'];
                } else {
                    $corretor_id .= ',' . $item[0]['id'];
                }
            endforeach;
        }

        $result = $this->Lead->query('select (select count(sem_atendimento)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_atendimento = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_atendimento,
                                             (select count(sem_contato)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_contato = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_contato,
                                             (select count(fone)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and fone = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as fone,
                                             (select coalesce((sum(fone_tentativas)/count(*)), 0)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and corretor_id in (' . $corretor_id . ')) as media_de_ligacoes,
                                             (select count(whats)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and whats = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as whats,
                                             (select count(leads.email)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and leads.email = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as email,
                                             (select count(material_enviado)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and material_enviado = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as material_enviado,
                                             (select count(sem_interesse)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and sem_interesse = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as sem_interesse,
                                             (select count(ficha)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and ficha = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as ficha,
                                             (select count(compra)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and compra = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as compra,
                                             (select count(preco)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and preco = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as preco,
                                             (select count(localizacao)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and localizacao = ' . "'S'" . '
                                                 and corretor_id in (' . $corretor_id . ')) as localizacao,
                                             (select count(*)
                                                from leads,
                                                     importacaoleads,
                                                     corretors
                                               where leads.importacaolead_id = importacaoleads.id
                                                 and importacaoleads.origen_id = ' . $origen_id . '
                                                 and corretors.id = leads.corretor_id
                                                 and corretor_id in (' . $corretor_id . ')) as total');

        return $result[0][0];
    }

    /**
     * equipe method
     */
    public function equipe() {

        $this->set('title_for_layout', 'Equipe');

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'conditions' => array('gerencia' => 'S'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        if ($this->request->is('post') || $this->request->is('put')) {
            CakeSession::write('corretors', $this->request->data['Relatorio']['corretor']);
            CakeSession::write('origen_id', $this->request->data['Relatorio']['origen']);
            $this->redirect(array('action' => 'equipe_graficos'));
        }
    }

    public function equipe_graficos() {

        $origen_id = $this->Session->read('origen_id');
        $corretors = $this->Session->read('corretors');

        $total = $this->Lead->query('select count(*) as cont' . '
                                           from leads, importacaoleads, corretors
                                          where leads.importacaolead_id = importacaoleads.id
                                            and corretors.id = leads.corretor_id
                                            and importacaoleads.origen_id = ' . $origen_id);

        $columns_barras['data'] = array('type' => 'string', 'label' => 'Data');
        foreach ($corretors as $key => $item) :
            $nome = $this->busca_nome_corretor($item);
            $columns_barras[$nome] = array('type' => 'number', 'label' => $nome);
            $columns_barras[] = array('type' => 'number', 'role' => 'annotation');

            if (empty($corretor_id)) {
                $corretor_id = $item;
            } else {
                $corretor_id .= ',' . $item;
            }
        endforeach;

        $column_chart_barras = new GoogleCharts();

        $column_chart_barras->type('ColumnChart');

        $column_chart_barras->options(array(
            'width' => '80%',
            'heigth' => '70%',
            'title' => '',
            'vAxis' => array('minValue' => 0),
            'titleTextStyle' => array('color' => 'grenn'),
            'fontSize' => 12,
        ));

        $column_chart_barras->columns($columns_barras);

        $string = array();

        $string['data'] = 'Ficha';

        $result = $this->Lead->query('select gerente_equipe, count(*) as cont' . '
                                        from leads, importacaoleads, corretors
                                       where leads.importacaolead_id = importacaoleads.id
                                         and corretors.id = leads.corretor_id
                                         and gerente_equipe in (' . $corretor_id . ')' . '
                                         and ficha = ' . "'S'" . '
                                         and importacaoleads.origen_id = ' . $origen_id . '
                                       group by gerente_equipe');

        foreach ($result as $key => $item):
            $nome = $this->busca_nome_corretor($item[0]['gerente_equipe']);
            $string[$nome] = round((($item[0]['cont'] * 100) / $total[0][0]['cont']), 2);
            $string[] = round((($item[0]['cont'] * 100) / $total[0][0]['cont']), 2);
        endforeach;

        $string_fim[] = $string;
        $column_chart_barras->addRow($string_fim[0]);

        $string = array();
        $string_fim = array();

        $string['data'] = 'Compra';

        $result = $this->Lead->query('select gerente_equipe, count(*) as cont' . '
                                        from leads, importacaoleads, corretors
                                       where leads.importacaolead_id = importacaoleads.id
                                         and corretors.id = leads.corretor_id
                                         and gerente_equipe in (' . $corretor_id . ')' . '
                                         and compra = ' . "'S'" . '
                                         and importacaoleads.origen_id = ' . $origen_id . '
                                       group by gerente_equipe');

        foreach ($result as $key => $item):
            $nome = $this->busca_nome_corretor($item[0]['gerente_equipe']);
            $string[$nome] = round((($item[0]['cont'] * 100) / $total[0][0]['cont']), 2);
            $string[] = round((($item[0]['cont'] * 100) / $total[0][0]['cont']), 2);
        endforeach;

        $string_fim[] = $string;
        $column_chart_barras->addRow($string_fim[0]);

        $this->set(compact('column_chart_barras'));

        $this->set('origen_id', $origen_id);
    }

    /**
     * valida_vinculo_lead method
     */
    public function valida_vinculo_lead($email = null) {

        $result = $this->Lead->query('select count(*) as cont from public.leads, public.clientes where leads.cliente_id = clientes.id and clientes.email = ' . "'" . $email . "'");

        return $result[0][0]['cont'];
    }

}

