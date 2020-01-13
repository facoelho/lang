<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 */
class EmpresasController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Empresas');
    }
    
    public function isAuthorized($user) {
        $Users = new UsersController;
        return $Users->validaAcesso($this->Session->read(), $this->request->controller);
        return parent::isAuthorized($user);
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $dadosUser = $this->Session->read();
        $this->Empresa->recursive = 0;
        $this->Paginator->settings = array(
            'conditions' => array('holding_id' => $dadosUser['Auth']['User']['holding_id']),
            'order' => array('razaosocial' => 'asc')
        );
        $this->set('empresas', $this->Paginator->paginate('Empresa'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Empresa->exists($id)) {
            throw new NotFoundException(__('Empresa inválida.'));
        }
        $dadosUser = $this->Session->read();
        $empresa = $this->Empresa->findById($id);
        if ($empresa['Holding']['id'] == $dadosUser['Auth']['User']['holding_id']) {
            $this->set('empresa', $empresa);
        } else {
            throw new NotFoundException(__('Empresa inválida.'));
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        
        $dadosUser = $this->Session->read();
        $holding_id = $dadosUser['Auth']['User']['Holding']['id'];
        $this->set(compact('holding_id'));
        
        $opcoes = array(1 => 'MATRIZ', 2 => 'FILIAL');
        $this->set('opcoes', $opcoes);
        
        $empresas = $this->Empresa->find('list', array('fields' => array('id', 'nomefantasia'), 'conditions' => array('holding_id'=>$holding_id, "cdempmatriz" => null)));
        $this->set(compact('empresas'));
        
        if ($this->request->is('post')) {
            $this->Empresa->create();
            $separadores = array(".", "-", "/");
            $this->request->data['Empresa']['cnpj'] = str_replace($separadores, '', $this->request->data['Empresa']['cnpjEmpresa']);
            $this->request->data['Empresa']['inscestadual'] = str_replace($separadores, '', $this->request->data['Empresa']['inscEstadualEmpresa']);
            $this->request->data['Empresa']['inscmunicipal'] = str_replace($separadores, '', $this->request->data['Empresa']['inscMunicipalEmpresa']);
            
            if ($this->Empresa->save($this->request->data)) {
                
                $id = $this->Empresa->getLastInsertID();
                $this->Empresa->id = $id;
                
                if ($this->request->data['Empresa']['logoempresa']['error'] == 0) {
                    $extensao = substr($this->request->data['Empresa']['logoempresa']['name'],(strlen($this->request->data['Empresa']['logoempresa']['name'])-4),strlen($this->request->data['Empresa']['logoempresa']['name']));
                    $nome_arquivo = "empresa_" . $id . $extensao;
                    $tamanho = @getimagesize($this->request->data['Empresa']['logoempresa']['tmp_name']);
                    $arquivo = new File($this->request->data['Empresa']['logoempresa']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/empresas/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                    }
                    $this->request->data['Empresa']['img_foto'] = $nome_arquivo;
                    if ($tamanho[0] > $tamanho[1]) {
                        $this->request->data['Empresa']['tipoimagem'] = "P";
                    } else {
                        $this->request->data['Empresa']['tipoimagem'] = "R";
                    }
                    $this->Empresa->save($this->request->data);
                }
                $this->Session->setFlash('Empresa adicionada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi salvo. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Empresa->id = $id;
        if (!$this->Empresa->exists($id)) {
            throw new NotFoundException(__('Empresa inválida.'));
        }
        
        $dadosUser = $this->Session->read();
        $holding_id = $dadosUser['Auth']['User']['Holding']['id'];
        
        $empresa = $this->Empresa->read(null, $id);
        if ($empresa['Holding']['id'] != $dadosUser['Auth']['User']['holding_id']) {
            throw new NotFoundException(__('Empresa inválida.'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['Empresa']['logoempresa']['error'] == 0) {
                // Apaga a imagem antiga
                if (!empty($this->request->data['Empresa']['img_foto'])) {
                    $img_antiga = new File(WWW_ROOT.'img/empresas/' . $this->request->data['Empresa']['img_foto'], true, 0755);
                    $img_antiga->delete();
                }
                // Insere a imagem nova
                $extensao = substr($this->request->data['Empresa']['logoempresa']['name'],(strlen($this->request->data['Empresa']['logoempresa']['name'])-4),strlen($this->request->data['Empresa']['logoempresa']['name']));
                $nome_arquivo = "empresa_" . $id . $extensao;
                $tamanho = @getimagesize($this->request->data['Empresa']['logoempresa']['tmp_name']);
                $arquivo = new File($this->request->data['Empresa']['logoempresa']['tmp_name'],false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File(WWW_ROOT.'img/empresas/' . $nome_arquivo, false ,0777);
                if($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                $this->request->data['Empresa']['img_foto'] = $nome_arquivo;
                if ($tamanho[0] > $tamanho[1]) {
                    $this->request->data['Empresa']['tipoimagem'] = "P";
                } else {
                    $this->request->data['Empresa']['tipoimagem'] = "R";
                }
            }
            if ($this->Empresa->save($this->request->data)) {
                $this->Session->setFlash('Empresa alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Registro não foi alterado. Por favor tente novamente.', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $empresa;
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Empresa->id = $id;
        if (!$this->Empresa->exists()) {
            throw new NotFoundException(__('Invalid empresa'));
        }
        $this->request->onlyAllow('post', 'delete');
        $foto = $this->Empresa->field('img_foto');
        if ($this->Empresa->delete()) {
            if (!empty($foto)) {
                $arquivo = new File(WWW_ROOT.'img/empresas/' . $foto, true, 0755);
                $arquivo->delete();
            }
            $this->Session->setFlash('Empresa deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Registro não foi deletado.', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }

}
