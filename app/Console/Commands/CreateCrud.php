<?php

namespace App\Console\Commands;

use App\Services\Crud\CriaModel;
use App\Services\Crud\CriarController;
use App\Services\Crud\CriaRequest;
use App\Services\Crud\CriarRelatorio;
use App\Services\Crud\CriaViews;
use Illuminate\Console\Command;

class CreateCrud extends Command
{

    protected $signature = 'create-crud';

    protected $description = 'Cria um crud default. by Mauricio';

    /**
     * @var CriaViews
     */
    private $criaViews;

    /**
     * @var CriaModel
     */
    private $criaModel;

    /**
     * @var CriaRequest
     */
    private $criaRequest;

    /**
     * @var CriarController
     */
    private $criarController;

    /**
     * @var CriarRelatorio
     */
    private $criarRelatorio;

    public function __construct(
        CriaViews $criaViews,
        CriaModel $criaModel,
        CriaRequest $criaRequest,
        CriarController $criarController,
        CriarRelatorio $criarRelatorio
    ) {
        parent::__construct();

        $this->criaViews = $criaViews;
        $this->criaModel = $criaModel;
        $this->criaRequest = $criaRequest;
        $this->criarController = $criarController;
        $this->criarRelatorio = $criarRelatorio;
    }

    public function handle()
    {
        while (true) {
            $tabela = $this->ask("Qual a tabela?");
            $titulo = $this->ask("Defina o titulo do seu CRUD");
            $routeAs = $this->ask("[ROTA] Qual o alias (as) da rota?");
            $colunasLista = $this->ask("Separadas por ';',\n Defina quais colunas deve aparecer na lista com suas respectivas labels... \n Exemplo: coluna1:Label 1;coluna2:Label 2;coluna3:Label 3");
            $camposForm = $this->ask("Separadas por ';',\n Defina quais colunas deve aparecer no seu formulario suas respectivas labels... \n Exemplo: coluna1:Label 1;coluna2:Label 2;coluna3:Label 3");

            echo "\n\n";
            echo "##############################################################\n";
            echo "####################### Conferir dados #######################\n";
            echo "##############################################################\n";
            echo "\n\n";
            echo "Tabela --------------------" . $tabela . "\n";
            echo "Titulo CRUD ---------------" . $titulo . "\n";
            echo "Alias (as) Rota -----------" . $routeAs . "\n";
            echo "Colunas da lista ----------" . $colunasLista . "\n";
            echo "Colunas da formulario -----" . $camposForm . "\n";


            echo "\n\n";

            $confirma = $this->ask("Confirma os dados abaixo (y/n)?");

            if (strtolower($confirma) != "y") {
                echo "\n\n";
                echo "##############################################################\n";
                echo "################## Reiniciando processo ######################\n";
                echo "##############################################################\n";
                echo "\n\n";
            } else {
                echo "\n\n";
                echo "GERANDO INFORMACOES.....................\n";
                break;
            }
        }

        try {
            // Primeira coisa que fazemos é criar as views
            $this->criaViews->criar($tabela, $titulo, $routeAs, $camposForm, $colunasLista);

            // Agora vamos criar o model
            $this->criaModel->criar($tabela);

            // Criamos o request para validação dos campos ao salvar o formulário
            $this->criaRequest->criar($tabela, $camposForm);

            // Agora o controller
            $this->criarController->criar($tabela, $titulo, $routeAs);

            // E por ultimo criamos o arquivo que é responsavel pelo Relatório (pela listagem dos registros na tabela)
            $this->criarRelatorio->criar($titulo, $tabela, $camposForm);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
