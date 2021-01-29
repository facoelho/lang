<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Contaspagar'); ?>
<fieldset>
    <?php
    echo $this->Form->input('contrato');
    echo $this->Form->input('proprietario');
    echo $this->Form->input('inquilino');
    echo $this->Form->input('valor', array('id' => 'valorID', 'type' => 'text', 'label' => 'Valor intermediação'));
    echo $this->Form->input('dtvencimento', array('id' => 'dtvencimento', 'class' => 'data', 'type' => 'text', 'label' => 'Vencimento'));
    echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'options' => $corretors, 'label' => 'Corretor agenciador', 'empty' => '-- Selecione o corretor --'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        $("#valorID").maskMoney({showSymbol: false, decimal: ",", thousands: "", precision: 2});
        $("#dtvencimento").mask("99/99/9999");
        $(".data").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
    });
</script>