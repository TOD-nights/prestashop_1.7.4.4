<?php

/* @PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig */
class __TwigTemplate_462faeff871dcd2e18afc6dca823c97c7dff7c8686eeea46ea5c47ee992a605b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 26
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/layout.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig", 26);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'import_panel' => array($this, 'block_import_panel'),
            'import_available_fields' => array($this, 'block_import_available_fields'),
            'import_sample_files' => array($this, 'block_import_sample_files'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@PrestaShop/Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 29
    public function block_content($context, array $blocks = array())
    {
        // line 30
        echo "    ";
        if (array_key_exists("importForm", $context)) {
            // line 31
            echo "    <div class=\"container\">
        <div class=\"row\">
            <div class=\"col-8\">
                ";
            // line 34
            $this->displayBlock('import_panel', $context, $blocks);
            // line 37
            echo "            </div>

            <div class=\"col-4\">
                ";
            // line 40
            $this->displayBlock('import_available_fields', $context, $blocks);
            // line 43
            echo "
                ";
            // line 44
            $this->displayBlock('import_sample_files', $context, $blocks);
            // line 47
            echo "            </div>
        </div>
    </div>
    ";
        }
    }

    // line 34
    public function block_import_panel($context, array $blocks = array())
    {
        // line 35
        echo "                    ";
        $this->loadTemplate("@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_panel.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig", 35)->display($context);
        // line 36
        echo "                ";
    }

    // line 40
    public function block_import_available_fields($context, array $blocks = array())
    {
        // line 41
        echo "                    ";
        $this->loadTemplate("@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_available_fields.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig", 41)->display($context);
        // line 42
        echo "                ";
    }

    // line 44
    public function block_import_sample_files($context, array $blocks = array())
    {
        // line 45
        echo "                    ";
        $this->loadTemplate("@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_sample_files.html.twig", "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig", 45)->display($context);
        // line 46
        echo "                ";
    }

    // line 53
    public function block_javascripts($context, array $blocks = array())
    {
        // line 54
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "

    <script src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/new-theme/public/imports.bundle.js"), "html", null, true);
        echo "\"></script>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  104 => 56,  98 => 54,  95 => 53,  91 => 46,  88 => 45,  85 => 44,  81 => 42,  78 => 41,  75 => 40,  71 => 36,  68 => 35,  65 => 34,  57 => 47,  55 => 44,  52 => 43,  50 => 40,  45 => 37,  43 => 34,  38 => 31,  35 => 30,  32 => 29,  11 => 26,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@PrestaShop/Admin/Configure/AdvancedParameters/ImportPage/import.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Configure\\AdvancedParameters\\ImportPage\\import.html.twig");
    }
}
