<?php
//echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
//echo $this->Html->link($this->Html->image("botoes/imprimir.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'print'), array('escape' => false));
?>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id', 'Id'); ?></th>
        <th><?php echo $this->Paginator->sort('id', 'Arquivo'); ?></th>
        <th><?php echo $this->Paginator->sort('descricao', 'Descrição'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($manuais as $item): ?>
        <tr>
            <td><?php echo h($item['Manuai']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Manuai']['arquivo']); ?>&nbsp;</td>
            <td><?php echo h($item['Manuai']['descricao']); ?>&nbsp;</td>
            <td>
                <div id="botoes">
                    <a href="/gestao/arquivos/manuais/<?php echo $item['Manuai']['arquivo'] ?>"target="_blank"> <?php echo $this->Html->image("botoes/view_2_min.png") ?></a>
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