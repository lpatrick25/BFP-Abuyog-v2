self.addEventListener('push', function (event) {
    let options = {
        body: event.data.text(),
        icon: '/img/bfp.svg', // Replace with your app's logo or an icon.
        badge: '/img/bfp.svg', // Optional: a badge to show on the push notification.
        data: { url: event.data.json().url }, // Optional: to store data you want to pass.
    };

    event.waitUntil(
        self.registration.showNotification(event.data.json().title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url) // Open a URL on notification click.
    );
});
