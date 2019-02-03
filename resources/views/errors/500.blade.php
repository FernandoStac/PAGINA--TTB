@extends('errors::illustrated-layout')

@section('code', '500')
@section('title', __('Error'))

@section('image')
<div style="background-image: url('{{ url('/svg/500.svg') }}');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">

</div>
@endsection

@section('message', __('Whoops, algo anda mal en el servidor {{ $exception->getMessage() }}'))
