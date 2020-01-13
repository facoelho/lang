<?php echo $this->Form->create('Relatorio', array('escape' => false, 'target' => '_blank')); ?>
<fieldset>
    <?php
    echo $this->Form->input('tipo', array('id' => 'tipoID', 'options' => $tipo, 'type' => 'select', 'label' => 'Formato do gráfico', 'empty' => ' -- Selecione uma opção -- '));
    ?>
    <div id="formCorretor">
        <?php
        echo $this->Form->input('corretor_id', array('id' => 'corretorID', 'options' => $corretors, 'type' => 'select', 'label' => 'Corretores', 'empty' => ' -- Selecione o corretor -- '));
        echo $this->Form->input('origenaux', array('id' => 'origenauxID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Empreendimentos', 'type' => 'select', 'multiple' => true));
        ?>
    </div>
    <div id="formOrigen">
        <?php
        echo $this->Form->input('origen', array('id' => 'origenID', 'title' => 'CTRL + Click (para selecionar mais de um)', 'label' => 'Empreendimentos', 'type' => 'select', 'multiple' => true));
        ?>
    </div>
    <div id="formGrafico">
        <?php
        echo $this->Form->input('grafico', array('id' => 'graficoID', 'options' => $grafico, 'type' => 'select', 'label' => 'Tipo de gráfico'));
        ?>
    </div>
</fieldset>
<?php echo $this->Form->end(__('Gerar gráficos')); ?>

<?php
$this->Js->get('#corretorID')->event(
        'change', $this->Js->request(
                array('controller' => 'Origens', 'action' => 'buscaOrigens', 'Origen'), array('update' => '#origenauxID',
            'async' => true,
            'method' => 'post',
            'dataExpression' => true,
            'data' => $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            )),
                )
        )
);
?>

<script type="text/javascript">

    jQuery(document).ready(function() {

        $("#formCorretor").hide();
        $("#formGrafico").hide();
        $("#formOrigen").hide();

        $("#tipoID").change(function() {
            if ($("#tipoID").val() == 'CE') {
                $("#formCorretor").show();
                $("#formGrafico").hide();
                $("#formOrigen").hide();
            } else if ($("#tipoID").val() == 'DE') {
                $("#formCorretor").hide();
                $("#formOrigen").show();
                $("#formGrafico").show();
            } else if ($("#tipoID").val() == 'PE') {
                $("#formCorretor").hide();
                $("#formOrigen").show();
                $("#formGrafico").hide();
            } else if ($("#tipoID").val() == 'PG') {
                $("#formCorretor").hide();
                $("#formOrigen").hide();
                $("#formGrafico").hide();
            } else if ($("#tipoID").val() == 'CL') {
                $("#formCorretor").hide();
                $("#formOrigen").show();
                $("#formGrafico").hide();
            } else {
                $("#formCorretor").hide();
                $("#formGrafico").hide();
                $("#formOrigen").hide();
            }
        });
    });
</script>