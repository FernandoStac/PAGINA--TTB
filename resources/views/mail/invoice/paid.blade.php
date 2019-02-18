@component('mail::message')
# Introduction

Hola!
Se cargo un archivo nuevo.



@component('mail::button', ['url' => $xml])
Ver xml
@endcomponent

 <br>

@component('mail::button', ['url' => $pdf])
Ver PDF
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent


