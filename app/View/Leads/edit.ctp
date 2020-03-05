<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
$cont = 0;
?>
<br>
<br>
<?php echo $this->Form->create('Lead'); ?>
<fieldset>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo 'Cliente'; ?></th>
            <th><?php echo 'E-mail'; ?></th>
            <th><?php echo 'Telefone'; ?></th>
            <th><?php echo 'Corretor'; ?></th>
        </tr>
        <?php foreach ($leads as $item): ?>
            <?php $cont++; ?>
            <tr>
                <td><?php echo h($item['Cliente']['nome']); ?>&nbsp;</td>
                <td><?php echo h($item['Cliente']['email']); ?>&nbsp;</td>
                <td><?php echo h($item['Cliente']['telefone']); ?>&nbsp;</td>
                <td><?php echo $this->Form->input('corretor_id.' . $item['Lead']['id'], array('id' => 'corretorID', 'type' => 'select', 'options' => $corretors, 'value' => $item['Lead']['corretor_id'], 'label' => false, 'empty' => '-- Selecione o corretor--')); ?>&nbsp;</td>
                <?php $cont = $this->requestAction('/Leads/valida_vinculo_lead', array('pass' => array($item['Cliente']['email']))); ?>
                <?php if ($cont > 1) { ?>
                    <td><?php echo $this->Html->link($this->Html->image("botoes/alerta_min.png", array("alt" => "Verificar conflitos", "title" => "Verificar conflitos")), array('controller' => 'Importacaoleads', 'action' => 'relatorio_conflito_lead', $item['Cliente']['email']), array('escape' => false, 'target' => '_blank')); ?>&nbsp;</td>
                <?php } else { ?>
                    <td><?php echo ''; ?>&nbsp;</td>
                <?php } ?>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>
<br>
<?php echo $cont . " registros encontrados."; ?>
<br><br>
<?php echo $this->Form->end(__('Editar')); ?>
