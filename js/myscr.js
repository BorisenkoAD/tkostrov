	jQuery(document).ready(function() {
		
		var defaults = {
		containerID: 'toTop', // fading element id
		containerHoverID: 'toTopHover', // fading element hover id
		scrollSpeed: 1200,
		easingType: 'linear'
		};
		
		 
		jQuery().UItoTop({ easingType: 'easeOutQuart' });
		 
		});
	
	//equalheight - одинаковая высота колонок
		  var k = jQuery.noConflict();
	  function equalHeight(group) {
		var tallest = 0;
		group.each(function() {
		  thisHeight = k(this).height();
		  if(thisHeight > tallest) {
			tallest = thisHeight;
		  }
		});
		group.height(tallest);
	  }        
	  k(document).ready(function(){
		equalHeight(k(".equalheight"));
	  });
	    //  плавная прокрутка
	     jQuery('a[href^="#"], a[href^="."]').click( function(){ // если в href начинается с # или ., то ловим клик
	    var scroll_el = jQuery(this).attr('href'); // возьмем содержимое атрибута href
        if (jQuery(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
	    jQuery('html, body').animate({ scrollTop: jQuery(scroll_el).offset().top }, 500); // анимируем скроолинг к элементу scroll_el
        }
	    return false; // выключаем стандартное действие
    });
	//Stellar - Parallax Plugin
	//Документация: https://github.com/markdalgleish/stellar.js
	//HTML: <div class="parallax" data-stellar-background-ratio="0.5"></div>
	jQuery.stellar({
		horizontalScrolling: false,
		responsive: true
	});