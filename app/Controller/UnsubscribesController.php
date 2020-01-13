<?php

App::uses('AppController', 'Controller');

App::import('Controller', 'Users');

/**
  class Unsubscribes Controller
 */
class UnsubscribesController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Unsubscribes');
        $this->Auth->allow(array('unsubscribe', 'sucess'));
    }

    /**
     * caracteristicas method
     */
    public function unsubscribe($email = null) {

        $this->set('email', $email);

        if ($this->request->is('post')) {

            $this->Unsubscribe->create();

            $this->request->data['Unsubscribe']['data'] = date('Y-m-d h:m');

            if ($this->Unsubscribe->save($this->request->data)) {
                $this->redirect(array('action' => 'sucess'));
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
