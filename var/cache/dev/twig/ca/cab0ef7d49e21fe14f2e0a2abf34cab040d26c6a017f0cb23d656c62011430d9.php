<?php

/* __string_template__0916e18772b3bb1571b3b552b0713332ced630fb7ed67907f9c738e5f68f7642 */
class __TwigTemplate_5b6df57683507c9ede2b8c178391190b5ae6436d7b265f3ac6fcc441094718a7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'extra_stylesheets' => array($this, 'block_extra_stylesheets'),
            'content_header' => array($this, 'block_content_header'),
            'content' => array($this, 'block_content'),
            'content_footer' => array($this, 'block_content_footer'),
            'sidebar_right' => array($this, 'block_sidebar_right'),
            'javascripts' => array($this, 'block_javascripts'),
            'extra_javascripts' => array($this, 'block_extra_javascripts'),
            'translate_javascripts' => array($this, 'block_translate_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "__string_template__0916e18772b3bb1571b3b552b0713332ced630fb7ed67907f9c738e5f68f7642"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "__string_template__0916e18772b3bb1571b3b552b0713332ced630fb7ed67907f9c738e5f68f7642"));

        // line 1
        echo "<!DOCTYPE html>
<html lang=\"it\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.75, maximum-scale=0.75, user-scalable=0\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>Prodotto • eurocka</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminProducts';
    var iso_user = 'it';
    var lang_is_rtl = '0';
    var full_language_code = 'it';
    var full_cldr_language_code = 'it-IT';
    var country_iso_code = 'IT';
    var _PS_VERSION_ = '1.7.4.4';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'È stato effettuato un nuovo ordine nel tuo negozio.';
    var order_number_msg = 'Numero dell\\\\\\'ordine: ';
    var total_msg = 'Totale: ';
    var from_msg = 'Da: ';
    var see_order_msg = 'Vedi quest\\\\\\'ordine';
    var new_customer_msg = 'Un nuovo cliente si è registrato nel tuo negozio.';
    var customer_name_msg = 'Nome cliente: ';
    var new_msg = 'Al tuo negozio è stato inviato un nuovo messaggio.';
    var see_msg = 'Leggi questo messaggio';
    var token = '80fe46524be30b87329eab55b867f3c9';
    var token_admin_orders = 'd421f192adafc9b7dca158866e05efcf';
    var token_admin_customers = '98dccc1ac7cabc66c1461858b5f9f558';
    var token_admin_customer_threads = 'bd0735ee32da605366c82b47b15e489a';
    var currentIndex = 'index.php?controller=AdminProducts';
    var employee_token = '0ee14fbcc20066abcc37470f72881b64';
    var choose_language_translate = 'Scegli lingua';
    var default_language = '2';
    var admin_modules_link = '/admin78257ysim/index.php/module/catalog/recommended?route=admin_module_catalog_post&_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc';
    var tab_modules_list = 'storecommanderps,onlive,viqeo,ndk_advanced_custom_fields,pm_advancedpack,cdesigner,ultimateimagetool';
    var update_success_msg = 'Aggiornato con successo';
    var errorLogin = 'PrestaShop non ha potuto accedere ad Addons. Si prega di controllare le tue credenziali e la tua connessione Internet.';
    var search_product_msg = 'Cerca un prodotto';
  </script>

      <link href=\"/admin78257ysim/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/admin78257ysim/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/gamification/views/css/gamification.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/nexixpay/views/css/back.css?v=7.1.9\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/admin78257ysim\\/\";
var baseDir = \"\\/\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":\"#,##0.00\\u00a0\\u00a4\"};
var host_mode = false;
var show_new_customers = \"1\";
var show_new_messages = false;
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/admin78257ysim/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/js/admin.js?v=1.7.4.4\"></script>
<script type=\"text/javascript\" src=\"/js/cldr.js\"></script>
<script type=\"text/javascript\" src=\"/js/tools.js?v=1.7.4.4\"></script>
<script type=\"text/javascript\" src=\"/admin78257ysim/public/bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin78257ysim/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/modules/nexixpay/views/js/xpay_admin.js?v=7.1.9\"></script>
<script type=\"text/javascript\" src=\"/modules/dhlshipping/views/js/loader.js\"></script>

  <script>
            var admin_gamification_ajax_url = \"http:\\/\\/scooter-eurocka.it\\/admin78257ysim\\/index.php?controller=AdminGamification&token=f84c56b2878229ed516b6619cd19746b\";
            var current_id_tab = 10;
        </script><script type=\"text/javascript\">
    document.GspedData = {\"config\":{\"apiBaseUrl\":\"http:\\/\\/scooter-eurocka.it\\/api\",\"paymentMethods\":{\"ps_checkpayment\":\"Assegno\",\"ps_wirepayment\":\"Bonifico bancario\",\"ps_checkout\":\"PrestaShop Checkout\",\"nexixpay\":\"nexixpay\",\"ps_cashondelivery\":\"ps_cashondelivery\"},\"cashOnDelivery\":[],\"platformStatuses\":[{\"value\":\"6\",\"label\":\"Annullato\"},{\"value\":\"17\",\"label\":\"Autorizzato. Sar\\u00e0 acquisito dal commerciante\"},{\"value\":\"5\",\"label\":\"Consegnato\"},{\"value\":\"18\",\"label\":\"Da Autorizzare\"},{\"value\":\"8\",\"label\":\"Errore di pagamento\"},{\"value\":\"1\",\"label\":\"In attesa di assegno\"},{\"value\":\"14\",\"label\":\"In attesa di pagamento\"},{\"value\":\"10\",\"label\":\"In attesa di pagamento con bonifico bancario\"},{\"value\":\"9\",\"label\":\"In attesa di rifornimento\"},{\"value\":\"12\",\"label\":\"In attesa di rifornimento\"},{\"value\":\"13\",\"label\":\"In attesa verifica contrassegno\"},{\"value\":\"2\",\"label\":\"Pagamento accettato\"},{\"value\":\"16\",\"label\":\"Pagamento parziale\"},{\"value\":\"11\",\"label\":\"Pagamento remoto accettato\"},{\"value\":\"3\",\"label\":\"Preparazione in corso\"},{\"value\":\"7\",\"label\":\"Rimborsato\"},{\"value\":\"15\",\"label\":\"Rimborso parziale\"},{\"value\":\"4\",\"label\":\"Spedito\"}]}};
</script>

";
        // line 84
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>
<body class=\"lang-it adminproducts\">


<header id=\"header\">
  <nav id=\"header_infos\" class=\"main-header\">

    <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

        
        <i class=\"material-icons js-mobile-menu\">menu</i>
    <a id=\"header_logo\" class=\"logo float-left\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\"></a>
    <span id=\"shop_version\">1.7.4.4</span>

    <div class=\"component\" id=\"quick-access-container\">
      <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Accesso Veloce
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php/module/manage?token=4d44ab86567f55c08e53c282dc4bd8c6\"
                 data-item=\"Moduli installati\"
      >Moduli installati</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCategories&amp;addcategory&amp;token=f4ed22ac4224a8742ea582544b4a6ffd\"
                 data-item=\"Nuova categoria\"
      >Nuova categoria</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php/product/new?token=4d44ab86567f55c08e53c282dc4bd8c6\"
                 data-item=\"Nuovo prodotto\"
      >Nuovo prodotto</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=6483b0a181ddf53a8e41b20aadac37a0\"
                 data-item=\"Nuovo voucher\"
      >Nuovo voucher</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\"
                 data-item=\"Ordini\"
      >Ordini</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=b6a6c3b6cad8abbe660388737b8367ec\"
                 data-item=\"Valutazione catalogo\"
      >Valutazione catalogo</a>
        <div class=\"dropdown-divider\"></div>
          <a
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"59\"
        data-icon=\"icon-AdminCatalog\"
        data-method=\"add\"
        data-url=\"index.php/product/form/40\"
        data-post-link=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminQuickAccesses&token=09c3ff0ef6eb3c593034bff716fb608b\"
        data-prompt-text=\"Da\\\\\\' un nome a questo shortcut:\"
        data-link=\"Prodotti - Lista\"
      >
        <i class=\"material-icons\">add_circle</i>
        Aggiungi a QuickAccess la pagina corrente
      </a>
        <a class=\"dropdown-item\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminQuickAccesses&token=09c3ff0ef6eb3c593034bff716fb608b\">
      <i class=\"material-icons\">settings</i>
      Gestisci gli accessi rapidi
    </a>
  </div>
</div>
    </div>
    <div class=\"component\" id=\"header-search-container\">
      <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/admin78257ysim/index.php?controller=AdminSearch&amp;token=13ab4fe3dd10125241fbc53b7b0956bd\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Ricerca (es. riferimento prodotto, nome cliente...)\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Ovunque
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Ovunque\" href=\"#\" data-value=\"0\" data-placeholder=\"Cosa hai bisogno di trovare?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Ovunque</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalogo\" href=\"#\" data-value=\"1\" data-placeholder=\"Nome prodotto, codice a barre, riferimento...\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalogo</a>
        <a class=\"dropdown-item\" data-item=\"Clienti per nome\" href=\"#\" data-value=\"2\" data-placeholder=\"E-mail, nome, ...\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Clienti per nome</a>
        <a class=\"dropdown-item\" data-item=\"Clienti per indirizzo IP\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Clienti per indirizzo IP</a>
        <a class=\"dropdown-item\" data-item=\"Ordini\" href=\"#\" data-value=\"3\" data-placeholder=\"ID ordine\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Ordini</a>
        <a class=\"dropdown-item\" data-item=\"Fatture\" href=\"#\" data-value=\"4\" data-placeholder=\"Numero fattura\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i></i> Fatture</a>
        <a class=\"dropdown-item\" data-item=\"Carrelli\" href=\"#\" data-value=\"5\" data-placeholder=\"ID carrello\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carrelli</a>
        <a class=\"dropdown-item\" data-item=\"Moduli\" href=\"#\" data-value=\"7\" data-placeholder=\"Nome modulo\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Moduli</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">CERCA</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
    </div>

          <div class=\"component hide-mobile-sm\" id=\"header-debug-mode-container\">
        <a class=\"link shop-state\"
           id=\"debug-mode\"
           data-toggle=\"pstooltip\"
           data-placement=\"bottom\"
           data-html=\"true\"
           title=\"<p class='text-left'><strong>Il tuo negozio si trova in modalità debug.</strong></p><p class='text-left'>Verranno mostrati tutti gli errori e i messaggi PHP. Quando non ne avrai più bisogno, <strong>escludi</strong> questa modalità.</p>\"
           href=\"/admin78257ysim/index.php/configure/advanced/performance?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\"
        >
          <i class=\"material-icons\">bug_report</i>
          <span>Modalità di debug</span>
        </a>
      </div>
            <div class=\"component\" id=\"header-shop-list-container\">
        <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"http://scooter-eurocka.it/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      Vai al negozio
    </a>
  </div>
    </div>
          <div class=\"component header-right-component\" id=\"header-notifications-container\">
        <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Ordini<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Clienti<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
              href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messaggi<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora nessun nuovo ordine :(<br>
              Hai verificato ultimamente il tuo tasso di conversione?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora nessun nuovo cliente :(<br>
              Sei stato attivo sui social media in questi giorni?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora non ci sono nuovi messaggi.<br>
              Nessuna nuova, buona nuova, non è vero?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a class=\"notif\" href='order_url'>
      #_id_order_ -
      da <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registrato <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
      </div>
        <div class=\"component\" id=\"header-employee-container\">
      <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"text-center employee_avatar\">
      <img class=\"avatar rounded-circle\" src=\"http://profile.prestashop.com/okamproo%40gmail.com.jpg\" />
      <span>Lore Xu</span>
    </div>
    <a class=\"dropdown-item employee-link profile-link\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmployees&amp;token=0ee14fbcc20066abcc37470f72881b64&amp;id_employee=1&amp;updateemployee\">
      <i class=\"material-icons\">settings_applications</i>
      Il tuo profilo
    </a>
    <a class=\"dropdown-item employee-link\" id=\"header_logout\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLogin&amp;token=f8432792ffe824c70154cf017b2a5bfd&amp;logout\">
      <i class=\"material-icons\">power_settings_new</i>
      <span>Esci</span>
    </a>
  </div>
</div>
    </div>

      </nav>
  </header>

<nav class=\"nav-bar d-none d-md-block\">
  <span class=\"menu-collapse\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <ul class=\"main-menu\">

          
                
                
        
          <li class=\"link-levelone \" data-submenu=\"1\" id=\"tab-AdminDashboard\">
            <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\" class=\"link\" >
              <i class=\"material-icons\">trending_up</i> <span>Pannello di controllo</span>
            </a>
          </li>

        
                
                                  
                
        
          <li class=\"category-title -active\" data-submenu=\"2\" id=\"tab-SELL\">
              <span class=\"title\">Vendi</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\" class=\"link\">
                    <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                    <span>
                    Ordini
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\" class=\"link\"> Ordini
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminInvoices&amp;token=6aaf2cc62db52c1f39b2e167ce513a12\" class=\"link\"> Fatture
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminSlip&amp;token=9990f4fc74b8ac76b13716cfac98de5a\" class=\"link\"> Buoni sconto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDeliverySlip&amp;token=eab2c8ca1adb166f902468d799753c1f\" class=\"link\"> Bolle di consegna
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarts&amp;token=53c8f72bb27cf16c887e4ee63db1087f\" class=\"link\"> Carrello della spesa
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                                                    
                <li class=\"link-levelone has_submenu -active open ul-open\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                  <a href=\"/admin78257ysim/index.php/product/catalog?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-store\">store</i>
                    <span>
                    Catalogo
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_up
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo -active\" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                              <a href=\"/admin78257ysim/index.php/product/catalog?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prodotti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCategories&amp;token=f4ed22ac4224a8742ea582544b4a6ffd\" class=\"link\"> Categorie
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTracking&amp;token=5c4a9db7ad651663051d3fa9794d0892\" class=\"link\"> Monitoraggio
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAttributesGroups&amp;token=70a4bc16584bec2760dcedad1ccfbd4e\" class=\"link\"> Attributi e Funzionalità
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminManufacturers&amp;token=857ba47cedca95c8c0a69ba39e71f7ad\" class=\"link\"> Marche &amp; Fornitori
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAttachments&amp;token=f017b1b41955a3c4348ad6dcf3256c3a\" class=\"link\"> File
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCartRules&amp;token=6483b0a181ddf53a8e41b20aadac37a0\" class=\"link\"> Buoni sconto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                              <a href=\"/admin78257ysim/index.php/stock/?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Stocks
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomers&amp;token=98dccc1ac7cabc66c1461858b5f9f558\" class=\"link\">
                    <i class=\"material-icons mi-account_circle\">account_circle</i>
                    <span>
                    Clienti
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-24\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"25\" id=\"subtab-AdminCustomers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomers&amp;token=98dccc1ac7cabc66c1461858b5f9f558\" class=\"link\"> Clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"26\" id=\"subtab-AdminAddresses\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAddresses&amp;token=f2c3e0d3ffd22222ec71c9a3a91febfd\" class=\"link\"> Indirizzi
                              </a>
                            </li>

                                                                                                                          </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"28\" id=\"subtab-AdminParentCustomerThreads\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomerThreads&amp;token=bd0735ee32da605366c82b47b15e489a\" class=\"link\">
                    <i class=\"material-icons mi-chat\">chat</i>
                    <span>
                    Servizio clienti
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-28\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomerThreads&amp;token=bd0735ee32da605366c82b47b15e489a\" class=\"link\"> Servizio clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrderMessage&amp;token=e55a9ad5c2d63273ff9eaeb43fa4cdcb\" class=\"link\"> Messaggi d&#039;ordine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminReturn&amp;token=d99540d96220629afe67529f92f81513\" class=\"link\"> Restituzione Prodotto
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminStats&amp;token=b6a6c3b6cad8abbe660388737b8367ec\" class=\"link\">
                    <i class=\"material-icons mi-assessment\">assessment</i>
                    <span>
                    Statistiche
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"42\" id=\"tab-IMPROVE\">
              <span class=\"title\">Migliora</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                  <a href=\"/admin78257ysim/index.php/module/manage?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    Moduli
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                              <a href=\"/admin78257ysim/index.php/module/manage?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Moduli &amp; Servizi
                              </a>
                            </li>

                                                                                                                              
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"49\" id=\"subtab-AdminAddonsCatalog\">
                              <a href=\"/admin78257ysim/index.php/module/addons-store?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Strumenti di Compra-Vendita
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"50\" id=\"subtab-AdminParentThemes\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemes&amp;token=363d2daad60b3158a728461d0282c49a\" class=\"link\">
                    <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                    <span>
                    Design
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-50\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"121\" id=\"subtab-AdminThemesParent\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemes&amp;token=363d2daad60b3158a728461d0282c49a\" class=\"link\"> Tema &amp; Logo
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"52\" id=\"subtab-AdminThemesCatalog\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemesCatalog&amp;token=d9ec20c0eae31e4891f28e83b0620792\" class=\"link\"> Catalogo dei Temi
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"53\" id=\"subtab-AdminCmsContent\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCmsContent&amp;token=9c4c195ed8c12726673ccd5587a9eaae\" class=\"link\"> Pagine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"54\" id=\"subtab-AdminModulesPositions\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminModulesPositions&amp;token=e143cce9d16babbd4a306c9d592a6f3d\" class=\"link\"> Posizioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"55\" id=\"subtab-AdminImages\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminImages&amp;token=3f69def2a4ffe71a2604d0e0b1aa4595\" class=\"link\"> Impostazioni immagine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"120\" id=\"subtab-AdminLinkWidget\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLinkWidget&amp;token=801276d14d5d646abd54164a6d0fbb85\" class=\"link\"> Link Widget
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"56\" id=\"subtab-AdminParentShipping\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarriers&amp;token=4316e2e0e0a53184c147d0e95de56534\" class=\"link\">
                    <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                    <span>
                    Spedizione
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-56\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"57\" id=\"subtab-AdminCarriers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarriers&amp;token=4316e2e0e0a53184c147d0e95de56534\" class=\"link\"> Mezzi di spedizione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"58\" id=\"subtab-AdminShipping\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminShipping&amp;token=f0344bf8354b3ad43426936a31e2c984\" class=\"link\"> Impostazioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"59\" id=\"subtab-AdminParentPayment\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPayment&amp;token=1868be390ff1095e9fd9fbdc1d3a43a0\" class=\"link\">
                    <i class=\"material-icons mi-payment\">payment</i>
                    <span>
                    Pagamento
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-59\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"60\" id=\"subtab-AdminPayment\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPayment&amp;token=1868be390ff1095e9fd9fbdc1d3a43a0\" class=\"link\"> Metodi di Pagamento
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"61\" id=\"subtab-AdminPaymentPreferences\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPaymentPreferences&amp;token=786326dca2c7f3240cfa46766ee0825a\" class=\"link\"> Impostazioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"62\" id=\"subtab-AdminInternational\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLocalization&amp;token=8d67d4f66bb3f79b5c959cae71548a18\" class=\"link\">
                    <i class=\"material-icons mi-language\">language</i>
                    <span>
                    Internazionale
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-62\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"63\" id=\"subtab-AdminParentLocalization\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLocalization&amp;token=8d67d4f66bb3f79b5c959cae71548a18\" class=\"link\"> Localizzazione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"68\" id=\"subtab-AdminParentCountries\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminZones&amp;token=815cd3b9b8fd29f4655b4cdd3c6ba64c\" class=\"link\"> Località
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"72\" id=\"subtab-AdminParentTaxes\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTaxes&amp;token=01ef60766792322fa177bc326d85e49d\" class=\"link\"> Tasse
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"75\" id=\"subtab-AdminTranslations\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTranslations&amp;token=bb65f8c0814909d1451cfdd7186ea4dc\" class=\"link\"> Traduzioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"76\" id=\"tab-CONFIGURE\">
              <span class=\"title\">Configura</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"77\" id=\"subtab-ShopParameters\">
                  <a href=\"/admin78257ysim/index.php/configure/shop/preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-settings\">settings</i>
                    <span>
                    Parametri Negozio
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-77\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"78\" id=\"subtab-AdminParentPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Generale
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"81\" id=\"subtab-AdminParentOrderPreferences\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrderPreferences&amp;token=f372babc9f2680e50a62db6d2ec1756c\" class=\"link\"> Impostazioni Ordine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"84\" id=\"subtab-AdminPPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/product_preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prodotti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"85\" id=\"subtab-AdminParentCustomerPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/customer_preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Impostazioni clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"89\" id=\"subtab-AdminParentStores\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminContacts&amp;token=78aea5f6c1705fd46b6fff20823df4f1\" class=\"link\"> Contatto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"92\" id=\"subtab-AdminParentMeta\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminMeta&amp;token=a67d4f7027ae4bfe672aaba4fa393f4c\" class=\"link\"> Traffico &amp; SEO
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"96\" id=\"subtab-AdminParentSearchConf\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminSearchConf&amp;token=c2e55bd40ed19aaa1ce677aca1a53d3b\" class=\"link\"> Cerca
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"125\" id=\"subtab-AdminGamification\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminGamification&amp;token=f84c56b2878229ed516b6619cd19746b\" class=\"link\"> Merchant Expertise
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"99\" id=\"subtab-AdminAdvancedParameters\">
                  <a href=\"/admin78257ysim/index.php/configure/advanced/system_information?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                    <span>
                    Parametri Avanzati
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-99\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"100\" id=\"subtab-AdminInformation\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/system_information?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Informazioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"101\" id=\"subtab-AdminPerformance\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/performance?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prestazioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"102\" id=\"subtab-AdminAdminPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/administration?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Amministrazione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"103\" id=\"subtab-AdminEmails\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmails&amp;token=16c57e27285a0c695c76999c81fddd50\" class=\"link\"> Email
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"104\" id=\"subtab-AdminImport\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/import?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Importa
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"105\" id=\"subtab-AdminParentEmployees\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmployees&amp;token=0ee14fbcc20066abcc37470f72881b64\" class=\"link\"> Dipendenti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"109\" id=\"subtab-AdminParentRequestSql\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminRequestSql&amp;token=b781b07c7640c446a0dd288911d31bd1\" class=\"link\"> Database
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"112\" id=\"subtab-AdminLogs\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLogs&amp;token=1c274e647211f40cd52bcf5d5af84d30\" class=\"link\"> Logs
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"113\" id=\"subtab-AdminWebservice\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminWebservice&amp;token=72b803b4b324ecbe7b32988d0f101f2f\" class=\"link\"> Webservice
                              </a>
                            </li>

                                                                                                                                                                            </ul>
                                    </li>
                          
        
            </ul>
  
</nav>

<div id=\"main-div\">

  
        
    <div class=\"content-div -notoolbar \">

      

      
                        
      <div class=\"row \">
        <div class=\"col-sm-12\">
          <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1010
        $this->displayBlock('content_header', $context, $blocks);
        // line 1011
        echo "                 ";
        $this->displayBlock('content', $context, $blocks);
        // line 1012
        echo "                 ";
        $this->displayBlock('content_footer', $context, $blocks);
        // line 1013
        echo "                 ";
        $this->displayBlock('sidebar_right', $context, $blocks);
        // line 1014
        echo "
          
        </div>
      </div>

    </div>

  
</div>

<div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh no!</h1>
  <p class=\"mt-3\">
    La versione mobile di questa pagina non è ancora disponibile.
  </p>
  <p class=\"mt-2\">
    Si prega di utilizzare un computer desktop per accedere a questa pagina, fin quando non sarà stata adattata ai dispositivi mobili.
  </p>
  <p class=\"mt-2\">
    Grazie.
  </p>
  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Indietro
  </a>
</div>
<div class=\"mobile-layer\"></div>

  <div id=\"footer\" class=\"bootstrap\">
    
</div>


  <div class=\"bootstrap\">
    <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-IT&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/it/login?email=okamproo%40gmail.com&amp;firstname=Lore&amp;lastname=Xu&amp;website=http%3A%2F%2Fscooter-eurocka.it%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-IT&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/admin78257ysim/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Collega il tuo negozio al marketplace di PrestaShop al fine di importare automaticamente tutti i tuoi acquisti di Addons.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Non hai ancora un account?</h4>
\t\t\t\t\t\t<p class='text-justify'>Scopri la potenza di PrestaShop Addons! Esplora il Market Ufficiale di PrestaShop e trovi oltre 3500 moduli innovativi e temi che ottimizzano i rapporti di conversione, incrementano il traffico, fidelizzano il cliente e massimizzano i tuoi ritorni.</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Collegati con PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/it/forgot-your-password\">Ho dimenticato la mia password</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/it/login?email=okamproo%40gmail.com&amp;firstname=Lore&amp;lastname=Xu&amp;website=http%3A%2F%2Fscooter-eurocka.it%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-IT&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCrea un account
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Accedi
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

  </div>

";
        // line 1123
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>
</html>";
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 84
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_extra_stylesheets($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "extra_stylesheets"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "extra_stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1010
    public function block_content_header($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content_header"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content_header"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1011
    public function block_content($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1012
    public function block_content_footer($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content_footer"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content_footer"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1013
    public function block_sidebar_right($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "sidebar_right"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "sidebar_right"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    // line 1123
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_extra_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "extra_javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "extra_javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function block_translate_javascripts($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->env->getExtension("Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension");
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "translate_javascripts"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->env->getExtension("Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension");
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "translate_javascripts"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "__string_template__0916e18772b3bb1571b3b552b0713332ced630fb7ed67907f9c738e5f68f7642";
    }

    public function getDebugInfo()
    {
        return array (  1286 => 1123,  1269 => 1013,  1252 => 1012,  1235 => 1011,  1218 => 1010,  1185 => 84,  1171 => 1123,  1060 => 1014,  1057 => 1013,  1054 => 1012,  1051 => 1011,  1049 => 1010,  119 => 84,  34 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"it\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.75, maximum-scale=0.75, user-scalable=0\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/img/app_icon.png\" />

<title>Prodotto • eurocka</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminProducts';
    var iso_user = 'it';
    var lang_is_rtl = '0';
    var full_language_code = 'it';
    var full_cldr_language_code = 'it-IT';
    var country_iso_code = 'IT';
    var _PS_VERSION_ = '1.7.4.4';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'È stato effettuato un nuovo ordine nel tuo negozio.';
    var order_number_msg = 'Numero dell\\\\\\'ordine: ';
    var total_msg = 'Totale: ';
    var from_msg = 'Da: ';
    var see_order_msg = 'Vedi quest\\\\\\'ordine';
    var new_customer_msg = 'Un nuovo cliente si è registrato nel tuo negozio.';
    var customer_name_msg = 'Nome cliente: ';
    var new_msg = 'Al tuo negozio è stato inviato un nuovo messaggio.';
    var see_msg = 'Leggi questo messaggio';
    var token = '80fe46524be30b87329eab55b867f3c9';
    var token_admin_orders = 'd421f192adafc9b7dca158866e05efcf';
    var token_admin_customers = '98dccc1ac7cabc66c1461858b5f9f558';
    var token_admin_customer_threads = 'bd0735ee32da605366c82b47b15e489a';
    var currentIndex = 'index.php?controller=AdminProducts';
    var employee_token = '0ee14fbcc20066abcc37470f72881b64';
    var choose_language_translate = 'Scegli lingua';
    var default_language = '2';
    var admin_modules_link = '/admin78257ysim/index.php/module/catalog/recommended?route=admin_module_catalog_post&_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc';
    var tab_modules_list = 'storecommanderps,onlive,viqeo,ndk_advanced_custom_fields,pm_advancedpack,cdesigner,ultimateimagetool';
    var update_success_msg = 'Aggiornato con successo';
    var errorLogin = 'PrestaShop non ha potuto accedere ad Addons. Si prega di controllare le tue credenziali e la tua connessione Internet.';
    var search_product_msg = 'Cerca un prodotto';
  </script>

      <link href=\"/admin78257ysim/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/admin78257ysim/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/gamification/views/css/gamification.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/js/jquery/plugins/fancybox/jquery.fancybox.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/modules/nexixpay/views/css/back.css?v=7.1.9\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/admin78257ysim\\/\";
var baseDir = \"\\/\";
var currency = {\"iso_code\":\"EUR\",\"sign\":\"\\u20ac\",\"name\":\"Euro\",\"format\":\"#,##0.00\\u00a0\\u00a4\"};
var host_mode = false;
var show_new_customers = \"1\";
var show_new_messages = false;
var show_new_orders = \"1\";
</script>
<script type=\"text/javascript\" src=\"/admin78257ysim/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/js/admin.js?v=1.7.4.4\"></script>
<script type=\"text/javascript\" src=\"/js/cldr.js\"></script>
<script type=\"text/javascript\" src=\"/js/tools.js?v=1.7.4.4\"></script>
<script type=\"text/javascript\" src=\"/admin78257ysim/public/bundle.js\"></script>
<script type=\"text/javascript\" src=\"/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/admin78257ysim/themes/default/js/vendor/nv.d3.min.js\"></script>
<script type=\"text/javascript\" src=\"/modules/gamification/views/js/gamification_bt.js\"></script>
<script type=\"text/javascript\" src=\"/js/jquery/plugins/fancybox/jquery.fancybox.js\"></script>
<script type=\"text/javascript\" src=\"/modules/nexixpay/views/js/xpay_admin.js?v=7.1.9\"></script>
<script type=\"text/javascript\" src=\"/modules/dhlshipping/views/js/loader.js\"></script>

  <script>
            var admin_gamification_ajax_url = \"http:\\/\\/scooter-eurocka.it\\/admin78257ysim\\/index.php?controller=AdminGamification&token=f84c56b2878229ed516b6619cd19746b\";
            var current_id_tab = 10;
        </script><script type=\"text/javascript\">
    document.GspedData = {\"config\":{\"apiBaseUrl\":\"http:\\/\\/scooter-eurocka.it\\/api\",\"paymentMethods\":{\"ps_checkpayment\":\"Assegno\",\"ps_wirepayment\":\"Bonifico bancario\",\"ps_checkout\":\"PrestaShop Checkout\",\"nexixpay\":\"nexixpay\",\"ps_cashondelivery\":\"ps_cashondelivery\"},\"cashOnDelivery\":[],\"platformStatuses\":[{\"value\":\"6\",\"label\":\"Annullato\"},{\"value\":\"17\",\"label\":\"Autorizzato. Sar\\u00e0 acquisito dal commerciante\"},{\"value\":\"5\",\"label\":\"Consegnato\"},{\"value\":\"18\",\"label\":\"Da Autorizzare\"},{\"value\":\"8\",\"label\":\"Errore di pagamento\"},{\"value\":\"1\",\"label\":\"In attesa di assegno\"},{\"value\":\"14\",\"label\":\"In attesa di pagamento\"},{\"value\":\"10\",\"label\":\"In attesa di pagamento con bonifico bancario\"},{\"value\":\"9\",\"label\":\"In attesa di rifornimento\"},{\"value\":\"12\",\"label\":\"In attesa di rifornimento\"},{\"value\":\"13\",\"label\":\"In attesa verifica contrassegno\"},{\"value\":\"2\",\"label\":\"Pagamento accettato\"},{\"value\":\"16\",\"label\":\"Pagamento parziale\"},{\"value\":\"11\",\"label\":\"Pagamento remoto accettato\"},{\"value\":\"3\",\"label\":\"Preparazione in corso\"},{\"value\":\"7\",\"label\":\"Rimborsato\"},{\"value\":\"15\",\"label\":\"Rimborso parziale\"},{\"value\":\"4\",\"label\":\"Spedito\"}]}};
</script>

{% block stylesheets %}{% endblock %}{% block extra_stylesheets %}{% endblock %}</head>
<body class=\"lang-it adminproducts\">


<header id=\"header\">
  <nav id=\"header_infos\" class=\"main-header\">

    <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

        
        <i class=\"material-icons js-mobile-menu\">menu</i>
    <a id=\"header_logo\" class=\"logo float-left\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\"></a>
    <span id=\"shop_version\">1.7.4.4</span>

    <div class=\"component\" id=\"quick-access-container\">
      <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Accesso Veloce
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php/module/manage?token=4d44ab86567f55c08e53c282dc4bd8c6\"
                 data-item=\"Moduli installati\"
      >Moduli installati</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCategories&amp;addcategory&amp;token=f4ed22ac4224a8742ea582544b4a6ffd\"
                 data-item=\"Nuova categoria\"
      >Nuova categoria</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php/product/new?token=4d44ab86567f55c08e53c282dc4bd8c6\"
                 data-item=\"Nuovo prodotto\"
      >Nuovo prodotto</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=6483b0a181ddf53a8e41b20aadac37a0\"
                 data-item=\"Nuovo voucher\"
      >Nuovo voucher</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\"
                 data-item=\"Ordini\"
      >Ordini</a>
          <a class=\"dropdown-item\"
         href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=b6a6c3b6cad8abbe660388737b8367ec\"
                 data-item=\"Valutazione catalogo\"
      >Valutazione catalogo</a>
        <div class=\"dropdown-divider\"></div>
          <a
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"59\"
        data-icon=\"icon-AdminCatalog\"
        data-method=\"add\"
        data-url=\"index.php/product/form/40\"
        data-post-link=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminQuickAccesses&token=09c3ff0ef6eb3c593034bff716fb608b\"
        data-prompt-text=\"Da\\\\\\' un nome a questo shortcut:\"
        data-link=\"Prodotti - Lista\"
      >
        <i class=\"material-icons\">add_circle</i>
        Aggiungi a QuickAccess la pagina corrente
      </a>
        <a class=\"dropdown-item\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminQuickAccesses&token=09c3ff0ef6eb3c593034bff716fb608b\">
      <i class=\"material-icons\">settings</i>
      Gestisci gli accessi rapidi
    </a>
  </div>
</div>
    </div>
    <div class=\"component\" id=\"header-search-container\">
      <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/admin78257ysim/index.php?controller=AdminSearch&amp;token=13ab4fe3dd10125241fbc53b7b0956bd\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Ricerca (es. riferimento prodotto, nome cliente...)\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        Ovunque
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"Ovunque\" href=\"#\" data-value=\"0\" data-placeholder=\"Cosa hai bisogno di trovare?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> Ovunque</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catalogo\" href=\"#\" data-value=\"1\" data-placeholder=\"Nome prodotto, codice a barre, riferimento...\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catalogo</a>
        <a class=\"dropdown-item\" data-item=\"Clienti per nome\" href=\"#\" data-value=\"2\" data-placeholder=\"E-mail, nome, ...\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Clienti per nome</a>
        <a class=\"dropdown-item\" data-item=\"Clienti per indirizzo IP\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Clienti per indirizzo IP</a>
        <a class=\"dropdown-item\" data-item=\"Ordini\" href=\"#\" data-value=\"3\" data-placeholder=\"ID ordine\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Ordini</a>
        <a class=\"dropdown-item\" data-item=\"Fatture\" href=\"#\" data-value=\"4\" data-placeholder=\"Numero fattura\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i></i> Fatture</a>
        <a class=\"dropdown-item\" data-item=\"Carrelli\" href=\"#\" data-value=\"5\" data-placeholder=\"ID carrello\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carrelli</a>
        <a class=\"dropdown-item\" data-item=\"Moduli\" href=\"#\" data-value=\"7\" data-placeholder=\"Nome modulo\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Moduli</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">CERCA</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
    </div>

          <div class=\"component hide-mobile-sm\" id=\"header-debug-mode-container\">
        <a class=\"link shop-state\"
           id=\"debug-mode\"
           data-toggle=\"pstooltip\"
           data-placement=\"bottom\"
           data-html=\"true\"
           title=\"<p class='text-left'><strong>Il tuo negozio si trova in modalità debug.</strong></p><p class='text-left'>Verranno mostrati tutti gli errori e i messaggi PHP. Quando non ne avrai più bisogno, <strong>escludi</strong> questa modalità.</p>\"
           href=\"/admin78257ysim/index.php/configure/advanced/performance?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\"
        >
          <i class=\"material-icons\">bug_report</i>
          <span>Modalità di debug</span>
        </a>
      </div>
            <div class=\"component\" id=\"header-shop-list-container\">
        <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"http://scooter-eurocka.it/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      Vai al negozio
    </a>
  </div>
    </div>
          <div class=\"component header-right-component\" id=\"header-notifications-container\">
        <div id=\"notif\" class=\"notification-center dropdown dropdown-clickable\">
  <button class=\"btn notification js-notification dropdown-toggle\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">notifications_none</i>
    <span id=\"notifications-total\" class=\"count hide\">0</span>
  </button>
  <div class=\"dropdown-menu dropdown-menu-right js-notifs_dropdown\">
    <div class=\"notifications\">
      <ul class=\"nav nav-tabs\" role=\"tablist\">
                          <li class=\"nav-item\">
            <a
              class=\"nav-link active\"
              id=\"orders-tab\"
              data-toggle=\"tab\"
              data-type=\"order\"
              href=\"#orders-notifications\"
              role=\"tab\"
            >
              Ordini<span id=\"_nb_new_orders_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"customers-tab\"
              data-toggle=\"tab\"
              data-type=\"customer\"
              href=\"#customers-notifications\"
              role=\"tab\"
            >
              Clienti<span id=\"_nb_new_customers_\"></span>
            </a>
          </li>
                                    <li class=\"nav-item\">
            <a
              class=\"nav-link \"
              id=\"messages-tab\"
              data-toggle=\"tab\"
              data-type=\"customer_message\"
              href=\"#messages-notifications\"
              role=\"tab\"
            >
              Messaggi<span id=\"_nb_new_messages_\"></span>
            </a>
          </li>
                        </ul>

      <!-- Tab panes -->
      <div class=\"tab-content\">
                          <div class=\"tab-pane active empty\" id=\"orders-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora nessun nuovo ordine :(<br>
              Hai verificato ultimamente il tuo tasso di conversione?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"customers-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora nessun nuovo cliente :(<br>
              Sei stato attivo sui social media in questi giorni?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                                    <div class=\"tab-pane  empty\" id=\"messages-notifications\" role=\"tabpanel\">
            <p class=\"no-notification\">
              Per ora non ci sono nuovi messaggi.<br>
              Nessuna nuova, buona nuova, non è vero?
            </p>
            <div class=\"notification-elements\"></div>
          </div>
                        </div>
    </div>
  </div>
</div>

  <script type=\"text/html\" id=\"order-notification-template\">
    <a class=\"notif\" href='order_url'>
      #_id_order_ -
      da <strong>_customer_name_</strong> (_iso_code_)_carrier_
      <strong class=\"float-sm-right\">_total_paid_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"customer-notification-template\">
    <a class=\"notif\" href='customer_url'>
      #_id_customer_ - <strong>_customer_name_</strong>_company_ - registrato <strong>_date_add_</strong>
    </a>
  </script>

  <script type=\"text/html\" id=\"message-notification-template\">
    <a class=\"notif\" href='message_url'>
    <span class=\"message-notification-status _status_\">
      <i class=\"material-icons\">fiber_manual_record</i> _status_
    </span>
      - <strong>_customer_name_</strong> (_company_) - <i class=\"material-icons\">access_time</i> _date_add_
    </a>
  </script>
      </div>
        <div class=\"component\" id=\"header-employee-container\">
      <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"text-center employee_avatar\">
      <img class=\"avatar rounded-circle\" src=\"http://profile.prestashop.com/okamproo%40gmail.com.jpg\" />
      <span>Lore Xu</span>
    </div>
    <a class=\"dropdown-item employee-link profile-link\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmployees&amp;token=0ee14fbcc20066abcc37470f72881b64&amp;id_employee=1&amp;updateemployee\">
      <i class=\"material-icons\">settings_applications</i>
      Il tuo profilo
    </a>
    <a class=\"dropdown-item employee-link\" id=\"header_logout\" href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLogin&amp;token=f8432792ffe824c70154cf017b2a5bfd&amp;logout\">
      <i class=\"material-icons\">power_settings_new</i>
      <span>Esci</span>
    </a>
  </div>
</div>
    </div>

      </nav>
  </header>

<nav class=\"nav-bar d-none d-md-block\">
  <span class=\"menu-collapse\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <ul class=\"main-menu\">

          
                
                
        
          <li class=\"link-levelone \" data-submenu=\"1\" id=\"tab-AdminDashboard\">
            <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\" class=\"link\" >
              <i class=\"material-icons\">trending_up</i> <span>Pannello di controllo</span>
            </a>
          </li>

        
                
                                  
                
        
          <li class=\"category-title -active\" data-submenu=\"2\" id=\"tab-SELL\">
              <span class=\"title\">Vendi</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\" class=\"link\">
                    <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                    <span>
                    Ordini
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrders&amp;token=d421f192adafc9b7dca158866e05efcf\" class=\"link\"> Ordini
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminInvoices&amp;token=6aaf2cc62db52c1f39b2e167ce513a12\" class=\"link\"> Fatture
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminSlip&amp;token=9990f4fc74b8ac76b13716cfac98de5a\" class=\"link\"> Buoni sconto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDeliverySlip&amp;token=eab2c8ca1adb166f902468d799753c1f\" class=\"link\"> Bolle di consegna
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarts&amp;token=53c8f72bb27cf16c887e4ee63db1087f\" class=\"link\"> Carrello della spesa
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                                                    
                <li class=\"link-levelone has_submenu -active open ul-open\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                  <a href=\"/admin78257ysim/index.php/product/catalog?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-store\">store</i>
                    <span>
                    Catalogo
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_up
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo -active\" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                              <a href=\"/admin78257ysim/index.php/product/catalog?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prodotti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCategories&amp;token=f4ed22ac4224a8742ea582544b4a6ffd\" class=\"link\"> Categorie
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTracking&amp;token=5c4a9db7ad651663051d3fa9794d0892\" class=\"link\"> Monitoraggio
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAttributesGroups&amp;token=70a4bc16584bec2760dcedad1ccfbd4e\" class=\"link\"> Attributi e Funzionalità
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminManufacturers&amp;token=857ba47cedca95c8c0a69ba39e71f7ad\" class=\"link\"> Marche &amp; Fornitori
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAttachments&amp;token=f017b1b41955a3c4348ad6dcf3256c3a\" class=\"link\"> File
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCartRules&amp;token=6483b0a181ddf53a8e41b20aadac37a0\" class=\"link\"> Buoni sconto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                              <a href=\"/admin78257ysim/index.php/stock/?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Stocks
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomers&amp;token=98dccc1ac7cabc66c1461858b5f9f558\" class=\"link\">
                    <i class=\"material-icons mi-account_circle\">account_circle</i>
                    <span>
                    Clienti
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-24\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"25\" id=\"subtab-AdminCustomers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomers&amp;token=98dccc1ac7cabc66c1461858b5f9f558\" class=\"link\"> Clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"26\" id=\"subtab-AdminAddresses\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminAddresses&amp;token=f2c3e0d3ffd22222ec71c9a3a91febfd\" class=\"link\"> Indirizzi
                              </a>
                            </li>

                                                                                                                          </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"28\" id=\"subtab-AdminParentCustomerThreads\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomerThreads&amp;token=bd0735ee32da605366c82b47b15e489a\" class=\"link\">
                    <i class=\"material-icons mi-chat\">chat</i>
                    <span>
                    Servizio clienti
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-28\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCustomerThreads&amp;token=bd0735ee32da605366c82b47b15e489a\" class=\"link\"> Servizio clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrderMessage&amp;token=e55a9ad5c2d63273ff9eaeb43fa4cdcb\" class=\"link\"> Messaggi d&#039;ordine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminReturn&amp;token=d99540d96220629afe67529f92f81513\" class=\"link\"> Restituzione Prodotto
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminStats&amp;token=b6a6c3b6cad8abbe660388737b8367ec\" class=\"link\">
                    <i class=\"material-icons mi-assessment\">assessment</i>
                    <span>
                    Statistiche
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"42\" id=\"tab-IMPROVE\">
              <span class=\"title\">Migliora</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                  <a href=\"/admin78257ysim/index.php/module/manage?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    Moduli
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                              <a href=\"/admin78257ysim/index.php/module/manage?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Moduli &amp; Servizi
                              </a>
                            </li>

                                                                                                                              
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"49\" id=\"subtab-AdminAddonsCatalog\">
                              <a href=\"/admin78257ysim/index.php/module/addons-store?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Strumenti di Compra-Vendita
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"50\" id=\"subtab-AdminParentThemes\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemes&amp;token=363d2daad60b3158a728461d0282c49a\" class=\"link\">
                    <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                    <span>
                    Design
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-50\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"121\" id=\"subtab-AdminThemesParent\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemes&amp;token=363d2daad60b3158a728461d0282c49a\" class=\"link\"> Tema &amp; Logo
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"52\" id=\"subtab-AdminThemesCatalog\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminThemesCatalog&amp;token=d9ec20c0eae31e4891f28e83b0620792\" class=\"link\"> Catalogo dei Temi
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"53\" id=\"subtab-AdminCmsContent\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCmsContent&amp;token=9c4c195ed8c12726673ccd5587a9eaae\" class=\"link\"> Pagine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"54\" id=\"subtab-AdminModulesPositions\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminModulesPositions&amp;token=e143cce9d16babbd4a306c9d592a6f3d\" class=\"link\"> Posizioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"55\" id=\"subtab-AdminImages\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminImages&amp;token=3f69def2a4ffe71a2604d0e0b1aa4595\" class=\"link\"> Impostazioni immagine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"120\" id=\"subtab-AdminLinkWidget\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLinkWidget&amp;token=801276d14d5d646abd54164a6d0fbb85\" class=\"link\"> Link Widget
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"56\" id=\"subtab-AdminParentShipping\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarriers&amp;token=4316e2e0e0a53184c147d0e95de56534\" class=\"link\">
                    <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                    <span>
                    Spedizione
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-56\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"57\" id=\"subtab-AdminCarriers\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminCarriers&amp;token=4316e2e0e0a53184c147d0e95de56534\" class=\"link\"> Mezzi di spedizione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"58\" id=\"subtab-AdminShipping\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminShipping&amp;token=f0344bf8354b3ad43426936a31e2c984\" class=\"link\"> Impostazioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"59\" id=\"subtab-AdminParentPayment\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPayment&amp;token=1868be390ff1095e9fd9fbdc1d3a43a0\" class=\"link\">
                    <i class=\"material-icons mi-payment\">payment</i>
                    <span>
                    Pagamento
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-59\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"60\" id=\"subtab-AdminPayment\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPayment&amp;token=1868be390ff1095e9fd9fbdc1d3a43a0\" class=\"link\"> Metodi di Pagamento
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"61\" id=\"subtab-AdminPaymentPreferences\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminPaymentPreferences&amp;token=786326dca2c7f3240cfa46766ee0825a\" class=\"link\"> Impostazioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"62\" id=\"subtab-AdminInternational\">
                  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLocalization&amp;token=8d67d4f66bb3f79b5c959cae71548a18\" class=\"link\">
                    <i class=\"material-icons mi-language\">language</i>
                    <span>
                    Internazionale
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-62\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"63\" id=\"subtab-AdminParentLocalization\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLocalization&amp;token=8d67d4f66bb3f79b5c959cae71548a18\" class=\"link\"> Localizzazione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"68\" id=\"subtab-AdminParentCountries\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminZones&amp;token=815cd3b9b8fd29f4655b4cdd3c6ba64c\" class=\"link\"> Località
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"72\" id=\"subtab-AdminParentTaxes\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTaxes&amp;token=01ef60766792322fa177bc326d85e49d\" class=\"link\"> Tasse
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"75\" id=\"subtab-AdminTranslations\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminTranslations&amp;token=bb65f8c0814909d1451cfdd7186ea4dc\" class=\"link\"> Traduzioni
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"76\" id=\"tab-CONFIGURE\">
              <span class=\"title\">Configura</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"77\" id=\"subtab-ShopParameters\">
                  <a href=\"/admin78257ysim/index.php/configure/shop/preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-settings\">settings</i>
                    <span>
                    Parametri Negozio
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-77\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"78\" id=\"subtab-AdminParentPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Generale
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"81\" id=\"subtab-AdminParentOrderPreferences\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminOrderPreferences&amp;token=f372babc9f2680e50a62db6d2ec1756c\" class=\"link\"> Impostazioni Ordine
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"84\" id=\"subtab-AdminPPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/product_preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prodotti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"85\" id=\"subtab-AdminParentCustomerPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/shop/customer_preferences?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Impostazioni clienti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"89\" id=\"subtab-AdminParentStores\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminContacts&amp;token=78aea5f6c1705fd46b6fff20823df4f1\" class=\"link\"> Contatto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"92\" id=\"subtab-AdminParentMeta\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminMeta&amp;token=a67d4f7027ae4bfe672aaba4fa393f4c\" class=\"link\"> Traffico &amp; SEO
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"96\" id=\"subtab-AdminParentSearchConf\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminSearchConf&amp;token=c2e55bd40ed19aaa1ce677aca1a53d3b\" class=\"link\"> Cerca
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"125\" id=\"subtab-AdminGamification\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminGamification&amp;token=f84c56b2878229ed516b6619cd19746b\" class=\"link\"> Merchant Expertise
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"99\" id=\"subtab-AdminAdvancedParameters\">
                  <a href=\"/admin78257ysim/index.php/configure/advanced/system_information?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\">
                    <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                    <span>
                    Parametri Avanzati
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-99\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"100\" id=\"subtab-AdminInformation\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/system_information?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Informazioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"101\" id=\"subtab-AdminPerformance\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/performance?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Prestazioni
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"102\" id=\"subtab-AdminAdminPreferences\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/administration?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Amministrazione
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"103\" id=\"subtab-AdminEmails\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmails&amp;token=16c57e27285a0c695c76999c81fddd50\" class=\"link\"> Email
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"104\" id=\"subtab-AdminImport\">
                              <a href=\"/admin78257ysim/index.php/configure/advanced/import?_token=H7kWq69RHOTBeeXtogtADoCpWTBP_8O2VQQRb9v2XZc\" class=\"link\"> Importa
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"105\" id=\"subtab-AdminParentEmployees\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminEmployees&amp;token=0ee14fbcc20066abcc37470f72881b64\" class=\"link\"> Dipendenti
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"109\" id=\"subtab-AdminParentRequestSql\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminRequestSql&amp;token=b781b07c7640c446a0dd288911d31bd1\" class=\"link\"> Database
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"112\" id=\"subtab-AdminLogs\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminLogs&amp;token=1c274e647211f40cd52bcf5d5af84d30\" class=\"link\"> Logs
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"113\" id=\"subtab-AdminWebservice\">
                              <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminWebservice&amp;token=72b803b4b324ecbe7b32988d0f101f2f\" class=\"link\"> Webservice
                              </a>
                            </li>

                                                                                                                                                                            </ul>
                                    </li>
                          
        
            </ul>
  
</nav>

<div id=\"main-div\">

  
        
    <div class=\"content-div -notoolbar \">

      

      
                        
      <div class=\"row \">
        <div class=\"col-sm-12\">
          <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  {% block content_header %}{% endblock %}
                 {% block content %}{% endblock %}
                 {% block content_footer %}{% endblock %}
                 {% block sidebar_right %}{% endblock %}

          
        </div>
      </div>

    </div>

  
</div>

<div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>Oh no!</h1>
  <p class=\"mt-3\">
    La versione mobile di questa pagina non è ancora disponibile.
  </p>
  <p class=\"mt-2\">
    Si prega di utilizzare un computer desktop per accedere a questa pagina, fin quando non sarà stata adattata ai dispositivi mobili.
  </p>
  <p class=\"mt-2\">
    Grazie.
  </p>
  <a href=\"http://scooter-eurocka.it/admin78257ysim/index.php?controller=AdminDashboard&amp;token=645ef5be08fcf71c6b6ef7be9bc756b8\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Indietro
  </a>
</div>
<div class=\"mobile-layer\"></div>

  <div id=\"footer\" class=\"bootstrap\">
    
</div>


  <div class=\"bootstrap\">
    <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-IT&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/it/login?email=okamproo%40gmail.com&amp;firstname=Lore&amp;lastname=Xu&amp;website=http%3A%2F%2Fscooter-eurocka.it%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-IT&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/admin78257ysim/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Collega il tuo negozio al marketplace di PrestaShop al fine di importare automaticamente tutti i tuoi acquisti di Addons.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Non hai ancora un account?</h4>
\t\t\t\t\t\t<p class='text-justify'>Scopri la potenza di PrestaShop Addons! Esplora il Market Ufficiale di PrestaShop e trovi oltre 3500 moduli innovativi e temi che ottimizzano i rapporti di conversione, incrementano il traffico, fidelizzano il cliente e massimizzano i tuoi ritorni.</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Collegati con PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/it/forgot-your-password\">Ho dimenticato la mia password</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/it/login?email=okamproo%40gmail.com&amp;firstname=Lore&amp;lastname=Xu&amp;website=http%3A%2F%2Fscooter-eurocka.it%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-IT&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCrea un account
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Accedi
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

  </div>

{% block javascripts %}{% endblock %}{% block extra_javascripts %}{% endblock %}{% block translate_javascripts %}{% endblock %}</body>
</html>", "__string_template__0916e18772b3bb1571b3b552b0713332ced630fb7ed67907f9c738e5f68f7642", "");
    }
}
