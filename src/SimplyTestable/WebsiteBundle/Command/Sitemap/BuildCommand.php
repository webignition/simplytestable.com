<?php
namespace SimplyTestable\WebsiteBundle\Command\Sitemap;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Routing\RouterInterface;

class BuildCommand extends ContainerAwareCommand
{
    /**
     * @var \DOMDocument
     */
    private $sitemapDom = null;

    /**
     * @var \DOMElement
     */
    private $urlElementTemplate = null;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('simplytestable:sitemap:build')
            ->setDescription('Build the sitemap.xml file')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getUrlsFromSource($this->getSitemapSource()) as $url) {
            $this->getSitemapDom()->getElementsByTagName('urlset')->item(0)->appendChild(
                $this->generateUrlElement($url)
            );
        }

        $sitemapContent = $this->getSitemapDom()->saveXML();
        file_put_contents($this->getSitemapPath() . '/sitemap.xml', $sitemapContent);
        $output->writeln('Generated sitemap at ['.$this->getSitemapPath().']');
    }

    /**
     * @return \DOMDocument
     */
    private function getSitemapDom()
    {
        if (is_null($this->sitemapDom)) {
            $this->sitemapDom = new \DOMDocument();
            $this->sitemapDom->loadXML($this->getSitemapTemplate());

            $urlElementTemplate = $this->sitemapDom->getElementsByTagName('url')->item(0);
            $this->urlElementTemplate = clone $urlElementTemplate;

            $this->sitemapDom->getElementsByTagName('urlset')->item(0)->removeChild($urlElementTemplate);
        }

        return $this->sitemapDom;
    }

    /**
     * @param $url
     *
     * @return \DOMElement
     */
    private function generateUrlElement($url)
    {
        $now = new \DateTime();

        $element = clone $this->urlElementTemplate;
        $element->getElementsByTagName('loc')->item(0)->nodeValue = $url;
        $element->getElementsByTagName('lastmod')->item(0)->nodeValue = $now->format('Y-m-d');

        return $element;
    }

    /**
     * @param \stdClass
     *
     * @return string[]
     */
    private function getUrlsFromSource($source)
    {
        $urls = [];

        foreach ($source as $relativePath => $details) {
            $urls[] = $this->getBaseUrl() . ltrim($relativePath, "/");

            if (!is_null($details)) {
                $urls = array_merge($urls, $this->getUrlsFromSource($details));
            }
        }

        return $urls;
    }

    /**
     * @return string
     */
    private function getBaseUrl()
    {
        $context = $this->getContainer()->get('router')->getContext();
        $context->setHost('simplytestable.com');
        $context->setScheme('https');

        return $this->getRouter()->generate('home_index', [], true);
    }

    /**
     * @return string
     */
    private function getSitemapPath()
    {
        return realpath($this->getContainer()->get('kernel')->getRootDir() . '/../web');
    }

    /**
     * @return string
     */
    private function getSitemapTemplate()
    {
        return file_get_contents(
            $this->getContainer()->get('kernel')->locateResource(
                '@SimplyTestableWebsiteBundle/Resources/config/sitemap.template.xml'
            )
        );
    }

    /**
     * @return \stdClass
     */
    private function getSitemapSource()
    {
        return json_decode(file_get_contents(
            $this->getContainer()->get('kernel')->locateResource(
                '@SimplyTestableWebsiteBundle/Resources/config/sitemap.source.json'
            )
        ));
    }

    /**
     * @return RouterInterface
     */
    private function getRouter()
    {
        return $this->getContainer()->get('router');
    }
}
