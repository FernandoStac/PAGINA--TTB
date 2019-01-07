@extends('errors::illustrated-layout')

@section('code', '429')
@section('title', __('Too Many Requests'))

@section('image')
<div style="background-image: url('{{ url('/svg/404.svg') }}');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __('Lo sentimos, usted esta haciendo muchas solicitudes al servidor.'))
