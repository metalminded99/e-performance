function toggle_checkbox( element, e_state ) {
	element.each(function(){
		if( e_state ){
			$(this).prop('checked', true);
		}else{
			$(this).prop('checked', false);
		}
		
	});
}