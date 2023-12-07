var CACHE_NAME = "menses-cache";
var CACHED_URLS = [

//manifest file
"./manifest.json",

//HTML files
"./index.html",
"./f1.html",
"./f2.html",
"./f3.html",
"./setnoti.html",
"./main.html",
"./menu.html",
"./calendar.html",
"./cycloscope.html",
"./inventory.html",
"./graph.html",
"./tips.html",
"./myths.html",
"./science.html",
"./settings.html",
"./did_p_start.html",
"./generic.html",
"./redirect.html",

// Stylesheets
"./css/background.css",
"./css/card.css",
"./css/click.css",
"./css/topnav.css",

// JavaScript
"./js/app.js",
"./js/dates.js",
"./js/size.js",

// Images
"./images/alleviate bloating.jpeg",
"./images/diy pad.jpeg",
"./images/foods to eat.jpeg",
"./images/overcoming_odor.jpeg",
"./images/relieving cramps.jpeg",
"./images/removing blood stains.jpeg",
"./images/android-chrome-192x192.png" ,
"./images/android-chrome-512x512.png" ,
"./images/gifs/generic.GIF" 
];

//caching all the assets
self.addEventListener("install", function(event) {
	event.waitUntil(
	caches.open(CACHE_NAME).then(function(cache) {
	return cache.addAll(CACHED_URLS);
	})
	);
});

//handling notifications
self.addEventListener("notificationclick", function(event) {
	event.waitUntil(self.clients.matchAll().then(function(clients){
		if(clients.length) //if some window is open
			clients[0].focus;
		else	
			self.clients.openWindow('./index.html');
	})
	);
});

//handling sync event for inventory
/* self.addEventListener("periodicSync",function(event) {
		if(event.tag === 'inventory-not')
		{
			var iflag = parseInt(window.localStorage.getItem('iflag'));
			var pflag = parseInt(window.localStorage.getItem('pflag'));
			var tflag = parseInt(window.localStorage.getItem('tflag'));
			if(iflag==1) //continue only if user wants to use inventory option
			{
				if(pflag)
				{
					var upad = parseInt(window.localStorage.getItem('upad'));
					var lpad = parseInt(window.localStorage.getItem('lpad'));
					if(upad>lpad)
					{
						navigator.serviceWorker.ready.then(function(registration) {
								registration.showNotification("You need to restock your pads!");
						});
					}					
				}
				if(tflag)
				{
					var utam = parseInt(window.localStorage.getItem('utam'));
					var ltam = parseInt(window.localStorage.getItem('ltam'));
					if(utam>ltam)
					{
						navigator.serviceWorker.ready.then(function(registration) {
								registration.showNotification("You need to restock your tampons!");
						});
					}
				}
			}
			
			//cancelling the sync event as the work is now complete
			navigator.serviceWorker.ready.then(function(registration) {
				registration.periodicSync.unregister('inventory-not');
			});
		}
}); */

self.addEventListener("periodicSync",function(event){
	if(event.tag === 'inventory-not')
	{
		alert("wow");
		console.log("wow");
	}
});

//caching stratergy
self.addEventListener("fetch", function(event) {
	
	//for gifs : network ,falling back to generic caching stratergy
	var req = new URL(event.request.url)
	if(req.pathname.startsWith("/menses/images/gifs/"))
	{
		event.respondWith(	
			fetch(event.request).then(function(networkResponse) {
				return networkResponse;
			}).catch(function(error)  {
				return caches.match("/menses/images/gifs/generic.GIF");
			})
		);
	}
	
	//for symptoms and PCOS : network ,falling back to generic caching stratergy
	else if(req.pathname.startsWith("/menses/symptoms") || req.pathname.startsWith("/menses/pcos"))
	{
		event.respondWith(	
			fetch(event.request).then(function(networkResponse) {
				return networkResponse;
			}).catch(function(error)  { 
			/* we do not directly return generic.html because then all further fetch requests will start from
			/menses/symptoms/ or /menses/pcos/
			Therefore we need to go one step back first. This is done by redirect.html*/
				return caches.match("/menses/redirect.html");
			})
		);
	}
	
	//for all other requests : Cache, falling back to network with frequent updates
	else{   
		event.respondWith(
		caches.open(CACHE_NAME).then(function(cache) {
		return cache.match(event.request).then(function(cachedResponse) {
		var fetchPromise =
		fetch(event.request).then(function(networkResponse) {
		cache.put(event.request, networkResponse.clone());
		return networkResponse;
		});
		return cachedResponse || fetchPromise;
		})
		})
		);	
		} 
});
