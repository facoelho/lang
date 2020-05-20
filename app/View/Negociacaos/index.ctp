<?php
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
echo $this->Html->link($this->Html->image("botoes/graficos.png", array("alt" => "Gráficos", "title" => "Gráficos")), array('action' => 'indicadores'), array('escape' => false, 'target' => '_blank'));
?>
<br>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter7', array('class' => 'input-box', 'placeholder' => 'Código'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter6', array('id' => 'corretorID', 'class' => 'select-box', 'placeholder' => 'Corretores', 'empty' => '-- Corretores --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter1', array('class' => 'input-box', 'placeholder' => 'Referência'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('class' => 'input-box', 'placeholder' => 'Cliente vendedor'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('class' => 'input-box', 'placeholder' => 'Cliente comprador'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'id' => 'data1', 'placeholder' => 'dia/mês/ano', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'data2', 'placeholder' => 'dia/mês/ano', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('id' => 'origenID', 'class' => 'select-box', 'placeholder' => 'Status', 'empty' => '-- Status --'));
    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('referencia', 'Referência'); ?></th>
        <th><?php echo $this->Paginator->sort('unidade', 'Unidade'); ?></th>
        <th><?php echo $this->Paginator->sort('endereco', 'Endereço'); ?></th>
        <th><?php echo $this->Paginator->sort('cliente_vendedor', 'Cliente vendedor'); ?></th>
        <th><?php echo $this->Paginator->sort('cliente_comprador', 'Cliente comprador'); ?></th>
        <th><?php echo $this->Paginator->sort('valor_imovel', 'Vlr imóvel'); ?></th>
        <th><?php echo $this->Paginator->sort('valor_proposta', 'Vlr proposta'); ?></th>
        <th><?php echo $this->Paginator->sort('status', 'Status'); ?></th>
        <th><?php echo 'Próxima ação'; ?></th>
        <th><?php echo 'Corretores'; ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($negociacaos as $item): ?>
        <?php $corretors = ''; ?>
        <tr>
            <td><?php echo h($item['Negociacao']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['referencia']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['unidade']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['endereco']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_vendedor']); ?>&nbsp;</td>
            <td><?php echo h($item['Negociacao']['cliente_comprador']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Negociacao']['valor_imovel'], 2, ',', '.'); ?>&nbsp;</td>
            <td><?php echo number_format($item['Negociacao']['valor_proposta'], 2, ',', '.'); ?>&nbsp;</td>

            <?php if ($item['Negociacao']['status'] == 'E') { ?>
                <td><strong><font color="#e6b800"><?php echo 'EM ANDAMENTO'; ?>&nbsp;</font></strong></td>
            <?php } elseif ($item['Negociacao']['status'] == 'A') { ?>
                <td><strong><font color="green"><?php echo 'ACEITA'; ?>&nbsp;</font></strong></td>
            <?php } elseif ($item['Negociacao']['status'] == 'F') { ?>
                <td><?php echo 'FINALIZADO'; ?>&nbsp;</td>
            <?php } elseif ($item['Negociacao']['status'] == 'C') { ?>
                <td><?php echo 'CANCELADO'; ?>&nbsp;</td>
            <?php } ?>
            <?php if (!empty($item['Negociacao']['dt_ultima_etapa'])) { ?>
                <?php if (date('Y-m-d') == date('Y-m-d', strtotime($item['Negociacao']['dt_ultima_etapa']))) { ?>
                    <td><strong><font color="#e6b800"><?php echo date('d/m/Y', strtotime($item['Negociacao']['dt_ultima_etapa'])); ?>&nbsp;</font></strong></td>
                <?php } elseif (date('Y-m-d') > date('Y-m-d', strtotime($item['Negociacao']['dt_ultima_etapa']))) { ?>
                    <td><strong><font color="red"><?php echo date('d/m/Y', strtotime($item['Negociacao']['dt_ultima_etapa'])); ?>&nbsp;</font></strong></td>
                <?php } elseif (date('Y-m-d') < date('Y-m-d', strtotime($item['Negociacao']['dt_ultima_etapa']))) { ?>
                    <td><strong><font color="green"><?php echo date('d/m/Y', strtotime($item['Negociacao']['dt_ultima_etapa'])); ?>&nbsp;</font></strong></td>
                <?php } ?>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>
            <?php foreach ($item['Corretor'] as $key => $value) : ?>
                <?php if (empty($corretors)) { ?>
                    <?php $corretors = $value['nome']; ?>
                <?php } else { ?>
                    <?php $corretors .= ', ' . $value['nome']; ?>
                <?php } ?>
            <?php endforeach; ?>
            <td><?php echo $corretors; ?>&nbsp;</td>
            <td>
                <div id="botoes">
                    <?php
                    if (!empty($item['Negociacao']['dtalerta'])) {
                        if (date('Y-m-d') <= date('Y-m-d', strtotime($item['Negociacao']['dtalerta']))) {
                            echo $this->Html->link($this->Html->image("botoes/alerta_min.png", array("alt" => "Alerta", "title" => "Alerta")), array('action' => ''), array('escape' => false));
                        }
                    }
                    echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Negociacao']['id']), array('escape' => false));
                    if (empty($item['Contasreceber'])) {
                        echo $this->Html->link($this->Html->image("botoes/pagar.png", array("alt" => "Lançar pagamento", "title" => "Lançar pagamento")), array('action' => 'pagar', $item['Negociacao']['id']), array('escape' => false));
                    }
                    echo $this->Html->link($this->Html->image("botoes/add_min.png", array("alt" => "Próxima ação", "title" => "Próxima ação")), array('controller' => 'Negociacaohistoricos', 'action' => 'add', $item['Negociacao']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image("botoes/status.png", array("alt" => "Próximo status", "title" => "Próximo status")), array('controller' => 'Negociacaostats', 'action' => 'add', $item['Negociacao']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Negociacao']['id']), array('escape' => false));
                    if ($adminholding == 1) {
                        echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Negociacao']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
                        );
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
<div id="indicador_cor">
    <table border="0" style ="width:50%" >
        <tr>
            <th><?php echo $this->Html->image("separador.png"); ?></th>
            <th><?php echo $this->Html->image("botoes/verde.png"); ?></th>
            <th><?php echo 'Em dia' ?></th>
            <th><?php echo $this->Html->image("separador.png"); ?></th>
            <th><?php echo $this->Html->image("botoes/amarelo.png"); ?></th>
            <th><?php echo 'Data limite' ?></td>
            <th><?php echo $this->Html->image("separador.png"); ?></th>
            <th><?php echo $this->Html->image("botoes/vermelho.png"); ?></th>
            <th><?php echo 'Em atrasado' ?></td>
        </tr>
    </table>
</div>

<script type="text/javascript">

    jQuery(document).ready(function() {
        $("#data1").mask("99/99/9999");
        $("#data2").mask("99/99/9999");
    });
</script>