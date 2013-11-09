<?php
namespace SimplyTestable\WebsiteBundle\Command\CacheValidator;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use SimplyTestable\WebsiteBundle\Command\BaseCommand;

class ClearCommand extends BaseCommand
{ 
    
    protected function configure()
    {
        $this
            ->setName('simplytestable:cachevalidator:clear')
            ->setDescription('Clear cache validator headers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('simplytestable.services.cachevalidatorheadersservice')->clear();
    }   
}