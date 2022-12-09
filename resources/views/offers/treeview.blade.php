<link href="<?php echo url('hummingbird/hummingbird-treeview.css'); ?>"
    rel="stylesheet" type="text/css">
<style>
.hummingbird-treeview * {
    font-size: 18px;
}
.section-title {
    border-top: 1px solid #c0c0c0;
    padding-top: 1rem;
}
</style>


                                                        <ul id="treeview" class="hummingbird-base">
                        <?php
                        $node = '';    
                        $in = 0;
                            foreach ($products as $p) {
                                $p_id = $p['product']->id;
                                
                                if ($in++ != 0)
                                    $node .= ',';
                                    $node .= '{ "id": "p-' . $p_id . '", "text": "' . $p['product']->title . '", "children": [';
                                    ?>
                                <input type="hidden" name="modules_selected_<?php echo $p_id; ?>" id="selected_modules_<?php echo $p_id; ?>">

                                <li><i class="fa fa-plus"></i> <label> <input type="checkbox" class="mp-<?php echo $p['product']->id; ?>" name="products[]" value="<?php echo $p['product']->id; ?>" onchange="select_items(this, '.p-<?php echo $p['product']->id; ?>')" id="p-<?php echo $p['product']->id; ?>" data-id="cp2-<?php echo $p['product']->id; ?>" onclick="item_selected('<?php echo $p['product']->id; ?>')">

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
                                                    <i class="fa fa-plus"></i> <label> <input type="checkbox" class="p-<?php echo $p['product']->id; ?>" name="modules[]" value="<?php echo $m['module']->id; ?>" onchange="select_items(this, '.m-<?php echo $m['module']->id; ?>')" id="m-<?php echo $m_id; ?>" data-id="cm2-<?php echo $m_id; ?>" onclick="item_selected('<?php echo $p['product']->id; ?>'); item_selected2('<?php echo $p['product']->id; ?>', '<?php echo $m_id; ?>')">
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

                                                                    <label> <input type="checkbox" class="p-<?php echo $p['product']->id; ?> m-<?php echo $m['module']->id; ?> items_detail-<?php echo $p['product']->id; ?>" name="items[]" value="<?php echo $item['item']->id; ?>" id="mi-<?php echo $mi_id; ?>" data-id="cmi2-<?php echo $mi_id; ?>" onclick="item_selected('<?php echo $p['product']->id; ?>'); item_selected2('<?php echo $p['product']->id; ?>', '<?php echo $m_id; ?>')">

                                                                        <?php echo $item['item']->title; ?>
                                                                    </label>
                                                                    <input type="hidden" name="prices<?= $item['item']->id?>" value="<?= $item['item']->price?>">
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
                        
                       
                         ?>

                         </ul>
                                                    </div>

                                                </div>
                                            </div>
                        
                      <script src="<?php echo url('hummingbird/hummingbird-treeview.js'); ?>"></script>
<script>
$("#treeview").hummingbird();
$( "#checkAll" ).click(function() {
$("#treeview").hummingbird("checkAll");
});
$( "#uncheckAll" ).click(function() {
  $("#treeview").hummingbird("uncheckAll");
});
$( "#collapseAll" ).click(function() {
  $("#treeview").hummingbird("collapseAll");
});
$( "#checkNode" ).click(function() {
  $("#treeview").hummingbird("checkNode",{attr:"id",name: "node-0-2-2",expandParents:false});
});
    
$("#treeview").hummingbird();
                         
                         function item_selected(p_id)
    {
        var old_files=$("#selected_products").val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(p_id);
        var new_files=files.join(',');
        $("#selected_products").val(new_files);
    }
    
    function item_selected2(p_id, m_id)
    {
        var old_files=$("#selected_modules_"+p_id).val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(m_id);
        var new_files=files.join(',');
        $("#selected_modules_"+p_id).val(new_files);
    }
    
    function item_selected12(p_id)
    {
        var old_files=$("#selected_products2").val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(p_id);
        var new_files=files.join(',');
        $("#selected_products2").val(new_files);
    }
    
    function item_selected22(p_id, m_id)
    {
        var old_files=$("#selected_modules2_"+p_id).val();
        if(old_files!='')
        var files=old_files.split(',');
        else var files=[];
        files.push(m_id);
        var new_files=files.join(',');
        $("#selected_modules2_"+p_id).val(new_files);
    }
    
    function select_items(th, checkboxes)
    {
        if($(th).is(':checked')) $(checkboxes).prop('checked', true);
        else $(checkboxes).prop('checked', false);
    }

</script>
