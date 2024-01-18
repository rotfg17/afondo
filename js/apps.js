/*Este codigo es para el sidebar*/
// Obtén referencias a los elementos relevantes
// Selecciona elementos del DOM usando clases y etiquetas
const sidebar = document.querySelector(".sidebar"); // Elemento de la barra lateral
const cross = document.querySelector(".fa-xmark"); // Elemento para cerrar la barra lateral
const black = document.querySelector(".black"); // Fondo oscuro detrás de la barra lateral
const sidebtn = document.querySelector(".second-1"); // Botón para abrir la barra lateral

// Agrega un evento de clic al botón "sidebtn" para abrir la barra lateral
sidebtn.addEventListener("click", () => {
    openSidebar();
});

// Agrega eventos de clic para cerrar la barra lateral al hacer clic en la "X" o el fondo oscuro
cross.addEventListener("click", () => {
    closeSidebar();
});

black.addEventListener("click", () => {
    closeSidebar();
});

// Selecciona más elementos del DOM
const sign = document.querySelector(".ac"); // Elemento de "ac"
const tri = document.querySelector(".triangle"); // Elemento de "triangle"
const signin = document.querySelector(".hdn-sign"); // Elemento para iniciar sesión
const close = document.querySelector(".fa-xmark"); // Elemento para cerrar el cuadro de inicio de sesión

// Función para abrir la barra lateral
function openSidebar() {
    sidebar.classList.add("active"); // Agrega la clase "active" para mostrar la barra lateral
    cross.classList.add("active"); // Agrega la clase "active" para mostrar el botón de cerrar
    black.classList.add("active"); // Agrega la clase "active" para mostrar el fondo oscuro
    document.body.classList.add("stop-scroll"); // Agrega una clase para evitar el desplazamiento del cuerpo
}

// Función para cerrar la barra lateral
function closeSidebar() {
    sidebar.classList.remove("active"); // Quita la clase "active" para ocultar la barra lateral
    cross.classList.remove("active"); // Quita la clase "active" para ocultar el botón de cerrar
    black.classList.remove("active"); // Quita la clase "active" para ocultar el fondo oscuro
    document.body.classList.remove("stop-scroll"); // Quita la clase para permitir el desplazamiento del cuerpo
}

// Obtener la hora actual de la República Dominicana
function getDominicanRepublicTime() {
    const date = new Date();
    const utc = date.getTime() + date.getTimezoneOffset() * 60000;
    const drtOffset = -4; // Offset horario de República Dominicana (UTC-4)
    const dominicanRepublicTime = new Date(utc + 3600000 * drtOffset);
    return dominicanRepublicTime;
}

// Formatear la hora y actualizar el contenido del elemento HTML
function updateCurrentDate() {
    const currentDateElement = document.getElementById("current_date");
    const dominicanRepublicTime = getDominicanRepublicTime();
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', timeZoneName: 'short' };
    currentDateElement.textContent = dominicanRepublicTime.toLocaleString('es-DO', options);
}

// Llamar a la función para actualizar la hora cada segundo
setInterval(updateCurrentDate, 1000);

// Llamar a la función una vez al cargar la página
updateCurrentDate();


//ESTE ES EL CODIGO DEL FORMULARIO DE CONTACTO//
//Contact Form in PHP
const form = document.querySelector("form"),
statusTxt = form.querySelector(".button-area span");
form.onsubmit = (e)=>{
  e.preventDefault();
  statusTxt.style.color = "#0D6EFD";
  statusTxt.style.display = "block";
  statusTxt.innerText = "Sending your message...";
  form.classList.add("disabled");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "message.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState == 4 && xhr.status == 200){
      let response = xhr.response;
      if(response.indexOf("required") != -1 || response.indexOf("valid") != -1 || response.indexOf("failed") != -1){
        statusTxt.style.color = "red";
      }else{
        form.reset();
        setTimeout(()=>{
          statusTxt.style.display = "none";
        }, 3000);
      }
      statusTxt.innerText = response;
      form.classList.remove("disabled");
    }
  }
  let formData = new FormData(form);
  xhr.send(formData);
}