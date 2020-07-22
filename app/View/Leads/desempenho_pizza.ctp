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

    <?php $chart_div_pizza = 'chart_div_pizza' . $i; ?>

    <?php $piechart[$i]->div($chart_div_pizza); ?>

    <div id="<?php echo $chart_div_pizza ?>">
        <?php $this->GoogleCharts->createJsChart($piechart[$i]); ?>
    </div>
    <?php $nome = $this->requestAction('/Leads/busca_nome_corretor', array('pass' => array($corretors[$i]))); ?>
    <center><b><?php echo $nome; ?></b></center>
    <?php $i++; ?>
<?php } ?>
<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js https://www.google.com/jsapi"></script>