<?php

/** Defino o local da classes */
namespace vendor\controller\pdf;

/** Carregamento da classe de gerar PDF */
require_once('./vendor/library/dompdf/autoload.php');

/** Importação de classes */
use Dompdf\Dompdf;
use vendor\controller\main\Main;
class Pdf
{

    /** Vairáveis da classe */
    private $dompdf = null;
    private $Main = null;
    private $preferences = null;
    private $html = null;
    private $dir = null;
    private $name = null;

    public function __construct()
    {

        /** Instânciamento da classe */
        $this->dompdf = new Dompdf();
        $this->Main = new Main();

    }

    /** Método usado para gerar o arquivo pdf */
    public function generate($html, $dir, $name, $preferences)
    {

        /** Decodifico as perguntas */
        $this->html = $html;
        $this->dir = $dir;
        $this->name = $name;
        $this->preferences = $preferences;

        /** Carrego a estrutura montada */
        $this->dompdf->loadHtml($this->html);

        /** Defino o papel e o formato */
        $this->dompdf->setPaper($this->preferences->size, $this->preferences->orientation);

        /** Renderizo o html para pdf */
        $this->dompdf->render();

        /** Verifico se a pasta do arquivo existe */
        if (is_dir($this->dir)) {

            /** Verifico se o arquivo existe */
            if (file_exists($this->dir . '/' . $this->name)) {

                /** Excluo o arquivo existente */
                if (unlink($this->dir . '/' . $this->name)) {

                    /** Gero um arquivo em formato pdf */
                    file_put_contents($this->dir . '/' . $this->name, $this->dompdf->output());

                    /** Retorno o caminho do pdf */
                    return $this->dir . '/' . $this->name;

                }

            } else {

                /** Gero um arquivo em formato pdf */
                file_put_contents($this->dir . '/' . $this->name, $this->dompdf->output());

                /** Retorno o caminho do pdf */
                return $this->dir . '/' . $this->name;

            }

        } else {

            /** Crio a pasta temporário para o arquivo */
            if (mkdir($this->dir, 0777, true)) {

                /** Gero um arquivo em formato pdf */
                file_put_contents($this->dir . '/' . $this->name, $this->dompdf->output());

                /** Retorno o caminho do pdf */
                return $this->dir . '/' . $this->name;

            }

        }

    }

}