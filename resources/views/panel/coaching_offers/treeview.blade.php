
                        <?php

                        $node = '';
                        if (!empty($courses[0]['products'])) {
                            $in = 0;
                            foreach ($courses[0]['products'] as $p) {
                                $p_id = $p['product']->id;

                                if ($in++ != 0)
                                    $node .= ',';
                                $node .= '{ "id": "p-' . $p_id . '", "text": "' . $p['product']->title . '", "children": [';
                        ?>
                                <input type="hidden" name="modules_selected_<?php echo $p_id; ?>" id="selected_modules_<?php echo $p_id; ?>">

                                <li><i class="fa fa-plus"></i> <label> <input type="checkbox" class="mp-<?php echo $p['product']->id; ?>" name="products[]" value="<?php echo $p['product']->id; ?>" onchange="select_items(this, '.p-<?php echo $p['product']->id; ?>')" id="p-<?php echo $p_id; ?>" data-id="cp2-<?php echo $p_id; ?>" onclick="item_selected('<?php echo $p_id; ?>')">

                                        <?php echo $p['product']->title . ' (' . trans('forms.lessons') . ': ' . $p['total_lessons'] . ' '/* . trans('forms.total_cost') . ': €' . $p['total_cost'] */. ')'; ?>
                                    </label>

                                    <ul>
                                        <?php
                                        if (!empty($p['modules'])) {
                                            $in2 = 0;
                                            foreach ($p['modules'] as $m) {
                                                $m_id = $m['module']->id;

                                                if ($in2++ != 0)
                                                    $node .= ',';
                                                $node .= '{ "id": "m-' . $m_id . '", "text": "' . $m['module']->title . '", "children": [';
                                        ?>
                                                <li>
                                                    <i class="fa fa-plus"></i> <label> <input type="checkbox" class="p-<?php echo $p['product']->id; ?>" name="modules<?php echo $p_id; ?>[]" value="<?php echo $m['module']->id; ?>" onchange="select_items(this, '.m-<?php echo $m['module']->id; ?>')" id="m-<?php echo $m_id; ?>" data-id="cm2-<?php echo $m_id; ?>" onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')">
                                                    </label>

                                                    <?php echo $m['module']->title . ' (' . trans('forms.lessons') . ': ' . $m['total_lessons'] . ' ' /*. trans('forms.total_cost') . ': €' . $m['total_cost'] */ . ')'; ?>

                                                    <ul>
                                                        <?php
                                                        if (!empty($m['items'])) {
                                                            $in3 = 0;
                                                            foreach ($m['items'] as $item) {
                                                                $mi_id = $item['item']->id;

                                                                if ($in3++ != 0)
                                                                    $node .= ',';
                                                                $node .= '{ "id": "mi-' . $mi_id . '", "text": "' . $item['item']->title . '" }';
                                                        ?>
                                                                <li>

                                                                    <label> <input type="checkbox" class="p-<?php echo $p['product']->id; ?> m-<?php echo $m['module']->id; ?> items_detail-<?php echo $p['product']->id; ?>" name="items<?php echo $m['module']->id; ?>[]" value="<?php echo $item['item']->id; ?>" id="mi-<?php echo $mi_id; ?>" data-id="cmi2-<?php echo $mi_id; ?>" onclick="item_selected('<?php echo $p_id; ?>'); item_selected2('<?php echo $p_id; ?>', '<?php echo $m_id; ?>')" onchange="select_product('<?php echo $p_id; ?>');" mdid="<?php echo $m['module']->id; ?>">

                                                                        <?php echo $item['item']->title; ?>
                                                                    </label>
                                                                    <input type="hidden" name="prices<?= $item['item']->id?>" value="<?= $item['item']->price_lessons?>">
                                                                    <?php echo ' ( ' . trans('forms.lessons') . ': <input type="number" name="lessons' . $item['item']->id . '" value="' . $item['item']->lessons . '" style="max-width:60px; padding-top:0px; padding-bottom:0px;" min="0" max="' . $item['item']->lessons . '" required id="item_id_'.$item['item']->id.'" onblur="sum_lession('.$p_id.');"> ' . /*trans('forms.price_lesson') . ': € ' . $item['item']->price_lessons .*/ ' )'; ?>

                                                                </li>
                                                        <?php }
                                                        } ?>
                                                    </ul>
                                                </li>
                                        <?php $node .= ' ]}';
                                            }
                                        } ?>

                                    </ul>
                                </li>
                                <!--<li style="list-style-type:none; padding-bottom:25px;"></li>-->
                        <?php $node .= ' ] }';
                            }
                        } ?>