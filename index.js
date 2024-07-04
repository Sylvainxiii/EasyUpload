// Déclarations des variables
const sendBtn = document.querySelector("#send");
const emailDom = document.querySelector('#destEmail');
const emailListDom = document.querySelector('.email-list');
const emailAddDom = document.querySelector('.email-add');

// Vérifie si l'email est correct
const isEmailValid = (email) => {
    return email.toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
}

// Défini l'URL et le formulaire
const url = `${location.origin}/src/upload.php`;
const form = document.querySelector('form');

function isEmptyFile() {
    const file = document.getElementById('fichier');

    if (file.files.length == 0) {
        $('#modalEmptyFile1').modal('show');
    }
}

// Affiche un spinner
function displaySpinner() {
    const spinner = document.getElementById("spin");
    
    spinner.hidden = false;

    setTimeout(() => {
        spinner.hidden = true;
    }, 5000);
}

// Affiche l'État de l'input File
function updateFileLabel() {
    const input = document.getElementById('fichier');
    const fileLabel = document.getElementById('fileNameLabel');
    const files = input.files;

    if (files.length === 0) {
        fileLabel.textContent = 'Choisir des fichiers';
    } else if (files.length === 1) {
        fileLabel.textContent = files[0].name;
    } else {
        const fileNames = Array.from(files).map(file => file.name).join(', ');
        fileLabel.textContent = fileNames;
    }
}

// Evènements
form.addEventListener('change', (event) => {
    event.preventDefault();

    if (event.target.id === 'destEmail') { return };
    let fichier = null
    let destEmail = null
    let sourceEmail = null
    // if emails and files are all filled enable
    fichier = document.querySelector("#fichier").files[0] // monofichier
    destEmail = document.querySelector('.email-list').childNodes.length > 0 ? true : false
    sourceEmail = document.querySelector('#sourceEmail').value

    if (fichier && destEmail && isEmailValid(sourceEmail)) {
        sendBtn.disabled = false
    }
});

// `Enter` event add email to list
emailDom.addEventListener('keydown', (event) => {
    if (event.code === 'Enter' && isEmailValid(emailDom.value)) {
        emailListUpdate(event);
    } else if (event.code === 'Enter') {
        emailDom.reportValidity();
    }
});

emailAddDom.addEventListener('click', (event) => {
    event.preventDefault();

    if (isEmailValid(emailDom.value)) {
        emailListUpdate(event);
    } else {
        emailDom.reportValidity();
    }
});

// updade list email
function emailListUpdate(event) {
    let emailDiv = document.createElement('div');
    emailDiv.textContent = emailDom.value;

    let emailDel = document.createElement('div');
    emailDel.setAttribute('class', 'email-del');
    emailDel.textContent = '❌';

    let emailWrap = document.createElement('div');
    emailWrap.setAttribute('class', 'email-wrap');
    emailWrap.append(emailDiv, emailDel);

    emailListDom.append(emailWrap);

    emailCountDomUpdate();

    emailDom.value = '';
}

// delete email in list
emailListDom.addEventListener('click', (event) => {
    if (event.target.className === 'email-del') {
        event.target.parentNode.remove();
        emailCountDomUpdate();
    }
});

// update emailCountDom
function emailCountDomUpdate() {
    document.querySelector('.email-count').parentElement.innerHTML = emailListDom.childNodes.length > 1 ?
        `Email destinataires: <span class="email-count">${emailListDom.childNodes.length}</span>` :
        `Email destinataire: <span class="email-count">${emailListDom.childNodes.length}</span>`;
}

// Listener sur la soumission du formulaire
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    displaySpinner();
    isEmptyFile();
    // Déclaration des variables    

    const destEmail = [...document.querySelector('.email-list').childNodes].map((value) => {
        return [...value.childNodes][0].textContent;
    });
    const sourceEmail = document.querySelector('#sourceEmail').value
    const files = document.querySelector('[type=file]').files;
    const formData = new FormData();

    formData.append('destEmail', destEmail);
    formData.append('sourceEmail', sourceEmail);

    // Ajoute chaque fichier dans la variable files
    for (let i = 0; i < files.length; i++) {
        let file = files[i]

        formData.append('files[]', file);
    }

    await fetch(url, {
        method: 'POST',
        body: formData,
    }).then((response) => {
        console.log(response)
    })

    // Reset le formulaire
    document.querySelector('#destEmail').value = "";
    document.querySelector('#sourceEmail').value = "";
    document.getElementById('fileNameLabel').textContent = "Choisir des fichiers";
    emailListDom.replaceChildren();
    emailCountDomUpdate();


})

// Effet du nom du site

document.addEventListener('DOMContentLoaded', () => {
    const spans = document.querySelectorAll('.backgroundText span');

    spans.forEach((span, index) => {
        setTimeout(() => {
            span.classList.add('active');
        }, (index + 1) * 250); // L'ajustement du délai d'animation pour chaque span
    });
});
