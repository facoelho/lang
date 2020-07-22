<br>
<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('controller' => 'Caixas', 'action' => 'index'), array('escape' => false));
?>
<br>
<br>
<?php echo $this->Form->create('Contasrecebermov'); ?>
<fieldset>
    <?php
    echo $this->Form->input('valorparcela', array('id' => 'valorparcelaID', 'type' => 'text', 'label' => 'Parcela', 'required' => true, 'value' => $this->request->data['Contasrecebermov']['valorparcela']));
    echo $this->Form->input('valorcorretor', array('id' => 'valorcorretorID', 'type' => 'text', 'label' => 'Corretor', 'required' => true, 'value' => $this->request->data['Contasrecebermov']['valorparcela']));
    echo $this->Form->input('valorgerente', array('id' => 'valorgerenteID', 'type' => 'text', 'label' => 'Gerente', 'required' => true));
    echo $this->Form->input('valorti', array('id' => 'valortiID', 'type' => 'text', 'label' => 'TI', 'required' => true));
    echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'type' => 'select', 'options' => $corretors, 'label' => 'Agenciador', 'empty' => '-- Agenciador --'));
    echo $this->Form->input('valoragenciador', array('id' => 'valoragenciadorID', 'type' => 'text', 'label' => 'Valor Agenciador($)'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('SALVAR')); ?>

<script type="text/javascript">

    jQuery(document).ready(function() {
        $("#valorparcelaID").maskMoney({showSymbol: false, decimal: ",", thousands: "", precision: 2});
        $("#dtcaixa").mask("99/99/9999");
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
