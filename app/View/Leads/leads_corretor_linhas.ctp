<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<p><h2><center><b><?php echo $origen[0][0]['descricao']; ?></b></h2></center></p>
<br>
<?php while ($i < $cont) { ?>

    <?php $chart_div = 'chart_div' . $i; ?>

    <?php $column_chart_linha[$i]->div($chart_div); ?>

    <div id="graficos">
        <div id="<?php echo $chart_div ?>">
            <?php $this->GoogleCharts->createJsChart($column_chart_linha[$i]); ?>
        </div>
        <center><b><?php echo $corretors[$i][0]['nome']; ?></b></center>
    </div>
    <?php $i++; ?>
<?php } ?>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>