<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

App::uses('CakeEmail', 'Network/Email');

/**
 * Categoria Controller
 */
class CategoriasController extends AppController {

    var $components = array('Email');

    function beforeFilter() {
        $this->set('title_for_layout', 'Categorias');
    }

    public function isAuthorized($user) {
        $Users = new UsersController;
        return $Users->validaAcesso($this->Session->read(), $this->request->controller);
        return parent::isAuthorized($user);
    }

    /**
     * index method
     */
    public function index() {

        $dadosUser = $this->Session->read();

        if ($dadosUser['Auth']['User']['adminholding'] == 2) {
            $this->Session->setFlash('Usuário não tem acesso a este módulo.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        }

        $conditions = array();

        $empresa_id = $dadosUser['empresa_id'];

        $categorias_pai = $this->Categoria->find('list', array('fields' => array('id', 'descricao'),
            'conditions' => array('empresa_id' => $empresa_id, 'categoria_pai_id IS NULL', 'ativo' => 'S'),
            'order' => array('descricao')));
        $this->set('categorias_pai', $categorias_pai);

        $tipo = array('S' => 'Saida', 'E' => 'Entrada', 'R' => 'Retirada');

        $ativo = array('S' => 'SIM', 'N' => 'NÃO');

        $this->Filter->addFilters(
                array(
                    'filter1' => array(
                        'Categoria.descricao' => array(
                            'operator' => 'LIKE',
                            'value' => array(
                                'before' => '%',
                                'after' => '%'
                            )
                        )
                    ),
                    'filter2' => array(
                        'Categoria.categoria_pai_id' => array(
                            'select' => $categorias_pai
                        ),
                    ),
                    'cat' => array(
                        'categoria' => array(
                            'select' => ''
                        ),
                    ),
                    'filter4' => array(
                        'Categoria.tipo' => array(
                            'select' => $tipo
                        ),
                    ),
                    'filter3' => array(
                        'Categoria.ativo' => array(
                            'select' => $ativo
                        ),
                    ),
                )
        );

        foreach ($this->Filter->getConditions() as $key => $item) :
            if ($key == 'Categoria.descricao LIKE') {
                $conditions[] = 'Categoria.descricao LIKE ' . "'%" . $item . "%'";
//                $conditions[] = 'Categoria.descricao ILIKE ' . "'%" . $item . "%'" . ' OR ' . 'Categoriapai.descricao ILIKE ' . "'%" . $item . "%'";
            }
            if ($key == 'Categoria.categoria_pai_id =') {
                $conditions[] = 'Categoria.categoria_pai_id = ' . $item;
            }
            if ($key == 'categoria =') {
                $conditions[] = 'Categoria.id = ' . $item;
            }
            if ($key == 'Categoria.tipo =') {
                $conditions[] = 'Categoria.tipo =  ' . "'" . $item . "'";
            }
            if ($key == 'Categoria.ativo =') {
                $conditions[] = 'Categoria.ativo = ' . "'" . $item . "'";
            }
        endforeach;

        $this->Categoria->recursive = 0;
        $this->Paginator->settings = array(
            'fields' => array('Categoria.id', 'Categoria.descricao', 'Categoria.ativo', 'Categoriapai.descricao', 'Categoria.tipo', 'Categoria.mensal', 'Categoria.dia_vencimento'),
            'joins' => array(
                array(
                    'table' => 'categorias',
                    'alias' => 'Categoriapai',
                    'type' => 'LEFT',
                    'conditions' => array('Categoria.categoria_pai_id = Categoriapai.id')
                )
            ),
            'conditions' => array('Categoria.empresa_id' => $dadosUser['empresa_id']),
            'order' => array('Categoria.descricao' => 'asc', 'Categoriapai.descricao', 'asc')
        );

        $this->Filter->setPaginate('conditions', array($conditions, 'Categoria.empresa_id' => $dadosUser['empresa_id']));

        $this->set('categorias', $this->Paginator->paginate('Categoria'));
    }

    /**
     * view method
     */
    public function view($id = null) {

        $this->Categoria->id = $id;
        if (!$this->Categoria->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($dadosUser['Auth']['User']['adminholding'] == 2) {
            $this->Session->setFlash('Usuário não tem acesso a este módulo.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        }

        $dadosUser = $this->Session->read();
        $empresa_id = $dadosUser['empresa_id'];

        $categoria = $this->Categoria->read(null, $id);

        if ($categoria['Categoria']['empresa_id'] != $empresa_id) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $this->set('categoria', $categoria);
    }

    /**
     * add method
     */
    public function add() {

        $dadosUser = $this->Session->read();

        if ($dadosUser['Auth']['User']['adminholding'] == 2) {
            $this->Session->setFlash('Usuário não tem acesso a este módulo.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        }

        $empresa_id = $dadosUser['empresa_id'];
        $this->set(compact('empresa_id'));

        $ativo = array('S' => 'Ativo', 'N' => 'Inativo');
        $this->set(compact('ativo'));

        $mensal = array('N' => 'NÃO', 'S' => 'SIM');
        $this->set(compact('mensal'));

        $categorias_pai = $this->Categoria->find('list', array('fields' => array('id', 'descricao'),
            'conditions' => array('empresa_id' => $empresa_id, 'categoria_pai_id IS NULL'),
            'order' => array('descricao')));
        $this->set(compact('categorias_pai'));

        $tipo = array('S' => 'Saida', 'E' => 'Entrada', 'R' => 'Retirada');
        $this->set(compact('tipo'));

        if ($this->request->is('post')) {
            $this->Categoria->create();
            if ($this->Categoria->save($this->request->data)) {
                $this->Session->setFlash('Categoria adicionada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Categorias', 'action' => 'add'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     */
    public function edit($id = null) {

        $this->Categoria->id = $id;
        if (!$this->Categoria->exists($id)) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        $dadosUser = $this->Session->read();

        if ($dadosUser['Auth']['User']['adminholding'] == 2) {
            $this->Session->setFlash('Usuário não tem acesso a este módulo.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        }

        $empresa_id = $dadosUser['empresa_id'];
        $this->set(compact('empresa_id'));

        $categorias_pai = $this->Categoria->find('list', array('fields' => array('id', 'descricao'),
            'conditions' => array('empresa_id' => $empresa_id, 'categoria_pai_id IS NULL')));
        $this->set(compact('categorias_pai'));

        $ativo = array('S' => 'Ativo', 'N' => 'Inativo');
        $this->set(compact('ativo'));

        $mensal = array('S' => 'SIM', 'N' => 'NÃO');
        $this->set(compact('mensal'));

        $tipo = array('S' => 'Saida', 'E' => 'Entrada', 'R' => 'Retirada');
        $this->set(compact('tipo'));

        $categorias = $this->Categoria->read(null, $id);

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Categoria->save($this->request->data)) {
                $this->Session->setFlash('Categoria alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('controller' => 'Categorias', 'action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $categorias;
        }
    }

    /**
     * delete method
     */
    public function delete($id = null) {

        $this->Categoria->id = $id;
        if (!$this->Categoria->exists()) {
            $this->Session->setFlash('Registro não encontrado.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($dadosUser['Auth']['User']['adminholding'] == 2) {
            $this->Session->setFlash('Usuário não tem acesso a este módulo.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('controller' => 'homes', 'action' => 'index'));
        }

        $result = $this->Categoria->query('select count(*) as cont
                                             from categorias
                                            where categoria_pai_id = ' . $id);
        if ($result[0][0]['cont'] > 0) {
            $this->Session->setFlash('Categoria pai não pode ser deletada.', 'default', array('class' => 'mensagem_erro'));
            $this->redirect(array('action' => 'index'));
        }

        if ($this->Categoria->delete()) {
            $this->Session->setFlash('Categoria deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

    public function importacao() {

        $caixa_id = '';
        $categoria_id = '';
        $descricao = '';

        $categorias = $this->Categoria->query('select id,
                                                      descricao
                                                 from public.categorias
                                                where categoria_pai_id is not null
                                                  and empresa_id = 15
                                                order by descricao');
        foreach ($categorias as $key => $item) :
            $pai = $this->Categoria->query('select id
                                              from public.categorias
                                             where descricao = ' . "'" . $item[0]['descricao'] . "'" . '
                                               and empresa_id = 15');

            $this->Categoria->query('update public.categorias
                                        set categoria_pai_id = ' . $pai[0][0]['id'] . '
                                      where id = ' . $item[0]['id']);
        endforeach;
    }

    /**
     * Funções ajax
     */
    public function buscaCategorias($chave, $categoria_paiID) {

        $this->layout = 'ajax';

        $dadosUser = $this->Session->read();
        $empresa_id = $dadosUser['empresa_id'];

        $categorias = $this->Categoria->find('list', array('order' => 'descricao ASC',
            'fields' => array('Categoria.id', 'Categoria.descricao'),
            'conditions' => array('Categoria.categoria_pai_id' => $categoria_paiID,
                'Categoria.empresa_id' => $empresa_id, 'Categoria.ativo' => 'S')));

        $this->set('categorias', $categorias);
    }

    public function buscaCategoriasfilhas($chave, $tipoID) {

        $this->layout = 'ajax';

        $dadosUser = $this->Session->read();
        $empresa_id = $dadosUser['empresa_id'];

        if ($tipoID <> 'T') {
            $categorias_aux = $this->Categoria->query('select categorias.id, categoriaspai.descricao ||' . "' - '" . '|| categorias.descricao as descricao
                 from categorias, categorias as categoriaspai
                where categoriaspai.id = categorias.categoria_pai_id
                  and categorias.categoria_pai_id IS NOT NULL
                  and categorias.tipo = ' . "'" . $tipoID . "'" . '
                order by categoriaspai.descricao, categorias.descricao');

            foreach ($categorias_aux as $key => $item) :
                $categorias[$item[0]['id']] = $item[0]['descricao'];
            endforeach;
        } else {
            $categorias_aux = $this->Categoria->query('select categorias.id, categoriaspai.descricao ||' . "' - '" . '|| categorias.descricao as descricao
                 from categorias, categorias as categoriaspai
                where categoriaspai.id = categorias.categoria_pai_id
                  and categorias.categoria_pai_id IS NOT NULL
                order by categoriaspai.descricao, categorias.descricao');

            foreach ($categorias_aux as $key => $item) :
                $categorias[$item[0]['id']] = $item[0]['descricao'];
            endforeach;
        }

        $this->set('categorias', $categorias);
    }

    public function send() {

        $corpo_email = '';

        $despesas_fixas = $this->Categoria->query('select descricao from categorias where mensal = ' . "'S'" . 'and dia_vencimento = ' . date('d'));

        if (!empty($despesas_fixas)) {
            $corpo_email .= 'Despesas com vencimento: ' . date('d/m/Y') . "<br/>";
            $corpo_email .= "<br/>";

            foreach ($despesas_fixas as $item) :
                $corpo_email .= $item[0]['descricao'] . "<br/>";
            endforeach;

            CakeSession::write('corpo_email', array($corpo_email));

            //$emails = array('felipe@eduardolang.com.br', 'otaviolang@hotmail.com');
            $emails = array('felipe@eduardolang.com.br');

            $Email = new CakeEmail();

            foreach ($emails as $key => $item) :
                $Email->template('despesas', null)
                        ->subject('Despesas fixas | Eduardo Lang Imóveis')
                        ->emailFormat('html')
                        ->to(trim($item))
                        ->from(array('contato@eduardolang.com.br' => 'Eduardo Lang Imóveis'))
                        ->send();
            endforeach;
            echo 'Despesas enviadas';
            die();
        } else {
            echo 'Não tem despesas para esta data';
            die();
        }

        $this->redirect(array('action' => 'email'));
    }

}

