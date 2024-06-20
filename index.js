const sendBtn = document.querySelector("#send")
const isEmailValid = (email) => {

    return email.toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        );
    }
// Défini l'URL et le formulaire
const url = 'http://Wetransfert.test/src/upload.php';
const form = document.querySelector('form');

function updateFileName() {
    const input = document.getElementById('fichier');
    const label = document.getElementById('fileNameLabel');
    const files = input.files;

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

form.addEventListener('change', (event) => {
    let fichier = null
    let destEmail = null
    let sourceEmail = null
    // if emails and files are all filled enable
    fichier = document.querySelector("#fichier").files[0] // monofichier
    destEmail = document.querySelector('#destEmail').value
    sourceEmail = document.querySelector('#sourceEmail').value

    if (fichier && isEmailValid(destEmail) && isEmailValid(sourceEmail)) {
        sendBtn.disabled = false
    }

})

// Listener sur la soumission du formulaire
form.addEventListener('submit', (event) => {
    event.preventDefault()
    const destEmail = document.querySelector('#destEmail').value
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

    fetch(url, {
        method: 'POST',
        body: formData,
    }).then((response) => {
        console.log(response)
    })
    
    document.querySelector('#destEmail').value = "";
    document.querySelector('#sourceEmail').value = "";
    document.getElementById('fileNameLabel').textContent = "Choisir des fichiers";
})