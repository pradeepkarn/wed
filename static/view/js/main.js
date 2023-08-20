// Attach the event listener using addEventListener
if (window.location.href.endsWith('/')) {
    var newUrl = window.location.href.replace(/\/$/, '');
    history.replaceState(null, '', newUrl);
  }
    // Function to set a cookie
function setCookie(name, value, days) {
  var expirationDate = new Date();
  expirationDate.setDate(expirationDate.getDate() + days);
  var cookieValue = encodeURIComponent(value) + "; expires=" + expirationDate.toUTCString() + "; path=/";
  document.cookie = name + "=" + cookieValue;
}

// Function to get a cookie by name
function getCookie(name) {
  var cookieName = name + "=";
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
      var cookie = cookies[i].trim();
      if (cookie.indexOf(cookieName) === 0) {
          return decodeURIComponent(cookie.substring(cookieName.length));
      }
  }
  return null;
}



