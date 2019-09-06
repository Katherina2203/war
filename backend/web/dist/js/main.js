$(function(){
    $(document).on('click', '.language', function(){
        var lang = $(this).attr('id');
        
        $.post('index.php?r=site/language', {'lang':lang}, function(data){
            location.reload();
        });
    });
    
    $('.expanded_fields').on('click',function(e){
        e.preventDefault();
            var x = document.getElementById('toggleFields_expanded');
            if (x.style.display === 'none') {
                x.style.display = 'block';
            } else {
                x.style.display = 'none';
            }
        });
    
  //   $(document).on('click', '.fc-day', function(){
   //     var date = $(this).attr('data-date');
  //   });
    
})