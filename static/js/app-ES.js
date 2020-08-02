(function () {
	"use strict";

	axios.interceptors.response.use(function (res) { return res.data; }, function (error) { return Promise.reject(error); });

	var i18n;

	if ((localStorage.getItem('language') == null) && (navigator.language.substr (0,2) != 'de')) {		
		i18n = new VueI18n({
			locale: localStorage.getItem('language') || 'es',
		});		
	} else {		
		i18n = new VueI18n({
			locale: localStorage.getItem('language') || 'de',
		});
	}

	var loadedLanguages = [];

	function fetchTranslation(lang) { // http://kazupon.github.io/vue-i18n/guide/lazy-loading.html
		return loadedLanguages.includes(lang) ? Promise.resolve() : axios.get('resources/locale-' + lang + '.json').then(function (res) {
			i18n.setLocaleMessage(lang, res);
			loadedLanguages.push(lang);
		});
	}

	fetchTranslation(i18n.locale);

	new Vue({
		el: '#app',
		i18n: i18n,
		data: {
			languages: ['de', 'es'],
		},
		methods: {
			currentLanguage: function (lang) {
				if (!lang) return i18n.locale;
				if (lang == this.languages[0]) {
					document.title = 'CIB fairBrieft: Serienbriefe mit einem Klick kuvertieren und versenden';
				}
				else {
				document.title = 'CIB fairBrieft: Correspondencia online de forma rápida, segura y fácil';
				}
				return fetchTranslation(lang).then(function () {
					i18n.locale = lang;
					axios.defaults.headers.common['Accept-Language'] = lang;
					localStorage.setItem('language', lang);
					window.location.href = '#' + lang;
				})
			},
		}
	});
})();