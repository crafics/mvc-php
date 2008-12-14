<?php
/* urls */
$urls = array(

	/* blog stuff */
	'^/blog/(?P<id>\d+)/'    	=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'singlePostAction'),
	'^/blog/feed/$'				=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'feedAction'),
	'^/blog/search/$'			=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'searchAction'),
	'^/blog/tag/'               => array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'tagAction'),
	'^/blog/post/thankyou/$'    => array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'thankyouAction'),
	'^/blog/post/$'          	=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'postAction'),
	'^/blog/posts/latest/'    	=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'latestBlogPostsAction'),

	/* admin stuff */
	'^/blog/settings/$'   		=> array('right'=>RIGHT_PRIVATE,'controller'=>'adminController','action'=>'settingsAction'),
	'^/blog/admin/$'   			=> array('right'=>RIGHT_PRIVATE,'controller'=>'adminController','action'=>'indexAction'),

	'^/blog/'          			=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'indexAction'),
	'^/$'   					=> array('right'=>RIGHT_PUBLIC,'controller'=>'blogController','action'=>'indexAction'),

);
