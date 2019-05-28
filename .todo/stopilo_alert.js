(function() {
	var stopilo_timeout = setTimeout(function() {
		console.log("stopilo_alert", "go");

		var stopilo_alert = function() {
			var str = this.querySelector(".task-project-name").innerHTML; 
			alert(this.textContent.replace(str, str + "\n"));
		}

		Array.from(document.getElementsByClassName("task-info")).forEach(function(elt) {
			elt.style.cursor = 'pointer';
			elt.addEventListener('click', stopilo_alert());
		});
		clearTimeout(stopilo_timeout);
	}(), 10000);
})();