<?php
namespace SimplyTestable\WebsiteBundle\Command\CacheValidator;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClearCommand extends ContainerAwareCommand
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
        $output->writeln('Clearing cache validator headers');
        $this->getContainer()->get('simplytestable.services.cachevalidatorheadersservice')->clear();
    }
}
