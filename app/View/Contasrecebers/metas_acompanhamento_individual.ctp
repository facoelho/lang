<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <center><b><?php echo '1º TRIMESTRE'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>
<br>
<?php foreach ($corretors as $key => $corretor): ?>

    <?php $chart_div = 'chart_div' . $corretor[0]['id']; ?>

    <?php $column_chart_barras[$corretor[0]['id']]->div($chart_div); ?>

    <div id="graficos_metas">
        <div id="<?php echo $chart_div ?>">
            <?php $this->GoogleCharts->createJsChart($column_chart_barras[$corretor[0]['id']]); ?>
        </div>
        <center><b><?php echo $corretor[0]['nome']; ?></b></center>
    </div>
    <?php $i++; ?>
<?php endforeach; ?>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>