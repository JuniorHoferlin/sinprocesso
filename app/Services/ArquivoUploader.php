<?php

namespace App\Services;

use File;
use Illuminate\Http\UploadedFile;
use Exception;
use Log;

class ArquivoUploader
{

    protected $pastaArquivos = '_arquivos/';

    /**
     * Faz upload de um arquivo para o servidor.
     *
     * @param UploadedFile $arquivo
     * @param string pasta
     *
     * @return string Nome do arquivo feito upload.
     */
    public function upload($arquivo, $pasta)
    {
        $nome = $arquivo->getClientOriginalName();
        $destino = $this->pastaArquivos . $pasta . '/';
        $fullPath = public_path($destino . $nome);

        // Trata nome de arquivos repetidos
        if (File::exists($fullPath)) {
            $pathInfo = pathinfo($fullPath);
            $extension = isset($pathInfo['extension']) ? ('.' . $pathInfo['extension']) : '';

            if (preg_match('/(.*?)(\d+)$/', $pathInfo['filename'], $match)) {
                $base = $match[1];
                $number = intVal($match[2]);
            } else {
                $base = $pathInfo['filename'];
                $number = 0;
            }

            do {
                $nome = $base . ++$number . $extension;
                $fullPath = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $nome;
            } while (File::exists($fullPath));
        }

        try {
            $arquivo->move($destino, $nome);
        }
        catch (Exception $e) {
            Log::error($e);

            return false;
        }

        return $destino . $nome;
    }
}