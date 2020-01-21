<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Contasreceber'); ?>
<fieldset>
    <table cellpadding="0" border="0" style ="width:50%">
        <tr>
            <th><?php echo 'Vencimento'; ?></th>
            <th><?php echo 'Valor parcela'; ?></th>
            <th><?php echo 'Data pagamento'; ?></th>
        </tr>
        <?php foreach ($contasrecebers as $item): ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtvencimento'])); ?></td>
                <?php if (!empty($item['Contasrecebermov']['dtpagamento'])) { ?>
                    <td><?php echo number_format($item['Contasrecebermov']['valorparcela'], 2, ",", "."); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtpagamento'])); ?></td>
                <?php } else { ?>
                    <td><?php echo $this->Form->input('valorparcela.' . $item['Contasrecebermov']['id'], array('id' => 'valorparcela', 'type' => 'text', 'label' => false, 'style' => 'width:150px', 'value' => $item['Contasrecebermov']['valorparcela'])); ?></td>
                    <td><?php echo $this->Form->input('dtpagamento.' . $item['Contasrecebermov']['id'], array('id' => 'dtpagamento', 'type' => 'text', 'label' => false, 'style' => 'width:130px')); ?></td>
                <?php } ?>
                <?php echo $this->Form->input('valorparcela.' . $item['Contasrecebermov']['id'], array('id' => 'valorparcela', 'type' => 'hidden', 'label' => false, 'value' => $item['Contasrecebermov']['valorparcela'])); ?>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>
<?php echo $this->Form->end(__('Salvar pagamento')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valorlancamentoID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        $("#dtvencimentoID").mask("99/99/9999");
    });

    var nome = $(this).attr('name');

</script>