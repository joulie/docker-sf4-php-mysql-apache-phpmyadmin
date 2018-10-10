<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the public 'twig' shared service.

include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/LoaderInterface.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/ExistsLoaderInterface.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/SourceContextLoaderInterface.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/Loader/Filesystem.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/ExtensionInterface.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/Extension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/TranslationExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/CodeExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/RoutingExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/YamlExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/StopwatchExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/HttpKernelExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/Extension/HttpFoundationExtension.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bridge/AppVariable.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/RuntimeLoaderInterface.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/ContainerRuntimeLoader.php';
include_once $this->targetDirs[3].'/vendor/symfony/twig-bundle/DependencyInjection/Configurator/EnvironmentConfigurator.php';
include_once $this->targetDirs[3].'/vendor/twig/twig/lib/Twig/Environment.php';
include_once $this->targetDirs[3].'/vendor/symfony/stopwatch/Stopwatch.php';

$a = new \Twig\Loader\FilesystemLoader(array(), $this->targetDirs[3]);
$a->addPath(($this->targetDirs[3].'/vendor/symfony/framework-bundle/Resources/views'), 'Framework');
$a->addPath(($this->targetDirs[3].'/vendor/symfony/framework-bundle/Resources/views'), '!Framework');
$a->addPath(($this->targetDirs[3].'/templates/bundles/TwigBundle'), 'Twig');
$a->addPath(($this->targetDirs[3].'/vendor/symfony/twig-bundle/Resources/views'), 'Twig');
$a->addPath(($this->targetDirs[3].'/vendor/symfony/twig-bundle/Resources/views'), '!Twig');
$a->addPath(($this->targetDirs[3].'/templates'));

$this->services['twig'] = $instance = new \Twig\Environment($a, array('default_path' => ($this->targetDirs[3].'/templates'), 'debug' => false, 'strict_variables' => false, 'exception_controller' => 'twig.controller.exception::showAction', 'form_themes' => $this->parameters['twig.form.resources'], 'autoescape' => 'name', 'cache' => ($this->targetDirs[0].'/twig'), 'charset' => 'UTF-8', 'paths' => array(), 'date' => array('format' => 'F j, Y H:i', 'interval_format' => '%d days', 'timezone' => NULL), 'number_format' => array('decimals' => 0, 'decimal_point' => '.', 'thousands_separator' => ',')));

$b = ($this->services['request_stack'] ?? $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack());

$c = new \Symfony\Bridge\Twig\AppVariable();
$c->setEnvironment('prod');
$c->setDebug(false);
if ($this->has('request_stack')) {
    $c->setRequestStack($b);
}

$instance->addExtension(new \Symfony\Bridge\Twig\Extension\TranslationExtension(NULL));
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\CodeExtension(($this->privates['debug.file_link_formatter'] ?? $this->privates['debug.file_link_formatter'] = new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL)), ($this->targetDirs[3].'/src'), 'UTF-8'));
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\RoutingExtension(($this->services['router'] ?? $this->getRouterService())));
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\YamlExtension());
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\StopwatchExtension(($this->privates['debug.stopwatch'] ?? $this->privates['debug.stopwatch'] = new \Symfony\Component\Stopwatch\Stopwatch(true)), false));
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpKernelExtension());
$instance->addExtension(new \Symfony\Bridge\Twig\Extension\HttpFoundationExtension($b, ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService())));
$instance->addGlobal('app', $c);
$instance->addRuntimeLoader(new \Twig\RuntimeLoader\ContainerRuntimeLoader(new \Symfony\Component\DependencyInjection\ServiceLocator(array('Symfony\\Bridge\\Twig\\Extension\\HttpKernelRuntime' => function () {
    return ($this->privates['twig.runtime.httpkernel'] ?? $this->load('getTwig_Runtime_HttpkernelService.php'));
}))));
(new \Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator('F j, Y H:i', '%d days', NULL, 0, '.', ','))->configure($instance);

return $instance;
