@component('mail::message')

Hola!
Se cargo un archivo nuevo.


@php 
$d=""
@endphp

@php 


$d=implode(['url' => $xml],$d)
@endphp

@if($d!=1)
@component('mail::button', ['url' => $xml])
Ver xml
@endcomponent
@endif
 <br>
@component('mail::button', ['url' => $pdf])
Ver PDF
@endcomponent

@endcomponent


