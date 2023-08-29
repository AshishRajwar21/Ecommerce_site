window.addEventListener("load",function(){
    var cart_remove_form = document.getElementById("cart-remove-form");//the data will be get in signup_form
    cart_remove_form.addEventListener("submit",function(event){//when submit button will be clicked
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(cart_remove_form);
        //on success
        XHR.addEventListener("load",cart_success);

        //on error
        XHR.addEventListener("error",on_error);//id,function

        //set up request
        XHR.open("post","api/toggle_remove.php");

        //form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();

    });



});

var cart_success = function(event){
    document.getElementById("loading").style.display = 'none';
    var response = JSON.parse(event.target.responseText);
    if (response.success){
        //alert(response.message);
        // var product_id = response.product_id;
        // var item = response.item;
        window.location.href = "cart_list.php";
    }
    else if (!response.success && !response.is_logged_in) {
        window.$("#login-modal").modal("show");
    }
};
