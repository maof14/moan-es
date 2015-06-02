// main.js

$(document).ready(function(){
	'use strict';

	console.log('Hello there!');

	var keywords = ['Dim', 'Private', 'Public', 'As', 'For', 'Next', 'String', 'Integer', 'Double', 'Single', 'UBound', 'LBound', 'New', 'Set', 'If', 'Then', 'Else', 'End', 'ElseIf', 'Set', 'Sub', 'Function', 'Not'];

	var codeStr = "\nSub SAPMacro() \nThisWorkbook.Activate \nCells(2, 1).Select \n\n' Below is modified recording due to duplicate naming with excel. \n\nIf Not IsObject(App) Then \n\tSet SapGuiAuto = GetObject(\"SAPGUI\") \n\tSet App = SapGuiAuto.GetScriptingEngine \nEnd If \nIf Not IsObject(Con) Then \n\tSet Con = App.Children(0) \nEnd If \nIf Not IsObject(session) Then \n\tSet session = Con.Children(0) \nEnd If \nIf IsObject(WScript) Then \n\tWScript.ConnectObject session, \"on\" \n\tWScript.ConnectObject Application, \"on\" \nEnd If \n\n\t' Do any mass update here with lightning speed... \n \nEnd Sub";

	writeCode(codeStr);

	function writeCode(codeStr){
		var charArr = codeStr.split(''), current = 0;
		var words = codeStr.split(' '), currentWord = 0;
		// Om man tänker såhär. Att man går igenom varje ord tills charen är ett mellanslag. Och om det ordet är något av dem i keyword, så gör en prepend + append. 
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
	        if(haystack[i] === needle || '\n' + haystack[i] === needle || '\n\t' + haystack[i] === needle || '\n\n\t' + haystack[i] === needle || '\n\n' + haystack[i] === needle) return true;
	    }
    return false;
}

});