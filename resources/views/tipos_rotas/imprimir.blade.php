@extends('layouts.imprimir')

@section('conteudo')
    @include('tipos_rotas.listagem', ['imprimir' => true])
@endsection