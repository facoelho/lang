<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$total_recebido = 0;
$total_el = 0;
$total_corretor = 0;
$total_corretor_individual = 0;
$total_gerente_individual = 0;
$total_coordenador_individual = 0;
$total_ti_individual = 0;
$total_gerente = 0;
$total_ti = 0;
$total_coordenador = 0;
$cont_corretor = 1;
$corretor = '';
$nome = '';
?>
<div id="informacao_leads">
    <center><b><?php echo 'RELATÓRIO DE CONTAS A RECEBER'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Negociação'; ?></th>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Vendedor'; ?></th>
        <th><?php echo 'Comprador'; ?></th>
        <th><?php echo 'Ref'; ?></th>
        <th><?php echo 'Unid'; ?></th>
        <th><?php echo 'Vencimento'; ?></th>
        <th><?php echo 'Recebimento'; ?></th>
        <th><?php echo 'NF EL'; ?></th>
        <th><?php echo 'NF Cor'; ?></th>
        <th><?php echo 'Parcela'; ?></th>
        <th><?php echo 'Parcela NF'; ?></th>
        <th><?php echo 'Corretor($)'; ?></th>
    </tr>
    <?php foreach ($contasrecebers as $item): ?>
        <?php
        $cont_corretor = $this->requestAction('/Contasrecebers/numero_corretors', array('pass' => array($item['Negociacao']['id'])));
        ?>
        <?php if ($corretor <> $item['Corretor']['id']) { ?>
            <?php if ($total_corretor_individual > 0) { ?>
                <tr>
                    <td colspan="12"><?php echo ''; ?>&nbsp;</td>
                    <td><strong><font color="blue"><?php echo number_format($total_corretor_individual, 2, ',', '.'); ?>&nbsp;</font></strong></td>
                </tr>
                <?php
                $total_coordenador_individual = 0;
                $total_corretor_individual = 0;
                $total_gerente_individual = 0;
                $total_ti_individual = 0;
                ?>
            <?php } ?>
        <?php } ?>
        <tr>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['referencia']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['unidade']); ?>&nbsp;</td>
            <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtvencimento'])); ?></td>
            <?php if (!empty($item['Contasrecebermov']['dtpagamento'])) { ?>
                <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtpagamento'])); ?></td>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>

            <?php if ($item['Negociacao']['nota_imobiliaria'] == 'S') { ?>
                <td><strong><font color="red"><?php echo h($item['Negociacao']['nota_imobiliaria']); ?>&nbsp;</font></strong></td>
            <?php } else { ?>
                <td><strong><font color="blue"><?php echo h($item['Negociacao']['nota_imobiliaria']); ?>&nbsp;</font></strong></td>
            <?php } ?>

            <?php if ($item['Negociacao']['nota_corretor'] == 'S') { ?>
                <td><strong><font color="red"><?php echo h($item['Negociacao']['nota_corretor']); ?>&nbsp;</font></strong></td>
            <?php } else { ?>
                <td><strong><font color="blue"><?php echo h($item['Negociacao']['nota_corretor']); ?>&nbsp;</font></strong></td>
            <?php } ?>

            <?php //SEM NOTA FISCAL OU SOMENTE O CORRETOR EMITIU NOTA FISCAL?>
            <?php if ($item['Negociacao']['nota_imobiliaria'] == 'N') { ?>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']), 2, ',', '.'); ?>&nbsp;</td>

                <?php $total_corretor = $total_corretor + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']); ?>
                <?php $total_corretor_individual = $total_corretor_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']); ?>

                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))); ?>
                <?php } else { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))); ?>
                <?php } ?>
                <?php $total_recebido = $total_recebido + ($item['Contasrecebermov']['valorparcela'] / $cont_corretor); ?>
            <?php } ?>

            <?php //SOMENTE A IMOBILIÁRIA EMITIU NOTA FISCAL ?>
            <?php if (($item['Negociacao']['nota_imobiliaria'] == 'S') and ($item['Negociacao']['nota_corretor'] == 'N')) { ?>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor) - (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) / 100 * 15), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) / 100 * 15), 2, ',', '.'); ?>&nbsp;</td>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                                                            <!--<td><?php echo number_format((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) / 100 * 15), 2, ',', '.'); ?>&nbsp;</td>-->
                <?php } else { ?>
                    <td><?php // echo number_format((0), 2, ',', '.');            ?>&nbsp;</td>
                <?php } ?>

                <?php $total_corretor = $total_corretor + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) / 100 * 15); ?>
                <?php $total_corretor_individual = $total_corretor_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']) / 100 * 15); ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_gerente_individual = $total_gerente_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) / 100 * 15); ?>
                <?php } ?>
                <?php $total_ti_individual = $total_ti_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) / 100 * 15); ?>
                <?php if ($item['Corretor']['id'] <> 7) { ?>
                    <?php $total_coordenador_individual = $total_coordenador_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) / 100 * 15); ?>
                <?php } ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_gerente = $total_gerente + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) / 100 * 15); ?>
                <?php } ?>
                <?php $total_ti = $total_ti + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02); ?>
                <?php if ($item['Corretor']['id'] <> 7) { ?>
                    <?php $total_coordenador = $total_coordenador + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) / 100 * 15); ?>
                <?php } ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) - (($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) / 100 * 15); ?>
                <?php } else { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) - (($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) / 100 * 15); ?>
                <?php } ?>
                <?php $total_recebido = $total_recebido + ($item['Contasrecebermov']['valorparcela'] / $cont_corretor) - (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) / 100 * 15); ?>
            <?php } ?>

            <?php //AMBOS EMITIRAM NOTA FISCAL ?>
            <?php if (($item['Negociacao']['nota_imobiliaria'] == 'S') and ($item['Negociacao']['nota_corretor'] == 'S')) { ?>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] / $cont_corretor) - (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) / 100 * 15), 2, ',', '.'); ?>&nbsp;</td>
                <td><?php echo number_format((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']), 2, ',', '.'); ?>&nbsp;</td>
                <?php $total_corretor = $total_corretor + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']); ?>
                <?php $total_corretor_individual = $total_corretor_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']); ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_gerente_individual = $total_gerente_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) / 100 * 15); ?>
                <?php } ?>
                <?php $total_ti_individual = $total_ti_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) / 100 * 15); ?>
                <?php if ($item['Corretor']['id'] <> 7) { ?>
                    <?php $total_coordenador_individual = $total_coordenador_individual + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) / 100 * 15); ?>
                <?php } ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_gerente = $total_gerente + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) / 100 * 15); ?>
                <?php } ?>
                <?php $total_ti = $total_ti + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02); ?>
                <?php if ($item['Corretor']['id'] <> 7) { ?>
                    <?php $total_coordenador = $total_coordenador + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) / 100 * 15); ?>
                <?php } ?>
                <?php if (($item['Negociacao']['id'] == 27) or ($item['Negociacao']['id'] == 52) or ($item['Negociacao']['id'] == 60) or ($item['Negociacao']['id'] == 35) or ($item['Negociacao']['id'] == 28) or ($item['Negociacao']['id'] == 32) or ($item['Negociacao']['id'] == 49) or ($item['Negociacao']['id'] == 28)) { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) - (($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.05) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) / 100 * 15); ?>
                <?php } else { ?>
                    <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) - (($item['Contasrecebermov']['valorparcela'] - ((($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.02) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * 0.01) + (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) * $item['Corretor']['perc_comissao']))) / 100 * 15); ?>
                <?php } ?>
                <?php $total_recebido = $total_recebido + ($item['Contasrecebermov']['valorparcela'] / $cont_corretor) - (($item['Contasrecebermov']['valorparcela'] / $cont_corretor) / 100 * 15); ?>
            <?php } ?>
        </tr>
        <?php $corretor = $item['Corretor']['id']; ?>
        <?php $nome = $item['Corretor']['nome']; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="12"><?php echo ''; ?>&nbsp;</td>
        <td><strong><font color="blue"><?php echo number_format($total_corretor_individual, 2, ',', '.'); ?>&nbsp;</font></strong></td>
    </tr>
</table>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <!--<td><b><font color="green"><?php echo 'Total recebido (NF): ' . number_format($total_recebido, 2, ',', '.'); ?>&nbsp;</b></td>-->
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Total Corretor: ' . number_format($total_corretor, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <!--<td><b><font color="blue"><?php echo 'Total EL: ' . number_format($total_el, 2, ',', '.'); ?>&nbsp;</b></td>-->
    </tr>
</table>