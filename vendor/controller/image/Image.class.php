<?php

namespace vendor\controller\image;

require_once('./vendor/library/wideImage/WideImage.php');

class Image
{

    /** Parâmetros da Classes */
    private $wideImage = null;
    private $path = null;
    private $name = null;
    private $preferences = null;

    /** Método Construtor */
    public function __construct()
    {

        /** Instanciamento do manipulador da imagem **/
        $this->wideImage = new \WideImage();

    }

    public function handling(string $path, string $name, object $preferences): void
    {

        /** Parâmetros de entrada **/
        $this->path = $path;
        $this->name = $name;
        $this->preferences = $preferences;

        /** Pego a extensão do arquivo */
        $extension = pathinfo($this->path . '/' . $this->name, PATHINFO_EXTENSION);

        /** Corto a imagem para icone **/
        $this->wideImage = \WideImage::load($this->path . '/' . $this->name);
        $this->wideImage = $this->wideImage->resize($this->preferences->width, $this->preferences->height, 'outside');
        $this->wideImage = $this->wideImage->crop('center', 'center', $this->preferences->width, $this->preferences->height);
        $this->wideImage = $this->wideImage->saveToFile($this->path . '/' . $this->name, ($extension === 'png' ? $this->preferences->quality_png : $this->preferences->quality_jpg));

    }

    /** Método Destrutor */
    public function __destruct()
    {

        /** Limpo o caminho atual */
        $this->path = null;

        /** Finalizo o instanciamento do manipulador da imagem **/
        $this->wideImage = null;

        /** Limpo o nome da imagem */
        $this->name = null;

    }

}