//

function test() {
	return 3;
}

function oKOKOKOK() {
	var x;
	for (var i = 1 ; i < 20 ; i++) {
		x++;
	}
	return x;
}

function aaaa() {
	return 3;
}

String.prototype.startsWith = function (str){
	return this.indexOf(str) === 0;
};

$.fn.myPlugin = function() {
	return this.each(function() {
		//Do stuff
	});
};

/**
 * Équivalent de la fonction array_column en PHP
 * @param {type} arr
 * @param {type} column
 * @returns {unresolved}
 */
function array_column(arr, column) {
	return arr.map(x => x[column]);
}