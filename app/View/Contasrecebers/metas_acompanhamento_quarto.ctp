<?php $this->layout = 'naoLogado'; ?>

<?php $column_chart_barras->div('chart_div'); ?>

<div id="chart_div">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>
<center><b><?php echo 'Meta 4º Trimestre'; ?></b></center>

<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>