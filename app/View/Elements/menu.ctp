<div id="menu">
    <ul id="jsddm">

        <?php
        $menu_1 = 0;
        $menu_2 = 0;
        $menu_3 = 0;
        $menu_4 = 0;
        $menu_5 = 0;
        $menu_6 = 0;

        //debug($menuCarregado);

        foreach ($menuCarregado as $itemMenu):

            if ($itemMenu['Menu']['menu'] == 1 && $menu_1 == 0) {
                ?>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/1">Administrativo</a>
                    <ul>
                        <?php
                        $menu_1++;
                    } elseif ($itemMenu['Menu']['menu'] == 2 && $menu_2 == 0) {
                        if ($menu_1 != 0) {
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/2">Cadastros</a>
                    <ul>
                        <?php
                        $menu_2++;
                    } elseif ($itemMenu['Menu']['menu'] == 3 && $menu_3 == 0) {
                        if ($menu_1 != 0 || $menu_2 != 0) {
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/3">Processos</a>
                    <ul>
                        <?php
                        $menu_3++;
                    } elseif ($itemMenu['Menu']['menu'] == 4 && $menu_4 == 0) {
                        ?>
                    </ul>
                </li>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/4">Relatórios</a>
                    <ul>
                        <?php
                        $menu_4++;
                    } elseif ($itemMenu['Menu']['menu'] == 5 && $menu_5 == 0) {
                        ?>
                    </ul>
                </li>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/5">Indicadores</a>
                    <ul>
                        <?php
                        $menu_5++;
                    } elseif ($itemMenu['Menu']['menu'] == 6 && $menu_6 == 0) {
                        ?>
                    </ul>
                </li>
                <li><a href="http://www.imobiliariaeduardolang.com.br/gestao/Menus/montamenu/6">Financeiro</a>
                    <ul>
                        <?php
                        $menu_6++;
                    }
                    ?>
                    <li><?php echo $this->Html->link($itemMenu['Menu']['nome'], array('controller' => $itemMenu['Menu']['controller'], 'action' => 'index')); ?></li>
                    <?php
                endforeach;
                ?>

            </ul>
        </li>

    </ul>
</div>