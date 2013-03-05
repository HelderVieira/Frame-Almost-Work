function traduzDiaDaSemana(dia) {
  if (dia == 0) {
    return "Sabado";
  } else if (dia == 1) {
    return "Domingo";
  } else if (dia == 2) {
    return "Segunda-feira";
  } else if (dia == 3) {
    return "Terca-feira";
  } else if (dia == 4) {
    return "Quarta-feira";
  } else if (dia == 5) {
    return "Quinta-feira";
  } else if (dia == 6) {
    return "Sexta-feira";
  }
}

function formata_data(campo){
	campo.value = filtra_campo(campo);
	vr = campo.value;
	tam = vr.length;

	if ((tam > 2) && (tam < 5)) {
		campo.value = vr.substr(0, (tam - 2)) + '/' + vr.substr((tam - 2), tam);
	}
	
	if ((tam >= 5) && (tam <= 10)) {
		campo.value = vr.substr(0, 2) + '/' + vr.substr(2, 2) + '/' + vr.substr(4, 4); 
  }
  
}

function filtra_campo(campo){
	var s = "";
	var cp = "";
	vr = campo.value;
	tam = vr.length;

	for (i = 0; i < tam ; i++) {  
		if ((vr.substring(i,(i + 1)) != "/") && (vr.substring(i,(i + 1)) != "-") && (vr.substring(i,(i + 1)) != ".") && (vr.substring(i,(i + 1)) != ",")){
		 	s = s + vr.substring(i,(i + 1));
		}
	}
	campo.value = s;
	return cp = campo.value
}
   
function IsValidDate(data){
  var regexp_digitos = /\D+/;   
  var dia=data.substring(0,2);
  var mes=data.substring(3,5);
  var ano=data.substring(6,10);

  if ((dia == "00") && (mes == "00") && (ano == "0000")){
    return false;
  }

  if (regexp_digitos.test(dia + mes + ano)){
    return false;
  }

  dia = parseInt(dia);
  mes = parseInt(mes);
  ano = parseInt(ano);

  if (dia > 31){
    return false;
  }

  if (mes > 12){
    return false;
  }

  if (((ano % 4 == 0) & (ano % 100 == 0) & (ano % 400 != 0)) | (ano % 4 != 0)){
    if ((dia == 29) && (mes == 2)){
      return false;
    }
  }

  if ((dia >= 30) && (mes == 2)){
    return false;
  }

  if (dia == 31){
    if ((mes == 4) || (mes == 6) || (mes == 9) || (mes == 11)){
      return false;
    }
  }

  return true;
}

