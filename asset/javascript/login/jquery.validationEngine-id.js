(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{"required":{
						"regex":"none",
						"alertText":"* Field ini harus diisi",
						"alertTextCheckboxMultiple":"* Harap option dipilih",
						"alertTextCheckboxe":"* Checkbox harus diisi"},
					"length":{
						"regex":"none",
						"alertText":"* Harus diisi antara ",
						"alertText2":" sampai ",
						"alertText3": " karakter"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Please select ",
						"alertText2":" options"},	
					"confirm":{
						"regex":"none",
						"alertText":"* Field yang diisi tidak cocok"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* Nomor telepon tidak cocok"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* Alamat email tidak cocok"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* Tanggal salah, harus ber-format YYYY-MM-DD"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"* Hanya angka"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* Hanya huruf dan angka"},	
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* Hanya huruf"}
					}	
		}
	}
})(jQuery);
$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});