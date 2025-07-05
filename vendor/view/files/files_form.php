<?php

/** Parâmetros de entrada */
$options = (object)json_decode($_POST['OPTIONS']);

/** Gero um Hash Aleatório para não duplicar declarações */
$MainRandomHashResult = $Main->RandomHash();

?>

<script type="text/javascript">

    /** Instânciamento da classe do Toast */
    var _file = new File();

</script>

<div id="FilesZone<?php echo $MainRandomHashResult?>">

    <label for="file" class="drop-container" id="dropContainer">

        <span class="drop-title">

           <?php echo $options->phrase ?>

        </span>

        ou

        <input type="file" id="file" name="file" onchange="_file.prepare('file')" <?php echo !empty($options->accept) ? 'accept="' . $options->accept . '"' : null?> <?php echo $options->multiple ? 'multiple' : null?> data-mysupport-file-preview="<?php echo $options->preview ?>" data-mysupport-file-zone="FilesZone<?php echo $MainRandomHashResult?>">

    </label>

</div>

<script type="text/javascript">

    // Seleciona o elemento HTML com o id "dropContainer" e atribui-o à constante dropContainer
    var dropContainer = document.getElementById("dropContainer");

    // Seleciona o elemento HTML com o id "file" e atribui-o à constante fileInput
    var fileInput = document.getElementById("file");

    // Adiciona um ouvinte de evento para o evento "dragover" no elemento dropContainer
    dropContainer.addEventListener("dragover", (e) => {

        // Previne o comportamento padrão do navegador para permitir a operação de arrastar e soltar
        e.preventDefault();

    }, false);

    // Adiciona um ouvinte de evento para o evento "dragenter" no elemento dropContainer
    dropContainer.addEventListener("dragenter", () => {

        // Adiciona a classe "drag-active" ao elemento dropContainer quando um item é arrastado para dentro dele
        dropContainer.classList.add("drag-active");

    });

    // Adiciona um ouvinte de evento para o evento "dragleave" no elemento dropContainer
    dropContainer.addEventListener("dragleave", () => {

        // Remove a classe "drag-active" do elemento dropContainer quando um item é arrastado para fora dele
        dropContainer.classList.remove("drag-active");

    });

    // Adiciona um ouvinte de evento para o evento "drop" no elemento dropContainer
    dropContainer.addEventListener("drop", (e) => {

        // Previne o comportamento padrão do navegador para permitir a operação de arrastar e soltar
        e.preventDefault();

        // Remove a classe "drag-active" do elemento dropContainer quando um item é solto dentro dele
        dropContainer.classList.remove("drag-active");

        // Define os arquivos arrastados e soltos como os arquivos selecionados no elemento fileInput
        fileInput.files = e.dataTransfer.files;

    });

</script>