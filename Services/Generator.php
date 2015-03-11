<?php

namespace Mtt\Bundle\DoctrineToEmberBundle\Services;

/**
 * Class Generator
 * @package Mtt\Bundle\DoctrineToEmberBundle\Services
 */
class Generator
{
    /**
     * @var string
     */
    protected $appVariable;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param string $appVariable
     * @param string $path
     */
    public function __construct($appVariable, $path)
    {
        $this->appVariable = $appVariable;
        $this->path = $path;
    }

    /**
     * @param array $classes
     * @param array $skeletonDirs
     */
    public function generate(array $classes, array $skeletonDirs)
    {
        $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem($skeletonDirs), array(
            'debug' => true,
            'cache' => false,
            'strict_variables' => true,
            'autoescape' => false,
        ));

        foreach ($classes as $class) {
            $this->renderFile(
                'model.js.twig',
                $this->getModelPath($class),
                array(
                    'appVariable' => $this->appVariable,
                    'modelName' => $class['modelName'],
                    'fields' => $class['fields'],
                )
            );
        }
    }

    /**
     * @param $template
     * @param $target
     * @param array $parameters
     * @return integer
     */
    protected function renderFile($template, $target, array $parameters)
    {
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }

        $content = $this->twig->render($template, $parameters);

        return file_put_contents($target, $content);
    }

    /**
     * @param array $class
     * @return string
     */
    protected function getModelPath(array $class)
    {
        return sprintf('%s/%s.js', $this->path, $class['modelName']);
    }
}
