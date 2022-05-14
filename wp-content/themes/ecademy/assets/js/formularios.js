
// $("#testForm").submit(function(e){
// 	e.preventDefault();
// });

$("#updatebasic").submit(function(e){
	e.preventDefault();
    var form_data = jQuery( this ).serializeArray();
    // console.log(form_data);
     // Here is the ajax petition.
     jQuery.ajax({
        url: ajax_var.url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // alert( response );
            if(response){  
                $("#basicdata").html("<b>Información actualizada</b>");
                location.reload(); }else { alert(response);  $("#basicdata").html("");
            }
        },
        fail : function( err ) {
            alert( "There was an error: " + err );
        }
    });
    return false;
});
 

$("#updateform3").submit(function(e){
	e.preventDefault();
    var form_data = jQuery( this ).serializeArray();
    console.log(form_data);
     // Here is the ajax petition.
     jQuery.ajax({
        url: ajax_var.url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // alert( response );
            if(response){  
                $("#basicdataform3").html("<b>Información actualizada</b>");
                location.reload(); }else { alert(response);  $("#basicdataform3").html("");
                     }
        },
        fail : function( err ) {
            alert( "There was an error: " + err );
        }
    });
    return false;
});

$("#updateform4").submit(function(e){
	e.preventDefault();
    var form_data = jQuery( this ).serializeArray();
    console.log(form_data);
     // Here is the ajax petition.
     jQuery.ajax({
        url: ajax_var.url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // alert( response );
            if(response){  
                $("#basicdataform4").html("<b>Información actualizada</b>");
                }else { alert(response);  $("#basicdataformr").html("");
                     }
        },
        fail : function( err ) {
            alert( "There was an error: " + err );
        }
    });
    return false;
});

$("#updateform5").submit(function(e){
	e.preventDefault();
    var form_data = jQuery( this ).serializeArray();
    //console.log(form_data);
     // Here is the ajax petition.
     jQuery.ajax({
        url: ajax_var.url,
        type : 'post',
        data : form_data,
        success : function( response ) {
            // alert( response );
            if(response){   
                $("#basicdataform5").html("<b>Información actualizada</b>");  location.reload();
                }else {   $("#basicdataform5").html("");
                     }
        },
        fail : function( err ) {
            alert( "There was an error: " + err );
        }
    });
    return false;
});
