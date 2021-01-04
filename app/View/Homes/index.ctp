<?php if (!empty($contasrecebers)) { ?>
    <?php if ($adminholding == 1) { ?>
        <?php $pie_chart->div('chart_div'); ?>
        <div id="graficos">
            <div id="chart_div">
                <?php echo $this->GoogleCharts->createJsChart($pie_chart); ?>
            </div>
        </div>
        <div id="contasreceber_home">
            <table border="1" style ="width:100%">
                <tr>
                    <th colspan="4"><h3><font color="blue"><center>Honorários a receber (30 dias)</center></font></h3></th>
                </tr>
                <tr>
                    <th>Vencimento</th>
                    <th>Comprador</th>
                    <th>Valor parcela</th>
                    <th class="actions"><?php echo __('Ações'); ?></th>
                </tr>
                <?php foreach ($contasrecebers as $key => $item): ?>
                    <tr>
                        <?php if (date('Y-m-d') > date('Y-m-d', strtotime($item[0]['dtvencimento']))) { ?>
                            <td><strong><font color="red"><?php echo date('d/m/Y', strtotime($item[0]['dtvencimento'])); ?></font></strong></td>
                        <?php } elseif (date('Y-m-d') == date('Y-m-d', strtotime($item[0]['dtvencimento']))) { ?>
                            <td><strong><font color="#d8b514"><?php echo date('d/m/Y', strtotime($item[0]['dtvencimento'])); ?></font></strong></td>
                        <?php } else { ?>
                            <td><strong><font color="green"><?php echo date('d/m/Y', strtotime($item[0]['dtvencimento'])); ?></font></strong></td>
                        <?php } ?>
                        <td><?php echo $item[0]['cliente_comprador']; ?></td>
                        <td><?php echo number_format($item[0]['valorparcela'], 2, ",", "."); ?></td>
                        <td>
                            <div id="botoes">
                                <?php
                                echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('controller' => 'Contasrecebers', 'action' => 'relatorio_contas_receber_individual', $item[0]['id']), array('escape' => false, 'target' => '_blank'));
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php } ?>
<?php } ?>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>