<?php
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
?>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('anomes', 'Mês/Ano'); ?></th>
        <th><?php echo $this->Paginator->sort('dtinicio', 'Data final'); ?></th>
        <th><?php echo 'Corretores'; ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($desempenhos as $item): ?>
        <tr>
            <td><?php echo h($item['Desempenho']['id']); ?>&nbsp;</td>
            <td><?php echo substr($item['Desempenho']['anomes'], 4, 2) . '/' . substr($item['Desempenho']['anomes'], 0, 4); ?>&nbsp;</td>
            <td><?php echo h($item['Desempenho']['obs']); ?>&nbsp;</td>
            <?php $corretors = $this->requestAction('/Desempenhos/busca_desempenho_corretors', array('pass' => array($item['Desempenho']['id']))); ?>
            <td>
                <?php foreach ($corretors as $corretor): ?>
                    <a href="http://www.imobiliariaeduardolang.com.br/gestao/Desempenhoindivids/qualify_desempenho/<?php echo $corretor['Desempenhoindivid']['id'] ?>"><img src="http://www.imobiliariaeduardolang.com.br/gestao/img/colaboradores/<?php echo $corretor['Corretor']['foto'] ?>" alt="<?php echo $corretor['Corretor']['nome'] ?>" width=35 height=35></a>
                <?php endforeach; ?>
            </td>
            <td>
                <div id="botoes">
                    <?php
//                    echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Desempenho']['id']), array('escape' => false));
//                    echo $this->Html->link($this->Html->image("botoes/editar.gif", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Desempenho']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir.gif', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Desempenho']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
                    );
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