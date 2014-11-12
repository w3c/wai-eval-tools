$(function(){
    var item_template = $('#results-template').text();
    var eval_tools = $.getJSON( "./js/data.json", function() {

    }).done(function(jsn) {

      var settings = {
        items            : jsn,
        facets           : {
          'guideline' : {'title': 'Guidelines', 'promoted': ["<strong><abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> 2.0 — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 2.0<\/strong>", "<abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 1.0"]},
          'language'  : {'title': 'Languages', 'collapsed': true},
          'assists': {'title': 'Features', 'collapsed': true},
          'automated': {'title': 'Automatically checks…', 'collapsed': true},
          'authoringtools': {'title': 'Authoring Tools', 'collapsed': true},
          'desktopapp': {'title': 'Operating system', 'collapsed': true},
          'onlineservice': {'title': 'Online Service', 'collapsed': true},
          'repairs': {'title': 'Repairs', 'collapsed': true},
          'runtime': {'title': 'Runtime', 'collapsed': true},
          'apis': {'title': 'APIs', 'collapsed': true},
          'checks': {'title': 'Checks', 'collapsed': true},
          'reports': {'title': 'Report Format', 'collapsed': true},
          'license' : {'title': 'License', 'collapsed': true}
        },
        resultSelector   : '#results',
        facetSelector    : '#facets',
        resultTemplate   : item_template,
        paginationCount  : 10,
        orderByOptions   : {'title': 'Title'},
        facetSortOption  : {},
        facetListContainer : '<ul class=facetlist></ul>',
        listItemTemplate   : '<li><span><input type="checkbox" class="facetitem" aria-pressed="false" id="<%= id %>"></span> <span><label for="<%= id %>"><%= name %> <span class="facetitemcount">(<%= count %>&nbsp;Tools)</span></label></span></li>',
        listItemInnerTemplate   : '<span><%= name %> <span class=facetitemcount>(<%= count %> Tools)</span></span>',
        orderByTemplate    : '',
        countTemplate      : '<div class="facettotalcount"><span aria-live="true"><%= count %> Results</span><% if (filters) { %> <span><strong>Selected Filters:</strong> <%= filters.join(", ") %> </span><% } %></div>',
        facetTitleTemplate : '<summary class="facettitle"><%= title %></summary>',
        facetContainer     : '<details <% if (obj.collapsed) { %><% } else { %>open="true"<% } %> class="facetsearch <% if (obj.collapsed) { %><% } else { %>open<% } %>" id="<%= id %>"></details> <%= obj %>',
        showMoreTemplate   : '<button type="button" id="showmorebutton">Show more</button>'
      };

    // use them!
    //
    $.facetelize(settings);
    // Emulate <details> where necessary and enable open/close event handlers
    // alert($.fn.details.support);
    $('html').addClass($.fn.details.support ? 'details' : 'no-details');
    $('#facets details, .navigation > details').details();
    });

});
