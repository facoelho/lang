<?php echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank')); ?>
<fieldset>
    <div id="formPeriodo">
        <?php
        echo $this->Form->input('dtinicio', array('id' => 'dtinicioID', 'class' => 'data', 'type' => 'text', 'label' => 'Data inicial'));
        echo $this->Form->input('dtfim', array('id' => 'dtfimID', 'class' => 'data', 'type' => 'text', 'label' => 'Data final'));
        ?>
    </div>
    <?php
    echo $this->Form->input('origen', array('id' => 'origenID', 'options' => $origens, 'type' => 'select', 'label' => 'Mídia de origem', 'empty' => ' -- Selecione a Mídia de origem -- '));
    echo $this->Form->input('tipo', array('id' => 'tipoID', 'options' => $tipo, 'type' => 'select', 'label' => 'Tipo de gráfico'));
    ?>
    <div id="formCorretor">
        <?php
        echo $this->Form->input('corretor', array('id' => 'corretorID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Corretor', 'type' => 'select', 'multiple' => true));
        echo $this->Form->input('formato', array('id' => 'formatoID', 'options' => $formato, 'type' => 'select', 'label' => 'Formato do gráfico'));
        ?>
    </div>
    <div id="formCorretor">
        <?php
        echo $this->Form->input('grafico', array('id' => 'graficoID', 'options' => $grafico, 'type' => 'select', 'label' => 'Tipo de gráfico'));
        ?>
    </div>
</fieldset>
<?php echo $this->Form->end(__('Gerar gráficos')); ?>

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