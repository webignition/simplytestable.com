<?php

namespace SimplyTestable\WebsiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpKernel\Log\LoggerInterface as Logger;

abstract class BaseCommand extends ContainerAwareCommand {    
    
    /**
     *
     * @return \Symfony\Component\HttpKernel\Log\LoggerInterface
     */
    protected function getLogger() {
        return $this->getContainer()->get('logger');
    }
    
}
