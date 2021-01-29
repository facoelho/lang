<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
$total_recebido = 0;
$total_el = 0;
$total_vgv = 0;
$total_receber = 0;
$total_recebido = 0;
?>
<center><b><?php echo 'VGV FINAL'; ?></b></center>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Valor'; ?></th>
    </tr>
    <?php foreach ($vgv as $item): ?>
        <tr>
            <td><?php echo h($item[0]['nome']); ?>&nbsp;</td>
            <td><?php echo number_format($item[0]['vgv'], 2, ',', '.'); ?>&nbsp;</td>
        </tr>
        <?php $total_vgv = $total_vgv + $item[0]['vgv']; ?>
    <?php endforeach; ?>
    <tr>
        <td><b><?php echo 'Total'; ?>&nbsp;</b></td>
        <td><b><?php echo number_format($total_vgv, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>
<br><br>
<center><b><?php echo 'VALOR TOTAL À RECEBER'; ?></b></center>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Valor'; ?></th>
    </tr>
    <?php foreach ($total as $item): ?>
        <tr>
            <td><?php echo h($item[0]['nome']); ?>&nbsp;</td>
            <td><?php echo number_format($item[0]['total'], 2, ',', '.'); ?>&nbsp;</td>
        </tr>
        <?php $total_receber = $total_receber + $item[0]['total']; ?>
    <?php endforeach; ?>
    <tr>
        <td><b><?php echo 'Total'; ?>&nbsp;</b></td>
        <td><b><?php echo number_format($total_receber, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>
<br><br>
<center><b><?php echo 'VALOR RECEBIDO'; ?></b></center>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Valor'; ?></th>
    </tr>
    <?php foreach ($recebidos as $item): ?>
        <tr>
            <td><?php echo h($item[0]['nome']); ?>&nbsp;</td>
            <td><?php echo number_format($item[0]['parcela'], 2, ',', '.'); ?>&nbsp;</td>
        </tr>
        <?php $total_recebido = $total_recebido + $item[0]['parcela']; ?>
    <?php endforeach; ?>
    <tr>
        <td><b><?php echo 'Total'; ?>&nbsp;</b></td>
        <td><b><?php echo number_format($total_recebido, 2, ',', '.'); ?>&nbsp;</b></td>
    </tr>
</table>