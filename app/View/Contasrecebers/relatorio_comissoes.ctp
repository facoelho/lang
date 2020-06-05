<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$total_recebido = 0;
$total_el = 0;
$total_corretor = 0;
$total_gerente = 0;
$total_ti = 0;
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
        <th><?php echo 'Valor parcela'; ?></th>
        <th><?php echo 'Corretor($)'; ?></th>
        <th><?php echo 'Gerente($)'; ?></th>
        <th><?php echo 'TI($)'; ?></th>
    </tr>
    <?php foreach ($contasrecebers as $item): ?>
        <tr>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Contasrecebermov']['valorparcela'], 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] * 0.4), 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] * 0.05), 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format(($item['Contasrecebermov']['valorparcela'] * 0.02), 2, ',', '.'); ?>&nbsp;</td>
            <?php $total_corretor = $total_corretor + ($item['Contasrecebermov']['valorparcela'] * 0.4); ?>
            <?php $total_gerente = $total_gerente + ($item['Contasrecebermov']['valorparcela'] * 0.05); ?>
            <?php $total_ti = $total_ti + ($item['Contasrecebermov']['valorparcela'] * 0.02); ?>
            <?php $total_el = $total_el + ($item['Contasrecebermov']['valorparcela'] - (($item['Contasrecebermov']['valorparcela'] * 0.02) + ($item['Contasrecebermov']['valorparcela'] * 0.05) + ($item['Contasrecebermov']['valorparcela'] * 0.4) )); ?>
            <?php $total_recebido = $total_recebido + $item['Contasrecebermov']['valorparcela']; ?>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td><b><font color="green"><?php echo 'Total recebido: ' . number_format($total_recebido, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Total Corretor: ' . number_format($total_corretor, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Total Gerente: ' . number_format($total_gerente, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="red"><?php echo 'Total TI: ' . number_format($total_ti, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
    <tr>
        <td><b><font color="blue"><?php echo 'Total EL: ' . number_format($total_el, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>