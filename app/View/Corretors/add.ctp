<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Corretor'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome');
    echo $this->Form->input('email');
    echo $this->Form->input('gerente_equipe', array('id' => 'corretorID', 'options' => $corretors, 'type' => 'select', 'label' => 'Gerente', 'empty' => '-- Selecione o Gerente --'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>