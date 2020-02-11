<?php

class HomesController extends AppController {

    function beforeFilter() {
        $this->set('title_for_layout', 'Home');
    }

    public function index() {

        $dadosUser = $this->Session->read();

        $this->set('adminholding', $dadosUser['Auth']['User']['adminholding']);

        $this->loadModel('Contasreceber');

        $contasrecebers = $this->Contasreceber->query('select contasrecebers.id, dtvencimento, valorparcela
                                                         from contasrecebers,
                                                              contasrecebermovs
                                                        where contasrecebers.id = contasrecebermovs.contasreceber_id
                                                          and (dtvencimento between CURRENT_DATE and CURRENT_DATE + interval ' . "'30 day'" . ' and dtpagamento is null or (dtvencimento < CURRENT_DATE and dtpagamento is null))
                                                        order by dtvencimento asc');
        $this->set('contasrecebers', $contasrecebers);
    }

}

?>