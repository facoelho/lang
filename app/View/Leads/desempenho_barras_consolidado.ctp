<?php
$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<p><h2><center><b><?php echo $origen[0][0]['descricao']; ?></b></h2></center></p>
<br>

<?php $column_chart_barras->div('chart_div'); ?>

<div id="chart_div">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>