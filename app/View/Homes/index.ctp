<?php if (!empty($contasrecebers)) { ?>
    <?php if ($adminholding == 1) { ?>
        <div id="contasreceber_home">
            <table border="1" style ="width:100%">
                <tr>
                    <th colspan="3"><h3><font color="blue"><center>Honorários a receber (30 dias)</center></font></h3></th>
                </tr>
                <tr>
                    <th>Vencimento</th>
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
                        <td><?php echo number_format($item[0]['valorparcela'], 2, ",", "."); ?></td>
                        <td>
                            <div id="botoes">
                                <?php
                                echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('controller' => 'Contasrecebers', 'action' => 'relatorio_contas_receber', $item[0]['id']), array('escape' => false, 'target' => '_blank'));
                                ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php } ?>
<?php } ?>