<?php
echo $this->Html->link($this->Html->image("botoes/retornar.png", array("alt" => "Retornar", "title" => "Retornar")), array('action' => 'index'), array('escape' => false, 'onclick' => 'history.go(-1); return false;'));
echo $this->Form->postLink($this->Html->image('botoes/excluir.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $cliente['Cliente']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?'));

//debug($cliente);

?>
<br>
<br>
<p>
<strong> Nome: </strong>
<?php echo $cliente['Cliente']['nome']; ?>
<br>
<strong> Sobrenome: </strong>
<?php echo $cliente['Cliente']['sobrenome']; ?>
<br>
<strong> CPF: </strong>
<?php echo $cliente['Cliente']['cpf']; ?>
<br>
<strong> RG: </strong>
<?php echo $cliente['Cliente']['rg']; ?>
<br>
<strong> Data de nascimento: </strong>
<?php echo $cliente['Cliente']['dtnascimento']; ?>
<br>
<strong> Sexo: </strong>
<?php if($cliente['Cliente']['sexo'] == "M") { echo "MASCULINO"; } else { echo "FEMININO"; } ; ?>
<br>
<strong> Ativo: </strong>
<?php if($cliente['Cliente']['ativo'] == "A") { echo "SIM"; } else { echo "NÃO"; } ; ?>
<br><br>
<?php 
if (empty($cliente['Endereco'])) {
    echo "Este cliente não tem endereço cadastrado.";
} else {
    ?>
    <strong> Cidade: </strong>
    <?php echo $cliente['Endereco'][0]['Cidade']['nome']; ?>
    <br>
    <strong> Rua: </strong>
    <?php echo $cliente['Endereco'][0]['rua']; ?>
    <br>
    <strong> Número: </strong>
    <?php echo $cliente['Endereco'][0]['numero']; ?>
    <br>
    <strong> Complemento: </strong>
    <?php echo $cliente['Endereco'][0]['complemento']; ?>
    <br>
    <strong> Bairro: </strong>
    <?php echo $cliente['Endereco'][0]['bairro']; ?>
    <br>
    <strong> Cep: </strong>
    <?php echo $cliente['Endereco'][0]['cep']; ?>
    <br>
    <strong> Telefone: </strong>
    <?php echo $cliente['Endereco'][0]['telefone']; ?>
    <br>
    <strong> Observação: </strong>
    <?php echo $cliente['Endereco'][0]['observacao']; ?>
    <br>
    <?php
}
?>
</p>