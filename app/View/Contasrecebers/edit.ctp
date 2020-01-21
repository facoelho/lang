<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Contasreceber'); ?>
<fieldset>
    <table cellpadding="0" border="0" style ="width:20%">
        <tr>
            <th colspan="2"><?php echo 'Informe o número de parcelas'; ?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('parcelas', array('label' => false, 'type' => 'text', 'style' => 'height: 30px;width:40px;margin-top:10px')); ?></td>
            <td><?php echo $this->form->end('Lançar parcelas'); ?></td>
        </tr>
    </table>
    <?php
    echo $this->Form->input('valor_total', array('type' => 'hidden'));
    echo $this->Form->input('confirma', array('type' => 'hidden', 'value' => 'N'));
    ?>
</fieldset>
<?php // echo $this->Form->end(__('Lançar parcelas')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
    });
</script>