<?php

/* @Product/ProductPage/Panels/seo.html.twig */
class __TwigTemplate_fe35cf1898a452e918a56b242574bb65472e14017b376cca325652924909b5f9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 25
        echo "<div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step5\">
  <div class=\"row\">
    <div class=\"col-md-12\">
      <div class=\"container-fluid\">
        <div class=\"row\">
          ";
        // line 30
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_seo.html.twig", array("seoForm" =>         // line 31
($context["seoForm"] ?? null), "productId" =>         // line 32
($context["productId"] ?? null)));
        // line 34
        echo "
        </div>
      </div>
    </div>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Panels/seo.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 34,  28 => 32,  27 => 31,  26 => 30,  19 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@Product/ProductPage/Panels/seo.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Product\\ProductPage\\Panels\\seo.html.twig");
    }
}
