<?php

$this->layout = 'naoLogado'; ?>
<?php
$corretor_id = '';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <?php echo '<b>'.'Origem: '.'</b>' . $leads[0]['Origen']['descricao'] ; ?>
    <br>
    <?php echo '<b>'.'Importação: '.'</b>' . date('d/m/Y H:i', strtotime($leads[0]['Importacaolead']['created'])); ?>
</div>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo 'Corretor'; ?></th>
        <th><?php echo 'Cliente'; ?></th>
        <th><?php echo 'E-mail'; ?></th>
        <th><?php echo 'Telefone'; ?></th>
    </tr>
    <?php foreach ($leads as $item): ?>
    <tr>
        <?php if ($corretor_id <> $item['Corretor']['id']) { ?>
        <td><b><?php echo $item['Corretor']['nome']; ?>&nbsp;</b></td>
        <?php } else { ?>
        <td><?php echo ''; ?>&nbsp;</td>
        <?php } ?>
        <td><?php echo $item['Cliente']['nome']; ?>&nbsp;</td>
        <td><?php echo $item['Cliente']['email']; ?>&nbsp;</td>
        <td><?php echo $item['Cliente']['telefone']; ?>&nbsp;</td>
        <?php $corretor_id = $item['Corretor']['id']; ?>
    </tr>
    <?php endforeach; ?>
</table>