<?php $this->layout = 'naoLogado'; ?>

<?php $column_chart_barras->div('chart_div'); ?>

<div id="chart_div" style="position: relative; width: 1141px; height: 800px;">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>