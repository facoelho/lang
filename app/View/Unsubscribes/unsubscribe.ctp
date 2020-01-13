<?php

$this->layout = 'naoLogado';
?>
<?php
echo $this->Html->image("/img/logo_medio.png", array("alt" => "Imobiliária Eduardo Lang", "title" => "Imobiliária Eduardo Lang"));
?>
<br><br>
<div id="linha" style="padding-top:2%; border-top:3px solid #ffcb05">
</div>
<?php echo $this->Form->create('Unsubscribe'); ?>
<fieldset>
    <?php echo $this->Form->input('email', array('id' => 'email', 'type' => 'readonly', 'label' => false, 'value' => $email));?>
    <?php echo $this->Form->end(__('Cancelar Inscrição')); ?>
</fieldset>

<script type="text/javascript">

</script>