<?php
echo $this->Html->link($this->Html->image("botoes/printer.png", array("alt" => "Imprimir todos Leads", "title" => "Imprimir todos Leads")), array('action' => 'relatorio_lista_leads'), array('escape' => false, 'target' => '_blank'));
echo $this->Html->link($this->Html->image("botoes/add.png", array("alt" => "Adicionar", "title" => "Adicionar")), array('action' => 'add'), array('escape' => false));
?>
<br>
<br>
<div id="filtroGrade">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('id' => 'origenID', 'class' => 'select-box', 'placeholder' => 'Mídia Referência', 'empty' => '-- Mídia Referência --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter2', array('id' => 'corretorID', 'class' => 'select-box', 'placeholder' => 'Corretores', 'empty' => '-- Corretores --'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter3', array('class' => 'input-box', 'placeholder' => 'Nome cliente'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter4', array('class' => 'input-box', 'placeholder' => 'Email cliente'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter5', array('class' => 'input-box', 'placeholder' => 'Telefone cliente'));
    echo $this->Html->image("separador.png");
    echo $this->Search->input('filter6', array('class' => 'input-box', 'id' => 'data1', 'placeholder' => 'dia/mês/ano', 'title' => 'Data inicial'), array('class' => 'input-box', 'id' => 'data2', 'placeholder' => 'dia/mês/ano', 'title' => 'Data final'));
    echo $this->Html->image("separador.png");
    ?>
    <input type="submit" value="Filtrar" class="botaoFiltro"/>
</div>
<table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('id'); ?></th>
        <th><?php echo $this->Paginator->sort('Origem.descricao', 'Mídia referência'); ?></th>
        <th><?php echo $this->Paginator->sort('created', 'Data'); ?></th>
        <th><?php echo $this->Paginator->sort('User.nome', 'Usuário'); ?></th>
        <th class="actions"><?php echo __('Ações'); ?></th>
    </tr>
    <?php foreach ($importacaoleads as $item): ?>
        <tr>
            <td><?php echo h($item['Importacaolead']['id']); ?>&nbsp;</td>
            <td><?php echo $item['Origen']['descricao']; ?>&nbsp;</td>
            <td><?php echo date('d/m/Y H:i:s', strtotime($item['Importacaolead']['created'])); ?>&nbsp;</td>
            <td><?php echo $item['User']['nome'] . ' ' . $item['User']['sobrenome']; ?>&nbsp;</td>
            <?php
            $cont = $this->requestAction('/Importacaoleads/valida_corretor_leads', array('pass' => array($item['Importacaolead']['id'])));
            $email = $this->requestAction('/Importacaoleads/valida_email_enviado', array('pass' => array($item['Importacaolead']['id'])));
            ?>
            <td>
                <div id="botoes">
                    <?php
                    if ($cont > 0) {
                        echo $this->Html->image("botoes/alerta_min.png", array("alt" => "Lead(s) pendente(s) de vinculo com corretor", "title" => "Lead(s) pendente(s) vinculo com de corretor"));
                    } else {
                        if ($email == 'N') {
                            echo $this->Html->link($this->Html->image('botoes/email_min_vermelho.png', array('alt' => 'Enviar lead(s) por e-mail?', 'title' => 'Enviar lead(s) por e-mail?')), array('action' => 'enviar_lead_email', $item['Importacaolead']['id']), array('escape' => false), __('Você realmete deseja enviar lead(s) por e-mail?'));
                        } else {
                            echo $this->Html->image("botoes/email_min_azul.png", array("alt" => "Lead(s) enviado(s) por e-mail", "title" => "Lead(s) enviado(s) por e-mail"));
                        }
                    }
                    echo $this->Html->link($this->Html->image("botoes/printer_min.png", array("alt" => "Imprimir leads", "title" => "Imprimir leads")), array('action' => 'relatorio_leads', $item['Importacaolead']['id']), array('escape' => false, 'target' => '_blank'));
                    echo $this->Html->link($this->Html->image("botoes/editar_min.png", array("alt" => "Editar", "title" => "Editar")), array('controller' => 'Leads', 'action' => 'edit', $item['Importacaolead']['id']), array('escape' => false));
                    echo $this->Html->link($this->Html->image('botoes/excluir_min.png', array('alt' => 'Exluir', 'title' => 'Exluir')), array('action' => 'delete', $item['Importacaolead']['id']), array('escape' => false), __('Você realmete deseja apagar esse item?')
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
    });
</script>