<?php

$this->layout = 'naoLogado'; ?>
<?php
$corretor_id = '';
$origen_id = '';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i') ; ?></b>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Data'; ?></th>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Mídia'; ?></th>
        <th><?php echo 'Cliente'; ?></th>
        <th><?php echo 'E-mail'; ?></th>
        <th><?php echo 'Telefone'; ?></th>
    </tr>
    <?php foreach ($leads as $item): ?>
    <tr>
        <td><b><?php echo date('d/m/Y H:i', strtotime($item['Importacaolead']['created'])); ?>&nbsp;</b></td>
        <td><b><?php echo $item['Corretor']['nome']; ?>&nbsp;</b></td>
        <td><b><font color="blue"><?php echo $item['Origen']['descricao']; ?>&nbsp;</font></b></td>
        <?php if ($corretor_id == $item['Corretor']['id']) { ?>
        <?php if ($origen_id <> $item['Origen']['id']) { ?>
        <td><b><font color="blue"><?php echo $item['Origen']['descricao']; ?>&nbsp;</font></b></td>
        <?php } else { ?>
        <td><?php echo ''; ?>&nbsp;</td>
        <?php } ?>
        <?php } ?>
        <td><?php echo $item['Cliente']['nome']; ?>&nbsp;</td>
        <td><?php echo $item['Cliente']['email']; ?>&nbsp;</td>
        <td><?php echo $item['Cliente']['telefone']; ?>&nbsp;</td>
        <?php $corretor_id = $item['Corretor']['id']; ?>
        <?php $origen_id = $item['Origen']['id']; ?>
    </tr>
    <?php endforeach; ?>
</table>