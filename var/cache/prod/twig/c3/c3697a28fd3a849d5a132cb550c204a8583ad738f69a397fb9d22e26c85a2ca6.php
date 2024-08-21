<?php

/* @PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_sample_files.html.twig */
class __TwigTemplate_718c5ffdcaa7a73e168cf2d0ae26d3bcf56a42130bb3c3b6f7612ba77e36ba68 extends Twig_Template
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
        echo "
";
        // line 27
        echo "
<div class=\"card\">
    <h3 class=\"card-header\">
        <i class=\"material-icons\">file_download</i> ";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Download sample csv files", array(), "Admin.Advparameters.Feature"), "html", null, true);
        echo "
    </h3>

    <div class=\"card-block\">
        <div class=\"list-group\">
            ";
        // line 35
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Categories file", 1 => "categories_import"), "method"), "html", null, true);
        echo "
            ";
        // line 36
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Products file", 1 => "products_import"), "method"), "html", null, true);
        echo "
            ";
        // line 37
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Combinations file", 1 => "combinations_import"), "method"), "html", null, true);
        echo "
            ";
        // line 38
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Customers file", 1 => "customers_import"), "method"), "html", null, true);
        echo "
            ";
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Addresses file", 1 => "addresses_import"), "method"), "html", null, true);
        echo "
            ";
        // line 40
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Brands file", 1 => "manufacturers_import"), "method"), "html", null, true);
        echo "
            ";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Suppliers file", 1 => "suppliers_import"), "method"), "html", null, true);
        echo "
            ";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Aliases file", 1 => "alias_import"), "method"), "html", null, true);
        echo "
            ";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "import_file_sample", array(0 => "Sample Store Contacts file", 1 => "store_contacts"), "method"), "html", null, true);
        echo "
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_sample_files.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 43,  63 => 42,  59 => 41,  55 => 40,  51 => 39,  47 => 38,  43 => 37,  39 => 36,  35 => 35,  27 => 30,  22 => 27,  19 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_sample_files.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Configure\\AdvancedParameters\\Blocks\\import_sample_files.html.twig");
    }
}
