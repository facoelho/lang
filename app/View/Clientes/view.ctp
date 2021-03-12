<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
echo $this->Html->link($this->Html->image('botoes/excluir.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $cliente['Cliente']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?'));
?>
<br>
<br>
<p>
    <?php if ($cliente['Cliente']['tipopessoa'] == 'J') { ?>
        <strong> CNPJ: </strong>
        <?php
        echo substr($cliente['Cliente']['cnpj'], 0, 2) . "." .
        substr($cliente['Cliente']['cnpj'], 2, 3) . "." .
        substr($cliente['Cliente']['cnpj'], 5, 3) . "/" .
        substr($cliente['Cliente']['cnpj'], 8, 4) . "-" .
        substr($cliente['Cliente']['cnpj'], 12, 2);
        ?>
        <br>
        <strong> Razão Social: </strong>
        <?php echo $cliente['Cliente']['razaosocial']; ?>
        <br>
    <?php } else { ?>
        <strong> CPF: </strong>
        <?php
        echo substr($cliente['Cliente']['cpf'], 0, 3) . "." .
        substr($cliente['Cliente']['cpf'], 3, 3) . "." .
        substr($cliente['Cliente']['cpf'], 6, 3) . "-" .
        substr($cliente['Cliente']['cpf'], 9, 2);
        ?>
        <br>
        <strong> Nome: </strong>
        <?php echo $cliente['Cliente']['nome']; ?>
        <br>
    <?php } ?>
    <br>
    <strong> Telefone fixo: </strong>
    <?php
    echo '(' . substr($cliente['Cliente']['telefone'], 0, 2) . ')' .
    substr($cliente['Cliente']['telefone'], 2, 11);
    ?>
    <br>
    <strong> Email: </strong>
    <?php
    echo $cliente['Cliente']['email'];
    ?>
</p>