(function () {
'use strict';

const MOUSE_EVENTS = ['click', 'touchstart'];

function closest(el, selector) {
  var matchesFn;

  // find vendor prefix
  ['matches', 'webkitMatchesSelector', 'mozMatchesSelector', 'msMatchesSelector', 'oMatchesSelector'].some(function(fn) {
    if (typeof document.body[fn] == 'function') {
      matchesFn = fn;
      return true;
    }
    return false;
  });

  var parent;

  // traverse parents
  while (el) {
    parent = el.parentElement;
    if (parent && parent[matchesFn](selector)) {
      return parent;
    }
    el = parent;
  }

  return null;
}

document.addEventListener('DOMContentLoaded', function() {
  // Get all document sliders
  var showQuickview = document.querySelectorAll('[data-show="quickview"]');
  [].forEach.call(showQuickview, function(show) {
    var quickview = document.getElementById(show.dataset['target']);
    var backdrop = document.getElementById('menu-backdrop');
    var html = document.getElementsByTagName('html')[0];
    if (quickview) {
      // Add event listener to update output when slider value change
      MOUSE_EVENTS.forEach((event) => {
        show.addEventListener(event, function(e) {
          e.preventDefault();
          quickview.classList.add('is-active');
          backdrop.classList.add('is-active');
          html.classList.add('is-clipped');
        });
      });
    }
  });

  // Get all document sliders
  var dismissQuickView = document.querySelectorAll('[data-dismiss="quickview"]');
  [].forEach.call(dismissQuickView, function(dismiss) {
    var quickview = closest(dismiss, '.quickview');
    var backdrop = document.getElementById('menu-backdrop');
    var html = document.getElementsByTagName('html')[0];
    if (quickview) {
      // Add event listener to update output when slider value change
      MOUSE_EVENTS.forEach((event) => {
        dismiss.addEventListener(event, function(e) {
          quickview.classList.remove('is-active');
          backdrop.classList.remove('is-active');
          html.classList.remove('is-clipped');
        });
      });
    }
  });
});

}());
