<?php
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
?>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('Corretor.nome', 'Nome'); ?></th>
        <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
        <th><?php echo $this->Paginator->sort('perc_comissao', '(%)'); ?></th>
        <th><?php echo 'Gerente'; ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($corretors as $item): ?>
        <tr>
            <td><?php echo h($item['Corretor']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['email']); ?>&nbsp;</td>
            <td><?php echo number_format($item['Corretor']['perc_comissao'], 2, ',', '.'); ?>&nbsp;</td>
            <?php if (!empty($item['Corretor']['gerente_equipe'])) { ?>
                <?php $nome = $this->requestAction('/Leads/busca_nome_corretor', array('pass' => array($item['Corretor']['gerente_equipe']))); ?>
                <td><?php echo $nome; ?>&nbsp;</td>
            <?php } else { ?>
                <td><?php echo ''; ?>&nbsp;</td>
            <?php } ?>
            <td>
                <div id="botoes">
                    <?php
                    echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Corretor']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Corretor']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Corretor']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
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