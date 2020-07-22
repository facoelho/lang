<?php
echo $this->Html->link($this->Html->image("botoes/graficos.png", array("alt" => "Gráficos", "title" => "Gráficos")), array('action' => 'perfil_leads_graficos'), array('escape' => false, 'target' => '_blank'));
?>
<br>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('id' => 'origenID', 'class' => 'select-box', 'placeholder' => 'Origen', 'empty' => '-- Mídia Origem --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('id' => 'corretorID', 'class' => 'select-box', 'placeholder' => 'Corretores', 'empty' => '-- Corretores --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('id' => 'OperacaotipoID', 'class' => 'select-box', 'placeholder' => 'Operação', 'empty' => '-- Operação --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('id' => 'bairroID', 'class' => 'select-box', 'placeholder' => 'Bairros', 'empty' => '-- Bairros --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('id' => 'ImoveltipoID', 'class' => 'select-box', 'placeholder' => 'Tipo de imóvel', 'empty' => '-- Tipo de imóvel --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter6', array('id' => 'DormitorioID', 'class' => 'select-box', 'placeholder' => 'Dormitórios', 'empty' => '-- Dormitórios --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter7', array('class' => 'input-box', 'id' => 'valor_max1', 'placeholder' => 'Valor inicial', 'title' => 'Valor inicial'), array('class' => 'input-box', 'id' => 'valor_max2', 'placeholder' => 'Valor final', 'title' => 'Valor final'));
    echo $this->Search->input('filter8', array('class' => 'input-box', 'id' => 'data1', 'placeholder' => 'Data qualificação', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'data2', 'placeholder' => 'Data qualificação', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>

</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('Lead.id', 'Lead'); ?></th>
        <th><?php echo $this->Paginator->sort('Origen.descricao', 'Origem'); ?></th>
        <th><?php echo $this->Paginator->sort('Corretor.nome', 'Corretor'); ?></th>
        <th><?php echo $this->Paginator->sort('Cliente.nome', 'Cliente'); ?></th>
        <th><?php echo $this->Paginator->sort('Cliente.telefone', 'Telefone'); ?></th>
        <th><?php echo 'Operação'; ?></th>
        <th><?php echo 'Situação'; ?></th>
        <th><?php echo 'Bairro'; ?></th>
        <th><?php echo 'Tipo imóvel'; ?></th>
        <th><?php echo 'Dormitórios'; ?></th>
        <th><?php echo 'Valor'; ?></th>
        <th><?php echo $this->Paginator->sort('Caracteristica.data', 'Qualificação'); ?></th>
        <th><?php echo 'Obs cliente'; ?></th>
        <th><?php echo 'Obs gerente'; ?></th>
        <th><?php echo 'Qualificação'; ?></th>
    </tr>
    <?php foreach ($caracteristicas as $item): ?>
        <tr>
            <td><?php echo h($item['Lead']['id']); ?>&nbsp;</td>
            <td><?php echo h($item['Origen']['descricao']); ?>&nbsp;</td>
            <td><?php echo h($item['Corretor']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Cliente']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Cliente']['telefone']); ?>&nbsp;</td>
            <td><?php echo h($item['Operacaotipo']['descricao']); ?>&nbsp;</td>
            <td><?php echo h($item['Imovelsituacao']['descricao']); ?>&nbsp;</td>
            <td><?php echo h($item['Bairro']['nome']); ?>&nbsp;</td>
            <td><?php echo h($item['Imoveltipo']['descricao']); ?>&nbsp;</td>
            <td><?php echo h($item['Dormitorio']['descricao']); ?>&nbsp;</td>
            <td><?php echo h(number_format($item['Caracteristica']['valor_max'], 2, ',', '.')); ?>&nbsp;</td>
            <td><?php echo date('d/m/Y', strtotime($item['Caracteristica']['data'])); ?>&nbsp;</td>
            <td><?php echo h($item['Lead']['obs_cliente']); ?>&nbsp;</td>
            <td><?php echo h($item['Lead']['obs']); ?>&nbsp;</td>
            <td><?php echo h($item['Caracteristica']['obs_corretor']); ?>&nbsp;</td>
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

        $("#data1").mask("99/99/9999");
        $("#data2").mask("99/99/9999");

        $("#categorias_paiID").change(function() {
            $.ajax({async: true,
                data: $("#categorias_paiID").serialize(),
                dataType: "html",
                success: function(data, textStatus) {
                    $("#categoriaID").html(data);
                },
                type: "post",
                url: "\/Categorias\/buscaCategorias\/Categoria\/" + $("#categorias_paiID option:selected").val()
            });
        });
        document.getElementById('origenID').focus();
    });
</script>