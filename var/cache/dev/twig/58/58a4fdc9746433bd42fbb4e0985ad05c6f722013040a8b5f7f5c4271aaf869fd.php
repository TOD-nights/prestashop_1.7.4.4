<?php

/* @PrestaShop/Admin/Product/ProductPage/product.html.twig */
class __TwigTemplate_900f408fb8c3468434a296f1f9485bd5b007b5aab1bb09eecf8857709dba5698 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 25
        $this->parent = $this->loadTemplate("@PrestaShop/Admin/layout.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 25);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
            'product_header' => array($this, 'block_product_header'),
            'product_tabs_container' => array($this, 'block_product_tabs_container'),
            'product_panel_essentials' => array($this, 'block_product_panel_essentials'),
            'product_panel_combinations' => array($this, 'block_product_panel_combinations'),
            'product_panel_shipping' => array($this, 'block_product_panel_shipping'),
            'product_panel_pricing' => array($this, 'block_product_panel_pricing'),
            'product_panel_seo' => array($this, 'block_product_panel_seo'),
            'product_panel_options' => array($this, 'block_product_panel_options'),
            'product_panel_modules' => array($this, 'block_product_panel_modules'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@PrestaShop/Admin/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Product/ProductPage/product.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Product/ProductPage/product.html.twig"));

        // line 327
        $context["js_translatable"] = twig_array_merge(array("Are you sure to disable variations ? they will all be deleted" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This will delete all the combinations. Do you wish to proceed?", array(), "Admin.Catalog.Notification")),         // line 329
($context["js_translatable"] ?? $this->getContext($context, "js_translatable")));
        // line 331
        $context["js_translatable"] = twig_array_merge(array("Form update success" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Settings updated.", array(), "Admin.Notifications.Success"), "Form update errors" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Unable to update settings.", array(), "Admin.Notifications.Error"), "Delete" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete", array(), "Admin.Actions"), "ToLargeFile" => twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("The file is too large. Maximum size allowed is: [1]. The file you are trying to upload is [2].", array(), "Admin.Notifications.Error"), array("[1]" => "{{maxFilesize}}", "[2]" => "{{filesize}}")), "Drop images here" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Drop images here", array(), "Admin.Catalog.Feature"), "or select files" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("or select files", array(), "Admin.Catalog.Feature"), "files recommandations" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Recommended size 800 x 800px for default theme.", array(), "Admin.Catalog.Feature"), "files recommandations2" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("JPG, GIF or PNG format.", array(), "Admin.Catalog.Feature"), "Cover" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Cover", array(), "Admin.Catalog.Feature"), "Are you sure to delete this?" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Are you sure to delete this?", array(), "Admin.Notifications.Warning"), "This will delete the specific price. Do you wish to proceed?" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("This will delete the specific price. Do you wish to proceed?", array(), "Admin.Catalog.Notification"), "Quantities" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Quantities", array(), "Admin.Catalog.Feature"), "Combinations" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Combinations", array(), "Admin.Catalog.Feature"), "Virtual product" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Virtual product", array(), "Admin.Catalog.Feature"), "tax incl." => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("tax incl.", array(), "Admin.Catalog.Feature"), "tax excl." => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("tax excl.", array(), "Admin.Catalog.Feature"), "You can't create pack product with variations. Are you sure to disable variations ? they will all be deleted." => (($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("A pack of products can't have combinations.", array(), "Admin.Catalog.Notification") . " ") . $this->getAttribute(        // line 348
($context["js_translatable"] ?? $this->getContext($context, "js_translatable")), "Are you sure to disable variations ? they will all be deleted", array(), "array")), "You can't create virtual product with variations. Are you sure to disable variations ? they will all be deleted." => (($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("A virtual product can't have combinations.", array(), "Admin.Catalog.Notification") . " ") . $this->getAttribute(        // line 349
($context["js_translatable"] ?? $this->getContext($context, "js_translatable")), "Are you sure to disable variations ? they will all be deleted", array(), "array"))),         // line 350
($context["js_translatable"] ?? $this->getContext($context, "js_translatable")));
        // line 25
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 27
    public function block_content($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 28
        echo "
  <form name=\"form\" id=\"form\" method=\"post\" class=\"form-horizontal product-page row justify-content-md-center\" novalidate=\"novalidate\">

    ";
        // line 31
        if ( !($context["editable"] ?? $this->getContext($context, "editable"))) {
            echo " <fieldset disabled id=\"field-disabled\"> ";
        }
        // line 32
        echo "    ";
        // line 33
        echo "    ";
        $this->displayBlock('product_header', $context, $blocks);
        // line 44
        echo "
    <div class=\"col-md-10\">
      <div id=\"form_bubbling_errors\">
        ";
        // line 47
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock(($context["form"] ?? $this->getContext($context, "form")), 'errors');
        echo "
      </div>
    </div>

    <div id=\"form-loading\" class=\"col-xxl-10\">
      ";
        // line 53
        echo "      ";
        $this->displayBlock('product_tabs_container', $context, $blocks);
        // line 56
        echo "      <div id=\"form_content\" class=\"tab-content\">

        ";
        // line 59
        echo "        ";
        $this->displayBlock('product_panel_essentials', $context, $blocks);
        // line 80
        echo "
        ";
        // line 82
        echo "        ";
        $this->displayBlock('product_panel_combinations', $context, $blocks);
        // line 103
        echo "
        ";
        // line 105
        echo "        ";
        $this->displayBlock('product_panel_shipping', $context, $blocks);
        // line 124
        echo "
        ";
        // line 126
        echo "        ";
        $this->displayBlock('product_panel_pricing', $context, $blocks);
        // line 133
        echo "
        ";
        // line 135
        echo "        ";
        $this->displayBlock('product_panel_seo', $context, $blocks);
        // line 141
        echo "
        ";
        // line 143
        echo "        ";
        $this->displayBlock('product_panel_options', $context, $blocks);
        // line 149
        echo "
        ";
        // line 151
        echo "        ";
        $this->displayBlock('product_panel_modules', $context, $blocks);
        // line 247
        echo "      </div>

      ";
        // line 249
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "id_product", array()), 'widget');
        echo "
      ";
        // line 250
        echo $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->searchAndRenderBlock($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "_token", array()), 'widget');
        echo "

    </div>
    ";
        // line 254
        echo "    ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/footer.html.twig", array("preview_link" =>         // line 255
($context["preview_link"] ?? $this->getContext($context, "preview_link")), "preview_link_deactivate" =>         // line 256
($context["preview_link_deactivate"] ?? $this->getContext($context, "preview_link_deactivate")), "is_shop_context" =>         // line 257
($context["is_shop_context"] ?? $this->getContext($context, "is_shop_context")), "editable" =>         // line 258
($context["editable"] ?? $this->getContext($context, "editable")), "is_active" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 259
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "vars", array()), "value", array()), "active", array()), "productId" =>         // line 260
($context["id_product"] ?? $this->getContext($context, "id_product"))));
        // line 261
        echo "
    ";
        // line 262
        if ( !($context["editable"] ?? $this->getContext($context, "editable"))) {
            echo " </fieldset> ";
        }
        // line 263
        echo "  </form>


  ";
        // line 266
        $this->loadTemplate("@PrestaShop/Admin/Product/ProductPage/product.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 266, "1805355240")->display(array_merge($context, array("id" => "confirmation_modal", "title" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Warning", array(), "Admin.Notifications.Warning"), "closable" => false, "actions" => array(0 => array("type" => "button", "label" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("No", array(), "Admin.Global"), "class" => "btn btn-outline-secondary btn-lg cancel"), 1 => array("type" => "button", "label" => $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Yes", array(), "Admin.Global"), "class" => "btn btn-primary btn-lg continue")))));
        // line 287
        echo "
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 33
    public function block_product_header($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_header"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_header"));

        // line 34
        echo "      ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/header.html.twig", array("formName" => $this->getAttribute($this->getAttribute(        // line 35
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "name", array()), "formType" => $this->getAttribute($this->getAttribute(        // line 36
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "type_product", array()), "is_multishop_context" =>         // line 37
($context["is_multishop_context"] ?? $this->getContext($context, "is_multishop_context")), "languages" =>         // line 38
($context["languages"] ?? $this->getContext($context, "languages")), "help_link" =>         // line 39
($context["help_link"] ?? $this->getContext($context, "help_link")), "stats_link" =>         // line 40
($context["stats_link"] ?? $this->getContext($context, "stats_link"))));
        // line 42
        echo "
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 53
    public function block_product_tabs_container($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_tabs_container"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_tabs_container"));

        // line 54
        echo "        ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Blocks/tabs.html.twig");
        echo "
      ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 59
    public function block_product_panel_essentials($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_essentials"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_essentials"));

        // line 60
        echo "          ";
        $context["formQuantityShortcut"] = (($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step1", array(), "any", false, true), "qty_0_shortcut", array(), "any", true, true)) ? ($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "qty_0_shortcut", array())) : (null));
        // line 61
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/essentials.html.twig", array("formPackItems" => $this->getAttribute($this->getAttribute(        // line 62
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "inputPackItems", array()), "productId" =>         // line 63
($context["id_product"] ?? $this->getContext($context, "id_product")), "images" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 64
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "vars", array()), "value", array()), "images", array()), "formShortDescription" => $this->getAttribute($this->getAttribute(        // line 65
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "description_short", array()), "formDescription" => $this->getAttribute($this->getAttribute(        // line 66
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "description", array()), "formFeatures" => $this->getAttribute($this->getAttribute(        // line 67
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "features", array()), "formManufacturer" => $this->getAttribute($this->getAttribute(        // line 68
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "id_manufacturer", array()), "formRelatedProducts" => $this->getAttribute($this->getAttribute(        // line 69
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "related_products", array()), "is_combination_active" =>         // line 70
($context["is_combination_active"] ?? $this->getContext($context, "is_combination_active")), "has_combinations" =>         // line 71
($context["has_combinations"] ?? $this->getContext($context, "has_combinations")), "formReference" => $this->getAttribute($this->getAttribute(        // line 72
($context["form"] ?? $this->getContext($context, "form")), "step6", array()), "reference", array()), "formQuantityShortcut" =>         // line 73
($context["formQuantityShortcut"] ?? $this->getContext($context, "formQuantityShortcut")), "formPriceShortcut" => $this->getAttribute($this->getAttribute(        // line 74
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "price_shortcut", array()), "formPriceShortcutTTC" => $this->getAttribute($this->getAttribute(        // line 75
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "price_ttc_shortcut", array()), "formCategories" => $this->getAttribute(        // line 76
($context["form"] ?? $this->getContext($context, "form")), "step1", array())));
        // line 78
        echo "
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 82
    public function block_product_panel_combinations($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_combinations"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_combinations"));

        // line 83
        echo "          ";
        $context["formStockQuantity"] = (($this->getAttribute($this->getAttribute(($context["form"] ?? null), "step3", array(), "any", false, true), "qty_0", array(), "any", true, true)) ? ($this->getAttribute($this->getAttribute(($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "qty_0", array())) : (null));
        // line 84
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/combinations.html.twig", array("formDependsOnStocks" => $this->getAttribute($this->getAttribute(        // line 85
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "depends_on_stock", array()), "productId" =>         // line 86
($context["id_product"] ?? $this->getContext($context, "id_product")), "formStockQuantity" =>         // line 87
($context["formStockQuantity"] ?? $this->getContext($context, "formStockQuantity")), "formStockMinimalQuantity" => $this->getAttribute($this->getAttribute(        // line 88
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "minimal_quantity", array()), "formLowStockThreshold" => $this->getAttribute($this->getAttribute(        // line 89
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "low_stock_threshold", array()), "formLowStockAlert" => $this->getAttribute($this->getAttribute(        // line 90
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "low_stock_alert", array()), "formVirtualProduct" => $this->getAttribute($this->getAttribute(        // line 91
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "virtual_product", array()), "asm_globally_activated" =>         // line 92
($context["asm_globally_activated"] ?? $this->getContext($context, "asm_globally_activated")), "formType" => $this->getAttribute($this->getAttribute(        // line 93
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "type_product", array()), "formAdvancedStockManagement" => $this->getAttribute($this->getAttribute(        // line 94
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "advanced_stock_management", array()), "formPackStockType" => $this->getAttribute($this->getAttribute(        // line 95
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "pack_stock_type", array()), "formStep3" => $this->getAttribute(        // line 96
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "formCombinations" =>         // line 97
($context["formCombinations"] ?? $this->getContext($context, "formCombinations")), "has_combinations" =>         // line 98
($context["has_combinations"] ?? $this->getContext($context, "has_combinations")), "max_upload_size" =>         // line 99
($context["max_upload_size"] ?? $this->getContext($context, "max_upload_size"))));
        // line 101
        echo "
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 105
    public function block_product_panel_shipping($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_shipping"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_shipping"));

        // line 106
        echo "          <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step4\">
            <div class=\"row\">
              <div class=\"col-md-12\">
                <div class=\"container-fluid\">
                  <div class=\"row\">
                    ";
        // line 111
        echo twig_include($this->env, $context, "@Product/ProductPage/Forms/form_shipping.html.twig", array("form" => $this->getAttribute(        // line 112
($context["form"] ?? $this->getContext($context, "form")), "step4", array()), "asm_globally_activated" =>         // line 113
($context["asm_globally_activated"] ?? $this->getContext($context, "asm_globally_activated")), "isNotVirtual" => ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 114
($context["form"] ?? $this->getContext($context, "form")), "step1", array()), "type_product", array()), "vars", array()), "value", array()) != "2"), "isChecked" => $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 115
($context["form"] ?? $this->getContext($context, "form")), "step3", array()), "advanced_stock_management", array()), "vars", array()), "checked", array()), "warehouses" =>         // line 116
($context["warehouses"] ?? $this->getContext($context, "warehouses"))));
        // line 117
        echo "
                  </div>
                </div>
              </div>
            </div>
          </div>
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 126
    public function block_product_panel_pricing($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_pricing"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_pricing"));

        // line 127
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/pricing.html.twig", array("pricingForm" => $this->getAttribute(        // line 128
($context["form"] ?? $this->getContext($context, "form")), "step2", array()), "is_multishop_context" =>         // line 129
($context["is_multishop_context"] ?? $this->getContext($context, "is_multishop_context")), "productId" =>         // line 130
($context["id_product"] ?? $this->getContext($context, "id_product"))));
        // line 131
        echo "
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 135
    public function block_product_panel_seo($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_seo"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_seo"));

        // line 136
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/seo.html.twig", array("seoForm" => $this->getAttribute(        // line 137
($context["form"] ?? $this->getContext($context, "form")), "step5", array()), "productId" =>         // line 138
($context["id_product"] ?? $this->getContext($context, "id_product"))));
        // line 139
        echo "
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 143
    public function block_product_panel_options($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_options"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_options"));

        // line 144
        echo "          ";
        echo twig_include($this->env, $context, "@Product/ProductPage/Panels/options.html.twig", array("optionsForm" => $this->getAttribute(        // line 145
($context["form"] ?? $this->getContext($context, "form")), "step6", array()), "productId" =>         // line 146
($context["id_product"] ?? $this->getContext($context, "id_product"))));
        // line 147
        echo "
        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 151
    public function block_product_panel_modules($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_modules"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "product_panel_modules"));

        // line 152
        echo "          ";
        if (($this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->hookCount("displayAdminProductsExtra") > 0)) {
            // line 153
            echo "            <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"hooks\">
              <div class=\"row\">
                <div class=\"col-md-12\">
                  <div class=\"container-fluid\">
                    <div class=\"row\">

                      ";
            // line 160
            echo "                      <div class=\"col-md-12\">
                        ";
            // line 161
            $context["hooks"] = $this->env->getExtension('PrestaShopBundle\Twig\HookExtension')->renderHooksArray("displayAdminProductsExtra", array("id_product" => ($context["id_product"] ?? $this->getContext($context, "id_product"))));
            // line 162
            echo "
                        <div class=\"row module-selection\" style=\"display: none;\">
                          <div class=\"col-md-12 col-lg-7\">
                            ";
            // line 165
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? $this->getContext($context, "hooks")));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 166
                echo "                              <div class=\"module-render-container module-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "name", array()), "html", null, true);
                echo "\">
                                <div>
                                  <img class=\"top-logo\" src=\"";
                // line 168
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "img", array()), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "displayName", array()), "html", null, true);
                echo "\">
                                  <h2 class=\"text-ellipsis module-name-grid\">
                                    ";
                // line 170
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "displayName", array()), "html", null, true);
                echo "
                                  </h2>
                                  <div class=\"text-ellipsis small-text module-version\">
                                    ";
                // line 173
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "version", array()), "html", null, true);
                echo " by ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "author", array()), "html", null, true);
                echo "
                                  </div>
                                </div>
                                <div class=\"small no-padding\">
                                  ";
                // line 177
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "description", array()), "html", null, true);
                echo "
                                </div>
                              </div>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 181
            echo "                          </div>
                          <div class=\"col-md-12 col-lg-5\">
                            <h2>";
            // line 183
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Module to configure", array(), "Admin.Catalog.Feature"), "html", null, true);
            echo "</h2>
                            <select class=\"modules-list-select\" data-toggle=\"select2\">
                              ";
            // line 185
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? $this->getContext($context, "hooks")));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 186
                echo "                                <option value=\"module-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "name", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "displayName", array()), "html", null, true);
                echo "</option>
                              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 188
            echo "                            </select>
                          </div>
                        </div>

                        <div class=\"module-render-container all-modules\">
                          <p>
                            <h2>";
            // line 194
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Choose a module to configure", array(), "Admin.Catalog.Feature"), "html", null, true);
            echo "</h2>
                            ";
            // line 195
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("These modules are relative to the product page of your shop.", array(), "Admin.Catalog.Feature"), "html", null, true);
            echo "<br />
                            ";
            // line 196
            echo twig_replace_filter($this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("To manage all your modules go to the [1]Installed module page[/1]", array(), "Admin.Catalog.Feature"), array("[1]" => (("<a href=\"" . $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_module_manage")) . "\">"), "[/1]" => "</a>"));
            echo "
                          </p>
                          <div class=\"row\">
                            ";
            // line 199
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? $this->getContext($context, "hooks")));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 200
                echo "                              <div class=\"col-md-12 col-lg-6 col-xl-4\">
                                <div class=\"module-item-wrapper-grid\">
                                  <div class=\"module-item-heading-grid\">
                                    <img class=\"module-logo-thumb-grid\" src=\"";
                // line 203
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "img", array()), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "displayName", array()), "html", null, true);
                echo "\">
                                    <h3 class=\"text-ellipsis module-name-grid\">
                                      ";
                // line 205
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "displayName", array()), "html", null, true);
                echo "
                                    </h3>
                                    <div class=\"text-ellipsis small-text module-version-author-grid\">
                                      ";
                // line 208
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "version", array()), "html", null, true);
                echo " by ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "author", array()), "html", null, true);
                echo "
                                    </div>
                                  </div>
                                  <div class=\"module-quick-description-grid small no-padding\">
                                    ";
                // line 212
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "description", array()), "html", null, true);
                echo "
                                  </div>
                                  <div class=\"module-container\">
                                    <div class=\"module-quick-action-grid clearfix\">
                                      <button class=\"modules-list-button btn btn-outline-primary pull-xs-right\" data-target=\"module-";
                // line 216
                echo twig_escape_filter($this->env, $this->getAttribute($context["module"], "id", array()), "html", null, true);
                echo "\">
                                        ";
                // line 217
                echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Configure", array(), "Admin.Actions"), "html", null, true);
                echo "
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 224
            echo "                          </div>
                        </div>

                        ";
            // line 227
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["hooks"] ?? $this->getContext($context, "hooks")));
            foreach ($context['_seq'] as $context["_key"] => $context["module"]) {
                // line 228
                echo "                          <div
                            id=\"module_";
                // line 229
                echo twig_escape_filter($this->env, $this->getAttribute($context["module"], "id", array()), "html", null, true);
                echo "\"
                            class=\"module-render-container module-";
                // line 230
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["module"], "attributes", array()), "name", array()), "html", null, true);
                echo "\"
                            style=\"display: none;\"
                          >
                            <div>
                              ";
                // line 234
                echo $this->getAttribute($context["module"], "content", array());
                echo "
                            </div>
                          </div>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['module'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 238
            echo "                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          ";
        }
        // line 246
        echo "        ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 290
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 291
        echo "  ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
  <script src=\"";
        // line 292
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/form.js"), "html", null, true);
        echo "\"></script>

  <script src=\"";
        // line 294
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-manufacturer.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 295
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-related.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 296
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-category-tags.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 297
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/default-category.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 298
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/product/product-combinations.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 299
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/category-tree.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 300
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/module/module_card.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 301
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("themes/default/js/bundle/modal-confirmation.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 302
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/tiny_mce/tiny_mce.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 303
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/admin/tinymce.inc.js"), "html", null, true);
        echo "\"></script>
  <script src=\"";
        // line 304
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\AssetExtension')->getAssetUrl("../js/admin/tinymce_loader.js"), "html", null, true);
        echo "\"></script>

  <script>
      \$(function() {
        var editable = '";
        // line 308
        echo twig_escape_filter($this->env, ($context["editable"] ?? $this->getContext($context, "editable")), "html", null, true);
        echo "';

        if (editable !== '1'){
          \$('#field-disabled').find(\"select\").each(function() {
            \$(this).removeClass('select2-hidden-accessible');
          });
          \$('#field-disabled').find(\"span.select2\").each(function() {
            \$(this).hide();
          });
          \$('#field-disabled').find(\"a.pstaggerClosingCross\").each(function() {
            \$(this).attr(\"disabled\", \"disabled\").on(\"click\", function() {
              return false;
            });
          });
        }
      });
  </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Product/ProductPage/product.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  729 => 308,  722 => 304,  718 => 303,  714 => 302,  710 => 301,  706 => 300,  702 => 299,  698 => 298,  694 => 297,  690 => 296,  686 => 295,  682 => 294,  677 => 292,  672 => 291,  663 => 290,  653 => 246,  643 => 238,  633 => 234,  626 => 230,  622 => 229,  619 => 228,  615 => 227,  610 => 224,  597 => 217,  593 => 216,  586 => 212,  577 => 208,  571 => 205,  564 => 203,  559 => 200,  555 => 199,  549 => 196,  545 => 195,  541 => 194,  533 => 188,  522 => 186,  518 => 185,  513 => 183,  509 => 181,  499 => 177,  490 => 173,  484 => 170,  477 => 168,  471 => 166,  467 => 165,  462 => 162,  460 => 161,  457 => 160,  449 => 153,  446 => 152,  437 => 151,  426 => 147,  424 => 146,  423 => 145,  421 => 144,  412 => 143,  401 => 139,  399 => 138,  398 => 137,  396 => 136,  387 => 135,  376 => 131,  374 => 130,  373 => 129,  372 => 128,  370 => 127,  361 => 126,  345 => 117,  343 => 116,  342 => 115,  341 => 114,  340 => 113,  339 => 112,  338 => 111,  331 => 106,  322 => 105,  311 => 101,  309 => 99,  308 => 98,  307 => 97,  306 => 96,  305 => 95,  304 => 94,  303 => 93,  302 => 92,  301 => 91,  300 => 90,  299 => 89,  298 => 88,  297 => 87,  296 => 86,  295 => 85,  293 => 84,  290 => 83,  281 => 82,  270 => 78,  268 => 76,  267 => 75,  266 => 74,  265 => 73,  264 => 72,  263 => 71,  262 => 70,  261 => 69,  260 => 68,  259 => 67,  258 => 66,  257 => 65,  256 => 64,  255 => 63,  254 => 62,  252 => 61,  249 => 60,  240 => 59,  227 => 54,  218 => 53,  207 => 42,  205 => 40,  204 => 39,  203 => 38,  202 => 37,  201 => 36,  200 => 35,  198 => 34,  189 => 33,  178 => 287,  176 => 266,  171 => 263,  167 => 262,  164 => 261,  162 => 260,  161 => 259,  160 => 258,  159 => 257,  158 => 256,  157 => 255,  155 => 254,  149 => 250,  145 => 249,  141 => 247,  138 => 151,  135 => 149,  132 => 143,  129 => 141,  126 => 135,  123 => 133,  120 => 126,  117 => 124,  114 => 105,  111 => 103,  108 => 82,  105 => 80,  102 => 59,  98 => 56,  95 => 53,  87 => 47,  82 => 44,  79 => 33,  77 => 32,  73 => 31,  68 => 28,  59 => 27,  49 => 25,  47 => 350,  46 => 349,  45 => 348,  44 => 331,  42 => 329,  41 => 327,  11 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source(" {#**
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
{% extends '@PrestaShop/Admin/layout.html.twig' %}

{% block content %}

  <form name=\"form\" id=\"form\" method=\"post\" class=\"form-horizontal product-page row justify-content-md-center\" novalidate=\"novalidate\">

    {% if not editable %} <fieldset disabled id=\"field-disabled\"> {% endif %}
    {# PRODUCT HEADER #}
    {% block product_header %}
      {{ include('@Product/ProductPage/Blocks/header.html.twig', {
        'formName': form.step1.name,
        'formType': form.step1.type_product,
        'is_multishop_context': is_multishop_context,
        'languages': languages,
        'help_link': help_link,
        'stats_link': stats_link
        })
      }}
    {% endblock %}

    <div class=\"col-md-10\">
      <div id=\"form_bubbling_errors\">
        {{ form_errors(form) }}
      </div>
    </div>

    <div id=\"form-loading\" class=\"col-xxl-10\">
      {# FORM TABS CONTAINER #}
      {% block product_tabs_container %}
        {{ include('@Product/ProductPage/Blocks/tabs.html.twig') }}
      {% endblock %}
      <div id=\"form_content\" class=\"tab-content\">

        {# PANEL ESSENTIALS #}
        {% block product_panel_essentials %}
          {% set formQuantityShortcut = form.step1.qty_0_shortcut is defined ? form.step1.qty_0_shortcut : null  %}
          {{ include('@Product/ProductPage/Panels/essentials.html.twig', {
              'formPackItems': form.step1.inputPackItems,
              'productId': id_product,
              'images': form.step1.vars.value.images,
              'formShortDescription': form.step1.description_short,
              'formDescription': form.step1.description,
              'formFeatures': form.step1.features,
              'formManufacturer': form.step1.id_manufacturer,
              'formRelatedProducts': form.step1.related_products,
              'is_combination_active': is_combination_active,
              'has_combinations': has_combinations,
              'formReference': form.step6.reference,
              'formQuantityShortcut': formQuantityShortcut,
              'formPriceShortcut': form.step1.price_shortcut,
              'formPriceShortcutTTC': form.step1.price_ttc_shortcut,
              'formCategories': form.step1,
            })
          }}
        {% endblock %}

        {# PANEL COMBINATIONS #}
        {% block product_panel_combinations %}
          {% set formStockQuantity = form.step3.qty_0 is defined ? form.step3.qty_0 : null  %}
          {{ include('@Product/ProductPage/Panels/combinations.html.twig', {
              'formDependsOnStocks': form.step3.depends_on_stock,
              'productId': id_product,
              'formStockQuantity': formStockQuantity,
              'formStockMinimalQuantity': form.step3.minimal_quantity,
              'formLowStockThreshold': form.step3.low_stock_threshold,
              'formLowStockAlert': form.step3.low_stock_alert,
              'formVirtualProduct': form.step3.virtual_product,
              'asm_globally_activated': asm_globally_activated,
              'formType': form.step1.type_product,
              'formAdvancedStockManagement': form.step3.advanced_stock_management,
              'formPackStockType': form.step3.pack_stock_type,
              'formStep3': form.step3,
              'formCombinations': formCombinations,
              'has_combinations': has_combinations,
              'max_upload_size': max_upload_size
            })
          }}
        {% endblock %}

        {# PANEL SHIPPING #}
        {% block product_panel_shipping %}
          <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step4\">
            <div class=\"row\">
              <div class=\"col-md-12\">
                <div class=\"container-fluid\">
                  <div class=\"row\">
                    {{ include('@Product/ProductPage/Forms/form_shipping.html.twig', {
                      'form' : form.step4,
                      'asm_globally_activated': asm_globally_activated,
                      'isNotVirtual': form.step1.type_product.vars.value != \"2\",
                      'isChecked': form.step3.advanced_stock_management.vars.checked,
                      'warehouses': warehouses
                    }) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        {% endblock %}

        {# PANEL PRICING #}
        {% block product_panel_pricing %}
          {{ include('@Product/ProductPage/Panels/pricing.html.twig', {
            'pricingForm': form.step2,
            'is_multishop_context': is_multishop_context,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL SEO #}
        {% block product_panel_seo %}
          {{ include('@Product/ProductPage/Panels/seo.html.twig', {
            'seoForm': form.step5,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL OPTIONS #}
        {% block product_panel_options %}
          {{ include('@Product/ProductPage/Panels/options.html.twig', {
            'optionsForm': form.step6,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL HOOKED MODULES #}
        {% block product_panel_modules %}
          {% if hookcount('displayAdminProductsExtra') > 0 %}
            <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"hooks\">
              <div class=\"row\">
                <div class=\"col-md-12\">
                  <div class=\"container-fluid\">
                    <div class=\"row\">

                      {# LEFT #}
                      <div class=\"col-md-12\">
                        {% set hooks = renderhooksarray('displayAdminProductsExtra', { 'id_product': id_product }) %}

                        <div class=\"row module-selection\" style=\"display: none;\">
                          <div class=\"col-md-12 col-lg-7\">
                            {% for module in hooks %}
                              <div class=\"module-render-container module-{{ module.attributes.name }}\">
                                <div>
                                  <img class=\"top-logo\" src=\"{{ module.attributes.img }}\" alt=\"{{ module.attributes.displayName }}\">
                                  <h2 class=\"text-ellipsis module-name-grid\">
                                    {{ module.attributes.displayName }}
                                  </h2>
                                  <div class=\"text-ellipsis small-text module-version\">
                                    {{ module.attributes.version }} by {{ module.attributes.author }}
                                  </div>
                                </div>
                                <div class=\"small no-padding\">
                                  {{ module.attributes.description }}
                                </div>
                              </div>
                            {% endfor %}
                          </div>
                          <div class=\"col-md-12 col-lg-5\">
                            <h2>{{ 'Module to configure'|trans({}, 'Admin.Catalog.Feature') }}</h2>
                            <select class=\"modules-list-select\" data-toggle=\"select2\">
                              {% for module in hooks %}
                                <option value=\"module-{{ module.attributes.name }}\">{{ module.attributes.displayName }}</option>
                              {% endfor %}
                            </select>
                          </div>
                        </div>

                        <div class=\"module-render-container all-modules\">
                          <p>
                            <h2>{{ 'Choose a module to configure'|trans({}, 'Admin.Catalog.Feature') }}</h2>
                            {{ 'These modules are relative to the product page of your shop.'|trans({}, 'Admin.Catalog.Feature') }}<br />
                            {{ 'To manage all your modules go to the [1]Installed module page[/1]'|trans({}, 'Admin.Catalog.Feature')|replace({'[1]': '<a href=\"' ~ path(\"admin_module_manage\") ~ '\">', '[/1]': '</a>'})|raw }}
                          </p>
                          <div class=\"row\">
                            {% for module in hooks %}
                              <div class=\"col-md-12 col-lg-6 col-xl-4\">
                                <div class=\"module-item-wrapper-grid\">
                                  <div class=\"module-item-heading-grid\">
                                    <img class=\"module-logo-thumb-grid\" src=\"{{ module.attributes.img }}\" alt=\"{{ module.attributes.displayName }}\">
                                    <h3 class=\"text-ellipsis module-name-grid\">
                                      {{ module.attributes.displayName }}
                                    </h3>
                                    <div class=\"text-ellipsis small-text module-version-author-grid\">
                                      {{ module.attributes.version }} by {{ module.attributes.author }}
                                    </div>
                                  </div>
                                  <div class=\"module-quick-description-grid small no-padding\">
                                    {{ module.attributes.description }}
                                  </div>
                                  <div class=\"module-container\">
                                    <div class=\"module-quick-action-grid clearfix\">
                                      <button class=\"modules-list-button btn btn-outline-primary pull-xs-right\" data-target=\"module-{{ module.id }}\">
                                        {{ 'Configure'|trans({}, 'Admin.Actions') }}
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            {% endfor %}
                          </div>
                        </div>

                        {% for module in hooks %}
                          <div
                            id=\"module_{{ module.id }}\"
                            class=\"module-render-container module-{{ module.attributes.name }}\"
                            style=\"display: none;\"
                          >
                            <div>
                              {{ module.content|raw }}
                            </div>
                          </div>
                        {% endfor %}
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          {% endif %}
        {% endblock %}
      </div>

      {{ form_widget(form.id_product) }}
      {{ form_widget(form._token) }}

    </div>
    {# FOOTER #}
    {{ include('@Product/ProductPage/Blocks/footer.html.twig', {
      'preview_link': preview_link,
      'preview_link_deactivate': preview_link_deactivate,
      'is_shop_context': is_shop_context,
      'editable': editable,
      'is_active': form.step1.vars.value.active,
      'productId': id_product
    }) }}
    {% if not editable %} </fieldset> {% endif %}
  </form>


  {% embed 'PrestaShopBundle:Admin/Helpers:bootstrap_popup.html.twig' with {
    'id': 'confirmation_modal',
    'title': \"Warning\"|trans({}, 'Admin.Notifications.Warning'),
    'closable': false,
    'actions': [
      {
        'type': 'button',
        'label': \"No\"|trans({}, 'Admin.Global'),
        'class': 'btn btn-outline-secondary btn-lg cancel'
      },
      {
        'type': 'button',
        'label': \"Yes\"|trans({}, 'Admin.Global'),
        'class': 'btn btn-primary btn-lg continue'
      }
    ],
  } %}
    {% block content %}
      <div class=\"modal-body\"></div>
    {% endblock %}
  {% endembed %}

{% endblock %}

{% block javascripts %}
  {{ parent() }}
  <script src=\"{{ asset('themes/default/js/bundle/product/form.js') }}\"></script>

  <script src=\"{{ asset('themes/default/js/bundle/product/product-manufacturer.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-related.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-category-tags.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/default-category.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-combinations.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/category-tree.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/module/module_card.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/modal-confirmation.js') }}\"></script>
  <script src=\"{{ asset('../js/tiny_mce/tiny_mce.js') }}\"></script>
  <script src=\"{{ asset('../js/admin/tinymce.inc.js') }}\"></script>
  <script src=\"{{ asset('../js/admin/tinymce_loader.js') }}\"></script>

  <script>
      \$(function() {
        var editable = '{{ editable }}';

        if (editable !== '1'){
          \$('#field-disabled').find(\"select\").each(function() {
            \$(this).removeClass('select2-hidden-accessible');
          });
          \$('#field-disabled').find(\"span.select2\").each(function() {
            \$(this).hide();
          });
          \$('#field-disabled').find(\"a.pstaggerClosingCross\").each(function() {
            \$(this).attr(\"disabled\", \"disabled\").on(\"click\", function() {
              return false;
            });
          });
        }
      });
  </script>
{% endblock %}

{% set js_translatable = {
\"Are you sure to disable variations ? they will all be deleted\": \"This will delete all the combinations. Do you wish to proceed?\"|trans({}, 'Admin.Catalog.Notification'),
}|merge(js_translatable) %}

{% set js_translatable = {
\"Form update success\": \"Settings updated.\"|trans({}, 'Admin.Notifications.Success'),
\"Form update errors\": \"Unable to update settings.\"|trans({}, 'Admin.Notifications.Error'),
\"Delete\": \"Delete\"|trans({}, 'Admin.Actions'),
\"ToLargeFile\": \"The file is too large. Maximum size allowed is: [1]. The file you are trying to upload is [2].\"|trans({}, 'Admin.Notifications.Error')|replace({ '[1]': '{{maxFilesize}}', '[2]': '{{filesize}}' }),
\"Drop images here\": \"Drop images here\"|trans({}, 'Admin.Catalog.Feature'),
\"or select files\": \"or select files\"|trans({}, 'Admin.Catalog.Feature'),
\"files recommandations\": \"Recommended size 800 x 800px for default theme.\"|trans({}, 'Admin.Catalog.Feature'),
\"files recommandations2\": \"JPG, GIF or PNG format.\"|trans({}, 'Admin.Catalog.Feature'),
\"Cover\": \"Cover\"|trans({}, 'Admin.Catalog.Feature'),
\"Are you sure to delete this?\": \"Are you sure to delete this?\"|trans({}, 'Admin.Notifications.Warning'),
\"This will delete the specific price. Do you wish to proceed?\": \"This will delete the specific price. Do you wish to proceed?\"|trans({}, 'Admin.Catalog.Notification'),
\"Quantities\": \"Quantities\"|trans({}, 'Admin.Catalog.Feature'),
\"Combinations\": \"Combinations\"|trans({}, 'Admin.Catalog.Feature'),
\"Virtual product\": \"Virtual product\"|trans({}, 'Admin.Catalog.Feature'),
\"tax incl.\": \"tax incl.\"|trans({}, 'Admin.Catalog.Feature'),
\"tax excl.\": \"tax excl.\"|trans({}, 'Admin.Catalog.Feature'),
\"You can't create pack product with variations. Are you sure to disable variations ? they will all be deleted.\": \"A pack of products can't have combinations.\"|trans({}, \"Admin.Catalog.Notification\") ~ ' ' ~ js_translatable['Are you sure to disable variations ? they will all be deleted'],
\"You can't create virtual product with variations. Are you sure to disable variations ? they will all be deleted.\": \"A virtual product can't have combinations.\"|trans({}, \"Admin.Catalog.Notification\") ~ ' ' ~ js_translatable['Are you sure to disable variations ? they will all be deleted'],
}|merge(js_translatable) %}
", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Product\\ProductPage\\product.html.twig");
    }
}


/* @PrestaShop/Admin/Product/ProductPage/product.html.twig */
class __TwigTemplate_900f408fb8c3468434a296f1f9485bd5b007b5aab1bb09eecf8857709dba5698_1805355240 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 266
        $this->parent = $this->loadTemplate("PrestaShopBundle:Admin/Helpers:bootstrap_popup.html.twig", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", 266);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "PrestaShopBundle:Admin/Helpers:bootstrap_popup.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Product/ProductPage/product.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@PrestaShop/Admin/Product/ProductPage/product.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 283
    public function block_content($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 284
        echo "      <div class=\"modal-body\"></div>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Product/ProductPage/product.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1182 => 284,  1173 => 283,  1144 => 266,  729 => 308,  722 => 304,  718 => 303,  714 => 302,  710 => 301,  706 => 300,  702 => 299,  698 => 298,  694 => 297,  690 => 296,  686 => 295,  682 => 294,  677 => 292,  672 => 291,  663 => 290,  653 => 246,  643 => 238,  633 => 234,  626 => 230,  622 => 229,  619 => 228,  615 => 227,  610 => 224,  597 => 217,  593 => 216,  586 => 212,  577 => 208,  571 => 205,  564 => 203,  559 => 200,  555 => 199,  549 => 196,  545 => 195,  541 => 194,  533 => 188,  522 => 186,  518 => 185,  513 => 183,  509 => 181,  499 => 177,  490 => 173,  484 => 170,  477 => 168,  471 => 166,  467 => 165,  462 => 162,  460 => 161,  457 => 160,  449 => 153,  446 => 152,  437 => 151,  426 => 147,  424 => 146,  423 => 145,  421 => 144,  412 => 143,  401 => 139,  399 => 138,  398 => 137,  396 => 136,  387 => 135,  376 => 131,  374 => 130,  373 => 129,  372 => 128,  370 => 127,  361 => 126,  345 => 117,  343 => 116,  342 => 115,  341 => 114,  340 => 113,  339 => 112,  338 => 111,  331 => 106,  322 => 105,  311 => 101,  309 => 99,  308 => 98,  307 => 97,  306 => 96,  305 => 95,  304 => 94,  303 => 93,  302 => 92,  301 => 91,  300 => 90,  299 => 89,  298 => 88,  297 => 87,  296 => 86,  295 => 85,  293 => 84,  290 => 83,  281 => 82,  270 => 78,  268 => 76,  267 => 75,  266 => 74,  265 => 73,  264 => 72,  263 => 71,  262 => 70,  261 => 69,  260 => 68,  259 => 67,  258 => 66,  257 => 65,  256 => 64,  255 => 63,  254 => 62,  252 => 61,  249 => 60,  240 => 59,  227 => 54,  218 => 53,  207 => 42,  205 => 40,  204 => 39,  203 => 38,  202 => 37,  201 => 36,  200 => 35,  198 => 34,  189 => 33,  178 => 287,  176 => 266,  171 => 263,  167 => 262,  164 => 261,  162 => 260,  161 => 259,  160 => 258,  159 => 257,  158 => 256,  157 => 255,  155 => 254,  149 => 250,  145 => 249,  141 => 247,  138 => 151,  135 => 149,  132 => 143,  129 => 141,  126 => 135,  123 => 133,  120 => 126,  117 => 124,  114 => 105,  111 => 103,  108 => 82,  105 => 80,  102 => 59,  98 => 56,  95 => 53,  87 => 47,  82 => 44,  79 => 33,  77 => 32,  73 => 31,  68 => 28,  59 => 27,  49 => 25,  47 => 350,  46 => 349,  45 => 348,  44 => 331,  42 => 329,  41 => 327,  11 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source(" {#**
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
{% extends '@PrestaShop/Admin/layout.html.twig' %}

{% block content %}

  <form name=\"form\" id=\"form\" method=\"post\" class=\"form-horizontal product-page row justify-content-md-center\" novalidate=\"novalidate\">

    {% if not editable %} <fieldset disabled id=\"field-disabled\"> {% endif %}
    {# PRODUCT HEADER #}
    {% block product_header %}
      {{ include('@Product/ProductPage/Blocks/header.html.twig', {
        'formName': form.step1.name,
        'formType': form.step1.type_product,
        'is_multishop_context': is_multishop_context,
        'languages': languages,
        'help_link': help_link,
        'stats_link': stats_link
        })
      }}
    {% endblock %}

    <div class=\"col-md-10\">
      <div id=\"form_bubbling_errors\">
        {{ form_errors(form) }}
      </div>
    </div>

    <div id=\"form-loading\" class=\"col-xxl-10\">
      {# FORM TABS CONTAINER #}
      {% block product_tabs_container %}
        {{ include('@Product/ProductPage/Blocks/tabs.html.twig') }}
      {% endblock %}
      <div id=\"form_content\" class=\"tab-content\">

        {# PANEL ESSENTIALS #}
        {% block product_panel_essentials %}
          {% set formQuantityShortcut = form.step1.qty_0_shortcut is defined ? form.step1.qty_0_shortcut : null  %}
          {{ include('@Product/ProductPage/Panels/essentials.html.twig', {
              'formPackItems': form.step1.inputPackItems,
              'productId': id_product,
              'images': form.step1.vars.value.images,
              'formShortDescription': form.step1.description_short,
              'formDescription': form.step1.description,
              'formFeatures': form.step1.features,
              'formManufacturer': form.step1.id_manufacturer,
              'formRelatedProducts': form.step1.related_products,
              'is_combination_active': is_combination_active,
              'has_combinations': has_combinations,
              'formReference': form.step6.reference,
              'formQuantityShortcut': formQuantityShortcut,
              'formPriceShortcut': form.step1.price_shortcut,
              'formPriceShortcutTTC': form.step1.price_ttc_shortcut,
              'formCategories': form.step1,
            })
          }}
        {% endblock %}

        {# PANEL COMBINATIONS #}
        {% block product_panel_combinations %}
          {% set formStockQuantity = form.step3.qty_0 is defined ? form.step3.qty_0 : null  %}
          {{ include('@Product/ProductPage/Panels/combinations.html.twig', {
              'formDependsOnStocks': form.step3.depends_on_stock,
              'productId': id_product,
              'formStockQuantity': formStockQuantity,
              'formStockMinimalQuantity': form.step3.minimal_quantity,
              'formLowStockThreshold': form.step3.low_stock_threshold,
              'formLowStockAlert': form.step3.low_stock_alert,
              'formVirtualProduct': form.step3.virtual_product,
              'asm_globally_activated': asm_globally_activated,
              'formType': form.step1.type_product,
              'formAdvancedStockManagement': form.step3.advanced_stock_management,
              'formPackStockType': form.step3.pack_stock_type,
              'formStep3': form.step3,
              'formCombinations': formCombinations,
              'has_combinations': has_combinations,
              'max_upload_size': max_upload_size
            })
          }}
        {% endblock %}

        {# PANEL SHIPPING #}
        {% block product_panel_shipping %}
          <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"step4\">
            <div class=\"row\">
              <div class=\"col-md-12\">
                <div class=\"container-fluid\">
                  <div class=\"row\">
                    {{ include('@Product/ProductPage/Forms/form_shipping.html.twig', {
                      'form' : form.step4,
                      'asm_globally_activated': asm_globally_activated,
                      'isNotVirtual': form.step1.type_product.vars.value != \"2\",
                      'isChecked': form.step3.advanced_stock_management.vars.checked,
                      'warehouses': warehouses
                    }) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        {% endblock %}

        {# PANEL PRICING #}
        {% block product_panel_pricing %}
          {{ include('@Product/ProductPage/Panels/pricing.html.twig', {
            'pricingForm': form.step2,
            'is_multishop_context': is_multishop_context,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL SEO #}
        {% block product_panel_seo %}
          {{ include('@Product/ProductPage/Panels/seo.html.twig', {
            'seoForm': form.step5,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL OPTIONS #}
        {% block product_panel_options %}
          {{ include('@Product/ProductPage/Panels/options.html.twig', {
            'optionsForm': form.step6,
            'productId': id_product
          }) }}
        {% endblock %}

        {# PANEL HOOKED MODULES #}
        {% block product_panel_modules %}
          {% if hookcount('displayAdminProductsExtra') > 0 %}
            <div role=\"tabpanel\" class=\"form-contenttab tab-pane\" id=\"hooks\">
              <div class=\"row\">
                <div class=\"col-md-12\">
                  <div class=\"container-fluid\">
                    <div class=\"row\">

                      {# LEFT #}
                      <div class=\"col-md-12\">
                        {% set hooks = renderhooksarray('displayAdminProductsExtra', { 'id_product': id_product }) %}

                        <div class=\"row module-selection\" style=\"display: none;\">
                          <div class=\"col-md-12 col-lg-7\">
                            {% for module in hooks %}
                              <div class=\"module-render-container module-{{ module.attributes.name }}\">
                                <div>
                                  <img class=\"top-logo\" src=\"{{ module.attributes.img }}\" alt=\"{{ module.attributes.displayName }}\">
                                  <h2 class=\"text-ellipsis module-name-grid\">
                                    {{ module.attributes.displayName }}
                                  </h2>
                                  <div class=\"text-ellipsis small-text module-version\">
                                    {{ module.attributes.version }} by {{ module.attributes.author }}
                                  </div>
                                </div>
                                <div class=\"small no-padding\">
                                  {{ module.attributes.description }}
                                </div>
                              </div>
                            {% endfor %}
                          </div>
                          <div class=\"col-md-12 col-lg-5\">
                            <h2>{{ 'Module to configure'|trans({}, 'Admin.Catalog.Feature') }}</h2>
                            <select class=\"modules-list-select\" data-toggle=\"select2\">
                              {% for module in hooks %}
                                <option value=\"module-{{ module.attributes.name }}\">{{ module.attributes.displayName }}</option>
                              {% endfor %}
                            </select>
                          </div>
                        </div>

                        <div class=\"module-render-container all-modules\">
                          <p>
                            <h2>{{ 'Choose a module to configure'|trans({}, 'Admin.Catalog.Feature') }}</h2>
                            {{ 'These modules are relative to the product page of your shop.'|trans({}, 'Admin.Catalog.Feature') }}<br />
                            {{ 'To manage all your modules go to the [1]Installed module page[/1]'|trans({}, 'Admin.Catalog.Feature')|replace({'[1]': '<a href=\"' ~ path(\"admin_module_manage\") ~ '\">', '[/1]': '</a>'})|raw }}
                          </p>
                          <div class=\"row\">
                            {% for module in hooks %}
                              <div class=\"col-md-12 col-lg-6 col-xl-4\">
                                <div class=\"module-item-wrapper-grid\">
                                  <div class=\"module-item-heading-grid\">
                                    <img class=\"module-logo-thumb-grid\" src=\"{{ module.attributes.img }}\" alt=\"{{ module.attributes.displayName }}\">
                                    <h3 class=\"text-ellipsis module-name-grid\">
                                      {{ module.attributes.displayName }}
                                    </h3>
                                    <div class=\"text-ellipsis small-text module-version-author-grid\">
                                      {{ module.attributes.version }} by {{ module.attributes.author }}
                                    </div>
                                  </div>
                                  <div class=\"module-quick-description-grid small no-padding\">
                                    {{ module.attributes.description }}
                                  </div>
                                  <div class=\"module-container\">
                                    <div class=\"module-quick-action-grid clearfix\">
                                      <button class=\"modules-list-button btn btn-outline-primary pull-xs-right\" data-target=\"module-{{ module.id }}\">
                                        {{ 'Configure'|trans({}, 'Admin.Actions') }}
                                      </button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            {% endfor %}
                          </div>
                        </div>

                        {% for module in hooks %}
                          <div
                            id=\"module_{{ module.id }}\"
                            class=\"module-render-container module-{{ module.attributes.name }}\"
                            style=\"display: none;\"
                          >
                            <div>
                              {{ module.content|raw }}
                            </div>
                          </div>
                        {% endfor %}
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          {% endif %}
        {% endblock %}
      </div>

      {{ form_widget(form.id_product) }}
      {{ form_widget(form._token) }}

    </div>
    {# FOOTER #}
    {{ include('@Product/ProductPage/Blocks/footer.html.twig', {
      'preview_link': preview_link,
      'preview_link_deactivate': preview_link_deactivate,
      'is_shop_context': is_shop_context,
      'editable': editable,
      'is_active': form.step1.vars.value.active,
      'productId': id_product
    }) }}
    {% if not editable %} </fieldset> {% endif %}
  </form>


  {% embed 'PrestaShopBundle:Admin/Helpers:bootstrap_popup.html.twig' with {
    'id': 'confirmation_modal',
    'title': \"Warning\"|trans({}, 'Admin.Notifications.Warning'),
    'closable': false,
    'actions': [
      {
        'type': 'button',
        'label': \"No\"|trans({}, 'Admin.Global'),
        'class': 'btn btn-outline-secondary btn-lg cancel'
      },
      {
        'type': 'button',
        'label': \"Yes\"|trans({}, 'Admin.Global'),
        'class': 'btn btn-primary btn-lg continue'
      }
    ],
  } %}
    {% block content %}
      <div class=\"modal-body\"></div>
    {% endblock %}
  {% endembed %}

{% endblock %}

{% block javascripts %}
  {{ parent() }}
  <script src=\"{{ asset('themes/default/js/bundle/product/form.js') }}\"></script>

  <script src=\"{{ asset('themes/default/js/bundle/product/product-manufacturer.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-related.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-category-tags.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/default-category.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/product/product-combinations.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/category-tree.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/module/module_card.js') }}\"></script>
  <script src=\"{{ asset('themes/default/js/bundle/modal-confirmation.js') }}\"></script>
  <script src=\"{{ asset('../js/tiny_mce/tiny_mce.js') }}\"></script>
  <script src=\"{{ asset('../js/admin/tinymce.inc.js') }}\"></script>
  <script src=\"{{ asset('../js/admin/tinymce_loader.js') }}\"></script>

  <script>
      \$(function() {
        var editable = '{{ editable }}';

        if (editable !== '1'){
          \$('#field-disabled').find(\"select\").each(function() {
            \$(this).removeClass('select2-hidden-accessible');
          });
          \$('#field-disabled').find(\"span.select2\").each(function() {
            \$(this).hide();
          });
          \$('#field-disabled').find(\"a.pstaggerClosingCross\").each(function() {
            \$(this).attr(\"disabled\", \"disabled\").on(\"click\", function() {
              return false;
            });
          });
        }
      });
  </script>
{% endblock %}

{% set js_translatable = {
\"Are you sure to disable variations ? they will all be deleted\": \"This will delete all the combinations. Do you wish to proceed?\"|trans({}, 'Admin.Catalog.Notification'),
}|merge(js_translatable) %}

{% set js_translatable = {
\"Form update success\": \"Settings updated.\"|trans({}, 'Admin.Notifications.Success'),
\"Form update errors\": \"Unable to update settings.\"|trans({}, 'Admin.Notifications.Error'),
\"Delete\": \"Delete\"|trans({}, 'Admin.Actions'),
\"ToLargeFile\": \"The file is too large. Maximum size allowed is: [1]. The file you are trying to upload is [2].\"|trans({}, 'Admin.Notifications.Error')|replace({ '[1]': '{{maxFilesize}}', '[2]': '{{filesize}}' }),
\"Drop images here\": \"Drop images here\"|trans({}, 'Admin.Catalog.Feature'),
\"or select files\": \"or select files\"|trans({}, 'Admin.Catalog.Feature'),
\"files recommandations\": \"Recommended size 800 x 800px for default theme.\"|trans({}, 'Admin.Catalog.Feature'),
\"files recommandations2\": \"JPG, GIF or PNG format.\"|trans({}, 'Admin.Catalog.Feature'),
\"Cover\": \"Cover\"|trans({}, 'Admin.Catalog.Feature'),
\"Are you sure to delete this?\": \"Are you sure to delete this?\"|trans({}, 'Admin.Notifications.Warning'),
\"This will delete the specific price. Do you wish to proceed?\": \"This will delete the specific price. Do you wish to proceed?\"|trans({}, 'Admin.Catalog.Notification'),
\"Quantities\": \"Quantities\"|trans({}, 'Admin.Catalog.Feature'),
\"Combinations\": \"Combinations\"|trans({}, 'Admin.Catalog.Feature'),
\"Virtual product\": \"Virtual product\"|trans({}, 'Admin.Catalog.Feature'),
\"tax incl.\": \"tax incl.\"|trans({}, 'Admin.Catalog.Feature'),
\"tax excl.\": \"tax excl.\"|trans({}, 'Admin.Catalog.Feature'),
\"You can't create pack product with variations. Are you sure to disable variations ? they will all be deleted.\": \"A pack of products can't have combinations.\"|trans({}, \"Admin.Catalog.Notification\") ~ ' ' ~ js_translatable['Are you sure to disable variations ? they will all be deleted'],
\"You can't create virtual product with variations. Are you sure to disable variations ? they will all be deleted.\": \"A virtual product can't have combinations.\"|trans({}, \"Admin.Catalog.Notification\") ~ ' ' ~ js_translatable['Are you sure to disable variations ? they will all be deleted'],
}|merge(js_translatable) %}
", "@PrestaShop/Admin/Product/ProductPage/product.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Product\\ProductPage\\product.html.twig");
    }
}
