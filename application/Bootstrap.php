<?php
Zend_Layout::startMvc();
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

//include files css and js to loaded auto matically ////
	protected function _initPlaceholders()
	{
		$this->bootstrap('View');
		$view = $this->getResource('View');
		$view->doctype('XHTML1_STRICT');
		//add Meta tags
		$view->headMeta()->appendName('keywords', 'blog')->appendHttpEquiv('Content-Type','text/html;charset=utf-8');
		// Set the initial title and separator:
		$view->headTitle('Et3lm ')->setSeparator(' :: ');
		// Set the initial stylesheet:
		$view->headLink()->prependStylesheet('/css/site.css');
		// Set the initial JS to load:
		$view->headScript()->prependFile('/js/site.js');
	}

	//To activate session
	protected function _initSession(){
		//to start session////
		Zend_Session::start();
		//create namespace into session
		$session = new Zend_Session_Namespace( 'Zend_Auth' );
		$session->setExpirationSeconds( 1800 );
		
	}

}

