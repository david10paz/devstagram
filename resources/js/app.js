//require('./bootstrap');

import { Dropzone } from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
        //Si hemos subido una imagen pero nos falto título o descripción a la hora de mandar el post, 
        //para que al recargar la imagen nos aparezca la que hemos subido en un principio y no se nos quede vacía.
        if (document.querySelector('[name="imagen"]').value.trim()) {
            //Si lo encuentra creamos una constante en la que le definimos un size por defecto y le damos el nombre que se le había genrado
            const imagenPublicada = {}
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value

            //Le añadimos los datos, tanto su info de size y name, como el thumbnail que guarda diciéndole donde esta ubicado
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            //Le añadimos una clase de completado
            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete')
        }
    }
});


/*dropzone.on('sending', function(file, xhr, formData){
    console.log(file);
});*/

dropzone.on('success', function (file, response) {
    console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen;
});

dropzone.on('error', function (file, message) {
    console.log(message);
});

dropzone.on('removedfile', function () {
    console.log("Archivo eliminado");
    //Reseteamos el campo si hay algo ya establecido en su value
    document.querySelector('[name="imagen"]').value = '';
});