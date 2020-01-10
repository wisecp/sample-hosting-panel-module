<div class="hizmetblok" id="block_module_details_con">
    <div class="block_module_details-title formcon">
        <h4><?php echo $module->lang[$module->page]; ?></h4>
    </div>

    <div class="clear"></div>
    <br>

    <form action="<?php echo $module->area_link; ?>" method="post" id="form-<?php echo $module->page; ?>">
        <input type="hidden" name="inc" value="use_method">
        <input type="hidden" name="method" value="<?php echo $module->page; ?>">

        <input type="text" name="var1" value="" placeholder="Input 1">
        <input type="text" name="var2" value="" placeholder="Input 2">


        <a href="javascript:void(0);" id="form-<?php echo $module->page; ?>_submit" class="yesilbtn gonderbtn" onclick=' MioAjaxElement($(this),{"result":"t_form_handle", "waiting_text":"<?php echo addslashes(__("website/others/button5-pending")); ?>"});'>
            <?php echo $module->lang["apply"]; ?>
        </a>
    </form>