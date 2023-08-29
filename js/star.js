function star_function(n){
    var star_rating = document.getElementsByClassName('star-rating');
    var star_value = document.getElementById('star-value');
    star_value.value = n;
    for (var i=0;i<n;i++){

        star_rating[i].classList.remove("far");
        star_rating[i].classList.add("fas");
    }
    for (var i=n;i<5;i++){

        star_rating[i].classList.remove("fas");
        star_rating[i].classList.add("far");
    }

}