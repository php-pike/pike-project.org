var Application = {
	init : function() {            
	},
        
        bindTooltipsToSimpleExample : function() {
            $("span:contains('Pike_Grid_Datasource_Doctrine')", $('div.source')).qtip({
                'content' : 'This is the place where the datasource is set up' +
                            ' and the Doctrine query is given as parameter. The datasource ' +
                            ' takes care of ordering or limiting the query according to the ' +
                            ' query parameters which can be modified by the user in a grid.'
            }).addClass('comment');
                
            $("span:contains('createQuery')", $('div.source')).qtip({
                'content' : 'With the createQuery() function you can create a SELECT, UPDATE or DELETE query' +
                            ' in Doctrine Query Language (DQL). More info about DQL is available in the Doctrine2' +
                            ' documentation. Only SELECT statements are accepted by the datasource, if you pass thru' +
                            ' a other statement Pike_Grid will throw a exception.'
            }).addClass('comment');
            
            $("span:contains('Pike_Grid'):last", $('div.source')).qtip({
               'content' : 'Its neccasary to pass thru a valid datasource to Pike_Grid which will tell the frontend' +
                           ' what kind of columns there are, what their names should be etc.'
            }).addClass('comment');
            
            $("span:contains('setCaption')", $('div.source')).qtip({
               'content' : 'Set the table caption. This is the title of the grid, see example above. This is not neccasary.'
            }).addClass('comment');
            
            $("span:contains('grid'):eq(3)", $('div.source')).qtip({
               'content' : 'We pass thru the grid object to the view here so that in the view you call the function' + 
                           ' ->getHTML() that prints the neccasary HTML for jqGrid to trigger.'
            }).addClass('comment');
            
            $("span:contains('appendScript')", $('div.source')).qtip({
               'content' : 'Append the generated JavaScript to the headScript() view helper. In the &lt;head&gt; tag you' +
                           ' can call the headScript() view helper to print this javascript which triggers jqGrid. If you ' +
                           ' want to change the grid you need to take care that your own javascript is appended to this (see' +
                           ' later examples)'
            }).addClass('comment');            

            $("span:contains('isXmlHttpRequest')", $('div.source')).qtip({
               'content' : 'If the current request is a xmlHttpRequest which can be identified by ZF easily then we disable' +
                           ' rendering the layout and the view and we output the JSON string from the datasource by getJSON()'
            }).addClass('comment');   

            $("span:contains('setParameters')", $('div.source')).qtip({
               'content' : 'With set parameters you can set all jqGrid expected grid parameters. Examples are sidx, sord, page, etc'
            }).addClass('comment');   

        },
        
        bindTooltipsToSimpleDataCallback : function() {
            $("span:contains('setColumnAttribute')", $('div.source')).qtip({
               'content' : 'With setColumnAttribute() you can set a attribute for the column according to the colModel' +
                           ' specification from jqGrid. There are two exclusions the data and positions attribute. The data' +
                           ' attribute you can specify a PHP callback function which will be called every row to render data' +
                           ' for this particular column where it takes the complete row as argument. See example grid above.'
            }).addClass('comment');               
            
            $("span:contains('$view'):eq(1)", $('div.source')).qtip({
               'content' : 'It\'s not possible to pass the view from the controller directly as $this->view cause this' +
                   'behavior is not supported by php closures. You use the view to put in a variable and then pass it with the' +
                   ' use keyword.'
            }).addClass('comment');                           

            $("span:contains('url'):eq(1)", $('div.source')).qtip({
               'content' : 'You could do a lot off magic in this closure here. Actually anything what is within the power' +
                    ' of PHP. In this particular case we use the Zend Framework url view helper to render a url encapsulated' + 
                    ' by the model name of the phone.'
            }).addClass('comment');      
        },
        
        bindTooltipsToDefaultSorting : function() {
            $("span:contains('ORDER')", $('div.source')).qtip({
               'content' : 'As you can see above you will see a sorting icon at the manufacturer as default. This is done very' +
                   ' simply by just adding a ORDER BY sql string as you used to. When the user clicks to sort another column this' +
                   ' ORDER BY will be overwritten by the datasource itself.'
            }).addClass('comment');                  
        },
        
        bindTooltipsToExtraColumns : function() {
            $("span:contains('addColumn')", $('div.source')).qtip({
               'content' : 'You can add non-sql columns by calling the addColumn() function to the grid. This function takes' +
                   ' the technical name as first, data as second, label as fourth, search index as sixth and positions as last. '+
                   ' Label, search index and position are optional. If you specify a search index you can set a column specification' +
                   ' from the query here. This will enable sorting on this column and the grid will be sorted to this field when ' +
                   ' someone clicks on the column specified by addColumn()'
            }).addClass('comment');
            
            $("span:contains('p.name'):last", $('div.source')).qtip({
               'content' : 'You can specify the search index here. It\'s best practice to take the column name with the identifier' +
                   ' here. If you pick the alias used in the query sorting results may not be as you expect. Especially if data in '+
                   ' the query is converted to a string like a date field surrounded with DATE_FORMAT.'
            }).addClass('comment');            
            
        },
        
        bindTooltipsToPositions : function() {
            $("span:contains('\'position\'')", $('div.source')).qtip({
                'content' : 'You can define (and override) the column position here with any integer number. ' +
                    ' The value you fill in here is not restricted to anything but you need to be aware that if an other' +
                    ' column has the same position value sorting the columns result might not be what you expect' +
                    ' its a good practice to set the number high if you want to be absolutely sure that the column' +
                    ' will be rendered as the last one. For rendering it as the first column you could even pass' +
                    ' a negative value like -10.'
            }).addClass('comment');
        },
        
        bindFilterToolbarToFilterGrid : function() {
            $('#filtergrid').jqGrid('filterToolbar', {stringResult : true, searchOnEnter : false});
        },
        
        bindTooltipsToFilter : function() {
            $("span:contains('bindFilterToolbarToFilterGrid')", $('div.source')).qtip({
                'content' : 'By calling this function in the application.js the filterToolbar plugin is' + 
                            ' enabled by jqGrid and this is all you have to do enable filtering your records with ' +
                            ' default behavior. You can modify this behavior according to the normal jqGrid settings.'
            }).addClass('comment');            

            $("span:contains('\'search'')", $('div.source')).qtip({
                'content' : 'According to the jqGrid colmodel specifications you can disable searching on a field setting' + 
                            ' the value of this attribute to false. A filter input field will not be issued when rendering the grid.'
            }).addClass('comment');
        }
}
