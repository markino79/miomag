/** 
 *
 */

function clickMarche(valMarche)
{
	document.getElementById('okTipi').style.display = 'none';
	document.getElementById('okModelli').style.display = 'none';
	document.getElementById('destinazioneTipi').innerHTML = '';
	document.getElementById('destinazioneModelli').innerHTML = '';
	document.getElementById('destinazioneConsumabili').innerHTML = '';
	document.getElementById('destinazionePulsante').style.display = 'none';
	getTipi(valMarche);
}

function clickTipi(valMarche, valTipi)
{
	document.getElementById('okModelli').style.display = 'none';
	document.getElementById('destinazioneModelli').innerHTML = '';
	document.getElementById('destinazioneConsumabili').innerHTML = '';
	document.getElementById('destinazionePulsante').style.display = 'none';
	getModelli(valMarche, valTipi);
}

function clickModelli(val)
{	
	if (val != "NONE"){
		document.getElementById('okModelli').style.display = 'block';
		//document.getElementById('destinazionePulsante').style.display = 'block';
		getConsumabili(document.search.marche.value, document.search.tipi.value, document.search.modelli.value)
	}else{
		document.getElementById('okModelli').style.display = 'none';
		document.getElementById('destinazionePulsante').style.display = 'none';
	}
}
	function getMarche()
	{
		var url = 'idprint/ajax';
		var pars = 'start=1';
	
		document.getElementById('idp_loader').style.display = 'block';

		var myAjax = new Ajax.Updater(
					{success:'destinazioneMarche'},
					//'destinazione', 
					url, 
					{
						method: 'get', 
						parameters: pars,
						onSuccess: function(){document.getElementById('idp_loader').style.display = 'none'},
						//onSuccess:function(transport){alert(transport.responseText)},
						onFailure: idp_reportError
					});
	}


	function getTipi(vMarca)
	{
		var url = 'idprint/ajax';
		var pars = 'marca='+vMarca;
		
		document.getElementById('idp_loader').style.display = 'block';
		
		var myAjax = new Ajax.Updater(
					{success:'destinazioneTipi'},
					//'destinazione', 
					url, 
					{
						method: 'get', 
						parameters: pars, 
						onSuccess: function(){document.getElementById('idp_loader').style.display = 'none'; document.getElementById('okMarche').style.display = 'block';},
						//onSuccess:function(transport){alert(transport.responseText)},
						onFailure: idp_reportError
					});
	}


	function getModelli(vMarca, vTipo)
	{
		var url = 'idprint/ajax';
		var pars = 'marca='+vMarca+'&tipo='+vTipo;
		
		document.getElementById('idp_loader').style.display = 'block';

		var myAjax = new Ajax.Updater(
					{success:'destinazioneModelli'},
					//'destinazione', 
					url, 
					{
						method: 'get', 
						parameters: pars, 
						onSuccess: function(){document.getElementById('idp_loader').style.display = 'none'; document.getElementById('okTipi').style.display = 'block';},
						//onSuccess:function(transport){alert(transport.responseText)},
						onFailure: idp_reportError
					});		
	}


	function getConsumabili(vMarca, vTipo, vModello)
	{
		var url = 'idprint/ajax';
		var pars = 'marca='+vMarca+'&tipo='+vTipo+'&modello='+vModello;
	
		document.getElementById('idp_loader').style.display = 'block';

		var myAjax = new Ajax.Updater(
					{success:'destinazioneConsumabili'},
					//'destinazione', 
					url, 
					{
						method: 'get', 
						parameters: pars, 
						onSuccess: function(){document.getElementById('idp_loader').style.display = 'none'},
						//onSuccess:function(transport){alert(transport.responseText)},
						onFailure: idp_reportError
					});
	}


	function idp_reportError(request)
	{
		alert('Errore.');
	}
