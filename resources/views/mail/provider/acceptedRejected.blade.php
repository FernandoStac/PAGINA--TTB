@component('mail::message')
<?php
    $ms="";
    $ow="";
    $do="";
    $st="";
    $ms=implode(['url' => $message],$ms);
    $st=implode(['url' => $status],$st);
    $ow=implode(['url' => $owner],$ow);
    $do=implode(['url' => $document],$do);
    $color = 'success';
    if($st=="not"){
        $color = 'error';
    }
?>
# @lang('Apreciable '.$ow)

{!!'La factura con serie y fólio <strong>'.$do."</strong> ".$ms.", le recomendamos revisarlo para saber de cual se trata"!!}

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach






@component('mail::button', ['url' => $url, 'color' => $color])
Entrar a IM para verificar la factura
@endcomponent

<br>

@component('mail::button', ['url' => $url2, 'color' => $color])
Documento
@endcomponent

@endcomponent
