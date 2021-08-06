
{*{capture name=path}<a rel="v:url" property="v:title" href="{$base_dir}content/category/2-company">Company</a><span class="navigation-pipe">{$navigationPipe}</span><a href="{$link->getModuleLink('azgallery', 'gallery')}" title="{l s='News' mod='rpadvancednews'}" rel="nofollow">{l s='Gallery' mod='azgallery'}</a><span class="navigation-pipe">{$navigationPipe}</span>{/capture}

{include file="$tpl_dir./breadcrumb.tpl"} *}

{extends file='page.tpl'}

{block name='page_title'}
    {l s='Gallery'}
{/block}

{block name='page_content'}
<div class="wrapper_iq">
    {if $isSingleShape eq true}

        <div id="step2">
            {include file='module:instantquote/views/templates/front/findAPan.tpl'}
        </div>
    {else}

        <div id="step1" >
            <div class="gray_border_box">

                <table class="shapecontainer" width="100%">
                    <tbody><tr>
                            <td id="pickMetalPart" class="shapefoo">
                                <h3 class="title_block">Please select the type of metal part you'd like to build.</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>

                                {dump($shapeClassData)}
                                {foreach from=$shapeClassData item=shapeData}
                                    <div class="imgShapePH hlshape noshape product_list_thumb" id="cngbg421"><input type="radio" checked="checked" value="{$shapeData.id_iq_shape}" name="shapeType" class="shapeType hidden" id="rbProductType_{$shapeData.id_iq_shape}">
                                        <label for="rbProductType_{$shapeData.id_iq_shape}">
                                            <i class="fa fa-check-circle"></i>
                                            <!--[if lte IE 6]><img id="imgProductType_421" src="/Images/ProQuote/hatbracket.gif" align="middle" alt="Hat Bracket"/><![endif]-->
                                            <!--[if !(lte IE 6)]><!--><img align="middle"  width="73" alt="Hat Bracket" src=" ../../modules/instantquote/images/productimages/{$shapeData.shape_image}" id="imgProductType_{$shapeData.id_iq_shape}"><!--<![endif]-->
                                            <span>{$shapeData.display_name}</span>
                                        </label>

                                    </div>
                                {/foreach}

                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>
            <input type="button" value="Next" class="next exclusive_large btn" id="nextStep2">
        </div>
        <div id="step2"></div>
    {/if}
</div>


<script>
    var base_url = '{$urls.base_url}';
    var skuMaterialSizeId = "{(isset($fieldDetails['material_size']))?$fieldDetails['material_size']:''}";

</script>

{/block}
