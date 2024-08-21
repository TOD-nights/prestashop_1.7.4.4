{if $v_less_1_7}
    <a class="col-lg-4 col-md-6 col-sm-6 col-xs-12" id="mycards-link" href="{$pageLink}">
        <span class="link-item">
            <i class="material-icons">call_to_action</i>{$linkLabel}
        </span>
    </a>
{else}
    <li>
        <a href="{$pageLink}" title="{$linkLabel}">
            <i class="icon-credit-card"></i>
            <span>{$linkLabel}</span>
        </a>
    </li>
{/if}