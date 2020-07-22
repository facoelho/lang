<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <center><b><?php echo 'PERCENTUAL DE CONVERSÃO GERAL'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<?php while ($i < $cont) { ?>

    <?php $chart_div = 'chart_div' . $i; ?>

    <?php $column_chart_barras[$i]->div($chart_div); ?>

    <div id="<?php echo $chart_div ?>">
        <?php $this->GoogleCharts->createJsChart($column_chart_barras[$i]); ?>
    </div>
    <?php $i++; ?>
<?php } ?>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>