<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Origen'); ?>
<fieldset>
    <?php
    echo $this->Form->input('descricao');
    echo $this->Form->input('valor_investido', array('id' => 'valorID', 'type' => 'text', 'label' => 'Valor investido'));
    echo $this->Form->input('compoem_indicador', array('id' => 'corretorID', 'options' => $opcao, 'type' => 'select', 'label' => 'Compõem indicador'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
    });
</script>