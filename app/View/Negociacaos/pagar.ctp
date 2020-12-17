<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<?php echo $this->Form->create('Negociacao'); ?>
<fieldset>
    <?php
    echo $this->Form->input('valor_imovel_aux', array('id' => 'valor_imovel_aux', 'type' => 'text', 'label' => 'Valor imóvel', 'value' => number_format($negociacao['Negociacao']['valor_proposta'], 2, ',', '.'), 'readonly' => true));
    echo $this->Form->input('honorarios', array('id' => 'honorarios', 'type' => 'text', 'label' => 'Honorarios'));
    echo $this->Form->input('perc_fechamento', array('id' => 'perc_fechamento', 'type' => 'text', 'label' => 'Perc fechamento', 'readonly' => true));
//        echo $this->Form->input('vgv', array('id' => 'vgv', 'type' => 'text', 'label' => 'VGV', 'readonly' => true));
    echo $this->Form->input('vgv_final', array('id' => 'vgv_final', 'type' => 'text', 'label' => 'VGV Final', 'readonly' => true));
    echo $this->Form->input('dtvenda', array('id' => 'dtvenda', 'class' => 'data', 'type' => 'text', 'label' => 'Data do fechamento do negócio'));
    echo $this->Form->input('valor_imovel', array('id' => 'valor_imovel', 'type' => 'text', 'label' => false, 'required' => true, 'value' => $negociacao['Negociacao']['valor_proposta'], 'hidden'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Adicionar')); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {

        $("#honorarios").change(function() {
            //calcula percentual fechamento
            var perc_fechamento = ($('#honorarios').val().replace(",", ".") * 100) / parseFloat($('#valor_imovel').val().replace(",", "."));
            $("#perc_fechamento").val(perc_fechamento.toFixed(2).replace(".", ","));
            //calcula vgv
//            var vgv = ($('#valor_imovel').val().replace(",", ".") * parseFloat($('#perc_fechamento').val().replace(",", ".")) / 100);
//            $("#vgv").val(vgv.toFixed(2).replace(".", ","));
            //calcula vgv final
            var vgv_final = ($('#valor_imovel').val().replace(",", ".") * parseFloat($('#perc_fechamento').val().replace(",", ".")) / 6);
            $("#vgv_final").val(vgv_final.toFixed(2).replace(".", ","));
        })

        $("#created").mask("99/99/9999");
        $("#dtvenda").mask("99/99/9999");
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