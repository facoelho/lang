<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Importacaoleads Controller
 */
class ImportacaoleadsController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Importacao leads');
    }

    /**
     * index method
     */
    public function index() {

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'),
            'order' => array('descricao')));
        $this->set('origens', $origens);

        $this->loadModel('Corretor');
        $corretors = $this->Corretor->find('list', array('fields' => array('id', 'nome'),
            'order' => array('nome')));
        $this->set('corretors', $corretors);

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
                        'Cliente.nome' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter4' => array(
                        'Cliente.email' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter5' => array(
                        'Cliente.telefone' => array(
                            'operator' => 'ILIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter6' => array(
                        'Importacaolead.created' => array(
                            'operator' => 'BETWEEN',
                            'between' => array(
                                'text' => __(' e ', true),
                                'date' => true
                            )
                        )
                    ),
                )
        );

        $this->Importacaolead->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('DISTINCT Importacaolead.id', 'Origen.descricao', 'Importacaolead.created', 'User.nome', 'User.sobrenome', 'count(*)'),
            'joins' => array(
                array(
                    'table' => 'leads',
                    'alias' => 'Lead',
                    'type' => 'INNER',
                    'conditions' => [
                        'Importacaolead.id = Lead.importacaolead_id',
                    ],
                ),
                array(
                    'table' => 'corretors',
                    'alias' => 'Corretor',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Lead.corretor_id = Corretor.id',
                    ],
                ),
                array(
                    'table' => 'clientes',
                    'alias' => 'Cliente',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Lead.cliente_id = Cliente.id',
                    ],
                ),
            ),
            'group' => 'Importacaolead.id, Origen.descricao, Importacaolead.created, User.nome, User.sobrenome',
            'order' => array('created' => 'desc')
        );

        $this->Filter->setPaginate('conditions', array($this->Filter->getConditions()));

        $this->set('importacaoleads', $this->Paginator->paginate('Importacaolead'));

        CakeSession::write('conditions', $this->Filter->getConditions());
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        $this->loadModel('Origen');
        $origens = $this->Origen->find('list', array('fields' => array('id', 'descricao'), array('order' => 'descricao')));
        $this->set(compact('origens'));

        if ($this->request->is('post')) {

            if (file_exists('../webroot/arquivos/leads.csv')) {
                unlink('../webroot/arquivos/leads.csv');
            }

            $extensao = substr($this->request->data['Importacaolead']['arquivoitem']['name'], (strlen($this->request->data['Importacaolead']['arquivoitem']['name']) - 4), strlen($this->request->data['Importacaolead']['arquivoitem']['name']));
            if ((strtoupper($extensao) <> strtoupper('.csv'))) {
                $this->Session->setFlash('A extensão do arquivo é inválida.', 'default', array('class' => 'mensagem_erro'));
                return;
            }

            if ($this->request->data['Importacaolead']['arquivoitem']['error'] == 0) {
                //exclui arquivo
                $nome_arquivo = $this->request->data['Importacaolead']['arquivoitem']['name'];
                $tamanho = @getimagesize($this->request->data['Importacaolead']['arquivoitem']['tmp_name']);
                $arquivo = new File($this->request->data['Importacaolead']['arquivoitem']['tmp_name'], false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File('../webroot/arquivos/' . $nome_arquivo, false, 0777);
                if ($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                rename('../webroot/arquivos/' . $nome_arquivo, '../webroot/arquivos/leads.csv');
            }

            if (empty($this->request->data['Importacaolead']['origem_id'])) {
                $this->Session->setFlash('Mídia de referência não foi informada.', 'default', array('class' => 'mensagem_erro'));
                return;
            }

            if (empty($this->request->data['Importacaolead']['arquivoitem']['name'])) {
                $this->Session->setFlash('Selecione um arquivo "*.csv".', 'default', array('class' => 'mensagem_erro'));
                return;
            }

            try {

                $this->Importacaolead->begin();

                $this->Importacaolead->query('INSERT INTO public.importacaoleads(created, user_id, origen_id)
							    values(now(),' . $dadosUser['Auth']['User']['id'] . ', ' . $this->request->data['Importacaolead']['origem_id'] . ')');

                $importacaolead = $this->Importacaolead->query('select MAX(id) as id from public.importacaoleads');

                $file = fopen('../webroot/arquivos/leads.csv', 'r');

                while (($line = fgetcsv($file)) !== FALSE) {

                    $this->Importacaolead->query('INSERT INTO public.clientes(email, nome, telefone)
                                            VALUES(' . "'" . $line[0] . "'" . ',' . "'" . $line[1] . "'" . ',' . "'" . $line[2] . "'" . ')');

                    $cliente = $this->Importacaolead->query('select MAX(id) as id from public.clientes', false);

                    $this->Importacaolead->query('INSERT INTO public.leads(cliente_id, status, importacaolead_id)
                                              values(' . $cliente[0][0]['id'] . ',' . "'A'" . ',' . $importacaolead[0][0]['id'] . ')');
                }

                $this->Importacaolead->commit();

                $this->Session->setFlash('Leads importados com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } catch (Exception $id) {
                $this->Importacaolead->rollback();
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Importacaolead->id = $id;
        if (!$this->Importacaolead->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $importacaoleads = $this->Importacaolead->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Importacaolead->save($this->request->data)) {
                $this->Session->setFlash('Importação alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $corretors;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Importacaolead->id = $id;
        if (!$this->Importacaolead->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Importacaolead->delete()) {
            $this->Session->setFlash('Importação deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * relatorio_leads method
     */
    public function relatorio_leads($id = null) {

        $this->Importacaolead->Lead->recursive = 0;

        $leads = $this->Importacaolead->Lead->find('all', array(
            'fields' => array('Importacaolead.created', 'Lead.id', 'Origen.descricao', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone', 'Corretor.id', 'Corretor.nome'),
            'conditions' => array('Importacaolead.id' => $id, 'Lead.corretor_id IS NOT NULL'),
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
            'order' => array('Corretor.nome' => 'asc', 'Cliente.nome' => 'asc')
        ));

        $this->set('leads', $leads);
    }

    /**
     * relatorio_leads method
     */
    public function relatorio_lista_leads($conditions = null) {

        $conditions = $this->Session->read('conditions');

        $conditions[] = 'Lead.corretor_id IS NOT NULL';

        $this->Importacaolead->Lead->recursive = 0;

        $leads = $this->Importacaolead->Lead->find('all', array(
            'fields' => array('Importacaolead.created', 'Lead.id', 'Origen.descricao', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone', 'Corretor.id', 'Corretor.nome', 'Origen.id', 'Origen.descricao'),
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
            'conditions' => $conditions,
            'order' => array('Corretor.nome' => 'asc', 'Origen.descricao', 'Cliente.nome' => 'asc'),
        ));

        $this->set('leads', $leads);
        $this->set('conditions', $conditions);
    }

    /**
     * relatorio_leads method
     */
    public function relatorio_conflito_lead($email = null) {

        $conditions[] = 'Cliente.email = ' . $email;
        $conditions[] = 'AND "Cliente"."email" in (select clientes.email from clientes, leads where leads.cliente_id = clientes.id)';

        $this->Importacaolead->Lead->recursive = 0;

        $leads = $this->Importacaolead->Lead->find('all', array(
            'fields' => array('Importacaolead.created', 'Lead.id', 'Origen.descricao', 'Cliente.nome', 'Cliente.email', 'Cliente.telefone', 'Corretor.id', 'Corretor.nome', 'Origen.id', 'Origen.descricao'),
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
            'conditions' => array('Cliente.email' => $email),
            'order' => array('Importacaolead.created' => 'asc'),
        ));

        $this->set('leads', $leads);
        $this->set('conditions', $conditions);
    }

    /**
     * valida_corretor_lead method
     */
    public function valida_corretor_leads($id = null) {

        $result = $this->Importacaolead->query('select count(*) as cont from public.leads where corretor_id is null and importacaolead_id = ' . $id);

        return $result[0][0]['cont'];
    }

}
