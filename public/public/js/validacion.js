let button = document.getElementById('envio');
button.disabled = true;

let p2 = document.getElementById('p2');
p2.disabled = true;

document
.getElementById('p1')
.addEventListener('input', function(evt){
    const campo = evt.target,
    valido = document.getElementById('ver1'),
    regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&#_.+-])([A-Za-z\d$@$!%*?&#_.+-]|[^ ])/;

    if(regex.test(campo.value) && campo.value.length >= 8) {
        valido.innerText = '';
        p2.disabled = false;
    }
    else{
        p2.disabled = true;
        valido.innerText = 'La contraseña debe contener minimo: 8 Caracteres, 1 Mayúscula, 1 Número, 1 Carácter especial';
    }
});

document
.getElementById('p2')
.addEventListener('input', function(evt){
    const camp = evt.target,
    valid = document.getElementById('ver2');

    if(camp.value != document.getElementById('p1').value){
        button.disabled = true;
        valid.innerText = 'Las contraseñas no coinciden';
    }
    else{
        button.disabled = false;
        valid.innerText = '';
    }
});
