<?php

echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<p>
    <?php echo '<b> Desempenho: </b>'. substr($this->request->data['Desempenho']['dtinicio'], 8, 2).'-'.substr($this->request->data['Desempenho']['dtinicio'], 5, 2).'-'.substr($this->request->data['Desempenho']['dtinicio'], 0, 4). ' à ' . substr($this->request->data['Desempenho']['dtfim'], 8, 2).'-'.substr($this->request->data['Desempenho']['dtfim'], 5, 2).'-'.substr($this->request->data['Desempenho']['dtfim'], 0, 4);?>
    <br>
<?php echo '<b> Corretor: </b>' . $this->request->data['Corretor']['nome'];?>
</p>
<br>
<?php echo $this->Form->create('Desempenhoindivid'); ?>
<fieldset>
    <?php
    echo $this->Form->input('vgv_avulso', array('id' => 'vgv_avulso', 'type' => 'text', 'label' => 'VGV Avulso'));
    echo $this->Form->input('vgv_emp', array('id' => 'vgv_emp', 'type' => 'text', 'label' => 'VGV Empreendimentos'));
    echo $this->Form->input('agenciamentos', array('id' => 'agenciamentos', 'type' => 'text', 'label' => 'Agenciamentos'));
    echo $this->Form->input('plantao_imob', array('id' => 'plantao_imob', 'type' => 'text', 'label' => 'Plantão imobiliária'));
    echo $this->Form->input('plantao_emp', array('id' => 'plantao_emp', 'type' => 'text', 'label' => 'Plantão Empreendimentos'));
    echo $this->Form->input('acao_ext', array('id' => 'acao_ext', 'type' => 'text', 'label' => 'Ações externas'));
    echo $this->Form->input('call_center', array('id' => 'call_center', 'type' => 'text', 'label' => 'Call Center'));
    echo $this->Form->input('sistema', array('id' => 'sistema', 'type' => 'text', 'label' => 'Sistema'));
    echo $this->Form->input('desempenho_id', array('id' => 'desempenho_id', 'type' => 'text', 'label' => false));
    echo $this->Form->input('corretor_id', array('id' => 'corretor_id', 'type' => 'text', 'label' => false));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<script type="text/javascript">
    jQuery(document).ready(function () {
        $("#vgv_avulso").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
        $("#vgv_emp").maskMoney({showSymbol: false, decimal: ",", thousands: ".", precision: 2});
    });
</script>