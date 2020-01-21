<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
$dadosFormulario = $this->Session->read('dadosFormulario');
$parcela = number_format($dadosFormulario['Contasreceber']['valor_total'] / $dadosFormulario['Contasreceber']['parcelas'], 2, ",", "");
$i = 0;
?>
<br>
<br>
<?php echo $this->Form->create('Contasreceber'); ?>
<fieldset>
    <?php echo $this->Form->input('parcelas', array('label' => 'Número de parcelas', 'type' => 'text', 'readonly', 'style' => 'height: 15px;width:40px')); ?>
    <table cellpadding="0" border="0" style ="width:30%">
        <tr>
            <th><?php echo 'Vencimento'; ?></th>
            <th><?php echo 'Valor parcela'; ?></th>
        </tr>
        <?php while ($i < $dadosFormulario['Contasreceber']['parcelas']) : ?>
            <tr>
                <td><?php echo $this->Form->input('dtvencimento.' . $i, array('id' => 'dtvencimentoID', 'type' => 'text', 'label' => false, 'required' => true)); ?></td>
                <td><?php echo $this->Form->input('valorparcela.' . $i, array('id' => 'valorparcelaID', 'type' => 'text', 'label' => false, 'value' => $parcela, 'required' => true)); ?></td>
            </tr>
            <?php $i++; ?>
        <?php endwhile; ?>
    </table>
    <?php
    echo $this->Form->input('confirma', array('type' => 'hidden', 'value' => 'S'));
    echo $this->Form->input('valortotal', array('id' => 'valortotalID', 'type' => 'text', 'label' => false, 'hidden', 'value' => $dadosFormulario['Contasreceber']['valor_total']));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Lançar parcelas')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
//        $("#valorparcelaID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        $("#dtvencimentoID").mask("99/99/9999");
    });
</script>