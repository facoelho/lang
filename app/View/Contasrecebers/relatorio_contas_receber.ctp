<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$valor_recebido = 0;
$saldo_final = 0;
?>
<div id="informacao_leads">
    <center><b><?php echo 'RELATÓRIO DE CONTAS A RECEBER'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Contas receber'; ?></th>
        <th><?php echo 'Status'; ?></th>
        <th><?php echo 'Nº parcelas'; ?></th>
        <th><?php echo 'Total'; ?></th>
        <th><?php echo 'Saldo'; ?></th>
        <th><?php echo 'Vencimento'; ?></th>
        <th><?php echo 'Pagamento'; ?></th>
        <th><?php echo 'Valor parcela'; ?></th>
    </tr>
    <?php foreach ($contasrecebers as $item): ?>
        <tr>
            <?php if ($contasreceber_id <> $item['Contasreceber']['id']) { ?>
                <td><?php echo h($item['Contasreceber']['id']); ?>&nbsp;</td>
                <?php if ($item['Contasreceber']['status'] == 'A') { ?>
                    <td><strong><font color="red"><?php echo 'Aberto'; ?>&nbsp;</font></strong></td>
                <?php } else { ?>
                    <td><strong><font color="green"><?php echo 'Fechado'; ?>&nbsp;</font></strong></td>
                <?php } ?>
                <td><?php echo h($item['Contasreceber']['parcelas']); ?>&nbsp;</td>
                <td><?php echo number_format($item['Contasreceber']['valor_total'], 2, ',', '.'); ?>&nbsp;</td>
                <?php $saldo = $this->requestAction('/Contasrecebers/calcula_saldo', array('pass' => array($item['Contasreceber']['id']))); ?>
                <td><?php echo number_format($saldo, 2, ',', '.'); ?>&nbsp;</td>
                <?php $saldo_final = $saldo_final + $saldo; ?>
            <?php } else { ?>
                <td colspan="5"><?php echo ''; ?>&nbsp;</td>
            <?php } ?>
            <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtvencimento'])); ?>&nbsp;</td>
            <?php if (!empty($item['Contasrecebermov']['dtpagamento'])) { ?>
                <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtpagamento'])); ?>&nbsp;</td>
                <?php $valor_recebido = $valor_recebido + $item['Contasrecebermov']['valorparcela']; ?>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>
            <td><?php echo number_format($item['Contasrecebermov']['valorparcela'], 2, ',', '.'); ?>&nbsp;</td>
        </tr>
        <?php $contasreceber_id = $item['Contasreceber']['id']; ?>
    <?php endforeach; ?>
</table>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td><b><font color="green"><?php echo 'Valor recebido: ' . number_format($valor_recebido, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Valor à receber: ' . number_format($saldo_final, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>