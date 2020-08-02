function sendEmailAnfrage() {
	var form = document.getElementById("anfrageForm");
	spiner("loader")
	submitOff("anfrageFormButton")
	$.ajax({
		type: 'POST',
		url: 'send_form_email.php',
		data: {     
			  typeForm : 'anfrage', 
			note: anfrageForm['hinweis'].value,
			firstName:  anfrageForm['vorname'].value,
			lastName: anfrageForm['nachname'].value,
			email: anfrageForm['eMail'].value,
			address: anfrageForm['strasse'].value,
			postalCode: anfrageForm['postleitzahl'].value,
			location: anfrageForm['ort'].value,
			company: anfrageForm['unternehmen'].value,
			phone: anfrageForm['telefon'].value,
			located: anfrageForm['gefunden'].value
		},
		success: function(data){
			$('#modalAnfrageForm').modal("hide");
			console.log("[INFO] Message sent: ", data); 
			document.getElementById("loader").style.display = "none";  
			document.getElementById("anfrageFormButton").disabled = false;  
			$('#KontaktFormularErfolgreich').modal();
			form.reset();
		},
		error: function(error){
			console.log("[ERROR] Message delivery failed: ", error);       
			$('#KontaktFormularNichtErfolgreich').modal();
			form.reset();
		}
	});    
}

function sendEmailKontakt() {
	var form = document.getElementById("kontaktForm");
	spiner("loadercontactForm")
	submitOff("kontaktFormButton")
	$.ajax({
		type: 'POST',
		url: 'send_form_email.php',
		data: {     
      		typeForm : 'kontakt', 
			firstName:  kontaktForm['vorname'].value,
			lastName: kontaktForm['nachname'].value,
			address: kontaktForm['strasse'].value,
			postalCode: kontaktForm['postleitzahl'].value,
			location: kontaktForm['ort'].value,
			company: kontaktForm['unternehmen'].value,
			email: kontaktForm['eMail'].value,
			phone: kontaktForm['telefon'].value,
			located: kontaktForm['gefunden'].value,
			note: kontaktForm['hinweis'].value
		},
		success: function(data){
			$('#modalKontaktForm').modal("hide");
			console.log("[INFO] Message sent: ", data); 
			document.getElementById("loadercontactForm").style.display = "none";  
			document.getElementById("kontaktFormButton").disabled = false;  
			$('#KontaktFormularErfolgreich').modal();
			form.reset();
		},
		error: function(error){
			console.log("[ERROR] Message delivery failed: ", error);       
			$('#KontaktFormularNichtErfolgreich').modal();
			form.reset();
		}
	});    
}

function sendEmailOrder() {
	var form = document.getElementById("bestellscheinForm");
	spiner("loader")
	submitOff("orderFormButton")
	$.ajax({
		type: 'POST',
		url: 'send_form_email.php',
		data: {     
			  typeForm : 'order', 
			numberOfLicenses:  bestellscheinForm['numberLicense'].value,
			companyName:  bestellscheinForm['firmenname'].value,
			legalForm:  bestellscheinForm['rechtsform'].value,
			salesTax:  bestellscheinForm['ustid'].value,
			salesTaxnr:  bestellscheinForm['ustidnr'].value,
			representative:  bestellscheinForm['vertreter'].value,
			salutation:  bestellscheinForm['anrede'].value,
			firstName: bestellscheinForm['vorname'].value,
			lastName: bestellscheinForm['nachname'].value,
			address: bestellscheinForm['strasse'].value,
			postalCode: bestellscheinForm['postleitzahl'].value,
			location: bestellscheinForm['ort'].value,
			country:  bestellscheinForm['land'].value,
			email: bestellscheinForm['eMail'].value,
			phone: bestellscheinForm['telefon'].value,
			checkboxTerms: bestellscheinForm['checkboxAgb'].checked,
			checkboxWithdrawal: bestellscheinForm['checkboxWiderrufsrecht'].checked,
			checkboxNews: bestellscheinForm['checkboxNewsletter'].checked
		},
		success: function(data){
			$('#modalContactForm').modal("hide");
			console.log("[INFO] Message sent: ", data); 
			document.getElementById("loader").style.display = "none";  
			document.getElementById("orderFormButton").disabled = false;  
			$('#KontaktFormularErfolgreich').modal();
			form.reset();
		},
		error: function(error){
			console.log("[ERROR] Message delivery failed: ", error);       
			$('#KontaktFormularNichtErfolgreich').modal();
			form.reset();
		}
	});    
}
