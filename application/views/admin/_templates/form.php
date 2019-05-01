<?php
defined('BASEPATH') OR exit('No direct script allowed');

function checkbox($array)
{
        foreach ($array as $key => $val):
                ?>
                <div class="checkbox">
                    <label for="<?php echo $key; ?>">
                        <?php echo form_checkbox($key, $key, html_escape(set_value($key))); ?>
                        <?php echo $val; ?>
                    </label>
                </div>
                <?php
        endforeach;
}
?>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $my_form['caption']; ?></div>
            <div class="panel-body">
                <?php
                if (isset($my_form['upload']))
                {
                        if ($my_form['upload'])
                        {
                                echo form_open_multipart($my_form['action'], 'role="form"');
                        }
                        else
                        {
                                show_error('must upload set to TRUE');
                        }
                }
                else
                {
                        echo form_open($my_form['action'], 'role="form"');
                }
                ?>
                <div class="col-md-12">                    
                    <div class="form-group<?php echo (form_error('conflict') != null) ? ' has-error' : ''; ?>">
                        <?php echo form_error('conflict'); ?>
                    </div>
                </div>
                <?php
//if there is a problem, try uncomment this to see all validations
// echo validation_errors();
                ?>
                <?php foreach ($my_forms_inputs as $k => $my_input): ?>                
                        <div class="col-md-<?php echo $my_input['size'] ?>">
                            <?php foreach ($my_input['attr'] as $mykey => $attr): ?>
                                    <div class="form-group<?php echo (form_error($mykey) != null) ? ' has-error' : ''; ?>">
                                        <?php
                                        echo form_label($attr['title'], $mykey, array(
                                            'class' => 'control-label'
                                        ));
                                        ?>
                                        <?php
                                        $tmp = TRUE;
                                        switch ($attr['type'])
                                        {
                                                case 'text':
                                                        echo form_input(array(
                                                            'name'        => $mykey,
                                                            'class'       => 'form-control',
                                                            'value'       => ($attr['value'] == NULL) ? html_escape(set_value($mykey)) : $attr['value'],
                                                            'placeholder' => $attr['title']
                                                        ));
                                                        break;
                                                case 'password':
                                                        echo form_input(array(
                                                            'name'        => $mykey,
                                                            'type'        => 'password',
                                                            'class'       => 'form-control',
                                                            'value'       => ($attr['value'] == NULL) ? html_escape(set_value($mykey)) : $attr['value'],
                                                            'placeholder' => $attr['title']
                                                        ));
                                                        break;
                                                case 'combo':
                                                        echo form_dropdown($mykey, $attr['combo_value'], ($attr['value'] == NULL) ? html_escape(set_value($mykey)) : $attr['value'], array(
                                                            'class' => 'form-control'
                                                        ));
                                                        break;
                                                case 'checkbox':
                                                        checkbox($attr['checkbox_value']);
                                                        break;
                                                case 'file':
                                                        echo form_upload($mykey);
                                                        break;
                                                default:
                                                        $tmp = FALSE;
                                                        log_message('error', 'no value in form view');
                                                        break;
                                        }
                                        echo form_error($mykey);
                                        if ($tmp)
                                                log_message('debug', 'form attribute added > ' . $mykey);
                                        ?>
                                    </div>
                            <?php endforeach; ?>
                        </div>        
                <?php endforeach; ?>


                <div class="col-md-12">
                    <?php
                    echo form_submit($my_form['button_name'], $my_form['button_title'], array(
                        'class' => 'btn btn-primary'
                    ));
                    ?>
                    <?php
                    echo form_reset('reset', 'Reset', array(
                        'class' => 'btn btn-default'
                    ));
                    ?>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div><!-- /.col-->
</div><!-- /.row -->
