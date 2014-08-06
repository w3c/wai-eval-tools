$(function(){
    var item_template = $('#results-template').text();
    var eval_tools = $.getJSON( "./js/data.json", function() {

    }).done(function(jsn) {

      var settings = {
        items            : jsn,
        facets           : {
          'guideline' : {'title': 'Guidelines'},
          'language'  : {'title': 'Languages', 'collapsed': true},
          'assistance': {'title': 'Assistance', 'collapsed': true},
          'platform' : {'title': 'Platform', 'collapsed': true},
          'license' : {'title': 'License', 'collapsed': true},
          'automatic': {'title': 'Automatically checks…', 'collapsed': true},
          'type': {'title': 'Type', 'collapsed': true},
          'checks': {'title': 'Checks', 'collapsed': true},
          'reports': {'title': 'Report Format', 'collapsed': true}
        },
        resultSelector   : '#results',
        facetSelector    : '#facets',
        resultTemplate   : item_template,
        paginationCount  : 8,
        orderByOptions   : {'title': 'Title'},
        facetSortOption  : {},
        facetListContainer : '<ul class=facetlist></ul>',
        listItemTemplate   : '<li><label><input type="checkbox" class="facetitem" aria-pressed="false" id="<%= id %>"> <span><%= name %> <span class="facetitemcount">(<%= count %> Tools)</span></span></label></li>',
        listItemInnerTemplate   : '<span><%= name %> <span class=facetitemcount>(<%= count %> Tools)</span></span>',
        orderByTemplate    : '',
        countTemplate      : '<div class="facettotalcount"><span aria-live="true"><%= count %> Results</span><% if (filters) { %> <span><strong>Selected Filters:</strong> <%= filters.join(", ") %> </span><% } %></div>',
        facetTitleTemplate : '<summary class="facettitle"><%= title %></summary>',
        facetContainer     : '<details <% if (obj.collapsed) { %><% } else { %>open="true"<% } %> class="facetsearch <% if (obj.collapsed) { %><% } else { %>open<% } %>" id="<%= id %>"></details> <%= obj %>',
      };

    // use them!
    //
    $.facetelize(settings);
    });

  // Emulate <details> where necessary and enable open/close event handlers
  // alert($.fn.details.support);
  $('html').addClass($.fn.details.support ? 'details' : 'no-details');
  $('details').details();
});
