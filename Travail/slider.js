let items=document.querySelectorAll('fieldset');
let nbslides=items.length;
let next=document.querySelector('.next');
let previous=document.querySelector('.prev');
let i=0;

function slidesuivant(){

  items[i].className="page";
  
  if(i<nbslides-1){
    i++;
  }
  items[i].className="pageactive";
}
next.addEventListener('click',slidesuivant)


function slideprecedent(){
  items[i].className="page";
  if(i>0){
    i--;
  }
  items[i].className="pageactive";
}
previous.addEventListener('click',slideprecedent)

