<?php

/**
 * Rotas padrões para CRUD simples.
 *
 * @param $controller
 */
function rotasCrud($controller)
{
    Route::get('/', ['uses' => "$controller@index", 'as' => 'index']);
    Route::get('adicionar', ['uses' => "$controller@adicionar", 'as' => 'adicionar']);
    Route::post('adicionar', ['uses' => "$controller@salvar", 'as' => 'adicionar.post']);
    Route::get('alterar/{id}', ['uses' => "$controller@alterar", 'as' => 'alterar']);
    Route::post('alterar/{id}', ['uses' => "$controller@atualizar", 'as' => 'alterar.post']);
    Route::get('excluir/{id}', ['uses' => "$controller@excluir", 'as' => 'excluir']);
}

function formatarTelefone($valor)
{
    $mascara = "(##) #####-####";
    if (strlen($valor) == 10) {
        $mascara = "(##) ####-####";
    }

    return adicionarMascara($valor, $mascara);
}

function formatarData($data, $formato = null)
{
    if (is_null($formato)) {
        $formato = 'd/m/Y';
    }

    $data = str_replace('/', '-', $data);

    return date($formato, strtotime($data));
}

function formatarDataExtenso($data)
{
    Date::setLocale('pt-BR');

    return Date::createFromFormat('Y-m-d H:i:s', $data)->format('l, j F \d\e Y \á\s H\hi');
}

/**
 * Formata um valor para a mascara especificada.
 *
 * @param  string $valor O valor a ser formatado.
 * @param  string $mascara A mascara para aplicar no conteúdo.
 *
 * @return string
 */
function adicionarMascara($valor, $mascara)
{
    if (!empty($valor) && mb_strlen($valor) > 0) {
        $mascarado = '';
        $k = 0;
        $tamanho = strlen($mascara);

        for ($i = 0; $i <= $tamanho - 1; $i++) {
            if ($mascara[$i] == '#') {
                if (isset($valor[$k])) {
                    $mascarado .= $valor[$k++];
                }
            } else {
                if (isset($mascara[$i])) {
                    $mascarado .= $mascara[$i];
                }
            }
        }

        return $mascarado;
    }

    return $valor;
}

/**
 * Formata um número para o formato de CPF.
 *
 * @param string $valor O valor a ser formatado.
 *
 * @return string
 */
function formatarCpf($valor)
{
    return adicionarMascara($valor, '###.###.###-##');
}

/**
 * Remove máscara de um valor específico.
 *
 * @param  string $valor Valor para editar.
 * @param  mixed $outros Caso deseja passar outros valores a serem removidos.
 *
 * @return string
 */
function removerMascara($valor, $outros = null)
{
    $remover = [
        '.', ',', '/', '-', '(', ')', '[', ']', ' ', '+', '_',
    ];

    if (!is_null($outros)) {
        if (!is_array($outros)) {
            $outros = [$outros];
        }

        $remover = array_merge($remover, $outros);
    }

    return str_replace($remover, '', $valor);
}

/**
 * Adiciona mascara BRL em um double.
 *
 * @param  double $valor Valor para formatar.
 *
 * @return string
 */
function formatarDinheiro($valor)
{
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

/**
 * Verifica se o usuário tem pelo menos uma das permissões especificadas.
 *
 * @param array $rotas
 *
 * @return bool
 */
function temAlgumaPermissao($rotas)
{
    foreach ($rotas as $rota) {
        if (\Gate::check($rota)) {
            return true;
        }
    }

    return false;
}

/**
 * Retorna o endereço IP do usuário acessando o site.
 *
 * @return string
 */
function enderecoIp()
{
    $request = Request::instance();
    $request->setTrustedProxies(['127.0.0.1']);

    return $request->getClientIp();
}

function segundosParaIntervalo($seconds = false)
{
    $retorno = "-";
    if ($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");

        $diferenca = $dtF->diff($dtT);
        $retorno = $diferenca->format('%Hh %imin %sseg');;
        if ($diferenca->d > 0) {
            $retorno = $diferenca->format('%a dia(s), ') . $retorno;
        }
    }

    return $retorno;
}

function encontraCorStatusTarefaRelatorio($status)
{
    switch ($status) {
        case "ABERTO":
            return "label-muted";
            break;
        case "PENDENTE":
            return "label-success";
            break;
        case "CONCLUIDO":
            return "label-primary";
            break;
        case "REPORTADA":
            return "label-warning";
            break;
        case "CANCELADO":
            return "label-danger";
            break;
        default:
            return "label-muted";
            break;
    }
}

function encontraCorStatusProcessoRelatorio($status)
{
    switch ($status) {
        case "ABERTO":
            return "label-success";
            break;
        case "FINALIZADO":
            return "label-primary";
            break;
        case "BLOQUEADO":
            return "label-danger";
            break;
        default:
            return "label-muted";
            break;
    }
}

