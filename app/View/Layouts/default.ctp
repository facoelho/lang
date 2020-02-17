<!DOCTYPE html>
<html>
    <head>
        <?php
        echo $this->Html->charset();
        //Pegando dados da sessão do usuário
        $dadosUser = $this->Session->read();
        ?>
        <title>
            .:: Eduardo Lang <?php echo " - " . $title_for_layout . " - " . $dadosUser['nomeEmpresa'] . " "; ?> ::.

        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('lang');
        echo $this->Html->css('south-street/jquery-ui-1.10.3.custom.min');
        echo $this->Html->css('colorpicker/colorpicker');

        echo $this->Html->script(array('jquery.js', 'gerais.js', 'jquery-ui.js', 'jquery.maskedinput.min.js', 'jquery.maskMoney.js', 'jquery-ui-1.10.3.custom.min.js', 'colorpicker.js'));

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>

        <div id="global">

            <div id="diferenca">

            </div>

            <div id="topo">

                <?php
                if ($dadosUser['empresa_tipologo'] == "R") {
                    ?>
                    <div id="topoleftr">
                        <?php
                        echo $this->Html->link($this->Html->image("empresas/" . $dadosUser['empresa_logo'], array("alt" => $dadosUser['nomeEmpresa'], "title" => $dadosUser['nomeEmpresa'])), array('controller' => 'homes', 'action' => 'index'), array('escape' => false));
                        ?>
                    </div>
                    <?php
                } elseif ($dadosUser['empresa_tipologo'] == "P") {
                    ?>
                    <div id="topoleftp">
                        <?php
                        echo $this->Html->link($this->Html->image("empresas/" . $dadosUser['empresa_logo'], array("alt" => $dadosUser['nomeEmpresa'], "title" => $dadosUser['nomeEmpresa'])), array('controller' => 'homes', 'action' => 'index'), array('escape' => false));
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div id="topoleftr">
                        <?php
                        echo $this->Html->link($this->Html->image("marca.png", array("alt" => "Marca Cliente", "title" => "Marca Cliente")), array('controller' => 'homes', 'action' => 'index'), array('escape' => false));
                        ?>
                    </div>
                    <?php
                }
                ?>

                <div id="toporight">
                    <div id="internadomenu">
                        <br>
                        <?php
                        echo $this->Html->link($this->Html->image("botoes/logout_01.png", array("alt" => "Sair", "title" => "Sair")), array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
                        ?>
                        Bem vindo, <span class="fontNomeUsuario"><b><?php echo $dadosUser['Auth']['User']['nome']; ?></b></span>.
                        <br> <span class="fontUltimoAcesso">Seu último acesso foi: <?php echo date('d/m/Y', strtotime($dadosUser['Auth']['User']['ultimoacesso'])) . " | " . date('H:i', strtotime($dadosUser['Auth']['User']['ultimoacesso'])); ?></span>
                        <br> <span class="fontUltimoAcesso">Você está logado em: <b><?php echo $dadosUser['nomeEmpresa']; ?></b></span>
                        <br></br>

                        <?php if (count($dadosUser['empresasCombo']) > 1) { ?>
                    <!-- <select name="trocaEmpresa" id="trocaEmpresa" class="trocaEmpresa" title="Trocar a empresa" onChange="location.href='http://www.sisagro.com/pecuaria/users/trocaEmpresa/' + this.value;"> -->
                            <select name="trocaEmpresa" id="trocaEmpresa" class="trocaEmpresa" title="Trocar a empresa" onChange="location.href = 'http://localhost/agenda_express/users/trocaEmpresa/' + this.value;">
                                <option value="">-- Trocar empresa -- </option>
                                <?php for ($i = 0; $i < count($dadosUser['empresasCombo']); $i++) { ?>
                                    <option value="<?php echo $dadosUser['empresasCombo'][$i]['Empresa']['id']; ?>"><?php echo $dadosUser['empresasCombo'][$i]['Empresa']['nomefantasia']; ?></option>
                                <?php } ?>
                            </select>
                        <?php } ?>

                        <?php
                        //echo $this->Html->link($this->Html->image("botoes/user_02.png", array("alt" => "Trocar empresa", "title" => "Trocar empresa")), array('controller' => 'users', 'action' => 'trocaEmpresa',14), array('escape' => false));
//                        echo $this->Html->link($this->Html->image("botoes/logout_01.png", array("alt" => "Sair", "title" => "Sair")), array('controller' => 'users', 'action' => 'logout'), array('escape' => false));
//                        echo $this->Html->link($this->Html->image("botoes/email.jpg", array("alt" => "Mensagem cliente", "title" => "Mensagem cliente")), array('controller' => 'logs', 'action' => 'index'), array('escape' => false));
                        ?>
                    </div>
                </div>
                <br>
                <?php echo $this->element('menu'); ?>

            </div>

            <div id="conteudo">
                <div id="titulopagina">
                    <?php echo $title_for_layout; ?>
                </div>
                <div id="corpo">
                    <?php echo $this->element('navegacao'); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
                </div>

            </div>

            <div id="rodape">
                <?php echo $this->Js->writeBuffer(); ?>
            </div>

        </div>

    </body>
</html>
