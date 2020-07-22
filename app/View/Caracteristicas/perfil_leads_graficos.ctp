<?php
$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<?php $operacaopiechart->div('operacao_chart_div'); ?>
<div id="graficos_caracteristicas">
    <div id="operacao_chart_div">
        <?php echo $this->GoogleCharts->createJsChart($operacaopiechart); ?>
    </div>
</div>

<?php $situacaopiechart->div('situacao_chart_div'); ?>
<div id="graficos_caracteristicas">
    <div id="situacao_chart_div">
        <?php echo $this->GoogleCharts->createJsChart($situacaopiechart); ?>
    </div>
</div>

<?php $tipopiechart->div('tipo_chart_div'); ?>
<div id="graficos_caracteristicas">
    <div id="tipo_chart_div">
        <?php echo $this->GoogleCharts->createJsChart($tipopiechart); ?>
    </div>
</div>
<?php $dormitoriopiechart->div('dormitorio_chart_div'); ?>
<div id="graficos_caracteristicas">
    <div id="dormitorio_chart_div">
        <?php echo $this->GoogleCharts->createJsChart($dormitoriopiechart); ?>
    </div>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

