@extends('layouts.imprimir')

@section('conteudo')
    @include('grupo_acesso.listagem', ['imprimir' => true])
@endsection