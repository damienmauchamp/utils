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

jQuery.fn.closestToOffset = function(offset) {
    var el = null,
        elOffset,
        x = offset.left,
        y = offset.top,
        distance,
        dx,
        dy,
        minDistance;
    this.each(function() {
        var $t = $(this);
        elOffset = $t.offset();
        right = elOffset.left + $t.width();
        bottom = elOffset.top + $t.height();

        if (
            x >= elOffset.left &&
            x <= right &&
            y >= elOffset.top &&
            y <= bottom
        ) {
            el = $t;
            return false;
        }

        var offsets = [
            [elOffset.left, elOffset.top],
            [right, elOffset.top],
            [elOffset.left, bottom],
            [right, bottom],
        ];
        for (var off in offsets) {
            dx = offsets[off][0] - x;
            dy = offsets[off][1] - y;
            distance = Math.sqrt(dx * dx + dy * dy);
            if (minDistance === undefined || distance < minDistance) {
                minDistance = distance;
                el = $t;
            }
        }
    });
    return el;
};

jQuery.fn.deplacer_element_vers = function(cible) {
    return $(this).detach().appendTo($(cible));
}

/**
 * Dans un tableau d'objets, vérifue qu'une clé est toujours égale à une valeur données
 * @param {array} tableau
 * @param {mixed} cle
 * @param {boolean} valeur
 * @param {boolean} retourner_compte
 * @returns {array|integer}
 */
function verifier_valeur_cle(tableau, cle, valeur = true, retourner_compte = false) {
    var resultat = tableau.filter(v => {
        return v[cle] == valeur;
    });
    return retourner_compte ? resultat.length : resultat;
}

/**
 * Désérialise un tableau de paramètres
 * @param {string} str
 * @returns {object}
 */
function deserialiser_params(str) {
    var tab = {};
    str.replace(/(?:\s|\?)*(.*)\s*/, '$1').split('&').forEach(s => {
        var split = s.split('=');
        if (/\[\]$/.test(split[0])) {
            if (typeof tab[split[0]] === "undefined") {
                tab[split[0].replace(/\[\]$/, '')] = [];
            }
            tab[split[0].replace(/\[\]$/, '')].push(split[1]);
        } else if (typeof tab[split[0]] !== "undefined") {
            if (typeof tab[split[0]] !== "object") {
                var tmp = tab[split[0]];
                tab[split[0]] = [];
                tab[split[0]].push(tmp);
            }
            tab[split[0]].push(split[1]);
        } else {
            tab[split[0]] = split[1];
        }
    });
    return tab;
}