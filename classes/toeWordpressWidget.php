<?php
abstract class toeWordpressWidgetBcp extends WP_Widget {
	public function preWidget($args, $instance) {
		if(frameBcp::_()->isTplEditor())
			echo $args['before_widget'];
	}
	public function postWidget($args, $instance) {
		if(frameBcp::_()->isTplEditor())
			echo $args['after_widget'];
	}
}
