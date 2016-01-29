var addclass = function(el, className) {
  if (el.classList) {
    el.classList.add(className);
  }
  else {
    el.className += ' ' + className;
  }
};

var remclass = function(el, className) {
  if (el.classList) {
    el.classList.remove(className);
  }
  else {
    el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
  }
};

var hasclass = function(el, className) {
  if (el.classList) {
    return el.classList.contains(className);
  }
  else {
    return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
  }
};

var getNearestParentMatchingSelector = function (elem, selector) {

  var matches = function(el, selector) {
    return (el.matches || el.matchesSelector || el.msMatchesSelector || el.mozMatchesSelector || el.webkitMatchesSelector || el.oMatchesSelector).call(el, selector);
  };

  for ( ; elem && elem !== document; elem = elem.parentNode ) {

    if ( matches(elem, selector) ) {
        return elem;
    }
  }
};

var addSharebox = function() {
  var plel = document.createElement('a');
  //addclass(plel, 'permalink');
  plel.innerHTML = '<svg aria-hidden="true" class="i-share"><use xlink:href="#i-share"></use></svg> SHARE';

  var plwrapdiv = document.createElement('div');
  addclass(plwrapdiv, 'permalink_wrapper');

  var sharebox = document.createElement('div');
  addclass(sharebox, 'sharebox');
  var shareboxtext = '<p><label>Link to this section:<input type="url" data-value="%s" value="" readonly> Shortcut to copy the link: <kbd>ctrl</kbd>+<kbd>C</kbd> <em>or</em> <kbd>⌘</kbd><kbd>C</kbd></label></p><p><a href="mailto:?subject=Web%20Accessibility%20Tutorials&body=Hi!%0AYou%20might%20be%20interested%20in%20this%3A%0A%0A%s">E-mail a link to this section</a><button>Close</button></p>';

  var url = window.location.origin + window.location.pathname;

  var elements = document.querySelectorAll('.future_permalink');
  Array.prototype.forEach.call(elements, function(el, i){ // … .each(…)

    var cplel = plel.cloneNode(true);
    var parentwid = getNearestParentMatchingSelector(el, 'li[id]');
    var theid = parentwid.id; //el.parentNode.parentNode.querySelector('h4[id]').id;
    cplel.setAttribute('href', '#' + theid);
    addclass(cplel, 'btn-small');
    cplel.setAttribute('aria-label', 'Share Link to this');//e section “' + el.textContent + '”');

    var csbtext = shareboxtext.replace("%s", '#' + theid).replace("%s", url + '#' + theid);
    var csb = sharebox.cloneNode(true);
    csb.innerHTML = csbtext;

    var cplwrapdiv = plwrapdiv.cloneNode(true);
    cplwrapdiv.appendChild(cplel);
    cplwrapdiv.appendChild(csb);
    //addclass(cplwrapdiv, el.localName);

    cplel.addEventListener('click', function(e){
      var url = window.location;
      var sbox = this.nextSibling;
      var input = sbox.querySelector('input');
      if (hasclass(sbox, 'open')) {
        remclass(sbox, 'open');
      } else {
        input.value = url + input.getAttribute('data-value');
        addclass(sbox, 'open');
        input.select();
        input.focus();
      }
      e.preventDefault();
    });

    el.parentNode.insertBefore(cplwrapdiv, el);
  });

  var sbbuttons = document.querySelectorAll('.sharebox button');
  Array.prototype.forEach.call(sbbuttons, function(el, i){ // … .each(…)
    el.addEventListener('click', function(){
      var openboxes = document.querySelectorAll('.sharebox.open');
      for (var i = openboxes.length - 1; i >= 0; i--) {
        remclass(openboxes[i], 'open');
      }
      el.parentNode.parentNode.parentNode.querySelector('a').focus();
    });
  });
};