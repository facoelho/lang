<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Cliente'); ?>
<fieldset>
    <?php
    echo $this->Form->input('nome', array('id' => 'telefone', 'label' => 'Nome'));
    echo $this->Form->input('telefone', array('id' => 'telefone', 'label' => 'Telefone'));
    echo $this->Form->input('email', array('id' => 'email', 'label' => 'E-mail'));
    echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'type' => 'hidden', 'value' => $leads[0]['Corretor']['id']));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Editar')); ?>