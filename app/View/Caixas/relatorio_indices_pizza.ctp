<?php $this->layout = 'naoLogado'; ?>

<?php $pie_chart_qtd->div('chart_div'); ?>
<?php $pie_chart_valor->div('valor'); ?>

<div id="chart_div">
    <?php echo $this->GoogleCharts->createJsChart($pie_chart_qtd); ?>
</div>
<br>
<div id="valor">
    <?php echo $this->GoogleCharts->createJsChart($pie_chart_valor); ?>
</div>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>
