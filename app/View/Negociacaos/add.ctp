<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Negociacao'); ?>
<fieldset>
    <?php
    if (!empty($cliente_vendedor)) {
        ?>
        <table border="0" style ="width:100%">
            <tr>
                <td><?php echo $this->Form->input('cliente_vendedor_id', array('id' => 'clientevendedorID', 'type' => 'select', 'options' => $cliente_vendedor, 'label' => 'Cliente')); ?></td>
                <td><?php echo "<div style='float: left; width: 50%; clear: none; margin-top: 30px; padding: 0;'>" . $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar o numero do ticket", "title" => "Alterar cliente")), array('controller' => 'Clientes', 'action' => 'index', 'V'), array('escape' => false)) . "</div>"; ?></td>
            </tr>
        </table>
        <?php
    } else {
        ?>
        <table border="0" style ="width:10%">
            <tr>
                <td><strong> Cliente vendedor: </strong></td>
                <td><?php echo $this->Html->link($this->Html->image("botoes/add_min.png", array("alt" => "Vincular a um ticket", "title" => "Adicionar cliente")), array('controller' => 'Clientes', 'action' => 'index', 'V'), array('escape' => false)); ?></td>
            </tr>
        </table>
        <br>
        <?php
    }
    if (!empty($cliente_comprador)) {
        ?>
        <table border="0" style ="width:100%">
            <tr>
                <td><?php echo $this->Form->input('cliente_comprador_id', array('id' => 'clientecompradorID', 'type' => 'select', 'options' => $cliente_comprador, 'label' => 'Cliente')); ?></td>
                <td><?php echo "<div style='float: left; width: 50%; clear: none; margin-top: 30px; padding: 0;'>" . $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar o numero do ticket", "title" => "Alterar cliente")), array('controller' => 'Clientes', 'action' => 'index', 'C'), array('escape' => false)) . "</div>"; ?></td>
            </tr>
        </table>
        <?php
    } else {
        ?>
        <table border="0" style ="width:10%">
            <tr>
                <td><strong> Cliente comprador: </strong></td>
                <td><?php echo $this->Html->link($this->Html->image("botoes/add_min.png", array("alt" => "Vincular a um ticket", "title" => "Adicionar cliente")), array('controller' => 'Clientes', 'action' => 'index', 'C'), array('escape' => false)); ?></td>
            </tr>
        </table>
        <br>
        <?php
    }
    echo $this->Form->input('referencia', array('id' => 'referenciaID', 'label' => 'Referência'));
    echo $this->Form->input('unidade', array('id' => 'unidadeID', 'label' => 'Unidade'));
//    echo $this->Form->input('cliente_vendedor', array('id' => 'cliente_vendedorID', 'label' => false, 'hidden' => true));
//    echo $this->Form->input('cliente_comprador', array('id' => 'cliente_compradorID', 'label' => false, 'hidden' => true));
    echo $this->Form->input('endereco', array('id' => 'enderecoID', 'label' => 'Endereço'));
    echo $this->Form->input('valor_imovel', array('id' => 'valor_imovelID', 'type' => 'text', 'label' => 'Valor imóvel'));
    echo $this->Form->input('valor_proposta', array('id' => 'valor_propostaID', 'type' => 'text', 'label' => 'Valor proposta'));
    echo $this->Form->input('corretor', array('id' => 'corretorID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Corretor', 'type' => 'select', 'multiple' => true));
    echo $this->Form->input('Negociacao.corretor_agenciador_id', array('id' => 'statusID', 'options' => $corretors, 'label' => 'Agenciador', 'empty' => '-- Selecione o agenciador --'));
    echo $this->Form->input('Negociacaostat.status', array('id' => 'statusID', 'options' => $status, 'label' => 'Status'));
    echo $this->Form->input('Negociacaostat.obs', array('id' => 'obs', 'label' => 'Observação'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valor_imovelID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        $("#valor_propostaID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        document.getElementById('clientevendedorID').focus();
    });
</script>