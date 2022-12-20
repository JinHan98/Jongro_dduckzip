function onClick(id) {
    if(window.confirm("배송 완료하시겠습니까?")) {
        getDeleteDeliver(id);
    }
}

async function getDeleteDeliver(id) {
    const url = `http://localhost:8888/orders.php/updateManagerDeliveryStatus?orderId=${id}`;
    const options = {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    };
    const res = await fetch(url, options);
    const data = await res.json();
    if (res.ok) {
        alert("배송이 완료되었습니다.");
        location.href="./addeliver.html";
    } else {
        throw Error(data);
    }   
}