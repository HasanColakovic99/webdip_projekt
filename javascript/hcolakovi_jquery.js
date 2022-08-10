$(document).ready(function () {
    let videa = new Array();

    $.getJSON("../json/search.json", function (jsonData) {
        $.each(jsonData, function (kljuc, vrijednost) {
            videa.push(vrijednost);
        });
    });

    $("#pretrazivanje").autocomplete({ source: videa });


    $("#pretrazi").click(function (event) {
        event.preventDefault();
        $(".container").find("div")
            .hide()
            .filter(":contains('" + $("input[name='pretrazi']").val() + "')")
            .show();

        if ($(".container").find("div").filter(":contains('" + $("input[name='pretrazi']").val() + "')").length == 0) {
            $("#nemaPodataka").html('Nema podataka');
        }
        else {
            $("#nemaPodataka").html('');
        }
    });

    $('#tabela').dataTable(
        {
            "aaSorting": [[0, "asc"], [1, "asc"]],
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true
        });
});



