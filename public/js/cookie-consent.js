document.addEventListener('DOMContentLoaded', function() {
    const cookieBanner = document.getElementById('cookie-banner');
    const acceptCookies = document.getElementById('accept-cookies');
    const rejectCookies = document.getElementById('reject-cookies');

    if (!cookieBanner || !acceptCookies || !rejectCookies) {
        console.error("Elementos del banner no encontrados!");
        return;
    }

    if (!localStorage.getItem('cookieConsent')) {
        cookieBanner.classList.remove('hidden');
    }

    acceptCookies.addEventListener('click', function() {
        localStorage.setItem('cookieConsent', 'accepted');
        cookieBanner.classList.add('hidden');
    });

    rejectCookies.addEventListener('click', function() {
        localStorage.setItem('cookieConsent', 'rejected');
        cookieBanner.classList.add('hidden');
    });
});