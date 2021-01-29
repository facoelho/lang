<?php
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
//echo $this->Html->link($this->Html->image("botoes/printer.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'relatorio_contas_pagar'), array('escape' => false, 'target' => '_blank'));
echo $this->Html->link($this->Html->image("botoes/cifrao_2.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'relatorio_comissoes_pagar'), array('escape' => false, 'target' => '_blank'));
?>
<br>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'input-box', 'placeholder' => 'Contrato'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('id' => 'corretorID', 'class' => 'select-box', 'placeholder' => 'Corretor', 'empty' => '-- Corretor --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('class' => 'input-box', 'id' => 'dtvencimento1', 'placeholder' => 'Vencimento inicial', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'dtvencimento2', 'placeholder' => 'Vencimento final', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'id' => 'dtrecebimento1', 'placeholder' => 'Recebimento inicial', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'dtrecebimento2', 'placeholder' => 'Recebimento final', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('class' => 'input-box', 'id' => 'dtrepasse1', 'placeholder' => 'Repasse inicial', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'dtrepasse2', 'placeholder' => 'Repasse final', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
//    echo $this->Search->input('filter6', array('id' => 'statusID', 'class' => 'select-box', 'placeholder' => 'Status', 'empty' => '-- Status --'));
//    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id', 'C.pagar'); ?></th>
        <th><?php echo $this->Paginator->sort('proprietario', 'Proprietário'); ?></th>
        <th><?php echo $this->Paginator->sort('inqulino', 'Inquilino'); ?></th>
        <th><?php echo $this->Paginator->sort('dtvencimento', 'Vencimento'); ?></th>
        <th><?php echo $this->Paginator->sort('dtrecebimento', 'Recebimento'); ?></th>
        <th><?php echo $this->Paginator->sort('dtrepasse', 'Repasse'); ?></th>
        <th><?php echo $this->Paginator->sort('valor', 'Valor (Taxa)'); ?></th>
        <th><?php echo $this->Paginator->sort('Corretor.nome', 'Corretor'); ?></th>
        <!--<th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>-->
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($contaspagars as $item): ?>
        <tr>
            <td><?php echo h($item['Contaspagar']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['proprietario']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['inquilino']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['dtvencimento']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['dtrecebimento']); ?>&nbsp;</td>
            <td><?php echo h($item['Contaspagar']['dtrepasse']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Contaspagar']['valor'], 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td>
                <div id="botoes">
                    <?php
                    echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Contaspagar']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Contaspagar']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?'));
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
        $("#dtvencimento1").mask("99/99/9999");
        $("#dtvencimento2").mask("99/99/9999");
        $("#dtrecebimento1").mask("99/99/9999");
        $("#dtrecebimento2").mask("99/99/9999");
        $("#dtrepasse1").mask("99/99/9999");
        $("#dtrepasse2").mask("99/99/9999");
    });
</script>