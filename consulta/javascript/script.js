function formatarCPF(valor){
			valor = valor.replace(/\D/g, '');
			
			if(valor.length > 3){
				valor = valor.substring(0,3) + '.' + valor.substring(3);
			}
			if(valor.length > 7){
				valor = valor.substring(0,7) + '.' + valor.substring(7);
			}
			if(valor.length > 11){
				valor = valor.substring(0,11) + '.' + valor.substring(11,13);
			}

			return valor
		}

		function formatarRG(valor){
			valor = valor.replace(/\D/g, '');
			
			if(valor.length > 3){
				valor = valor.substring(0,2) + '.' + valor.substring(2);
			}
			if(valor.length > 6){
				valor = valor.substring(0,6) + '.' + valor.substring(6);
			}
			if(valor.length > 10){
				valor = valor.substring(0,10) + '.' + valor.substring(10);
			}
			if(valor.length > 11){
				valor = valor.substring(0,10) + '-' + valor.substring(8,9);
			}

			return valor
		}

		document.addEventListener('DOMContentLoaded', function() {
			const turma = document.getElementById('turma');
			const professor = document.getElementById('professor');

			const professores = {
	  				'1': 'Magali',
	  				'2': 'Fabiana',
	  				'3': 'Edileusa',
	  				'4': 'Edna',
	  				'5': 'Adria',
	 				'6': 'Thiago'
	 		};

			turma.addEventListener('change', function(){
				professor.value = professores[turma.value] || "";
			});
		});