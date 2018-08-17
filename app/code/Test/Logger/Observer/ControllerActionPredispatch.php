<?php 

namespace Test\Logger\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Psr\Log\LoggerInterface;

class ControllerActionPredispatch implements ObserverInterface
{
	protected $_remoteAddress;
	protected $_logger;
	protected $_urlInterface;
	protected $_directoryList;
	protected $_logfile_path;
	
	public function __construct(RemoteAddress $RemoteAddress, LoggerInterface $logger,  UrlInterface $urlInterface, DirectoryList $directoryList){
		$this->_remoteAddress = $RemoteAddress;
		$this->_logger = $logger;
		$this->_urlInterface = $urlInterface;
		$this->_logfile_path = $directoryList->getRoot().'/var/log/IP_Logger.log';
	}
	
   public function execute(\Magento\Framework\Event\Observer $observer)
   {
	   $remote_ip = $this->_remoteAddress->getRemoteAddress();
	   $current_url = $this->_urlInterface->getCurrentUrl();
	   
	   $message = sprintf('User with IP %s moved to %s.', $remote_ip, $current_url);
	   
	   //$this->_logger->pushHandler(new \Monolog\Handler\StreamHandler($this->_logfile_path));
	   
	   
	   // не стандартный log файл
		$writer = new \Zend\Log\Writer\Stream($this->_logfile_path);
		$logger = new \Zend\Log\Logger();
		$logger->addWriter($writer);
		$logger->info($message);	

		//echo $message; die;		
	   
	   //$this->_logger->info($message);   
   }

}