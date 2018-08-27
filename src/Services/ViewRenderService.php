<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class ViewRenderService
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var DefaultViewParameters
     */
    private $defaultViewParameters;

    public function __construct(Twig_Environment $twig, DefaultViewParameters $defaultViewParameters)
    {
        $this->twig = $twig;
        $this->defaultViewParameters = $defaultViewParameters;
    }

    /**
     * @param string $view
     * @param array $parameters
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderView($view, array $parameters = [])
    {
        return $this->twig->render($view, $parameters);
    }

    /**
     * @param string $view
     * @param array $parameters
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderViewWithDefaultViewParameters($view, array $parameters = [])
    {
        return $this->renderView(
            $view,
            array_merge($this->defaultViewParameters->getDefaultViewParameters(), $parameters)
        );
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderResponse($view, array $parameters = [], Response $response = null)
    {
        if (empty($response)) {
            $response = new Response();
        }

        $content = $this->renderView($view, $parameters);

        $response->setContent($content);

        return $response;
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     *
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderResponseWithDefaultViewParameters($view, array $parameters = [], Response $response = null)
    {
        return $this->renderResponse(
            $view,
            array_merge($this->defaultViewParameters->getDefaultViewParameters(), $parameters),
            $response
        );
    }
}
