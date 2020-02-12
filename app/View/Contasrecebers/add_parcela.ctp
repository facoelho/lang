<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar parcela", "title" => "Adicionar parcela")), array('action' => 'add_parcela'), array('escape' => false));
?>
<br>
<br>
<?php echo $this->Form->create('Contasreceber'); ?>
<fieldset>
    <table cellpadding="0" border="0" style ="width:50%">
        <tr>
            <th><?php echo 'Vencimento'; ?></th>
            <th><?php echo 'Valor parcela'; ?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('dtvencimento', array('id' => 'dtvencimento', 'type' => 'text', 'label' => false, 'style' => 'width:150px')); ?></td>
            <td><?php echo $this->Form->input('valorparcela', array('id' => 'valorparcela', 'type' => 'text', 'label' => false, 'style' => 'width:150px')); ?></td>
        </tr>
    </table>
</fieldset>
<?php echo $this->Form->end(__('Salvar pagamento')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valorparcela").maskMoney({showSymbol: false, decimal: ",", thousands: "", precision: 2});
        $("#dtvencimento").mask("99/99/9999");
    });

    var nome = $(this).attr('name');

</script>