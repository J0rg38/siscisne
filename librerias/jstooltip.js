// JavaScript Document

/*$(document).on("click", ".tooltipf", function() {
    $(this).tooltip(
        { 
            items: ".tooltipf", 
            content: function(){
                return $(this).data('description');
            }, 
            close: function( event, ui ) {
                var me = this;
                ui.tooltip.hover(
                    function () {
                        $(this).stop(true).fadeTo(400, 1); 
                    },
                    function () {
                        $(this).fadeOut("400", function(){
                            $(this).remove();
                        });
                    }
                );
                ui.tooltip.on("remove", function(){
                    $(me).tooltip("destroy");
                });
          },
        }
    );
    $(this).tooltip("open");
});*/


$(document).on("click", ".tooltipf", function() {
	
				dhtmlx.alert({
					title:"Aviso",
					type:"info",
					text: $(this).data('description'),
					callback: function(result){

					}
				});


//	alert($(this).data('description'));
	
});