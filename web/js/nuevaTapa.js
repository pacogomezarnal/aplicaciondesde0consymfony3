//Funciones copiadas de Mozilla DEveloper
var fileTypes = [
  'image/jpeg',
  'image/pjpeg',
  'image/png'
]

function validFileType(file) {
  for(var i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }
  return false;
}
function onChange(event) {
  var file = event.target.files[0];
  if(validFileType(file)) {
    //Cambiamos el Thumb
    var tapaThumb = document.getElementById('tapaThumb');
    tapaThumb.src = window.URL.createObjectURL(file);
  }
}
