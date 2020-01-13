<?php
$this->layout = 'naoLogado';
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<p><h2><center><b><?php echo $origen[0][0]['descricao']; ?></b></h2></center></p>
<br>
<?php $chart_div_ficha = 'chart_div_ficha'; ?>

<?php $column_chart_ficha_barras->div($chart_div_ficha); ?>
<div id="<?php echo $chart_div_ficha ?>">
    <?php $this->GoogleCharts->createJsChart($column_chart_ficha_barras); ?>
</div>
<center><b><?php echo 'PERCENTUAL DE APROVEITAMENTO EM FICHAS'; ?></b></center>
<br>
<?php $chart_div_compra = 'chart_div_compra'; ?>

<?php $column_chart_compra_barras->div($chart_div_compra); ?>
<div id="<?php echo $chart_div_compra ?>">
    <?php $this->GoogleCharts->createJsChart($column_chart_compra_barras); ?>
</div>
<center><b><?php echo 'PERCENTUAL DE APROVEITAMENTO EM COMPRAS'; ?></b></center>