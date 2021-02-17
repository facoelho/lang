<?php echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank')); ?>
<fieldset>
    <?php
    echo $this->Form->input('ano', array('label' => false, 'type' => 'text', 'label' => 'Ano', 'style' => 'height: 30px;width:60px;margin-top:10px'));
    echo $this->Form->input('tipo', array('id' => 'tipoID', 'options' => $tipos, 'label' => 'Tipo de gráfico'));
    ?>
</fieldset>
<?php echo $this->Form->end(__('Gerar acompanhamento')); ?>

<script type="text/javascript">

    jQuery(document).ready(function() {

        $("#dtinicioID").mask("99/99/9999");
        $("#dtfimID").mask("99/99/9999");

        $("#formPeriodo").show();
        $("#formCorretor").hide();

        $("#tipoID").change(function() {
            if ($("#tipoID").val() !== 'DL') {
                $("#formCorretor").show();
                $("#formPeriodo").hide();
            } else {
                $("#formCorretor").hide();
                $("#formPeriodo").show();
            }
        });
    });
</script>