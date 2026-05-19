(function ($) {
  if(window.innerWidth < 767.98){
      $('#sidebar').addClass('active');
  }
  $(window).resize(function(){   
      if(window.innerWidth < 767.98){
          $('#sidebar').addClass('active');
      }
  });
  $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
      $('#sidebarCollapse').toggleClass('mobile-collapse');
  });
})(jQuery);


$(window).resize(function(){

if(window.innerWidth < 991.98){
    $('#sidebar').addClass('active');
}


});
$(document).ready(function() {

    if(window.innerWidth < 991.98){
        $('#sidebar').addClass('active');
    }
   
       
    });

    var valueHover = 0;
    function calcSliderPos(e,maxV) {
            return (e.offsetX / e.target.clientWidth) *  parseInt(maxV,10);
        }
        
    $(".starrate").on("click",function(){
        $(this).data('val',valueHover);
        $(this).addClass('saved')
        });
        
    $(".starrate").on("mouseout",function(){
        upStars($(this).data('val'));
        });	

        
    $(".starrate span.ctrl").on("mousemove",function(e) { 
        var maxV = parseInt($(this).parent("div").data('max'))
        valueHover = Math.ceil(calcSliderPos(e,maxV)*2)/2;
        upStars(valueHover);
        });


function upStars(val) {

var val = parseFloat(val);
$("#test").html( val.toFixed(1) );

var full = Number.isInteger(val);
val = parseInt(val);
var stars = $("#starrate i");

stars.slice(0,val).attr("class" , "fas fa-fw fa-star" );
if(!full)  { stars.slice(val,val+1).attr("class" , "fas fa-fw fa-star-half-alt" ); val++ }
stars.slice(val,5).attr("class" , "far fa-fw fa-star" );




}	

        
        $(document).ready(function() {
        $(".starrate span.ctrl").width($(".starrate span.cont").width());
        $(".starrate span.ctrl").height($(".starrate span.cont").height());
        });

