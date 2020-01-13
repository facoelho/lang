<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Importacaolead', array('type' => 'file')); ?>
<fieldset>
    <?php
    echo $this->Form->input('origem_id', array('id' => 'origemID', 'type' => 'select', 'options' => $origens, 'label' => 'Mídia de referência', 'empty' => '-- Selecione a Mídia de referência --'));
    echo $this->Form->input('arquivoitem', array('id' => 'arquivoitemID', 'type' => 'file', 'class' => 'file', 'label' => 'Somente arquivos *.csv serão validados'));
    echo $this->Form->input('arquivo', array('type' => 'hidden'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Importar')); ?>