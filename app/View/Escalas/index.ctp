<?php echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank')); ?>
<fieldset>
    <?php
    echo $this->Form->input('anomes', array('id' => 'dtinicioID', 'class' => 'data', 'type' => 'text', 'label' => 'Mês da escala'));
    echo $this->Form->input('corretor', array('id' => 'corretorID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Corretor', 'type' => 'select', 'multiple' => true));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Imprimir')); ?>

<script>

    jQuery(document).ready(function() {

        $("#dtinicioID").mask("99/9999");

        $(".data").datepicker({
            dateFormat: 'mm/yy',
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