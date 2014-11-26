$(function(){
    var item_template = $('#results-template').text();
    var eval_tools = $.getJSON( "./js/data.json", function() {

    }).done(function(jsn) {

      var settings = {
        items            : jsn,
        facets           : {
          'guideline' : {'title': 'Guidelines', 'promoted': ["<strong><abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> 2.0 — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 2.0<\/strong>", "<abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> 1.0 — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 1.0"]},
          'language'  : {'title': 'Languages', 'collapsed': true},
          'type': {'title': 'Type of tool', 'collapsed': true},
          'assists': {'title': 'Assists by …', 'collapsed': true, 'promoted': ['Generating reports of evaluation results', 'Providing step-by-step evaluation guidance', 'Displaying information within web pages', 'Modifying the presentation of web pages']},
          'automated': {'title': 'Automatically checks…', 'collapsed': true, 'promoted': ['Single web pages', 'Groups of web pages or web sites', 'Restricted or password protected pages']},
          'license' : {'title': 'License', 'collapsed': true},
          'a11ystatement' : {'title': 'Accessibility Statement', 'plain': true }
        },
        resultSelector   : '#results',
        facetSelector    : '#facets',
        resultTemplate   : item_template,
        enablePagination : false,
        paginationCount  : 10,
        orderByOptions   : {'title': 'Title'},
        facetSortOption  : {},
        facetListContainer : '<ul class=facetlist></ul>',
        listItemTemplate   : '<li><span><input type="checkbox" class="facetitem" aria-pressed="false" id="<%= id %>"></span> <span><label for="<%= id %>"><%= name %> <span class="facetitemcount">(<%= count %>&nbsp;Tools)</span></label></span></li>',
        listItemInnerTemplate   : '<span><%= name %> <span class=facetitemcount>(<%= count %> tools)</span></span>',
        orderByTemplate    : '',
        countTemplate      : '<div class="facettotalcount"><span aria-live="true">Showing <%= count %> <% if (count==1) { %>tool<% } else {%>tools<% } %></span><% if (filters) { %>, matching the filters: <span class="filter"><%= filters.join("</span>, <span class=\'filter\'>") %></span><% } %></div>',
        facetTitleTemplate : '<% if (!obj.plain) { %><summary class="facettitle"><%= title %></summary><% } %>',
        facetContainer     : '<% if (!obj.plain) { %><details <% if (obj.collapsed) { %><% } else { %>open="true"<% } %> class="facetsearch <% if (obj.collapsed) { %><% } else { %>open<% } %>" id="<%= id %>"></details><% } else { %><div class="plainitem"></div><% } %>',
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
