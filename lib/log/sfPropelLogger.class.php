<?php

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A symfony logging adapter for Propel
 *
 * @package    symfony
 * @subpackage log
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @version    SVN: $Id: sfPropelLogger.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfPropelLogger extends AbstractLogger
{
  protected
    $dispatcher = null;

  /**
   * Constructor.
   *
   * @param sfEventDispatcher $dispatcher
   */
  public function __construct(sfEventDispatcher $dispatcher = null)
  {
    if (null === $dispatcher)
    {
      $this->dispatcher = sfProjectConfiguration::getActive()->getEventDispatcher();
    }
    else
    {
      $this->dispatcher = $dispatcher;
    }
  }

    /**
     * Primary method to handle logging.
     *
     * @param $level
     * @param $message the message to log.
     * @param array $context
     * @return void
     *
     */
    public function log($level, $message, array $context = array())
    {
        $priority = sfLogger::DEBUG;
        switch ($level) {
            case LogLevel::EMERGENCY:
                $priority = sfLogger::EMERG;
                break;
            case LogLevel::ALERT:
                $priority = sfLogger::ALERT;
                break;
            case LogLevel::CRITICAL:
                $priority = sfLogger::CRIT;
                break;
            case LogLevel::ERROR:
                $priority = sfLogger::ERR;
                break;
            case LogLevel::WARNING:
                $priority = sfLogger::WARNING;
                break;
            case LogLevel::NOTICE:
                $priority = sfLogger::NOTICE;
                break;
            case LogLevel::INFO:
                $priority = sfLogger::INFO;
                break;
            case LogLevel::DEBUG:
                $priority = sfLogger::DEBUG;
                break;
        }
        $this->dispatcher->notify(new sfEvent($this, 'application.log', array($message, 'priority' => $priority)));
    }
}
