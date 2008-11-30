<?php
/* urls */
$url_mappings = array(

	'^/blog/(?P<id>\d+)/'    	=> 'blogController::singlePostAction',
	'^/blog/feed/$'				=> 'blogController::feedAction',
	'^/blog/search/$'			=> 'blogController::searchAction',
	'^/blog/tag/'               => 'blogController::tagAction',
	'^/blog/post/thankyou/$'    => 'blogController::thankyouAction',
	'^/blog/post/$'          	=> 'blogController::postAction',
	'^/blog/posts/latest/'    	=> 'blogController::latestBlogPostsAction',
	'^/blog/'          			=> 'blogController::indexAction',
	'^/$'   					=> 'blogController::indexAction',

);
