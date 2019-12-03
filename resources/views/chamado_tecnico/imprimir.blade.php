@extends('layouts.imprimir')

@section('conteudo')
    @include('suporte.listagem', ['imprimir' => true])
@endsection