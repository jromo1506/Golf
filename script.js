




function copiarTexto(event) {
    event.preventDefault()
    // Seleccionar el texto del input
    const texto = document.getElementById('textoACopiar').value;
    
    // Copiar el texto al portapapeles
    navigator.clipboard.writeText(texto)
        .then(() => {
            alert('Texto copiado al portapapeles');
        })
        .catch(err => {
            console.error('Error al copiar el texto: ', err);
    });
}
