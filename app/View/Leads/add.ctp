<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Origen'); ?>
<fieldset>
    <?php
    echo $this->Form->input('descricao');
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>