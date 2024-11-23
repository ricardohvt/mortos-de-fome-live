const searchInput = document.getElementById('searchInput');
const searchButton = document.getElementById('searchButton');
const recipeslist = document.getElementById('recipeslist');
const modalContainer = document.getElementById('modalContainer');
const recipesdetailsContent = document.getElementById('recipes-details-Content');
// Função para abrir o popup
function inpcadastro() {
    document.getElementById('popup').style.display = 'block';
    document.getElementById('loginPopup').style.display = 'none';
}

// Função para fechar o popup
function fecharCadastro() {
    document.getElementById('popup').style.display = 'none';
}

// Máscara para o campo de telefone
document.getElementById('tel').addEventListener('input', function (e) {
    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
    e.target.value = !x[2] ? x[1] : `(${x[1]}) ${x[2]}${x[3] ? '-' + x[3] : ''}`;
});

// Função de hashing
async function digestMessage(message) {
    const msgUint8 = new TextEncoder().encode(message); 
    const hashBuffer = await window.crypto.subtle.digest("SHA-512", msgUint8); 
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map((b) => b.toString(16).padStart(2, "0")).join("");
    return hashHex;
}

// Função de cadastro
async function cadastro() {
    const password = document.getElementById("password").value;
    const confPassword = document.getElementById("confpswd").value;
    const email = document.getElementById("email").value;
    const username = document.getElementById("username").value;
    const telefone = document.getElementById("tel").value;
    var a = document.getElementById('h1d');
    if (password === confPassword) {
        const hash = await digestMessage(password); 
        localStorage.setItem("senhaHash", hash);
        localStorage.setItem("telefone", telefone);
        localStorage.setItem("userEmail", email);
        localStorage.setItem("nome", username);
        a.innerHTML = ("<p>Seu cadastro foi concluído!</p>");
    } else {
        a.innerHTML = ("<p>As senhas não são iguais!</p>");
    }
}

// Função para abrir o popup de login
function inpLogin() {
    document.getElementById('loginPopup').style.display = 'block';
    document.getElementById('popup').style.display = 'none';
}

// Função para fechar o popup de login
function fecharLogin() {
    document.getElementById('loginPopup').style.display = 'none';
}

// Função de login
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
// conversor

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

  