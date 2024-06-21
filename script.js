 function displaySpinner(){
    // Affiche un spinner
    setTimeout(function(){
        document.getElementById("spin").hidden = false;
    });

    setTimeout(function(){
        document.getElementById("spin").hidden = true;
    }, 5000);
    }

 