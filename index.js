import displaySpinner from "./script.js";
import "./titleAnimation.js";

window.addEventListener('load', () => {
    main();
});

/**
 * default App, invoked in event load
 */
function main() {
    /**
     * Déclarations des variables
     */
    const range = document.createRange();
    const sendBtn = document.querySelector("#send");
    const eMailDom = document.querySelector('#destEmail');
    const eMailListDom = document.querySelector('.email-list');
    const sourceEmailDom = document.querySelector('#sourceEmail');
    const fichierDom = document.querySelector("#fichier");
    const form = document.querySelector('form');
    // Défini l'URL et le formulaire
    const url = `${location.origin}/src/upload.php`;

    /**
     * Evènements
     */
    form.addEventListener('change', (event) => {
        event.preventDefault();

        if (event.target.type === 'file') {
            updateFileName();
        }

        if (event.target.id === eMailDom.id) {
            if (isEmailValid(event.target.value)) {
                eMailListUpdate(event);
            } else {
                event.target.reportValidity();
            }
        }

        enableSendBtn();
    });

    form.addEventListener('click', async (event) => {
        if (event.target.type === 'submit') { return };

        if (event.target.className === 'email-del') {
            event.target.parentNode.remove();
            eMailCountDomUpdate();
            enableSendBtn();
            return;
        }
    });

    // `Enter` event add email to list
    eMailDom.addEventListener('keydown', (event) => {
        const evCode = event.code === 'Enter' || event.code === 'NumpadEnter';
        if (evCode && isEmailValid(eMailDom.value)) {
            event.preventDefault();
            eMailListUpdate(event);
        } else if (evCode) {
            event.preventDefault();
            eMailDom.reportValidity();
        }

        enableSendBtn();
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Déclaration des variables    
        const destEmail = [...eMailListDom.childNodes].map((value) => {
            return [...value.childNodes][0].textContent;
        });
        const files = fichierDom.files;
        const formData = new FormData();

        formData.append('destEmail', destEmail);
        formData.append('sourceEmail', sourceEmailDom.value);

        // Ajoute chaque fichier dans la variable files
        for (let i = 0; i < files.length; i++) {
            let file = files[i]
            formData.append('files[]', file);
        }

        resetForm();
        displaySpinner();
        isEmptyFile();

        await fetch(url, {
            method: 'POST',
            body: formData,
        }).then((response) => {
            console.log(response)
        });

        return;
    });

    // Vérifie si l'email est correct
    const isEmailValid = (email) => {
        return email.toLowerCase().match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    }

    function isEmptyFile() {
        const file = document.getElementById('fichier');

        if (file.files.length == 0) {
            $('#modalEmptyFile1').modal('show');
        }
    }

    function updateFileName() {
        const label = document.getElementById('fileNameLabel');
        const files = fichierDom.files;

        if (files.length === 0) {
            label.textContent = 'Choisir des fichiers';
        } else if (files.length === 1) {
            label.textContent = files[0].name;
        } else {
            let fileNameString = '';
            for (let i = 0; i < files.length; i++) {
                fileNameString += files[i].name;
                if (i !== files.length - 1) {
                    fileNameString += ', ';
                }
            }
            label.textContent = fileNameString;
        }
    }

    // updade list email
    function eMailListUpdate(event) {
        const stringHtml = `<div class="email-wrap"><div>${event.target.value}</div><div class="email-del">❌</div></div>`;
        eMailListDom.appendChild(range.createContextualFragment(stringHtml));

        eMailCountDomUpdate();
        eMailDom.value = '';
    }

    // update eMailCountDom
    function eMailCountDomUpdate() {
        document.querySelector('.email-count').parentElement.innerHTML = eMailListDom.childNodes.length > 1 ?
            `Email destinataires: <span class="email-count">${eMailListDom.childNodes.length}</span>` :
            `Email destinataire: <span class="email-count">${eMailListDom.childNodes.length}</span>`;
    }

    // Reset le formulaire
    function resetForm() {
        eMailDom.value = "";
        sourceEmailDom.value = "";
        document.getElementById('fileNameLabel').textContent = "Choisir des fichiers";
        eMailListDom.replaceChildren();
        eMailCountDomUpdate();
    }

    // Enable btn send
    function enableSendBtn() {
        if (fichierDom.files[0] && sourceEmailDom.value && eMailListDom.childNodes.length > 0) {
            sendBtn.disabled = false;
        } else {
            sendBtn.disabled = true;
        }
    }
}
