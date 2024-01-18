/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


/*ESTE ES EL CODIGO DEL MODAL*/

const openModalButtons = document.querySelectorAll('.deleteBtn');
const modal = document.getElementById('modalElimina');
const closeModalButtons = modal.querySelectorAll('.btn-close, .btn-secondary');
const confirmButton = modal.querySelector('.btn-danger');
const darkOverlay = document.getElementById('darkOverlay');
let entryIdToDelete = null;

function openModal() {
    modal.classList.add('show');
    modal.style.display = 'block';
    darkOverlay.style.display = 'block'; // Muestra el fondo oscuro
    document.body.classList.add('modal-open');
}

function closeModal() {
    modal.classList.remove('show');
    modal.style.display = 'none';
    darkOverlay.style.display = 'none'; // Oculta el fondo oscuro
    document.body.classList.remove('modal-open');
}

function eliminarElemento() {
    if (entryIdToDelete) {
        document.getElementById('entryIdToDelete').value = entryIdToDelete;
        document.getElementById('eliminarForm').submit();
        closeModal();
    }
}

openModalButtons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        entryIdToDelete = button.getAttribute('data-entry-id');
        openModal();
    });
});

closeModalButtons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        closeModal();
    });
});

confirmButton.addEventListener('click', (e) => {
    e.preventDefault();
    eliminarElemento();
});