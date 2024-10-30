<style type="text/css">
    .postbox-container {
        padding-right: 0;
    }
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
    postboxes.add_postbox_toggles(pagenow);
    jQuery('#toeContactDevelopersForm').submit(function(){
        jQuery(this).sendForm({
            onSuccess: function(res) {
                if(!res.error) {
                    jQuery('#toeContactDevelopersForm').clearForm();
                }
            }
        });
        return false;
    });
});
</script>
<h1>Ready! Ecommerce v <?php echo $this->version?></h1>
<div class="wrap"><div>
<div id="dashboard-widgets" class="metabox-holder">
     
<div id="postbox-container-1" class="postbox-container" style="width:50%;">
    <div id="normal-sortables" class="meta-box-sortables ui-sortable">
        <div id="id1" class="postbox" style="display: block">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><?php langBcp::_e('FAQ')?></h3>
            <div class="inside">
                <p><?php langBcp::_e('-')?> <a href="http://readyshoppingcart.com/products_categories/templates/" title="WordPress E-commerce Themes">Free E-commerce Themes</a></p>
                <p><?php langBcp::_e('It is a complete solution for full-fledged shop. Our plugin is integrated in this free WordPress theme.')?></p>
                <p><?php langBcp::_e('To launch your shop, you need to complete 2 points:')?></p>
                <ol>
                    <li><?php langBcp::_e('Set up theme and plugin')?></li>
                    <li><?php langBcp::_e('Add products')?></li>
                </ol>
                <p><?php langBcp::_e('-')?> <a href="http://readyshoppingcart.com/faq/add-product-stepbystep-tutorial/">How to add goods?</a></p>
                <p><?php langBcp::_e('-')?> <a href="http://readyshoppingcart.com/faq/insert-product-in-to-theme/">How to display products on my online store?</a></p>
                <p><?php langBcp::_e('-')?> <a href="http://readyshoppingcart.com/faq/ecommerce-plugin-stepbystep/">How to adjust shipping | billing | taxes | main options?</a></p>
               <p><?php langBcp::_e('-')?> <a href="http://readyshoppingcart.com/faq/widgets/">Widgets FAQ</a></p>
                <p><?php langBcp::_e('- Video Tutorials')?></p>
            </div>
        </div>
        <div id="id2" class="postbox" style="display: block">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><?php langBcp::_e('System Information')?></h3>
            <div class="inside">
                <?php foreach($this->data['system_info'] as $key => $item) { ?>
                    <p><?php langBcp::_e($key)?>: <a class="<?php echo ($item['error'] ? 'toeErrorMsg' : 'toeSuccessMsg')?>"><?php echo $item['value']?></a></p>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<div id="postbox-container-2" class="postbox-container" style="width:50%;">
    <div id="side-sortables" class="meta-box-sortables ui-sortable">
        <div id="id3" class="postbox" style="display: block">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><?php langBcp::_e('Contact Us')?></h3>
            <div class="inside">
                <form id="toeContactDevelopersForm">
                    <table>
                        <tr><td valign="top"><label for="name"><?php langBcp::_e('Name')?></label>:</td><td><?php echo htmlBcp::text('name', array('attrs' => 'placeholder="'. langBcp::_('John Doe'). '"'))?></td></tr>
                        <tr><td valign="top"><label for="email"><?php langBcp::_e('E-mail')?></label>:</td><td><?php echo htmlBcp::text('email', array('attrs' => 'placeholder="'. langBcp::_('mail@example.com'). '"'))?></td></tr>
                        <tr><td valign="top"><label for="website"><?php langBcp::_e('Website')?></label>:</td><td><?php echo htmlBcp::text('website', array('attrs' => 'placeholder="'. langBcp::_('http://yoursite.com'). '"'))?></td></tr>
                        <tr><td valign="top"><label for="subject"><?php langBcp::_e('Subject')?></label>:</td><td><?php echo htmlBcp::text('subject', array('attrs' => 'placeholder="'. langBcp::_('Subject'). '"'))?></td></tr>
                        <tr><td valign="top"><label for="category"><?php langBcp::_e('Category')?></label>:</td><td><?php echo htmlBcp::selectbox('category', array('optionsBcp' => $this->devQuestions))?></td></tr>
                        <tr><td valign="top"><label for="message"><?php langBcp::_e('Message')?></label>:</td><td><?php echo htmlBcp::textarea('message', array('attrs' => 'placeholder="'. langBcp::_('Type your meassage here. If you have any troubles, please describe it accurately. If it`s possibe send us: (text of the errors, print screen of errors, link to the webpages where you try to insert products, and any other information)'). '"'))?></td></tr>
                        <tr>
                            <td valign="top">
                                <?php echo htmlBcp::hidden('mod', array('value' => 'adminmenu'))?>
                                <?php echo htmlBcp::hidden('action', array('value' => 'sendMailToDevelopers'))?>
                                <?php echo htmlBcp::hidden('reqType', array('value' => 'ajax'))?>
                                <?php echo htmlBcp::submit('send', array('value' => langBcp::_('Send e-mail')))?>
                            </td>
                            <td><div id="msg"></div></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div id="id4" class="postbox" style="display: block">
            <div class="handlediv" title="Click to toggle"><br></div>
            <h3 class="hndle"><?php langBcp::_e('News and Info')?></h3>
            <div class="inside">
                <p><?php langBcp::_e('- If you like our plugin, please rate it five stars at')?> <a href="http://wordpress.org/extend/plugins/ready-ecommerce/">wordpress.org</a></p>
                <p><?php langBcp::_e('- If you don\'t, please contact us, showing us our imperfection. We\'ll try to improve our service.')?></p>
                <p><?php langBcp::_e('- New '. BCP_VERSION. ' RC-1 version realised!')?></p>
            </div>
        </div>
    </div>
</div>
</div></div></div>
        
        
