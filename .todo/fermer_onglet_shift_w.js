$(document).keydown(function(e) {
    if (e.keyCode === 87 && e.shiftKey) {
        $('.en_cours .fermer_onglet').trigger('click');
    }
});