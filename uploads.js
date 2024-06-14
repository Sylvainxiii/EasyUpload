// Défini l'URL et le formulaire
const url = 'http://localhost/Clone-Weetransfert/src/upload.php';
const form = document.querySelector('form');

// Listener sur la soumission du formulaire
form.addEventListener('submit', (event) => {
    event.preventDefault()
    const files = document.querySelector('[type=file]').files;
    const formData = new FormData();

    // Ajoute chaque fichier dans la variable files
    for (let i = 0; i < files.length; i++) {
        let file = files[i]
    
        formData.append('files[]', file)
    }

    fetch(url, {
        method: 'POST',
        body: formData,
    }).then((response) => {
        console.log(response)
    })
})