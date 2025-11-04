$(document).ready(function(){
    $('a').click(function(e){
        var id = $(this).attr('id');
        // alert(id)
        $('#GestionHumana'+id).toggle();
        $('#Compras'+id).toggle();
        $('#Ventas'+id).toggle();
        $('#Calidad'+id).toggle();



        $('#GestionHumanaclose'+id).click(function(){
            $('#GestionHumana'+id).css('display', 'none');
        });

        $('#Comprasclose'+id).click(function(){
            $('#Compras'+id).css('display', 'none');
        });

        $('#Ventasclose'+id).click(function(){
            $('#Ventas'+id).css('display', 'none');
        });

        $('#Calidadclose'+id).click(function(){
            $('#Calidad'+id).css('display', 'none');
        });



        $('#GestionHumanaclose').click(function(e){
            $('#GestionHumana'+id).css('display', 'none');
            $('#Compras'+id).css('display', 'none');
            $('#Ventas'+id).css('display', 'none');
            $('#Calidad'+id).css('display', 'none');
        })

        $('#Comprasclose').click(function(e){
            $('#GestionHumana'+id).css('display', 'none');
            $('#Compras'+id).css('display', 'none');
            $('#Ventas'+id).css('display', 'none');
            $('#Calidad'+id).css('display', 'none');
        })

        $('#Ventasclose').click(function(e){
            $('#GestionHumana'+id).css('display', 'none');
            $('#Compras'+id).css('display', 'none');
            $('#Ventas'+id).css('display', 'none');
            $('#Calidad'+id).css('display', 'none');

        })

        $('#Calidadclose').click(function(e){
            $('#GestionHumana'+id).css('display', 'none');
            $('#Compras'+id).css('display', 'none');
            $('#Ventas'+id).css('display', 'none');
            $('#Calidad'+id).css('display', 'none');
        })


    })
})
