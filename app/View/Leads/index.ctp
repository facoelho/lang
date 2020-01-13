<?php

echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
?>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('descricao', 'Descrição'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($origens as $item): ?>
    <tr>
        <td><?php echo h($item['Origen']['id']); ?>&nbsp;</td>
        <td><?php echo h($item['Origen']['descricao']); ?>&nbsp;</td>
        <td>
            <div id="botoes">
                    <?php
                    echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Origen']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image("botoes/editar.gif", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Origen']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir.gif', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Origen']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
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