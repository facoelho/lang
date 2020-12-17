<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <center><b><?php echo 'PERCENTUAL DE CONVERSÃO/EMPREENDIMENTO'; ?></b></center>
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<?php while ($i < $cont) { ?>

    <?php $chart_div = 'chart_div' . $i; ?>

    <?php $column_chart_barras[$i]->div($chart_div); ?>

    <div id="<?php echo $chart_div ?>">
        <?php $this->GoogleCharts->createJsChart($column_chart_barras[$i]); ?>
    </div>
    <?php $descricao = $this->requestAction('/Leads/busca_nome_empreendimento', array('pass' => array($origens[$i]))); ?>
    <center><b><?php echo $descricao; ?></b></center>
    <?php $i++; ?>
<?php } ?>
<script type="text/javascript" src="gstatic.com/charts/loader.js"></script>