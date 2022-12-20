function inputValueChange(){
    document.getElementById('cos').innerText=String(money*(inputValue*1))
    input.style.display='visible';
}
function plus(money){
    document.getElementById('ma').innerText=String((document.getElementById('ma').innerText*1)+1);
    var temp=document.getElementById('ma').innerText;
    document.getElementById('cos').innerText=String(money*(temp*1))+'원';

}
function minus(money){
    if(document.getElementById('ma').innerText*1>1) {
        document.getElementById('ma').innerText = String((document.getElementById('ma').innerText * 1) - 1)
        var temp=document.getElementById('ma').innerText;
        document.getElementById('cos').innerText=String(money*(temp*1))+'원';
    }
}

function Confirm(){
  window.confirm("로그아웃을 하시겠습니까?");
}

function resizeApply() {
    var minWidth = 1500;
    var body = document.getElementsByTagName('body')[0];
    if (window.innerWidth < minWidth) { body.style.zoom = (window.innerWidth / minWidth); }
    else body.style.zoom = 1;
}
  
window.onload = function() {
    window.addEventListener('resize', function() {
      resizeApply();
    });
}
  
resizeApply();

function goReserve() {
  const many = document.getElementById('ma').innerText
  const cost = document.getElementById('cos').innerText.split('원')[0]
  location.href=`rcreserve.html?${id}?${many}?${cost}`;
}

function goDeliver() {
  const many = document.getElementById('ma').innerText
  const cost = document.getElementById('cos').innerText.split('원')[0]
  location.href=`rcdeliver.html?${id}?${many}?${cost}`;
}
  