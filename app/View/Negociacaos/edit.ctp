<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Negociacao'); ?>
<fieldset>
    <?php
    echo $this->Form->input('referencia', array('id' => 'referenciaID', 'label' => 'Referência'));
    echo $this->Form->input('unidade', array('id' => 'unidadeID', 'label' => 'Unidade'));
    echo $this->Form->input('cliente_vendedor', array('id' => 'cliente_vendedorID', 'label' => 'Cliente vendedor'));
    echo $this->Form->input('cliente_comprador', array('id' => 'cliente_compradorID', 'label' => 'Cliente comprador'));
    echo $this->Form->input('endereco', array('id' => 'enderecoID', 'label' => 'Endereço'));
    echo $this->Form->input('valor_imovel', array('id' => 'valor_imovelID', 'type' => 'text', 'label' => 'Valor imóvel'));
    echo $this->Form->input('valor_proposta', array('id' => 'valor_propostaID', 'type' => 'text', 'label' => 'Valor proposta'));
    echo $this->Form->input('Corretor.Corretor', array('title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Escolha o(s) corretor(es)', 'type' => 'select', 'multiple' => true));
//    echo $this->Form->input('status', array('id' => 'statusID', 'label' => 'Status'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
//        $("#valor_imovelID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
//        $("#valor_propostaID").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
    });
</script>