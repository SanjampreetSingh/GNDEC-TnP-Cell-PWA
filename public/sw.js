importScripts("https://storage.googleapis.com/workbox-cdn/releases/3.3.0/workbox-sw.js");

workbox.precaching.precacheAndRoute([
  {
    "url": "favicon.ico",
    "revision": "ac29a51f219ca1c52ca4e2c58745361b"
  },
  {
    "url": "manifest.json",
    "revision": "fcfdf1a193c4f4a25eb49f17d9bcaf73"
  },
  {
    "url": "offline.html",
    "revision": "3ef6e540f4e7764a3242c9d5e3b9c07f"
  },
  {
    "url": "offline.png",
    "revision": "a62ebdc11693964198bc54c92521f35c"
  }
]);

// workbox.routing.registerRoute(
//     'http://localhost:8000/js/bundle.min.js',
//     workbox.strategies.staleWhileRevalidate({
//         cacheName: 'static-js',
//     }),
// );

// workbox.routing.registerRoute(
//     'http://localhost:8000/css/style.css',
//     workbox.strategies.staleWhileRevalidate({
//         cacheName: 'static-css',
//     }),
// );

// workbox.routing.registerRoute(
//     '/',
//     workbox.strategies.cacheFirst({
//         cacheName: 'posts',
//         plugins: [
//             new workbox.expiration.Plugin({
//                 maxEntries: 50,
//                 maxAgeSeconds: 5 * 60, // 5 minutes
//             }),
//             new workbox.cacheableResponse.Plugin({
//                 statuses: [0, 200],
//             }),
//         ],
//     }),
// );

const OFFLINE_URL = 'http://localhost:8000/offline.html';
self.addEventListener('fetch', event => {
    if (event.request.mode === 'navigate' ||
        (event.request.method === 'GET' &&
            event.request.headers.get('accept').includes('text/html'))) {
        event.respondWith(
            fetch(event.request).catch(error => {
                return caches.match(OFFLINE_URL);
            })
        );
    }
});