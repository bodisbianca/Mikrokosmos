function openNav() {
  document.getElementById("meniu-vert").style.width = "350px";
}
function closeNav() {
  document.getElementById("meniu-vert").style.width = "0%";
}


function selectImagine(imagine)
{
  var imagArray, i;
  imagArray = document.getElementsByClassName("img-sec");
  for (i = 0; i < imagArray.length; i++)
  {
    if(imagArray[i].style.opacity == "1")
      imagArray[i].style.opacity=".6";
  }

  var mainImagine = document.getElementById("mainImg");
  mainImagine.src = imagine.src;
  imagine.style.opacity="1";
}


function clearSeats ()
{
  var selectedSeats= document.getElementsByName("seat[]");
  for(var i = 0; i < selectedSeats.length; i++)
  {
    if(selectedSeats[i].checked == true)
      { selectedSeats[i].checked=false; }
  }
}
