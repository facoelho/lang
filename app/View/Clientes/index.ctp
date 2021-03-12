<?php
//if ($negociacao == 'N') {
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
//} else {
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
//}
?>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'select-box', 'id' => 'tipopessoaID', 'placeholder' => 'Tipo pessoa', 'empty' => '-- Tipo pessoa --'));
//    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('class' => 'input-box', 'id' => 'razaosocialID', 'placeholder' => 'Razão Social'));
//    echo $this->Html->image("separador.png");
//    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'id' => 'nomeID', 'placeholder' => 'Nome'));
//    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('class' => 'input-box', 'id' => 'cpfID', 'placeholder' => 'CPF'));
    echo $this->Html->image("separador.png");
    ?>
    <input  type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<br>
<br>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('tipopessoa', 'Tipo Pessoa'); ?></th>
        <th><?php echo 'CNPJ/CPF'; ?></th>
        <th><?php echo 'Razão Social/Nome Cliente'; ?></th>
        <th><?php echo $this->Paginator->sort('telefone', 'Fixo'); ?></th>
        <th><?php echo $this->Paginator->sort('email', 'email'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($clientes as $item): ?>
        <tr>
            <td><?php echo h($item['Cliente']['id']); ?>&nbsp;</td>
            <?php if ($item['Cliente']['tipopessoa'] == 'J') { ?>
                <td><?php echo 'Jurídica'; ?>&nbsp;</td>
                <td><?php
                    echo substr($item['Cliente']['cnpj'], 0, 2) . "." .
                    substr($item['Cliente']['cnpj'], 2, 3) . "." .
                    substr($item['Cliente']['cnpj'], 5, 3) . "/" .
                    substr($item['Cliente']['cnpj'], 8, 4) . "-" .
                    substr($item['Cliente']['cnpj'], 12, 2);
                    ?>&nbsp;
                </td>
                <td><?php echo h($item['Cliente']['razaosocial']); ?>&nbsp;</td>
            <?php } else { ?>
                <td><?php echo 'Física'; ?>&nbsp;</td>
                <td><?php
                    echo substr($item['Cliente']['cpf'], 0, 3) . "." .
                    substr($item['Cliente']['cpf'], 3, 3) . "." .
                    substr($item['Cliente']['cpf'], 6, 3) . "-" .
                    substr($item['Cliente']['cpf'], 9, 2);
                    ?>&nbsp;
                </td>
                <td><?php echo h($item['Cliente']['nome']); ?>&nbsp;</td>
            <?php } ?>
            <?php if (!empty($item['Cliente']['telefone'])) { ?>
                <td><?php
                    echo '(' . substr($item['Cliente']['telefone'], 0, 2) . ')' .
                    substr($item['Cliente']['telefone'], 2, 11);
                    ?>&nbsp;
                </td>
            <?php } else { ?>
                <td><?php echo ''; ?></td>
            <?php } ?>
            <td><?php echo h($item['Cliente']['email']); ?>&nbsp;</td>
            <td>
                <div id="botoes">
                    <?php
                    if ($negociacao == 'V') {
                        echo $this->Html->link($this->Html->image("botoes/add_min.png", array("alt" => "Adicionar vendedor no pedido", "title" => "Adicionar vendedor na negociação")), array('controller' => 'Negociacaos', 'action' => 'add', $item['Cliente']['id'], 'V'), array('escape' => false));
                    } elseif ($negociacao == 'C') {
                        echo $this->Html->link($this->Html->image("botoes/add_min.png", array("alt" => "Adicionar comprador no pedido", "title" => "Adicionar comprador na negociação")), array('controller' => 'Negociacaos', 'action' => 'add', $item['Cliente']['id'], 'C'), array('escape' => false));
                    } else {
                        echo $this->Html->link($this->Html->image("botoes/view_min.png", array("alt" => "Visualizar", "title" => "Visualizar")), array('action' => 'view', $item['Cliente']['id']), array('escape' => false));
                        echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('action' => 'edit', $item['Cliente']['id']), array('escape' => false));
                        echo $this->Html->link($this->Html->image('botoes/deletar_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Cliente']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
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
        echo "<p> &nbsp; | " . $this->Paginator->numbers(array('first' => 4, 'last' => 4)) . "| </p>";
    } else {
        echo $this->Paginator->counter('{:count}') . " registros encontrados.";
    }
    ?>
</p>


<script type="text/javascript">

    jQuery(document).ready(function() {
        $("#nomeID").hide();
        $("#cpfID").hide();
        $("#razaosocialID").hide();
        $("#nomefantasiaID").hide();
        document.getElementById('tipopessoaID').focus();

        $('#tipopessoaID').change(function() {
            if ($('#tipopessoaID').val() === 'J') {
                $("#razaosocialID").show();
                $("#nomefantasiaID").show();
                $("#nomeID").hide();
                $("#cpfID").hide();
                document.getElementById('nomeID').value = '';
                document.getElementById('cpfID').value = '';
            } else if ($('#tipopessoaID').val() === 'F') {
                $("#razaosocialID").hide();
                $("#nomefantasiaID").hide();
                $("#nomeID").show();
                $("#cpfID").show();
                document.getElementById('razaosocialID').value = '';
                document.getElementById('nomefantasiaID').value = '';
            } else if ($('#tipopessoaID').val() === '') {
                document.getElementById('nomeID').value = '';
                document.getElementById('cpfID').value = '';
                document.getElementById('razaosocialID').value = '';
                document.getElementById('nomefantasiaID').value = '';
                $("#razaosocialID").hide();
                $("#nomefantasiaID").hide();
                $("#nomeID").hide();
                $("#cpfID").hide();
            }
        });
    });
</script>