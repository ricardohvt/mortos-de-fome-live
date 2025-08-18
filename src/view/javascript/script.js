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

  