@extends('layouts.imprimir')

@section('conteudo')
    @include('rotas.listagem', ['imprimir' => true])
@endsection