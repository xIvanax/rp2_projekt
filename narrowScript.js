$(document).ready(function() {
    //tu sam prije dohvacala labele 
    var select = $('#city');
    var rangeInputs = $('.rangeInputs');
    var distance = $('#distanceFilter');
  
  $('#poseban').on('click', function(){
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
    let arrHotelsF = new Array();
    var k = 0;
    var grad = select.val();
    var lowPrice = (rangeInputs.eq(0).val().length > 0)? Number(rangeInputs.eq(0).val()) : 0;
    var upPrice = (rangeInputs.eq(1).val().length > 0)? Number(rangeInputs.eq(1).val()) : Number.MAX_VALUE;
    var dist = (distance.val().length > 0)? Number(distance.val()) : Number.MAX_VALUE;
    var lowRating = (rangeInputs.eq(2).val().length > 0)? Number(rangeInputs.eq(2).val()) : 0;
    var upRating = (rangeInputs.eq(3).val().length > 0)? Number(rangeInputs.eq(3).val()) : 10;
    for(var i = 0; i < oldList.length; i++){//broj hotela
        var cijena = $(".listingSort td").eq(6*i + 4).html().substring(15);
        cijena = cijena.substr(0, cijena.length-2);
        var udaljenost = $(".listingSort td").eq(6*i + 2).html().substring(32);
        udaljenost = udaljenost.substr(0, udaljenost.length - 2);
        if($(".listingSort td").eq(6*i).html().substring(7) === grad &&
        Number(udaljenost) <= dist &&
        Number($(".listingSort td").eq(6*i + 3).html().substring(17)) <= upRating &&
        Number($(".listingSort td").eq(6*i + 3).html().substring(17)) >= lowRating &&
        Number(cijena) <= upPrice &&
        Number(cijena) >= lowPrice) {
            arrHotelsF[k++] = new Hotel($(".listingSort td").eq(6*i).html(), $(".listingSort td").eq(6*i + 1).html(), 
            $(".listingSort td").eq(6*i + 2).html(), $(".listingSort td").eq(6*i + 3).html(), $(".listingSort td").eq(6*i + 4).html(), 
            $(".listingSort button").eq(i).val());
        }
    }

    var n = arrHotelsF.length;
    oldList.remove();
    for(var i = 0; i < n; i++){
      $('#forma').append(
        '<table class="listingSort">' +
          '<tr>' +
            '<td class="hotel">' + arrHotelsF[i].grad + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotelsF[i].ime + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotelsF[i].udaljenost + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotelsF[i].rating + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' + arrHotelsF[i].price + '</td>' +
          '</tr>' +
          '<tr>' +
            '<td class="hotel">' +
              '<button type="submit" name="button" class="availabilityButton" value="' + arrHotelsF[i].id + '">' +
                'See availability</button>' +
            '</td>' +
          '</tr>' +
        '</table>');
    }
    });
  });
  