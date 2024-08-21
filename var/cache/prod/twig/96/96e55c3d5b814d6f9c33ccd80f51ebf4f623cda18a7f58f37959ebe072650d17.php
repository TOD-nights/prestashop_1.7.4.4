<?php

/* @PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_file_history.html.twig */
class __TwigTemplate_75fa93d5dba6f2096fc3a3ee45d81ae788f5e2ab16e225266a878aee88831a20 extends Twig_Template
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
<div class=\"card d-none js-files-history-block\">
    <div class=\"card-header\">
        ";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("History of uploaded files", array(), "Admin.Advparameters.Feature"), "html", null, true);
        echo "
        <span class=\"badge badge-primary js-files-history-number\">";
        // line 31
        echo twig_escape_filter($this->env, twig_length_filter($this->env, ($context["importFileNames"] ?? null)), "html", null, true);
        echo "</span>
        <a href=\"#\" class=\"close js-close-files-history-block-btn\" aria-label=\"Close\">
            <span aria-hidden=\"true\">&times;</span>
        </a>
    </div>
    <div class=\"card-content\">
        <table id=\"fileHistoryTable\"
               class=\"table mb-0\"
               data-delete-file-url=\"";
        // line 39
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_import_file_delete");
        echo "\"
               data-download-file-url=\"";
        // line 40
        echo $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_import_file_download");
        echo "\"
        >
            <tbody>
                <tr class=\"d-none\">
                    <td></td>
                    <td>
                        <div class=\"btn-group float-right\" data-file=\"\">
                            <button type=\"button\" class=\"btn btn-sm btn-outline-secondary js-use-file-btn\">
                                ";
        // line 48
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Use", array(), "Admin.Actions"), "html", null, true);
        echo "
                            </button>
                            <button type=\"button\"
                                    class=\"btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split\"
                                    data-toggle=\"dropdown\"
                                    aria-haspopup=\"true\"
                                    aria-expanded=\"false\"
                            >
                                <span class=\"sr-only\">";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Toggle Dropdown", array(), "Admin.Modules.Feature"), "html", null, true);
        echo "</span>
                            </button>
                            <div class=\"dropdown-menu menu-sm\">
                                <a href=\"#\" class=\"dropdown-item js-download-file-btn\" target=\"_blank\">
                                    <i class=\"material-icons\">file_download</i>
                                    ";
        // line 61
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Download", array(), "Admin.Advparameters.Feature"), "html", null, true);
        echo "
                                </a>
                                <div class=\"dropdown-divider\"></div>
                                <a href=\"#\" class=\"dropdown-item js-delete-file-btn\">
                                    <i class=\"material-icons\">delete</i>
                                    ";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete", array(), "Admin.Actions"), "html", null, true);
        echo "
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                ";
        // line 72
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["importFileNames"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["fileName"]) {
            // line 73
            echo "                <tr>
                    <td>";
            // line 74
            echo twig_escape_filter($this->env, $context["fileName"], "html", null, true);
            echo "</td>
                    <td>
                        <div class=\"btn-group float-right\" data-file=\"";
            // line 76
            echo twig_escape_filter($this->env, $context["fileName"], "html", null, true);
            echo "\">
                            <button type=\"button\" class=\"btn btn-sm btn-outline-secondary js-use-file-btn\">
                                ";
            // line 78
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Use", array(), "Admin.Actions"), "html", null, true);
            echo "
                            </button>
                            <button type=\"button\"
                                    class=\"btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split\"
                                    data-toggle=\"dropdown\"
                                    aria-haspopup=\"true\"
                                    aria-expanded=\"false\"
                            >
                                <span class=\"sr-only\">";
            // line 86
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Toggle Dropdown", array(), "Admin.Modules.Feature"), "html", null, true);
            echo "</span>
                            </button>
                            <div class=\"dropdown-menu menu-sm\">
                                <a href=\"";
            // line 89
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_import_file_download", array("filename" => $context["fileName"])), "html", null, true);
            echo "\" class=\"dropdown-item\" target=\"_blank\">
                                    <i class=\"material-icons\">file_download</i>
                                    ";
            // line 91
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Download", array(), "Admin.Advparameters.Feature"), "html", null, true);
            echo "
                                </a>
                                <div class=\"dropdown-divider\"></div>
                                <a href=\"";
            // line 94
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\RoutingExtension')->getPath("admin_import_file_delete", array("filename" => $context["fileName"])), "html", null, true);
            echo "\" class=\"dropdown-item\">
                                    <i class=\"material-icons\">delete</i>
                                    ";
            // line 96
            echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bridge\Twig\Extension\TranslationExtension')->trans("Delete", array(), "Admin.Actions"), "html", null, true);
            echo "
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['fileName'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 103
        echo "            </tbody>
        </table>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_file_history.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  156 => 103,  143 => 96,  138 => 94,  132 => 91,  127 => 89,  121 => 86,  110 => 78,  105 => 76,  100 => 74,  97 => 73,  93 => 72,  84 => 66,  76 => 61,  68 => 56,  57 => 48,  46 => 40,  42 => 39,  31 => 31,  27 => 30,  22 => 27,  19 => 25,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@PrestaShop/Admin/Configure/AdvancedParameters/Blocks/import_file_history.html.twig", "C:\\xampp\\htdocs\\prestashop_1.7.4.4\\src\\PrestaShopBundle\\Resources\\views\\Admin\\Configure\\AdvancedParameters\\Blocks\\import_file_history.html.twig");
    }
}
