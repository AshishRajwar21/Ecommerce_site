        var total_raw_price =  document.getElementById("total-raw-price");
        var total_item_price =  document.getElementById("total-item-price");
        var total_discount_price =  document.getElementById("total-discount-price");
        var saving_price =  document.getElementById("saving-price");
        function increment(id,item,discounted_p,actual_p){
            console.log(id);
            var count_of_it = document.getElementById('count-cart-'+id+'-'+item);
            var discounted_price = document.getElementById('discounted-price-'+id+'-'+item);
            var quantity = document.getElementById('cart-quantity-'+id+'-'+item);
            quantity.value = parseInt(quantity.value)+1;
            var actual_price;
            if (actual_p!=discounted_p){
                actual_price = document.getElementById('actual-price-'+id+'-'+item);    
            }
            
            if (parseInt(count_of_it.innerHTML) < 5){
                count_of_it.innerHTML = parseInt(count_of_it.innerHTML) + 1;
                discounted_price.innerHTML = (parseFloat(discounted_price.innerHTML) + discounted_p).toFixed(2);
                if (actual_p!=discounted_p){
                    actual_price.innerHTML = (parseFloat(actual_price.innerHTML) + actual_p).toFixed(2);
                }
                total_raw_price.innerHTML = (parseFloat(total_raw_price.innerHTML) + actual_p).toFixed(2);
                total_item_price.innerHTML = (parseFloat(total_item_price.innerHTML) + discounted_p).toFixed(2);
                total_discount_price.innerHTML = parseFloat(total_raw_price.innerHTML) - parseFloat(total_item_price.innerHTML);
                saving_price.innerHTML = parseFloat(total_raw_price.innerHTML) - parseFloat(total_item_price.innerHTML); 
            }
            else{
                alert("Max 5 items can be taken.");
            }
        }
        function decrement(id,item,discounted_p,actual_p){
            var count_of_it = document.getElementById('count-cart-'+id+'-'+item);
            var discounted_price = document.getElementById('discounted-price-'+id+'-'+item);
            var quantity = document.getElementById('cart-quantity-'+id+'-'+item);
            quantity.value = parseInt(quantity.value)-1;
            var actual_price;
            if (actual_p!=discounted_p){
                actual_price = document.getElementById('actual-price-'+id+'-'+item);    
            }
            if (parseInt(count_of_it.innerHTML) > 0){
                count_of_it.innerHTML = parseInt(count_of_it.innerHTML) - 1;
                discounted_price.innerHTML = (parseFloat(discounted_price.innerHTML) - discounted_p).toFixed(2);
                if (actual_p!=discounted_p){
                    actual_price.innerHTML = (parseFloat(actual_price.innerHTML) - actual_p).toFixed(2);
                }                
                total_raw_price.innerHTML = (parseFloat(total_raw_price.innerHTML) - actual_p).toFixed(2);
                total_item_price.innerHTML = (parseFloat(total_item_price.innerHTML) - discounted_p).toFixed(2);
                total_discount_price.innerHTML = parseFloat(total_raw_price.innerHTML) - parseFloat(total_item_price.innerHTML);
                saving_price.innerHTML = parseFloat(total_raw_price.innerHTML) - parseFloat(total_item_price.innerHTML);
            }
            else{
                alert("Negative count of items can not be taken.");
            }
        }