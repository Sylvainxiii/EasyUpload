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