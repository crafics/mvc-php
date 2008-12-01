<?php
/* urls */
$url_mappings = array(

	/* blog stuff */

	'^/blog/(?P<id>\d+)/'    	=> 'blogController::singlePostAction',
	'^/blog/feed/$'				=> 'blogController::feedAction',
	'^/blog/search/$'			=> 'blogController::searchAction',
	'^/blog/tag/'               => 'blogController::tagAction',
	'^/blog/post/thankyou/$'    => 'blogController::thankyouAction',
	'^/blog/post/$'          	=> 'blogController::postAction',
	'^/blog/posts/latest/'    	=> 'blogController::latestBlogPostsAction',

	/* admin stuff */
	'^/blog/settings/$'   		=> 'adminController::settingsAction',
	'^/blog/admin/$'   			=> 'adminController::indexAction',


	'^/blog/'          			=> 'blogController::indexAction',
	'^/$'   					=> 'blogController::indexAction',

);
