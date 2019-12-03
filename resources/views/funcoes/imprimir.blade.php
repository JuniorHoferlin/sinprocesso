@extends('layouts.imprimir')

@section('conteudo')
    @include('funcoes.listagem', ['imprimir' => true])
@endsection