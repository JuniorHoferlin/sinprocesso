<div class="navbar-collapse collapse" id="navbar">
    <ul class="nav-top-menu nav navbar-nav">
        <li class="active">
            <a href="{{ route('home') }}">
                Dashboard
            </a>
        </li>
        @can('processos.novo')
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Novo processo
                    <span class="caret"></span>
                </a>

                <ul role="menu" class="dropdown-menu">
                    @foreach($tiposProcessos as $tipo)
                        <li>
                            <a href="{{ route('processos.novo', $tipo->id) }}" class="abrir-processo" data-tr="{{ $tipo->tr }}">{{ $tipo->descricao }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endcan

        @if (temAlgumaPermissao(['processos.index', 'tipo_processo.index', 'tarefas.index','documento_padrao.index','formularios.index']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Processos
                    <span class="caret"></span>
                </a>

                <ul role="menu" class="dropdown-menu">
                    @can('processos.index')
                        <li><a href="{{ route('processos.index') }}">Gerenciar processos</a></li>
                    @endcan

                    @can('tipo_processo.index')
                        <li><a href="{{ route('tipo_processo.index') }}">Tipos de processo</a></li>
                    @endcan

                    @can('tarefas.index')
                        <li><a href="{{ route('tarefas.index') }}">Gerenciar tarefas</a></li>
                    @endcan

                    @can('documento_padrao.index')
                        <li><a href="{{ route('documento_padrao.index') }}">Documento padrão</a></li>
                    @endcan

                    @can('formularios.index')
                        <li><a href="{{ route('formularios.index') }}">Formulários</a></li>
                    @endcan

                    @can('modalidade.index')
                        <li><a href="{{ route('modalidade.index') }}">Modalidades</a></li>
                    @endcan
                </ul>
            </li>
        @endif

        @can('minhas_tarefas')
            <li><a href="{{ route('minhas_tarefas') }}">Minhas tarefas</a></li>
        @endcan

        @if (temAlgumaPermissao(['areas.index', 'grupo_acesso.index']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Áreas
                    <span class="caret"></span>
                </a>
                <ul role="menu" class="dropdown-menu">
                    @can('areas.index')
                        <li><a href="{{ route('areas.index') }}">Gerenciar áreas</a></li>
                    @endcan

                    @can('grupo_acesso.index')
                        <li><a href="{{ route('grupo_acesso.index') }}">Grupos de acesso</a></li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (temAlgumaPermissao(['termo_referencia.index', 'insumo.index']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Termo de referência <span class="caret"></span>
                </a>

                <ul role="menu" class="dropdown-menu">
                    @can('termo_referencia.index')
                        <li><a href="{{ route('termo_referencia.index') }}">Gerenciar termo de referência</a></li>
                    @endcan

                    @can('insumo.index')
                        <li><a href="{{ route('insumo.index') }}">Gerenciar insumos</a></li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (temAlgumaPermissao(['auditoria.index', 'andamento_tarefa.index']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Relatórios
                    <span class="caret"></span>
                </a>

                <ul role="menu" class="dropdown-menu">

                    @can('andamento_tarefa.index')
                        <li><a href="{{ route('andamento_tarefa.index') }}">Tempo médio das tarefas</a></li>
                    @endcan

                    @can('insumo_processo.index')
                        <li><a href="{{ route('insumo_processo.index') }}">Insumos por processo</a></li>
                    @endcan

                    @can('informacao_area.index')
                        <li><a href="{{ route('informacao_area.index') }}">Processo por área</a></li>
                    @endcan

                    <li class="nav-divider"></li>

                    @can('auditoria.index')
                        <li><a href="{{ route('auditoria.index') }}">Auditoria</a></li>
                    @endcan
                </ul>
            </li>
        @endif
    </ul>


    <ul class="nav-top-menu nav navbar-top-links navbar-right">
        @can('suporte.index')
            <li><a href="{{ route('suporte.index') }}" class="link-config">Suporte</a></li>
        @endcan

        @if (temAlgumaPermissao(['feriados.index', 'tipo_regra.index', 'tipos_rotas.index', 'rotas.index','usuarios.index', 'funcoes.index', 'grupo_acesso.gerenciar_permissoes']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Configurações
                    <span class="caret"></span>
                </a>

                <ul role="menu" class="dropdown-menu">
                    @can('feriados.index')
                        <li><a href="{{ route('feriados.index') }}">Feriados</a></li>
                    @endcan

                    @can('tipo_regra.index')
                        <li><a href="{{ route('tipo_regra.index') }}">Tipo de regra</a></li>
                    @endcan

                    <li class="nav-divider"></li>

                    @can('usuarios.index')
                        <li><a href="{{ route('usuarios.index') }}">Usuários</a></li>
                    @endcan

                    @can('grupo_acesso.gerenciar_permissoes')
                        <li><a href="{{ route('grupo_acesso.gerenciar_permissoes') }}">Permissões</a></li>
                    @endcan

                    @can('funcoes.index')
                        <li><a href="{{ route('funcoes.index') }}">Funções</a></li>
                    @endcan

                    @can('tipos_rotas.index')
                        <li><a href="{{ route('tipos_rotas.index') }}">Tipos de Rotas</a></li>
                    @endcan

                    @can('rotas.index')
                        <li><a href="{{ route('rotas.index') }}">Rotas</a></li>
                    @endcan
                </ul>
            </li>
        @endif

        <li>
            <a href="#">
                <i class="fa fa-user"></i> {{ auth()->user()->primeiroNome }}
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                <i class="fa fa-sign-out"></i> Sair
            </a>
        </li>
    </ul>
</div>