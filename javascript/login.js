const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');
const recipeslist = document.getElementById('recipeslist');
const modalContainer = document.getElementById('modalContainer');
const recipesdetailsContent = document.getElementById('recipes-details-Content');
// Função para abrir o popup
function inpcadastro() {
    window.location.href = "cadastro-index.html";
}

function fecharLogin() {
    window.location.href = "index.html";
}

// Função de hashing
async function digestMessage(message) {
    const msgUint8 = new TextEncoder().encode(message); 
    const hashBuffer = await window.crypto.subtle.digest("SHA-512", msgUint8); 
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map((b) => b.toString(16).padStart(2, "0")).join("");
    return hashHex;
}

function login() {
    const email = document.getElementById("loginEmail").value;
    const password = document.getElementById("loginPassword").value;
    const storedEmail = localStorage.getItem("userEmail");
    const storedHash = localStorage.getItem("senhaHash");

    if (email === storedEmail) {
        digestMessage(password).then(hash => {
            if (hash === storedHash) {
                document.getElementById('loginMsg').innerHTML = "<p>Login bem-sucedido!</p>";
            } else {
                document.getElementById('loginMsg').innerHTML = "<p>Senha incorreta!</p>";
            }
        });
    } else {
        document.getElementById('loginMsg').innerHTML = "<p>Email não encontrado!</p>";
    }
}

function mostrarconversor() {
    document.getElementById('conversor').style.display = 'block';
}

function fecharconversor() {
    document.getElementById('conversor').style.display = 'none';
}

function convertUnits() {
    const quantity = parseFloat(document.getElementById('quantity').value);
    const unitFrom = document.getElementById('unit_from').value;
    const unitTo = document.getElementById('unit_to').value;
  
    let conversionFactor;
    switch (unitFrom) {
      case 'g':
        conversionFactor = 1;
        break;
      case 'kg':
        conversionFactor = 1000;
        break;
      case 'lb':
        conversionFactor = 453.592;
        break;
      case 'oz':
        conversionFactor = 28.3495;
        break;
      case 'ml':
        conversionFactor = 1;
        break;
      case 'l':
        conversionFactor = 1000;
        break;
      case 'colher_de_cha':
        conversionFactor = 4.92892;
        break;
      case 'colher_de_sopa':
        conversionFactor = 14.7868;
        break;
      case 'xicara':
        conversionFactor = 236.588;
        break;
      default:
        conversionFactor = 1;
    }
  
    let result;
    switch (unitTo) {
      case 'g':
        result = quantity * conversionFactor;
        break;
      case 'kg':
        result = quantity * conversionFactor / 1000;
        break;
      case 'lb':
        result = quantity * conversionFactor / 453.592;
        break;
      case 'oz':
        result = quantity * conversionFactor / 28.3495;
        break;
      case 'ml':
        result = quantity * conversionFactor;
        break;
      case 'l':
        result = quantity * conversionFactor / 1000;
        break;
      case 'colher_de_cha':
        result = quantity * conversionFactor / 4.92892;
        break;
      case 'colher_de_sopa':
        result = quantity * conversionFactor / 14.7868;
        break;
      case 'xicara':
        result = quantity * conversionFactor / 236.588;
        break;
      default:
        result = quantity;
    }
  
    document.getElementById('result').textContent = result.toFixed(2);
  }
