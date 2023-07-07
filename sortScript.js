$(document).ready(function() {
  var choice = $('.decorated-label');

  for (var i = 0; i < choice.length; i++) {
    (function(index) { // Create a closure to capture the current value of `i`
      $('.decorated-label').eq(index).on('click', function() {

        if (choice.eq(index).css('background-color') === "rgb(221, 221, 221)"
        || choice.eq(index).css('background-color') === "rgb(242, 242, 242)") {
          choice.eq(index).css('background-color', "rgb(176, 172, 172)");
		for(var j = 0; j < choice.length; j++){
		if(j !== index){
      choice.eq(j).css('background-color', "rgb(242, 242, 242)");
		}
	}

        } else {
          choice.eq(index).css('background-color', "rgb(242, 242, 242)");
        }
      });
    })(i); // Pass the current value of `i` to the closure
  }

$('#sort').on('click', function(){
	var choice = $('.decorated-label');
	for (var i = 0; i < choice.length; i++){
		if(choice.eq(i).css('background-color') === "rgb(176, 172, 172)"){
      if(choice.eq(i).attr("id") === "dl1"){//silazni sort po cijeni
				sortPrice(1);
			}else if(choice.eq(i).attr("id") === "dl2"){
				sortPrice(2);
			}
			if(choice.eq(i).attr("id") === "dl3"){//silazni sort po ratingu
				sortRating(3);
			}else if(choice.eq(i).attr("id") === "dl4"){
				sortRating(4);
			}
			if(choice.eq(i).attr("id") === "dl5"){
				sortDistance(5);
			}else if(choice.eq(i).attr("id") === "dl6"){
				sortDistance(6);
			}
		}
	}
  });

function sortRating(k) {
	//ako k==3 silazno, inace uzlazno
      //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
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

      function usporediRating1(a, b){
        return a.rating > b.rating;
      }

      function usporediRating2(a, b){
        return a.rating < b.rating;
      }

      Hotel.prototype = {
        constructor: Hotel, // treba jer {} kreira NOVI objekt
      };
      let arrHotels = new Array();
      let arrRating = new Array();
      for(var i = 0; i < oldList.length; i++){//broj hotela
        arrHotels[i] = new Hotel($(".listingSort td").eq(6*i).html(), $(".listingSort td").eq(6*i + 1).html(), 
        $(".listingSort td").eq(6*i + 2).html(), $(".listingSort td").eq(6*i + 3).html(), $(".listingSort td").eq(6*i + 4).html(), 
        $(".availabilityButton").eq(i).val());
        arrRating[i] = $(".listingSort td").eq(6*i + 3).html();//rating
      }

      if(k === 3){
        arrHotels.sort(usporediRating2);
      }else {
        arrHotels.sort(usporediRating1);
      }
      var n = arrHotels.length;
      oldList.remove();
      for(var i = 0; i < n; i++){
        $('#forma').append(
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
                '<button type="submit" name="button" class="availabilityButton" value="' + arrHotels[i].id + '">' +
                  'See availability</button>' +
              '</td>' +
            '</tr>' +
          '</table>');
      }
  }
function sortDistance(k) {
	//ako k==6 silazno, inace uzlazno
      //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
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

      function usporediUdaljenost1(a, b){
        udaljenost1 = a.udaljenost.substring(31);
        udaljenost1 = udaljenost1.substring(0, udaljenost1.length - 2);
        udaljenost1 = Number(udaljenost1);
        udaljenost2 = b.udaljenost.substring(31);
        udaljenost2 = udaljenost2.substring(0, udaljenost2.length - 2);
        udaljenost2 = Number(udaljenost2);
        return udaljenost1 > udaljenost2;
      }

      function usporediUdaljenost2(a, b){
        udaljenost1 = a.udaljenost.substring(31);
        udaljenost1 = udaljenost1.substring(0, udaljenost1.length - 2);
        udaljenost1 = Number(udaljenost1);
        udaljenost2 = b.udaljenost.substring(31);
        udaljenost2 = udaljenost2.substring(0, udaljenost2.length - 2);
        udaljenost2 = Number(udaljenost2);
        return udaljenost1 < udaljenost2;
      }

      Hotel.prototype = {
        constructor: Hotel, // treba jer {} kreira NOVI objekt
      };
      let arrHotels = new Array();
      for(var i = 0; i < oldList.length; i++){//broj hotela
        arrHotels[i] = new Hotel($(".listingSort td").eq(6*i).html(), $(".listingSort td").eq(6*i + 1).html(), 
        $(".listingSort td").eq(6*i + 2).html(), $(".listingSort td").eq(6*i + 3).html(), $(".listingSort td").eq(6*i + 4).html(), 
        $(".availabilityButton").eq(i).val());
      }

      if(k === 6){
        arrHotels.sort(usporediUdaljenost1);
      }else {
        arrHotels.sort(usporediUdaljenost2);
      }

      var n = arrHotels.length;
      oldList.remove();
      for(var i = 0; i < n; i++){
        $('#forma').append(
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
                '<button type="submit" name="button" class="availabilityButton" value="' + arrHotels[i].id + '">' +
                  'See availability</button>' +
              '</td>' +
            '</tr>' +
          '</table>');
      }
  }

  function sortPrice(k) {
  	//ako k==1 silazno, inace uzlazno
        //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
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

        function usporediCijenu1(a, b){
          price1 = a.price.substring(14);
          price1 = price1.substring(0, price1.length - 2);
          price1 = Number(price1);
          price2 = b.price.substring(14);
          price2 = price2.substring(0, price2.length - 2);
          price2 = Number(price2);
          return price1 > price2;
        }

        function usporediCijenu2(a, b){
          price1 = a.price.substring(14);
          price1 = price1.substring(0, price1.length - 2);
          price1 = Number(price1);
          price2 = b.price.substring(14);
          price2 = price2.substring(0, price2.length - 2);
          price2 = Number(price2);
          return price1 < price2;
        }

        Hotel.prototype = {
          constructor: Hotel, // treba jer {} kreira NOVI objekt
        };
        let arrHotels = new Array();
        for(var i = 0; i < oldList.length; i++){//broj hotela
          arrHotels[i] = new Hotel($(".listingSort td").eq(6*i).html(), $(".listingSort td").eq(6*i + 1).html(), 
          $(".listingSort td").eq(6*i + 2).html(), $(".listingSort td").eq(6*i + 3).html(), $(".listingSort td").eq(6*i + 4).html(), 
          $(".availabilityButton").eq(i).val());
          console.log("id = " + arrHotels[i].id);
        }

        if(k === 1){
          arrHotels.sort(usporediCijenu2);
        }else {
          arrHotels.sort(usporediCijenu1);
        }

        var n = arrHotels.length;
        oldList.remove();
        for(var i = 0; i < n; i++){
          $('#forma').append(
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
                  '<button type="submit" name="button" class="availabilityButton" value="' + arrHotels[i].id + '">' +
                    'See availability</button>' +
                '</td>' +
              '</tr>' +
            '</table>');
        }
    }
});
