<?php

/* @Product/ProductPage/Forms/form_manufacturer.html.twig */
class __TwigTemplate_97d400fa751091a4749f45f484af716646c594bd70c38109987d4f2ff1076648 extends Twig_Template
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
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Product/ProductPage/Forms/form_manufacturer.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Product/ProductPage/Forms/form_manufacturer.html.twig"));

        // line 25
        echo "<div id=\"manufacturer-content\" class=\"";
        echo ((($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "vars", array()), "value", array()) == "")) ? ("hide") : (""));
        echo "\">
  <h2>";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Brand", array(), "Admin.Catalog.Feature"), "html", null, true);
        echo "</h2>
  <div class=\"row\">
    <div class=\"col-md-4\">
      <fieldset class=\"form-group\">
      ";
        // line 30
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'widget');
        echo "
      <div class=\"col-md-12\">
        ";
        // line 32
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'errors');
        echo "
      </div>
      </fieldset>
    </div>
    <div class=\"col-md-1\">
      <a id=\"reset_brand_product\" class=\"btn tooltip-link delete pl-0 pr-0\"><i class=\"material-icons\">delete</i></a>
    </div>
  </div>
</div>
<div class=\"row\">
  <div class=\"col-md-4\">
    <button type=\"button\" class=\"btn btn-outline-primary sensitive open ";
        // line 43
        echo ((($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "vars", array()), "value", array()) != "")) ? ("hide") : (""));
        echo "\" id=\"add_brand_button\">
      <i class=\"material-icons\">add_circle</i> ";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Add a brand", array(), "Admin.Catalog.Feature"), "html", null, true);
        echo "
    </button>
  </div>
</div>
";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "@Product/ProductPage/Forms/form_manufacturer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  60 => 44,  56 => 43,  42 => 32,  37 => 30,  30 => 26,  25 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{#**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2018 PrestaShop SA
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * International Registered Trademark & Property of PrestaShop SA
 *#}
<div id=\"manufacturer-content\" class=\"{{ form.vars.value == '' ? 'hide':'' }}\">
  <h2>{{ \"Brand\"|trans({}, 'Admin.Catalog.Feature') }}</h2>
  <div class=\"row\">
    <div class=\"col-md-4\">
      <fieldset class=\"form-group\">
      {{ form_widget(form) }}
      <div class=\"col-md-12\">
        {{ form_errors(form) }}
      </div>
      </fieldset>
    </div>
    <div class=\"col-md-1\">
      <a id=\"reset_brand_product\" class=\"btn tooltip-link delete pl-0 pr-0\"><i class=\"material-icons\">delete</i></a>
    </div>
  </div>
</div>
<div class=\"row\">
  <div class=\"col-md-4\">
    <button type=\"button\" class=\"btn btn-outline-primary sensitive open {{ form.vars.value != '' ? 'hide':'' }}\" id=\"add_brand_button\">
      <i class=\"material-icons\">add_circle</i> {{ 'Add a brand'|trans({}, 'Admin.Catalog.Feature') }}
    </button>
  </div>
</div>
", "@Product/ProductPage/Forms/form_manufacturer.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Product\\ProductPage\\Forms\\form_manufacturer.html.twig");
    }
}
