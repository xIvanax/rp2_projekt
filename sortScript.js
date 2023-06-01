$(document).ready(function() {
  var choice = $('.decorated-label');
  console.log(choice.length);
  
  for (var i = 0; i < choice.length; i++) {
    (function(index) { // Create a closure to capture the current value of `i`
      $('.decorated-label').eq(index).on('click', function() {
        console.log(choice.eq(index).css('background-color'));
        
        if (choice.eq(index).css('background-color') === "rgb(221, 221, 221)"
	|| choice.eq(index).css('background-color') === "rgb(242, 242, 242)") {
          choice.eq(index).css('background-color', "rgb(176, 172, 172)");
	if(index === 3)
		choice.eq(2).css('background-color', "rgb(242, 242, 242)");
if(index === 2)
		choice.eq(3).css('background-color', "rgb(242, 242, 242)");
if(index === 0)
		choice.eq(1).css('background-color', "rgb(242, 242, 242)");
if(index === 1)
		choice.eq(0).css('background-color', "rgb(242, 242, 242)");
if(index === 4)
		choice.eq(5).css('background-color', "rgb(242, 242, 242)");
if(index === 5)
		choice.eq(4).css('background-color', "rgb(242, 242, 242)");


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
			console.log("hi");
			if(choice.eq(i).attr("id") === "dl3"){//silazni sort po ratingu
				sortRating(3);
			}else
				sortRating(4);
		}
	}
  });
	
function sortRating(k) {
	//ako k==3 silazno, inace uzlazno
      //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
      var table = $(".listingSort td");//tu su ćelije tablice s hotelima
      var oldList = $('.listingSort');
      var j = 0;
      function Hotel(grad, ime, udaljenost, rating, id) {
        this.ime = ime;
        this.grad = grad;
        this.udaljenost = udaljenost;
        this.rating = rating;
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
var j = 0;
      for(var i = 0; i < oldList.length; i++){//broj hotela
	console.log("ime = " + $(".listingSort td").eq(5*i + 1).html());
        arrHotels[i] = new Hotel($(".listingSort td").eq(5*i).html(), $(".listingSort td").eq(5*i + 1).html(), $(".listingSort td").eq(5*i + 2).html(), $(".listingSort td").eq(5*i + 3).html(), $(".listingSort button").eq(j++).attr('id'));
        arrRating[i] = $(".listingSort td").eq(5*i + 3).html();//rating
      }

      if(k === 3){
        arrHotels.sort(usporediRating2);
      }else {
        arrHotels.sort(usporediRating1);
      }
      console.log("here");
	var n = arrHotels.length;
console.log("n = " + n);
      oldList.remove();
      for(var i = 0; i < n; i++){
console.log("why");
console.log(arrHotels[i].ime);
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
              '<td class="hotel">' +
                '<button type="submit" name="button" value="' + arrHotels[i].id + '">' +
                  'See availability</button>' +
              '</td>' +
            '</tr>' +
          '</table>' +
          '<br>');
      }
  }
});
