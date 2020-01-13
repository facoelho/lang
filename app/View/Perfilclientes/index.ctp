<?php

//echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
//echo $this->Html->link($this->Html->image("botoes/imprimir.png", array("alt" => "Imprimir", "title" => "Imprimir")), array('action' => 'print'), array('escape' => false));
?>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'input-box', 'id' => 'usuario', 'placeholder' => 'Corretor'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('class' => 'input-box', 'id' => 'nome', 'placeholder' => 'Cliente'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('class' => 'input-box', 'id' => 'email', 'placeholder' => 'E-mail'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'id' => 'telefone', 'placeholder' => 'Telefone'));
    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<br><br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('usuario', 'Corretor'); ?></th>
        <th><?php echo $this->Paginator->sort('nome', 'Cliente'); ?></th>
        <th><?php echo $this->Paginator->sort('email', 'E-mail'); ?></th>
        <th><?php echo $this->Paginator->sort('telefone', 'Telefone'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($perfilclientes as $item): ?>
    <tr>
        <td><?php echo h($item['Perfilcliente']['usuario']); ?>&nbsp;</td>
        <td><?php echo h($item['Perfilcliente']['nome']); ?>&nbsp;</td>
        <td><?php echo h($item['Perfilcliente']['email']); ?>&nbsp;</td>
        <td><?php echo h($item['Perfilcliente']['telefone']); ?>&nbsp;</td>
        <td>
            <div id="botoes">
                    <?php
                    echo $this->Html->link($this->Html->image("botoes/view_2_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Perfilcliente']['id']), array('escape' => false));
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
        echo "<p> &nbsp; | " . $this->Paginator->numbers(array('first' => 4, 'last' => 4)) . "| </p>";
    } else {
        echo $this->Paginator->counter('{:count}') . " registros encontrados.";
    }
    ?>
</p>