// Effet du nom du site
document.addEventListener("DOMContentLoaded", () => {
  const spans = document.querySelectorAll(".backgroundText span");

  spans.forEach((span, index) => {
    setTimeout(() => {
      span.classList.add("active");
    }, (index + 1) * 250); // L'ajustement du délai d'animation pour chaque span
  });
});

window.addEventListener("load", () => {
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
  const emailDestinataireDom = document.querySelector("#destEmail");
  const emailExpediteurDom = document.querySelector("#expediteurEmail");
  const eMailListDom = document.querySelector(".email-list");
  const fichierDom = document.querySelector("#fichier");
  const form = document.querySelector("form");
  const messageEmailTextareaDom = document.querySelector(
    "#messageEmailTextarea"
  );
  // Défini l'URL et le formulaire
  const url = `${location.origin}/src/upload.php`;

  /**
   * Evènements
   */
  function handleFormChangeOrClick(event) {
    if (event.type === "change") {
      event.preventDefault();

      if (event.target.type === "file") {
        updateFileName();
      }

      if (event.target.id === emailDestinataireDom.id) {
        if (isEmailValid(event.target.value)) {
          eMailListUpdate(event);
        } else {
          event.target.reportValidity();
        }
      }

      if (event.target.id === emailExpediteurDom.id) {
        if (!isEmailValid(event.target.value)) {
          event.target.reportValidity();
        }
      }
    } else if (event.type === "click") {
      if (event.target.type === "submit") {
        return;
      }

      if (event.target.className === "email-del") {
        event.target.parentNode.remove();
        eMailCountDomUpdate();
      }
    }

    enableSendBtn();
  }

  form.addEventListener("change", handleFormChangeOrClick);
  form.addEventListener("click", handleFormChangeOrClick);

  // `Enter` event add email to list
  emailDestinataireDom.addEventListener("keydown", (event) => {
    const eventCode = event.code === "Enter" || event.code === "NumpadEnter";
    if (eventCode && isEmailValid(emailDestinataireDom.value)) {
      event.preventDefault();
      eMailListUpdate(event);
    } else if (eventCode) {
      event.preventDefault();
      emailDestinataireDom.reportValidity();
    }
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    // Déclaration des variables
    const destEmail = [...eMailListDom.childNodes].map((value) => {
      return [...value.childNodes][0].textContent;
    });
    const files = fichierDom.files;
    const formData = new FormData();

    formData.append("destEmail", destEmail);
    formData.append("expediteurEmail", emailExpediteurDom.value);
    formData.append("messageEmail", messageEmailTextareaDom.value);

    // Ajoute chaque fichier dans la variable files
    for (let i = 0; i < files.length; i++) {
      let file = files[i];
      formData.append("files[]", file);
    }

    displaySpinner();
    resetForm();

    await fetch(url, {
      method: "POST",
      body: formData,
    }).then((response) => {
      console.log(response);
    });

    return;
  });

  // Vérifie si l'email est correct
  const isEmailValid = (email) => {
    return email
      .toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  };

  function isEmptyFile() {
    const file = document.getElementById("fichier");

    if (file.files.length == 0) {
      $("#modalEmptyFile1").modal("show");
    }
  }

  function updateFileName() {
    const input = document.getElementById("fichier");
    const fileLabel = document.getElementById("fileNameLabel");
    const files = input.files;

    if (files.length === 0) {
      fileLabel.textContent = "Choisir des fichiers";
    } else if (files.length === 1) {
      fileLabel.textContent = files[0].name;
    } else {
      const fileNames = Array.from(files)
        .map((file) => file.name)
        .join(", ");
      fileLabel.textContent = fileNames;
    }
  }

  // updade list email
  function eMailListUpdate(event) {
    const stringHtml = `<div class="email-wrap"><div>${event.target.value}</div><div class="email-del">❌</div></div>`;
    eMailListDom.appendChild(range.createContextualFragment(stringHtml));

    eMailCountDomUpdate();
    emailDestinataireDom.value = "";
  }

  // update eMailCountDom
  function eMailCountDomUpdate() {
    document.querySelector(".email-count").parentElement.innerHTML =
      eMailListDom.childNodes.length > 1
        ? `Email destinataires: <span class="email-count">${eMailListDom.childNodes.length}</span>`
        : `Email destinataire: <span class="email-count">${eMailListDom.childNodes.length}</span>`;
  }

  // Reset le formulaire
  function resetForm() {
    var fileInput = document.getElementById("fichier");
    fileInput.value = "";
    emailDestinataireDom.value = "";
    emailExpediteurDom.value = "";
    document.getElementById("fileNameLabel").textContent =
      "Choisir des fichiers";
    eMailListDom.replaceChildren();
    eMailCountDomUpdate();
    messageEmailTextareaDom.value = "";
    sendBtn.disabled = true;
  }

  // Enable btn send
  function enableSendBtn() {
    if (
      fichierDom.files[0] &&
      isEmailValid(emailExpediteurDom.value) &&
      eMailListDom.childNodes.length > 0
    ) {
      sendBtn.disabled = false;
    } else {
      sendBtn.disabled = true;
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
}
