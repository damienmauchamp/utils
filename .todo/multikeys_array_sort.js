array_places.sort(function(a, b) {
	return (a.tribune === b.tribune) ? (a.place - b.place) : (a.tribune > b.tribune ? 1 : -1);
});

array_places.sort(function(a, b) {
	if (a.tribune === b.tribune) {
		return a.place - b.place;
	}
	return a.tribune > b.tribune ? 1 : -1;
});