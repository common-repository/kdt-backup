<?php
class adminmenuControllerBcp extends controllerBcp {
    public function sendMailToDevelopers() {
        $res = new responseBcp();
        $data = reqBcp::get('post');
        $fields = array(
            'name' => new fieldBcpBcp('name', langBcp::_('Your name field is required.'), '', '', 'Your name', 0, array(), 'notEmpty'),
            'website' => new fieldBcpBcp('website', langBcp::_('Your website field is required.'), '', '', 'Your website', 0, array(), 'notEmpty'),
            'email' => new fieldBcpBcp('email', langBcp::_('Your e-mail field is required.'), '', '', 'Your e-mail', 0, array(), 'notEmpty, email'),
            'subject' => new fieldBcpBcp('subject', langBcp::_('Subject field is required.'), '', '', 'Subject', 0, array(), 'notEmpty'),
            'category' => new fieldBcpBcp('category', langBcp::_('You must select a valid category.'), '', '', 'Category', 0, array(), 'notEmpty'),
            'message' => new fieldBcpBcp('message', langBcp::_('Message field is required.'), '', '', 'Message', 0, array(), 'notEmpty'),
        );
        foreach($fields as $f) {
            $f->setValue($data[$f->name]);
            $errors = validatorBcp::validate($f);
            if(!empty($errors)) {
                $res->addError($errors);
            }
        }
        if(!$res->error) {
            $msg = 'Message from: '. get_bloginfo('name').', Host: '. $_SERVER['HTTP_HOST']. '<br />';
            foreach($fields as $f) {
                $msg .= '<b>'. $f->label. '</b>: '. nl2br($f->value). '<br />';
            }
			$headers[] = 'From: '. $fields['name']->value. ' <'. $fields['email']->value. '>';
			add_filter('wp_mail_content_type', array(frameBcp::_()->getModule('messenger'), 'mailContentType'));
            wp_mail('ukrainecmk@ukr.net, simon@readyshoppingcart.com, support@readyecommerce.zendesk.com', 'Ready Ecommerce Contact Dev', $msg, $headers);
            $res->addMessage(langBcp::_('Done'));
        }
        $res->ajaxExec();
    }
}

