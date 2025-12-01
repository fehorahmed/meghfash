<rss xmlns:g="http://base.google.com/ns/1.0" xmlns:c="http://base.google.com/cns/1.0" version="2.0">
    <channel>
        <title>
        <![CDATA[ {{general()->meta_title}} ]]>
        </title>
        <link>
        <![CDATA[ {{route('index')}} ]]>
        </link>
        <description>
        <![CDATA[ {!!general()->meta_description!!} ]]>
        </description>
        @foreach($products as $product)
        <item>
            <g:id>{{$product->id}}</g:id>
            <g:title><![CDATA[ {{$product->name}} ]]></g:title>
            <g:description><![CDATA[ {!!$product->description!!} ]]></g:description>
            <g:link>{{route('productView',$product->slug?:'no-title')}}</g:link>
            <g:product_type>@foreach($product->productCategories as $i=>$ctg) {{$i==0?'':'>'}} {{$ctg->name}} @endforeach</g:product_type>
            <g:image_link>{{asset($product->image())}}</g:image_link>
            <g:condition>new</g:condition>
            <g:availability>in stock</g:availability>
            <g:currency>{{general()->currency}}</g:currency>
            <g:price>{{priceFormat($product->regular_price)}}</g:price>
            <g:sale_price>{{priceFormat($product->final_price)}}</g:sale_price>
        </item>
        @endforeach
    </channel>
</rss>