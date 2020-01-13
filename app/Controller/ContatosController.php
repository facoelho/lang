<?php

App::uses('AppController', 'Controller');

App::uses('CakeEmail', 'Network/Email');

/**
 * Contatos Controller
 */
class ContatosController extends AppController {

    var $components = array('Email');

    public function email() {

    }

    public function send() {

        $emails = explode(',', $this->data['Contato']['email']);

        $Email = new CakeEmail();

        foreach ($emails as $key => $item) :

            $email = explode(';', $item);

            if (!empty($email)) {

                CakeSession::write('contato', $email);

                $Email->template('contato', null)
                        ->subject('Contato | Eduardo Lang Imóveis 🙂🙂🙂')
                        ->emailFormat('html')
                        ->to(trim($email[1]))
                        ->from(array('contato@eduardolang.com.br' => 'Eduardo Lang Imóveis'))
//                        ->from('contato@eduardolang.com.br')
                        ->send();
            }
        endforeach;

        $this->redirect(array('action' => 'email'));
    }

}
