<?php
$this->layout = 'naoLogado';
$i = 0;
echo $this->Html->image("/img/logo.png", array("alt" => "Logo", "title" => "Logo"));
?>
<div id="informacao_leads">
    <b><?php echo date('d/m/Y H:i'); ?></b>
</div>

<br>
<?php while ($i < $cont) { ?>

    <?php $chart_div = 'chart_div' . $i; ?>

    <?php $piechart[$i]->div($chart_div); ?>

    <div id="<?php echo $chart_div ?>">
        <?php $this->GoogleCharts->createJsChart($piechart[$i]); ?>
    </div>
    <?php $descricao = $this->requestAction('/Leads/busca_nome_empreendimento', array('pass' => array($origens[$i]))); ?>
    <center><b><?php echo $descricao; ?></b></center>
    <?php $i++; ?>
<?php } ?>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>