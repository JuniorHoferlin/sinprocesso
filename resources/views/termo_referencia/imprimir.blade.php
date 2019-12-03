@extends('layouts.imprimir')

@section('conteudo')
    @include('termo_referencia.listagem', ['imprimir' => true])
@endsection