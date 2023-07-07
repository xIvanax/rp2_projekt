$(document).ready(function() {
  var choice = $('.pdecorated-label');

  for (var i = 0; i < choice.length; i++) {
    (function(index) { // Create a closure to capture the current value of `i`
      $('.pdecorated-label').eq(index).on('click', function() {

        if (choice.eq(index).css('background-color') === "rgb(221, 221, 221)"
        || choice.eq(index).css('background-color') === "rgb(242, 242, 242)") {
          choice.eq(index).css('background-color', "rgb(176, 172, 172)");
      		for(var j = 0; j < choice.length; j++){
        		if(j !== index){
              choice.eq(j).css('background-color', "rgb(242, 242, 242)");
        		}
        	}
        }else {
          choice.eq(index).css('background-color', "rgb(242, 242, 242)");
        }
      });
    })(i); // Pass the current value of `i` to the closure
  }

$('#pSort').on('click', function(){
	var choice = $('.pdecorated-label');
	for (var i = 0; i < choice.length; i++){
		if(choice.eq(i).css('background-color') === "rgb(176, 172, 172)"){
      if(choice.eq(i).attr("id") === "dl1"){//silazni sort po cijeni
				sortPPrice(1);
			}else if(choice.eq(i).attr("id") === "dl2"){
				sortPPrice(2);
			}
			if(choice.eq(i).attr("id") === "dl3"){//silazni sort po tipu
				sortType(3);
			}else if(choice.eq(i).attr("id") === "dl4"){
				sortType(4);
			}
		}
	}
  });

function sortType(k) {
	//ako k==3 silazno, inace uzlazno
      //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
      var table = $("#premiumSort td");
      var oldList = $('#premiumSort tr');
      var len = $('#premiumSort tr');
      var n = len.length; //broj redaka
      var j = 0;
      function Room(id, tip, price, fname) {
        this.tip =  tip.substring(10);
        this.price = Number(price.substring(13));
        this.id = id.substring(9);
        this.fname = id.substring(9);
      }

      function usporeditip2(a, b){
        tip1 = a.tip.toLowerCase();
        tip2 = b.tip.toLowerCase();
        return tip1 > tip2;
      }

      function usporeditip1(a, b){
        tip1 = a.tip.toLowerCase();
        tip2 = b.tip.toLowerCase();
        return tip1 < tip2;
      }

      Room.prototype = {
        constructor: Room, // treba jer {} kreira NOVI objekt
      };
      let arrRooms = new Array();
      var j = 0;
      for(var i = 0; i < n; i++){
        arrRooms[i] = new Room($("#premiumSort td").eq(4*i).html(), $("#premiumSort td").eq(4*i + 1).html(), $("#premiumSort td").eq(4*i + 2).html(), $("#premiumSort td").eq(4*i).html());
      }

      if(k === 3){
        arrRooms.sort(usporeditip2);
      }else {
        arrRooms.sort(usporeditip1);
      }

      oldList.remove();
      for(var i = 0; i < n; i++){
        $('#premiumSort').append(
              '<tr>' +
                '<td class="room">id sobe: ' + arrRooms[i].id + '</td>' +
                '<td class="room">tip sobe: ' + arrRooms[i].tip + '</td>' +
                '<td class="room">cijena sobe: ' + arrRooms[i].price + '</td>' +
                '<td class="room">' +
                  '<form class="" action="index.php?rt=hotels/removeroom" method="post">' +
                    '<input type="submit" name="' + arrRooms[i].fname + '" value="X">' +
                  '</form>' +
                '</td>' +
              '</tr>');

      }
  }

  function sortPPrice(k) {
  	//ako k==1 silazno, inace uzlazno
        //sad znam koji sort moram napraviti, ali da bi sortirala prvo moram dohvatiti listu
        var table = $("#premiumSort td");//tu su ćelije tablice sa sobama
        var oldList = $('#premiumSort tr');
        var len = $('#premiumSort tr');
        var n = len.length; //broj redaka
        var j = 0;
        function Room(id, tip, price, fname) {
          this.tip = tip.substring(10);
          this.price = Number(price.substring(13));
          this.id = id.substring(9);
          this.fname = id.substring(9);
        }

        function usporediCijenu1(a, b){
          return a.price > b.price;
        }

        function usporediCijenu2(a, b){
          return a.price < b.price;
        }

        Room.prototype = {
          constructor: Room, // treba jer {} kreira NOVI objekt
        };
        let arrRooms = new Array();
        let arrPrice = new Array();
        var j = 0;
        for(var i = 0; i < n; i++){
          arrRooms[i] = new Room($("#premiumSort td").eq(4*i).html(), $("#premiumSort td").eq(4*i + 1).html(), $("#premiumSort td").eq(4*i + 2).html(), $("#premiumSort td").eq(4*i).html());
        }

        if(k === 1){
          arrRooms.sort(usporediCijenu2);
        }else {
          arrRooms.sort(usporediCijenu1);
        }

        oldList.remove();
        for(var i = 0; i < n; i++){
          $('#premiumSort').append(
                '<tr>' +
                  '<td class="room">id sobe: ' + arrRooms[i].id + '</td>' +
                  '<td class="room">tip sobe: ' + arrRooms[i].tip + '</td>' +
                  '<td class="room">cijena sobe: ' + arrRooms[i].price + '</td>' +
                  '<td class="room">' +
                    '<form class="" action="index.php?rt=hotels/removeroom" method="post">' +
                      '<input type="submit" name="' + arrRooms[i].fname + '" value="X">' +
                    '</form>' +
                  '</td>' +
                '</tr>');
        }
    }
});
