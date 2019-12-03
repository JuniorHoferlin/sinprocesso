@extends('layouts.imprimir')

@section('conteudo')
    @include('tipo_regra.listagem', ['imprimir' => true])
@endsection