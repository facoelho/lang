<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false));
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar parcela", "title" => "Adicionar parcela")), array('action' => 'add_parcela', $contasreceber_id, $negociacao_id), array('escape' => false));
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
            <th class="actions"><?php echo __('Ações'); ?></th>
        </tr>
        <?php foreach ($contasrecebers as $item): ?>
            <tr>
                <?php if (!empty($item['Contasrecebermov']['dtpagamento'])) { ?>
                    <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtvencimento'])); ?></td>
                <?php } else { ?>
                    <td><?php echo $this->Form->input('dtvencimento.' . $item['Contasrecebermov']['id'], array('id' => 'dtvencimento', 'type' => 'text', 'label' => false, 'style' => 'width:150px', 'value' => date('d/m/Y', strtotime($item['Contasrecebermov']['dtvencimento'])))); ?></td>
                <?php } ?>
                <?php if (!empty($item['Contasrecebermov']['dtpagamento'])) { ?>
                    <td><?php echo number_format($item['Contasrecebermov']['valorparcela'], 2, ",", "."); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($item['Contasrecebermov']['dtpagamento'])); ?></td>
                <?php } else { ?>
                    <td><?php echo $this->Form->input('valorparcela.' . $item['Contasrecebermov']['id'], array('id' => 'valorparcela', 'type' => 'text', 'label' => false, 'style' => 'width:150px', 'value' => $item['Contasrecebermov']['valorparcela'])); ?></td>
                    <td><?php echo $this->Form->input('dtpagamento.' . $item['Contasrecebermov']['id'], array('id' => 'dtpagamento', 'type' => 'text', 'label' => false, 'style' => 'width:130px')); ?></td>
                <?php } ?>
                <td>
                    <div id="botoes">
                        <?php
                        if (empty($item['Contasrecebermov']['dtpagamento'])) {
                            echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete_parcela', $item['Contasrecebermov']['id'], $item['Contasrecebermov']['contasreceber_id'], $item['Contasreceber']['negociacao_id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
                            );
                        }
                        ?>
                    </div>
                </td>
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