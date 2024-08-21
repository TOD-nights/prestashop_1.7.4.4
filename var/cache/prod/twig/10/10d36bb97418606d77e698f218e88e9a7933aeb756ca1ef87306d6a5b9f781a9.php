<?php

/* @PrestaShop/Admin/Configure/ShopParameters/preferences.html.twig */
class __TwigTemplate_609cf3b549a533848b2227871b0ea982384003e5fe9c946ac7bf8817fad679c2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 25
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/layout.html.twig", "@PrestaShop/Admin/Configure/ShopParameters/preferences.html.twig", 25);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'preferences_form_general' => array($this, 'block_preferences_form_general'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@PrestaShop/Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 29
        $context["generalForm"] = $this->getAttribute(($context["form"] ?? null), "general", array());
        // line 25
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 32
    public function block_content($context, array $blocks = array())
    {
        // line 33
        echo "    <div class=\"container\">
        ";
        // line 34
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_start', array("attr" => array("class" => "form", "id" => "configuration_form")));
        echo "
        <div class=\"row\">
            ";
        // line 36
        $this->displayBlock('preferences_form_general', $context, $blocks);
        // line 131
        echo "
        </div>
        ";
        // line 133
        echo         $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderBlock(($context["form"] ?? null), 'form_end');
        echo "
    </div>
";
    }

    // line 36
    public function block_preferences_form_general($context, array $blocks = array())
    {
        // line 37
        echo "                <div class=\"col\">
                    <div class=\"card\">
                        <h3 class=\"card-header\">
                            <i class=\"material-icons\">settings</i> ";
        // line 40
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("General", array(), "Admin.Global"), "html", null, true);
        echo "
                        </h3>
                        <div class=\"card-block\">
                            <div class=\"card-text\">
                                <div class=\"form-group\">
                                    ";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute(($context["ps"] ?? null), "label_with_help", array(0 => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable SSL", array(), "Admin.Shopparameters.Feature"), 1 => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("If you want to enable SSL on all the pages of your shop, activate the \"Enable on all the pages\" option below.", array(), "Admin.Shopparameters.Help")), "method"), "html", null, true);
        echo "
                                    ";
        // line 46
        if ($this->getAttribute($this->getAttribute(($context["app"] ?? null), "request", array()), "isSecure", array(), "method")) {
            // line 47
            echo "                                        ";
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_ssl", array()), 'errors');
            echo "
                                        ";
            // line 48
            echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_ssl", array()), 'widget');
            echo "
                                        <small class=\"form-text\">";
            // line 49
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("If you own an SSL certificate for your shop's domain name, you can activate SSL encryption (https://) for customer account identification and order processing.", array(), "Admin.Shopparameters.Help"), "html", null, true);
            echo "</small>
                                    ";
        } else {
            // line 51
            echo "                                        <a class=\"d-block\" href=\"";
            echo twig_escape_filter($this->env, ($context["sslUri"] ?? null), "html", null, true);
            echo "\">
                                          ";
            // line 52
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Please click here to check if your shop supports HTTPS.", array(), "Admin.Shopparameters.Feature"), "html", null, true);
            echo "
                                        </a>
                                    ";
        }
        // line 55
        echo "                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable SSL on all pages", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 58
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_ssl_everywhere", array()), 'errors');
        echo "
                                    ";
        // line 59
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_ssl_everywhere", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("When enabled, all the pages of your shop will be SSL-secured.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 63
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Increase front office security", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 64
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_token", array()), 'errors');
        echo "
                                    ";
        // line 65
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "enable_token", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable or disable token in the Front Office to improve PrestaShop's security.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 69
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Allow iframes on HTML fields", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 70
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "allow_html_iframes", array()), 'errors');
        echo "
                                    ";
        // line 71
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "allow_html_iframes", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 72
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Allow iframes on text fields like product description. We recommend that you leave this option disabled.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Use HTMLPurifier Library", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 76
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "use_htmlpurifier", array()), 'errors');
        echo "
                                    ";
        // line 77
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "use_htmlpurifier", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 78
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Clean the HTML content on text fields. We recommend that you leave this option enabled.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 81
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Round mode", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 82
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_round_mode", array()), 'errors');
        echo "
                                    ";
        // line 83
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_round_mode", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 84
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("You can choose among 6 different ways of rounding prices. \"Round up away from zero ...\" is the recommended behavior.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 87
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Round type", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 88
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_round_type", array()), 'errors');
        echo "
                                    ";
        // line 89
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_round_type", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 90
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("You can choose when to round prices: either on each item, each line or the total (of an invoice, for example).", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 93
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Number of decimals", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 94
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_display_precision", array()), 'errors');
        echo "
                                    ";
        // line 95
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "price_display_precision", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 96
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Choose how many decimals you want to display", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 99
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Display brands and suppliers", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 100
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "display_suppliers", array()), 'errors');
        echo "
                                    ";
        // line 101
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "display_suppliers", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 102
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable brands and suppliers pages on your front office even when their respective modules are disabled.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 105
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Display best sellers", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 106
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "display_best_sellers", array()), 'errors');
        echo "
                                    ";
        // line 107
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "display_best_sellers", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 108
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable best sellers page on your front office even when its respective module is disabled.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 111
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Enable Multistore", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 112
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "multishop_feature_active", array()), 'errors');
        echo "
                                    ";
        // line 113
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "multishop_feature_active", array()), 'widget');
        echo "
                                    <small class=\"form-text\">";
        // line 114
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The multistore feature allows you to manage several e-shops with one Back Office. If this feature is enabled, a \"Multistore\" page will be available in the \"Advanced Parameters\" menu.", array(), "Admin.Shopparameters.Help"), "html", null, true);
        echo "</small>
                                </div>
                                <div class=\"form-group\">
                                    <label class=\"form-control-label\">";
        // line 117
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Main Shop Activity", array(), "Admin.Shopparameters.Feature"), "html", null, true);
        echo "</label>
                                    ";
        // line 118
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "shop_activity", array()), 'errors');
        echo "
                                    ";
        // line 119
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["generalForm"] ?? null), "shop_activity", array()), 'widget');
        echo "
                                </div>
                            </div>
                        </div>
                        <div class=\"card-footer\">
                            <div class=\"d-flex justify-content-end\">
                                <button class=\"btn btn-primary\">";
        // line 125
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Save", array(), "Admin.Actions"), "html", null, true);
        echo "</button>
                            </div>
                        </div>
                    </div>
                </div>
            ";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Configure/ShopParameters/preferences.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  304 => 125,  295 => 119,  291 => 118,  287 => 117,  281 => 114,  277 => 113,  273 => 112,  269 => 111,  263 => 108,  259 => 107,  255 => 106,  251 => 105,  245 => 102,  241 => 101,  237 => 100,  233 => 99,  227 => 96,  223 => 95,  219 => 94,  215 => 93,  209 => 90,  205 => 89,  201 => 88,  197 => 87,  191 => 84,  187 => 83,  183 => 82,  179 => 81,  173 => 78,  169 => 77,  165 => 76,  161 => 75,  155 => 72,  151 => 71,  147 => 70,  143 => 69,  137 => 66,  133 => 65,  129 => 64,  125 => 63,  119 => 60,  115 => 59,  111 => 58,  107 => 57,  103 => 55,  97 => 52,  92 => 51,  87 => 49,  83 => 48,  78 => 47,  76 => 46,  72 => 45,  64 => 40,  59 => 37,  56 => 36,  49 => 133,  45 => 131,  43 => 36,  38 => 34,  35 => 33,  32 => 32,  28 => 25,  26 => 29,  11 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@PrestaShop/Admin/Configure/ShopParameters/preferences.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Configure\\ShopParameters\\preferences.html.twig");
    }
}
