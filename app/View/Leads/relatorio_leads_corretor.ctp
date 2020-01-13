<?php
$this->layout = 'naoLogado';
echo '<b>Impresso: </b>' . date('d/m/Y H:i');
?>
<br><br>
<?php echo '<b>Origen: </b>' . $leads[0]['Origen']['descricao']; ?>
<br><br>
<?php echo '<b>Corretor: </b>' . $leads[0]['Corretor']['nome']; ?>
<br><br>
<?php echo $this->Form->create('Lead'); ?>
<table cellpadding="0" border="0" style ="width:100%;">
    <tr>
        <th><?php echo 'Cod'; ?></th>
        <th><?php echo 'Nome'; ?></th>
        <th><?php echo 'E-mail'; ?></th>
        <th><?php echo 'Fone'; ?></th>
        <th colspan="10"><?php echo ''; ?></th>
    </tr>
    <?php foreach ($leads as $item): ?>
        <tr>
            <td><?php echo $item['Cliente']['id']; ?></td>
            <td><?php echo $item['Cliente']['nome']; ?></td>
            <td><?php echo $item['Cliente']['email']; ?></td>
            <td><?php echo $item['Cliente']['telefone']; ?></td>
            <td><?php echo 'sem/atendimento'; ?></td>
            <td><?php echo 'fone'; ?></td>
            <td><?php echo 'whats'; ?></td>
            <td><?php echo 'email'; ?></td>
            <td><?php echo 'sem/contato'; ?></td>
            <td><?php echo 'preco'; ?></td>
            <td><?php echo 'localizacao'; ?></td>
            <td><?php echo 'material enviado'; ?></td>
            <td><?php echo 'ficha'; ?></td>
            <td><?php echo 'compra'; ?></td>
        </tr>
        <td colspan="13"><?php echo '<b>Obs: </b>' . $item['Lead']['obs']; ?></td>
    <?php endforeach; ?>
</table>
