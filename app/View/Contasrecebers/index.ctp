<?php
echo $this->Html->link($this->Html->image("botoes/printer.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'relatorio_contas_receber'), array('escape' => false, 'target' => '_blank'));
echo $this->Html->link($this->Html->image("botoes/cifrao_2.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'relatorio_comissoes'), array('escape' => false, 'target' => '_blank'));
echo $this->Html->link($this->Html->image("botoes/ranking.jpg", array("alt" => "Ranking", "title" => "Ranking")), array('action' => 'relatorio_ranking'), array('escape' => false, 'target' => '_blank'));
?>
<br>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter8', array('id' => 'corretorID', 'class' => 'select-box', 'placeholder' => 'Corretor', 'empty' => '-- Corretor --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter1', array('class' => 'input-box', 'placeholder' => 'Referência'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('class' => 'input-box', 'placeholder' => 'Cliente vendedor'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('class' => 'input-box', 'placeholder' => 'Cliente comprador'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter6', array('class' => 'input-box', 'placeholder' => 'Endereço'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'id' => 'data1', 'placeholder' => 'Vencimento inicial', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'data2', 'placeholder' => 'Vencimento final', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter7', array('class' => 'input-box', 'id' => 'datapagto', 'placeholder' => 'Pagamento inicial', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'datapagto2', 'placeholder' => 'Pagamento final', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter9', array('id' => 'recebidosID', 'class' => 'select-box', 'placeholder' => 'Recebidos', 'empty' => '-- Recebidos --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('id' => 'statusID', 'class' => 'select-box', 'placeholder' => 'Status', 'empty' => '-- Status --'));
    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id', 'C.receber'); ?></th>
        <th><?php echo $this->Paginator->sort('Negociacao.id', 'Negociação'); ?></th>
        <th><?php echo $this->Paginator->sort('Corretor.nome', 'Corretor'); ?></th>
        <th><?php echo $this->Paginator->sort('Negociacao.cliente_vendedor', 'Vendedor'); ?></th>
        <th><?php echo $this->Paginator->sort('Negociacao.cliente_comprador', 'Comprador'); ?></th>
        <th><?php echo $this->Paginator->sort('Negociacao.endereco', 'Endereço'); ?></th>
        <th><?php echo 'NF EL'; ?></th>
        <th><?php echo 'NF Cor'; ?></th>
        <th><?php echo $this->Paginator->sort('parcelas', 'Parcelas'); ?></th>
        <th><?php echo $this->Paginator->sort('valor_total', 'Valor total'); ?></th>
        <!--<th><?php echo $this->Paginator->sort('valor_total', 'Valor(NF)'); ?></th>-->
        <th><?php echo $this->Paginator->sort('saldo', 'Saldo'); ?></th>
        <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($contasrecebers as $item): ?>
        <tr>
            <td><?php echo h($item['Contasreceber']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['endereco'] . ' - ' . $item['Negociacao']['referencia']); ?>&nbsp;</td>
            <?php if ($item['Negociacao']['nota_imobiliaria'] == 'S') { ?>
                <td><strong><font color="red"><?php echo h($item['Negociacao']['nota_imobiliaria']); ?>&nbsp;</font></strong></td>
            <?php } else { ?>
                <td><strong><font color="blue"><?php echo h($item['Negociacao']['nota_imobiliaria']); ?>&nbsp;</font></strong></td>
            <?php } ?>
            <?php if ($item['Negociacao']['nota_corretor'] == 'S') { ?>
                <td><strong><font color="red"><?php echo h($item['Negociacao']['nota_corretor']); ?>&nbsp;</font></strong></td>
            <?php } else { ?>
                <td><strong><font color="blue"><?php echo h($item['Negociacao']['nota_corretor']); ?>&nbsp;</font></strong></td>
            <?php } ?>
            <td><?php echo h($item['Contasreceber']['parcelas']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Contasreceber']['valor_total'], 2, ',', '.'); ?>&nbsp;</td>

            <?php $saldo = $this->requestAction('/Contasrecebers/calcula_saldo', array('pass' => array($item['Contasreceber']['id']))); ?>
            <td><?php echo number_format($saldo, 2, ',', '.'); ?>&nbsp;</td>
            <?php if ($item['Contasreceber']['status'] == 'A') { ?>
                <td><strong><font color="blue"><?php echo 'Aberto'; ?>&nbsp;</font></strong></td>
            <?php } else { ?>
                <td><strong><font color="green"><?php echo 'Fechado'; ?>&nbsp;</font></strong></td>
            <?php } ?>
            <td>
                <div id="botoes">
                    <?php
                    if (empty($item['Contasreceber']['parcelas'])) {
                        echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Contasreceber']['id']), array('escape' => false));
                        echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Contasreceber']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
                        );
                    } else {
                        echo $this->Html->link($this->Html->image("botoes/cifrao.png", array("alt" => "Efetuar pagamento", "title" => "Efetuar pagamento")), array('action' => 'pagar', $item['Contasreceber']['id'], $item['Negociacao']['id']), array('escape' => false));
                    }
                    ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<p>
    <?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    } else {
        echo $this->Paginator->counter('{:count}') . " registros encontrados.";
    }
    ?>
</p>

<script type="text/javascript">

    jQuery(document).ready(function() {
        $("#data1").mask("99/99/9999");
        $("#data2").mask("99/99/9999");
        $("#datapagto").mask("99/99/9999");
        $("#datapagto2").mask("99/99/9999");
    });
</script>