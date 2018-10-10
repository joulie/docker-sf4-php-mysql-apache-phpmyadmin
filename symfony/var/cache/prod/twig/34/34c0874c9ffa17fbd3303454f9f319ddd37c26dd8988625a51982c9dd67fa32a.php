<?php

/* index.html.twig */
class __TwigTemplate_a98334e6b76808a4ea8133c86b02f518bd8d718a622e4bbab9e15e048f2ffbea extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "index.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = array())
    {
        // line 3
        echo "<p>
    Bonjour et bienvenue sur le test Hardis pour Alexandre Joulie
    <br>
    vous trouverez les résultats du test1 via l'URL /test1 : test1.1 via /test1/{id existant} - test1.2 via /test1/{id inexistant}
    <br>
    vous trouverez les résultats du test2 via l'URL /test2 : test 2.1 via /test2 - test 2.2 avec un fichier .csv vide (hébergé ici dans hardis\\public\\donnees.csv - test 2.3 en déplaçant le fichier de la précédente URL
</p>
";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  35 => 3,  32 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html.twig", "/home/wwwroot/sf4/templates/index.html.twig");
    }
}
