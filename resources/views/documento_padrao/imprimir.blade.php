@extends('layouts.imprimir')

@section('conteudo')
    @include('documento_padrao.listagem', ['imprimir' => true])
@endsection