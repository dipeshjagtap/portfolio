// ===== service-worker.js =====

// Version the cache – change this when you update files
const CACHE_NAME = "dipeshjagtap-resume-v2";

// List of files to cache
const ASSETS_TO_CACHE = [
  "/resume/",
  "/resume/index.html",
  "/resume/content/style.css",
  "/resume/content/style1.css",
  "/resume/content/dipesh.png",
  "/resume/content/favicon/favicon-32x32.png",
  "/resume/content/favicon/favicon-16x16.png",
  "/resume/content/favicon/android-chrome-192x192.png",
  "/resume/content/favicon/android-chrome-512x512.png",
  "/resume/content/script.js"
];

// Install phase: cache everything
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS_TO_CACHE))
  );
  self.skipWaiting(); // Activate immediately after install
});

// Activate phase: remove old cache versions
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) =>
      Promise.all(
        cacheNames.map((name) => {
          if (name !== CACHE_NAME) {
            return caches.delete(name);
          }
        })
      )
    )
  );
  self.clients.claim(); // Take control of pages immediately
});

// Fetch handler: network-first strategy
self.addEventListener("fetch", (event) => {
  // Ignore chrome extensions and other non-http requests
  if (!event.request.url.startsWith("http")) return;

  event.respondWith(
    fetch(event.request)
      .then((response) => {
        // Clone and store in cache for offline use
        const resClone = response.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(event.request, resClone));
        return response;
      })
      .catch(() => caches.match(event.request)) // fallback to cache when offline
  );
});

// Optional: Listen for skipWaiting message to update immediately
self.addEventListener("message", (event) => {
  if (event.data && event.data.type === "SKIP_WAITING") {
    self.skipWaiting();
  }
});
