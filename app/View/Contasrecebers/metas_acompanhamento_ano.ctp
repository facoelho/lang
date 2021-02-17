<?php $this->layout = 'naoLogado'; ?>

<?php $column_chart_barras_ano->div('chart_div_ano'); ?>
<?php $piechart->div('pie_chart_div'); ?>
<?php $piechart_super->div('pie_chart_super_div'); ?>

<div id="chart_div_ano">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras_ano); ?>
</div>
<center><b><?php echo 'Meta Anual (2021)'; ?></b></center>
<div id="pie_chart_div">
    <?php $this->GoogleCharts->createJsChart($piechart); ?>
</div>
<center><b><?php echo 'Meta Anual (2021)'; ?></b></center>
<div id="pie_chart_super_div">
    <?php $this->GoogleCharts->createJsChart($piechart_super); ?>
</div>
<center><b><?php echo 'Super Meta Anual (2021)'; ?></b></center>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>