function onClick(id) {
    if(window.confirm("예약 주문을 완료 처리하시겠습니까?")) {
        getDeleteReserve(id);
    }
}

async function getDeleteReserve(id) {
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
        alert("예약 주문이 완료 처리되었습니다.");
        location.href="./adreserve.html";
    } else {
        throw Error(data);
    }   
}