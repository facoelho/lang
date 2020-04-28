<?php

App::uses('GoogleCharts', 'GoogleCharts.Lib');

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

        // Pizza

        $vencidos = $this->Contasreceber->query('select sum(valorparcela) valor
                                                   from contasrecebermovs
                                                  where dtpagamento is null
                                                    and dtvencimento < CURRENT_DATE');

        $vencer = $this->Contasreceber->query('select sum(valorparcela) valor
                                                 from contasrecebermovs
                                                where dtpagamento is null
                                                  and dtvencimento >= CURRENT_DATE');

        $pie_chart = new GoogleCharts();

        $pie_chart->type('PieChart');

        $pie_chart->options(array(
            'width' => '600',
            'heigth' => '300',
            'title' => 'Títulos em aberto',
            'titleTextStyle' => array('color' => 'blue'),
        ));

        $pie_chart->columns(array(
            'situacao' => array(
                'type' => 'string',
                'label' => 'Situação'
            ),
            'valor' => array(
                'type' => 'number',
                'label' => 'Valor',
            ),
        ));

        $pie_chart->addRow(array('situacao' => 'À receber', 'valor' => $vencer[0][0]['valor']));
        $pie_chart->addRow(array('situacao' => 'Em atraso', 'valor' => $vencidos[0][0]['valor']));

        $this->set(compact('pie_chart'));
    }

}

?>