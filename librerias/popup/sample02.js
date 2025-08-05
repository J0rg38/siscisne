// JavaScript Document

function fireMyPopup(oCapa) {
<!-- Due to different browser naming of certain key global variables, we need to do three different tests to determine their values -->

// Determine how much the visitor had scrolled

var scrolledX, scrolledY;
if( self.pageYOffset ) {
  scrolledX = self.pageXOffset;
  scrolledY = self.pageYOffset;
} else if( document.documentElement && document.documentElement.scrollTop ) {
  scrolledX = document.documentElement.scrollLeft;
  scrolledY = document.documentElement.scrollTop;
} else if( document.body ) {
  scrolledX = document.body.scrollLeft;
  scrolledY = document.body.scrollTop;
}

// Determine the coordinates of the center of browser's window

var centerX, centerY;
if( self.innerHeight ) {
  centerX = self.innerWidth;
  centerY = self.innerHeight;
} else if( document.documentElement && document.documentElement.clientHeight ) {
  centerX = document.documentElement.clientWidth;
  centerY = document.documentElement.clientHeight;
} else if( document.body ) {
  centerX = document.body.clientWidth;
  centerY = document.body.clientHeight;
}

  var leftOffset = scrolledX + (centerX - 900) / 2;
  var topOffset = scrolledY + (centerY - 350) / 2;


  document.getElementById(oCapa).style.top = topOffset + "px";
  document.getElementById(oCapa).style.left = leftOffset + "px";
  document.getElementById(oCapa).style.display = "block";


  /*document.getElementById("mypopup").style.top = topOffset + "px";
  document.getElementById("mypopup").style.left = leftOffset + "px";
  document.getElementById("mypopup").style.display = "block";*/
}