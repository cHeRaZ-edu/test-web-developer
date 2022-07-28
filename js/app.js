$(function () {
    let personalList = [];
    const formSubirPersonal = $("#formSubirPersonal");
    formSubirPersonal[0].addEventListener("submit", function (e) {
        e.preventDefault();
        let personal = {};
        debugger;
        personal.fullName = $("#inputFullName").val();
        personal.fechaNacimiento = $("#inputFechaNacimiento").val();
        personal.edad = $("#inputEdad").val();
        personal.genero = $("#selectGenero").val();
        personal.email = $("#inputEmail").val();
        
        
        let modal = $("#modalPersonal");
        let title = $(".modal-title");
        let content = $(".modal-body");
        title.text("Subir Personal");
        content.text("Subiendo personal ...");
        modal.modal("show");
        let btnAccept = modal.find("#btnAccept");
        btnAccept.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Espere`);
        setTimeout(function () {
            let xhr = new XMLHttpRequest();
            let form = new FormData();
            //Enviarlo en formato JSON
            form.append("personal", JSON.stringify(personal));
            xhr.open("POST", "/subirpersonal.php");
            xhr.onreadystatechange = function () {
                if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                    let res = JSON.parse(xhr.response);
                    if(isErrorServer(res))
                        return;
                    content.html(res.message);
                    btnAccept.text("Aceptar");
                    btnAccept.click(function () {
                        modal.modal("hide");
                    });
                    personalList.push(res.personal);
                    actualizarLista();
                }
            }
            xhr.send(form);
        },1000);
        
    });

    function actualizarLista() {
        let listUL = $("#list-personal");
        listUL.empty();
        personalList.map((personal) => {
            listUL.append($(`<li class="list-group-item">${personal.nombre_completo}</li>`));
        });
    }

    function consultarLista() {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/consultarpersonal.php");
        xhr.onreadystatechange = function () {
            if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200)  {
                console.log(xhr.response);
                let res = JSON.parse(xhr.response);
                if(isErrorServer(res))
                    return;
                personalList = res.personalArray;
                if(personalList.length > 0) {
                    let modal = $("#modalPersonal");
                    let title = $(".modal-title");
                    let content = $(".modal-body");
                    title.text("Personal Actualizado");
                    content.text(res.message);
                    let btnAccept = modal.find("#btnAccept");
                    btnAccept.text("Aceptar");
                    modal.modal("show");
                    btnAccept.click(function () {
                        modal.modal("hide");
                    });
                }
                actualizarLista();
            }
        }
        xhr.send();
    }
    consultarLista();
    function isErrorServer(res) {
        if(res.status == 500) {
            let modal = $("#modalPersonal");
            let title = $(".modal-title");
            let content = $(".modal-body");
            title.text("Error en la base de datos");
            content.text(res.message);
            let btnAccept = modal.find("#btnAccept");
            btnAccept.text("Aceptar");
            modal.modal("show");
            btnAccept.click(function () {
                modal.modal("hide");
            });
            return true;
        }
        return false;
    }
});