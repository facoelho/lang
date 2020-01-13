<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
?>
<br>
<br>
<p>
    <strong> Id: </strong>
    <?php echo $negociacao['Negociacao']['id']; ?>
    <br>
    <strong> Referência: </strong>
    <?php echo $negociacao['Negociacao']['referencia']; ?>
    <br>
    <strong> Endereço: </strong>
    <?php echo $negociacao['Negociacao']['endereco']; ?>
    <br>
    <strong> Vendedor: </strong>
    <?php echo $negociacao['Negociacao']['cliente_vendedor']; ?>
    <br>
    <strong> Comprador: </strong>
    <?php echo $negociacao['Negociacao']['cliente_comprador']; ?>
    <br>
    <strong> Valor do imóvel: </strong>
    <?php echo number_format($negociacao['Negociacao']['valor_imovel'], 2, ',', '.'); ?>
    <br>
    <strong> Valor da proposta: </strong>
    <?php echo number_format($negociacao['Negociacao']['valor_proposta'], 2, ',', '.'); ?>
    <br>
    <strong> Cadastrado: </strong>
    <?php echo $negociacao['User']['nome'] . ' ' . $negociacao['User']['sobrenome'] . ' - ' . date('d/m/Y', strtotime($negociacao['Negociacao']['created'])) . " | " . date('H:i', strtotime($negociacao['Negociacao']['created'])); ?>
    <br>
    <strong> Status atual: </strong>
    <?php if ($negociacao['Negociacao']['status'] == 'E') { ?>
        <?php echo 'EM ANDAMENTO'; ?>
    <?php } elseif ($negociacao['Negociacao']['status'] == 'A') { ?>
        <?php echo 'ACEITA'; ?>
    <?php } elseif ($negociacao['Negociacao']['status'] == 'F') { ?>
        <?php echo 'FINALIZADO'; ?>
    <?php } elseif ($negociacao['Negociacao']['status'] == 'C') { ?>
        <?php echo 'CANCELADO'; ?>
    <?php } ?>
</p>
<br>
<div id="esquerda">
    <strong><h3> Históricos </h3></strong>
    <br>
    <?php foreach ($negociacao['Negociacaohistorico'] as $key => $item) : ?>
        <p>
            <?php $usuario = $this->requestAction('/Users/busca_nome_usuario', array('pass' => array($item['user_id']))); ?>
            <?php echo '<b>' . date('d/m/Y', strtotime($item['created'])) . '</b>' . ' | ' . $usuario; ?>
            <br>
            <?php echo $item['obs']; ?>
        </p>
        <br>
    <?php endforeach; ?>
</div>
<br>
<div id="direita">
    <strong><h3> Status </h3></strong>
    <br>
    <?php foreach ($negociacao['Negociacaostat'] as $key => $item) : ?>
        <p>
            <?php $usuario = $this->requestAction('/Users/busca_nome_usuario', array('pass' => array($item['user_id']))); ?>
            <?php if ($item['status'] == 'E') { ?>
                <b><?php echo 'EM ANDAMENTO'; ?></b>
            <?php } elseif ($item['status'] == 'A') { ?>
                <b><?php echo 'ACEITA'; ?></b>
            <?php } elseif ($item['status'] == 'F') { ?>
                <b><?php echo 'FINALIZADA'; ?></b>
            <?php } ?>
            <?php echo ' | ' . date('d/m/Y', strtotime($item['created'])) . ' | ' . $usuario; ?>
            <br>
            <?php echo $item['obs']; ?>
        </p>
        <br>
    <?php endforeach; ?>
</div>
</p>