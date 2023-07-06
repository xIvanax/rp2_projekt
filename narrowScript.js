$(document).ready(function() {
    //tu sam prije dohvacala labele 
    var select = $('#city');
    var rangeInputs = $('.rangeInputs');
    var distance = $('#distanceFilter');

    console.log(select);
  
  $('#poseban').on('click', function(){
    console.log("zeli narrow");
    var table = $(".listingSort td");//tu su ćelije tablice s hotelima
    var oldList = $('.listingSort');
    var j = 0;
    function Hotel(grad, ime, udaljenost, rating, price, id) {
      this.ime = ime;
      this.grad = grad;
      this.udaljenost = udaljenost;
      this.rating = rating;
      this.price = price;
      this.id = id;
    }

    Hotel.prototype = {
      constructor: Hotel, // treba jer {} kreira NOVI objekt
    };
    console.log("novi niz");
    let arrHotels = new Array();
    var j = 0;
    var grad = select.val();
    var lowPrice = (rangeInputs.eq(0).val().length > 0)? Number(rangeInputs.eq(0).val()) : 0;
    var upPrice = (rangeInputs.eq(1).val().length > 0)? Number(rangeInputs.eq(1).val()) : Number.MAX_VALUE;
    var dist = (distance.val().length > 0)? Number(distance.val()) : Number.MAX_VALUE;
    var lowRating = (rangeInputs.eq(2).val().length > 0)? Number(rangeInputs.eq(2).val()) : 0;
    var upRating = (rangeInputs.eq(3).val().length > 0)? Number(rangeInputs.eq(3).val()) : 10;
    console.log("grad=" + grad + " lp=" + lowPrice + " up=" + upPrice + " d=" + dist + " lr=" + lowRating + " ur=" + upRating);
    for(var i = 0; i < oldList.length; i++){//broj hotela
        var cijena = $(".listingSort td").eq(6*i + 4).html().substring(15);
        cijena = cijena.substr(0, cijena.length-2);
        var udaljenost = $(".listingSort td").eq(6*i + 2).html().substring(32);
        udaljenost = udaljenost.substr(0, udaljenost.length - 2);
        console.log("usporedujem...");
        console.log("grad=" + $(".listingSort td").eq(6*i).html().substring(7) + " p=" + cijena + " d=" + udaljenost + " r=" + $(".listingSort td").eq(6*i + 3).html().substring(17));
        if($(".listingSort td").eq(6*i).html().substring(7) === grad &&
        Number(udaljenost) <= dist &&
        Number($(".listingSort td").eq(6*i + 3).html().substring(17)) <= upRating &&
        Number($(".listingSort td").eq(6*i + 3).html().substring(17)) >= lowRating &&
        Number(cijena) <= upPrice &&
        Number(cijena) >= lowPrice)
        {
            console.log("grad=" + grad + " lp=" + lowPrice + " up=" + upPrice + " d=" + dist + " lr=" + lowRating + " ur=" + upRating);
            console.log("ubacujem prethodno navedeni...");
            arrHotels[i] = new Hotel($(".listingSort td").eq(6*i).html(), $(".listingSort td").eq(6*i + 1).html(), $(".listingSort td").eq(6*i + 2).html(), $(".listingSort td").eq(6*i + 3).html(), $(".listingSort td").eq(6*i + 4).html(), $(".listingSort button").eq(j++).attr('id'));
        }
    }

    var n = arrHotels.length;
    console.log("n="+n);
    oldList.remove();
    for(var i = 0; i < n; i++){
      $('#list').append(
        '<table class="listingSort">' +
          '<tr>' +
            '<td class="hotel">' + arrHotels[i].grad + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotels[i].ime + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotels[i].udaljenost + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotels[i].rating + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotels[i].price + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' +
              '<button type="submit" name="button" value="' + arrHotels[i].id + '">' +
                'See availability</button>' +
            '</td>' +
          '</tr>' +
        '</table>');
    }
    });
  });
  