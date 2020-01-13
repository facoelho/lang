<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<p><h2><center><b><?php echo 'QUANTIDADE DE REGISTROS'; ?></b></h2></center></p>

<?php $piechart->div('chart_div'); ?>

<div id="chart_div">
    <?php echo $this->GoogleCharts->createJsChart($piechart); ?>
</div>

<p><h2><center><b><?php echo 'VALOR EM PROPOSTAS'; ?></b></h2></center></p>

<?php $piechart_proposta->div('chart_div_proposta'); ?>

<div id="chart_div_proposta">
    <?php echo $this->GoogleCharts->createJsChart($piechart_proposta); ?>
</div>