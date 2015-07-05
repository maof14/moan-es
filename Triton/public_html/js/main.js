// main.js

$(document).ready(function(){
	'use strict';

	console.log('Hello there!');

	var keywords = ['Dim', 'Private', 'Public', 'As', 'For', 'Next', 'String', 'Integer', 'Double', 'Single', 'UBound', 'LBound', 'New', 'Set', 'If', 'Then', 'Else', 'End', 'ElseIf', 'Set', 'Sub', 'Function', 'Not', 'ByRef', 'ByVal', 'Optional', 'Boolean', 'Loop', 'Do', 'Until', 'With', 'Object', 'In', 'Variant'];

	var codeExamples = [
		"\nSub SAPMacro() \nThisWorkbook.Activate \nCells(2, 1).Select \n\n' Below is modified recording due to duplicate naming with excel. \n\nIf Not IsObject(App) Then \n\tSet SapGuiAuto = GetObject(\"SAPGUI\") \n\tSet App = SapGuiAuto.GetScriptingEngine \nEnd If \nIf Not IsObject(Con) Then \n\tSet Con = App.Children(0) \nEnd If \nIf Not IsObject(session) Then \n\tSet session = Con.Children(0) \nEnd If \nIf IsObject(WScript) Then \n\tWScript.ConnectObject session, \"on\" \n\tWScript.ConnectObject Application, \"on\" \nEnd If \n\n\t' Do any mass update here with lightning speed... \n \nEnd Sub",
		"\nSub SAPMain() \nThisWorkbook.Activate \nSAPConnection.initWithTransaction \"VA02\"",
		"\n' Build a select statement for SQL with CDatabase \nPublic Function selectQuery(ByVal table As String, Optional ByRef fields As Variant, Optional ByVal distinct As Boolean) As String \n\tDim i As Integer, SQL As String \n\tSQL = \"SELECT \" \n\tIf Not IsMissing(distinct) Then \n\t\tIf distinct = True Then \n\t\t\tSQL = SQL & \"DISTINCT \" \n\t\tEnd If \n\tEnd If \n\tIf Not IsMissing(fields) Then \n\t\tIf IsArray(fields) Then \n\t\t\tFor i = 0 To UBound(fields) - 1 \n\t\t\t\tSQL = SQL & fields(i) & \", \" \n\t\t\tNext i \n\t\t\tSQL = SQL & fields(UBound(fields)) & \" \" \n\t\tElse \n\t\t\tSQL = SQL & fields & \" \" \n\t\tEnd If \n\tElse \n\t\tSQL = SQL & \"* \" \n\tEnd If \n\tSQL = SQL & \"FROM \" & table \n\tselectQuery = SQL \nEnd Function",
		"\nSub SAPMainScript() \n \n\t' Dimensions ... \n \n\t' Get the transaction and script name from the template. \n \n\ttransaction = Cells(1, 1).Value \n\tscript = Cells(2, 7).Value \n \n\t' Initialize dependency classes \n \n\tSet stats = New CStatistics \n\tstats.init script \n\tSet timer = New CTimer \n\ttimer.init \n \n\t' Select the first cell to update in the template. \n\tCells(6, 2).Select \n \n\tSAPConnection.initWithNewSessionAndTransaction transaction \n \n\t' Setup SAP object loop \n\tDo Until IsEmpty(ActiveCell) \n \n\t\t' Execute script per object ... \n \n\tLoop \n \nEnd Sub",
		"\n' Find a pattern with custom Workbook formula. \n' Match examples: 1.4.12.15, 1.11.2.4, 1.12.1 \nFunction GetPattern(ByVal str As String) As String \n\t' Dimensions ... \n\tDim patterns, p As Variant \n\tDim RegMC \n\tDim result As String \n \n\t' Set up the patterns, prioritize numbers with four sequences. \n\tpatterns = Array( _ \n\t\t\"([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)|([0-9]+\.[0-9]+\.[0-9]+)\" _ \n\t) \n \n\tDim objRegEx As Object \n\tSet objRegEx = CreateObject(\"VBScript.RegExp\") \n \n\tFor Each p In patterns \n\t\tWith objRegEx \n\t\t\t.pattern = p \n\t\t\tIf .test(str) Then \n\t\t\t\tSet RegMC = .Execute(str) \n\t\t\t\tresult = RegMC(0).Value \n\t\t\tElse \n\t\t\t\tresult = \"No match\" \n\t\t\tEnd If \n\t\t\End With \n\tNext p \n \n\tSet RegMC = Nothing \n\tSet objRegEx = Nothing \n \n\t' Return result \n\tGetPattern = result \nEnd Function"
	];

	var random = Math.floor(Math.random() * 5) + 0;

	writeCode(codeExamples[random]);

	function writeCode(codeStr){
		var charArr = codeStr.split(''), current = 0;
		var words = codeStr.split(' '), currentWord = 0;
		setInterval(function(){
			if(current < charArr.length) {
				if(charArr[current] === ' ') { currentWord++; }
				if(in_array(words[currentWord], keywords)) {
					$('#code-example').html($('#code-example').html() + '<span class="keyword-blue">' + charArr[current++] + '</span>');
				} // else if(charArr[current] === '\'') {
				// 	var comment = codeStr.substr(current, codeStr.indexOf('\n', current) - current).split('');
				// 	var commentCurrent = 0;
				// 	setInterval(function(){
				// 		if(charArr[current] === ' ') { currentWord++; }
				// 		if(commentCurrent < comment.length) {
				// 			console.log(words[currentWord]);
				// 			 // Ne antingen får man tänka till här. Eller så får man göra så den skriver ut kommentarer rakt av. Eller så skiter man i att ha med kommentarer. Det kan ju vara någonting. Och så har man det senare istället. Kan ju fungera alltså. 
				// 			$('#code-example').html($('#code-example').html() + '<span class="keyword-green">' + charArr[current++] + '</span>');
				// 			commentCurrent++;
				// 		}
				// 	}, 25);
				// }
				else {
					$('#code-example').html($('#code-example').html() + charArr[current++]);	
				}
			}
		}, 50);
	}

	function in_array(needle, haystack) {
	    var length = haystack.length;
	    for(var i = 0; i < length; i++) {
	        if(haystack[i] === needle || '\n' + haystack[i] === needle || '\n\t' + haystack[i] === needle || '\n\n\t' + haystack[i] === needle || '\n\n' + haystack[i] === needle || '\n\t\t\t' + haystack[i] === needle || '\n\t\t' + haystack[i] === needle) return true;
	    }
    return false;
}

	$('.delete-example').on('click', function(e){
		// do not refresh page. 
		e.preventDefault();
		var me = $(this), id = $(this).attr('example-id'); 
		console.log(id);
		if(confirm('Are you sure you want to delete this example?')) {
			$.ajax({
			url: 'ajax/handle_request.php?action=delete&id=' + id,
			type: 'get', 
			success: function(data) {
				if(data.success = true) {
					removeExample(me);
				} else {
					console.log('Removal of example by Ajax failed. Maybe the example is not there or you are not authorized to remove.');
				}
			},
			error: function(data) {
				console.log('Unknown error removing example.');
			}
		});
		return false;
		}
	});

	var removeExample = function(example) {
		example.parentsUntil('.examples').slideUp('normal', function(){ $(this).remove(); });		
	}

	$('.publish-example').on('click', function(e){
		// do not refresh page. 
		e.preventDefault();
		var me = $(this), id = $(this).attr('example-id'); 
		console.log(id);
		$.ajax({
			url: 'ajax/handle_request.php?action=publish&id=' + id,
			type: 'get', 
			success: function(data) {
				console.log(data);
				if(data.success = true) {
					publishExample(me);
				} else {
					console.log('Example could not be published.');
				}
			},
			error: function(data) {
				console.log('Unknown error publishing example.');
			}
		});
	});

	var publishExample = function(example) {
		if($(example).find('.icon-available').hasClass('glyphicon-minus')) {
			$(example).find('.icon-available').removeClass('glyphicon-minus').addClass('glyphicon-ok');
		} else {
			$(example).find('.icon-available').removeClass('glyphicon-ok').addClass('glyphicon-minus');
		}
		return false;
	}

// customize
var v = new Vue({
	el: '#editor',
	data: {
	input: '# hello'
	},
	filters: {
	marked: marked
	}
});

});