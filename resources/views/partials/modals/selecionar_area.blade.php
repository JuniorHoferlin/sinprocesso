<div class="modal fade" id="select_area">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Selecione uma área</h4>
            </div>
            <div class="modal-body">
                <?php
                function recurse($array = array(), $nivel = 1)
                {
                    $margem = 20 * $nivel - 20;
                    echo '<ul class="select-multinivel nivel-' . $nivel . ' ' . ($nivel > 1 ? 'hide' : '') . '">';
                    foreach ($array as $i) {
                        echo '<li>';
                        echo '<label style="margin-left: ' . $margem . 'px;" class="radio-inline">';
                        echo '<input type="radio" data-id="' . $i->id . '" data-name="' . $i->descricao . '" name="selecionado-select-area"/>' . $i->descricao;
                        echo '</label>';
                        if ($areas_sub = $i->areas) {
                            recurse($areas_sub, $nivel + 1);
                        }
                        echo '</li>';
                    }
                    echo '</ul>';
                }

                recurse($areas);
                ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>