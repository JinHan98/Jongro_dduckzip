async function postStore() {
    const storeName = document.getElementById("store_name").value
    const phoneNumber = document.getElementById("phone_number").value
    const materials = document.getElementById("materials").value
    const address = document.getElementById("sample6_address").value + " " + document.getElementById("sample6_detailAddress").value


    const url = `http://localhost:8888/board.php/insertBoard`
    
    var details = {
      'Address' : address,
      'StoreName' : storeName,
      'Phone' : phoneNumber,
      'Food' : materials
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
         alert("가게 등록이 완료되었습니다..");
         location.href="./findmaterial.html";
    } else {
        throw Error(data);
    }   
  }