<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Funcionario'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome');
    echo $this->Form->input('ativo', array('id' => 'ativoID', 'options' => $opcoes, 'type' => 'select', 'label' => 'Ativo'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>