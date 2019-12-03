@extends('layouts.imprimir')

@section('conteudo')
    @include('modalidade.listagem', ['imprimir' => true])
@endsection