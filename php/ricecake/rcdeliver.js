const id = location.href.split('?')[1];
const order_many = location.href.split('?')[2];
const cost = location.href.split('?')[3];

async function postDeliver() {
    var today = new Date();

    var year = today.getFullYear();
    var month = ('0' + (today.getMonth() + 1)).slice(-2);
    var day = ('0' + today.getDate()).slice(-2);

    var dateString = year + '-' + month  + '-' + day;

    var hours = ('0' + today.getHours()).slice(-2); 
    var minutes = ('0' + today.getMinutes()).slice(-2);
    var seconds = ('0' + today.getSeconds()).slice(-2); 

    var timeString = hours + ':' + minutes  + ':' + seconds;

    const dateTime = dateString + " " + timeString

    console.log(dateTime);

    const address = document.getElementById("sample6_address").value + " " + document.getElementById("sample6_detailAddress").value


    const url = `http://localhost:8888/orders.php/insertDelivery`
    
    var details = {
      'customer_id' : 1,
      'product_id' : id,
      'Order_many' : order_many,
      'Order_datetime' : dateTime,
      'address' : address,
      'Order_number' : 1,
      'Order_price' : cost
    }

    var formBody = [];
    for (var property in details) {    
          var encodedKey = encodeURIComponent(property);
          var encodedValue = encodeURIComponent(details[property]);
          formBody.push(encodedKey + "=" + encodedValue);
    }
    formBody = formBody.join("&");

    const options = {
          method: 'POST', // *GET, POST, PUT, DELETE 등
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: formBody
    }
    let res = await fetch(url, options);
    let data = await res.json();

    if (res.ok) {
         console.log(data);
         alert("배송 신청 완료되었습니다.");
         location.href="./main.html";
    } else {
        throw Error(data);
    }   
  }