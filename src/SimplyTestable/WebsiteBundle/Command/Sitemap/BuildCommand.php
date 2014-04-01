<?php
namespace SimplyTestable\WebsiteBundle\Command\Sitemap;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SimplyTestable\WebsiteBundle\Command\BaseCommand;

class BuildCommand extends BaseCommand
{ 
    
    protected function configure()
    {
        $this
            ->setName('simplytestable:sitemap:build')
            ->setDescription('Build the sitemap.xml file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {  
        $sitemapContent = str_replace('{{last-modified-date}}', date('Y-m-d'), $this->getSitemapTemplate());
        file_put_contents($this->getSitemapPath() . '/sitemap.xml', $sitemapContent);
        $output->writeln('Generated sitemap at ['.$this->getSitemapPath().']');
    }
    
    
    private function getSitemapPath() {
        return realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
    }
    
    
    private function getSitemapTemplate() {
        return file_get_contents($this->getContainer()->get('kernel')->locateResource('@SimplyTestableWebsiteBundle/Resources/config/sitemap.template.xml'));        
    }
}