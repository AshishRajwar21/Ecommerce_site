window.addEventListener("load",function(){
    var seller_signup_form = document.getElementById("seller-signup-form");//the data will be get in signup_form
    seller_signup_form.addEventListener("submit",function(event){//when submit button will be clicked
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(seller_signup_form);
        //on success
        XHR.addEventListener("load",seller_signup_success);

        //on error
        XHR.addEventListener("error",on_error);//id,function

        //set up request
        XHR.open("post","api/seller_signup_submit.php");

        //form data is sent with request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();

    });

    var seller_login_form = document.getElementById("seller-login-form");
    seller_login_form.addEventListener("submit",function(event){
        var XHR = new XMLHttpRequest();
        var form_data = new FormData(seller_login_form);
        //on success
        XHR.addEventListener("load",seller_login_success);
        //on error
        XHR.addEventListener("error",on_error);
        //set up request
        XHR.open("post","api/seller_login_submit.php");
        
        //form data is sent with  request
        XHR.send(form_data);

        document.getElementById("loading").style.display = 'block';
        event.preventDefault();

    });



});

var seller_signup_success = function(event){
    document.getElementById("loading").style.display = 'none';
    var response = JSON.parse(event.target.responseText);
    if (response.success){
        alert(response.message);
        window.location.href = "seller_home.php";
    }
    else{
        alert(response.message);
    }

};

var seller_login_success = function(event){
    document.getElementById("loading").style.display = 'none';
    var response = JSON.parse(event.target.responseText);
    if (response.success){
        //alert(response.message);
        window.location.href = "seller_home.php";
    }
    else{
        alert(response.message);
    }
};




var on_error = function(event){
    document.getElementById("loading").style.display = 'none';
    alert('Oops! Something went wrong.');
};