<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <center><b><?php echo 'DISTRIBUIÇÃO LEADS/CORRETOR'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<p><h2><center><b><?php echo $nome; ?></b></h2></center></p>

<?php $chart_div = 'chart_div'; ?>

<?php $column_chart_barras->div($chart_div); ?>
<div id="<?php echo $chart_div ?>">
    <?php $this->GoogleCharts->createJsChart($column_chart_barras); ?>
</div>

<?php $chart_div_pizza = 'chart_div_pizza'; ?>

<?php $piechart->div($chart_div_pizza); ?>

<div id="<?php echo $chart_div_pizza ?>">
    <?php $this->GoogleCharts->createJsChart($piechart); ?>
</div>