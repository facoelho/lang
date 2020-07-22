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
<center><b><?php echo 'VGV FINAL'; ?></b></center>
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
    <?php endforeach; ?>
</table>
<br><br>
<center><b><?php echo 'VALOR TOTAL À RECEBER'; ?></b></center>
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
    <?php endforeach; ?>
</table>
<br><br>
<center><b><?php echo 'VALOR RECEBIDO'; ?></b></center>
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
    <?php endforeach; ?>
</table>