<?php 

namespace Test\Logger\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

use \Test\Logger\Logger\Logger;

class ControllerActionPredispatch implements ObserverInterface
{
	protected $_remoteAddress;
	protected $_logger;
	protected $_urlInterface;
	
	public function __construct(RemoteAddress $RemoteAddress, Logger $logger, UrlInterface $urlInterface, DirectoryList $directoryList){
		$this->_remoteAddress = $RemoteAddress;
		$this->_logger = $logger;
		$this->_urlInterface = $urlInterface;
	}
	
   public function execute(\Magento\Framework\Event\Observer $observer)
   {
	   $remote_ip = $this->_remoteAddress->getRemoteAddress();
	   $current_url = $this->_urlInterface->getCurrentUrl();
	   
	   $message = sprintf('User with IP %s moved to %s.', $remote_ip, $current_url);
	   
	   //$this->_logger->pushHandler(new \Monolog\Handler\StreamHandler($this->_logfile_path));
	   $this->_logger->info($message);	   

		//echo $message; die;	      
   }

}