//Poistamisen vahvistus meemeille ja kommenteille.
//Tunnistaa poistonapin id:n "deleteButton" perusteella.
$(document).ready(function () {
    $('#deleteButton').on('click', function (event) {
        if (!confirm('Are you sure that you want to delete this entity?')) {
            event.preventDefault();
        }
    });
});