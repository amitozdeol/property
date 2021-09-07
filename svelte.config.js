/** @type {import('@sveltejs/kit').Config} */
const config = {
	kit: {
		// hydrate the <div id="app"> element in src/app.html
		target: '#app',
        files: {
			assets: 'public',
			routes: 'resources/js/routes',
			template: 'resources/views/dashboard.blade.php'
		},
	}
};

export default config;
